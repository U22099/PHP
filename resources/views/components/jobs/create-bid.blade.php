@props(['job'])
<div class="col-span-2 border rounded-xl p-8 md:p-10 lg:p-12">
    <h3 class="text-2xl font-bold text-gray-900 mb-2">Place a Bid</h3>

    @auth
        @if ($job->bids->where('user_id', Auth::id())->count() > 0)
            <p class="text-gray-600">You have already bidded for this job.</p>
        @elseif (Auth::user()->role === 'freelancer')
            <form action="/jobs/{{ $job->id }}/bids" method="POST" class="flex flex-col gap-2">
                @csrf
                <x-form-field class="w-full" label="Bid Ammount" fieldname="amount"
                    placeholder="{{ ceil(($job->min_budget + $job->max_budget) / 2) }}" type="number" required>
                    <x-slot:icon>
                        <x-grommet-money class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('amount')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>

                <x-form-field class="w-full" label="Time Range (in days)" fieldname="time_range"
                    placeholder="{{ $job->time_budget }}" type="number" required>
                    <x-slot:icon>
                        <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                    </x-slot:icon>
                    @error('time_range')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>

                <x-form-field class="w-full" rows='5' label="Bid Message" fieldname="message"
                    placeholder="Write your bid message here..." :textarea="true" required>
                    @error('message')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </x-form-field>
                <x-button type="submit" class="mt-6 w-fit">Submit Bid</x-button>
            </form>
        @else
            <p class="text-gray-600">Only freelancers can place bids on jobs.</p>
        @endif
    @endauth
</div>
