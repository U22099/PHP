<!-- resources/views/components/project/card.blade.php -->
@props(['project', 'showEditProjectModal', 'editingProject']) {{-- showEditProjectModal and editingProject are Alpine.js refs from parent --}}

<div
    class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer">
    <div class="flex-grow mb-2">
        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $project->title }}</h3>
        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $project->description }}</p>
        <a href="{{ $project->link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            View Project Link
            <svg class="inline-block w-4 h-4 ml-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
        </a>

        {{-- Image Display Component --}}
        @if (!empty($project->images))
            <div class="mt-4">
                {{-- Pass the PHP $project->images directly to the component --}}
                <x-image-display type="project" :images="$project->images" />
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-2 justify-end mx-auto lg:mx-0">
        <button @click="editingProject = @js($project); showProjectFormModal = true;"
            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z">
                </path>
            </svg>
            Edit
        </button>
        <button
            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 00-.5-.5H11V4.5a.5.5 0 00-1 0V7H6.5a.5.5 0 000 1H9v2.5a.5.5 0 001 0V8h2.5a.5.5 0 00.5-.5z"
                    clip-rule="evenodd"></path>
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM.7 10a9.3 9.3 0 1118.6 0 9.3 9.3 0 01-18.6 0z"></path>
            </svg>
            Share
        </button>
        <form method="POST" action="/projects/{{ $project->id }}"
            onsubmit="return confirm('Are you sure you want to delete this project?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Delete
            </button>
        </form>
    </div>
</div>
