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
        Schema::table('booking', function (Blueprint $table) {
            $table->string('delivery_state')->nullable();
            $table->string('delivery_postal_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['delivery_state', 'delivery_postal_code']);
        });
    }
};
