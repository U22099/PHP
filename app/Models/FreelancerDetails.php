<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FreelancerDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_name',
        'professional_summary',
        'country',
        'city',
        'phone_number',
        'skills',
        'portfolio_link',
        'years_of_experience',
        'education',
        'certifications',
        'languages',
        'availability',
        'response_time',
        'linkedin_profile',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stacks(): BelongsToMany
    {
        return $this->belongsToMany(Stacks::class);
    }
}
