<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyNotification extends Model
{
    use HasFactory;

    protected $fillable = ['agency_id', 'message', 'type', 'status', 'rejection_reason'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
