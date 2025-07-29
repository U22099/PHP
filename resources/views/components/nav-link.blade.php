@props(['active' => false])

<a
    {{ $attributes->merge(['class' => ($active ? 'text-white' : 'text-gray-400') . ' text-sm/6 font-semibold inline-flex items-center']) }}>
    @isset($icon)
        <span class="mr-2">{{ $icon }}</span>
    @endisset
    {{ $slot }}
</a>
