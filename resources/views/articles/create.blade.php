<x-layout>
    <x-slot:title>
        Create New Article
    </x-slot:title>

    <x-slot:heading>
        Create Article
    </x-slot:heading>

    <div class="bg-white border rounded-lg px-4 py-5 sm:p-6">
        <form method="POST" action="/articles">
            @csrf

            <div class="space-y-12 p-2">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Create a New Article</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <x-form-field rootClass="sm:col-span-4" class="w-full" fieldname="title"
                            placeholder="How to build a laravel app" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-form-field>

                        <x-markdown-editor rootClass="col-span-full" :characterLimit="Auth::user()->is_premium
                            ? env('ARTICLE_BODY_LIMIT_PER_USER_PREMIUM')
                            : env('ARTICLE_BODY_LIMIT_PER_USER')" fieldname="body"
                            label="Article Body" class="w-full h-[650px]">
                            @error('body')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </x-markdown-editor>

                        <div class="col-span-full">
                            <x-searchable-input name="tags" label="Articles Tags" placeholder="Add Article Tags..."
                                :initialItems="old('tags', [])" :availableItems="$availableTags" placeholder="Add tags" />
                            @error('tags')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-button type="link" href="/articles"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</x-button>
                <x-button type="submit">Save</x-button>
            </div>
        </form>
    </div>
</x-layout>
