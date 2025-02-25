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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->date('report_date');
            $table->time('report_time');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('police_station_id');
            $table->unsignedBigInteger('cause_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('police_station_id')->references('id')->on('police_stations');
            $table->foreign('cause_id')->references('id')->on('causes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
