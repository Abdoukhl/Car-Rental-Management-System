<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048' // 2MB كحد أقصى
        ]);

        $user = Auth::user();
        
        // حذف الصورة القديمة إذا كانت موجودة
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // حفظ الصورة الجديدة
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
         /** @var \App\Models\User $user */
        $user->profile_photo_path = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'profile_photo_url' => $user->profile_photo_url
        ]);
    }
    
}