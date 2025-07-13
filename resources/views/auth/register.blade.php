<x-layout>
    <x-slot:heading>
        Log In
    </x-slot:heading>

    <form method="POST" action="/register"
        class="border-b border-gray-900/10 flex flex-col gap-2 pb-4 w-full md:w-2/3 lg:w-2/6 justicy-start items-center mx-auto">
        @csrf

        <div class="space-y-4 w-full">
            <div class="w-full">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Welcome To Laravel Test</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Fill in the form to register.</p>

                <div class="mt-10 flex gap-3 flex-col justify-start items-center w-full">
                    <x-form-field class="w-full" fieldname="username" placeholder="John Doe" required />
                    <x-form-field class="w-full" fieldname="email" placeholder="johndoe@gmail.com" required />
                    <x-form-field type="password" fieldname="password" placeholder="password" required />
                    <x-form-field type="password" label="confirm password" fieldname="password_confirmation"
                        placeholder="retype password" required />
                </div>
            </div>
        </div>
        <div class="mt-6 flex flex-col items-center justify-end w-full">
            <x-button type="submit" addclass="w-full justify-center">Register</x-button>
        </div>
        <a href="/login" class="text-xs font-semibold text-gray-400">Already have an account? <span
                class="text-blue-500">Log In</span></a>

    </form>
</x-layout>
