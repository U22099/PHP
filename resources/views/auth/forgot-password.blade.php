<x-layout>
    <x-slot:title>
        Forget Password
    </x-slot:title>

    <x-slot:heading>
        Forget Password
    </x-slot:heading>

    <form method="POST" action="/forgot-password"
        class="border-b border-gray-900/10 flex flex-col gap-2 p-4 w-full md:w-2/3 lg:w-2/6 justicy-start items-center mx-auto">
        @csrf

        <div class="space-y-4 w-full">
            <div class="w-full">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Can't remember your password?</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Enter your account's email below to get a password reset
                    email.</p>

                <div class="mt-10 flex gap-3 flex-col justify-start items-center w-full">
                    <x-form-field class="w-full" fieldname="email" placeholder="example@gmail.com" required>
                        <x-slot:icon>
                            <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" /> {{-- Added Email icon --}}
                        </x-slot:icon>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>
                </div>
            </div>
        </div>
        <div class="mt-6 flex flex-col items-center justify-end w-full">
            <x-button type="submit" class="w-full justify-center">Get Password Reset Link</x-button>
        </div>
        <a href="/login" class="text-xs font-semibold text-gray-400">I've remembered my password? <span
                class="text-blue-500">Login</span></a>

    </form>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000);
        showEditProfileModal = false"
            class="absolute bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000);
        showEditProfileModal = false"
            class="absolute bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</x-layout>
