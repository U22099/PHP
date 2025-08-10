@props([
    'fieldname',
    'label' => $fieldname,
    'data' => null,
    'rootClass' => 'flex flex-col w-full',
    'type' => 'text',
    'textarea' => false,
    'rows' => 3,
    'characterLimit' => null,
])

<div class="{{ $rootClass }}">
    <label for="{{ $fieldname }}"
        class="block text-sm font-medium leading-6 text-gray-900 capitalize">{{ $label }}</label>

    <div class="mt-2 w-full" x-data="{
        showPassword: false,
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword
        },
        initialValue: {{ Js::from(old($fieldname) ?? $data) }},
        currentLength: 0,
        limit: {{ $characterLimit ?? 'null' }},
        init() {
            this.currentLength = this.initialValue.length;
        }
    }" x-init="init()">
        <div
            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">

            @if ($textarea === true)
                @isset($icon)
                    <div class="flex p-3 pr-1 items-start">
                        {{ $icon }}
                    </div>
                @endisset
                <textarea rows={{ $rows }}
                    {{ $attributes->merge(['class' => 'block flex-1 border-0 bg-transparent p-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 focus:outline-none']) }}
                    name="{{ $fieldname }}" id="{{ $fieldname }}" x-on:input="currentLength = $event.target.value.length"
                    @if ($characterLimit) maxlength="{{ $characterLimit }}" @endif>{{ old($fieldname) ?? $data }}</textarea>
            @else
                @isset($icon)
                    <div class="flex px-3 pr-1 items-center">
                        {{ $icon }}
                    </div>
                @endisset
                <input x-bind:type="showPassword ? 'text' : '{{ $type }}'"
                    {{ $attributes->merge(['class' => 'block flex-1 border-0 bg-transparent p-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 focus:outline-none']) }}
                    name="{{ $fieldname }}" id="{{ $fieldname }}" value="{{ old($fieldname) ?? $data }}"
                    x-on:input="currentLength = $event.target.value.length"
                    @if ($characterLimit) maxlength="{{ $characterLimit }}" @endif />
            @endif

        </div>
        @if ($characterLimit)
            <p class="mt-1 text-xs text-gray-500 text-right" x-text="`${currentLength} / ${limit}`"
                :class="{ 'text-red-600': currentLength > limit }">
            </p>
        @endif
        {{ $slot }}
    </div>
</div>
