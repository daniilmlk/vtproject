<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('friendships', function (Blueprint $table) {
            $table->foreignId('sender_id')->after('id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->after('sender_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('friendships', function (Blueprint $table) {
            $table->dropColumn('sender_id');
            $table->dropColumn('receiver_id');
        });
    }
};
