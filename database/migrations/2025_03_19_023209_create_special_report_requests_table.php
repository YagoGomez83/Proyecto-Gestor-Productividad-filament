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
        Schema::create('special_report_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('sismo_register_id');
            $table->foreign('sismo_register_id')->references('id')->on('sismo_registers');
            $table->foreign('report_id')->references('id')->on('reports');
            $table->boolean('success')->default(false)->comment('indica si la solicitud fue exitosa');
            $table->text('description')->nullable()->comment('descripción de la solicitud');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_report_requests');
    }
};
