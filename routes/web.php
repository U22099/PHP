<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\JobController;
use App\Models\Job;
use App\Models\Post;
use illuminate\Support\Arr;


Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::resource('jobs', JobController::class);

Route::resource('articles', ArticleController::class);
