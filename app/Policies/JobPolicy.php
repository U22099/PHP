<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Job $job): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return $user->role == 'client' && (!$user->is_premium && $user->number_of_jobs_created_today <= env('JOBS_LIMIT_PER_DAY'));
    }

    public function update(User $user, Job $job): bool
    {
        return $user->is($job->user);
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->is($job->user);
    }

    public function restore(User $user, Job $job): bool
    {
        return false;
    }

    public function forceDelete(User $user, Job $job): bool
    {
        return false;
    }

    public function massRejectBids(User $user, Job $job): bool
    {
        return $job->user->is($user);
    }
}
