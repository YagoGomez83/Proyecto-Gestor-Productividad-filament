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
        Schema::table('sismo_registers', function (Blueprint $table) {
            $table->string('solicitud_number_note')->nullable()->comment('número de evento');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sismo_registers', function (Blueprint $table) {
            //
            $table->dropColumn('solicitud_number_note');
            //
        });
    }
};
