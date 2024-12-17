@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="post-creation-container">
        <h2 class="header-title">Create a Post</h2>
        
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <!-- User Info -->
            <div class="user-info">
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="user-avatar">
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>

            <!-- Content -->
            <div class="form-group">
                <textarea 
                    name="content" 
                    class="post-textarea" 
                    rows="5" 
                    placeholder="What's on your mind?" 
                    required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit" class="post-button">Post</button>
            </div>
        </form>
    </div>
</div>
@endsection
