<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

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
            ->pluck('name')
            ->toArray();
        return view('articles.create', [
            'availableTags' => $availableTags
        ]);
    }

    public function store()
    {
        $maxBodyLength = Auth::user()->is_premium
            ? env('ARTICLE_BODY_LIMIT_PER_USER_PREMIUM')
            : env('ARTICLE_BODY_LIMIT_PER_USER');

        request()->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required', 'string', 'max:' . $maxBodyLength],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $article = Article::create([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'body' => str_replace('"', "'", Purifier::clean(request('body'))),
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
            ->pluck('name')
            ->toArray();
        return view('articles.edit', ['article' => $article, 'availableTags' => $availableTags]);
    }

    public function update(Article $article)
    {
        $maxBodyLength = Auth::user()->is_premium
            ? env('ARTICLE_BODY_LIMIT_PER_USER_PREMIUM')
            : env('ARTICLE_BODY_LIMIT_PER_USER');

        request()->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required', 'string', 'max:' . $maxBodyLength],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $article->updateOrFail([
            'title' => request('title'),
            'body' => str_replace('"', "'", Purifier::clean(request('body'))),
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
