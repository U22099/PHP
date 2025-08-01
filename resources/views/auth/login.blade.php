<x-layout>
    <x-slot:title>
        Log In
    </x-slot:title>

    <x-slot:heading>
        Log In
    </x-slot:heading>

    <form method="POST" action="/login"
        class="border-b border-gray-900/10 flex flex-col gap-2 p-4 w-full md:w-2/3 lg:w-2/6 justicy-start items-center mx-auto">
        @csrf

        <div class="space-y-4 w-full">
            <div class="w-full">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Welcome Back</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Enter your credentials below to log in.</p>

                <div class="mt-10 flex gap-3 flex-col justify-start items-center w-full">
                    <x-form-field class="w-full" fieldname="email" placeholder="example@gmail.com" required>
                        <x-slot:icon>
                            <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" /> {{-- Added Email icon --}}
                        </x-slot:icon>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>
                    <x-form-field type="password" fieldname="password" placeholder="password" required>
                        <x-slot:icon>
                            <button type="button" @click="togglePasswordVisibility()"
                                class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <template x-if="!showPassword">
                                    <x-heroicon-o-eye class="h-5 w-5" />
                                </template>
                                <template x-if="showPassword">
                                    <x-heroicon-o-eye-slash class="h-5 w-5" />
                                </template>
                            </button>
                        </x-slot:icon>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>
                </div>
            </div>
        </div>
        <div class="mt-6 flex flex-col items-center justify-end w-full">
            <x-button type="submit" class="w-full justify-center">Log In</x-button>
        </div>
        <a href="/register" class="text-xs font-semibold text-gray-400">Don't have an account? <span
                class="text-blue-500">Register</span></a>

    </form>
</x-layout>
