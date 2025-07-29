@props(['bids'])

<x-layout>
    <div class="col-span-1 border rounded-xl p-8 md:p-10 lg:p-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Bids for this Job</h3>

        @if ($bids->count() > 0)
            <ul class="space-y-4">
                @foreach ($bids as $bid)
                    <li>
                        <div class="border rounded-lg p-4">
                            <p class="text-gray-700"><strong>Bid Amount:</strong> {{ $bid->bid_amount }}</p>
                            <p class="text-gray-700"><strong>Time Budget:</strong> {{ $bid->bid_time_budget }} days</p>
                            <p class="text-gray-700"><strong>Message:</strong> {{ $bid->bid_message }}</p>
                            <p class="text-gray-700"><strong>Status:</strong> {{ $bid->bid_status }}</p>
                            <p class="text-gray-700"><strong>Bidded by:</strong> {{ $bid->user->username }}</p>
                            @can('updateStatus', $bid)
                                <form action="{{ route('jobs.update_bid_status', ['job' => $bid->job->id, 'bid' => $bid->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label for="status-{{ $bid->id }}"
                                        class="block text-sm font-medium text-gray-700">Update Status:</label>
                                    <select name="bid_status" id="status-{{ $bid->id }}"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="accepted" {{ $bid->bid_status === 'accepted' ? 'selected' : '' }}>
                                            Accepted
                                        </option>
                                        <option value="rejected" {{ $bid->bid_status === 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                        <option value="interviewing"
                                            {{ $bid->bid_status === 'interviewing' ? 'selected' : '' }}>
                                            Interviewing</option>
                                        <option value="pending" {{ $bid->bid_status === 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                    <button type="submit"
                                        class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
                                </form>
                            @endcan
                            @can('update', $bid)
                                <a href="{{ route('jobs.edit_bid', ['job' => $$bid->job->id, 'bid' => $bid->id]) }}"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm">Edit Bid</a>
                            @endcan
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">No bids yet for this job.</p>
        @endif
    </div>
</x-layout>
