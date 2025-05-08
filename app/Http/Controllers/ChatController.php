<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function openChat(User $user)
    {
        $authId = Auth::id();

        if ($authId === $user->id) {
            return redirect()->back()->with('error', 'You cannot chat with yourself.');
        }

        $chat = Chat::where(function ($query) use ($authId, $user) {
            $query->where('user_one_id', $authId)
                  ->where('user_two_id', $user->id);
        })->orWhere(function ($query) use ($authId, $user) {
            $query->where('user_one_id', $user->id)
                  ->where('user_two_id', $authId);
        })->first();

        if (!$chat) {
            $chat = Chat::create([
                'user_one_id' => $authId,
                'user_two_id' => $user->id,
            ]);
        }

        $messages = $chat->messages()->with('sender')->orderBy('created_at')->get();

        return view('chat.window', [
            'chat' => $chat,
            'messages' => $messages,
            'friend' => $user,
        ]);
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $authId = Auth::id();

        $chat = Chat::firstOrCreate(
            [
                ['user_one_id', $authId],
                ['user_two_id', $user->id],
            ],
            [
                'user_one_id' => $authId,
                'user_two_id' => $user->id,
            ]
        );

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $authId,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }
}

