<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    public function create(User $user): bool
    {
        return !Auth::check();
    }

    public function update(User $user, User $model): bool
    {
        return $user->is($model) && $user->email === $model->email;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->is($model);
    }

    public function uploadImage(User $user): bool
    {
        return $user->number_of_images_uploaded_today <= ($user->is_premium ? env('IMAGE_UPLOAD_LIMIT_PER_USER_PREMIUM') : env('IMAGE_UPLOAD_LIMIT_PER_USER'));
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
