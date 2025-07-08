@props(['active' => false])

<a {{ $attributes }}
    class="{{ $active ? 'text-white' : 'text-gray-300' }} text-sm/6 font-semibold">{{ $slot }}</a>
