<x-layout>
    <x-slot:heading>
        {{ $job->title }}
    </x-slot:heading>
    <x-slot:headerbutton>
        @can('update', $job)
            <x-button type="link" href="/jobs/{{ $job->id }}/edit" class="capitalize">
                Edit Job
            </x-button>
        @endcan
    </x-slot:headerbutton>

    <div class="border rounded-xl p-8 md:p-10 lg:p-12 mb-8">
        <!-- Employer and Salary Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 pb-6 border-b border-gray-100">
            <div>
                @if ($job->user)
                    {{-- Ensure user exists before trying to access it --}}
                    <p class="text-lg text-gray-600 font-medium mb-1">
                        Offered by: <span class="text-indigo-600 font-bold">{{ $job->user->name }}</span>
                    </p>
                @endif
                <p class="text-2xl font-semibold text-green-700">
                    <span
                        class="inline-flex items-center rounded-md bg-green-50 px-4 py-2 text-xl font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        Pays {{ $job->salary }}
                    </span>
                </p>
            </div>

            {{-- Optional: Add a company logo here if you have one --}}
            {{--
            @if ($job->user && $job->user->logo_url)
                <img src="{{ $job->user->logo_url }}" alt="{{ $job->user->name }} Logo" class="h-20 w-auto mt-4 sm:mt-0 sm:ml-6">
            @endif
            --}}
        </div>

        <!-- Job Description Section -->
        <div class="mt-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h3>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-6 text-justify">
                <!-- Assuming $job->description exists and is the full content -->
                @if ($job->description)
                    {!! nl2br(e($job->description)) !!} {{-- Use nl2br and escape for safety, or {!! $job->description !!} if already sanitized HTML --}}
                @else
                    <p>This exciting role offers a unique opportunity to contribute to a dynamic team. We are looking
                        for passionate individuals who are eager to grow, innovate, and make a significant impact.
                        Responsibilities include collaborative problem-solving, efficient project execution, and
                        continuous learning within a supportive environment. Join us and shape the future!</p>
                @endif
                @if (!empty($job->screenshots))
                    <h1 class="text-lg font-bold text-gray-500 mt-3 mb-8">Project Screenshots</h1>
                    <x-image-display :images="$job->screenshots" />
                @endif
            </div>
            <p class="mt-4 text-gray-500 text-sm italic">
                *Specific responsibilities and qualifications may be detailed above or upon application.
            </p>
        </div>

        <!-- Tags Section -->
        @if ($job->tags->isNotEmpty())
            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Key Skills & Tags</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($job->tags as $tag)
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-200">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="flex justify-start mt-8">
        <x-button type="link" href="/jobs">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to Job Listings
        </x-button>
    </div>
</x-layout>
