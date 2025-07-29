<?php

namespace App\Models;

use App\Models\Bids;
use App\Models\Currency;
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
        'user_id',
        'title',
        'min_budget',
        'max_budget',
        'time_budget',
        'currency_id',
        'description',
        'screenshots'
    ];

    protected $casts = ['screenshots' => 'array'];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bids::class, foreignKey: 'job_listing_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, foreignPivotKey: 'job_listing_id');
    }
}
