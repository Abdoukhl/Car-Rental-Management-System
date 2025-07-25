<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Message;
class DocumentController extends Controller
{
    // عرض جميع الوثائق
    public function index()
    {$unreadMessages = Message::where('status', 'unread')->count();
        
        $documents = Document::with('agency')->get();
        return view('admin.agencies.documents', compact('documents','unreadMessages'));
    }

    // قبول الوثيقة
    public function approve($id)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'تم قبول الوثيقة بنجاح.');
    }

    // رفض الوثيقة
    public function reject($id)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'تم رفض الوثيقة بنجاح.');
    }
}