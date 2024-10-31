<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discussion_comment_replies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('comment_id');
            $table->bigInteger('reply_id');
            $table->text('comments');
            $table->bigInteger('user_id');
            $table->bigInteger('likes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_comment_replies');
    }
};
