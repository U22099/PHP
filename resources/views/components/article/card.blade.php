@props(['article'])

<div class="rounded-lg p-6 flex flex-col justify-start items-start border border-gray-200 hover:border-indigo-400 transition-colors duration-200 mt-2 cursor-pointer">
    <h3 class="text-xl font-bold text-gray-800 mb-2" onclick="window.location.href = '/articles/{{ $article->id }}';">{{ $article->title }}</h3>
    <div class="text-gray-600 line-clamp-3">{!! $article->body !!}</div>

    <div class="mt-4 text-sm text-gray-500 border-t pt-3">
        Published on {{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}
    </div>
</div>
