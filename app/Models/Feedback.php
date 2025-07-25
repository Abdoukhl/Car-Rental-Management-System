<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'customer_id',
        'rating',
        'comment', // إذا كنت تستخدم التعليقات
    ];

    // العلاقة مع السيارة
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // العلاقة مع الزبون
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}