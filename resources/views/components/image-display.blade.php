@props(['images' => []])

<script>
    let images = @json($images) || [];
</script>
<div x-data="{
    open: false,
    currentImageSrc: '',
    currentImageAlt: '',
    allImagesOpen: false,
    allImages: images || [],
    openModal(src, alt) {
        this.currentImageSrc = src;
        this.currentImageAlt = alt;
        this.open = true;
    },
    openAllImages() {
        if (this.allImages.length > 0) {
            this.currentImageAlt = 'Gallery Images';
            this.open = true;
            this.allImagesOpen = true;
        }
    },
    closeModal() {
        this.currentImageSrc = '';
        this.currentImageAlt = '';
        this.allImagesOpen = false;
        this.open = false;
    },
}" @keydown.escape.window="open = false" class="relative w-full h-full">
    {{-- Image Gallery Grid --}}
    <div x-show="allImages.length > 0" class="grid gap-2 w-full lg:max-w-xl mx-auto"
        :class="{
            'grid-cols-1': allImages.length === 1,
            'grid-cols-2': allImages.length >= 2,
        }">
        <template x-for="(image, index) in allImages.slice(0, 4)" :key="index" class="w-full h-60">
            <div class="relative aspect-square overflow-hidden rounded-lg cursor-pointer group bg-gray-100 flex items-center justify-center h-60 w-full"
                @click="openModal(image, 'Gallery Image ' + (index + 1))">
                <img :src="image" :alt="'Gallery Image ' + (index + 1)"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                <template x-if="allImages.length > 4 && index === 3">
                    <div class="absolute inset-0 bg-black/60 text-white flex items-center justify-center font-bold text-lg cursor-pointer z-10"
                        @click.stop="openAllImages()">
                        +<span x-text="allImages.length - 4"></span> More
                    </div>
                </template>
            </div>
        </template>
    </div>
    <div x-show="allImages.length === 0" class="text-center p-4 text-gray-500">
        No images to display yet.
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center w-full h-full p-2" x-cloak>
        <div class="relative max-h-[90vh] w-full h-full lg:w-1/2 lg:h-[50vh] flex flex-col bg-black/90 p-4 rounded-md"
            @click.outside="closeModal()">
            <button @click="closeModal()"
                class="absolute top-0 right-0 text-white text-4xl font-bold cursor-pointer hover:text-gray-300 pr-4"
                aria-label="Close">
                &times;
            </button>

            <template x-if="!allImagesOpen">
                <div class="flex flex-col items-center justify-center h-full w-full">
                    <img :src="currentImageSrc" :alt="currentImageAlt" class="w-full h-60 object-contain mx-auto">
                    <p x-text="currentImageAlt" class="mt-4 text-center text-gray-300 text-sm md:text-base"></p>
                </div>
            </template>

            <template x-if="allImagesOpen">
                <div class="flex flex-col h-full w-full">
                    <p x-text="currentImageAlt" class="text-center text-gray-300 text-sm"></p>

                    <div class="flex flex-wrap gap-2 w-full h-full overflow-y-scroll mt-4">
                        <template x-for="(image, index) in allImages" :key="index">
                            <img :src="image" :alt="image"
                                class="w-full lg:w-[48%] h-60 object-contain">
                        </template>
                    </div>
            </template>
        </div>
    </div>
</div>
