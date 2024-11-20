<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Post::create([
            'user_id' => auth()->id(),  // Logged-in user
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }
    public function toggleLike(Request $request, Post $post)
{
    $userId = auth()->id();

    try {
        // Check if the user already liked the post
        $existingLike = $post->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            // Unlike the post
            $existingLike->delete();
            $post->decrement('like_count');
        } else {
            // Like the post
            $post->likes()->create(['user_id' => $userId]);
            $post->increment('like_count');
        }

        return response()->json(['like_count' => $post->like_count]);
    } catch (\Exception $e) {
        Log::error('Error toggling post like', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Unable to process request'], 500);
    }
}


}

