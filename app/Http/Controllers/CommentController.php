<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|max:500',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back();
    }
    public function toggleLike(Comment $comment)
{
    $user = auth()->user();

    if ($comment->likes()->where('user_id', $user->id)->exists()) {
        $comment->likes()->where('user_id', $user->id)->delete();
        $comment->decrement('like_count');
    } else {
        $comment->likes()->create(['user_id' => $user->id]);
        $comment->increment('like_count');
    }

    return response()->json(['like_count' => $comment->like_count]);
}

}


