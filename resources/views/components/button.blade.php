@props(['type', 'active' => true, 'addclass' => ''])

@php
    $baseClasses =
        'inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out' .
        ' ' .
        $addclass;
@endphp

@if ($type == 'link')
    <a {{ $attributes }} class="{{ ($active ? 'text-white' : 'text-gray-300') . ' ' . $baseClasses }}">
        {{ $slot }}
    </a>
@else
    <button {{ $attributes }} class="{{ $baseClasses }}">
        {{ $slot }}
    </button>
@endif
