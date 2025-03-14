<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('call_letter_exports', function (Blueprint $table) {
            $table->renameColumn('event number', 'event_number');
        });
    }

    public function down()
    {
        Schema::table('call_letter_exports', function (Blueprint $table) {
            $table->renameColumn('event_number', 'event number');
        });
    }
};
