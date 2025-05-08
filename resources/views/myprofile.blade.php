@extends('layouts.app')

@section('content')
<div class="profile-container">
 <div class="profile-content">
    <!-- Profile Info Section -->
    <div class="profile-info">
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="{{ asset('storage/' . ($user->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="Profile Picture" class="avatar-img">
            </div>
            <div class="user-name">
                <h2>{{ $user->name }}</h2>
            </div>
        </div>

        <div class="bio-and-edit">
            <p class="user-bio">{{ $user->bio ?? 'This user has not written a bio yet.' }}</p>
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
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="user-avatar">
                    <div class="user-info">
                        <p class="user-name">{{ $user->name }}</p>
                        <p class="post-time">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Post Content -->
                <p class="post-content">{{ $post->content }}</p>

                <!-- Post Actions -->
                <div class="post-actions">
                    <span class="like-count">{{ $post->like_count }}</span>
                    <button class="like-button" data-post-id="{{ $post->id }}">👍 Like</button>
                    <button class="comments-toggle-button" data-post-id="{{ $post->id }}">
                        Comments ({{ $post->comments->count() }})
                    </button>
                </div>

                <!-- Comments Section -->
                <div id="comments-section-{{ $post->id }}" class="comments-section hidden">
                    <!-- Existing Comments -->
                    <div class="comments-list">
                        @foreach($post->comments as $comment)
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="comment-user-avatar"></div>
                                    <p class="comment-user-name"><strong>{{ $comment->user->name }}</strong></p>
                                </div>
                                <p class="comment-content">{{ $comment->content }}</p>
                                <div class="comment-actions">
                                    <span class="like-count">{{ $comment->like_count }}</span>
                                    <button class="like-comment-button" data-comment-id="{{ $comment->id }}">👍 Like</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Comment -->
                    <form method="POST" action="{{ route('comments.store') }}" class="add-comment-form">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="content" placeholder="Write a comment..." required></textarea>
                        <button type="submit">Comment</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
 </div>
 <div class="profile-sidebar">
    <a href="{{ route('friends.index') }}" class="sidebar-link">👥 Friends</a> 

    <div class="friend-search">
        <input type="text" name="q" placeholder="Search by Name" class="search-input" value="{{ request('q') }}" id="search-input">
    </div>

    <div class="friends-list">
                @foreach ($friends as $friend)
                    <div class="friends-card">
                        <div class="friends-user">
                            <img src="{{ asset('storage/' . ($friend->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="Profile Picture" class="friends-avatar">
                            <span class="friends-name">{{ $friend->name }}</span>
                        </div>
                        <form action="{{ route('friend.remove', $friend->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="friends-button">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
</div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle comments section visibility
        document.querySelectorAll('.comments-toggle-button').forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.getAttribute('data-post-id');
                const section = document.getElementById(`comments-section-${postId}`);
                if (section) {
                    section.classList.toggle('hidden');
                }
            });
        });

        // Like post
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', async () => {
                const postId = button.getAttribute('data-post-id');
                await togglePostLike(postId);
            });
        });

        // Like comment
        document.querySelectorAll('.like-comment-button').forEach(button => {
            button.addEventListener('click', async () => {
                const commentId = button.getAttribute('data-comment-id');
                await toggleCommentLike(commentId);
            });
        });
    });

    // AJAX для поиска
    document.getElementById('search-input').addEventListener('input', function () {
        const query = this.value;
        fetch("{{ route('friends.index') }}?q=" + query)
            .then(response => response.json())
            .then(data => {
                document.getElementById('friend-list').innerHTML = data.friends;
            });
    });

    async function togglePostLike(postId) {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        });

        if (response.ok) {
            const data = await response.json();
            const likeCountElement = document.querySelector(`.like-button[data-post-id="${postId}"]`).previousElementSibling;
            likeCountElement.textContent = data.like_count;
        }
    }

    async function toggleCommentLike(commentId) {
        const response = await fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        });

        if (response.ok) {
            const data = await response.json();
            const likeCountElement = document.querySelector(`.like-comment-button[data-comment-id="${commentId}"]`).previousElementSibling;
            likeCountElement.textContent = data.like_count;
        }
    }
</script>
@endsection
