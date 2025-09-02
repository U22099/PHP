@props(['name', 'label', 'id' => null, 'isPremium', 'initialUrls' => null, 'initialPublicIds' => null])

<div x-data="{
    imageUrls: [],
    imagePublicIds: [],
    remainingUploads: {{ ($isPremium ? env('IMAGE_UPLOAD_LIMIT_PER_USER_PREMIUM') : env('IMAGE_UPLOAD_LIMIT_PER_USER')) - Auth::user()->number_of_images_uploaded_today }},
    maxSize: {{ $isPremium ? 5 : 2 }} * 1024 * 1024,
    maxSizeMb: {{ $isPremium ? 5 : 2 }},
    dragging: false,
    loading: null,
    errors: [],
    handleFileSelect(event) {
        this.uploadFiles(event.target.files);
    },
    handleDrop(event) {
        this.dragging = false;
        this.uploadFiles(event.dataTransfer.files);
    },
    async uploadFiles(files) {
        this.loading = 'Uploading...';
        this.errors = [];
        const formData = new FormData();

        if (files.length === 0) {
            this.errors.push('No files selected.');
            this.loading = null;
            return;
        }

        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        try {
            const response = await fetch('/image/upload', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Image upload failed.');
            }

            const data = await response.json();
            this.remainingUploads = data.remaining_uploads;

            if (Array.isArray(data.images)) {
                for (let i = 0; i < data.images.length; i++) {
                    const img = data.images[i];
                    this.imageUrls = [...this.imageUrls, img.url];
                    this.imagePublicIds = [...this.imagePublicIds, img.public_id];
                }
            }
        } catch (error) {
            this.errors.push(error.message || 'An unexpected error occurred during upload.');
            console.error('Upload Error:', error);
        } finally {
            this.loading = null;
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
        }
    },
    async deleteImage(public_id, index) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }
        this.loading = 'Deleting...';
        this.errors = [];

        try {
            const response = await fetch('/image/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
                },
                body: JSON.stringify({ public_id: public_id }),
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Image deletion failed.');
            }

            this.imageUrls.splice(index, 1);
            this.imagePublicIds.splice(index, 1);
            this.remainingUploads = data.remaining_uploads;
        } catch (error) {
            this.errors.push(error.message || 'An unexpected error occurred during deletion.');
            console.error('Delete Error:', error);
        } finally {
            this.loading = null;
        }
    },
    init(imageUrls, publicIds) {
        this.imageUrls = imageUrls;
        this.imagePublicIds = publicIds;
    }
}" x-init='init(@json($initialUrls ?? []), @json($initialPublicIds ?? []))'>

    <div class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pb-6 pt-5"
        x-bind:class="{ 'border-indigo-500': dragging }" @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false" @drop.prevent="handleDrop($event)">

        <label for="image-selections" class="space-y-1 cursor-pointer text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                aria-hidden="true">
                <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L40 32M4 32l4-4m0 0l4 4m-4-4l4 4M20 12h4m-4 0v4m-4-4h4"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <p class="relative rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none">
                    <span>Upload images</span>
                    <input type="file" name="image-selections[]" id="image-selections" multiple class="sr-only"
                        accept="image/jpeg,image/png,image/gif,image/svg+xml" @change="handleFileSelect($event)"
                        x-ref="fileInput">
                </p>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG up to <span x-text="maxSizeMb"></span>MB each</p>
            <p class="text-xs text-gray-500"><span x-text="remainingUploads"></span> free image uploads left</p>
        </label>
    </div>

    {{-- Loader --}}
    <div x-show="loading" class="mt-4 flex items-center justify-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <span x-text="loading"></span>
    </div>

    {{-- Errors --}}
    <div x-show="errors.length > 0" class="mt-4">
        <template x-for="error in errors" :key="error">
            <p x-text="error" class="text-red-600 text-sm"></p>
        </template>
    </div>

    {{-- Image Previews --}}
    <div class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-show="imageUrls.length > 0">
        <template x-for="(imageUrl, index) in imageUrls" :key="index">
            <div class="relative group aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border border-gray-200">
                <img :src="imageUrl" alt="Uploaded Image" class="object-cover w-full h-48">
                <button type="button" @click="deleteImage(imagePublicIds[index], index)"
                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    {{-- <div class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-show="imageUrls.length > 0">
        <x-carousel :width="192">
            <template x-for="(imageUrl, index) in imageUrls" :key="index">
                <div class="relative group aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border border-gray-200">
                    <img :src="imageUrl" alt="Uploaded Image" class="object-cover w-full h-48">
                    <button type="button" @click="deleteImage(imagePublicIds[index], index)"
                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </template>
        </x-carousel>
    </div> --}}

    {{-- Hidden input to store image URLs for form submission --}}
    <template x-for="(imageUrl, index) in imageUrls" :key="'hidden-input-' + index">
        <input type="hidden" name="{{ $name }}[]" :value="imageUrl">
    </template>
    <template x-for="(publicId, index) in imagePublicIds" :key="'hidden-input-' + index">
        <input type="hidden" name="publicIds[]" :value="publicId">
    </template>
    {{ $slot }}
</div>
