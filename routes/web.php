<?php

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

Route::get('/jobs', function () {
    return view('jobs.index', [
        'jobs' => Job::with('employer', 'tags')->latest()->simplePaginate()
    ]);
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'description' => request('description'),
        'employer_id' => rand(1, 5)
    ]);

    return redirect('/jobs');
});

Route::get('/job/{id}', function ($id) {
    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});

Route::get('/posts', function () {
    return view('posts.index', [
        'posts' => Post::with('user', 'tags')->latest()->simplePaginate(10)
    ]);
});

Route::get('/post/{id}', function ($id) {
    $post = Post::find($id);
    return view('posts.show', ['post' => $post]);
});
