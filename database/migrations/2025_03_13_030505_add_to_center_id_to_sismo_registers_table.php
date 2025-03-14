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
            //
            $table->unsignedBigInteger('center_id')->comment('centro de operaciones');
            $table->foreign('center_id')->references('id')->on('centers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sismo_registers', function (Blueprint $table) {
            //
            $table->dropForeign(['center_id']);
            $table->dropColumn('center_id');
        });
    }
};
