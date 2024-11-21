@extends('layouts.app')

@section('content')
<div class="profile-container">
<!-- Profile Info Section -->
<div class="profile-info">
    <!-- Profile Avatar and Name -->
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="{{ $user->avatar ?? 'path/to/default-avatar.jpg' }}" alt="Profile Picture" class="avatar-img">
        </div>
        <div class="user-name">
            <h2>{{ $user->name }}</h2>
        </div>
    </div>

    <!-- Bio and Edit Profile Button -->
    <div class="bio-and-edit">
        <p class="user-bio">{{ $user->bio ?? 'This user has not set a bio yet.' }}</p>
        <div class="edit-profile-btn">
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
        </div>
    </div>
</div>



<!-- Profile Stats Section -->
<div class="profile-stats">
    <div class="stat-item">
        <p class="stat-number">{{ $posts->count() }}</p>
        <p class="stat-label">Posts</p>
    </div>
    <div class="stat-item">
        <p class="stat-number">{{ $totalLikes }}</p>
        <p class="stat-label">Likes</p>
    </div>
</div>

<!-- User Posts Section -->
<div class="user-posts">
    @foreach($posts as $post)
        <div class="post-card">
            <!-- Post Header -->
            <div class="post-header">
                <div class="user-avatar"></div>
                <div class="user-info">
                    <p class="user-name">{{ $user->name }}</p>
                    <p class="post-time">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Content -->
            <p class="post-content">{{ $post->content }}</p>

            <!-- Post Likes and Actions -->
            <div class="post-actions">
                <span class="like-count">{{ $post->likes->count() }}</span>
                <button class="like-button" data-post-id="{{ $post->id }}">
                    👍 Like
                </button>
            </div>
        </div>
    @endforeach
</div>


</div>
@endsection
