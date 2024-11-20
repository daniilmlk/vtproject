<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->unsignedInteger('like_count')->default(0);
    });

    Schema::table('comments', function (Blueprint $table) {
        $table->unsignedInteger('like_count')->default(0);
    });
}

public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropColumn('like_count');
    });

    Schema::table('comments', function (Blueprint $table) {
        $table->dropColumn('like_count');
    });
}

};
