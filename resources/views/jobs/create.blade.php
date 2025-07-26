<x-layout>
    <x-slot:title>
        Create New Job
    </x-slot:title>

    <x-slot:heading>
        Create Job
    </x-slot:heading>

    <form method="POST" action="/jobs">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Create a New Job Listing</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form-field rootClass="sm:col-span-4" class="w-full" fieldname="title" placeholder="Software Engineer" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>

                    <x-form-field rootClass="sm:col-span-4" class="w-full" fieldname="salary" label="Salary (e.g.,
                            $50,000)" placeholder="$50,000" required>
                        @error('salary')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>

                    <div class="col-span-full">
                        <label for="description"
                            class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea id="description" name="description" rows="4"
                                class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                required>{{ old('description') }}</textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the job requirements
                            and responsibilities.</p>
                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full">
                        <x-tags-input name="tags" label="Articles Tags" :initial-tags="old('tags', [])" :available-tags="$availableTags" placeholder="Add tags" />
                        @error('tags')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <x-button type="link" href="/jobs"
                class="text-sm font-semibold leading-6 text-gray-900">Cancel</x-button>
            <x-button type="submit">Save</x-button>
        </div>
    </form>
</x-layout>
