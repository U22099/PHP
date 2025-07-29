@props(['bids', 'title'])

<x-layout>
    {{-- Main container, now flat with a subtle border --}}
    <div x-data="{
        selectedBids: [],
        startSelection: false,
    }" class="col-span-1 border border-gray-200 bg-white rounded-xl p-6 md:p-8 lg:p-10">
        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-indigo-500 pb-3">
            Bids for this Job: {{ $title }}
        </h3>

        <div class="flex w-full justify-end items-center mb-3" x-show="selectedBids.length < 1">
            <x-button @click="startSelection = !startSelection" addclass="self-end w-fit"
                x-text="startSelection ? 'Deselect Bids': 'Select Bids'"></x-button>
        </div>

        @if ($bids->count() > 0)
            {{-- Mass Reject Controls (visible only if there are bids and selections) --}}
            <div x-show="selectedBids.length > 0" x-transition.opacity.duration.300ms
                class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-md flex items-center justify-between">
                <span class="font-medium text-sm md:text-base">
                    <span x-text="selectedBids.length"></span> bid<span x-show="selectedBids.length > 1">s</span>
                    selected.
                </span>
                <form id="mass-reject-form" method="POST" action="#">
                    {{-- {{ route('jobs.mass_update_bid_status', ['job' => $bids->first()->job->id]) }} --}}
                    @csrf
                    @method('PATCH')
                    {{-- Hidden input to send selected bid IDs --}}
                    <input type="hidden" name="bid_ids" :value="selectedBids.join(',')">
                    <input type="hidden" name="bid_status" value="rejected">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <x-heroicon-s-x-circle class="h-5 w-5 mr-2" aria-hidden="true" />
                        Mass Reject Selected
                    </button>
                </form>
            </div>

            <ul class="space-y-6 md:space-y-8">
                @foreach ($bids as $bid)
                    <li class="relative">
                        {{-- Individual bid card, now flat with subtle border --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 md:p-6 flex flex-row items-center">
                            {{-- Checkbox for mass selection --}}
                            <div class="absolute top-4 left-4 sm:static sm:mr-4"
                                x-show="startSelection || selectedBids.length > 0">
                                <input type="checkbox" x-model="selectedBids" value="{{ $bid->id }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600 rounded-md border-gray-300 focus:ring-indigo-500 cursor-pointer">
                            </div>

                            <div class="flex flex-col items-start">

                                <div class="flex-grow w-full sm:w-auto mt-4 sm:mt-0">
                                    {{-- Bidder Information & Avatar --}}
                                    <div class="flex items-center mb-3">
                                        <img src="{{ $bid->user->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($bid->user->username) }}&background=random&color=fff&size=40"
                                            alt="{{ $bid->user->username }}"
                                            class="w-14 h-14 rounded-full object-cover border-2 border-indigo-300 mr-3">
                                        <h4 class="text-lg md:text-xl font-semibold text-gray-800">
                                            Bid by <span
                                                class="text-indigo-600">{{ $bid->user->firstname . ' ' . $bid->user->lastname }}</span>
                                        </h4>
                                    </div>

                                    {{-- Bid Details Grid --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 text-gray-700 mb-5">
                                        <div class="flex flex-col">
                                            <p class="font-medium text-sm text-gray-500 mb-1">Bid Amount:</p>
                                            <p class="text-lg font-bold text-green-700 flex items-center">
                                                <span
                                                    class="mr-1">{{ $bid->job->currency->symbol }}</span>{{ number_format($bid->bid_amount, 2) }}
                                            </p>
                                        </div>
                                        <div class="flex flex-col">
                                            <p class="font-medium text-sm text-gray-500 mb-1">Time Budget:</p>
                                            <p class="text-lg font-bold text-blue-700 flex items-center">
                                                <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                                                {{ $bid->bid_time_budget }} days
                                            </p>
                                        </div>
                                        <div class="col-span-full">
                                            <p class="font-medium text-sm text-gray-500 mb-1">Message:</p>
                                            <p
                                                class="text-gray-800 text-base italic leading-relaxed bg-white p-3 rounded-md border border-gray-100">
                                                "{{ $bid->bid_message }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div
                                    class="mt-4 sm:mt-0 flex flex-col sm:flex-row sm:items-center sm:space-x-3 space-y-3 sm:space-y-0 w-full sm:w-auto">

                                    @can('updateStatus', $bid)
                                        {{-- Message Freelancer Button (updates status to 'interviewing') --}}
                                        <form
                                            action="{{ route('jobs.update_bid_status', ['job' => $bid->job->id, 'bid' => $bid->id]) }}"
                                            method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="bid_status"
                                                value="{{ $bid->bid_status === 'interviewing' ? 'acccepted' : 'interviewing' }}">
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
                                                <x-heroicon-s-envelope class="h-5 w-5 mr-2" aria-hidden="true" />
                                                {{ $bid->bid_status === 'interviewing' ? 'Award Job' : 'Message Freelancer' }}
                                            </button>
                                        </form>

                                        {{-- Reject Bid Button (updates status to 'rejected') --}}
                                        <form
                                            action="{{ route('jobs.update_bid_status', ['job' => $bid->job->id, 'bid' => $bid->id]) }}"
                                            method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="bid_status" value="rejected">
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full">
                                                <x-heroicon-s-x-circle class="h-5 w-5 mr-2" aria-hidden="true" />
                                                Reject Bid
                                            </button>
                                        </form>
                                    @endcan

                                    @can('update', $bid)
                                        {{-- Edit Bid Link --}}
                                        <a href="{{ route('jobs.edit_bid', ['job' => $bid->job->id, 'bid' => $bid->id]) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                                            <x-heroicon-s-pencil-square class="h-4 w-4 mr-2" aria-hidden="true" />
                                            Edit Bid
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
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
