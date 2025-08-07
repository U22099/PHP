<?php

namespace App\Policies;

use App\Models\Bids;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class BidsPolicy
{
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Bids $bid, Job $job): bool
    {
        return $bid->user->is($user) || ($bid->job_listing_id === $job->id && $job->user->is($user));
    }

    public function create(User $user): bool
    {
        return ($user->role === 'freelancer') && (!$user->is_premium && $user->number_of_bids_created_today <= env('BIDS_LIMIT_PER_DAY'));
    }

    public function update(User $user, Bids $bid): bool
    {
        return $user->role === 'freelancer' && $bid->user->is($user);
    }

    public function delete(User $user, Bids $bid, Job $job): bool
    {
        return $user->role === 'freelancer' && $bid->user->is($user);
    }

    public function restore(User $user, Bids $bid): bool
    {
        return false;
    }

    public function forceDelete(User $user, Bids $bid): bool
    {
        return false;
    }

    public function updateStatus(User $user, Bids $bid, Job $job): bool
    {
        return $bid->job_listing_id === $job->id && $job->user->is($user);
    }
}
