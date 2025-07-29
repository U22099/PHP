    @props(['type' => 'info'])

    @php
        $classes = 'px-4 py-3 rounded relative';
        $textClasses = 'block sm:inline';

        if ($type === 'success') {
            $classes .= ' bg-green-100 border border-green-400 text-green-700';
        } elseif ($type === 'danger') {
            $classes .= ' bg-red-100 border border-red-400 text-red-700';
        } elseif ($type === 'info') {
            $classes .= ' bg-white border border-yellow-400 text-black';
        }
    @endphp

    <div {{ $attributes->merge(['class' => $classes]) }} role="alert">
        {{ $slot }}
    </div>
