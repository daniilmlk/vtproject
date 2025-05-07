<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Models\User;
use App\Models\Post;

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::resource('posts', PostController::class);
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])->name('comments.like');



Route::get('/', function () {
    return view('auth.login');
});
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// Route::redirect('/dashboard', '/profile')->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // New route for "My Profile"
    Route::get('/my-profile', [ProfileController::class, 'myProfile'])->name('profile.myprofile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});


Route::get('/admin/dashboard', function () {
    if (!session('is_admin')) {
        abort(403);
    }

    $users = User::all();
    $posts = Post::with('user')->get();
    $stats = [
        'users' => $users->count(),
        'posts' => $posts->count(),
    ];

    return view('admin.dashboard', compact('users', 'posts', 'stats'));
})->name('admin.dashboard');

Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
Route::delete('/admin/users/{user}', [ProfileController::class, 'destroy'])->name('admin.users.destroy');



require __DIR__.'/auth.php';
