<x-layout>
    <div class="flex justify-between container mx-auto px-4 py-6 sm:px-6 sm:py-8">
        <div class="w-full border rounded-xl p-8 md:p-10 lg:p-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Edit your bid for {{ $job->title }}</h3>

            @can('update', $bid)
                <form action="{{ route('bids.update', ['job' => $job->id, 'bid' => $bid->id]) }}" method="POST"
                    class="flex flex-col gap-2">
                    @csrf
                    @method('PUT')
                    <x-form-field class="w-full" label="Bid Amount" fieldname="bid_amount" :data="$bid->bid_amount" type="number"
                        required>
                        <x-slot:icon>
                            <x-grommet-money class="h-5 w-5 text-gray-400" />
                        </x-slot:icon>
                        @error('bid_amount')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>

                    <x-time-input class="w-full" label="Time Budget" fieldname="bid_time_budget"
                        data="{{ $bid->bid_time_budget }}" required>
                        <x-slot:icon>
                            <x-fluentui-time-picker-20 class="h-5 w-5 text-gray-400" />
                        </x-slot:icon>
                        @error('bid_time_budget')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-time-input>

                    <x-form-field class="w-full" rows='5' label="Bid Message" :data="$bid->bid_message"
                        fieldname="bid_message" :textarea="true" required>
                        @error('bid_message')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </x-form-field>
                    <div class="flex w-full gap-2 justify-end mt-6">
                        <a href="{{ route('bids.index', ['job' => $job->id]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-fit">Cancel</a>
                        <x-button type="submit" class="w-fit">Update Bid</x-button>
                    </div>
                </form>
            @else
                <p class="text-red-500">You are not authorized to edit this bid.</p>
            @endcan
        </div>
    </div>
</x-layout>
