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
        Schema::create('application_for_admissions_cameras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_for_admission_id')->constrained()->onDelete('cascade');
            $table->foreignId('camera_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_for_admissions_cameras');
    }
};
