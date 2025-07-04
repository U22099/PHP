<x-layout>
    <x-slot:heading>
        Recent Articles
    </x-slot:heading>

    <div class="mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <div
                    class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden flex flex-col group hover:shadow-xl transition-all duration-300 ease-in-out">
                    <a href="/post/{{ $post->id }}" class="block p-6 flex flex-col flex-grow">
                        <h2
                            class="text-xl font-semibold text-indigo-600 group-hover:text-indigo-700 transition-colors duration-200 mb-2 leading-tight">
                            {{ $post->title }}
                        </h2>
                        <p class="text-gray-600 text-base leading-relaxed flex-grow">
                            {{ Str::limit($post->body, 100) }}
                        </p>
                    </a>
                    <div
                        class="px-6 pb-4 pt-2 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                        <span>Author: <span class="font-medium text-gray-700">{{ $post->author }}</span></span>
                        <a href="/post/{{ $post->id }}"
                            class="text-indigo-500 hover:text-indigo-700 font-medium transition-colors duration-200">
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
    </div>
</x-layout>
