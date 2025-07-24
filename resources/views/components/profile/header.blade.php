@props(['user'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 bg-white border-b border-gray-200 flex flex-col sm:flex-row items-center sm:justify-between">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            {{-- asset('storage/' . $user->image) --}}
            <img class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500"
                src="{{ $user->image ? $user->image : 'https://ui-avatars.com/api/?name=' . urlencode($user->firstname . ' ' . $user->lastname) . '&color=FFFFFF&background=312e81' }}"
                alt="{{ $user->username }}">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $user->firstname }}
                    {{ $user->lastname }}</h1>
                <p class="text-lg text-gray-600">@ {{ $user->username }}</p>
                <p class="text-md font-medium text-indigo-700 capitalize">{{ $user->role }}</p>
            </div>
        </div>
        <div class="flex lg:flex-col flex-row lg:space-y-3 lg:space-x-0 space-y-0 space-x-4">
            <x-button @click="showEditProfileModal = true;">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                </svg>
                Edit Profile
            </x-button>
            <form method="POST" action="/logout" class="flex lg:justify-end lg:self-end">
                @csrf
                <x-button type="submit"
                    class="bg-transparent hover:!border-indigo-400 !transition-colors !duration-200 hover:!bg-transparent !text-gray-800 !border-gray-400 !shadow-none lg:self-end">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-2 0V4H5v2a1 1 0 01-2 0V3zm9 7a1 1 0 01.707 1.707L10 14.414l-2.707-2.707A1 1 0 017 11v-1a1 1 0 112 0v1.586l1.707-1.707A1 1 0 0112 10z"
                            clip-rule="evenodd" />
                    </svg>
                    Logout
                </x-button>
            </form>
        </div>
    </div>
</div>
