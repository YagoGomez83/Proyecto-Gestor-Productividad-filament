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
        Schema::table('police_stations', function (Blueprint $table) {
            //
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('police_stations', function (Blueprint $table) {
            if (Schema::hasColumn('police_stations', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};
