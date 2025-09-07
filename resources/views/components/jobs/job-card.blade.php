@props(['job'])

<div class="divide-y divide-gray-100">
    <a href="/jobs/{{ $job->id }}"
        class="group block py-6 px-4 rounded-md hover:bg-gray-100 transition-colors duration-200 ease-in-out border-b border-gray-200">
        <div class="flex justify-end w-full">
            <h3 class="text-xl font-semibold text-indigo-500 group-hover:text-indigo-700 leading-tight mb-2 sm:mb-0">
                Bids: {{ $job->bids->count() }}
            </h3>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-xl font-semibold text-indigo-500 group-hover:text-indigo-700 leading-tight mb-2 sm:mb-0">
                {{ $job->title }}
            </h3>
            <div class="flex gap-2 justify-end sm:justify-start items-center">
                <span
                    class="text-xs font-semibold text-neutral-500 group-hover:text-neutral-700 leading-tight mb-2 sm:mb-0">
                    Posted: {{ $job->created_at->diffForHumans() }}
                </span>
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-3 py-1 text-base font-medium text-green-700 ring-1 ring-inset ring-green-600/20 flex-shrink-0">
                    {{ $job->currency->symbol }}
                    <span>
                        @if ($job->min_budget === $job->max_budget)
                            {{ Number::abbreviate($job->min_budget, 1) }}
                        @else
                            {{ Number::abbreviate($job->min_budget, 1) }} -
                            {{ Number::abbreviate($job->max_budget, 1) }}
                        @endif
                    </span>
                    <span class="ml-2">in
                        {{ Illuminate\Support\Carbon::now()->addDays($job->time_budget)->diffForHumans(null, true) }}</span>
                </span>
            </div>
        </div>
        <div class="prose text-gray-800 line-clamp-3">
            @if ($job->description)
                {{ $job->description }}
            @else
                <p class="mt-2 text-gray-600 text-sm">
                    A great opportunity for talented individuals. Click to learn more!
                </p>
            @endif
        </div>
        @if ($job->tags->isNotEmpty())
            {{-- Only show tags if there are any --}}
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($job->tags as $tag)
                    <span onclick="window.location.href = '/jobs?tags[]={{ $tag->name }}'"
                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </a>
</div>
