<x-layout>
    <x-slot:title>
        Contact Us
    </x-slot:title>

    <x-slot:heading>
        Get in Touch
    </x-slot:heading>

    <div class="border rounded-xl p-8 md:p-12 lg:p-16 mb-8 max-w-4xl mx-auto">
        <p class="text-lg text-gray-700 leading-relaxed mb-10 text-center md:text-left">
            Have a question, a project idea, a new feature you'd like to request or just want to say hello? We'd love to
            hear from you! Fill out the form below or reach out directly using the contact details provided.
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                <form action="/contact" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                        <input type="text" name="name" id="name" autocomplete="name"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            value="{{ Auth::user() ? Auth::user()->firstname . ' ' . Auth::user()->lastname : null }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" autocomplete="email"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            value="{{ Auth::user() ? Auth::user()->email : null }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                        <textarea id="message" name="message" rows="3"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            placeholder="Tell us about your desired feature, project idea or inquiry..."></textarea>
                    </div>
                    @if (session('success'))
                        <x-alert type="success">
                            {{ session('success') }}
                        </x-alert>
                    @endif
                    <div class="flex justify-end">
                        <x-button type="submit"
                            disabled='{{ !Auth::user() || Auth::user()->last_dev_contact < Illuminate\Support\Carbon::now()->subWeek() }}'
                            class="disabled:opacity-50 disabled:cursor-not-allowed">
                            Send Message
                            <x-heroicon-s-paper-airplane class="ml-3 -mr-1 h-5 w-5" />
                        </x-button>
                    </div>
                </form>
            </div>

            <!-- Contact Information Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Our Contact Details</h2>
                <div class="space-y-6 text-gray-700 text-lg">
                    <div class="flex items-start">
                        <x-heroicon-o-envelope class="flex-shrink-0 h-7 w-7 text-indigo-600 mr-4" />
                        <div>
                            <span class="font-semibold text-gray-900">Email:</span><br>
                            <a href="mailto:{{ env('DEV_EMAIL', 'info@example.com') }}"
                                class="text-indigo-600 hover:underline">{{ env('DEV_EMAIL', 'info@example.com') }}</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <x-heroicon-o-phone class="flex-shrink-0 h-7 w-7 text-indigo-600 mr-4" />
                        <div>
                            <span class="font-semibold text-gray-900">Phone:</span><br>
                            <a href="tel:+1234567890"
                                class="text-indigo-600 hover:underline">{{ env('DEV_PHONE_NO', 'info@example.com') }}</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <x-heroicon-o-map-pin class="flex-shrink-0 h-7 w-7 text-indigo-600 mr-4" />
                        <div>
                            <span class="font-semibold text-gray-900">Address:</span><br>
                            123 Main Street, Suite 456<br>
                            Tech City, State, 12345
                        </div>
                    </div>
                </div>

                <!-- Optional: Social Media Links -->
                <div class="mt-10 pt-6 border-t border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Connect With Us</h3>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition duration-200">
                            <x-heroicon-o-face-smile class="h-8 w-8" />
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition duration-200">
                            <x-heroicon-o-sparkles class="h-8 w-8" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
