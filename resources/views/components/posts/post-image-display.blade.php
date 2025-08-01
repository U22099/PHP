<div class="relative w-full h-full mt-4">
    {{-- Image Gallery Grid --}}
    <div x-show="post.images.length > 0" class="grid gap-2 w-full lg:max-w-xl mx-auto"
        :class="{
            'grid-cols-1': post.images.length === 1,
            'grid-cols-2': post.images.length >= 2,
        }">
        <template x-for="(image, index) in post.images.slice(0, 4)" :key="index" class="w-full h-60">
            <div
                class="relative aspect-square overflow-hidden rounded-lg cursor-pointer group bg-gray-100 flex items-center justify-center h-24 lg:h-48 w-full">
                <img :src="image" :alt="'Gallery Image ' + (index + 1)"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                <template x-if="post.images.length > 4 && index === 3">
                    <div
                        class="absolute inset-0 bg-black/60 text-white flex items-center justify-center font-bold text-lg cursor-pointer z-10">
                        +<span x-text="post.images.length - 4"></span> More
                    </div>
                </template>
            </div>
        </template>
    </div>
    <div x-show="post.images.length === 0" class="text-center p-4 text-gray-500">
        No images to display yet.
    </div>
</div>
