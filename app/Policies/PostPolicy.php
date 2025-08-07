<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Post $post): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check() && (!$user->is_premium && $user->number_of_posts_created_today <= env('POSTS_LIMIT_PER_DAY'));
    }

    public function update(User $user, Post $post): bool
    {
        return $user->is($post->user);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->is($post->user);
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
