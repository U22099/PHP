<x-layout>
    <x-slot:title>
        {{ $project->title }}
    </x-slot:title>

    <x-slot:heading>
        Project By @<span>{{ $project->user->username }}</span>
    </x-slot:heading>

    <x-slot:headerbutton>
        @auth
            <x-button type="link"
                href="/{{ Auth::user()->id === $project->user_id ? 'profile' : $project->user->username }}?tabs=projects">
                <x-heroicon-o-arrow-left class="h-5 w-5 mr-2 text-white" />
                Go Back
            </x-button>
        @endauth
    </x-slot:headerbutton>

    <div class="w-full px-4 py-8">
        <div class="max-w-7xl mx-auto border rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="h-48 lg:h-full lg:col-span-1">
                    <img class="h-full w-full object-cover object-center"
                        src="{{ count($project->images) === 0 ? 'https://ui-avatars.com/api/?name=' . urlencode($project->title) . '&background=random&color=fff&size=40' : $project->images[0] }}"
                        alt="Project main image">
                </div>
                <div class="p-8 w-full lg:col-span-1">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Project</div>
                    <h1 class="block mt-1 leading-tight font-medium text-black text-2xl">{{ $project->title }}</h1>
                    <div class="mt-2 text-gray-500">{!! $project->description !!}</div>

                    {{-- Project Stacks --}}
                    @if ($project->stacks)
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Stacks:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($project->stacks as $stack)
                                    <span
                                        class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">{{ $stack->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($project->link)
                        <div class="mt-4">
                            <a href="{{ $project->link }}" class="text-indigo-600 hover:text-indigo-900"
                                target="_blank">View Project</a>
                        </div>
                    @endif

                    @if ($project->images)
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Gallery</h3>
                            <x-image-gallery :images="$project->images" />
                        </div>
                    @endif

                    <div class="mt-8 flex items-center justify-between">
                        <div class="text-gray-500 text-sm">
                            Created: {{ $project->created_at->format('M d, Y') }}
                        </div>
                        @auth
                            @if (Auth::user()->id === $project->user_id)
                                <x-button href="/profile/projects/{{ $project->id }}/edit" type="link">Edit</x-button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
