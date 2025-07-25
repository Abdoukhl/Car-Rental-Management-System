<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'plan',
        'status',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}