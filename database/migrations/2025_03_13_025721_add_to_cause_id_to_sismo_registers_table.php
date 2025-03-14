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
            $table->unsignedBigInteger('cause_id')->comment('causa del evento');
            $table->foreign('cause_id')->references('id')->on('causes');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sismo_registers', function (Blueprint $table) {
            $table->dropForeign(['cause_id']);
            $table->dropColumn('cause_id');
            //
        });
    }
};
