@props(['fieldname', 'label' => $fieldname, 'data' => null, 'rootClass' => 'flex flex-col w-full'])

<div class="{{ $rootClass }}">
    <label for="{{ $fieldname }}"
        class="block text-sm font-medium leading-6 text-gray-900 capitalize">{{ $label }}</label>
    <div class="mt-2 w-full">
        <div
            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
            <input
                {{ $attributes->merge(['class' => 'block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6']) }}
                name="{{ $fieldname }}" id="{{ $fieldname }}" value="{{ old($fieldname) ?? $data }}" />
        </div>
        {{ $slot }}
    </div>
</div>
