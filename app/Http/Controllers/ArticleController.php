<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tags;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::with('user', 'tags')->latest()->simplePaginate(10)
        ]);
    }

    public function create()
    {
        $availableTags = Tags::whereHas('articles')
            ->orWhereHas('jobs')
            ->pluck('name')
            ->toArray();
        return view('articles.create', [
            'availableTags' => $availableTags
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $article = Article::create([
            'user_id' => rand(1, 5),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        if (request()->has('tags')) {
            $tagNames = request()->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->sync([]);
        }

        return redirect('/articles');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article)
    {
        $availableTags = Tags::whereHas('articles')
            ->orWhereHas('jobs')
            ->pluck('name')
            ->toArray();
        return view('articles.edit', ['article' => $article, 'availableTags' => $availableTags]);
    }

    public function update(Article $article)
    {
        request()->validate([
            'title' => ['string', 'required', 'min:3'],
            'body' => ['string', 'required'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $article->updateOrFail([
            'title' => request('title'),
            'body' => request('body'),
        ]);

        if (request()->has('tags')) {
            $tagNames = request()->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->sync([]);
        }

        return redirect('/articles/' . $article->id);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect('/articles');
    }
}
