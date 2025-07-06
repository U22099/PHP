<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    /** @use HasFactory<\Database\Factories\TagsFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, relatedPivotKey: 'job_listing_id');
    }
}
