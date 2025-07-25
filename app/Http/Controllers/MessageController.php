<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'تم إرسال الرسالة بنجاح!');
    }

    public function index()
    {
        $unreadMessages = Message::where('status', 'unread')->count();
        $messages = Message::with('user')->latest()->get();
        return view('admin.messages.index', compact('messages', 'unreadMessages'));
    }

    public function update(Message $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'تم تحديث حالة الرسالة');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function destroyAll()
    {
        
        
        Message::truncate();
        return back()->with('success', 'تم حذف جميع الرسائل بنجاح');
    }
}