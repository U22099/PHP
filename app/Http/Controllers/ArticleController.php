<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        return view('articles.create');
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required'],
        ]);

        Article::create([
            'user_id' => rand(1, 5),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        return redirect('/articles');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['post' => $post]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(Article $article)
    {
        request()->validate([
            'title' => ['string', 'required', 'min:3'],
            'body' => ['string', 'required'],
        ]);

        $article->updateOrFail([
            'title' => request('title'),
            'body' => request('title'),
        ]);

        return redirect('/articles/' . $article->id);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect('/articles');
    }
}
