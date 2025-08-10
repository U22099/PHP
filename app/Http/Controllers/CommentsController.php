<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => ['required', 'max:500']
        ]);

        Comments::create([
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
            'body' => request('body'),
        ]);

        return redirect()->route('posts.show', $post);
    }
    public function update(Request $request, Comments $comments)
    {
        //
    }
    public function destroy(Comments $comments)
    {
        //
    }
}
