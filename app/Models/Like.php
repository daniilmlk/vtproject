<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Add 'user_id', 'post_id', and 'comment_id' to the fillable array
    protected $fillable = [
        'user_id',  // Allow mass assignment for the user_id
        'post_id',  // Allow mass assignment for the post_id
        'comment_id', // Allow mass assignment for the comment_id
    ];

    // Optional: define relationships (if necessary)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

