<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::redirect('/dashboard', '/profile')->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // New route for "My Profile"
    Route::get('/my-profile', [ProfileController::class, 'myProfile'])->name('profile.myprofile');
});


require __DIR__.'/auth.php';
