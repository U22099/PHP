<x-layout>
    <x-slot:title>
        {{ $project->title }}
    </x-slot:title>

    <x-slot:heading>
        Edit: {{ $project->title }}
    </x-slot:heading>


    <div class="w-full px-4 py-8">
        <div class="max-w-7xl mx-auto border rounded-lg overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Project</h1>

            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Project Title --}}
                <div class="mb-4">
                    <x-form-field fieldname="title" label="Project Title" :data="$project->title" />
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Description (Markdown Editor) --}}
                <div class="mb-4">
                    <x-markdown-editor fieldname="description" label="Project Description" :data="$project->description" />
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Link --}}
                <div class="mb-4">
                    <x-form-field fieldname="link" label="Project Link" :data="$project->link" type="url" />
                    @error('link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Stacks --}}
                <div class="mb-4">
                    <x-searchable-input name="stacks" label="Project Stacks" placeholder="Add Project Stacks..."
                        :availableItems="$availableStacks" :initialItems="old('stacks', $project->stacks->pluck('name')->toArray())" />
                    @error('stacks')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-multi-image-upload label="Add Images" name="images" :initialUrls="old('images', $project->images)" :initialPublicIds="old('publicIds', $project->public_ids)"
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

                <div class="mt-6 flex w-full justify-end">
                    <x-button type="submit">
                        Update Project
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
