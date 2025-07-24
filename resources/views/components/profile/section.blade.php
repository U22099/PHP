<!-- resources/views/components/profile/section.blade.php -->
@props(['title'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">{{ $title }}</h2>
    {{ $slot }}
</div>
