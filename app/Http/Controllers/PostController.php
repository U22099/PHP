<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user:id,username,role,image', 'tags']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('body', 'like', '%' . $search . '%');
            });
        }

        if ($userRole = $request->get('user_role')) {
            if (in_array($userRole, ['client', 'freelancer'])) {
                $query->whereHas('user', function ($q) use ($userRole) {
                    $q->where('role', $userRole);
                });
            }
        }

        if ($tagNames = $request->get('tags')) {
            if (!is_array($tagNames)) {
                $tagNames = [$tagNames];
            }
            $query->whereHas('tags', function ($q) use ($tagNames) {
                $q->whereIn('name', $tagNames);
            });
        }

        $posts = $query->latest()->paginate(10);

        $posts->through(function ($post) {
            $post->created_at_human = $post->created_at->diffForHumans();
            $post->user_data_for_display = $post->user ? $post->user->toArray() : null;
            $post->tag_names_for_display = $post->tags ? $post->tags->pluck('name')->toArray() : [];
            return $post;
        });

        $allTags = Tags::whereHas('posts')->orderBy('name')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'posts' => $posts,
                'allTags' => $allTags->pluck('name'),
            ]);
        }

        return view('posts.index', [
            'posts' => $posts,
            'allTags' => $allTags->pluck('name'),
        ]);
    }

    public function create()
    {
        $availableTags = Tags::whereHas('posts')
            ->pluck('name')
            ->toArray();
        return view('posts.create', ['availableTags' => $availableTags]);
    }

    public function store(Request $request)
    {
        $maxBodyLength = Auth::user()->is_premium
            ? env('POST_BODY_LIMIT_PER_USER_PREMIUM')
            : env('POST_BODY_LIMIT_PER_USER');

        request()->validate([
            'images' => ['sometimes', 'array'],
            'images.*' => ['string', 'url'],
            'publicIds' => ['sometimes', 'array', 'required_with:images'],
            'publicIds.*' => ['string'],
            'body' => ['string', 'required', 'max:' . $maxBodyLength],
        ]);

        $hashtags = [];
        if (preg_match_all('/(#)([^\s]+)/', $request->input('body'), $matches)) {
            $hashtags = $matches[1];
        }

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'body' => preg_replace('/#\S+/', '', $request->input('body')),
            'images' => $request->input('images') ?? [],
            'public_ids' => $request->input('publicIds') ?? [],
        ]);

        if (sizeof($hashtags) > 0) {
            $tagNames = $hashtags;
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }

            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->sync([]);
        }

        return redirect('/posts');
    }

    public function show(Post $post)
    {
        $post->load('comments.user');
        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        $availableTags = Tags::whereHas('posts')
            ->pluck('name')
            ->toArray();

        return view('posts.edit', ['post' => $post, 'availableTags' => $availableTags]);
    }

    public function update(Post $post)
    {
        $maxBodyLength = Auth::user()->is_premium
            ? env('POST_BODY_LIMIT_PER_USER_PREMIUM')
            : env('POST_BODY_LIMIT_PER_USER');

        request()->validate([
            'images' => ['sometimes', 'array'],
            'images.*' => ['string', 'url'],
            'publicIds' => ['sometimes', 'array', 'required_with:images'],
            'publicIds.*' => ['string'],
            'body' => ['string', 'required', 'max:' . $maxBodyLength],
        ]);

        $hashtags = [];
        if (preg_match_all('/(#)([^\s]+)/', request('body'), $matches)) {
            $hashtags = array_map(function ($tag) {
                return ltrim($tag, '#');
            }, $matches[0]);
        }

        $post->updateOrFail([
            'body' => preg_replace('/#\S+/', '', request('body')),
            'images' => $request->input('images') ?? [],
            'public_ids' => $request->input('publicIds') ?? [],
        ]);

        if (sizeof($hashtags) > 0) {
            $tagNames = $hashtags;
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->sync([]);
        }

        return redirect('/posts/' . $post->id);
    }

    public function destroy(Post $post)
    {
        if (!empty($post->images)) {
            foreach ($post->public_ids as $public_id) {
                $deleted = Storage::disk('cloudinary')->delete($public_id);
                if ($deleted) {
                    Auth::user()->image_uploads()->where('public_id', $publicId)->delete();
                }
            }
        }

        $post->delete();

        return redirect('/posts');
    }
}
