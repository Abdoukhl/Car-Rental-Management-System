<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';
    protected $fillable = [
        'brand', 'model', 'agency_id', 'license_plate', 'status',
        'eco_friendly', 'daily_rate', 'fuel_type', 'picture', 'average_rating',
        'family_friendly', 'seats', 'child_seat', 'air_conditioning' // حقول جديدة
    ];

    // العلاقة مع Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // التحقق مما إذا كانت السيارة مؤجرة حاليًا
    public function isRented()
    {
        return $this->bookings()
            ->where('status', 'Confirmed')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->exists();
    }

    // العلاقة مع Agency
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'car_id');
    }

    public function updateAverageRating()
    {
        $this->average_rating = $this->ratings()->avg('rating');
        $this->save();
    }

    // دالة جديدة للحصول على المزايا كسلسلة نصية
    public function getFeaturesAttribute()
    {
        $features = [];
        if ($this->child_seat) $features[] = 'Child Seat';
        if ($this->air_conditioning) $features[] = 'Air Conditioning';
        if ($this->family_friendly) $features[] = 'Family Friendly';
        if ($this->eco_friendly) $features[] = 'Eco Friendly';
        
        return implode(', ', $features);
    }
}