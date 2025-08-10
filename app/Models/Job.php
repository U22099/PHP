<?php

namespace App\Models;

use App\Models\Bids;
use App\Models\Currency;
use App\Models\Employer;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'images',
        'publicIds'
    ];

    protected $casts = ['images' => 'array', 'publicIds' => 'array'];

    protected $withCount = ['bids'];

    protected $appends = ['average_bid_amount'];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bids::class, foreignKey: 'job_listing_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class, foreignPivotKey: 'job_listing_id');
    }

    public function getAverageBidAmountAttribute(): float
    {
        $average = $this->bids()->avg('bid_amount') ?? 0;
        return ceil($average);
    }
}
