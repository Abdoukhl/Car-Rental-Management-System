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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id('notificationId'); // Primary Key
        $table->string('message'); // Notification message
        $table->enum('type', ['info', 'warning', 'success', 'error']); // Type of notification
        $table->timestamp('date')->useCurrent(); // Timestamp of the notification
        $table->enum('status', ['unread', 'read']); // Status of the notification
        $table->unsignedBigInteger('user_id')->nullable(); // Optional: associate with a user
        $table->unsignedBigInteger('agency_id')->nullable();
        $table->timestamps();

        // Foreign key constraint (if notifications are linked to users)
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
       
        $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
