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
        Schema::table('car', function (Blueprint $table) {
            $table->boolean('family_friendly')->default(false)->after('fuel_type');
            $table->integer('seats')->default(4)->after('family_friendly');
            $table->boolean('child_seat')->default(false)->after('seats');
            $table->boolean('air_conditioning')->default(false)->after('child_seat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car', function (Blueprint $table) {
            $table->dropColumn([
                'family_friendly',
                'seats',
                'child_seat',
                'air_conditioning'
            ]);
        });
    }
};