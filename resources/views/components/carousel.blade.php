@props(['width', 'height' => 48])

<div x-data="{
    currentIndex: 0,
    totalItems: 0,
    perfectContainerWidth: '100%',
    init() {
        const containerWidth = this.$refs.carouselItems.offsetWidth;
        const itemsPerPage = containerWidth / (@js($width) + 12);
        this.totalItems = Math.ceil(this.$refs.carouselItems.childElementCount / itemsPerPage);
        this.perfectContainerWidth = (Math.floor(itemsPerPage) * (@js($width) + 12)) + 'px';
        console.log(this.totalItems, this.perfectContainerWidth);
    },
    prev() {
        this.currentIndex = (this.currentIndex === 0) ? this.currentIndex : this.currentIndex - 1;
    },
    next() {
        this.currentIndex = (this.currentIndex === this.totalItems - 1) ? this.currentIndex : this.currentIndex + 1;
    },
}" x-init="init()"
    x-bind:class="'relative mx-auto w-[' + perfectContainerWidth + '] overflow-hidden'">
    <div x-ref="carouselItems" class="flex h-{{ $height }} transition-transform ease-in-out duration-500 gap-3 -z-10"
        :style="`transform: translateX(${-currentIndex*100}%)`">
        {{ $slot }}
    </div>

    <button @click="prev()" type="button"
        class="absolute top-0 start-0 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
            <x-heroicon-s-chevron-left class="w-4 h-4 rtl:rotate-180" />
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button @click="next()" type="button"
        class="absolute top-0 end-0 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
            <x-heroicon-s-chevron-right class="w-4 h-4 rtl:rotate-180" />
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
