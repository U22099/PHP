<?php

use illuminate\Support\Arr;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/jobs', function () {
    return view('jobs', [
        'jobs' => [
            [
                'id' => '1',
                'name' => 'Teacher',
                'salary' => '£89200',
            ],
            [
                'id' => '2',
                'name' => 'Programmer',
                'salary' => '£1400000',
            ],
            [
                'id' => '3',
                'name' => 'Engineer',
                'salary' => '£880000',
            ],
        ]
    ]);
});

Route::get('/job/{id}', function ($id) {
    $jobs = [
        [
            'id' => '1',
            'name' => 'Teacher',
            'salary' => '£89200',
        ],
        [
            'id' => '2',
            'name' => 'Programmer',
            'salary' => '£1400000',
        ],
        [
            'id' => '3',
            'name' => 'Engineer',
            'salary' => '£880000',
        ],
    ];
    $job = Arr::first($jobs, fn($job) => $job['id'] == $id);

    return view('job', ["job" => $job]);
});
