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
        Schema::create('_insurance', function (Blueprint $table) {
            $table->id();
        
            $table->string('policyNumber')->unique();
            $table->enum('coverageDetails', ['basic', 'premium', 'comprehensive'])->default('basic');
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_insurance');
    }
};
