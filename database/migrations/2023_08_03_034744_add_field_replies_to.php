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
        Schema::table('content_comments', function (Blueprint $table) {
            $table->bigInteger('reply_to')->nullable()->after('parent_id');
        });
    }
};
