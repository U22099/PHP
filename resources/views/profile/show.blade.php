<x-profile.layout>
    <div x-data="{
        currentTab: '{{ $user->role === 'freelancer' ? 'projects' : 'posts' }}',
        showEditProfileModal: false,
        showProjectFormModal: false,
        editingProject: null,
        openAddProjectModal() {
            this.editingProject = null;
            this.showProjectFormModal = true;
        },
    }" class="pb-10">
        {{-- Profile Header --}}
        <x-profile.header :user="$user" />
        <x-profile.navigation :user-role="$user->role" />

        {{-- Main Content Area (conditionally displayed based on currentTab) --}}
        <div class="mt-6">
            {{-- My Projects Section (Freelancer Specific) --}}
            @if ($user->role === 'freelancer')
                <template x-if="currentTab === 'projects'">
                    <x-profile.section title="My Projects">
                        <button @click="openAddProjectModal()"
                            class="mb-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add New Project
                        </button>
                        @if ($user->projects->isEmpty())
                            <p class="text-center p-4 text-gray-500 italic">No projects added yet.</p>
                        @else
                            @foreach ($user->projects as $project)
                                <x-project.card :project="$project" />
                            @endforeach
                        @endif
                    </x-profile.section>
                </template>
            @endif

            {{-- My Jobs Section (Client Specific - Placeholder) --}}
            @if ($user->role === 'client')
                <template x-if="currentTab === 'jobs'">
                    <x-profile.section title="My Posted Jobs">
                        <x-button type="link" href="/jobs/create">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Post New Job
                        </x-button>
                        {{-- Assuming $user->jobs if you added that relationship --}}
                        @if (empty($user->jobs) || $user->jobs->isEmpty())
                            <p class="text-center p-4 text-gray-500 italic">No jobs posted yet.</p>
                        @else
                            @foreach ($user->jobs as $job)
                                <div class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer"
                                    onclick="window.location.href = '/jobs/{{ $job->id }}';">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $job->title }}</h3>
                                    <p class="text-gray-600 text-sm mt-1">{{ $job->description }}</p>
                                    <p class="text-gray-700 font-medium mt-2">Budget: {{ $job->budget }}</p>
                                </div>
                            @endforeach
                        @endif
                    </x-profile.section>
                </template>
            @endif

            {{-- My Posts Section (Common) --}}
            <template x-if="currentTab === 'posts'">
                <x-profile.section title="My Posts">
                    <x-button type="link" href="/posts/create">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Create New Post
                    </x-button>
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
                    <x-button type="link" href="/articles/create">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Write New Article
                    </x-button>
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


        <template x-if="showEditProfileModal">
            <div class="fixed inset-0 bg-black/50 z-50 flex items-start lg:items-center justify-center p-4 overflow-y-scroll"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
                <div class="border bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
                    <button @click="showEditProfileModal = false"
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                    <h3 class="text-xl font-bold mb-4">Edit Profile</h3>
                    <x-profile.user-form :user="$user" />
                </div>
            </div>
        </template>

        <template x-if="showProjectFormModal">
            <div class="fixed inset-0 bg-black/50 z-50 flex items-start lg:items-center justify-center p-4 overflow-y-scroll"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
                <div class="border bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
                    <button @click="showProjectFormModal = false"
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                    <h3 x-text="editingProjectId ? 'Edit Project' : 'Add New Project'" class="text-xl font-bold mb-4">
                    </h3>
                    <template x-if="editingProject">
                        <x-project.form :edit="true" :availableTags="$availableTags" />
                    </template>
                    <template x-if="!editingProject">
                        <x-project.form :edit="false" :availableTags="$availableTags" />
                    </template>
                </div>
            </div>
        </template>
    </div>
</x-profile.layout>
