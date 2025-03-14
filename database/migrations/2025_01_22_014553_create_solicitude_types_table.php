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
        Schema::create('solicitude_types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('nombre del tipo de solicitud');
            $table->string('description')->comment('descripción del tipo de solicitud');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitude_types');
    }
};
