<x-layout>
    <x-slot:title>
        Edit Post: {{ $post->id }}
    </x-slot:title>

    <x-slot:heading>
        Edit Post
    </x-slot:heading>

    <div class="max-w-xl mx-auto py-4 p-2">
        <form method="POST" action="{{ route('posts.update', $post) }}" class="border rounded-lg p-6">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <x-multi-image-upload label="Add Images" name="images" :initialUrls="old('images', $post->images)" :initialPublicIds="old('publicIds', $post->public_ids)"
                    :isPremium="Auth::user()->is_premium">
                    <div>
                        @error('images')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('publicIds')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('publicIds.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </x-multi-image-upload>
            </div>

            <div class="mb-6">
                <x-form-field rootClass="w-full" fieldname="body" label="Edit your post" :textarea="true"
                    :rows="6" :characterLimit="Auth::user()->is_premium ? env('POST_BODY_LIMIT_PER_USER_PREMIUM') : env('POST_BODY_LIMIT_PER_USER')" placeholder="Share your thoughts here..." data="{{ $post->body }}" required>
                    @error('body')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>
            </div>

            <div class="flex items-center justify-end gap-x-4">
                <a href="{{ route('posts.show', $post) }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</x-layout>
