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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('summary');
            $table->text('content')->nullable();
            $table->text('video')->nullable();
            $table->foreignId('page_type_id');
            $table->string('image');
            $table->bigInteger('location_id');
            $table->enum('location_type',['province','city']);
            $table->bigInteger('reads');
            $table->bigInteger('likes');
            $table->bigInteger('created_by');
            $table->dateTime('publish_date');
            $table->enum('status',['publish','draft','archive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
