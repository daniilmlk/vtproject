<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('q');
    $user = auth()->user();

    $friendIds = $user->friends()->pluck('friendships.sender_id')
        ->merge($user->friends()->pluck('friendships.receiver_id'))->toArray();

    $friendIds[] = $user->id;

    $friends = $user->friends();
    if ($query) {
        $friends = $friends->where('name', 'like', '%' . $query . '%');
    }
    $friends = $friends->get();

    $users = User::whereNotIn('id', $friendIds)->get();

    $pendingRequests = Friendship::where('receiver_id', $user->id)
        ->where('status', 'pending')
        ->with('sender') 
        ->get();

    if ($request->ajax()) {
        return response()->json([
            'friends' => view('friends._friends_list', compact('friends'))->render()
        ]);
    }

    return view('friends.index', compact('friends', 'users', 'pendingRequests'));
}



    public function search(Request $request)
    {
        $query = $request->input('q');
        $user = auth()->user();

        $friends = $user->friends()
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return view('friends.index', compact('friends'));
    }

    public function sendRequest($receiverId)
    {
        $senderId = Auth::id();

        $exists = Friendship::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->exists();

        if ($exists) {
            return back()->with('error', 'Friend request already sent or already friends.');
        }

        Friendship::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function acceptRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->receiver_id != Auth::id()) {
            abort(403);
        }

        $friendship->update(['status' => 'accepted']);

        Friendship::create([
            'sender_id' => $friendship->receiver_id,
            'receiver_id' => $friendship->sender_id,
            'status' => 'accepted',
        ]);

        return back()->with('success', 'Friend request accepted!');
    }

    public function declineRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        if ($friendship->receiver_id != Auth::id()) {
            abort(403);
        }

        $friendship->update(['status' => 'declined']);

        return back()->with('success', 'Friend request declined.');
    }

    public function removeFriend($friendId)
    {
        $userId = Auth::id();

        Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $friendId)
                  ->where('receiver_id', $userId);
        })->delete();

        return back()->with('success', 'Friend removed.');
    }
}
