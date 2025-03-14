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
        Schema::create('sismo_registers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_solicitude')->comment('fecha de solicitud');
            $table->string('solicitud_number')->comment('número de evento');
            $table->unsignedBigInteger('solicitude_type_id')->comment('tipo de solicitud');
            $table->foreign('solicitude_type_id')->references('id')->on('solicitude_types');
            $table->string('description')->comment('descripción del evento');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sismo_registers');
    }
};
