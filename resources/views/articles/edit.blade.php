<x-layout>
    <x-slot:title>
        Edit Article:- {{ $article->title }}
    </x-slot:title>

    <x-slot:heading>
        Edit Article
    </x-slot:heading>

    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <form method="POST" action="/articles/{{ $article->id }}">
            @csrf
            @method('PATCH')

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
                        <x-markdown-editor rootClass="col-span-full" fieldname="body" label="Article Body"
                            class="w-full h-[650px]" :data="$article->body">
                            @error('body')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-markdown-editor>
                        <div class="col-span-full">
                            <x-searchable-input name="tags" label="Articles Tags" placeholder="Add Article Tags..."
                                :initialItems="old('tags', $article->tags->pluck('name')->toArray())" :availableItems="$availableTags" placeholder="Add tags" />
                            @error('tags')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between px-2 w-full">
                <x-button type="button" form="delete-form" class="text-sm font-semibold leading-6">Delete</x-button>
                <div class="flex items-center justify-end gap-x-6">
                    <x-button type="link" href="/articles/{{ $article->id }}"
                        class="text-sm font-semibold leading-6">Cancel</x-button>
                    <x-button type="submit">Save</x-button>
                </div>
            </div>
        </form>
        <form method="POST" action="/articles/{{ $article->id }}" id="delete-form" hidden>
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-layout>
