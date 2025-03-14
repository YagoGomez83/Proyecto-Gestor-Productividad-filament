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
            $table->unsignedBigInteger('police_station_id')->comment('comisaría')->nullable();
            $table->foreign('police_station_id')->references('id')->on('police_stations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sismo_registers', function (Blueprint $table) {
            //
            $table->dropForeign(['police_station_id']);
            $table->dropColumn('police_station_id');
        });
    }
};
