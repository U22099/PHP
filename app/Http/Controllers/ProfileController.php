<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tags;
use App\Models\User;
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
            'jobs' => fn($q) => $q->latest(),
        ]);

        return view('profile.show', [...compact('user')]);
    }

    public function show()
    {
        $user = Auth::user()->load([
            'projects' => fn($q) => $q->latest(),
            'posts' => fn($q) => $q->latest(),
            'articles' => fn($q) => $q->latest(),
            'jobs' => fn($q) => $q->latest(),
        ]);

        $allTags = Tags::whereHas('projects')->orderBy('name')->get();

        return view('profile.show', [...compact('user'), 'availableTags' => 'allTags']);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'image' => 'nullable|image|max:2048',
            ]);

            $user->fill($validatedData);

            // Handle image upload if implemented
            // if ($request->hasFile('image')) {
            //     if ($user->image) {
            //         Storage::disk('public')->delete($user->image);
            //     }
            //     $path = $request->file('image')->store('profile_images', 'public');
            //     $user->image = $path;
            // }

            $user->save();

            return back()->with('success', 'Profile updated successfully!');
        } catch (ValidationException $e) {
            return redirect('/profile?error=profile-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
