@extends('layouts.app')

@section('content')
<div class="main-container">
    <h2 class="text-xl font-bold mb-4">Recent Posts</h2>

    @foreach($posts as $post)
    <div class="post-card">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-gray-300"></div> <!-- Placeholder for User Avatar -->
            <div>
                <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="post-content mt-4">
            <p>{{ $post->content }}</p>
        </div>

        <div class="post-actions mt-4">
            <button>Like</button>
            <button>Comment</button>
        </div>
    </div>
    @endforeach
</div>
@endsection
