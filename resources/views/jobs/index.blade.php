<x-layout>
    <x-slot:title>
        Jobs
    </x-slot:title>

    <x-slot:heading>
        Available Positions
    </x-slot:heading>

    <x-slot:headerbutton>
        @can('create', \App\Models\Job::class)
            <x-button type="link" href="/jobs/create" class="capitalize">
                Create Job
            </x-button>
        @endcan
    </x-slot:headerbutton>

    <div class="pt-2 not-even:py-8 px-2 sm:px-4 lg:px-8">
        <div class="flex flex-col-reverse gap-4 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-8 lg:mt-0 mt-8">
                @forelse ($jobs as $job)
                    <x-jobs.job-card :job="$job" />
                @empty
                    <div class="text-center py-10 text-gray-500">
                        <p class="text-lg">No job listings found at the moment.</p>
                        <p class="mt-2 text-sm">Perhaps it's time to create some new ones?</p>
                    </div>
                @endforelse
                <div class="mt-5">
                    {{ $jobs->links() }}
                </div>
            </div>
            <div class="lg:col-span-4"> {{-- lg:pe-2 lg:h-[70vh] lg:overflow-y-scroll --}}
                <x-jobs.job-filter-sidebar :allTags="$allTags" />
            </div>
        </div>
    </div>
</x-layout>
