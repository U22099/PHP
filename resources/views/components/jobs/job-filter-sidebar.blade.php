@props(['allTags'])

<script>
    let initialSelectedTags = @json(request('tags', []));
    let initialAllAvailableTags = @json($allTags);
</script>
<div x-data="{
    search: '{{ request('search') }}',
    timeframe: '{{ request('timeframe', 'all') }}', // New data property for timeframe
    selectedTags: initialSelectedTags,
    allAvailableTags: initialAllAvailableTags,
    mobileFilterOpen: false,

    applyFilters() {
        let params = new URLSearchParams();
        if (this.search) {
            params.append('search', this.search);
        }
        if (this.timeframe && this.timeframe !== 'all') { // Use timeframe in params
            params.append('timeframe', this.timeframe);
        }
        this.selectedTags.forEach(tag =>
            params.append('tags[]', tag));
        window.location.href = '{{ route('jobs.index') }}?' + params.toString();
    },
    toggleTag(tag) {
        if (this.selectedTags.includes(tag)) {
            this.selectedTags = this.selectedTags.filter(t => t !== tag);
        } else {
            this.selectedTags.push(tag);
        }
    },
    toggleMobileFilter: function() {
        this.mobileFilterOpen = !this.mobileFilterOpen;
    }
}" class="border rounded-lg p-6 sticky lg:top-8">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Filter Jobs</h3>

    <div class="mb-4">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
        <input type="text" x-model.debounce.500ms="search" @keydown.enter="applyFilters()"
            class="w-full rounded-md border border-gray-300 p-2 focus-within:outline-none" placeholder="Search jobs...">
    </div>
    <div class="w-full border p-2 rounded-lg lg:hidden" @click="toggleMobileFilter()">
        <p x-text="(mobileFilterOpen ? 'Hide Filters' : 'Show Filters')" class="text-center font-medium"></p>
    </div>

    <!-- Filter by Timeframe -->
    <div class="mb-4 hidden lg:block"> {{-- Desktop view --}}
        <label class="block text-sm font-medium text-gray-700 mb-1">Posted When</label>
        <div class="mt-2 space-y-2">
            <div class="flex items-center">
                <input id="timeframe-all" name="timeframe" type="radio" x-model="timeframe" value="all"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-all" class="ml-2 block text-sm text-gray-900">All Time</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-today" name="timeframe" type="radio" x-model="timeframe" value="today"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-today" class="ml-2 block text-sm text-gray-900">Today</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-week" name="timeframe" type="radio" x-model="timeframe" value="week"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-week" class="ml-2 block text-sm text-gray-900">This Week</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-month" name="timeframe" type="radio" x-model="timeframe" value="month"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-month" class="ml-2 block text-sm text-gray-900">This Month</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-year" name="timeframe" type="radio" x-model="timeframe" value="year"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-year" class="ml-2 block text-sm text-gray-900">This Year</label>
            </div>
        </div>
    </div>

    <!-- Filter by Tags -->
    <div class="mb-6 hidden lg:block"> {{-- Desktop view --}}
        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
        <div class="mt-2 flex flex-wrap gap-2 max-h-[180px] overflow-y-scroll">
            <template x-for="tag in allAvailableTags" :key="tag">
                <button type="button" @click="toggleTag(tag); applyFilters();"
                    :class="{
                        'bg-indigo-600 text-white': selectedTags.includes(
                            tag),
                        'bg-gray-200 text-gray-700 hover:bg-gray-300': !selectedTags.includes(
                            tag)
                    }"
                    class="px-3 py-1 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    #<span x-text="tag"></span>
                </button>
            </template>
            <template x-if="allAvailableTags.length === 0">
                <p class="text-xs text-gray-500">No tags available.</p>
            </template>
        </div>
    </div>

    <!-- Filter by Timeframe Mobile -->
    <div class="mb-4 mt-4 lg:hidden" x-show="mobileFilterOpen"> {{-- Mobile view --}}
        <label class="block text-sm font-medium text-gray-700 mb-1">Posted When</label>
        <div class="mt-2 space-y-2">
            <div class="flex items-center">
                <input id="timeframe-all-mobile" name="timeframe" type="radio" x-model="timeframe" value="all"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-all-mobile" class="ml-2 block text-sm text-gray-900">All Time</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-today-mobile" name="timeframe" type="radio" x-model="timeframe" value="today"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-today-mobile" class="ml-2 block text-sm text-gray-900">Today</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-week-mobile" name="timeframe" type="radio" x-model="timeframe"
                    value="week" @change="applyFilters()"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-week-mobile" class="ml-2 block text-sm text-gray-900">This Week</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-month-mobile" name="timeframe" type="radio" x-model="timeframe"
                    value="month" @change="applyFilters()"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-month-mobile" class="ml-2 block text-sm text-gray-900">This Month</label>
            </div>
            <div class="flex items-center">
                <input id="timeframe-year-mobile" name="timeframe" type="radio" x-model="timeframe"
                    value="year" @change="applyFilters()"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="timeframe-year-mobile" class="ml-2 block text-sm text-gray-900">This Year</label>
            </div>
        </div>
    </div>

    <!-- Filter by Tags Mobile-->
    <div class="mb-6 lg:hidden" x-show="mobileFilterOpen">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
        <div class="mt-2 flex flex-wrap gap-2 max-h-[200px] overflow-y-scroll">
            <template x-for="tag in allAvailableTags" :key="tag">
                <button type="button" @click="toggleTag(tag); applyFilters();"
                    :class="{
                        'bg-indigo-600 text-white': selectedTags.includes(
                            tag),
                        'bg-gray-200 text-gray-700 hover:bg-gray-300': !selectedTags.includes(
                            tag)
                    }"
                    class="px-3 py-1 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    #<span x-text="tag"></span>
                </button>
            </template>
            <template x-if="allAvailableTags.length===0">
                <p class="text-xs text-gray-500">No tags available.</p>

            </template>
        </div>

    </div>
    <div class="mt-4">
        <x-button @click="applyFilters()" class="w-full" :enableDefaultStyling="false">
            Apply Filters
        </x-button>
    </div>

</div>
