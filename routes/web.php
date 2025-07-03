<?php

use App\Models\Job;
use illuminate\Support\Arr;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/jobs', function () {
    return view('jobs', [
        'jobs' => Job::all()
    ]);
});

Route::get('/job/{id}', function ($id) {
    $job = Job::find($id);

    return view('job', ['job' => $job]);
});
