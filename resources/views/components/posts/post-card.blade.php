<div class="border rounded-lg p-6">
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

    <div class="mb-4">
        {{-- <x-image-display type="post" :images="[]" x-bind:images="post.images" /> --}}
        <p class="text-gray-800 prose leading-relaxed text-base line-clamp-3" x-html="post.body"></p>
        <template x-if="post.body.length > 250">
            <a :href="`{{ url('/posts') }}/${post.id}`"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-1 inline-block">Read
                more</a>
        </template>

        <template x-if="post.tag_names_for_display && post.tag_names_for_display.length > 0">
            <div class="mt-2 flex flex-wrap gap-1">
                <template x-for="(tag, tagIndex) in post.tag_names_for_display" :key="tagIndex">
                    <span class="font-bold text-blue-600 text-sm">#<span x-text="tag"></span></span>
                </template>
            </div>
        </template>
    </div>

    <div class="flex items-center justify-between text-gray-500 border-t border-gray-200 pt-4 mt-4">
        <button
            class="flex items-center space-x-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21H3v-7a2 2 0 012-2h7.042M10 9V3a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1h5a1 1 0 011 1v4a1 1 0 001 1h2m-7 10h7.243a2 2 0 001.807-2.73l-1.5-3A2 2 0 0011.66 9H3.66M14 20h4.764a2 2 0 001.789-2.894l-3.5-7A2 2 0 0015.263 9H3v7a2 2 0 002 2h7.042">
                </path>
            </svg>
            <span x-text="`Like (${post.likes_count || 0})`"></span>
        </button>
        <a :href="`{{ url('/posts') }}/${post.id}#comments`"
            class="flex items-center space-x-1 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                </path>
            </svg>
            <span x-text="`Comment (${post.comments_count || 0})`"></span>
        </a>
        <button
            class="flex items-center space-x-1 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
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
        <template x-if="post.can_update">
            <div class="mt-4 border-t border-gray-200 pt-4 text-right">
                <x-button type="link" x-bind:href="`{{ url('/posts') }}/${post.id}/edit`"
                    class="mr-2 bg-yellow-500 hover:bg-yellow-600">
                    Edit Post
                </x-button>
                <form x-bind:action="`{{ url('/posts') }}/${post.id}`" method="POST" class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" class="bg-red-600 hover:bg-red-700">
                        Delete Post
                    </x-button>
                </form>
            </div>
        </template>
    @endauth
</div>
