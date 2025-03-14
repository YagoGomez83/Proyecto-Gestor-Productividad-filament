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
        Schema::create('camera_exports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_datetime')->comment('fecha y hora de inicio de la exportación');
            $table->timestamp('end_datetime')->comment('fecha y hora de fin de la exportación');
            $table->boolean('success')->default(false)->comment('indica si la exportación fue exitosa');
            $table->text('description')->nullable()->comment('descripción de la exportación');
            $table->unsignedBigInteger('sismo_register_id');
            $table->foreign('sismo_register_id')->references('id')->on('sismo_registers')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camera_exports');
    }
};
