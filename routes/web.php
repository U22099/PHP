<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Models\Job;
use App\Models\Post;
use illuminate\Support\Arr;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

Route::get('/jobs/create', [JobController::class, 'create'])
    ->name('jobs.create')
    ->middleware('auth')
    ->can('create');

Route::get('/jobs/{job}', [JobController::class, 'show'])
    ->name('jobs.show')
    ->middleware('auth');

Route::post('/jobs', [JobController::class, 'store'])
    ->name('jobs.store')
    ->middleware('auth')
    ->can('create');

Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->name('jobs.edit')
    ->middleware('auth')
    ->can('edit', 'job');

Route::patch('/jobs/{job}', [JobController::class, 'update'])
    ->name('jobs.update')
    ->middleware('auth')
    ->can('update', 'job');

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->name('jobs.destroy')
    ->middleware('auth')
    ->can('destroy', 'job');

Route::resource('articles', ArticleController::class);
