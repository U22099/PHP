<x-layout>
    <x-slot:title>
        Jobs: {{ $job->title }}
    </x-slot:title>

    <x-slot:heading>
        {{ $job->title }}
    </x-slot:heading>

    <x-slot:headerbutton>
        <div class="flex gap-2 items-center">
            <div class="hidden lg:flex mr-2">
                <x-button type="link" href="/jobs/{{ $job->id }}/bids" class="capitalize">
                    View Proposals
                </x-button>
            </div>
            @can('update', $job)
                <x-button type="link" href="/jobs/{{ $job->id }}/edit" class="capitalize">
                    Edit Job
                </x-button>
            @endcan
        </div>
    </x-slot:headerbutton>

    @section('social_meta_tags')
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ route('jobs.show', $job) }}">
        <meta property="og:title" content="{{ $job->user->username }}">
        <meta property="og:description" content="{{ Str::limit($job->description, 150) }}">
        <meta property="og:image" content="{{ $job->images ? $job->images[0] : $job->user->image }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <meta name="twitter:title" content="{{ $job->user->username }}">
        <meta name="twitter:description" content="{{ Str::limit($job->description, 150) }}">
        <meta name="twitter:image" content="{{ $job->images ? $job->images[0] : $job->user->image }}">
    <meta name="twitter:image:width" content="1200">
    <meta name="twitter:image:height" content="630">
    @endsection

    {{-- Job Information --}}
    <div class="border rounded-xl p-8 md:p-10 lg:p-12">
        <!-- Employer and Salary Section -->
        <div class="flex items-center mb-8 pb-6 border-b border-gray-100 w-full">
            <span
                class="flex flex-wrap sm:items-center rounded-md bg-green-50 px-4 py-2 text-md lg:text-xl font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                Pays {{ $job->currency->symbol }}
                <span>
                    @if ($job->min_budget === $job->max_budget)
                        {{ Number::abbreviate($job->min_budget, 1) }}
                    @else
                        {{ Number::abbreviate($job->min_budget, 1) }} -
                        {{ Number::abbreviate($job->max_budget, 1) }}
                    @endif
                </span>
                <span class="ml-2">in
                    <span>
                        {{ $job->time_budget }} {{ str('day')->plural($job->time_budget) }}
                        @if ($job->time_budget > 7)
                            <span class="text-gray-500 font-medium text-sm">
                                (&#8776;
                                {{ \Carbon\Carbon::now()->addDays($job->time_budget)->diffForHumans(null, true) }})
                            </span>
                        @endif
                    </span>
                </span>
            </span>
        </div>

        <!-- Job Description Section -->
        <div class="mt-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h3>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-2 text-justify">
                @if ($job->description)
                    {{ $job->description }}
                @else
                    <p>This exciting role offers a unique opportunity to contribute to a dynamic team. We are looking
                        for passionate individuals who are eager to grow, innovate, and make a significant impact.
                        Responsibilities include collaborative problem-solving, efficient project execution, and
                        continuous learning within a supportive environment. Join us and shape the future!</p>
                @endif
                @if (!empty($job->images))
                    <h1 class="text-lg font-bold text-gray-500 mt-3 mb-4">Project Screenshots</h1>
                    <x-image-gallery :images="$job->images" />
                @endif
            </div>
            <p class="mt-4 text-gray-500 text-sm italic">
                *Specific responsibilities and qualifications may be detailed above or upon application.
            </p>
        </div>

        <!-- Tags Section -->
        @if ($job->tags->isNotEmpty())
            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Key Skills Needed</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($job->tags as $tag)
                        <a
                            href="/jobs?tags[]={{ $tag->name }}"
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-200">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Bidding Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mt-8">
        <x-bids.create-bid :job="$job" />
        <x-bids.bids-info :job="$job" />
    </div>

</x-layout>
