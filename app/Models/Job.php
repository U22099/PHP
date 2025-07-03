<?php

namespace App\Models;

use Illuminate\Support\Arr;

class Job
{
    public static function all(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Teacher',
                'salary' => '£89200',
            ],
            [
                'id' => 2,
                'name' => 'Programmer',
                'salary' => '£1400000',
            ],
            [
                'id' => 3,
                'name' => 'Engineer',
                'salary' => '£880000',
            ]
        ];
    }

    public static function find(int $id): array
    {
        $job = Arr::first(static::all(), fn($job) => $job['id'] == $id);
        if (!$job) {
            abort(404);
        }
        return $job;
    }
}
