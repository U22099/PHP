<x-layout>
    <x-slot:heading>
        Edit Article
    </x-slot:heading>

    <form method="POST" action="/articles/{{ $article->id }}">
        @csrf
        @method('PATCH')

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Edit {{ $article->title }}</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                        <div class="mt-2">
                            <div
                                class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="title" id="title"
                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                    placeholder="Software Engineer" value="{{ old('title') ?? $article->title }}"
                                    required>
                            </div>
                            @error('title')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="body"
                            class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea id="body" name="body" rows="6"
                                class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                required>{{ old('body') ?? $article->body }}</textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the article
                            requirements
                            and responsibilities.</p>
                        @error('body')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between px-2 w-full">
            <x-button type="button" form="delete-form"
                class="text-sm font-semibold leading-6 text-red-600">Delete</x-button>
            <div class="flex items-center justify-end gap-x-6">
                <x-button type="link" href="/articles/{{ $article->id }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</x-button>
                <x-button type="submit">Save</x-button>
            </div>
        </div>
    </form>
    <form method="POST" action="/articles/{{ $article->id }}" id="delete-form" hidden>
        @csrf
        @method('DELETE')
    </form>
</x-layout>
