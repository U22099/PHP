<x-layout>
    <x-slot:title>
        Articles
    </x-slot:title>
    <x-slot:heading>
        Recent Articles
    </x-slot:heading>
    <x-slot:headerbutton>
        @can('create', \App\Models\Article::class)
            <x-button type="link" href="/articles/create" class="capitalize">
                Create Article
            </x-button>
        @endcan
    </x-slot:headerbutton>

    <div class="mt-8 flow-root">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($articles as $article)
                <div
                    class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden flex flex-col group hover:shadow-xl transition-all duration-300 ease-in-out">
                    <a href="/articles/{{ $article->id }}" class="p-6 flex flex-col flex-grow">
                        <h3
                            class="text-xl font-semibold text-indigo-600 group-hover:text-indigo-700 transition-colors duration-200 mb-2 leading-tight">
                            {{ $article->title }}
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed flex-grow mb-4 line-clamp-5">
                            {!! $article->body !!}
                        </p>
                    </a>
                    @if ($article->tags->isNotEmpty())
                        <div class="px-6 pb-4 pt-2 border-t border-gray-100 flex flex-wrap gap-2 text-sm">
                            @foreach ($article->tags as $tag)
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <div class="px-6 pb-6 pt-2 text-sm text-gray-500 flex justify-end">
                        <a href="/articles/{{ $article->id }}"
                            class="text-indigo-500 hover:text-indigo-700 font-medium transition-colors duration-200 inline-flex items-center">
                            Read More &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500 bg-gray-50 rounded-lg shadow-inner">
                    <p class="text-lg mb-2">No articles published yet.</p>
                    <p class="text-sm">Be the first to share your thoughts!</p>
                </div>
            @endforelse
        </div>
        <div class="mt-5">
            {{ $articles->links() }}
        </div>
    </div>
</x-layout>
