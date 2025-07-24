<!-- resources/views/posts/create.blade.php -->
<x-layout>
    <x-slot:heading>
        Create New Post
    </x-slot:heading>

    <div class="max-w-xl mx-auto py-4 p-2">
        <form method="POST" action="{{ route('posts.store') }}" class="border rounded-lg p-6">
            @csrf

            <div class="mb-6">
                <label for="body" class="block text-sm font-medium leading-6 text-gray-900">What's on your
                    mind?</label>
                <div class="mt-2">
                    <textarea id="body" name="body" rows="6"
                        class="block w-full rounded-md p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 border"
                        required placeholder="Share your thoughts here...">{{ old('body') }}</textarea>
                </div>
                @error('body')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-x-4">
                <a href="{{ route('posts.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</x-layout>
