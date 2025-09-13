<x-layout>
    <x-slot:title>
        View Post: {{ $post->id }}
    </x-slot:title>

    <x-slot:heading>
        Post Details
    </x-slot:heading>

    @section('social_meta_tags')
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ route('posts.show', $post) }}">
        <meta property="og:title" content="{{ $post->user->username }}">
        <meta property="og:description" content="{{ Str::limit($post->body, 150) }}">
        <meta property="og:image" content="{{ $post->images ? $post->images[0] : $post->user->image }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <meta name="twitter:title" content="{{ $post->user->username }}">
        <meta name="twitter:description" content="{{ Str::limit($post->body, 150) }}">
        <meta name="twitter:image" content="{{ $post->images ? $post->images[0] : $post->user->image }}">
        <meta name="twitter:image:width" content="1200">
        <meta name="twitter:image:height" content="630">
    @endsection

    <div class="max-w-3xl mx-auto px-3 py-8" x-data="{
        liked_by_user: JSON.parse(`{{ $post->liked_by_user ? 'true' : 'false' }}`),
        likes_count: {{ $post->likes->count() ?? 0 }},
        like() {
            this.likes_count += !this.liked_by_user ? 1 : -1;
    
            fetch(`/posts/{{ $post->id }}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                this.liked_by_user = data.liked;
                this.likes_count = data.this.likes_count;
            }).catch(() => {
                this.liked_by_user = !this.liked_by_user;
                this.likes_count += this.liked_by_user ? 1 : -1;
            });
        }
    }">
        <div class="border rounded-lg p-6">
            <!-- Profile Header -->
            <div class="flex items-center mb-4">
                <img class="h-12 w-12 rounded-full object-cover mr-4"
                    src="https://i.pravatar.cc/150?img={{ $post->user->id ?? rand(1, 70) }}"
                    alt="{{ $post->user->username ?? 'User' }}">
                <div>
                    <a href="/profile/{{ $post->user->username }}"
                        class="font-bold text-lg text-gray-900 hover:underline">{{ $post->user->username ?? 'Anonymous User' }}</a>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Full Post Content -->
            <div class="mb-6 prose max-w-none">
                <p class="text-gray-800 leading-relaxed">{{ $post->body }}</p>
                @if ($post->tags->isNotEmpty())
                    {{-- Only show tags if there are any --}}
                    <div class="mt-1 flex flex-wrap gap-1">
                        @foreach ($post->tags as $tag)
                            <a href='/{{ Auth::check() ? 'posts/' : '' }}?tags[]={{ $tag->name }}'
                                class="font-bold text-blue-600 prose leading-relaxed text-base">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                @if (!empty($post->images))
                    <x-image-gallery :images="$post->images" />
                @endif
            </div>

            <!-- Actions (Like, Comment, Share) - Same as index -->
            <div class="flex items-center justify-between text-gray-500 border-t border-gray-200 pt-4 mt-4">
                <button @click="like()"
                    :class="{ 'text-blue-600': liked_by_user, 'hover:text-blue-600': !liked_by_user }"
                    class="flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
                    <x-heroicon-o-hand-thumb-up class="h-6 w-6 md:h-5 md:w-5" />
                    <span class="hidden md:inline" x-text="`Like (${likes_count || 0})`"></span>
                    <span class="md:hidden" x-text="`(${likes_count || 0})`"></span>
                </button>
                <a href="#comments" class="flex items-center space-x-1 text-green-600">
                    <x-heroicon-o-chat-bubble-left class="h-6 w-6 md:h-5 md:w-5" />
                    <span class="hidden md:inline">Comment
                        ({{ $post->comments_count ?? $post->comments->count() }})</span>
                    <span class="md:hidden">({{ $post->comments_count ?? $post->comments->count() }})</span>
                </a>
                <x-share-button url="{{ route('posts.show', $post) }}" from="post"
                    class="flex items-center space-x-1 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded px-2 py-1" />
            </div>

            {{-- Optional: Edit/Delete buttons for owner --}}
            @auth
                @can('update', $post)
                    <div class="mt-4 border-t border-gray-200 pt-4 text-right">
                        <x-button type="link" href="{{ route('posts.edit', $post) }}"
                            class="mr-2 bg-yellow-500 hover:bg-yellow-600">
                            Edit Post
                        </x-button>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" class="bg-red-600 hover:bg-red-700">
                                Delete Post
                            </x-button>
                        </form>
                    </div>
                @endcan
            @endauth
        </div>

        <section id="comments" class="mt-8">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Comments ({{ $post->comments->count() }})</h3>

            <!-- New Comment Form -->
            @auth
                <div class="border rounded-lg p-3 mb-6">
                    <h4 class="text-lg font-semibold mb-3 text-gray-800">Add a Comment</h4>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        {{-- <input name="post_id" type="text" value="{{ $post-> }}" --}}
                        <textarea name="body" rows="2"
                            class="w-full border-gray-300 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 resize-y p-2"
                            placeholder="Write your comment here...">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div class="mt-2 text-right">
                            <x-button type="submit">
                                Post Comment
                            </x-button>
                        </div>
                    </form>
                </div>
            @else
                <p class="text-center text-gray-600 py-4">Please <a href="{{ route('login') }}"
                        class="text-indigo-600 hover:underline">log in</a> to post a comment.</p>
            @endauth


            <!-- Existing Comments -->
            <div class="space-y-4">
                @forelse ($post->comments->sortByDesc('created_at') as $comment)
                    <div class="rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <img class="h-8 w-8 rounded-full object-cover mr-3"
                                src="https://i.pravatar.cc/150?img={{ $comment->user->id ?? rand(1, 70) }}"
                                alt="{{ $comment->user->username ?? 'User' }}">
                            <div>
                                <a href="#"
                                    class="font-semibold text-gray-900 hover:underline text-sm">{{ $comment->user->username ?? 'Anonymous' }}</a>
                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-gray-600 text-center py-4">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layout>
