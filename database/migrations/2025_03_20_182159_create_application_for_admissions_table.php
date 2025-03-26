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
        Schema::create('application_for_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_solicitude');
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->string('police_hierarchy');
            $table->unsignedBigInteger('cause_id');
            $table->unsignedBigInteger('police_station_id');
            $table->unsignedBigInteger('center_id');
            $table->text('observations');
            $table->foreign('cause_id')->references('id')->on('causes');
            $table->foreign('police_station_id')->references('id')->on('police_stations');
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_for_admissions');
    }
};
