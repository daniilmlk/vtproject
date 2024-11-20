@extends('layouts.app')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')
<div class="main-container">
    <div class="posts-container">
        @foreach($posts as $post)
        <div class="post-card">
            <!-- Post Header -->
            <div class="post-header">
                <div class="user-avatar"></div>
                <div class="user-info">
                    <p class="user-name">{{ $post->user->name }}</p>
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
