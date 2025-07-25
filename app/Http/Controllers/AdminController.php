<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Notification;
use App\Models\User;
use App\Models\ActivationRequest;
use Illuminate\Http\Request;
use App\Models\SubscriptionRequest; 
use App\Models\Subscription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Support\Facades\Log;
use App\Models\AgencyNotification;
use App\Models\Message;
use App\Models\Car;
class AdminController extends Controller
{
    
   
    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        // Get unread notifications
        $unreadNotifications = Notification::where('status', 'unread')->get();
        $activationRequests = ActivationRequest::where('status', 'pending')->with('agency')->get();
        $messages = Message::latest()->get(); 
        // Get pending subscription requests
        $subscriptionRequests = SubscriptionRequest::where('status', 'pending')->with('agency')->get();
        
        // Get unread messages count
        $unreadMessages = Message::where('status', 'unread')->count();
        
        // Pass data to the view
        return view('admin.dashboard', compact(
            'unreadNotifications', 
            'messages' ,
            'activationRequests',
            'subscriptionRequests',
            'unreadMessages'
        ));
    }
    
    public function reuploadDocument(Request $request)
    {
        $request->validate([
            'registration_document' => 'required|mimes:pdf,png,jpg,jpeg,doc,docx|max:2048',
        ]);
       

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User is not logged in.');
        }

        $agency = Agency::where('user_id', $user->id)->first();
        if (!$agency) {
            return redirect()->back()->with('error', 'Agency not found.');
        }

        // Get old document and delete it from storage if exists
        $oldDocument = Document::where('agency_id', $agency->id)->first();
        if ($oldDocument) {
            $oldFilePath = public_path($oldDocument->document_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete old file from storage
            }
            $oldDocument->delete(); // Delete document record from database
        }

        // Save new file with unique name
        if ($request->hasFile('registration_document')) {
            $file = $request->file('registration_document');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension(); // Unique name
            $filePath = 'documents/' . $fileName;
            $file->move(public_path('documents'), $fileName);

            // Insert new document and update status
            $document = Document::create([
                'agency_id' => $agency->id,
                'document_name' => $file->getClientOriginalName(),
                'document_path' => $filePath,
                'status' => 'pending', // Status "under review"
            ]);

            // Update agency status to "pending"
            $agency->update(['status' => 'pending']);

            // Notify admin about new document
            AgencyNotification::create([
                'agency_id' => $agency->id,
                'message' => '📄 New document uploaded for review.',
                'type' => 'admin_to_agency',
                'status' => 'unread',
            ]);

            return redirect()->route('agency.dashboard')->with('success', 'Document reuploaded successfully and is now under review.');
        }

        return redirect()->back()->with('error', 'Failed to upload file.');
    }

    
    // Notify agency when document is approved
    public function approveDocument($id)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => 'approved']);

        $agency = Agency::find($document->agency_id);
        if ($agency) {
            $agency->update(['status' => 'approved']);
            
            // Create approval notification
            $notification = new AgencyNotification();
            $notification->agency_id = $agency->id;
            $notification->message = '🎉 Your document has been approved! You can now proceed to use our services.';
            $notification->type = 'admin_to_agency';
            $notification->status = 'unread';
            $saved = $notification->save();

            if ($saved) {
                Log::info('✅ Approval notification sent to agency:', $notification->toArray());
            } else {
                Log::error('❌ Failed to save approval notification in database.');
            }
        }

        return redirect()->back()->with('success', 'Document approved and notification sent to agency.');
    }

    public function rejectDocument($id, Request $request)
    {
        Log::info('📢 rejectDocument() called', ['document_id' => $id]);

        $document = Document::findOrFail($id);
        $document->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        $agencyId = $document->agency_id;

        if (!$agencyId) {
            Log::error('❌ No agency ID associated with this document.');
            return redirect()->back()->with('error', 'Could not find agency associated with this document.');
        }

        // Update agency status to "rejected"
        $agency = Agency::find($agencyId);
        if ($agency) {
            $agency->update(['status' => 'rejected']);
            Log::info('🚀 Agency status updated to "rejected"', ['agency_id' => $agencyId]);
        } else {
            Log::error('❌ Agency not found.', ['agency_id' => $agencyId]);
        }

        $notification = AgencyNotification::create([
            'agency_id' => $agencyId,
            'message' => 'The submitted document has been rejected. Please review the reason and resubmit.',
            'type' => 'admin_to_agency',
            'rejection_reason' => $request->rejection_reason,
            'status' => 'unread',
        ]);

        if ($notification) {
            Log::info('✅ Notification sent to agency:', $notification->toArray());
        } else {
            Log::error('❌ Failed to save notification in database.');
        }

        return redirect()->back()->with('success', 'Document rejected and notification sent to agency.');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Activate agency subscription.
     */
    public function activateSubscription($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update(['status' => 'active']);

        // Send notification to admin
        Notification::create([
            'user_id' => Auth::id(), // Admin ID
            'message' => 'Subscription activated for agency: ' . $agency->name_agency,
            'status' => 'unread',
            'type' => 'subscription_activated',
            'related_id' => $agency->id,
        ]);

        return redirect()->back()->with('success', 'Agency subscription activated successfully.');
    }

    /**
     * Activate agency account.
     */
    public function activateAgency($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update(['status' => 'active']);

        // Update activation request status
        ActivationRequest::where('agency_id', $id)->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Account activated successfully.');
    }

    /**
     * Display list of agencies that have paid but are not activated.
     */
    public function pendingAgencies()
    {
        // Get agencies that have paid but are not activated
        $pendingAgencies = Agency::where('status', 'paid')->get();
       
        return view('admin.agencies.pending', compact('pendingAgencies'));
    }

    /**
     * Display list of agencies.
     */
    public function manageAgencies()
    {
        // الحصول على جميع الوكالات مع المستخدم المرتبط بها
        $agencies = Agency::with('user')->get();
        
        // الحصول على المستندات مع العلاقة الخاصة بالوكالة
        $documents = Document::with('agency')->get();
        
        // حساب عدد الرسائل الغير مقروءة
        $unreadMessages = Message::where('status', 'unread')->count();
    
        // حساب عدد السيارات لكل وكالة
        $agenciesWithCarCount = $agencies->map(function($agency) {
            $agency->car_count = $agency->cars()->count();  // إضافة العدد الكلي للسيارات للوكالة
            $agency->email = $agency->user->email;  // إضافة البريد الإلكتروني من علاقة المستخدم
            return $agency;
        });
    
        return view('admin.agencies.index', compact('agenciesWithCarCount', 'documents', 'unreadMessages'));
    }
    
    /**
     * Display details of a specific agency.
     */
    public function showAgency($id)
    {
        $agency = Agency::with('user', 'subscription', 'cars')->findOrFail($id); // Get agency with user, subscription, and cars
        
        // حساب عدد السيارات
        $agency->car_count = $agency->cars()->count();
        
        // حساب عدد الأيام المتبقية في الاشتراك
        $remainingDays = $agency->subscription 
            ? now()->diffInDays($agency->subscription->end_date, false) 
            : null;
        
        // إضافة البريد الإلكتروني
        $email = $agency->user->email;
        
        return view('admin.agencies.show', compact('agency', 'remainingDays', 'email'));
    }
    
    /**
     * Delete agency and associated user.
     */
    public function destroyAgency($id)
    {
        $agency = Agency::findOrFail($id);

        // Delete associated user
        $user = User::find($agency->user_id);
        if ($user) {
            $user->delete();
        }

        // Delete agency
        $agency->delete();

        return redirect()->route('admin.agencies.index')->with('success', 'Agency and associated user deleted successfully!');
    }

    /**
     * Display notifications list.
     */
    public function manageNotifications()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Display details of a specific notification.
     */
    public function showNotification($id)
    {
        $notification = Notification::findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Delete notification.
     */
    public function destroyNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully!');
    }

    public function approveSubscription($id)
    {
        $request = SubscriptionRequest::findOrFail($id);
    
        // Update request status to "approved"
        $request->update(['status' => 'approved']);
    
        // Activate agency subscription
        $agency = $request->agency;
        $endDate = $request->plan === 'monthly' ? now()->addMonth() : now()->addYear();
    
        if ($agency->subscription) {
            $agency->subscription->update([
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        } else {
            // Create new subscription with user_id
            Subscription::create([
                'user_id' => $agency->user_id, // Add user_id
                'agency_id' => $agency->id,
                'plan' => $request->plan,
                'start_date' => now(),
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        }
    
        return redirect()->back()->with('success', 'Subscription request approved successfully.');
    }

    public function rejectSubscription($id)
    {
        $request = SubscriptionRequest::findOrFail($id);

        // Update request status to "rejected"
        $request->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Subscription request rejected successfully.');
    }

    public function checkDocument()
    {
        $document = Document::latest()->first();

        if (!$document) {
            return response()->json(['message' => '⚠️ No document found in database']);
        }

        $correctedPath = str_replace('documents/', 'public/documents/', $document->document_path);

        if (Storage::exists($correctedPath)) {
            return response()->json(['message' => '✅ File exists']);
        } else {
            return response()->json(['message' => '❌ File not found']);
        }
    }
    /**
 * Display list of all users.
 */
public function manageUsers()
{
    $users = User::with(['agency', 'customer'])->latest()->paginate(10);
    $unreadMessages = Message::where('status', 'unread')->count();
    
    return view('admin.users.index', compact('users', 'unreadMessages'));
}

/**
 * Delete a user.
 */
public function destroyUser($id)
{
    $user = User::findOrFail($id);
    
    // حذف الوكالة المرتبطة أولاً إن وجدت
    if ($user->agency) {
        $user->agency->delete();
    }
    
    // حذف العميل المرتبط إن وجد
    if ($user->customer) {
        $user->customer->delete();
    }
    
    // حذف المستخدم
    $user->delete();
    
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
}
 // عرض صفحة البروفايل
public function showProfile()
{
    $admin = Auth::user(); // نحصل على بيانات المسؤول الحالي
    return view('admin.profile.show', compact('admin'));
}

// عرض صفحة التعديل
public function editProfile()
{
    $admin = Auth::user();
    return view('admin.profile.edit', compact('admin'));
}

// عملية التحديث
public function updateProfile(Request $request)
{
    $user = Auth::user();
    
    // التحقق من البيانات المدخلة
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'profile_photo' => 'nullable|image|max:2048',
    ]);
    
    // تحديث البيانات الأساسية
    $user->name = $request->name;
    $user->email = $request->email;
    
    // إذا تم رفع صورة جديدة
    if ($request->hasFile('profile_photo')) {
        // حذف الصورة القديمة إذا كانت موجودة
        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
        }
        
        // حفظ الصورة الجديدة
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
    }
    /** @var \App\Models\User $user */


    $user->save();
    
    return redirect()->route('admin.profile')->with('success', 'تم تحديث البروفايل بنجاح');
}   
public function updatePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|max:2048'
    ]);
    /** @var \App\Models\User $user */
     $user = Auth::user();
    $path = $request->file('profile_photo')->store('profile-photos', 'public');
    
    // الطريقة الأولى: استخدام save()
    $user->profile_photo_path = $path;
    $user->save();

    return response()->json([
        'success' => true,
        'profile_photo_url' => $user->profile_photo_url
    ]);
}
}