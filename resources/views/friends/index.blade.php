@extends('layouts.app')

@section('content')
<div class="friends-container">
    <div class="friends-section friends-left">
        <h2 class="friends-title">Your Friends</h2>
        @if ($friends->isEmpty())
            <p class="friends-message">You don't have any friends yet.</p>
        @else
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
        @endif
    </div>

    <div class="friends-section friends-center">
        <h2 class="friends-title">Find Friends</h2>
        <div class="friends-list">
            @foreach ($users as $user)
                <div class="friends-card">
                    <div class="friends-user">
                        <img src="{{ asset('storage/' . ($user->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="User Picture" class="friends-avatar">
                        <span class="friends-name">{{ $user->name }}</span>
                    </div>
                    <form action="{{ route('friend.send', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="friends-button">Send Request</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div class="friends-section friends-right">
        <h2 class="friends-title">Pending Requests</h2>
        @if ($pendingRequests->isEmpty())
            <p class="friends-message">No pending friend requests.</p>
        @else
            <div class="friends-list">
                @foreach ($pendingRequests as $request)
                    <div class="friends-card">
                        <div class="friends-user">
                            <img src="{{ asset('storage/' . ($request->sender->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="Sender Picture" class="friends-avatar">
                            <span class="friends-name">{{ $request->sender->name }}</span>
                        </div>
                        <div class="friends-request-buttons">
                            <form action="{{ route('friend.accept', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="friends-button">Accept</button>
                            </form>
                            <form action="{{ route('friend.decline', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="friends-button">Decline</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
