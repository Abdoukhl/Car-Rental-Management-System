<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgencyNotification;
use Illuminate\Support\Facades\Auth;
class AgencyNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
   
    public function index()
{
    $user = Auth::user();

    
    if (!$user || !$user->agency) {
        return redirect()->route('dashboard')->with('error', 'لم يتم العثور على وكالة مرتبطة بحسابك.');
    }
   
$unreadNotifications = AgencyNotification::where('agency_id', $user->agency->id)
    ->where('status', 'unread')
    ->count();
    $notifications = AgencyNotification::where('agency_id', $user->agency->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('agency.notifications', compact(
            'unreadNotifications', 
            'notifications'
        ));
    }        
public function markAllAsRead()
    {
        $agency = Auth::user()->agency;
        
        if (!$agency) {
            return redirect()->back()->with('error', 'لم يتم العثور على الوكالة.');
        }
    
        AgencyNotification::where('agency_id', $agency->id)
            ->where('status', 'unread')
            ->update(['status' => 'read']);
    
        return redirect()->back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة.');
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function markAsRead($notificationId)
    {
        $notification = AgencyNotification::findOrFail($notificationId);
        $notification->update(['status' => 'read']);
        return redirect()->back()->with('success', 'تم تحديد الإشعار كمقروء.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function clearHistory(Request $request)
{
    $user = Auth::user();
    
    if (!$user || !$user->agency) {
        return redirect()->back()->with('error', 'لم يتم العثور على وكالة مرتبطة بحسابك.');
    }

    // حذف جميع إشعارات الوكالة
    AgencyNotification::where('agency_id', $user->agency->id)->delete();

    return redirect()->route('agency.notifications')
        ->with('success', 'تم حذف سجل الإشعارات بنجاح.');
}
}
