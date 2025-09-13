@props(['url' => '', 'from', 'class'])

<div x-data="{ open: false, copied: false, url: '{{ $url }}' || `{{ url('/posts') }}/${post.id}` }" class="relative">
    <button @click="open = true"
        class="{{ $class }}">
        <x-heroicon-o-share class="h-6 w-6 md:h-5 md:w-5" />
        <span class="hidden md:inline">Share</span>
    </button>

    <template x-if="open">
        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
            <div class="bg-white rounded-lg p-6 w-full max-w-sm mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Share this {{ $from }}</h3>
                    <button @click="open = false"
                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </div>

                <p class="text-sm text-gray-600 mb-2">Share this link via</p>
                <div class="flex justify-center space-x-4 mb-4">
                    <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out this {{ $from }} on {{ config('app.name') }}!:  ' + url)"
                        target="_blank" class="text-green-500 hover:text-green-700">
                        <x-ri-whatsapp-fill class="w-10 h-10" />
                    </a>
                    <a :href="'https://x.com/intent/tweet?url=' + encodeURIComponent(url) +
                        '&text=' + encodeURIComponent('Check out this {{ $from }} on {{ config('app.name') }}!: ')"
                        target="_blank" class="text-gray-800 hover:text-gray-600">
                        <x-ri-twitter-x-fill class="w-10 h-10" />
                    </a>
                    <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url)" target="_blank"
                        class="text-blue-600 hover:text-blue-800">
                        <x-ri-facebook-box-fill class="w-10 h-10" />
                    </a>
                </div>

                <p class="text-sm text-gray-600 mb-2">Or copy link</p>
                <div class="flex items-center space-x-2">
                    <input type="text" :value="url" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <button
                        @click="
                            navigator.clipboard.writeText(url).then(() => {
                                copied = true;
                                setTimeout(() => copied = false, 2000);
                            })
                        "
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" x-text="copied ? 'Copied' : 'Copy'">
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
