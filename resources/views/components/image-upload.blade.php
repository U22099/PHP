@props(['name', 'label', 'id' => null, 'isPremium' => false, 'existingImage' => null])

<div x-data="{
    isPremium: {{ $isPremium ? 'true' : 'false' }},
    maxSize: {{ $isPremium ? 5 : 2 }} * 1024 * 1024,
    maxSizeMb: {{ $isPremium ? 5 : 2 }},
    remainingUploads: {{ ($isPremium ? env('IMAGE_UPLOAD_LIMIT_PER_USER_PREMIUM') : env('IMAGE_UPLOAD_LIMIT_PER_USER')) - Auth::user()->number_of_images_uploaded_today }},
    dragging: false,
    previewUrl: '{{ $existingImage }}' || null,
    error: '',
    validMimes: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
    handleFileSelect(event) {
        this.processFile(event.target.files[0]);
    },
    handleDrop(event) {
        this.dragging = false;
        if (event.dataTransfer.files.length > 0) {
            const file = event.dataTransfer.files[0];
            this.processFile(file);
            this.$refs.fileInput.files = event.dataTransfer.files;
        }
    },
    processFile(file) {
        this.error = '';
        this.previewUrl = null; // Reset preview

        if (!file) return;

        if (!this.validMimes.includes(file.type)) {
            this.error = 'Invalid file type. Please upload a PNG, JPG, GIF, or SVG.';
            this.$refs.fileInput.value = '';
            return;
        }

        if (file.size > this.maxSize) {
            this.error = `File is too large. Maximum size is ${this.maxSizeMb}MB.`;
            this.$refs.fileInput.value = '';
            return;
        }

        let reader = new FileReader();
        reader.onload = (e) => {
            this.previewUrl = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    removeImage() {
        this.previewUrl = null;
        this.$refs.fileInput.value = '';
        this.error = '';
    },
    init() {
        if (this.existingImage) {
            this.previewUrl = this.existingImage;
        }
    }
}" x-init="init()">
    <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
        x-bind:class="{ 'border-indigo-500': dragging }" @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false" @drop.prevent="handleDrop($event)">
        <div class="space-y-1 text-center">
            <input type="file" name="{{ $name }}" id="{{ $id ?? $name }}" class="sr-only"
                accept="image/jpeg,image/png,image/gif,image/svg+xml" @change="handleFileSelect($event)"
                x-ref="fileInput">
            <template x-if="!previewUrl">
                <label for="{{ $id ?? $name }}" class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48" aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <p
                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload a file</span>
                        </p>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">
                        PNG, JPG, GIF, SVG up to <span x-text="maxSizeMb"></span>MB
                    </p>
                    <p class="text-xs text-gray-500">
                        <span x-text="remainingUploads"></span>
                        free image uploads left</p>
                </label>
            </template>

            <template x-if="previewUrl">
                <div class="relative">
                    <img :src="previewUrl" class="mx-auto max-h-48 rounded-lg object-cover">
                    <button @click.prevent="removeImage" type="button"
                        class="absolute top-0 right-0 -mt-2 -mr-2 bg-white text-red-500 rounded-full p-1 shadow-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <template x-if="error">
        <p x-text="error" class="text-red-500 text-xs mt-2"></p>
    </template>
    {{ $slot }}
</div>
