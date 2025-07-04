<x-layout>
    <x-slot:heading>
        {{ $post->title }}
    </x-slot:heading>

    <div class="bg-white shadow-lg rounded-xl p-8 md:p-10 mb-8">
        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-8">
            {{--
                IMPORTANT: Use {!! $post->body !!} ONLY if you trust the source or have
                sanitized HTML. Otherwise, use {{ nl2br(e($post->body)) }}
                to render line breaks and safely escape HTML.
            --}}
            {!! nl2br(e($post->body)) !!}
        </div>

        <p class="w-full flex justify-end text-right text-gray-600 text-sm italic mt-6 pt-4 border-t border-gray-100">
            Author: <span class="font-medium text-gray-800 ml-1">{{ $post->author }}</span>
        </p>
    </div>

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
