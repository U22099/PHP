<!-- resources/views/posts/edit.blade.php -->
<x-layout>
    <x-slot:heading>
        Edit Post
    </x-slot:heading>

    <div class="max-w-xl mx-auto py-8">
        <form method="POST" action="{{ route('posts.update', $post) }}" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PATCH') {{-- Use PATCH for updates --}}

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title (Optional)</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="A catchy title for your post" value="{{ old('title', $post->title) }}">
                </div>
                @error('title')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="body" class="block text-sm font-medium leading-6 text-gray-900">Edit your thoughts...</label>
                <div class="mt-2">
                    <textarea id="body" name="body" rows="6" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required placeholder="Share your thoughts here...">{{ old('body', $post->body) }}</textarea>
                </div>
                @error('body')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-x-4">
                <a href="{{ route('posts.show', $post) }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</x-layout>
