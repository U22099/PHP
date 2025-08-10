<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Images extends Model
{
    protected $fillable = [
        'user_id',
        'image_url',
        'public_id',
        'uploaded_at'
    ];

    protected static function booted()
    {
        static::deleting(function ($image) {
            Storage::disk('cloudinary')->delete($image->public_id);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
