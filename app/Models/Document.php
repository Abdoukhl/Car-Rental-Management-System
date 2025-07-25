<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'document_name',
        'document_path',
        'status',
    ];

    // علاقة مع الوكالة
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}