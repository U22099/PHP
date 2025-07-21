<?php

namespace App\Models;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'body'
    ];

    protected $casts = ['images' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    public function getCanUpdateAttribute(): bool
    {
        return auth()->check() ? auth()->user()->can('update', $this) : false;
    }
}
