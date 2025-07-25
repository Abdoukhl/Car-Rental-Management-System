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
    Schema::create('ratings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('car_id'); // تأكد من أن النوع هو unsignedBigInteger
        $table->unsignedBigInteger('customer_id'); // تأكد من أن النوع هو unsignedBigInteger
        $table->unsignedBigInteger('user_id')->nullable(); 
        $table->integer('rating'); // التقييم (من 1 إلى 5)
        $table->timestamps();

        // تعريف المفاتيح الخارجية
         // Foreign key constraint (if notifications are linked to users)
         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
        $table->foreign('car_id')->references('id')->on('car')->onDelete('cascade');
        $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
