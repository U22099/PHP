<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    /** @use HasFactory<\Database\Factories\EmployerFactory> */
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, relatedPivotKey: 'job_listing_id');
    }
}
