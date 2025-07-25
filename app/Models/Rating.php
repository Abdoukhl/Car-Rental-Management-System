<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'customer_id',
        'rating',
        'comment',
    ];
    protected static function booted()
    {
        static::saved(function ($rating) {
            $rating->car->updateAverageRating();
        });

        static::deleted(function ($rating) {
            $rating->car->updateAverageRating();
        });
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agency()
    {
        return $this->hasOneThrough(
            Agency::class,
            Car::class,
            'id', // Foreign key on cars table
            'id', // Foreign key on agencies table
            'car_id', // Local key on ratings table
            'agency_id' // Local key on cars table
        );
    }
}