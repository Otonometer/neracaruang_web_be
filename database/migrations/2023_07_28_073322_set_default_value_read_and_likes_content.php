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
        Schema::table('contents',function (Blueprint $table)
        {
            $table->integer('reads')->default(0)->change();
            $table->integer('likes')->default(0)->change();
        });
    }
};
