@props(['bid'])

<div
    class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer">
    <div class="flex-grow mb-2" @click="window.location.href = '/jobs/{{ $bid->job->id }}';">
        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $bid->job->title }}</h3>
        <div class="text-gray-600 text-sm mb-2 line-clamp-3">{{ strip_tags($bid->job->description) }}</div>
    </div>
    <div class="grid w-full grid-cols-2 gap-4 text-center md:grid-cols-5">
        <div class="flex flex-col items-center justify-center">
            <div class="flex items-center gap-1 pb-2 text-gray-600">
                <x-heroicon-o-users class="w-5 h-5 mr-2" />
                <span>Total Bids</span>
            </div>
            <div class="font-bold">
                {{ $bid->job->bids_count }}
            </div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div class="flex items-center gap-1 pb-2 text-gray-600">
                <x-heroicon-o-clock class="h-5 w-5 text-gray-400" />
                Bid Placed
            </div>
            <div class="font-bold">
                {{ $bid->created_at->format('M d, Y') }}
            </div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div class="flex items-center gap-1 pb-2 text-gray-600">
                <x-heroicon-o-banknotes class="h-5 w-5 text-gray-400" />
                Average Bid
            </div>
            <div class="font-bold">
                {{ $bid->job->currency->symbol }}{{ number_format($bid->job->average_bid_amount) }}
            </div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div class="flex items-center gap-1 pb-2 text-gray-600">
                <x-grommet-money class="h-5 w-5 text-gray-400" />
                Bid Amount
            </div>
            <div class="font-bold">
                {{ $bid->job->currency->symbol }}{{ number_format($bid->bid_amount) }}
            </div>
        </div>
        <div class="flex flex-col items-center justify-center col-span-2 sm:col-span-1">
            <div class="flex items-center gap-1 pb-2 text-gray-600">
                <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                Time Budget
            </div>
            <div class="font-bold">
                <span>
                    {{ $bid->bid_time_budget }} {{ str('day')->plural($bid->bid_time_budget) }}
                    @if ($bid->bid_time_budget > 7)
                        <span class="text-gray-500 font-medium text-sm">
                            (&#8776;
                            {{ \Carbon\Carbon::now()->addDays($bid->bid_time_budget)->diffForHumans(null, true) }})
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
