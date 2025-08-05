<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentsPolicy
{
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Comments $comments): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Comments $comments): bool
    {
        return Auth::check() && $comments->user->is($user);
    }

    public function delete(User $user, Comments $comments): bool
    {
        return Auth::check() && $comments->user->is($user);
    }

    public function restore(User $user, Comments $comments): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comments $comments): bool
    {
        return false;
    }
}
