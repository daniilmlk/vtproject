@extends('layouts.app')

@section('content')
<div class="admin-dashboard-container">
    <h1 class="admin-title">Admin Dashboard</h1>

    <div class="admin-stats">
        <div class="admin-stat-item">
            <div class="stat-number">{{ $stats['users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="admin-stat-item">
            <div class="stat-number">{{ $stats['posts'] }}</div>
            <div class="stat-label">Total Posts</div>
        </div>
    </div>

    <div class="admin-section">
        <h2 class="admin-section-title">User Management</h2>
        <div class="admin-list">
            @foreach($users as $user)
                <div class="admin-list-item">
                    <span>{{ $user->name }} – {{ $user->email }}</span>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="admin-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-section">
        <h2 class="admin-section-title">Post Management</h2>
        <div class="admin-list">
            @foreach($posts as $post)
                <div class="admin-list-item">
                    <div>
                        <p>{{ Str::limit($post->content, 150) }}</p> 
                        <em>by {{ $post->user->name }}</em><br>
                    </div>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="admin-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
