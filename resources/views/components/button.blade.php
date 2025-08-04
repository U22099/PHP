@props(['type' => 'button', 'active' => true, 'enableDefaultStyling' => true])

@php
    $defaultStyling =
        'inline-flex text-sm sm:text-md items-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out';
@endphp

@if ($type == 'link')
    <a
        {{ $attributes->merge(['class' => ($active ? 'text-white' : 'text-gray-300') . ' ' . ($enableDefaultStyling ? $defaultStyling : '')]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $enableDefaultStyling ? $defaultStyling : '']) }}>
        {{ $slot }}
    </button>
@endif
