<x-layout>
    <x-slot:heading>
        Jobs Listing
    </x-slot:heading>
    <ul>
        @foreach ($jobs as $job)
            <li>
                <a href="/job/{{ $job['id'] }}">
                    <strong>{{ $job['name'] }}:</strong>
                    Pays {{ $job['salary'] }} per year.
                </a>
            </li>
        @endforeach
    </ul>
</x-layout>
