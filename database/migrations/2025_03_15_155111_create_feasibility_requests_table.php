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
        Schema::create('feasibility_requests', function (Blueprint $table) {
            $table->id();
            $table->boolean('Success')->default(false);
            $table->enum('Feasibility_request', ['not applicable', 'incomplete', 'feasible', 'not feasible'])->default('not feasible');
            $table->boolean('Requests_report')->default(false);
            $table->boolean('Device_assignment')->default(false);
            $table->boolean('Reports_end_of_monitoring')->default(false);
            $table->unsignedBigInteger('sismo_register_id');
            $table->foreign('sismo_register_id')->references('id')->on('sismo_registers')->onDelete('cascade');
            $table->text('Description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feasibility_requests');
    }
};
