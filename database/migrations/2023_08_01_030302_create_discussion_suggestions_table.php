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
        Schema::create('discussion_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->string('abstract');
            $table->integer('user_id');
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
        Schema::dropIfExists('discussion_suggestions');
    }
};
