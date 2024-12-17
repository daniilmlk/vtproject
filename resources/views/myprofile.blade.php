@extends('layouts.app')

@section('content')
<div class="profile-container">
<!-- Profile Info Section -->
<div class="profile-info">
    <!-- Profile Avatar and Name -->
    <div class="profile-header">
        <div class="profile-avatar">
        <img src="{{ asset('storage/' . ($user->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="Profile Picture" class="avatar-img">
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
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="user-avatar">
                <div class="user-info">
                    <p class="user-name">{{ $user->name }}</p>
                    <p class="post-time">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Content -->
            <p class="post-content">{{ $post->content }}</p>

            <!-- Actions -->
            <div class="post-actions">
                <span class="like-count">{{ $post->like_count }}</span>
                <button class="like-button" data-post-id="{{ $post->id }}">👍 Like</button>
                <button class="comments-toggle-button" data-post-id="{{ $post->id }}">
                    Comments ({{ $post->comments->count() }})
                </button>
            </div>

            <!-- Comments Section -->
            <div id="comments-section-{{ $post->id }}" class="comments-section hidden">
                <!-- List Existing Comments -->
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

                <!-- Add a Comment -->
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
<script>


    document.addEventListener('DOMContentLoaded', () => {
        // Toggle comments section
        const commentToggleButtons = document.querySelectorAll('.comments-toggle-button');
        commentToggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.getAttribute('data-post-id');
                const section = document.getElementById(`comments-section-${postId}`);
                if (section) {
                    section.classList.toggle('hidden'); // Toggle visibility
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
