<x-layout>
    <x-slot:heading>
        Posts Feed
    </x-slot:heading>

    <div class="container mx-auto pt-2 not-even:py-8 px-2 sm:px-4 lg:px-8">
        <div class="flex flex-col-reverse gap-4 lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Main Content Area (Posts & Create Form) -->
            <div class="lg:col-span-8 lg:mt-0 mt-8">
                <x-posts.create-post-form />
                <x-posts.post-feed :posts="$posts" />
            </div>

            <div class="lg:col-span-4">
                <x-posts.post-filter-sidebar :all-tags="$allTags" />
            </div>
        </div>
    </div>
</x-layout>
