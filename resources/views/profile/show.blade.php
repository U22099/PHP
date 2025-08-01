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

        <x-profile.navigation :user-role="$user->role" />

        {{-- Main Content Area (conditionally displayed based on currentTab) --}}
        <div class="mt-6">
            {{-- My Projects Section (Freelancer Specific) --}}
            @if ($user->role === 'freelancer')
                <template x-if="currentTab === 'projects'">
                    <x-profile.section title="My Projects">
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
            @endif

            {{-- My Jobs Section (Client Specific - Placeholder) --}}
            @if ($user->role === 'client')
                <template x-if="currentTab === 'jobs'">
                    <x-profile.section title="My Posted Jobs">
                        @if (Auth::user()->id === $user->id)
                            <x-button type="link" href="/jobs/create">
                                <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                                Post New Job
                            </x-button>
                        @endif
                        {{-- Assuming $user->jobs if you added that relationship --}}
                        @if (empty($user->jobs) || $user->jobs->isEmpty())
                            <p class="text-center p-4 text-gray-500 italic">No jobs posted yet.</p>
                        @else
                            @foreach ($user->jobs as $job)
                                <div class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer"
                                    onclick="window.location.href = '/jobs/{{ $job->id }}';">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $job->title }}</h3>
                                    <div class="text-gray-600 text-sm mt-1 line-clamp-3">{!! $job->description !!}</div>
                                    <p class="text-gray-700 font-medium mt-2">Budget: {{ $job->currency->symbol }}
                                        <span>
                                            @if ($job->min_budget === $job->max_budget)
                                                {{ Number::abbreviate($job->min_budget, 1) }}
                                            @else
                                                {{ Number::abbreviate($job->min_budget, 1) }} -
                                                {{ Number::abbreviate($job->max_budget, 1) }}
                                            @endif
                                        </span>
                                    </p>
                                    <p class="text-gray-700 font-medium mt-2">Bids: {{ $job->bids->count() }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </x-profile.section>
                </template>
            @endif

            {{-- My Posts Section (Common) --}}
            <template x-if="currentTab === 'posts'">
                <x-profile.section title="My Posts">
                    @if (Auth::user()->id === $user->id)
                        <x-button type="link" href="/posts/create">
                            <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                            Create New Post
                        </x-button>
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
                <x-profile.section title="My Articles">
                    @if (Auth::user()->id === $user->id)
                        <x-button type="link" href="/articles/create">
                            <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                            Write New Article
                        </x-button>
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
        @endif
    </div>
</x-profile.layout>
