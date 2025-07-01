@props(['active' => false, 'type' => 'a'])

@if ($type == 'a')
    <a {{ $attributes }}
        class="{{ $active ? 'text-white' : 'text-gray-300' }} text-sm/6 font-semibold">{{ $slot }}</a>
@elseif ($type == 'button')
    <button {{ $attributes }}
        class="{{ $active ? 'text-white' : 'text-gray-300' }} text-sm/6 font-semibold">{{ $slot }}</button>
@else
    <div {{ $attributes }} class="{{ $active ? 'text-white' : 'text-gray-300' }} text-sm/6 font-semibold">
        {{ $slot }}</div>
@endif
