<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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

    public function myProfile()
{
    $user = auth()->user();
    
    // Fetch user's posts and include likes relationship
    $posts = Post::where('user_id', $user->id)->latest()->get();
    $userPosts = Post::where('user_id', Auth::id())->with('likes')->get();

    // Calculate total likes for all posts
    $totalLikes = $userPosts->sum(function ($post) {
        return $post->likes->count(); // Sum likes for each post
    });

    return view('myprofile', compact('user', 'posts', 'totalLikes'));
}
public function destroy(User $user): RedirectResponse
    {
        if (!session('is_admin')) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted.');
    }

}
