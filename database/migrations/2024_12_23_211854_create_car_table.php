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
        Schema::create('car', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('brand');
            $table->string('license_plate');
           $table->enum('status',['good','bad','perfect']);
           $table->double('daily_rate');
      
           $table->unsignedBigInteger('agency_id');
           $table->string('picture');
           $table->boolean('eco_friendly')->default(false); 
           $table->string('fuel_type')->nullable();
           
            $table->timestamps();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');

            
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car');

    }
    
};
