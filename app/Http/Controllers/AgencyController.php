<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Car;
use App\Models\Notification;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\ActivationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\SubscriptionRequest;
use App\Models\Document;
use App\Models\AgencyNotification;

class AgencyController extends Controller
{
    /**
     * Display list of agencies.
     */
    public function index()
    {
        $loggedInAgency = Agency::where('user_id', Auth::id())->first();
    
        if (!$loggedInAgency) {
            return redirect()->route('agency.dashboard')->with('error', 'Agency not found.');
        }
    
        $availableCars = Car::where('agency_id', $loggedInAgency->id)->paginate(10);
    
        return view('car.index', compact('availableCars'));
    }
    
    /**
     * Display details of a specific agency.
     */
    public function show(Agency $agency)
    {
        $loggedInAgency = Agency::where('user_id', Auth::id())->first();

        if (!$loggedInAgency) {
            return redirect()->route('agency.dashboard')->with('error', 'Agency not found.');
        }

        if ($agency->id !== $loggedInAgency->id) {
            return redirect()->route('agency.dashboard')->with('error', 'You are not authorized to access this page.');
        }

        $availableCars = Car::where('agency_id', $loggedInAgency->id)->paginate(10);
        $agency->load(['notification']);

        return view('agency.show', compact('agency', 'availableCars'));
    }

    /**
     * Store a new agency.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commercial_register_number' => 'required|string|unique:agencies',
            'name_agency' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_agency' => 'required|string|max:20',
            'registration_document' => 'required|mimes:pdf,png|max:2048',
        ]);

        if ($request->hasFile('registration_document')) {
            $file = $request->file('registration_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $fileName);
            
            Log::info('File uploaded:', [
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
            ]);
        } else {
            Log::error('File not uploaded.');
            return redirect()->back()->with('error', 'File was not uploaded.');
        }

        $agency = Agency::create([
            'commercial_register_number' => $request->commercial_register_number,
            'name_agency' => $request->name_agency,
            'city' => $request->city,
            'address' => $request->address,
            'phone_agency' => $request->phone_agency,
            'registration_document' => $fileName,
            'status' => 'pending',
        ]);

        return redirect()->route('agency.index')->with('success', 'Agency added successfully! Your account will be activated after review.');
    }

    /**
     * Show the form for editing an agency.
     */
    public function edit(Agency $agency)
    {
        return view('agency.edit', compact('agency'));
    }

    /**
     * Update agency details.
     */
    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'commercial_register_number' => 'required|string|unique:agencies,commercial_register_number,' . $agency->id,
            'name_agency' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_agency' => 'required|string|max:20',
        ]);

        $agency->update($request->all());

        return redirect()->route('agency.index')->with('success', 'Agency updated successfully!');
    }

    /**
     * Delete an agency and its associated user.
     */
    public function destroy(Agency $agency)
    {
        $user = User::find($agency->user_id);
        if ($user) {
            $user->delete();
        }

        $agency->delete();

        return redirect()->route('agency.index')->with('success', 'Agency and associated user deleted successfully!');
    }

    /**
     * Display agency dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $agency = Agency::where('user_id', $user->id)->first();
        
        if (!$agency) {
            return redirect()->route('subscription.expired')->with('error', 'Agency not found.');
        }
    
        // حساب معلومات الاشتراك
        $subscription = $agency->subscription;
        $daysRemaining = 0;
        $isSubscriptionActive = false;
    
        if ($subscription && $subscription->end_date > now()) {
            $daysRemaining = now()->diffInDays($subscription->end_date);
            
            $isSubscriptionActive = true;
        }
    
        // الإشعارات
        $notifications = AgencyNotification::where('agency_id', $agency->id)
            ->where('status', 'unread')
            ->latest()
            ->get();
    
        // الإحصائيات العامة
        $totalCars = Car::count();
        $totalAgencies = Agency::count();
        $totalBookings = Booking::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $unreadNotifications = $notifications->count();
    
        // بيانات الوكالة الخاصة
        $agencyCars = Car::where('agency_id', $agency->id)
            ->latest()
            ->paginate(12);
    
        $agencyBookings = Booking::whereHas('car', function($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            })
            ->latest()
            ->paginate(10);
    
        return view('agency.dashboard', [
            // الإحصائيات العامة
            'totalCars' => $totalCars,
            'totalAgencies' => $totalAgencies,
            'totalBookings' => $totalBookings,
            'pendingPayments' => $pendingPayments,
            'unreadNotifications' => $unreadNotifications,
            
            // بيانات الوكالة
            'cars' => $agencyCars,
            'car' => Car::latest()->get(), // جميع السيارات (كما في الكود الأصلي)
            'bookings' => $agencyBookings,
            'notifications' => $notifications,
            'agencyId' => $agency->id,
            
            // بيانات الاشتراك
            'subscription' => $subscription,
            'daysRemaining' => $daysRemaining,
            'isSubscriptionActive' => $isSubscriptionActive,
            'agency' => $agency,
            
            // متغيرات إضافية قد تكون مستخدمة في العرض
            'user' => $user
        ]);
    }
    public function subscriptionExpired()
{
    $agency = Agency::where('user_id', Auth::id())->first();
    
    if (!$agency) {
        return redirect()->route('agency.dashboard')->with('error', 'Agency not found.');
    }

    // Get notifications (collection of notification objects)
    $notifications = AgencyNotification::where('agency_id', $agency->id)
        ->where('status', 'unread')
        ->latest()
        ->take(10)
        ->get();

    // Get unread notifications count (integer)
    $unreadNotifications = AgencyNotification::where('agency_id', $agency->id)
        ->where('status', 'unread')
        ->count();

    $subscription = $agency->subscription;
    $remainingDays = 0;
    
    if ($subscription) {
        $remainingDays = now()->diffInDays($subscription->end_date);
    }

    return view('agency.subscription_expired', [
        'subscription' => $subscription,
        'remainingDays' => $remainingDays,
        'notifications' => $notifications,          // Pass the notifications collection
        'unreadNotifications' => $unreadNotifications // Pass the unread count
    ]);
}
    /**
     * Display subscription status.
     */
    public function subscriptionStatus()
    {
        $agency = Agency::where('user_id', Auth::id())->first();
    
        if (!$agency || !$agency->subscription) {
            return redirect()->route('subscription.expired')->with('error', 'No active subscription found.');
        }
    
        $remainingDays = now()->diffInDays($agency->subscription->end_date);
    
        $notifications = AgencyNotification::where('agency_id', $agency->id)
            ->latest()
            ->take(10)
            ->get();
    
        $unreadNotifications = AgencyNotification::where('agency_id', $agency->id)
            ->where('status', 'unread')
            ->count();
    
        return view('agency.subscription_status', [
            'subscription' => $agency->subscription,
            'remainingDays' => $remainingDays,
            'notifications' => $notifications,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
    
    /**
     * Show subscription renewal page.
     */
    public function showRenewSubscription()
    {
        $agency = Agency::where('user_id', Auth::id())->first();
        
        if (!$agency) {
            return redirect()->route('subscription.expired')->with('error', 'Agency not found.');
        }
    
        $notifications = AgencyNotification::where('agency_id', $agency->id)
            ->latest()
            ->take(10)
            ->get();
    
        $unreadNotifications = AgencyNotification::where('agency_id', $agency->id)
            ->where('status', 'unread')
            ->count();
    
        $subscription = $agency->subscription;
        $remainingDays = $subscription ? now()->diffInDays($subscription->end_date) : 0;
    
        return view('agency.renew_subscription', [
            'subscription' => $subscription,
            'remainingDays' => $remainingDays,
            'notifications' => $notifications,
            'unreadNotifications' => $unreadNotifications,
            'hasSubscription' => $subscription !== null
        ]);
    }
    /**
     * Renew agency subscription.
     */
    public function renewSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
        ]);
    
        $agency = Agency::where('user_id', Auth::id())->first();
    
        if (!$agency) {
            return response()->json(['error' => 'Agency not found.'], 404);
        }
    
        // Delete any existing pending subscription requests
        SubscriptionRequest::where('agency_id', $agency->id)
            ->where('status', 'pending')
            ->delete();
    
        // Create new subscription request
        $subscriptionRequest = SubscriptionRequest::create([
            'agency_id' => $agency->id,
            'plan' => $request->plan,
            'status' => 'pending',
        ]);
    
        Notification::create([
            'user_id' => 1, // Admin user
            'message' => 'New subscription request from agency: ' . $agency->name_agency . ' - Plan: ' . $request->plan,
            'status' => 'unread',
            'type' => 'subscription_request',
            'related_id' => $agency->id,
        ]);
    
        $amount = $request->plan === 'monthly' ? 3000 : 30000; // Adjusted amounts
        $currency = 'DZD';
    
        $product = $this->createPaymentProduct('Subscription Renewal');
    
        if (!$product || !isset($product['id'])) {
            return response()->json(['error' => 'Failed to create product.'], 500);
        }
    
        $price = $this->createPaymentPrice($product['id'], $amount);
    
        if (!$price || !isset($price['id'])) {
            return response()->json(['error' => 'Failed to create price.'], 500);
        }
    
        $paymentLink = $this->createPaymentLink([
            [
                'price' => $price['id'],
                'quantity' => 1,
            ],
        ], $agency->id, $request->plan);
    
        if (!$paymentLink || !isset($paymentLink['url'])) {
            return response()->json(['error' => 'Failed to create payment link.'], 500);
        }
    
        return response()->json([
            'payment_url' => $paymentLink['url'],
            'message' => 'Subscription request sent successfully.',
        ]);
    }
    
    /**
     * Handle successful payment.
     */
    public function subscriptionSuccess(Request $request)
    {
        $agency = Agency::where('user_id', Auth::id())->first();
    
        if (!$agency) {
            return redirect()->route('subscription.expired')->with('error', 'Agency not found.');
        }
    
        // Delete any existing subscription
        if ($agency->subscription) {
            $agency->subscription->delete();
        }
    
        // Create new subscription
        $newSubscription = Subscription::create([
            'agency_id' => $agency->id,
            'plan' => $request->plan,
            'start_date' => now(),
            'end_date' => $request->plan === 'monthly' ? now()->addMonth() : now()->addYear(),
            'status' => 'active',
        ]);
    
        // Update subscription request status
        SubscriptionRequest::where('agency_id', $agency->id)
            ->where('status', 'pending')
            ->update(['status' => 'completed']);
    
        return redirect()->route('subscription.status')->with('success', 'Payment confirmed successfully! Your subscription has been renewed.');
    }
    /**
     * Handle failed payment.
     */
    public function subscriptionFail(Request $request)
    {
        return redirect()->route('subscription.status')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Handle Chargily Webhook requests.
     */
   /**
 * Handle Chargily Webhook requests.
 */
public function handleChargilyWebhook(Request $request)
{
    $payload = $request->all();
    $signature = $request->header('Signature');

    if (!$this->verifyChargilySignature($payload, $signature)) {
        Log::error('Invalid Chargily Webhook Signature');
        return response()->json(['error' => 'Invalid signature'], 403);
    }

    $eventType = $payload['event'];
    $paymentData = $payload['data'];

    if ($eventType === 'payment_succeeded') {
        $agencyId = $paymentData['metadata']['agency_id'];
        $plan = $paymentData['metadata']['plan'];

        $agency = Agency::find($agencyId);

        if ($agency) {
            // Delete existing subscription if exists
            if ($agency->subscription) {
                $agency->subscription->delete();
            }

            // Create new subscription
            Subscription::create([
                'agency_id' => $agency->id,
                'plan' => $plan,
                'start_date' => now(),
                'end_date' => $plan === 'monthly' ? now()->addMonth() : now()->addYear(),
                'status' => 'active',
            ]);

            // Update subscription request status
            SubscriptionRequest::where('agency_id', $agency->id)
                ->where('status', 'pending')
                ->update(['status' => 'completed']);

            Log::info('Payment confirmed for agency: ' . $agencyId);
        }
    }

    return response()->json(['success' => true]);
}
    /**
     * Verify Chargily signature.
     */
    private function verifyChargilySignature($payload, $signature)
    {
        $secretKey = env('CHARGILY_SECRET_KEY');
        $computedSignature = hash_hmac('sha256', json_encode($payload), $secretKey);

        return hash_equals($signature, $computedSignature);
    }

    /**
     * Create product in Chargily.
     */
    private function createPaymentProduct($name)
    {
        $data = ['name' => $name];
        return $this->chargilyRequest('products', $data);
    }

    /**
     * Create price in Chargily.
     */
    private function createPaymentPrice($productId, $amount)
    {
        $data = [
            'amount' => $amount,
            'currency' => 'dzd',
            'product_id' => $productId,
        ];
        return $this->chargilyRequest('prices', $data);
    }

    /**
     * Create payment link in Chargily.
     */
    private function createPaymentLink($items, $agencyId, $plan)
    {
        $data = [
            'name' => 'Subscription Renewal',
            'items' => $items,
            'metadata' => [
                'agency_id' => $agencyId,
                'plan' => $plan,
            ],
        ];
        return $this->chargilyRequest('payment-links', $data);
    }

    /**
     * Send request to Chargily API.
     */
    private function chargilyRequest($endpoint, $postFields)
    {
        $bearer_token = env('CHARGILY_SECRET_KEY');
        $endpointUrl = [
            'products' => "https://pay.chargily.net/test/api/v2/products",
            'prices' => "https://pay.chargily.net/test/api/v2/prices",
            'payment-links' => "https://pay.chargily.net/test/api/v2/payment-links",
        ][$endpoint];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpointUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $bearer_token",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error('cURL Error:', ['error' => $err]);
            return null;
        } else {
            return json_decode($response, true);
        }
    }

    /**
     * Request account activation by agency.
     */
    public function requestActivation(Request $request)
    {
        $agency = Agency::where('user_id', Auth::id())->first();

        if (!$agency) {
            return redirect()->back()->with('error', 'Agency not found.');
        }

        ActivationRequest::create([
            'agency_id' => $agency->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Activation request sent successfully. Please wait for account activation.');
    }

    /**
     * Send notification from admin to agency.
     */
    public function sendAdminNotificationToAgency($agencyId, $message, $rejectionReason = null)
    {
        AgencyNotification::create([
            'agency_id' => $agencyId,
            'message' => $message,
            'type' => 'admin_to_agency',
            'rejection_reason' => $rejectionReason,
        ]);
    }

    /**
     * Send notification from customer to agency.
     */
    public function sendCustomerNotificationToAgency($agencyId, $message)
    {
        AgencyNotification::create([
            'agency_id' => $agencyId,
            'message' => $message,
            'type' => 'customer_to_agency',
        ]);
    }

    /**
     * Display agency notifications.
     */
    public function showAgencyNotifications($agencyId)
    {
        $notifications = AgencyNotification::where('agency_id', $agencyId)->latest()->get();
        return view('agency.notifications', compact('notifications'));
    }
    
    /**
     * Mark notification as read.
     */
    public function markNotificationAsRead($notificationId)
    {
        $notification = AgencyNotification::findOrFail($notificationId);
        $notification->update(['status' => 'read']);
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Reject document.
     */
    public function rejectDocument($id, Request $request)
    {
        $document = Document::findOrFail($id);
        $document->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        $agency = Agency::find($document->agency_id);
        if ($agency) {
            $agency->update(['status' => 'rejected']);
        }

        AgencyNotification::create([
            'agency_id' => $document->agency_id,
            'message' => '❌ Your document has been rejected. Reason: ' . $request->rejection_reason,
            'type' => 'admin_to_agency',
            'status' => 'unread',
        ]);

        return redirect()->back()->with('success', 'Document rejected successfully.');
    }

    /**
     * Reupload document.
     */
    public function reuploadDocument(Request $request)
    {
        $request->validate([
            'registration_document' => 'required|mimes:pdf,png,jpg,jpeg,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

        $agency = Agency::where('user_id', $user->id)->first();
        if (!$agency) {
            return redirect()->back()->with('error', 'Agency not found.');
        }

        $oldDocument = Document::where('agency_id', $agency->id)->first();
        if ($oldDocument) {
            $oldFilePath = public_path($oldDocument->document_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $oldDocument->delete();
        }

        if ($request->hasFile('registration_document')) {
            $file = $request->file('registration_document');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'documents/' . $fileName;
            $file->move(public_path('documents'), $fileName);

            Document::create([
                'agency_id' => $agency->id,
                'document_name' => $file->getClientOriginalName(),
                'document_path' => $filePath,
                'status' => 'pending',
            ]);

            $agency->update(['status' => 'pending']);

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

    /**
     * Reject agency.
     */
    public function rejectAgency(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason ?? 'No reason specified',
        ]);
        return redirect()->back()->with('error', 'Agency rejected with the specified reason.');
    }

    /**
     * Display agency bookings.
     */
  // app/Http/Controllers/AgencyController.php
public function bookings()
{
    $agency = Agency::where('user_id',  Auth::id())->first();

    if (!$agency) {
        return redirect()->route('agency.dashboard')->with('error', 'Agency not found.');
    }

    $pendingBookings = Booking::with(['car', 'user'])
        ->whereHas('car', function($query) use ($agency) {
            $query->where('agency_id', $agency->id);
        })
        ->whereIn('status', ['Pending', 'Pending Payment', 'Pending Approval'])
        ->orderBy('created_at', 'desc')
        ->get();

    $confirmedBookings = Booking::with(['car', 'user'])
        ->whereHas('car', function($query) use ($agency) {
            $query->where('agency_id', $agency->id);
        })
        ->where('status', 'Confirmed')
        ->orderBy('created_at', 'desc')
        ->get();

    // Get notifications correctly
    $user = Auth::user();
    $notifications = AgencyNotification::where('agency_id', $agency->id)
    ->latest()
    ->take(10)
    ->get();

$unreadNotifications = AgencyNotification::where('agency_id', $agency->id)
    ->where('status', 'unread')
    ->count();
    return view('agency.bookings', [
        'pendingBookings' => $pendingBookings,
        'confirmedBookings' => $confirmedBookings,
        'unreadNotifications' => $unreadNotifications ,
        'notifications' => $notifications,
    ]);
}
    /**
     * Approve booking.
     */
    public function approveBooking(Booking $booking)
    {
        $agency = Agency::where('user_id', Auth::id())->first();
        
        if (!$agency || $booking->car->agency_id !== $agency->id) {
            return redirect()->back()->with('error', 'This action is not allowed.');
        }

        $booking->update(['status' => 'Confirmed']);

        Notification::create([
            'user_id' => $booking->user_id,
            'message' => 'Your booking for car: ' . $booking->car->brand . ' ' . $booking->car->model . ' has been approved',
            'status' => 'unread',
            'type' => 'booking_approved',
            'related_id' => $booking->id,
        ]);

        return redirect()->route('agency.bookings')->with('success', 'Booking approved successfully.');
    }

    /**
     * Reject booking.
     */
    public function rejectBooking(Request $request, Booking $booking)
    {
        $agency = Agency::where('user_id', Auth::id())->first();
        
        if (!$agency || $booking->car->agency_id !== $agency->id) {
            return redirect()->back()->with('error', 'This action is not allowed.');
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $rejectionReason = $request->reason;
        $carInfo = $booking->car->brand . ' ' . $booking->car->model;
        $userId = $booking->user_id;

        Notification::create([
            'user_id' => $userId,
            'message' => 'Your booking for car: ' . $carInfo . ' has been rejected - Reason: ' . $rejectionReason,
            'status' => 'unread',
            'type' => 'booking_rejected',
            'related_id' => $booking->id,
        ]);

        $booking->delete();

        Log::info('Booking deleted after rejection', [
            'booking_id' => $booking->id,
            'agency_id' => $agency->id,
            'reason' => $rejectionReason
        ]);

        return redirect()->route('agency.bookings')->with('success', 'Booking rejected and deleted successfully.');
    }

    /**
     * Update delivery method.
     */
    public function updateDeliveryMethod(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'delivery_method' => 'required|in:agency,delivery',
            'delivery_address' => 'required_if:delivery_method,delivery|string|max:255',
            'delivery_phone' => 'required_if:delivery_method,delivery|string|max:20',
            'delivery_notes' => 'nullable|string|max:500',
        ]);
        
        $updateData = [
            'delivery_method' => $request->delivery_method,
        ];

        if ($request->delivery_method === 'delivery') {
            $updateData['delivery_address'] = $request->delivery_address;
            $updateData['delivery_phone'] = $request->delivery_phone;
            $updateData['delivery_notes'] = $request->delivery_notes;
        } else {
            $updateData['delivery_address'] = null;
            $updateData['delivery_phone'] = null;
            $updateData['delivery_notes'] = null;
        }

        $booking->update($updateData);

        $notificationMessage = $request->delivery_method === 'agency' 
            ? 'Car will be picked up from agency'
            : 'Customer requested car delivery to: ' . $request->delivery_address;

        Notification::create([
            'user_id' => $booking->car->agency->user_id,
            'message' => 'Delivery method updated for booking #' . $booking->id . ': ' . $notificationMessage,
            'status' => 'unread',
            'type' => 'delivery_updated',
            'related_id' => $booking->id,
        ]);

        return redirect()->route('bookings.show', $booking)
               ->with('success', 'Delivery method updated successfully');
    }
}