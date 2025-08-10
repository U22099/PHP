<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Bids;
use App\Models\Comments;
use App\Models\Currency;
use App\Models\FreelancerDetails;
use App\Models\Images;
use App\Models\Job;
use App\Models\Post;
use App\Models\Projects;
use App\Models\Stacks;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('✨ Starting Database Seeding Process ✨');
        $this->command->info('-----------------------------------------');

        // --- Image Cleanup Section ---
        $this->command->comment('Cleaning up previous images from Cloudinary and database...');
        $publicIdsToDelete = Images::pluck('public_id')->toArray();

        if (empty($publicIdsToDelete)) {
            $this->command->line('No previous image records found in the database. Skipping Cloudinary deletion.');
        } else {
            $this->command->line('Found ' . count($publicIdsToDelete) . ' images to delete from Cloudinary.');
            try {
                // Delete from Cloudinary in bulk
                Storage::disk('cloudinary')->delete($publicIdsToDelete);
                $this->command->info('Successfully initiated deletion of images on Cloudinary.');
            } catch (\Exception $e) {
                $this->command->error('Failed to delete images from Cloudinary: ' . $e->getMessage());
                $this->command->warn('This might indicate API credential issues or network problems. Local database will still be truncated.');
            }
        }
        DB::table('images')->truncate(); 
        $this->command->info('Images table truncated locally.');
        $this->command->info('-----------------------------------------');


        // --- User Creation ---
        $this->command->comment('👩‍💻 Creating 10 random users (Clients & Freelancers)...');
        User::factory()->count(10)->create()->each(function ($user) {
            if ($user->role === 'freelancer') {
                FreelancerDetails::factory()->create([
                    'user_id' => $user->id
                ]);
                $this->command->line("   -> Created freelancer: <fg=cyan>{$user->username}</>");
            } else {
                $this->command->line("   -> Created client: <fg=blue>{$user->username}</>");
            }
        });
        $this->command->info('✅ Random users created successfully.');
        $this->command->info('-----------------------------------------');


        // --- Tags & Stacks Creation ---
        $this->command->comment('🏷️ Creating 20 random Tags...');
        Tags::factory()->count(20)->create();
        $this->command->info('✅ Tags created.');

        $this->command->comment('📚 Creating 20 random Stacks...');
        Stacks::factory()->count(20)->create();
        $this->command->info('✅ Stacks created.');
        $this->command->info('-----------------------------------------');


        // --- Currency Creation ---
        $this->command->comment('💰 Creating 20 random Currencies...');
        Currency::factory()->count(20)->create();
        $this->command->info('✅ Currencies created.');
        $this->command->info('-----------------------------------------');


        // --- Post Creation ---
        $this->command->comment('📝 Creating 50 random Posts with Comments and Tags...');
        Post::factory()->count(50)->create()->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create([
                'post_id' => $post->id, // Assign post_id directly here
            ]);
            $tags = Tags::all()->random(rand(1, 5));
            $post->tags()->attach($tags);
        });
        $this->command->info('✅ Random Posts, Comments, and Tags created.');
        $this->command->info('-----------------------------------------');


        // --- Article Creation ---
        $this->command->comment('✍️ Creating 50 random Articles with Tags...');
        Article::factory()->count(50)->create()->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });
        $this->command->info('✅ Random Articles and Tags created.');
        $this->command->info('-----------------------------------------');


        // --- Job Creation for Client Users ---
        $this->command->comment('💼 Creating Jobs for random Client users...');
        $clientUsers = User::where('role', 'client')->get();
        if ($clientUsers->isNotEmpty()) {
            foreach ($clientUsers as $client) {
                $jobsCreated = rand(1, 5);
                Job::factory()->count($jobsCreated)->create([
                    'user_id' => $client->id,
                    'currency_id' => Currency::find(rand(1, 20))->id,
                ])->each(function ($job) {
                    $tags = Stacks::all()->random(rand(1, 3));
                    $job->tags()->attach($tags);
                });
                $this->command->line("   -> Client <fg=blue>{$client->username}</> created <fg=yellow>{$jobsCreated}</> jobs.");
            }
        } else {
            $this->command->warn('No client users found to create jobs for!');
        }
        $this->command->info('✅ Jobs for client users created and tagged.');
        $this->command->info('-----------------------------------------');


        // --- Creating Specific Test Users ---
        $this->command->comment('👤 Creating specific test users...');
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
        $this->command->info('   -> Test Freelancer <fg=cyan>u22099</> created.');

        FreelancerDetails::factory()->create([
            'user_id' => $testFreelancer->id
        ]);
        $this->command->line('   -> Test Freelancer details added.');

        $testClient = User::create([
            'firstname' => 'Client',
            'lastname' => 'Olaniyi',
            'username' => 'mr.jobber',
            'email' => 'u22099dandev@gmail.com',
            'image' => 'https://i.pravatar.cc/300?img=' . rand(1, 100),
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => Hash::make('helloworld'),
            'remember_token' => Str::random(10),
        ]);
        $this->command->info('   -> Test Client <fg=blue>mr.jobber</> created.');
        $this->command->info('✅ Specific test users created.');
        $this->command->info('-----------------------------------------');


        // --- Data for Test Freelancer ---
        $this->command->comment("🛠️ Populating data for test freelancer <fg=cyan>u22099</>...");
        Post::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id
        ])->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create([
                'post_id' => $post->id,
            ]);
            $tags = Tags::all()->random(rand(1, 20)); // Tags for these posts as well
            $post->tags()->attach($tags);
        });
        $this->command->line('   -> Posts and Comments created for test freelancer.');

        Article::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id
        ])->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });
        $this->command->line('   -> Articles and Tags created for test freelancer.');

        Projects::factory()->count(rand(1, 5))->create([
            'user_id' => $testFreelancer->id,
            'link' => rand(0, 1) ? 'https://dan22099.vercel.app' : 'https://u22099.github.io/Portfolio2',
        ])->each(function ($project) {
            $stacks = Stacks::all()->random(rand(1, 8));
            $project->stacks()->attach($stacks);
        });
        $this->command->line('   -> Projects and Stacks created for test freelancer.');
        $this->command->info('✅ Test freelancer data populated.');
        $this->command->info('-----------------------------------------');


        // --- Data for Test Client ---
        $this->command->comment("🛒 Populating data for test client <fg=blue>mr.jobber</>...");
        Post::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id
        ])->each(function ($post) {
            Comments::factory()->count(rand(5, 10))->create([
                'post_id' => $post->id,
            ]);
            $tags = Tags::all()->random(rand(1, 20));
            $post->tags()->attach($tags);
        });
        $this->command->line('   -> Posts, Comments, and Tags created for test client.');

        Article::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id
        ])->each(function ($article) {
            $tags = Tags::all()->random(rand(1, 20));
            $article->tags()->attach($tags);
        });
        $this->command->line('   -> Articles and Tags created for test client.');

        Job::factory()->count(rand(1, 5))->create([
            'user_id' => $testClient->id,
            'currency_id' => Currency::find(rand(1, 20))->id,
        ])->each(function ($job) {
            $tags = Stacks::all()->random(rand(1, 3));
            $job->tags()->attach($tags);
        });
        $this->command->line('   -> Jobs and Stacks created for test client.');
        $this->command->info('✅ Test client data populated.');
        $this->command->info('-----------------------------------------');


        // --- Bids Creation ---
        $this->command->comment('🤝 Creating Bids for Jobs (ensuring unique freelancer bids per job)...');
        $freelancers = User::where('role', 'freelancer')->get();
        $jobs = Job::all();
        $bidsCreatedCount = 0;

        foreach ($jobs as $job) {
            $biddedFreelancerIds = [];
            $jobBidCount = rand(1, min(10, $freelancers->count())); // Max 10 bids per job, capped by available freelancers

            for ($i = 0; $i < $jobBidCount; $i++) {
                $availableFreelancers = $freelancers->filter(function ($f) use ($biddedFreelancerIds) {
                    return !in_array($f->id, $biddedFreelancerIds);
                });

                if ($availableFreelancers->isEmpty()) {
                    $this->command->line("   -> No more unique freelancers to bid on job ID: {$job->id}");
                    break;
                }

                $freelancer = $availableFreelancers->random();
                $biddedFreelancerIds[] = $freelancer->id;

                Bids::factory()->create([
                    'user_id' => $freelancer->id,
                    'job_listing_id' => $job->id,
                ]);
                $bidsCreatedCount++;
            }
            $this->command->line("  -> Job <fg=yellow>#{$job->id}</> received <fg=green>{$jobBidCount}</> bids.");
        }
        $this->command->info("✅ Total {$bidsCreatedCount} bids created across all jobs.");
        $this->command->info('-----------------------------------------');


        $this->command->info('🎉 Database Seeding Complete! Enjoy your development environment! 🎉');
        $this->command->info('');
    }
}
