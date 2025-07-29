@php
    $currencies = \App\Models\Currency::all();
@endphp
<div>
    <label for="currency" class="block text-sm font-medium leading-6 text-gray-900 capitalize mb-3">Currency:</label>
    <select name="currency_id" id="currency"
        class="ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 bg-white appearance-none rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none"
        @change="applyFilters()" x-model="currency_id">
        <option value="all">All Currency</option>
        @foreach ($currencies as $currency)
            <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->symbol }}</option>
        @endforeach
    </select>
</div>
