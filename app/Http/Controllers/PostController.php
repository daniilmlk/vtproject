<?php

namespace App\Http\Controllers;

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
}

