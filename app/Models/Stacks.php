<?php

namespace App\Models;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stacks extends Model
{
    /** @use HasFactory<\Database\Factories\StacksFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Projects::class);
    }
}
