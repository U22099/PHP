@props(['images' => null, 'type' => 'post'])

<div x-data="{
    open: false,
    currentImageSrc: '',
    currentImageAlt: '',
    allImages: ($type === 'post' ? post.images : $type === 'job' ? job.screenshots : $type === 'project' ? project.images : []) || $images || [],
    openModal(src, alt) {
        this.currentImageSrc = src;
        this.currentImageAlt = alt;
        this.open = true;
    },
    openAllImages() {
        // This is where you'd implement a more sophisticated gallery viewer
        // for all images, e.g., an Alpine.js carousel component.
        // For now, we'll just open the modal with the first image
        // and maybe add a message.
        if (this.allImages.length > 0) {
            this.openModal(this.allImages[0].full_url, this.allImages[0].alt || 'Gallery Image');
            this.currentImageAlt = 'Showing more images. (Full gallery view to be implemented!)';
        }
    }
}" @keydown.escape.window="open = false" class="relative">
    {{-- Image Gallery Grid --}}
    <div x-show="allImages.length > 0" class="grid gap-2 max-w-xl mx-auto"
        :class="{
            'grid-cols-1': allImages.length === 1,
            'grid-cols-2': allImages.length >= 2,
        }">
        <template x-for="(image, index) in allImages.slice(0, 4)" :key="index">
            <div class="relative aspect-square overflow-hidden rounded-lg cursor-pointer group bg-gray-100 flex items-center justify-center"
                @click="openModal(image, image || 'Gallery Image ' + (index + 1))">
                <img :src="image" :alt="image || 'Gallery Image ' + (index + 1)"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                <template x-if="allImages.length > 4 && index === 3">
                    <div class="absolute inset-0 bg-black/60 text-white flex items-center justify-center font-bold text-lg cursor-pointer"
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

    {{-- The Modal Structure (remains the same as before) --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" @click.outside="closeModal()"
        x-cloak>
        <div class="relative max-w-4xl max-h-[90vh] w-full bg-transparent flex flex-col">
            <button @click="closeModal()"
                class="absolute -top-10 right-0 text-white text-4xl font-bold cursor-pointer hover:text-gray-300"
                aria-label="Close">
                &times;
            </button>
            <img :src="currentImageSrc" :alt="currentImageAlt" class="max-w-full max-h-[80vh] object-contain mx-auto">
            <p x-text="currentImageAlt" class="mt-4 text-center text-gray-300 text-sm md:text-base"></p>
        </div>
    </div>
</div>
