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
        
        Schema::create('agency_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id');
            $table->string('message');
            $table->string('type')->nullable(); // يمكن أن يكون 'admin_to_agency' أو 'customer_to_agency'
            $table->string('status')->default('unread'); // unread, read
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('related_type')->nullable(); // مثل 'car_rating', 'booking', إلخ
          
            $table->text('rejection_reason')->nullable(); // سبب الرفض في حالة رفض الملفات
            $table->timestamps();
    
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_notifications');
    }
};
