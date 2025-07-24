<?php

namespace App\Policies;

use App\Models\Projects;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProjectsPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Projects $article): bool
    {
        return $user->is($article->user);
    }
}
