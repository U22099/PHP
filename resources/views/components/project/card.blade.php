@props(['project', 'user_id'])

<div
    class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer">
    <div class="flex-grow mb-2"
        @click="window.location.href = '/{{ Auth::user()->id === $user_id ? 'profile' : Auth::user()->username }}/projects/{{ $project->id }}';">
        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $project->title }}</h3>
        <div class="text-gray-600 text-sm mb-2 line-clamp-3">{{ strip_tags($project->description) }}</div>
        <a href="{{ $project->link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            View Project Link
            <x-heroicon-o-link class="inline-block w-4 h-4 ml-1 -mt-0.5" />
        </a>


        @if (!empty($project->images))
            <div class="mt-4">
                <x-image-gallery :images="$project->images" image_height="h-32" />
            </div>
        @endif
    </div>

    @if (Auth::user()->id === $user_id)
        <div class="flex flex-wrap gap-2 justify-end mx-auto lg:mx-0">
            <button @click="window.location.href = '/profile/projects/{{ $project->id }}/edit';"
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <x-heroicon-o-pencil class="w-4 h-4 mr-1" />
                Edit
            </button>
            <button
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <x-heroicon-o-share class="w-4 h-4 mr-1" />
                Share
            </button>
            <form method="POST" action="/projects/{{ $project->id }}"
                onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                    Delete
                </button>
            </form>
        </div>
    @endif
</div>
