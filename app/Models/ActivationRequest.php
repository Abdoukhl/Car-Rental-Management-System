<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'status',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}