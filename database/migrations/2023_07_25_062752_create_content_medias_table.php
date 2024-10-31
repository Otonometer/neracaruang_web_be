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
        Schema::create('content_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id');
            $table->enum('media_type',['image','video','infografis']);
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('summary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
