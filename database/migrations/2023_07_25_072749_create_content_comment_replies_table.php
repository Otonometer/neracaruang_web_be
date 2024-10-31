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
        Schema::create('content_comment_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foreign_comment_id');
            $table->integer('comment_id');
            $table->bigInteger('user_id');
            $table->text('comment');
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
        Schema::dropIfExists('content_comment_replies');
    }
};
