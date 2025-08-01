<?php

namespace App\Models;

use App\Models\Comments;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'body'
    ];

    protected $casts = ['images' => 'array'];

    protected $withCount = ['comments', 'likes'];

    protected $appends = ['can_update', 'liked_by_user'];


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

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function getCanUpdateAttribute(): bool
    {
        return Auth::check() && Auth::user()->can('update', $this);
    }

    public function getLikedByUserAttribute(): bool
    {
        return Auth::check() ? $this->likes()->where('user_id', Auth::id())->exists() : false;
    }
}
