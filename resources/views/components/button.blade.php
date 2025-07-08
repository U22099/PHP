@props(['type', 'active' => true])

@if ($type == 'link')
    <a {{ $attributes }}
        class="{{ $active ? 'text-white' : 'text-gray-300' }} inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">{{ $slot }}</a>
@else
    <button {{ $attributes }}
        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">{{ $slot }}</button>
@endif
