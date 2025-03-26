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
    $table->unsignedBigInteger('application_id'); // Cambiar el nombre de la columna
    $table->unsignedBigInteger('camera_id');

    // Definir claves foráneas con nombres más cortos
    $table->foreign('application_id', 'app_adm_cam_fk')
          ->references('id')->on('application_for_admissions')
          ->onDelete('cascade');

    $table->foreign('camera_id', 'cam_app_fk')
          ->references('id')->on('cameras')
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
