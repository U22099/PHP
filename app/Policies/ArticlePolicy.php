<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ArticlePolicy
{
    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Article $article): bool
    {
        return $user->is($article->user);
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->is($article->user);
    }

    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }
}
