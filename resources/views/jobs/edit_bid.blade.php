<x-layout>
    <div class="border rounded-md px-6 py-8">
        <div class="flex justify-between container mx-auto">
            <div class="w-full lg:w-8/12">
                <x-jobs.edit-bid-form :job="$job" :bid="$bid" />
            </div>
            <x-jobs.job-filter-sidebar />
        </div>
    </div>
</x-layout>
