@props(['edit' => false, 'availableTags'])

<form method="POST" x-bind:action="editingProject ? '/projects/' + editingProject.id : '/projects'" class="space-y-4">
    @csrf
    @if ($edit)
        @method('PUT')
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Project Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', '') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
        @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>{{ old('description', '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="link" class="block text-sm font-medium text-gray-700">Project Link (URL)</label>
        <input type="url" name="link" id="link" value="{{ old('link', '') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
        @error('link')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Image Uploads for Projects (Complex, will require specific JS for multi-upload/preview) --}}
    {{-- For simplicity, let's assume images are handled separately or as URLs.
         If you need a true multi-image uploader, consider a Livewire component or dedicated JS library. --}}
    <div>
        <label for="images" class="block text-sm font-medium text-gray-700">Project Images (JSON Array of
            URLs)</label>
        <input type="text" name="images" id="images" value="{{ old('images', '[]') }}"
            placeholder='e.g., ["http://example.com/img1.jpg", "http://example.com/img2.png"]'
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        @error('images')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-full">
        <x-tags-input name="tags" label="Projects Stacks" :initial-tags="old('tags', [])" :available-tags="$availableTags"
            placeholder="Add tags" />
        @error('tags')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-200">
        <button type="button" @click="showEditProjectModal = false"
            class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cancel
        </button>
        <x-button type="submit" x-text="editingProject ? 'Update Project' : 'Add Project' ">
        </x-button>
    </div>
</form>
