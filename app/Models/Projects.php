<?php

namespace App\Models;

use App\Models\Stacks;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stacks()
    {
        return $this->belongsToMany(Stacks::class);
    }
}
