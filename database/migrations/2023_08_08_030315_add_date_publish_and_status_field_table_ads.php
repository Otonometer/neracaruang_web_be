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
        //
        Schema::table('ads', function(Blueprint $table) {
            $table->dateTime('date_start')->nullable()->after('location_type');
            $table->dateTime('date_end')->nullable()->after('date_start');
            $table->enum('status', ['publish', 'draft'])->default('draft')->after('date_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
