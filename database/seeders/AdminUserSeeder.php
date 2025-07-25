<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'abderrahmankhial2004@gmail.com',
            'password' => Hash::make('36329720'), // استبدل 'password' بكلمة مرور قوية
            'account_type' => 'admin', // تعيين نوع الحساب كـ admin
        ]);
    }
}