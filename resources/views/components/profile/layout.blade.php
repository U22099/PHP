<x-layout>

    <x-slot:title>
        Profile: {{ $title }}
    </x-slot:title>

    <div {{ $attributes->merge(['class' => 'min-h-screen bg-gray-100 py-10']) }}>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-layout>
