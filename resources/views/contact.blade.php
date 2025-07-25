<x-layout>
    <x-slot:heading>
        Get in Touch
    </x-slot:heading>

    <div class="border rounded-xl p-8 md:p-12 lg:p-16 mb-8 max-w-4xl mx-auto">
        <p class="text-lg text-gray-700 leading-relaxed mb-10 text-center md:text-left">
            Have a question, a project idea, or just want to say hello? We'd love to hear from you! Fill out the form
            below or reach out directly using the contact details provided.
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                        <input type="text" name="name" id="name" autocomplete="name"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" autocomplete="email"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                        <textarea id="message" name="message" rows="3"
                            class="block w-full rounded-md border-b-2 border-b-gray-300 shadow-sm focus:border-b-gray-700 focus:outline-none sm:text-base p-3"
                            placeholder="Tell us about your project or inquiry..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Send Message
                             <x-heroicon-s-paper-airplane class="ml-3 -mr-1 h-5 w-5" />
                        </button>
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
                            <a href="mailto:info@example.com"
                                class="text-indigo-600 hover:underline">info@example.com</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <x-heroicon-o-phone class="flex-shrink-0 h-7 w-7 text-indigo-600 mr-4" />
                        <div>
                            <span class="font-semibold text-gray-900">Phone:</span><br>
                            <a href="tel:+1234567890" class="text-indigo-600 hover:underline">+1 (234) 567-890</a>
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
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition duration-200">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M19.812 5.054c.94-.27 1.88.077 2.464.838.307.38.506.843.585 1.354a4.425 4.425 0 01.026.47c0 2.875-.028 5.75-.028 8.625 0 .26-.002.52-.002.78a4.4 4.4 0 01-4.325 4.417 4.4 4.4 0 01-4.425-4.417c0-.26.002-.52.002-.78 0-2.875.028-5.75.028-8.625a4.425 4.425 0 01-.026-.47 4.195 4.195 0 01-.585-1.354c-.584-.76-1.524-1.108-2.464-.838l-7.79 2.235c-.94.27-1.58.995-1.706 1.916-.126.92.203 1.838.83 2.536l.298.337c.594.67 1.344 1.155 2.152 1.423.808.267 1.666.36 2.525.275l.39-.036c.86-.085 1.67-.384 2.37-.872l.46-.316c.7-.488 1.25-.853 1.63-.997.38-.144.75-.144 1.13 0 .38.144.75.51 1.13.997l.46.316c.7.488 1.51.787 2.37.872l.39.036c.86.085 1.717-.008 2.525-.275.808-.268 1.558-.753 2.152-1.423l.298-.337c.627-.698.956-1.616.83-2.536-.126-.92-.766-1.646-1.706-1.916l-7.79-2.235zM12 11a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <!-- Add more social icons like LinkedIn, GitHub, etc. -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
