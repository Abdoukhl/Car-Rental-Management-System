<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        
        'password',
        'account_type', // أضف هذا الحقل
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function agency()
{
    return $this->hasOne(Agency::class, 'user_id');
}

public function customer()
{
    return $this->hasOne(Customer::class, 'user_id');
}
public function admin()
{
    return $this->hasOne(Admin::class);

}
public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}
public function getProfilePhotoUrlAttribute()
{
    return $this->profile_photo_path 
        ? asset('storage/'.$this->profile_photo_path)
        : asset('images/default-avatar.png');
}
}
