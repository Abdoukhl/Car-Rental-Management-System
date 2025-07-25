<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date')->default(now()); // تاريخ اليوم كقيمة افتراضية
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Rejected'])->default('Pending'); // الحالة الافتراضية
            $table->double('total_amount');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('car_id');
            $table->timestamps();

            // إضافة فهارس
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->boolean('documents_verified')->default(false);
            // إضافة مفاتيح خارجية
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('car')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking');
    }
};