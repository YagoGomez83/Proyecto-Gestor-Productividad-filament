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
        Schema::table('feasibility_requests', function (Blueprint $table) {
            $table->text('Description')->nullable()->change(); // Permitir valores NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feasibility_requests', function (Blueprint $table) {
            $table->text('Description')->nullable(false)->change(); // Revertir si es necesario
        });
    }
};
