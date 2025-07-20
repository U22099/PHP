@auth
    <div class="border rounded-lg p-4 mb-8 flex justify-between">
        <div class="flex items-center">
            <img class="h-12 w-12 rounded-full object-cover mr-4"
                src="https://i.pravatar.cc/150?img={{ Auth::user()->id ?? rand(1, 70) }}"
                alt="{{ Auth::user()->username ?? 'User' }}">
            <span class="font-semibold text-gray-900">{{ Auth::user()->username ?? 'Your Name' }}</span>
        </div>
        <x-button type="link" href="{{ route('posts.create') }}" class="px-2 py-1">
            Add Post
        </x-button>
    </div>
@else
    <div class="border rounded-lg p-6 mb-8 text-center text-gray-600">
        <p class="mb-4">Join the conversation! Share your thoughts with the community.</p>
        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Login</a> or
        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Register</a>
        to post.
    </div>
@endauth
