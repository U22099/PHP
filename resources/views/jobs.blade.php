<x-layout>
    <x-slot:heading>
        Available Positions
    </x-slot:heading>

    <div class="mt-8 flow-root">
        <div class="space-y-10 divide-y divide-gray-200">
            @forelse ($jobs as $employerName => $jobsByEmployer)
                <div class="pt-8 first:pt-0">
                    <h2
                        class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-indigo-600 pb-2 inline-block">
                        {{ $employerName }}
                    </h2>

                    <div class="-my-6 divide-y divide-gray-100">
                        @foreach ($jobsByEmployer as $job)
                            <a href="/job/{{ $job->id }}"
                                class="group block py-6 px-4 hover:bg-gray-50 transition-colors duration-200 ease-in-out border-b border-gray-100 last:border-b-0">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <h3
                                        class="text-xl font-semibold text-indigo-600 group-hover:text-indigo-700 leading-tight mb-2 sm:mb-0">
                                        {{ $job->name }}
                                    </h3>
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-3 py-1 text-base font-medium text-green-700 ring-1 ring-inset ring-green-600/20 flex-shrink-0">
                                        {{ $job->salary }} per year
                                    </span>
                                </div>
                                <p class="mt-2 text-gray-600 text-sm">
                                    A great opportunity for talented individuals. Click to learn more!
                                </p>

                                @if ($job->tags->isNotEmpty())
                                    {{-- Only show tags if there are any --}}
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($job->tags as $tag)
                                            <span
                                                class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg">No job listings found at the moment.</p>
                    <p class="mt-2 text-sm">Perhaps it's time to create some new ones?</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
