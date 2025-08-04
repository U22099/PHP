@props(['fieldname', 'label' => $fieldname, 'data' => 0, 'rootClass' => 'flex flex-col w-full'])

<div class="{{ $rootClass }}">
    <label for="{{ $fieldname }}"
        class="block text-sm font-medium leading-6 text-gray-900 capitalize">{{ $label }}</label>
    <div class="flex flex-col mt-2 w-full" x-data="{
        number: parseInt('{{ old($fieldname) ?? $data }}'),
        output: parseInt('{{ old($fieldname) ?? $data }}'),
        period: 'day',
        setPeriod(period) {
            const formerPeriod = this.period;
            this.period = period;
            this.number = this.formatNumber(formerPeriod);
            this.output = this.setOutput();
            this.period += this.number > 1 ? 's' : '';
        },
        formatNumber(formerPeriod) {
            const fromDays = this.period.includes('month') ? this.number / 30 : this.period.includes('week') ? this.number / 7 : this.number;
            const fromWeeks = this.period.includes('month') ? this.number / 4 : this.period.includes('week') ? this.number : this.number * 7;
            const fromMonths = this.period.includes('month') ? this.number : this.period.includes('week') ? this.number * 4 : this.number * 30;
    
            return Math.ceil(formerPeriod.includes('day') ? fromDays : formerPeriod.includes('week') ? fromWeeks : fromMonths);
        },
        setOutput() {
            const multiplier = this.period.includes('month') ? 30 : this.period.includes('week') ? 7 : 1;
            return this.number * multiplier;
        },
        updateNumber() {
            this.number = this.$refs.input.value;
            this.output = this.setOutput();
        },
        init() {
            this.setPeriod('day');
        },
    }" x-init="init()">
        <div
            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
            @isset($icon)
                <div class="flex px-3 pr-1 items-center">
                    {{ $icon }}
                </div>
            @endisset
            <input type="number" name="{{ $fieldname }}" id="{{ $fieldname }}" x-model="output" hidden />
            <input type="number" x-ref="input"
                {{ $attributes->merge(['class' => 'block flex-1 border-0 bg-transparent p-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 focus:outline-none']) }}
                x-model="number" @input="updateNumber()" />
            <div class="flex text-sm pl-2 px-3 items-center capitalize" x-text="period"></div>
        </div>
        <div class="flex gap-4 mx-auto w-fit mt-2">
            <button type="button"
                x-bind:class="(period.includes('day') ? 'bg-indigo-600 text-white' : 'text-black') +
                ' px-3 py-1.5 cursor-pointer border font-semibold text-sm rounded-lg'"
                @click="setPeriod('day')" x-text="number > 1 ? 'Days' : 'Day'"></button>
            <button type="button"
                x-bind:class="(period.includes('week') ? 'bg-indigo-600 text-white' : 'text-black') +
                ' px-3 py-1.5 cursor-pointer border font-semibold text-sm rounded-lg'"
                @click="setPeriod('week')" x-text="number > 1 ? 'Weeks' : 'Week'"></button>
            <button type="button"
                x-bind:class="(period.includes('month') ? 'bg-indigo-600 text-white' : 'text-black') +
                ' px-3 py-1.5 cursor-pointer border font-semibold text-sm rounded-lg'"
                @click="setPeriod('month')" x-text="number > 1 ? 'Months' : 'Month'"></button>
        </div>
        {{ $slot }}
    </div>
</div>
