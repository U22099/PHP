@props(['job', 'bid'])

<div class="col-span-2 border rounded-xl p-8 md:p-10 lg:p-12">
    <h3 class="text-2xl font-bold text-gray-900 mb-4">Edit Your Bid for {{ $job->title }}</h3>

    @can('update', $bid)
        <form action="{{ route('jobs.update_bid', ['job' => $job->id, 'bid' => $bid->id]) }}" method="POST" class="flex flex-col gap-2">
            @csrf
            @method('PATCH')
            <x-form-field class="w-full" label="Bid Amount" fieldname="bid_amount"
                value="{{ old('bid_amount', $bid->bid_amount) }}" type="number" required>
                <x-slot:icon>
                    <x-grommet-money class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('bid_amount')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </x-form-field>

            <x-form-field class="w-full" label="Time Budget (in days)" fieldname="bid_time_budget"
                value="{{ old('bid_time_budget', $bid->bid_time_budget) }}" type="number" required>
                <x-slot:icon>
                    <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                </x-slot:icon>
                @error('bid_time_budget')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </x-form-field>

            <x-form-field class="w-full" rows='5' label="Bid Message" fieldname="bid_message"
                :textarea="true" required>{{ old('bid_message', $bid->bid_message) }}</x-form-field>
            @error('bid_message')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <x-button type="submit" class="mt-6 w-fit">Update Bid</x-button>
        </form>
    @else
        <p class="text-red-500">You are not authorized to edit this bid.</p>
    @endcan
</div>
