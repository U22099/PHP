@props(['job'])

<div class="col-span-2 border rounded-xl p-8 md:p-10 lg:p-12">
    <h3 class="text-2xl font-bold text-gray-900 mb-2">Place a Bid</h3>

    @auth
        @php
            $user_bid = $job->bids->where('user_id', Auth::id())->first();
            if ($user_bid) {
                $user_bid->load('user');
            }
        @endphp
        @if ($user_bid)
            <p class="text-gray-600">You have already bidded for this job.</p>
            <div class="flex-grow mb-2 border p-4 rounded-xl bg-gray-100 opacity-70 w-full sm:w-auto mt-6 sm:mt-0">
                <div class="flex items-center mb-3">
                    <img src="{{ $user_bid->user->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($user_bid->user->username) }}&background=random&color=fff&size=40"
                        alt="{{ $user_bid->user->username }}"
                        class="w-14 h-14 rounded-full object-cover border-2 border-indigo-300 mr-3">
                    <h4 class="text-lg md:text-xl font-semibold text-gray-800">
                        Bid by <span
                            class="text-indigo-600">{{ $user_bid->user->firstname . ' ' . $user_bid->user->lastname }}</span>
                    </h4>
                </div>
                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $job->title }}</h3>
                    <div class="text-gray-600 text-sm mb-2 line-clamp-3">{{ $user_bid->bid_message }}</div>
                </div>
            </div>
            <div class="flex w-full justify-end gap-4">
                <form method="POST" action="{{ route('bids.delete', ['job' => $job->id, 'bid' => $user_bid->id]) }}"
                    onsubmit="return confirm('Are you sure you want to delete your bid?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                        Delete
                    </button>
                </form>
                <button @click="window.location.href = '/jobs/{{ $job->id }}/bids/{{ $user_bid->id }}/edit';"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-md font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-heroicon-o-pencil class="w-4 h-4 mr-1" />
                    Edit
                </button>
            </div>
        @elseif (Auth::user()->role === 'freelancer')
            <form action="/jobs/{{ $job->id }}/bids" method="POST" class="flex flex-col gap-2">
                @csrf
                <x-form-field class="w-full" label="Bid Ammount" fieldname="bid_amount"
                    placeholder="{{ ceil(($job->min_budget + $job->max_budget) / 2) }}" type="number" required>
                    <x-slot:icon>
                        <x-grommet-money class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('bid_amount')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>

                <x-time-input class="w-full" label="Time Budget" fieldname="bid_time_budget" data="{{ $job->time_budget }}"
                    required>
                    <x-slot:icon>
                        <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('bid_time_budget')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-time-input>

                <x-form-field class="w-full" rows='5' label="Bid Message" fieldname="bid_message"
                    placeholder="Write your bid message here..." :textarea="true" required>
                    @error('bid_message')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>
                <x-button type="submit" class="mt-6 w-fit">Submit Bid</x-button>
            </form>
        @else
            <p class="text-gray-600">Only freelancers can place bids on jobs.</p>
        @endif
    @endauth
    @guest
        <x-button type="link" href="{{ route('login') }}">Log in</x-button>
    @endguest
</div>
