<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use \Exception;
use \Log;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $user = Auth::user();

        if (!$user->can('uploadImage')) {
            return response()->json(['message' => 'You have reached your image upload limit.'], 403);
        }

        $maxSizeKB = $user->is_premium ? 5 * 1024 : 2 * 1024;

        $rules = [
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:' . $maxSizeKB],
        ];

        $validator = Validator::make($request->all(), $rules);

        try {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 422);
            }

            $uploadedImagesData = [];
            foreach ($request->file('images') as $image) {
                $publicId = Storage::disk('cloudinary')->putFile('bidmax', $image);

                $url = Storage::disk('cloudinary')->url($publicId);

                Images::create([
                    'user_id' => $user->id,
                    'image_url' => $url,
                    'public_id' => $publicId
                ]);

                $uploadedImagesData[] = [
                    'url' => $url,
                    'public_id' => $publicId
                ];
            }

            $updatedUser = User::find($user->id);

            $imageUploadLimit = $updatedUser->is_premium ? env('IMAGE_UPLOAD_LIMIT_PER_USER_PREMIUM') : env('IMAGE_UPLOAD_LIMIT_PER_USER');

            $remainingUploads = $imageUploadLimit - $updatedUser->number_of_images_uploaded_today;

            return response()->json([
                'message' => 'Images uploaded successfully.',
                'images' => $uploadedImagesData,
                'remaining_uploads' => $remainingUploads
            ], 200);
        } catch (Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);
            return response()->json(['message' => 'An error occurred during upload: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'public_id' => ['required', 'string'],
        ]);

        $publicId = $request->input('public_id');

        try {
            $deleted = Storage::disk('cloudinary')->delete($publicId);

            $updatedUser = User::find($user->id);

            $imageUploadLimit = $updatedUser->is_premium ? env('IMAGE_UPLOAD_LIMIT_PER_USER_PREMIUM') : env('IMAGE_UPLOAD_LIMIT_PER_USER');

            $remainingUploads = $imageUploadLimit - $updatedUser->number_of_images_uploaded_today;

            if ($deleted) {
                $user->image_uploads()->where('public_id', $publicId)->delete();
                return response()->json([
                    'message' => 'Image deleted successfully.',
                    'remaining_uploads' => $remainingUploads
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Failed to delete image or image not found on Cloudinary. It might have already been deleted.',
                    'remaining_uploads' => $remainingUploads
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('Image deletion error: ' . $e->getMessage(), ['exception' => $e, 'public_id' => $publicId]);
            return response()->json(['message' => 'An error occurred during deletion: ' . $e->getMessage()], 500);
        }
    }
}
