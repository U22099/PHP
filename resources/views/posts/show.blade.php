<x-layout>
    <x-slot:title>
        View Post: {{ $post->id }}
    </x-slot:title>

    <x-slot:heading>
        Post Details
    </x-slot:heading>

    <div class="max-w-3xl mx-auto px-3 py-8">
        <div class="border rounded-lg p-6">
            <!-- Profile Header -->
            <div class="flex items-center mb-4">
                <img class="h-12 w-12 rounded-full object-cover mr-4"
                    src="https://i.pravatar.cc/150?img={{ $post->user->id ?? rand(1, 70) }}"
                    alt="{{ $post->user->username ?? 'User' }}">
                <div>
                    <a href="#"
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
                            <span class="font-bold text-blue-600 prose leading-relaxed text-base">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                @if (!empty($post->images))
                    <x-image-display :images="$post->images" />
                @endif
            </div>

            <!-- Actions (Like, Comment, Share) - Same as index -->
            <div class="flex items-center justify-between text-gray-500 border-t border-gray-200 pt-4 mt-4">
                <button
                    class="flex items-center space-x-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1">
                    <x-heroicon-o-hand-thumb-up class="h-5 w-5" />
                    <span>Like ({{ $post->likes_count ?? 0 }})</span>
                </button>
                <span class="flex items-center space-x-1 text-green-600"> {{-- Active comment count --}}
                    <x-heroicon-o-chat-bubble-left class="h-5 w-5" />
                    <span>Comment ({{ $post->comments_count ?? $post->comments->count() }})</span>
                </span>
                <button
                    class="flex items-center space-x-1 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded px-2 py-1">
                    <x-heroicon-o-share class="h-5 w-5" />
                    <span>Share</span>
                </button>
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
