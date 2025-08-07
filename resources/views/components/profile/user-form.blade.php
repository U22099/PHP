@props(['user'])

<form method="POST" enctype="multipart/form-data" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="space-y-4">
        <x-form-field class="w-full" fieldname="firstname" :data="$user->firstname" required>
            <x-slot:icon>
                <x-heroicon-o-user class="h-5 w-5 text-gray-400" />
            </x-slot:icon>
            @error('firstname')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </x-form-field>

        <x-form-field class="w-full" fieldname="lastname" :data="$user->lastname" required>
            <x-slot:icon>
                <x-heroicon-o-user class="h-5 w-5 text-gray-400" />
            </x-slot:icon>
            @error('lastname')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </x-form-field>

        <x-form-field class="w-full" fieldname="username" :data="$user->username" required>
            <x-slot:icon>
                <x-heroicon-o-at-symbol class="h-5 w-5 text-gray-400" />
            </x-slot:icon>
            @error('username')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </x-form-field>

        <x-form-field class="w-full" fieldname="email" :data="$user->email" required>
            <x-slot:icon>
                <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
            </x-slot:icon>
            @error('email')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </x-form-field>

        {{-- Image Upload (Optional) --}}
        {{-- Uncomment and adjust if you handle image uploads with a file input --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="button" @click="showEditProfileModal = false;"
                class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </button>
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Changes
            </button>
        </div>
    </div>
</form>
