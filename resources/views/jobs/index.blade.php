<x-layout>
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

    <div class="mt-8 flow-root">
        <x-jobs.job-filter-sidebar :allTags="$allTags" />
        <div class="space-y-10 divide-y divide-gray-200">
            @forelse ($jobs as $job)
                <x-jobs.job-card :job="$job" />
            @empty
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg">No job listings found at the moment.</p>
                    <p class="mt-2 text-sm">Perhaps it's time to create some new ones?</p>
                </div>
            @endforelse
        </div>
        <div class="mt-5">
            {{ $jobs->links() }}
        </div>
    </div>
</x-layout>
