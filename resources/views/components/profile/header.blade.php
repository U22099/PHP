@props(['user'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 bg-white border-b border-gray-200 flex flex-col sm:flex-row items-center sm:justify-between">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            {{-- asset('storage/' . $user->image) --}}
            <img class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500"
                src="{{ $user->image ? $user->image : 'https://ui-avatars.com/api/?name=' . urlencode($user->firstname . ' ' . $user->lastname) . '&color=FFFFFF&background=312e81' }}"
                alt="{{ $user->username }}">
            <div>
                <h1 class="flex gap-1 items-center text-2xl md:text-3xl font-extrabold text-gray-900">
                    {{ $user->firstname }}
                    {{ $user->lastname }}
                    @if ($user->is_premium)
                        <x-heroicon-s-check-badge class="h-8 w-8 text-blue-500" />
                    @endif
                </h1>
                <p class="text-lg text-gray-600">&#64;{{ $user->username }}</p>
                <p class="text-md font-medium text-indigo-700 capitalize">{{ $user->role }}</p>
                <p class="text-md font-medium {{ $user->is_premium ? 'text-indigo-600' : 'text-gray-600' }} capitalize">
                    Plan: <a href="/subscription"
                        class="font-bold underline">{{ $user->is_premium ? 'Premium User' : 'Basic Plan' }}</a>
                </p>
            </div>
        </div>
        @if (Auth::user()->id === $user->id)
            <div class="flex lg:flex-col flex-row lg:space-y-3 lg:space-x-0 space-y-0 space-x-4">
                <x-button @click="showEditProfileModal = true;">
                    <x-heroicon-s-pencil class="-ml-1 mr-2 h-5 w-5" />
                    Edit Profile
                </x-button>
                <form method="POST" action="/logout" class="flex lg:justify-end lg:self-end">
                    @csrf
                    <x-button type="submit"
                        class="bg-transparent hover:!border-indigo-400 !transition-colors !duration-200 hover:!bg-transparent !text-gray-800 !border-gray-400 !shadow-none lg:self-end">
                        <x-gravityui-arrow-right-from-square class="-ml-1 mr-2 h-5 w-5 text-gray-500" />
                        Logout
                    </x-button>
                </form>
            </div>
        @endif
    </div>
</div>
