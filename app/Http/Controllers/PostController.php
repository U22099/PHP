<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::with('user', 'tags', 'comments')->latest()->simplePaginate(10)
        ]);
    }

    public function create()
    {
        $availableTags = Tags::whereHas('posts')
            ->pluck('name')
            ->toArray();
        return view('posts.create', ['availableTags' => $availableTags]);
    }

    public function store()
    {
        request()->validate([
            'body' => ['required'],
        ]);

        $hashtags = [];
        if (preg_match_all('/#[^\s]+/', request('body'), $matches)) {
            $hashtags = $matches[0];
        }

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'body' => preg_replace('/#\S+/', '', request('body')),
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
        request()->validate([
            'body' => ['string', 'required'],
        ]);

        $hashtags = [];
        if (preg_match_all('/#[^\s]+/', request('body'), $matches)) {
            $hashtags = $matches[0];
        }

        $post->updateOrFail([
            'body' => preg_replace('/#\S+/', '', request('body')),
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
        $post->delete();

        return redirect('/posts');
    }
}
