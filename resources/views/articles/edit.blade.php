<x-layout>
    <x-slot:title>
        Edit Article: {{ $article->title }}
    </x-slot:title>

    <x-slot:heading>
        Edit Article
    </x-slot:heading>

    <form method="POST" action="/articles/{{ $article->id }}">
        @csrf
        @method('PUT')

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Edit {{ $article->title }}</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form-field rootClass="sm:col-span-4" class="w-full" fieldname="title"
                        placeholder="How to build a laravel app" data="{{ $article->title }}" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>

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

                    <div class="col-span-full">
                        <x-tags-input name="tags" label="Articles Tags" :initial-tags="old('tags', $article->tags->pluck('name')->toArray())" :available-tags="$availableTags"
                            placeholder="Add tags" />
                        @error('tags')
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
