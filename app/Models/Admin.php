<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
   
    protected $table = 'admins';
    protected $fillable = ['role'];

    // العلاقة مع جدول المستخدمين
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    // وظائف إدارية (يجب عليك تحديد منطق العمل بداخلها)
    public function manageCars()
    {
        // منطق إدارة السيارات
    }

    public function manageUsers()
    {
        // منطق إدارة المستخدمين
    }

    public function manageOwners()
    {
        // منطق إدارة المالكين
    }
    
}
