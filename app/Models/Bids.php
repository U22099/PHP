<?php

namespace App\Models;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_listing_id',
        'user_id',
        'bid_amount',
        'bid_message',
        'bid_time_budget',
        'status'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, $foreignKey = 'job_listing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
