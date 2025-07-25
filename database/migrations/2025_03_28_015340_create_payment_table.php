<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['credit_card', 'DZ_Golden_Card', 'bank_transfer', 'cash'])->default('cash');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->decimal('commission', 10, 2)->nullable();
            $table->timestamps();

            // مفتاح أجنبي
            $table->foreign('contract_id')->references('id')->on('_contract')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('_payment');
    }
};
