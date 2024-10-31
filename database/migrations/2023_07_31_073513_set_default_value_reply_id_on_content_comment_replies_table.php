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
        Schema::table('content_comment_replies', function (Blueprint $table) {
            $table->bigInteger('comment_id')->nullable()->change();
            $table->bigInteger('reply_id')->nullable()->change();
            $table->bigInteger('likes')->default(0)->change();
        });
    }

   
};
