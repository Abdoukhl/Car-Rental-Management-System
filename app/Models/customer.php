<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Customer extends Model
{
    use HasFactory;
    
    protected $table = 'customer';
    
    protected $fillable = [
        'user_id',
        'driving_license_number',
        'driving_license_copy',
        'national_id_copy',
        'passport_copy',
        'residence_proof'
    ];

    public static function rules($id = null)
    {
        return [
            'driving_license_number' => 'required|string|max:50',
            'driving_license_copy' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'national_id_copy' => 'nullable|required_without:passport_copy|file|mimes:jpeg,png,pdf|max:2048',
            'passport_copy' => 'nullable|required_without:national_id_copy|file|mimes:jpeg,png,pdf|max:2048',
            'residence_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}