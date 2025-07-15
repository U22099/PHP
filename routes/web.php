<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Models\Article;
use App\Models\Comments;
use App\Models\Job;
use App\Models\Post;
use illuminate\Support\Arr;


Route::get('/', function () {
    return view('homepage');
});
Route::get('/contact', function () {
    return view('contact');
});

// Auth Route
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

// Jobs Route
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

Route::get('/jobs/create', [JobController::class, 'create'])
    ->name('jobs.create')
    ->middleware('auth')
    ->can('create', Job::class);

Route::get('/jobs/{job}', [JobController::class, 'show'])
    ->name('jobs.show')
    ->middleware('auth');

Route::post('/jobs', [JobController::class, 'store'])
    ->name('jobs.store')
    ->middleware('auth')
    ->can('create', Job::class);

Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->name('jobs.edit')
    ->middleware('auth')
    ->can('update', 'job');

Route::patch('/jobs/{job}', [JobController::class, 'update'])
    ->name('jobs.update')
    ->middleware('auth')
    ->can('update', 'job');

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->name('jobs.destroy')
    ->middleware('auth')
    ->can('delete', 'job');

// Articles Route
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/articles/create', [ArticleController::class, 'create'])
    ->name('articles.create')
    ->middleware('auth')
    ->can('create', Article::class);

Route::post('/articles', [ArticleController::class, 'store'])
    ->name('articles.store')
    ->middleware('auth')
    ->can('create', Article::class);

Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
    ->name('articles.edit')
    ->middleware('auth')
    ->can('update', 'article');

Route::patch('/articles/{article}', [ArticleController::class, 'update'])
    ->name('articles.update')
    ->middleware('auth')
    ->can('update', 'article');

Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
    ->name('articles.destroy')
    ->middleware('auth')
    ->can('delete', 'article');

// Posts Route
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create')
    ->middleware('auth')
    ->can('create', Post::class);

Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store')
    ->middleware('auth')
    ->can('create', Post::class);

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit')
    ->middleware('auth')
    ->can('update', 'post');

Route::patch('/posts/{post}', [PostController::class, 'update'])
    ->name('posts.update')
    ->middleware('auth')
    ->can('update', 'post');

Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->name('posts.destroy')
    ->middleware('auth');

// Comments
Route::post('/comments/{post}', [CommentsController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth')
    ->can('create', Comments::class);