<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    /**
     * Show user's profile with posts and total likes.
     */
    public function myProfile(Request $request)
    {
        $user = auth()->user();
        
        // Fetch user's posts and include likes relationship
        $posts = Post::where('user_id', $user->id)->latest()->get();
        $userPosts = Post::where('user_id', Auth::id())->with('likes')->get();

        // Calculate total likes for all posts
        $totalLikes = $userPosts->sum(function ($post) {
            return $post->likes->count(); // Sum likes for each post
        });

        // Get list of friends (including search functionality)
        $friendIds = $user->friends()->pluck('friendships.sender_id')
            ->merge($user->friends()->pluck('friendships.receiver_id'))->toArray();

        $friendIds[] = $user->id;

        // Search functionality for friends
        $query = $request->input('q');
        $friends = $user->friends();

        if ($query) {
            $friends = $friends->where('name', 'like', '%' . $query . '%');
        }

        $friends = $friends->get();

        return view('myprofile', compact('user', 'posts', 'totalLikes', 'friends'));
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        if (!session('is_admin')) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted.');
    }
}
