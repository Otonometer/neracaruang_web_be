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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('summary');
            $table->text('content')->nullable();
            $table->string('image');
            $table->bigInteger('reads');
            $table->bigInteger('likes');
            $table->bigInteger('moderator');
            $table->bigInteger('co_moderator');
            $table->dateTime('publish_date_start');
            $table->dateTime('publish_date_end');
            $table->enum('status',['not_processed','processing','accepted','cancel']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
