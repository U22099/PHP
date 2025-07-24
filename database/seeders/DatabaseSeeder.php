<?php

namespace Database\Seeders;

use App\Models\Article;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comments;
use App\Models\Job;
use App\Models\Post;
use App\Models\Projects;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        Tags::factory()->count(20)->create();

        Post::factory()->count(50)->create()->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create()->each(function ($comment) use ($post) {
                $comment->post_id = $post->id;
            });
            $tags = Tags::all()->random(rand(1, 5));
            $post->tags()->attach($tags);
        });

        Article::factory()->count(50)->create()->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });

        $clientUsers = User::where('role', 'client')->get();
        if ($clientUsers->isNotEmpty()) {
            foreach ($clientUsers as $client) {
                Job::factory()->count(rand(1, 5))->create([
                    'user_id' => $client->id
                ])->each(function ($job) {
                    $tags = Tags::all()->random(rand(1, 3));
                    $job->tags()->attach($tags);
                });
            }
        }

        $testFreelancer = User::create([
            'firstname' => 'Daniel',
            'lastname' => 'Olaniyi',
            'username' => 'u22099',
            'email' => 'nifemiolaniyi4@gmail.com',
            'image' => 'https://i.pravatar.cc/300?img=' . rand(1, 100),
            'role' => 'freelancer',
            'email_verified_at' => now(),
            'password' => Hash::make('helloworld'),
            'remember_token' => Str::random(10),
        ]);

        $testClient = User::create([
            'firstname' => 'Client',
            'lastname' => 'Olaniyi',
            'username' => 'mr.jobber',
            'email' => 'u22099dandev4@gmail.com',
            'image' => 'https://i.pravatar.cc/300?img=' . rand(1, 100),
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => Hash::make('helloworld'),
            'remember_token' => Str::random(10),
        ]);

        Post::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id
        ])->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create()->each(function ($comment) use ($post) {
                $comment->post_id = $post->id;
            });
        });

        Article::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id
        ])->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });

        Projects::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id,
            'link' => rand(0, 1) ? 'https://dan22099.vercel.app' : 'https://u22099.github.io/Portfolio2',
        ]);

        Post::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id
        ])->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create()->each(function ($comment) use ($post) {
                $comment->post_id = $post->id;
            });
            $tags = Tags::all()->random(rand(1, 20));
            $post->tags()->attach($tags);
        });

        Article::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id
        ])->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });

        Job::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id
        ])->each(function ($job) {
            $tags = Tags::all()->random(rand(1, 3));
            $job->tags()->attach($tags);
        });
    }
}
