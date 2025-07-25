<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{protected $table = '_payment';
    protected $fillable = [
        'payment_date',
        'amount',
        'payment_method',
        'status',
        'commission',
        'booking_id',
    ];

}
