<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Add 'user_id', 'post_id', and 'content' to the $fillable property
    protected $fillable = [
        'user_id',  // Allow mass assignment for user_id
        'post_id',  // Allow mass assignment for post_id
        'content',  // Allow mass assignment for content
    ];

    // Define relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
