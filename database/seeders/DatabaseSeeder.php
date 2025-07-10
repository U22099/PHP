<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Employer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Job;
use App\Models\Post;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        Employer::factory()->count(5)->create();
        Tags::factory()->count(20)->create();

        Post::factory()->count(50)->create();

        Article::factory()->count(50)->create()->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });

        Job::factory()->count(30)->create()->each(function ($job) {
            $tags = Tags::all()->random(rand(1, 3));
            $job->tags()->attach($tags);
        });
    }
}
