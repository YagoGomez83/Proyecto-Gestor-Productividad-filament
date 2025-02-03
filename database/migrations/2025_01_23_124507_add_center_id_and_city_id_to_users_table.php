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
        Schema::table('users', function (Blueprint $table) {
            // Agregar columnas sin utilizar "after", ya que "center_id" no existe
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();

            // Definir las claves foráneas
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar las claves foráneas
            $table->dropForeign(['city_id']);
            $table->dropForeign(['group_id']);

            // Eliminar las columnas
            $table->dropColumn(['city_id', 'group_id']);
        });
    }
};
