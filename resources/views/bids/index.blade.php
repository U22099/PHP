<x-layout>
    <x-slot:heading>
        Proposals
    </x-slot:heading>

    <x-slot:headerbutton>
        <x-button type="link" href="/jobs/{{ $job->id }}" class="capitalize flex gap-1 items-center">
            <x-heroicon-o-arrow-left class="h-5 w-5 text-white" />
            Go Back
        </x-button>
    </x-slot:headerbutton>

    <div x-data="{
        selectedBids: [],
        startSelection: false,
    }" class="col-span-1 border border-gray-200 bg-white rounded-xl p-6 md:p-8 lg:p-10">
        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-indigo-500 pb-3">
            Bids: {{ $job->title }}
        </h3>

        @if ($job->user->is(Auth::user()))
            <div class="flex w-full justify-end items-center mb-3" x-show="selectedBids.length < 1">
                <x-button @click="startSelection = !startSelection" addclass="self-end w-fit"
                    x-text="startSelection ? 'Deselect Bids': 'Select Bids'"></x-button>
            </div>
        @endif

        @php
            $acceptedBids = $bids->where('bid_status', 'accepted');
            $otherBids = $bids->where('bid_status', '!=', 'accepted');
            $acceptedBidsCount = $acceptedBids->count();
        @endphp

        @if ($user_bid)
            <div class="pb-6 mb-6 border-b-2 border-gray-200">
                <h3 class="font-bold text-xl mb-2"> Your Bid
                    @if ($user_ranked)
                        <span>&#40;ranked
                            #{{ $user_ranked - $acceptedBidsCount }}&#41;</span>
                    @endif
                </h3>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 md:p-6 flex flex-row items-center">
                    <x-bids.index-card :bid="$user_bid" :job="$job" />
                </div>
            </div>
        @endif

        @if ($job->bids_count)
            @if ($job->user->is(Auth::user()))
                <div x-show="selectedBids.length > 0" x-transition.opacity.duration.300ms
                    class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-md flex items-center justify-between">
                    <span class="font-medium text-sm md:text-base">
                        <span x-text="selectedBids.length"></span> bid<span x-show="selectedBids.length > 1">s</span>
                        selected.
                    </span>
                    <form method="POST" action="{{ route('bids.mass_reject', ['job' => $job->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bids_ids" :value="selectedBids.join(',')">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <x-heroicon-s-trash class="h-5 w-5 mr-2" aria-hidden="true" />
                            Mass Reject Selected
                        </button>
                    </form>
                </div>
            @endif

            @if ($acceptedBidsCount)
                <ul class="space-y-6 md:space-y-8 list-outside list-disc pb-6 mb-6 border-b-2 border-gray-200">
                    @foreach ($acceptedBids as $bid)
                        <li class="relative">
                            {{-- Individual bid card --}}
                            <div
                                class="bg-green-50 border border-green-200 rounded-lg p-4 md:p-6 flex flex-row items-center">
                                {{-- Bid card content --}}
                                <x-bids.index-card :bid="$bid" :job="$job" />
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <ol class="space-y-6 md:space-y-8 list-outside list-decimal">
                @foreach ($otherBids as $bid)
                    <li class="relative">
                        {{-- Individual bid card --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 md:p-6 flex flex-row items-center">
                            {{-- Checkbox for mass selection --}}
                            <div class="absolute top-4 left-4 sm:static sm:mr-4"
                                x-show="startSelection || selectedBids.length > 0">
                                <input type="checkbox" x-model="selectedBids" value="{{ $bid->id }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600 rounded-md border-gray-300 focus:ring-indigo-500 cursor-pointer">
                            </div>

                            {{-- Bid card content --}}
                            <x-bids.index-card :bid="$bid" :job="$job" />
                        </div>
                    </li>
                @endforeach
            </ol>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-blue-400">
                        <x-heroicon-s-information-circle class="h-5 w-5" fill="currentColor" aria-hidden="true"
                            clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-base text-blue-700 font-medium">
                            No bids yet for this job. Be sure to share it widely!
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>
