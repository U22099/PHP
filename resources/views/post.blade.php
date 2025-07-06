<x-layout>
    <x-slot:heading>
        {{ $post->title }}
    </x-slot:heading>

    <div class="bg-white shadow-xl rounded-xl p-8 md:p-10 lg:p-12 mb-8">
        <!-- Author and Date Section -->
        <div class="flex items-center justify-between flex-wrap gap-y-2 mb-8 pb-6 border-b border-gray-100">
            @if ($post->user)
                {{-- Ensure user (author) exists --}}
                <p class="text-lg text-gray-600 font-medium">
                    By: <span class="text-indigo-600 font-bold">{{ $post->user->firstname }}</span>
                </p>
            @endif
            <p class="text-gray-500 text-sm">
                Published: {{ $post->created_at->format('M d, Y') }} {{-- Format the creation date --}}
            </p>
        </div>

        <!-- Post Body -->
        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-10">
            {{--
                IMPORTANT: Use {!! $post->body !!} ONLY if you trust the source or have
                sanitized HTML. Otherwise, use {{ nl2br(e($post->body)) }}
                to render line breaks and safely escape HTML.
            --}}
            {!! nl2br(e($post->body)) !!}
        </div>

        <!-- Tags Section -->
        @if ($post->tags->isNotEmpty())
            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Topics & Tags</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($post->tags as $tag)
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-200">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="flex justify-start mt-8">
        <a href="/posts"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to All Posts
        </a>
    </div>
</x-layout>
