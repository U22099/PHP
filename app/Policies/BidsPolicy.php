<?php

namespace App\Policies;

use App\Models\Bids;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class BidsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bids $bid): bool
    {
        return $bid->user->is($user) || ($bid->job && $bid->job->user->is($user));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'freelancer';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bids $bid): bool
    {
        return $user->role === 'freelancer' && $bid->user->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bids $bid): bool
    {
        return $bid->user->is($user) || ($bid->job && $bid->job->user->is($user));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bids $bid): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bids $bid): bool
    {
        return false;
    }

    public function updateStatus(User $user, Bids $bid): bool
    {
        return $bid->job && $bid->job->user->is($user);
    }
}
