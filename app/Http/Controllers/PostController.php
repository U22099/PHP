<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::with('user', 'tags')->latest()->simplePaginate(10)
        ]);
    }

    public function create()
    {
        $availableTags = Tags::pluck('name')->toArray();
        return view('posts.create', ['availableTags' => $availableTags]);
    }

    public function store()
    {
        request()->validate([
            'body' => ['required'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $post = Post::create([
            'user_id' => rand(1, 5),
            'body' => request('body'),
        ]);

        if (request()->has('tags')) {
            $tagNames = request()->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
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
        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        $availableTags = Tags::pluck('name')->toArray();
        return view('posts.edit', ['post' => $post, 'availableTags' => $availableTags]);
    }

    public function update(Post $post)
    {
        request()->validate([
            'body' => ['string', 'required'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $post->updateOrFail([
            'body' => request('body'),
        ]);

        if (request()->has('tags')) {
            $tagNames = request()->input('tags');
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
