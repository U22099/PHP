<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tags;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show_user($username)
    {
        $user = User::where('username', $username)->firstOrFail()->load([
            'projects' => fn($q) => $q->latest(),
            'posts' => fn($q) => $q->latest(),
            'articles' => fn($q) => $q->latest(),
            'jobs' => fn($q) => $q->latest()->with('currency'),
        ]);

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

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);

            $user->fill($validatedData);

            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');

                if ($user->image_public_id) {
                    Cloudinary::delete($user->image_public_id);
                }
                $uploadedImage = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'bidmax'
                ]);
                $user->image = $uploadedImage->getSecurePath();
                $user->image_public_id = $uploadedImage->getPublicId();
            }

            $user->save();

            return back()->with('success', 'Profile updated successfully!');
        } catch (ValidationException $e) {
            return redirect('/profile?error=profile-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
