<?php

namespace App\Models;

use App\Models\Stacks;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Projects extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'title',
        'link',
        'description',
        'images',
    ];

    protected $casts = ['images' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stacks(): BelongsToMany
    {
        return $this->belongsToMany(Stacks::class);
    }
}
