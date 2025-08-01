<x-layout>
    <x-slot:title>
        New Project
    </x-slot:title>

    <x-slot:heading>
        Create New Project
    </x-slot:heading>


    <div class="w-full px-4 py-8">
        <div class="max-w-7xl mx-auto border rounded-lg overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-6">Create Project</h1>

            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                {{-- Project Title --}}
                <div class="mb-4">
                    <x-form-field fieldname="title" label="Project Title" />
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Description (Markdown Editor) --}}
                <div class="mb-4">
                    <x-markdown-editor fieldname="description" label="Project Description" />
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Link --}}
                <div class="mb-4">
                    <x-form-field fieldname="link" label="Project Link" type="url" />
                    @error('link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Stacks --}}
                <div class="mb-4">
                    <x-searchable-input name="stacks" label="Project Stacks" placeholder="Add Project Stacks..."
                        :availableItems="$availableStacks" :initialItems="[]" />
                    @error('stacks')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Images (You might need a more complex component for image uploads/management) --}}
                {{-- For now, we'll just display the existing image paths --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium leading-6 text-gray-900 capitalize">Existing Images</label>
                    <div class="mt-2">
                        {{-- @if ($project->images)
                            <x-carousel :width="192">
                                @foreach ($project->images as $image)
                                    <img src="{{ $image }}" alt="images"
                                        class="w-48 h-full object-cover rounded-lg" />
                                    <input type="text" name="images[]" id="images" value="{{ $image }}" hidden>
                                @endforeach
                            </x-carousel>
                        @else
                            <p class="text-gray-500">No images uploaded yet.</p>
                        @endif --}}
                    </div>
                    {{-- You would typically have an input for new image uploads here --}}
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex w-full justify-end">
                    <x-button type="submit">
                        Update Project
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
