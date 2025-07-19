<!-- resources/views/posts/index.blade.php -->
<x-layout>
    <x-slot:heading>
        Posts Feed
    </x-slot:heading>

    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Main Content Area (Posts) -->
            <div class="lg:col-span-8">
                @auth
                    <div class="bg-white shadow-md rounded-lg p-4 mb-8">
                        <div class="flex items-center mb-4">
                            <img class="h-12 w-12 rounded-full object-cover mr-4"
                                src="https://i.pravatar.cc/150?img={{ Auth::user()->id ?? rand(1, 70) }}"
                                alt="{{ Auth::user()->username ?? 'User' }}">
                            <span class="font-semibold text-gray-900">{{ Auth::user()->username ?? 'Your Name' }}</span>
                        </div>
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <textarea name="body" rows="2"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 resize-y p-2"
                                placeholder="What's on your mind, {{ Auth::user()->username ?? 'friend' }}?">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <div class="mt-4 text-right">
                                <x-button type="submit">
                                    Post
                                </x-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white shadow-md rounded-lg p-6 mb-8 text-center text-gray-600">
                        <p class="mb-4">Join the conversation! Share your thoughts with the community.</p>
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Login</a> or
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Register</a>
                        to post.
                    </div>
                @endauth

                <!-- Alpine.js controlled Post List -->
                <script>
                    let initialPosts = @json($posts->items());
                    let initialNextPageUrl = @json($posts->nextPageUrl());
                </script>
                <div x-data="{
                    posts: initialPosts,
                    nextPageUrl: initialNextPageUrl,
                    loading: false,
                    loadMorePosts() {
                        if (!this.nextPageUrl || this.loading) return;
                
                        this.loading = true;
                        fetch(this.nextPageUrl + window.location.search, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                this.posts = [...this.posts, ...data.posts.data];
                                this.nextPageUrl = data.posts.next_page_url;
                            })
                            .catch(error => console.error('Error loading more posts:', error))
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                }" class="space-y-6">
                    <template x-if="posts.length === 0">
                        <p class="text-center text-gray-600 text-lg">No posts match your criteria.</p>
                    </template>
                    <template x-for="post in posts" :key="post.id">
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <!-- Profile Header -->
                            <div class="flex items-center mb-4">
                                <img class="h-10 w-10 rounded-full object-cover mr-3"
                                    :src="`https://i.pravatar.cc/150?img=${post.user_data_for_display ? post.user_data_for_display.id : Math.floor(Math.random() * 70) + 1}`"
                                    :alt="post.user_data_for_display ? post.user_data_for_display.username : 'User'">
                                <div>
                                    <a :href="`#`" class="font-semibold text-gray-900 hover:underline"
                                        x-text="post.user_data_for_display ? post.user_data_for_display.username : 'Anonymous User'"></a>
                                    <p class="text-sm text-gray-500" x-text="post.created_at_human"></p>
                                    <p class="text-xs text-gray-500"
                                        x-text="post.user_data_for_display && post.user_data_for_display.role ? '(' + post.user_data_for_display.role + ')' : ''">
                                    </p>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="mb-4">
                                <p class="text-gray-800 prose leading-relaxed text-base" x-html="post.body_excerpt"></p>
                                <template x-if="post.body.length > 250">
                                    <a :href="`{{ url('/posts') }}/${post.id}`"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-1 inline-block">Read
                                        more</a>
                                </template>

                                <template x-if="post.tag_names_for_display && post.tag_names_for_display.length > 0">
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        <template x-for="(tag, tagIndex) in post.tag_names_for_display"
                                            :key="tagIndex">
                                            <span class="font-bold text-blue-600 text-sm">#<span
                                                    x-text="tag"></span></span>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <!-- Actions (Like, Comment, Share) -->
                            <div
                                class="flex items-center justify-between text-gray-500 border-t border-gray-200 pt-4 mt-4">
                                <button
                                    class="flex items-center space-x-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21H3v-7a2 2 0 012-2h7.042M10 9V3a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1h5a1 1 0 011 1v4a1 1 0 001 1h2m-7 10h7.243a2 2 0 001.807-2.73l-1.5-3A2 2 0 0011.66 9H3.66M14 20h4.764a2 2 0 001.789-2.894l-3.5-7A2 2 0 0015.263 9H3v7a2 2 0 002 2h7.042">
                                        </path>
                                    </svg>
                                    <span x-text="`Like (${post.likes_count || 0})`"></span>
                                </button>
                                <a :href="`{{ url('/posts') }}/${post.id}#comments`"
                                    class="flex items-center space-x-1 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded px-2 py-1">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                    <span x-text="`Comment (${post.comments_count || 0})`"></span>
                                </a>
                                <button
                                    class="flex items-center space-x-1 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded px-2 py-1">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.882 13.065 9 12.7 9 12c0-.3 0-.6-.118-.858m0 0a8.01 8.01 0 012.44-4.894m0 0L17.5 4l-4.498 4.498m-1.5 0l2.5-2.5V11m0 5c-.754 0-1.465-.2-2.07-.577m0 0a8.006 8.006 0 01-2.44 4.894m0 0L6.5 20l4.498-4.498m1.5 0l-2.5 2.5V13m0-1c0 .3 0 .6.118.858m0 0c.2.277.46.52.757.728M9 12c0-.3 0-.6.118-.858m0 0a8.01 8.01 0 012.44-4.894m0 0L17.5 4l-4.498 4.498m-1.5 0l2.5-2.5V11m0 5c-.754 0-1.465-.2-2.07-.577m0 0a8.006 8.006 0 01-2.44 4.894m0 0L6.5 20l4.498-4.498m1.5 0l-2.5 2.5V13">
                                        </path>
                                    </svg>
                                    <span>Share</span>
                                </button>
                            </div>

                            @auth
                                {{-- Assuming PostPolicy methods 'update' and 'delete' --}}
                                <template x-if="post.can_update">
                                    <div class="mt-4 border-t border-gray-200 pt-4 text-right">
                                        <x-button type="link" x-bind:href="`{{ url('/posts') }}/${post.id}/edit`"
                                            addclass="mr-2 bg-yellow-500 hover:bg-yellow-600">
                                            Edit Post
                                        </x-button>
                                        <form x-bind:action="`{{ url('/posts') }}/${post.id}`" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" addclass="bg-red-600 hover:bg-red-700">
                                                Delete Post
                                            </x-button>
                                        </form>
                                    </div>
                                </template>
                            @endauth
                        </div>
                    </template>

                    <div x-show="posts.length > 0 && nextPageUrl" class="mt-8 text-center">
                        <x-button @click="loadMorePosts()">
                            <span x-show="!loading">Load More Posts</span>
                            <span x-show="loading">Loading...</span>
                        </x-button>
                    </div>

                </div>
            </div>

            <!-- Right Sidebar (Search and Filters) -->
            <script>
                let initialSelectedTags = @json(request('tags', []));
                let initialAllAvailableTags = @json($allTags->pluck('name'));
            </script>
            <div class="lg:col-span-4 lg:mt-0 mt-8">
                <div x-data="{
                    search: '{{ request('search') }}',
                    userRole: '{{ request('user_role', 'all') }}',
                    selectedTags: initialSelectedTags,
                    allAvailableTags: initialAllAvailableTags,
                
                    applyFilters() {
                        let params = new URLSearchParams();
                        if (this.search) {
                            params.append('search', this.search);
                        }
                        if (this.userRole && this.userRole !== 'all') {
                            params.append('user_role', this.userRole);
                        }
                        this.selectedTags.forEach(tag =>
                            params.append('tags[]', tag));
                        window.location.href = '{{ route('posts.index') }}?' + params.toString();
                    },
                    toggleTag(tag) {
                        if (this.selectedTags.includes(tag)) {
                            this.selectedTags = this.selectedTags.filter(t => t !== tag);
                        } else {
                            this.selectedTags.push(tag);
                        }
                    }
                }" class="bg-white shadow-md rounded-lg p-6 sticky top-8">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Filter Posts</h3>

                    <!-- Search by Keyword -->
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" x-model.debounce.500ms="search" @keydown.enter="applyFilters()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Search posts...">
                    </div>

                    <!-- Filter by User Role -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Posted By</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input id="role-all" name="user_role" type="radio" x-model="userRole"
                                    value="all" @change="applyFilters()"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="role-all" class="ml-2 block text-sm text-gray-900">All Posts</label>
                            </div>
                            <div class="flex items-center">
                                <input id="role-client" name="user_role" type="radio" x-model="userRole"
                                    value="client" @change="applyFilters()"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="role-client" class="ml-2 block text-sm text-gray-900">Clients</label>
                            </div>
                            <div class="flex items-center">
                                <input id="role-freelancer" name="user_role" type="radio" x-model="userRole"
                                    value="freelancer" @change="applyFilters()"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="role-freelancer"
                                    class="ml-2 block text-sm text-gray-900">Freelancers</label>
                            </div>
                        </div>
                    </div>

                    <!-- Filter by Tags -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                        <div class="mt-2 flex flex-wrap gap-2 max-h-[200px] overflow-y-scroll">
                            <template x-for="tag in allAvailableTags" :key="tag">
                                <button type="button" @click="toggleTag(tag); applyFilters();"
                                    :class="{
                                        'bg-indigo-600 text-white': selectedTags.includes(
                                            tag),
                                        'bg-gray-200 text-gray-700 hover:bg-gray-300': !selectedTags.includes(
                                            tag)
                                    }"
                                    class="px-3 py-1 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    #<span x-text="tag"></span>
                                </button>
                            </template>
                            <template x-if="allAvailableTags.length === 0">
                                <p class="text-xs text-gray-500">No tags available.</p>
                            </template>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-button @click="applyFilters()" class="w-full">
                            Apply Filters
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
