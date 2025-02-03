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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->date('service_date');
            $table->time('service_time');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('initial_police_movement_code_id');
            $table->foreign('initial_police_movement_code_id')->references('id')->on('police_movement_codes')->onDelete('cascade');
            $table->unsignedBigInteger('final_police_movement_code_id');
            $table->foreign('final_police_movement_code_id')->references('id')->on('police_movement_codes')->onDelete('cascade');
            $table->enum('status', ['preventive', 'reactive'])->default('preventive');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
