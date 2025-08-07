<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use \App\Models\FreelancerDetails;
use App\Models\Article;
use App\Models\Bids;
use App\Models\Job;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Projects;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['number_of_jobs_created_today', 'number_of_articles_created_today', 'number_of_posts_created_today', 'number_of_bids_created_today'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Projects::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bids::class);
    }

    public function freelancer_details(): HasOne
    {
        return $this->hasOne(FreelancerDetails::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function getNumberOfJobsCreatedTodayAttribute(): int
    {
        return $this->jobs()->where('created_at', '>=', Carbon::now()->startOfDay())->count();
    }

    public function getNumberOfArticlesCreatedTodayAttribute(): int
    {
        return $this->articles()->where('created_at', '>=', Carbon::now()->startOfDay())->count();
    }

    public function getNumberOfPostsCreatedTodayAttribute(): int
    {
        return $this->posts()->where('created_at', '>=', Carbon::now()->startOfDay())->count();
    }

    public function getNumberOfBidsCreatedTodayAttribute(): int
    {
        return $this->bids()->where('created_at', '>=', Carbon::now()->startOfDay())->count();
    }
}
