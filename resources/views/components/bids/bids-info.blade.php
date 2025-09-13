@props(['job'])
<div class="col-span-1 flex flex-col gap-8 w-full border rounded-xl p-8 md:p-10 lg:p-12">
    {{-- Client Information --}}
    <div class="w-full">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Client Information</h3>
        @if ($job->user)
            <div class="flex items-center gap-4">
                @if ($job->user->image)
                    <img src="{{ $job->user->image }}" alt="{{ $job->user->username }} Logo"
                        class="h-16 w-16 rounded-full">
                @endif
                <div>
                    <p class="text-lg text-gray-600 font-medium mb-1">
                        Client Name: <span
                            class="text-indigo-600 font-bold">{{ $job->user->firstname . ' ' . $job->user->lastname }}</span>
                    </p>
                    <p class="text-gray-600 text-sm">
                        Member since: {{ $job->user->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        @else
            <p class="text-gray-600">Client information not available.</p>
        @endif
    </div>

    {{-- Bids Section --}}
    <div class="w-full">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Bids Overview</h3>

        @if ($job->bids->isNotEmpty())
            @php
                $acceptedBids = $job->bids->where('bid_status', 'accepted')->count();
                $interviewingBids = $job->bids->where('bid_status', 'interviewing')->count();
            @endphp
            <h4 class="text-gray-600 mb-2">Total Bids: <span class="font-bold">{{ $job->bids->count() }}</span></h4>
            <h4 class="text-gray-600 mb-2">Average Bid: <span class="font-bold">
                    {{ $job->currency->symbol }}{{ number_format($job->average_bid_amount) }}
                </span></h4>
            <h4 class="text-gray-600 mb-2">Accepted Bids: <span class="font-bold"> {{ $acceptedBids }}
                </span></h4>

            <h4 class="text-gray-600 mb-2">Interviewing: <span class="font-bold">
                    {{ $interviewingBids }} </span></h4>
        @else
            <p class="text-gray-600">No bids have been placed yet.</p>
        @endif
    </div>

    <div class="flex flex-col gap-2">
        <x-button type="link" href="/jobs/{{ $job->id }}/bids"
            class="capitalize w-full flex justify-center items-center mt-2">
            View Proposals
        </x-button>
        <x-share-button url="{{ route('jobs.show', $job) }}" from="job"
            class="w-full flex justify-center items-center gap-2 px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" />
    </div>
</div>
