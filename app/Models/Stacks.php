<?php

namespace App\Models;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stacks extends Model
{
    /** @use HasFactory<\Database\Factories\StacksFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->belongsToMany(Projects::class);
    }
}
