@props(['fieldname', 'is_checked' => false, 'label' => $fieldname])

<div x-data="{ is_checked: {{ $is_checked ? 'true' : 'false' }} }" class="w-full flex items-start">
    <label for="{{ $fieldname }}" class="flex items-center cursor-pointer w-full justify-between">
        <div class="flex items-center gap-2 font-bold text-gray-900">
            @isset($icon)
                {{ $icon }}
            @endisset
            <span>{{ $label }}</span>
        </div>
        <div class="relative">
            <input type="checkbox" id="{{ $fieldname }}" name="{{ $fieldname }}" class="sr-only" x-model="is_checked">

            <div class="block w-10 h-6 rounded-full" :class="is_checked ? 'bg-indigo-600' : 'bg-gray-200'"></div>

            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform"
                :class="is_checked ? 'translate-x-full' : ''"></div>
        </div>
    </label>
</div>
