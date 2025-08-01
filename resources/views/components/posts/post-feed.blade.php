@props(['posts'])

<script>
    let initialPosts = @json($posts->items());
    let initialNextPageUrl = @json($posts->nextPageUrl());
</script>
<div x-data="{
    posts: initialPosts,
    nextPageUrl: initialNextPageUrl,
    loading: false,
    loadMorePosts() {
        if (!this.nextPageUrl || this.loading) return;

        this.loading = true;
        fetch(this.nextPageUrl + window.location.search, {
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                this.posts = [...this.posts, ...data.posts.data];
                this.nextPageUrl = data.posts.next_page_url;
            })
            .catch(error => console.error('Error loading more posts:', error))
            .finally(() => {
                this.loading = false;
            });
    },
    like(id) {
        const post = this.posts.find(post => post.id === id);
        post.liked_by_user = !post.liked_by_user;
        post.likes_count += post.liked_by_user ? 1 : -1;

        fetch(`/posts/${post.id}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json()).then(data => {
            post.liked_by_user = data.liked;
            post.likes_count = data.likes_count;
        }).catch(() => {
            post.liked_by_user = !post.liked_by_user;
            post.likes_count += post.liked_by_user ? 1 : -1;
        });
    }
}" class="space-y-6">
    <template x-if="posts.length === 0">
        <p class="text-center text-gray-600 text-lg">No posts found at the moment</p>
    </template>
    <template x-for="post in posts" :key="post.id">
        <x-posts.post-card />
    </template>

    <div x-show="posts.length > 0 && nextPageUrl" class="mt-8 text-center">
        <x-button @click="loadMorePosts()">
            <span x-show="!loading">Load More Posts</span>
            <span x-show="loading">Loading...</span>
        </x-button>
    </div>
</div>
