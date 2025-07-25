<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $unreadMessages = Message::where('status', 'unread')->count();
        
        // البحث
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // الفلترة حسب نوع الحساب
        if ($request->has('account_type') && $request->input('account_type') != '') {
            $query->where('account_type', $request->input('account_type'));
        }
        
        $users = $query->paginate(10);
        
        return view('admin.users.index', compact('users','unreadMessages'));
    }

    public function destroy(User $user)
    {
        // منع حذف حسابات الأدمن
        if ($user->account_type === 'admin') {
            return back()->with('error', 'Cannot delete admin accounts.');
        }
        
        $user->delete();
        
        return back()->with('success', 'User deleted successfully.');
    }
}