<x-layout>
    <x-slot:heading>
        {{ $job['name'] }}
    </x-slot:heading>
    <p>Pays {{ $job['salary'] }} per year.</p>
</x-layout>
