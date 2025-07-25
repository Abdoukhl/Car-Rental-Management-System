<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('_payment', function (Blueprint $table) {
            // إضافة أعمدة جديدة
            if (!Schema::hasColumn('_payment', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('commission');
            }
            
            if (!Schema::hasColumn('_payment', 'notes')) {
                $table->text('notes')->nullable()->after('transaction_id');
            }
            
            // تعديل أنواع البيانات في الحقول الموجودة
            $table->enum('payment_method', [
                'credit_card', 
                'DZ_Golden_Card', 
                'bank_transfer', 
                'cash',
                'chargily'
            ])->default('cash')->change();

            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded'
            ])->default('pending')->change();

            // إضافة فهارس لتحسين الأداء
            $table->index('contract_id');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('_payment', function (Blueprint $table) {
            // حذف الفهارس
            $table->dropIndex(['contract_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_method']);

            // لا نحذف الحقول للحفاظ على البيانات
        });
    }
};
