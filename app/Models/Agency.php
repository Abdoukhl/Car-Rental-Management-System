<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'city',
        'address',
        'registration_document',
        'phone',
        'rejection_reason',
        'status', // تمت إضافة العمود status
    ];

    // Relationships
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
   
    public function agencyNotifications()
{
    return $this->hasMany(AgencyNotification::class);
}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'user_id', 'user_id');
    }
      // إضافة علاقة مع الوثائق
      public function documents()
      {
          return $this->hasMany(Document::class);
      }
      // app/Models/Agency.php
public function bookings()
{
    return $this->hasManyThrough(
        Booking::class,
        Car::class,
        'agency_id', // Foreign key on cars table
        'car_id',    // Foreign key on bookings table
        'id',        // Local key on agencies table
        'id'         // Local key on cars table
    );
}
}