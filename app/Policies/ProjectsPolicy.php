<?php

namespace App\Policies;

use App\Models\Projects;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProjectsPolicy
{
    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }

    public function delete(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }

    public function restore(User $user, Projects $article): bool
    {
        return false;
    }

    public function forceDelete(User $user, Projects $article): bool
    {
        return false;
    }
}
