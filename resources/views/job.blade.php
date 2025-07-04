<x-layout>
    <x-slot:heading>
        {{ $job->name }}
    </x-slot:heading>

    <div class="bg-white shadow-lg rounded-xl p-8 md:p-10 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <p class="text-2xl font-semibold text-green-700">
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-4 py-2 text-xl font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                    Pays {{ $job->salary }} per year
                </span>
            </p>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h3>
            <p class="text-gray-700 leading-relaxed text-lg">
                <!-- Placeholder for actual job description. You'd typically have a $job->description here -->
                This exciting role offers a unique opportunity to contribute to a dynamic team. We are looking for
                passionate individuals who are eager to grow, innovate, and make a significant impact. Responsibilities
                include collaborative problem-solving, efficient project execution, and continuous learning within a
                supportive environment. Join us and shape the future!
            </p>
            <p class="mt-4 text-gray-500 text-sm">
                *Specific responsibilities and qualifications available upon application.
            </p>
        </div>
    </div>

    <div class="flex justify-end mt-8">
        <a href="/jobs"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to Job Listings
        </a>
    </div>
</x-layout>
