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
        Schema::create('sub_police_movement_codes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('police_movement_code_id');
            $table->timestamps();
            $table->foreign('police_movement_code_id')->references('id')->on('police_movement_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_police_movement_codes');
    }
};
