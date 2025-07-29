@props(['allTags'])

<script>
    let initialSelectedTags = @json(request('tags', []));
    let initialAllAvailableTags = @json($allTags);
</script>
<div x-data="{
    search: '{{ request('search') }}',
    timeframe: '{{ request('timeframe', 'all') }}',
    budget_range: '{{ request('budget_range', 'all') }}',
    time_range: '{{ request('time_range', 'all') }}',
    currency_id: '{{ request('currency_id', 'all') }}',
    selectedTags: initialSelectedTags,
    allAvailableTags: initialAllAvailableTags,
    moreFilterOpen: false,

    applyFilters() {
        let params = new URLSearchParams();
        if (this.search) {
            params.append('search', this.search);
        }
        if (this.timeframe && this.timeframe !== 'all') {
            params.append('timeframe', this.timeframe);
        }
        if (this.budget_range && this.budget_range !== 'all') {
            params.append('budget_range', this.budget_range);
        }
        if (this.time_range && this.time_range !== 'all') {
            params.append('time_range', this.time_range);
        }
        if (this.currency_id && this.currency_id !== 'all') {
            params.append('currency_id', this.currency_id);
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
        this.moreFilterOpen = !this.moreFilterOpen;
    }
}" class="border rounded-lg p-6 sticky lg:top-8">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Filter Jobs</h3>

    <div class="mb-4">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
        <input type="text" x-model.debounce.500ms="search" @keydown.enter="applyFilters()"
            class="w-full rounded-md border border-gray-300 p-2 focus-within:outline-none" placeholder="Search jobs...">
    </div>
    <div class="w-full border p-2 rounded-lg cursor-pointer" @click="toggleMobileFilter()">
        <p x-text="(moreFilterOpen ? 'Hide Filters' : 'Show Filters')" class="text-center font-medium"></p>
    </div>

    <div class="grid grid-cols-2 mt-2 w-full" x-show="moreFilterOpen">
        <!-- Timeframe and Budget Range Filters -->
        <div class="mb-4 col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Posted When:</label>
            <div class="mt-2 space-y-2">
                @foreach (['all' => 'All Time', 'today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'year' => 'This Year'] as $value => $label)
                    <div class="flex items-center">
                        <input id="timeframe-{{ $value }}" name="timeframe" type="radio" x-model="timeframe"
                            value="{{ $value }}" @change="applyFilters()"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 cursor-pointer">
                        <label for="timeframe-{{ $value }}"
                            class="ml-2 block text-sm text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4 col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Budget Range:</label>
            <div class="mt-2 space-y-2">
                @foreach ([
        'all' => 'All Range',
        '0-10000' => '0 - 10K',
        '10000-50000' => '10K - 50K',
        '50000-100000' => '50K - 100K',
        '100000-infinite' => '100K - <span class="text-indigo-600 font-medium text-2xl ml-2">&infin;</span>',
    ] as $value => $label)
                    <div class="flex items-center">
                        <input id="budget_range-{{ $loop->index }}" name="budget_range" x-model="budget_range"
                            type="radio" value="{{ $value }}" @change="applyFilters()"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 cursor-pointer">
                        <label for="budget_range-{{ $loop->index }}"
                            class="ml-2 flex text-sm items-center text-gray-900">{!! $label !!}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4 col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Time Range:</label>
            <div class="mt-2 space-y-2 w-full flex flex-wrap items-center gap-2">
                @foreach (['all' => 'All Time', '1-7' => '1 - 7 Days', '7-31' => '1 Weeks - 1 Month', '31-93' => '1 Month - 3 Months', '93-infinite' => '3Months+'] as $value => $label)
                    <div class="flex items-center w-fit">
                        <input id="time_range-{{ $loop->index }}" name="time_range" x-model="time_range"
                            type="radio" value="{{ $value }}" @change="applyFilters()"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 cursor-pointer">
                        <label for="time_range-{{ $loop->index }}"
                            class="ml-2 flex text-sm items-center text-gray-900">{!! $label !!}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Filter by Currency Desktop-->
    <div class="mb-4 hidden lg:block">
        <x-jobs.job-currency-select />
    </div>

    <!-- Filter by Tags Desktop-->
    <div class="mb-6 hidden lg:block">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
        <div class="mt-2 flex flex-wrap gap-2 max-h-[150px] overflow-y-scroll">
            <template x-for="tag in allAvailableTags" :key="'desktop-' + tag">
                <button type="button" @click="toggleTag(tag); applyFilters();"
                    :class="{
                        'bg-indigo-600 text-white': selectedTags.includes(
                            tag),
                        'bg-gray-200 text-gray-700 hover:bg-gray-300': !selectedTags.includes(
                            tag)
                    }"
                    class="px-3 py-1 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span x-text="tag"></span>
                </button>
            </template>
            <template x-if="allAvailableTags.length === 0">
                <p class="text-xs text-gray-500">No tags available.</p>
            </template>
        </div>
    </div>

    <!-- Filter by Currency Mobile-->
    <div class="mb-4 lg:hidden" x-show="moreFilterOpen">
        <x-jobs.job-currency-select />
    </div>

    <!-- Filter by Tags Mobile-->
    <div class="mb-6 lg:hidden" x-show="moreFilterOpen">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
        <div class="mt-2 flex flex-wrap gap-2 max-h-[200px] overflow-y-scroll">
            <template x-for="tag in allAvailableTags" :key="'mobile-' + tag">
                <button type="button" @click="toggleTag(tag); applyFilters();"
                    :class="{
                        'bg-indigo-600 text-white': selectedTags.includes(
                            tag),
                        'bg-gray-200 text-gray-700 hover:bg-gray-300': !selectedTags.includes(
                            tag)
                    }"
                    class="px-3 py-1 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span x-text="tag"></span>
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
