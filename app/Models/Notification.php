<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notificationId',
        'message',
        'type',
        'date',
        'status',
    ];
    public function booking()
    {
        return $this->hasOne(booking::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
    public function agency()
{
    return $this->belongsTo(Agency::class);
}

}
