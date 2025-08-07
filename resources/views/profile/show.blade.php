<x-profile.layout>
    <x-slot:title>
        {{ $user->firstname . ' ' . $user->lastname }}
    </x-slot:title>

    <div x-data="{
        currentTab: '{{ request()->has('tab') ? request()->get('tab') : ($user->role === 'freelancer' ? 'projects' : 'jobs') }}',
        showEditProfileModal: JSON.parse('{{ !request()->has('error') ? 'false' : (request()->get('error') === 'profile-form-error' ? 'true' : 'false') }}'),
    }" class="pb-10">
        {{-- Profile Header --}}
        <x-profile.header :user="$user" />

        {{-- Freelancer Details Card (conditionally displayed for freelancers) --}}
        @if (Auth::user()->id !== $user->id || $user->role === 'freelancer')
            <div class="my-4">
                <x-freelancer.profile-card :freelancerDetails="$user->freelancer_details" />
            </div>
        @endif

        <x-profile.navigation :user="$user" />

        {{-- Main Content Area (conditionally displayed based on currentTab) --}}
        <div class="mt-6">
            {{-- My Projects Section (Freelancer Specific) --}}
            @if ($user->role === 'freelancer')
                <template x-if="currentTab === 'projects'">
                    <x-profile.section
                        title="{{ Auth::user()->id !== $user->id ? $user->firstname . `'` : 'My' }} Projects">
                        @if (Auth::user()->id === $user->id)
                            <button @click="window.location.href = '/profile/projects/new'"
                                class="mb-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                Add New Project
                            </button>
                        @endif
                        @if ($user->projects->isEmpty())
                            <p class="text-center p-4 text-gray-500 italic">No projects added yet.</p>
                        @else
                            @foreach ($user->projects as $project)
                                <x-project.card :project="$project" :user_id="$user->id" />
                            @endforeach
                        @endif
                    </x-profile.section>
                </template>

                @if (Auth::user()->id === $user->id)
                    <template x-if="currentTab === 'bids'">
                        <x-profile.section title="My Bids">
                            <button @click="window.location.href = '/jobs?timeframe=today'"
                                class="mb-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                View Recent Jobs
                            </button>
                            @if ($user->bids->isEmpty())
                                <p class="text-center p-4 text-gray-500 italic">No bids yet.</p>
                            @else
                                @foreach ($user->bids as $bid)
                                    <x-bids.card :bid="$bid" />
                                @endforeach
                            @endif
                        </x-profile.section>
                    </template>
                @endif
            @endif

            {{-- My Jobs Section (Client Specific - Placeholder) --}}
            @if ($user->role === 'client' && (Auth::user()->id !== $user->id ? Auth::user()->role !== $user->role : true))
                <template x-if="currentTab === 'jobs'">
                    <x-profile.section
                        title="{{ Auth::user()->id !== $user->id ? $user->firstname . `'` : 'My' }} Posted Jobs">
                        @if (Auth::user()->id === $user->id)
                            @can('create', \App\Models\Job::class)
                                <div class="flex w-full gap-2 items-end flex-wrap">
                                    <x-button type="link" href="/jobs/create">
                                        <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                        Post New Job
                                    </x-button>
                                    <p
                                        class="{{ $user->is_premium ? 'text-indigo-600' : 'text-gray-600' }} font-bold text-sm flex gap-1 items-end">
                                        {{ !$user->is_premium ? env('JOBS_LIMIT_PER_DAY') - $user->number_of_jobs_created_today : svg('css-infinity') }}
                                        free jobs remaining today</p>
                                </div>
                            @endcan
                        @endif
                        @if (empty($user->jobs) || $user->jobs->isEmpty())
                            <p class="text-center p-4 text-gray-500 italic">No jobs posted yet.</p>
                        @else
                            @foreach ($user->jobs as $job)
                                <div class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer"
                                    onclick="window.location.href = '/jobs/{{ $job->id }}';">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $job->title }}</h3>
                                    <div class="text-gray-600 text-sm mt-1 line-clamp-3">
                                        {{ strip_tags($job->description) }}</div>
                                    <p class="text-gray-700 font-medium mt-2 flex gap-0">Budget:
                                        {{ $job->currency->symbol }}
                                        <span>
                                            @if ($job->min_budget === $job->max_budget)
                                                {{ Number::abbreviate($job->min_budget, 1) }}
                                            @else
                                                {{ Number::abbreviate($job->min_budget, 1) }} -
                                                {{ Number::abbreviate($job->max_budget, 1) }}
                                            @endif
                                        </span>
                                    </p>
                                    <p class="text-gray-700 font-medium mt-2">Bids: {{ $job->bids_count }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </x-profile.section>
                </template>
            @endif

            {{-- My Posts Section (Common) --}}
            <template x-if="currentTab === 'posts'">
                <x-profile.section title="{{ Auth::user()->id !== $user->id ? $user->firstname . `'` : 'My' }} Posts">
                    @if (Auth::user()->id === $user->id)
                        @can('create', \App\Models\Post::class)
                            <div class="flex w-full gap-2 items-end flex-wrap">
                                <x-button type="link" href="/posts/create">
                                    <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                    Create New Post
                                </x-button>
                                <p
                                    class="{{ $user->is_premium ? 'text-indigo-600' : 'text-gray-600' }} font-bold text-sm flex gap-1 items-end">
                                    {{ !$user->is_premium ? env('POSTS_LIMIT_PER_DAY') - $user->number_of_posts_created_today : svg('css-infinity') }}
                                    free posts remaining today</p>
                            </div>
                        @endcan
                    @endif
                    @if ($user->posts->isEmpty())
                        <p class="text-center p-4 text-gray-500 italic">No posts published yet.</p>
                    @else
                        @foreach ($user->posts as $post)
                            <x-posts.card :post="$post" />
                        @endforeach
                    @endif
                </x-profile.section>
            </template>

            {{-- My Articles Section (Common) --}}
            <template x-if="currentTab === 'articles'">
                <x-profile.section
                    title="{{ Auth::user()->id !== $user->id ? $user->firstname . `'` : 'My' }} Articles">
                    @if (Auth::user()->id === $user->id)
                        @can('create', \App\Models\Article::class)
                            <div class="flex w-full gap-2 items-end flex-wrap">
                                <x-button type="link" href="/articless/create">
                                    <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                    Create New Article
                                </x-button>
                                <p
                                    class="{{ $user->is_premium ? 'text-indigo-600' : 'text-gray-600' }} font-bold text-sm flex gap-1 items-end">
                                    {{ !$user->is_premium ? env('ARTICLES_LIMIT_PER_DAY') - $user->number_of_articless_created_today : svg('css-infinity') }}
                                    free articles remaining today</p>
                            </div>
                        @endcan
                    @endif
                    @if ($user->articles->isEmpty())
                        <p class="text-center p-4 text-gray-500 italic">No articles written yet.</p>
                    @else
                        @foreach ($user->articles as $article)
                            <x-article.card :article="$article" />
                        @endforeach
                    @endif
                </x-profile.section>
            </template>
        </div>


        @if (Auth::user()->id === $user->id)
            <template x-if="showEditProfileModal">
                <div class="fixed inset-0 bg-black/50 z-50 flex items-start lg:items-center justify-center p-4 overflow-y-scroll"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    x-cloak>
                    <div class="border bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
                        <button @click="showEditProfileModal = false"
                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                        <h3 class="text-xl font-bold mb-4">Edit Profile</h3>
                        <x-profile.user-form :user="$user" />
                    </div>
                </div>
            </template>
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000);
                showEditProfileModal = false"
                    class="absolute bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
                    {{ session('success') }}
                </div>
            @endif
        @endif
    </div>
</x-profile.layout>
