<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');

            $table->timestamps();

            $table->unique(['user_id', 'friend_id']);
            $table->unique(['friend_id', 'user_id']);
            $table->unique(['sender_id', 'receiver_id']);
            $table->unique(['receiver_id', 'sender_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
