<?php

namespace App\Models;

use App\Models\Employer;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Job extends Model
{
    protected $table = 'jobs_listing';

    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'employer_id',
        'title',
        'salary',
        'description',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, foreignPivotKey: 'job_listing_id');
    }
}
