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
            
            $table->foreignId('application_for_admission_id')
                  ->constrained(
                      'application_for_admissions', 
                      'id', 
                      'app_admission_cameras_fk1'  // Nombre corto para la constraint
                  )
                  ->onDelete('cascade');
            
            $table->foreignId('camera_id')
                  ->constrained(
                      'cameras', 
                      'id', 
                      'app_admission_cameras_fk2'  // Nombre corto para la constraint
                  )
                  ->onDelete('cascade');
            
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