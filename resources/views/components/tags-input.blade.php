@props([
    'name', // The name for the hidden input array (e.g., 'tags')
    'label' => 'Tags', // The label for the input field
    'initialTags' => [], // An array of tags already selected (e.g., from an old post)
    'availableTags' => [], // The full list of available tags for suggestions
    'placeholder' => 'Add tags...', // Placeholder for the input
])

<div x-data="{
    allTags: {{ json_encode($availableTags) }}, // Full list for suggestions
    selectedTags: {{ json_encode($initialTags) }}, // Current selected tags
    searchTerm: '', // What the user is typing
    showSuggestions: false, // Control floating menu visibility
    activeSuggestionIndex: -1, // For keyboard navigation
    get filteredTags() {
        filtered = this.allTags.filter(tag => {
            return tag.toLowerCase().includes(this.searchTerm.toLowerCase()) &&
                !this.selectedTags.includes(tag); // Don't suggest already selected tags
        });
        if (filtered.length < 1) {
            return [this.searchTerm];
        } else return filtered;
    },
    addTag(tag) {
        if (tag && !this.selectedTags.includes(tag)) {
            this.selectedTags.push(tag);
            this.searchTerm = ''; // Clear input after adding
            //this.showSuggestions = false;
            this.activeSuggestionIndex = -1;
        }
    },
    removeTag(tagToRemove) {
        this.selectedTags = this.selectedTags.filter(tag => tag !== tagToRemove);
    },
    handleInputFocus() {
        this.showSuggestions = true;
    },
    handleInputBlur() {
        // Delay hiding to allow click events on suggestions to fire
        setTimeout(() => {
            this.showSuggestions = false;
            this.activeSuggestionIndex = -1;
        }, 150);
    },
    handleKeyDown(event) {
        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                this.activeSuggestionIndex = (this.activeSuggestionIndex + 1) % this.filteredTags.length;
                break;
            case 'ArrowUp':
                event.preventDefault();
                this.activeSuggestionIndex = (this.activeSuggestionIndex - 1 + this.filteredTags.length) % this.filteredTags.length;
                break;
            case 'Enter':
                event.preventDefault();
                if (this.activeSuggestionIndex !== -1) {
                    this.addTag(this.filteredTags[this.activeSuggestionIndex]);
                } else if (this.searchTerm.trim() !== '') {
                    this.addTag(this.searchTerm.trim());
                }
                break;
            case 'Tab':
                if (this.activeSuggestionIndex !== -1) {
                    this.addTag(this.filteredTags[this.activeSuggestionIndex]);
                    event.preventDefault();
                }
                break;
            case 'Escape':
                this.showSuggestions = false;
                this.activeSuggestionIndex = -1;
                break;
            case 'Backspace':
                if (this.searchTerm === '' && this.selectedTags.length > 0) {
                    event.preventDefault();
                    this.removeTag(this.selectedTags[this.selectedTags.length - 1]);
                }
                break;
        }
    }
}" @click.away="handleInputBlur()" {{-- Hide suggestions when clicking outside --}} class="mb-4">

    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>

    <div class="mt-2 relative">
        <!-- Display Selected Tags (Tokens) -->
        <div x-show="selectedTags.length > 0"
            class="flex flex-wrap gap-2 mb-2 p-2 border border-gray-300 rounded-md bg-gray-50 min-h-[40px]">
            <template x-for="(tag, index) in selectedTags" :key="index">
                <span
                    class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-sm font-medium text-indigo-800">
                    <span x-text="tag"></span>
                    <button type="button" @click="removeTag(tag)"
                        class="-mr-0.5 ml-1.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:bg-indigo-500 focus:text-white focus:outline-none">
                        <span class="sr-only">Remove tag</span>
                        <x-heroicon-o-x-mark class="h-2 w-2" />
                    </button>
                </span>
            </template>
        </div>

        <!-- Tag Input Field -->
        <input type="text" x-model="searchTerm" x-ref="tagInput" @focus="handleInputFocus()"
            @keydown="handleKeyDown($event)"
            class="block w-full rounded-md px-2 py-1.5 text-gray-900 border border-gray-3 focus-within:outline-none sm:text-sm sm:leading-6"
            placeholder="{{ $placeholder }}">

        <!-- Floating Suggestions Menu -->
        <div x-show="showSuggestions && filteredTags.length > 0" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-10 mt-1 w-full max-h-60 overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            <template x-for="(tag, index) in filteredTags" :key="index">
                <div @click="addTag(tag)"
                    :class="{
                        'bg-indigo-500 text-white': index === activeSuggestionIndex,
                        'text-gray-900': index !==
                            activeSuggestionIndex
                    }"
                    class="relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                    <span x-text="tag" class="block truncate"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Hidden Inputs for Form Submission -->
    <template x-for="(tag, index) in selectedTags" :key="index">
        <input type="hidden" :name="`{{ $name }}[]`" :value="tag">
    </template>
</div>
