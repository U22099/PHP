<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use AppModelsUser;
use IlluminateAuthAccessResponse;
use IlluminateSupportFacadesAuth;

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

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
