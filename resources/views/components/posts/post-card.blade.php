<div class="border rounded-lg p-6">
    <div class="flex items-center mb-4">
        <img class="h-10 w-10 rounded-full object-cover mr-3" :src="post.user_data_for_display.image"
            :alt="post.user_data_for_display ? post.user_data_for_display.username : 'User'">
        <div>
            <a :href="`/${post.user_data_for_display.username}`" class="font-semibold text-gray-900 hover:underline"
                x-text="post.user_data_for_display ? post.user_data_for_display.username : 'Anonymous User'"></a>
            <p class="text-sm text-gray-500" x-text="post.created_at_human"></p>
            <p class="text-xs text-gray-500"
                x-text="post.user_data_for_display && post.user_data_for_display.role ? '(' + post.user_data_for_display.role + ')' : ''">
            </p>
        </div>
    </div>

    <div class="mb-4">
        <p class="text-gray-800 prose leading-relaxed text-base line-clamp-3" x-html="post.body"></p>
        <template x-if="post.body.length > 250">
            <a :href="`{{ url('/posts') }}/${post.id}`"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-1 inline-block">Read
                more</a>
        </template>

        <template x-if="post.tag_names_for_display && post.tag_names_for_display.length > 0">
            <div class="mt-1 flex flex-wrap gap-1">
                <template x-for="(tag, tagIndex) in post.tag_names_for_display" :key="tagIndex">
                    <a :href="`/{{ Auth::check() ? 'posts/' : '' }}?tags[]=${tag}`"
                        class="font-bold text-blue-600 text-sm">#<span x-text="tag"></span></a>
                </template>
            </div>
        </template>
        <template x-if="post.images.length > 0">
            <x-posts.post-image-display />
        </template>
    </div>

    <div class="flex items-center justify-between text-gray-500 border-t border-gray-200 pt-4 mt-4">
        <button @click="like(post.id)"
            :class="{ 'text-blue-600': post.liked_by_user, 'hover:text-blue-600': !post.liked_by_user }"
            class="flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
            <x-heroicon-o-hand-thumb-up class="h-6 w-6 md:h-5 md:w-5" />
            <span class="hidden md:inline" x-text="`Like (${post.likes_count || 0})`"></span>
            <span class="md:hidden" x-text="`(${post.likes_count || 0})`"></span>
        </button>
        <a :href="`{{ url('/posts') }}/${post.id}#comments`"
            class="flex items-center space-x-1 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
            <x-heroicon-o-chat-bubble-left class="h-6 w-6 md:h-5 md:w-5" />
            <span class="hidden md:inline" x-text="`Comment (${post.comments_count || 0})`"></span>
            <span class="md:hidden" x-text="`(${post.comments_count || 0})`"></span>
        </a>
        <button
            class="flex items-center space-x-1 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded px-2 py-1 text-sm md:text-md">
            <x-heroicon-o-share class="h-6 w-6 md:h-5 md:w-5" />
            <span class="hidden md:inline">Share</span>
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
