<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }
}

