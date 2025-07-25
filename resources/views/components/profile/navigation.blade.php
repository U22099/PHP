@props(['userRole'])

<nav class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
    <div class="flex border-b border-gray-200">
        <button @click="currentTab = 'posts'"
            :class="{ 'border-indigo-500 text-indigo-600': currentTab === 'posts', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'posts' }"
            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 ease-in-out flex-1 text-center flex items-center justify-center">
            <x-heroicon-o-document-text class="h-5 w-5 mr-2" />
            My Posts
        </button>
        <button @click="currentTab = 'articles'"
            :class="{ 'border-indigo-500 text-indigo-600': currentTab === 'articles', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'articles' }"
            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 ease-in-out flex-1 text-center flex items-center justify-center">
            <x-heroicon-o-book-open class="h-5 w-5 mr-2" />
            My Articles
        </button>

        {{-- Role-specific tabs --}}
        @if ($userRole === 'freelancer')
            <button @click="currentTab = 'projects'"
                :class="{ 'border-indigo-500 text-indigo-600': currentTab === 'projects', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'projects' }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 ease-in-out flex-1 text-center flex items-center justify-center">
                <x-heroicon-o-folder class="h-5 w-5 mr-2" />
                My Projects
            </button>
        @elseif ($userRole === 'client')
            <button @click="currentTab = 'jobs'"
                :class="{ 'border-indigo-500 text-indigo-600': currentTab === 'jobs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'jobs' }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 ease-in-out flex-1 text-center flex items-center justify-center">
                <x-heroicon-o-briefcase class="h-5 w-5 mr-2" />
                My Jobs
            </button>
        @endif
    </div>
</nav>
