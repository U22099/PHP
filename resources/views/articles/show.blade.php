<x-layout>
    <x-slot:title>
        View Article: {{ $article->title }}
    </x-slot:title>
    <x-slot:heading>
        {{ $article->title }}
    </x-slot:heading>
    
    <x-slot:headerbutton>
        <x-share-button :url="route('articles.show', $article)" from="article" class="inline-flex items-center rounded-xl gap-2 bg-blue-100 px-4 py-2 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-200" />
        @can('update', $article)
            <x-button type="link" href="/articles/{{ $article->id }}/edit" class="capitalize">
                Edit Article
            </x-button>
        @endcan
    </x-slot:headerbutton>

    @section('social_meta_tags')
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ route('articles.show', $article) }}">
        <meta property="og:title" content="{{ $article->user->username }}">
        <meta property="og:description" content="{{ Str::limit($article->body, 150) }}">
        <meta property="og:image" content="{{ $article->user->image }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <meta name="twitter:title" content="{{ $article->user->username }}">
        <meta name="twitter:description" content="{{ Str::limit($article->body, 150) }}">
        <meta name="twitter:image" content="{{ $article->user->image }}">
    <meta name="twitter:image:width" content="1200">
    <meta name="twitter:image:height" content="630">
    @endsection

    <div class="border rounded-xl p-8 md:p-10 lg:p-12 mb-8">
        <!-- Author and Date Section -->
        <div class="flex items-center justify-between flex-wrap gap-y-2 mb-8 pb-6 border-b border-gray-100">
            @if ($article->user)
                {{-- Ensure user (author) exists --}}
                <p class="text-lg text-gray-600 font-medium">
                    By: <span class="text-indigo-600 font-bold">{{ $article->user->firstname }}</span>
                </p>
            @endif
            <p class="text-gray-500 text-sm">
                Published: {{ $article->created_at->format('M d, Y') }} {{-- Format the creation date --}}
            </p>
        </div>

        <!-- article Body -->
        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-10 text-justify">
            {!! $article->body !!}
        </div>

        <!-- Tags Section -->
        @if ($article->tags->isNotEmpty())
            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Topics & Tags</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($article->tags as $tag)
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
        <x-button type="link" href="/articles">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to All articles
        </x-button>
    </div>
</x-layout>
