@props(['post'])

<div class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer"
    onclick="window.location.href = '/posts/{{ $post->id }}';">
    <div class="mb-4">
        <div class="text-gray-800 line-clamp-3">{{ $post->body }}</div>
    </div>

    @if (!empty($post->images))
        <div class="mt-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Attached Images:</h4>
            <x-image-gallery :images="$post->images" />
        </div>
    @endif

    <div class="mt-4 text-sm text-gray-500 border-t pt-3">
        Posted on {{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}
    </div>
</div>
