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
        Schema::table('contents',function(Blueprint $table){
            $table->enum('location_type',['province','city','national'])->change();
            $table->bigInteger('location_id')->nullable()->change();
        });
    }
};
