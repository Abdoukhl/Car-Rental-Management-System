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
            $table->enum('status', [
                'Pending',         // في انتظار الموافقة
                'Pending Payment', // في انتظار الدفع
                'Confirmed',      // تم التأكيد
                'Cancelled',      // تم الإلغاء
                'Rejected',       // تم الرفض
                'Completed'       // تم الانتهاء
            ])->default('Pending')->change();
        });
    }
    
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('status', 20)->default('Pending')->change();
        });
    }
};
