@props(['bid', 'job'])

<div class="flex flex-col items-start">
    <div class="flex-grow w-full sm:w-auto mt-6 sm:mt-0">
        {{-- Bidder Information & Avatar --}}
        <div class="flex justify-start sm:items-center mb-3 w-full cursor-pointer"
            onclick="window.location.href = '/{{ $bid->user->username }}'">
            <img src="{{ $bid->user->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($bid->user->username) }}&background=random&color=fff&size=40"
                alt="{{ $bid->user->username }}"
                class="w-14 h-14 rounded-full object-cover border-2 border-indigo-300 mr-3">
            <div class="flex flex-col">
                <h4 class="text-lg md:text-xl font-semibold text-gray-800 sm:flex sm:items-center sm:gap-2">
                    Bid by <span class="text-indigo-600">
                        {{ $bid->user->firstname . ' ' . $bid->user->lastname }}</span>
                    <span class="flex items-center gap-1">
                        <span class="text-gray-400">&#64;{{ $bid->user->username }}</span>
                        @if ($bid->user->is_premium)
                            <x-heroicon-s-check-badge class="h-5 w-5 text-blue-500" />
                        @endif
                    </span>
                </h4>
                @if ($bid->user->freelancer_details)
                    <span class="text-gray-600">{{ $bid->user->freelancer_details->professional_name ?? 'N/A' }}</span>
                    <div class="text-sm text-gray-600 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                        <span>{{ $bid->user->freelancer_details->country ?? 'N/A' }},
                            {{ $bid->user->freelancer_details->city ?? 'N/A' }}</span>
                        <span class="hidden sm:inline">|</span>
                        <span>{{ $bid->user->freelancer_details->availability ?? 'N/A' }}</span>
                        <span class="hidden sm:inline">|</span>
                        <span>Response time: {{ $bid->user->freelancer_details->response_time ?? 'N/A' }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bid Details Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-3 gap-x-6 text-gray-700 mb-5">
            <div class="flex flex-col">
                <p class="font-medium text-sm text-gray-500 mb-1">Bid Amount:</p>
                <p class="text-lg font-bold text-green-600 flex items-center gap-1">
                    <x-grommet-money class="h-5 w-5 text-gray-400" />
                    <span>
                        {{ $job->currency->symbol }}{{ number_format($bid->bid_amount, 2) }}
                    </span>
                </p>
            </div>
            <div class="flex flex-col">
                <p class="font-medium text-sm text-gray-500 mb-1">Time Budget:</p>
                <p class="text-lg font-bold text-blue-700 flex items-center gap-1">
                    <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                    <span>
                        {{ $bid->bid_time_budget }} {{ str('day')->plural($bid->bid_time_budget) }}
                        @if ($bid->bid_time_budget > 7)
                            <span class="text-gray-500 font-medium text-sm">
                                (&#8776;
                                {{ \Carbon\Carbon::now()->addDays($bid->bid_time_budget)->diffForHumans(null, true) }})
                            </span>
                        @endif
                    </span>
                </p>
            </div>
            <div class="flex flex-col">
                <p class="font-medium text-sm text-gray-500 mb-1">Bid Status:</p>
                <p
                    class="text-lg font-bold {{ $bid->bid_status === 'pending' ? 'text-gray-400' : ($bid->bid_status === 'interviewing' ? 'text-indigo-500' : ($bid->bid_status === 'accepted' ? 'text-green-600' : 'text-red-500')) }} flex items-center gap-1">
                    @if ($bid->bid_status === 'pending')
                        <x-rpg-hourglass class="h-5 w-5 text-gray-400" />
                    @elseif($bid->bid_status === 'interviewing')
                        <x-cri-chat class="h-5 w-5 text-indigo-500" />
                    @elseif($bid->bid_status === 'accepted')
                        <x-fas-award class="h-5 w-5 text-green-600" />
                    @elseif($bid->bid_status === 'rejected')
                        <x-fas-x class="h-5 w-5 text-red-400" />
                    @endif
                    <span>
                        {{ strtoupper($bid->bid_status) }}
                    </span>
                </p>
            </div>
            <div class="col-span-full" x-data="{
                showMore: false,
                toggleShowMore() {
                    this.showMore = !this.showMore;
                }
            }">
                <p class="font-medium text-sm text-gray-500 mb-1">Message:</p>
                <div
                    class="text-gray-800 text-base italic leading-relaxed bg-white p-3 rounded-md border border-gray-100">
                    <span
                        :class="!showMore && 'line-clamp-3'">&OpenCurlyDoubleQuote;{{ $bid->bid_message }}&CloseCurlyDoubleQuote;</span>
                    <span class="cursor-pointer ml-2 text-indigo-600" @click="toggleShowMore()"
                        x-text="showMore ? 'Show Less' : 'Show More'"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div
        class="mt-4 sm:mt-0 flex flex-col sm:flex-row sm:items-center sm:space-x-3 space-y-3 sm:space-y-0 w-full sm:w-auto">

        @can('updateStatus', [$bid, $job])
            {{-- Message Freelancer Button (updates status to 'interviewing') --}}
            @if ($bid->bid_status !== 'accepted')
                <form action="{{ route('bids.update_status', ['job' => $job->id, 'bid' => $bid->id]) }}" method="POST"
                    class="w-full sm:w-auto">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="bid_status"
                        value="{{ $bid->bid_status === 'interviewing' ? 'accepted' : 'interviewing' }}">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white {{ $bid->bid_status === 'interviewing' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500 ' : 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 ' }} focus:outline-none focus:ring-2 focus:ring-offset-2 w-full">
                        @if ($bid->bid_status === 'interviewing')
                            <x-fas-award class="h-5 w-5 mr-2" aria-hidden="true" />
                            Award Job
                        @else
                            <x-heroicon-s-envelope class="h-5 w-5 mr-2" aria-hidden="true" />
                            Message Freelancer
                        @endif
                    </button>
                </form>

                {{-- Reject Bid Button (updates status to 'rejected') --}}

                <form action="{{ route('bids.update_status', ['job' => $job->id, 'bid' => $bid->id]) }}" method="POST"
                    class="w-full sm:w-auto">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="bid_status" value="rejected">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full">
                        <x-heroicon-s-x-circle class="h-5 w-5 mr-2" aria-hidden="true" />
                        Reject Bid
                    </button>
                </form>
            @else
                <a href="#"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:ring-green-500  focus:outline-none focus:ring-2 focus:ring-offset-2 w-full">
                    <x-heroicon-s-envelope class="h-5 w-5 mr-2" aria-hidden="true" />
                    View Messages
                </a>
            @endif
        @endcan

        @can('update', $bid)
            {{-- Edit Bid Link --}}
            <a href="{{ route('bids.edit', ['job' => $job->id, 'bid' => $bid->id]) }}"
                class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                <x-heroicon-s-pencil-square class="h-4 w-4 mr-2" aria-hidden="true" />
                Edit Bid
            </a>
        @endcan

        @can('delete', [$bid, $job])
            <form method="POST" action="{{ route('bids.delete', ['job' => $job->id, 'bid' => $bid->id]) }}"
                onsubmit="return confirm('Are you sure you want to delete your bid?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full sm:w-auto">
                    <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                    Delete
                </button>
            </form>
        @endcan
    </div>
</div>
