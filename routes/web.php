<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Models\Article;
use App\Models\Comments;
use App\Models\Job;
use App\Models\Post;
use App\Models\Projects;
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
Route::get('/register/verify', [RegisterUserController::class, 'verify'])->name('auth.verify');
Route::post('/register/verify', [RegisterUserController::class, 'verifyOtp'])->name('auth.register.verify');
Route::post('/register/verify/{user}', [RegisterUserController::class, 'sendVerificationCode'])->name('auth.verify.resend');
Route::post('/register', [RegisterUserController::class, 'store']);

// Jobs Route
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])
        ->name('jobs.create')
        ->can('create', Job::class);

    Route::get('/jobs/{job}', [JobController::class, 'show'])
        ->name('jobs.show');

    Route::post('/jobs', [JobController::class, 'store'])
        ->name('jobs.store')
        ->can('create', Job::class);

    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
        ->name('jobs.edit')
        ->can('update', 'job');

    Route::patch('/jobs/{job}', [JobController::class, 'update'])
        ->name('jobs.update')
        ->can('update', 'job');

    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
        ->name('jobs.destroy')
        ->can('delete', 'job');
});

// Articles Route
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create')
        ->can('create', Article::class);

    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store')
        ->can('create', Article::class);

    Route::get('/articles/{article}', [ArticleController::class, 'show'])
        ->name('articles.show');

    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit')
        ->can('update', 'article');

    Route::patch('/articles/{article}', [ArticleController::class, 'update'])
        ->name('articles.update')
        ->can('update', 'article');

    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy')
        ->can('delete', 'article');
});
// Posts Route
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create')
        ->can('create', Post::class);

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store')
        ->can('create', Post::class);

    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit')
        ->can('update', 'post');

    Route::patch('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update')
        ->can('update', 'post');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // Comments
    Route::post('/comments/{post}', [CommentsController::class, 'store'])
        ->name('comments.store')
        ->can('create', Comments::class);
});

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects/create', [ProjectsController::class, 'create'])
        ->name('projects.create')
        ->can('create', Projects::class);

    Route::post('/projects', [ProjectsController::class, 'store'])
        ->name('projects.store')
        ->can('create', Projects::class);

    Route::get('/projects/{project}', [ProjectsController::class, 'show'])
        ->name('projects.show');

    Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])
        ->name('projects.edit')
        ->can('update', 'project');

    Route::patch('/projects/{project}', [ProjectsController::class, 'update'])
        ->name('projects.update')
        ->can('update', 'project');

    Route::delete('/projects/{project}', [ProjectsController::class, 'destroy'])
        ->name('projects.destroy');
});
