<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    // 1. أضف ثوابت للحالات الممكنة
    public const STATUS_PENDING = 'Pending';
    public const STATUS_PENDING_PAYMENT = 'Pending Payment';
    public const STATUS_CONFIRMED = 'Confirmed';
    public const STATUS_CANCELLED = 'Cancelled';
    public const STATUS_REJECTED = 'Rejected';
    public const STATUS_COMPLETED = 'Completed';

    // 2. قائمة بالحالات المسموحة
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_PENDING_PAYMENT,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELLED,
        self::STATUS_REJECTED,
        self::STATUS_COMPLETED
    ];

    protected $fillable = [
        'booking_date',
        'start_date',
        'end_date',
        'total_amount',
        'status',
        'user_id',
        'car_id',
        'delivery_method',
        'delivery_address',
        'delivery_phone',
        'delivery_notes',
        'delivery_state',       
        'delivery_postal_code' ,
        'driving_license_path',
        'id_proof_path',
        'residence_proof_path' 
    ];
    protected $casts = [
        'booking_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        // 3. لا نحتاج لـ cast لـ status لأنه enum
    ];

    // 4. التحقق من الحالة عند التعديل (سكوب)
    public function scopeValidStatus($query, $status)
    {
        if (!in_array($status, self::$statuses)) {
            throw new \InvalidArgumentException("Invalid booking status");
        }
        return $query->where('status', $status);
    }

    // 5. علاقات النموذج
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    

   

    // 6. دوال مساعدة للتحقق من الحالة
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

}