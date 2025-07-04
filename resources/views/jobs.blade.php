<x-layout>
    <x-slot:heading>
        Available Positions
    </x-slot:heading>

    <div class="mt-8 flow-root">
        <div class="-my-6 divide-y divide-gray-100">
            @forelse ($jobs as $job)
                <a href="/job/{{ $job->id }}"
                    class="group block py-6 px-4 hover:bg-gray-50 transition-colors duration-200 ease-in-out border-b border-gray-100 last:border-b-0">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-indigo-600 group-hover:text-indigo-700">
                            {{ $job->name }}
                        </h2>
                        <span
                            class="inline-flex items-center rounded-md bg-green-50 px-3 py-1 text-base font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            {{ $job->salary }} per year
                        </span>
                    </div>
                    <p class="mt-2 text-gray-600 text-sm">
                        Discover exciting opportunities and competitive compensation. Click to learn more!
                    </p>
                </a>
            @empty
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg">No job listings found at the moment.</p>
                    <p class="mt-2 text-sm">Perhaps it's time to create some new ones?</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
