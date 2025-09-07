<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Images;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function show_user(String $username)
    {
        $user = User::where('username', $username)->firstOrFail()->load([
            'projects' => fn($q) => $q->latest(),
            'posts' => fn($q) => $q->latest(),
            'articles' => fn($q) => $q->latest(),
            'jobs' => fn($q) => $q->latest()->with('currency'),
        ]);

        if (!Auth::user()->can('viewUser', $user)) {
            abort(403, 'You are not authorized to view this user profile.');
        }

        return view('profile.show', [...compact('user')]);
    }

    public function show()
    {
        $user = Auth::user()->load([
            'projects' => fn($q) => $q->latest(),
            'posts' => fn($q) => $q->latest(),
            'articles' => fn($q) => $q->latest(),
            'jobs' => fn($q) => $q->latest()->with('currency'),
            'bids' => fn($q) => $q->latest()->with('job.currency'),
        ]);

        return view('profile.show', [...compact('user')]);
    }

    public function updateJobAlerts(Request $request)
    {
        try {
            $request->validate([
                'is_checked' => 'boolean'
            ]);

            $user = Auth::user();
            $user->job_alerts = $request->input('is_checked');
            $user->save();

            return response()->json([
                'job_alert' => $user->job_alerts,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
            ]);
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        if (!Auth::user()->can('uploadImage')) {
            throw ValidationException::withMessages(['image' => 'You have reached your image upload limit.']);
        }

        $user = Auth::user();
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', $user->is_premium ? 'max:4096' : 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        try {
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();
            $user->fill($validatedData);

            if ($request->hasFile('image')) {
                if ($user->image_public_id) {
                    $deleted = Storage::disk('cloudinary')->delete($user->image_public_id);
                    if ($deleted) {
                        $user->images()->where('public_id', $user->image_public_id)->delete();
                    }
                }
                $path = $request->file('image')->store('bidmax', 'cloudinary');

                $user->image_public_id = $path;
                $url = Storage::disk('cloudinary')->url($path);
                $user->image = $url;

                Images::create([
                    'user_id' => $user->id,
                    'image_url' => $url,
                    'public_id' => $path
                ]);
            }

            $user->save();

            return back()->with('success', 'Profile updated successfully!');
        } catch (ValidationException $e) {
            return redirect('/profile')
                ->with('error', 'profile-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
