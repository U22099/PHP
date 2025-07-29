@props(['allTags'])

<script>
    let initialSelectedTags = @json(request('tags', []));
    let initialAllAvailableTags = @json($allTags);
</script>
<div x-data="{
    search: '{{ request('search') }}',
    userRole: '{{ request('user_role', 'all') }}',
    selectedTags: initialSelectedTags,
    allAvailableTags: initialAllAvailableTags,
    mobileFilterOpen: false,

    applyFilters() {
        let params = new URLSearchParams();
        if (this.search) {
            params.append('search', this.search);
        }
        if (this.userRole && this.userRole !== 'all') {
            params.append('user_role', this.userRole);
        }
        this.selectedTags.forEach(tag =>
            params.append('tags[]', tag));
        window.location.href = '{{ route('posts.index') }}?' + params.toString();
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
    <h3 class="text-xl font-bold mb-4 text-gray-800">Filter Posts</h3>

    <!-- Search by Keyword -->
    <div class="mb-4">
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
        <input type="text" x-model.debounce.500ms="search" @keydown.enter="applyFilters()"
            class="w-full rounded-md border border-gray-300 p-2 focus-within:outline-none" placeholder="Search posts...">
    </div>
    <div class="w-full border p-2 rounded-lg lg:hidden" @click="toggleMobileFilter()">
        <p x-text="(mobileFilterOpen ? 'Hide Filters' : 'Show Filters')" class="text-center font-medium"></p>
    </div>

    <!-- Filter by User Role-->
    <div class="mb-4 hidden lg:block">
        <label class="block text-sm font-medium text-gray-700 mb-1">Posted By</label>
        <div class="mt-2 space-y-2">
            <div class="flex items-center">
                <input id="role-all" name="user_role" type="radio" x-model="userRole" value="all"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-all" class="ml-2 block text-sm text-gray-900">All Posts</label>
            </div>
            <div class="flex items-center">
                <input id="role-client" name="user_role" type="radio" x-model="userRole" value="client"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-client" class="ml-2 block text-sm text-gray-900">Clients</label>
            </div>
            <div class="flex items-center">
                <input id="role-freelancer" name="user_role" type="radio" x-model="userRole" value="freelancer"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-freelancer" class="ml-2 block text-sm text-gray-900">Freelancers</label>
            </div>
        </div>
    </div>

    <!-- Filter by Tags -->
    <div class="mb-6 hidden lg:block">
        <label class="block text-sm font-medium text-gray-700 mb-1">Hashtags</label>
        <div class="mt-2 flex flex-wrap gap-2 max-h-[150px] overflow-y-scroll">
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
                <p class="text-xs text-gray-500">No hashtags available.</p>
            </template>
        </div>
    </div>

    <!-- Filter by User Role Mobile-->
    <div class="mb-4 mt-4 lg:hidden" x-show="mobileFilterOpen">
        <label class="block text-sm font-medium text-gray-700 mb-1">Posted By</label>
        <div class="mt-2 space-y-2">
            <div class="flex items-center">
                <input id="role-all" name="user_role" type="radio" x-model="userRole" value="all"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-all" class="ml-2 block text-sm text-gray-900">All Posts</label>
            </div>
            <div class="flex items-center">
                <input id="role-client" name="user_role" type="radio" x-model="userRole" value="client"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-client" class="ml-2 block text-sm text-gray-900">Clients</label>
            </div>
            <div class="flex items-center">
                <input id="role-freelancer" name="user_role" type="radio" x-model="userRole" value="freelancer"
                    @change="applyFilters()" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                <label for="role-freelancer" class="ml-2 block text-sm text-gray-900">Freelancers</label>
            </div>
        </div>
    </div>
    <!-- Filter by Tags -->
    <div class="mb-6 lg:hidden" x-show="mobileFilterOpen">
        <label class="block text-sm font-medium text-gray-700 mb-1">Hashtags</label>
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
            <template x-if="allAvailableTags.length === 0">
                <p class="text-xs text-gray-500">No hashtags available.</p>
            </template>
        </div>
    </div>

    <div class="mt-4">
        <x-button @click="applyFilters()" class="w-full" :enableDefaultStyling="false">
            Apply Filters
        </x-button>
    </div>
</div>
