<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\AgencyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerNotification;
class BookingController extends Controller
{
  
public function index()
{
    $bookings = Booking::with('car')->latest()->paginate(10); // اجلب الحجوزات مع السيارات
    return view('bookings.customer-index', compact('bookings'));
}
    public function create(Car $car)
    {
        if (Auth::user()->account_type !== 'customer') {
            return redirect()->route('home')->with('error', 'Only customers can book cars.');
        }

        $existingBooking = Booking::where('car_id', $car->id)
            ->where('status', '!=', 'Cancelled')
            ->exists();

        if ($existingBooking) {
            return redirect()->route('customer.carlist')->with('error', 'This car is currently booked and unavailable.');
        }

        return view('bookings.create', compact('car'));
    }


   
    public function store(Request $request, Car $car)
    {
        if (Auth::user()->account_type !== 'customer') {
            return redirect()->route('home')->with('error', 'Only customers can book cars.');
        }
    
        // التحقق من صحة البيانات والمستندات المطلوبة
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'driving_license' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'id_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'residence_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'start_date.after_or_equal' => 'The start date must be today or later.',
            'end_date.after' => 'The end date must be after the start date.',
            'driving_license.required' => 'A copy of driving license is required.',
            'id_proof.required' => 'A copy of ID card or passport is required.',
            'residence_proof.required' => 'A proof of residence is required.',
            '*.mimes' => 'The file must be an image (JPEG, PNG, JPG) or PDF.',
            '*.max' => 'The file size must not exceed 2MB.',
        ]);
    
        // التحقق من توفر السيارة
        $existingBooking = Booking::where('car_id', $car->id)
            ->where('status', '!=', 'Cancelled')
            ->exists();
    
        if ($existingBooking) {
            return redirect()->back()->with('error', 'The car is not available for booking.');
        }
    
        // حساب المدة والمبلغ الإجمالي
        $days = (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24);
    
        if ($days <= 0) {
            return redirect()->back()->with('error', 'Invalid date range. Please check your selected dates.');
        }
    
        $totalAmount = $days * $car->daily_rate;
    
        // تخزين المستندات المرفوعة
        $drivingLicensePath = $request->file('driving_license')->store('documents/driving_licenses', 'public');
        $idProofPath = $request->file('id_proof')->store('documents/id_proofs', 'public');
        $residenceProofPath = $request->file('residence_proof')->store('documents/residence_proofs', 'public');
    
        // إنشاء الحجز
        $booking = Booking::create([
            'car_id' => $car->id,
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_amount' => $totalAmount,
            'booking_date' => now(),
            'status' => 'Pending Payment',
            'driving_license_path' => $drivingLicensePath,
            'id_proof_path' => $idProofPath,
            'residence_proof_path' => $residenceProofPath,
        ]);
    
        // إنشاء رابط الدفع
        $paymentLink = $this->createChargilyPaymentLink($booking, $totalAmount);
        
        if (!$paymentLink || !isset($paymentLink['url'])) {
            $booking->delete();
            return response()->json([
                'error' => 'Failed to create payment link. Please try again.'
            ], 500);
        }
    
        // إرسال إشعار إلى الوكالة
        AgencyNotification::create([
            'agency_id' => $car->agency_id,
            'message' => 'New booking request for car: ' . $car->brand . ' ' . $car->model . ' - Amount: ' . $totalAmount . ' DZD',
            'status' => 'unread',
            'type' => 'booking_request',
            'related_id' => $booking->id,
        ]);
    
        return response()->json([
            'success' => true,
            'payment_url' => $paymentLink['url'],
            'booking_id' => $booking->id,
            'message' => 'Booking request created successfully. You will be redirected to payment page.'
        ]);
    }
    private function createChargilyPaymentLink($booking, $amount)
    {
        // إنشاء منتج
        $product = $this->createPaymentProduct('Car Booking - ' . $booking->car->brand . ' ' . $booking->car->model);

        if (!$product || !isset($product['id'])) {
            Log::error('Failed to create Chargily product');
            return null;
        }

        // إنشاء سعر
        $price = $this->createPaymentPrice($product['id'], $amount);

        if (!$price || !isset($price['id'])) {
            Log::error('Failed to create Chargily price');
            return null;
        }

        // إنشاء رابط دفع
        $paymentLink = $this->createPaymentLink([
            [
                'price' => $price['id'],
                'quantity' => 1,
            ],
        ], $booking->id);

        return $paymentLink;
    }

    private function createPaymentProduct($name)
    {
        $data = [
            'name' => $name,
        ];

        return $this->chargilyRequest('products', $data);
    }

    private function createPaymentPrice($productId, $amount)
    {
        $data = [
            'amount' => $amount * 100, // تحويل إلى سنتيم (لأن Chargily يتعامل بالسنتيم)
            'currency' => 'dzd',
            'product_id' => $productId,
        ];

        return $this->chargilyRequest('prices', $data);
    }

    private function createPaymentLink($items, $bookingId)
    {
        $data = [
            'name' => 'Car Booking Payment',
            'items' => $items,
            'metadata' => [
                'booking_id' => $bookingId,
            ],
            'after_completion_message' => 'Thank you for your payment! The agency will review your booking.',
            'pass_fees_to_customer' => true,
        ];

        return $this->chargilyRequest('payment-links', $data);
    }

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
            Log::error('Chargily cURL Error:', ['error' => $err]);
            return null;
        } else {
            return json_decode($response, true);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return redirect()->route('customer.bookings')->with('error', 'Booking not found.');
        }

        $booking->update(['status' => 'Pending Approval']);

        AgencyNotification::create([
            'agency_id' => $booking->car->agency_id,
            'message' => 'Payment received for booking #' . $booking->id . '. Please approve the booking.',
            'status' => 'unread',
            'type' => 'payment_received',
            'related_id' => $booking->id,
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Payment successful! Your booking is pending agency approval.');
    }
    public function paymentFail(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);

        if ($booking) {
            $booking->update(['status' => 'Payment Failed']);
        }

        return redirect()->route('customer.bookings')->with('error', 'Payment failed. Please try again.');
    }

    public function handleWebhook(Request $request)
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
            $bookingId = $paymentData['metadata']['booking_id'];
            $booking = Booking::find($bookingId);

            if ($booking) {
                $booking->update([
                    'status' => 'Pending Approval',
                    'payment_id' => $paymentData['id'],
                    'payment_method' => $paymentData['payment_method'],
                ]);

                // إرسال إشعار إلى الوكالة
                AgencyNotification::create([
                    'agency_id' => $booking->car->agency_id,
                    'message' => 'Payment confirmed for booking #' . $booking->id,
                    'status' => 'unread',
                    'type' => 'payment_confirmed',
                    'related_id' => $booking->id,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    private function verifyChargilySignature($payload, $signature)
    {
        $secretKey = env('CHARGILY_SECRET_KEY');
        $computedSignature = hash_hmac('sha256', json_encode($payload), $secretKey);

        return hash_equals($signature, $computedSignature);
    }
    public function cancel(Booking $booking)
    {
        // التحقق من أن المستخدم هو صاحب الحجز
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'You are not authorized to cancel this booking.');
        }
    
        // يمكن الإلغاء فقط إذا كانت الحالة لم يتم تأكيدها بعد
        if (!in_array($booking->status, ['Pending Payment', 'Pending Approval', 'Confirmed'])) {
            return redirect()->back()->with('error', 'You can only cancel bookings that are not yet completed.');
        }
    
        DB::beginTransaction();
    
        try {
            $car = $booking->car;
            $agencyId = $car->agency_id;
            
            // حذف الحجز تماماً من قاعدة البيانات
            $booking->delete();
    
            // تحديث حالة السيارة إذا كانت محجوزة
            if ($car->status === 'Rented') {
                $car->update(['status' => 'Available']);
            }
    
            // إرسال إشعار إلى الوكالة
            AgencyNotification::create([
                'agency_id' => $agencyId,
                'message' => 'Booking #' . $booking->id . ' has been cancelled and deleted by the customer.',
                'status' => 'unread',
                'type' => 'booking_cancelled',
                'related_id' => null, // لأن الحجز تم حذفه
            ]);
    
            DB::commit();
    
            return redirect()->route('customer.bookings')->with('success', 'Booking has been cancelled and removed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking cancellation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }
    public function confirm(Booking $booking)
    {
        // التحقق من أن المستخدم هو صاحب الوكالة أو مسؤول
        $user = Auth::user();
        if ($user->account_type !== 'admin' && $user->id !== $booking->car->agency->user_id) {
            return redirect()->route('home')->with('error', 'You are not authorized to confirm bookings.');
        }

        $booking->update(['status' => 'Confirmed']);

        // إرسال إشعار إلى العميل
        // يمكنك إضافة نظام إشعارات للعملاء هنا إذا كان موجوداً

        return redirect()->route('agency.bookings')->with('success', 'Booking confirmed successfully!');
    }
    public function approve(Booking $booking)
    {
        $user = Auth::user();
        if ($user->account_type !== 'admin' && $user->id !== $booking->car->agency->user_id) {
            return redirect()->route('home')->with('error', 'You are not authorized to approve bookings.');
        }
    
        $booking->update(['status' => 'Confirmed']);
    
        // إرسال إشعار للزبون
        CustomerNotification::create([
            'user_id' => $booking->user_id,
            'message' => 'Your booking #' . $booking->id . ' has been approved by the agency.',
            'status' => 'unread',
            'type' => 'booking_approved',
            'related_id' => $booking->id,
        ]);
    
        return redirect()->route('agency.bookings')->with('success', 'Booking approved successfully!');
    }
    
    public function reject(Booking $booking)
    {
        $user = Auth::user();
        if ($user->account_type !== 'admin' && $user->id !== $booking->car->agency->user_id) {
            return redirect()->route('home')->with('error', 'You are not authorized to reject bookings.');
        }
    
        $booking->update(['status' => 'Rejected']);
    
        // إرسال إشعار للزبون
        CustomerNotification::create([
            'user_id' => $booking->user_id,
            'message' => 'Your booking #' . $booking->id . ' has been rejected by the agency.',
            'status' => 'unread',
            'type' => 'booking_rejected',
            'related_id' => $booking->id,
        ]);
        
        return redirect()->route('agency.bookings')->with('success', 'Booking rejected successfully!');
    }
    // عرض جميع حجوزات الزبون
public function customerBookings()
{
    if (Auth::user()->account_type !== 'customer') {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    $bookings = Booking::where('user_id', Auth::id())
        ->with(['car', 'car.agency'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('bookings.customer-index', compact('bookings'));
}

// عرض تفاصيل حجز معين للزبون
public function showCustomerBooking(Booking $booking)
{
    if (Auth::user()->account_type !== 'customer' || $booking->user_id !== Auth::id()) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    return view('bookings.customer-show', compact('booking'));
}
public function showPaymentPage(Booking $booking)
{
    // التحقق من أن المستخدم هو صاحب الحجز
    if (Auth::id() !== $booking->user_id) {
        return redirect()->route('bookings.customer-index')
               ->with('error', 'Unauthorized access.');
    }

    // التحقق من أن الحجز بحالة "Pending Payment"
    if ($booking->status !== 'Pending Payment') {
        return redirect()->route('bookings.customer-show', $booking->id)
               ->with('error', 'This booking does not require payment.');
    }

    // إنشاء رابط دفع جديد (إذا لزم الأمر)
    $paymentLink = $this->createChargilyPaymentLink($booking, $booking->total_amount);

    if (!$paymentLink || !isset($paymentLink['url'])) {
        return redirect()->route('bookings.customer-show', $booking->id)
               ->with('error', 'Failed to generate payment link. Please try again.');
    }

    return view('bookings.payment', [
        'booking' => $booking,
        'paymentUrl' => $paymentLink['url']
    ]);
}
public function showDeliveryOptions(Booking $booking)
{
    // التحقق من أن المستخدم هو صاحب الحجز
    if (Auth::id() !== $booking->user_id) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    // التحقق من أن الحجز مؤكد ولم يتم اختيار طريقة الاستلام بعد
    if ($booking->status !== 'Confirmed' || $booking->delivery_method) {
        return redirect()->route('bookings.customer-show', $booking->id)
               ->with('error', 'Delivery method already selected or booking not confirmed.');
    }

    return view('bookings.delivery-options', compact('booking'));
}

/**
 * معالجة اختيار طريقة الاستلام
 */
// في دالة selectDeliveryMethod
// في دالة selectDeliveryMethod
public function selectDeliveryMethod(Request $request, Booking $booking)
{
    if (Auth::id() !== $booking->user_id) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    $validated = $request->validate([
        'delivery_method' => 'required|in:pickup,delivery',
        'delivery_phone' => 'required|string|max:20',
        'address' => 'required_if:delivery_method,delivery',
        'state' => 'required_if:delivery_method,delivery',
        'postal_code' => 'required_if:delivery_method,delivery',
        'delivery_notes' => 'nullable|string',
    ]);

    $updateData = [
        'delivery_method' => $validated['delivery_method'],
        'delivery_phone' => $validated['delivery_phone'],
        'delivery_notes' => $validated['delivery_notes'] ?? null,
    ];

    if ($validated['delivery_method'] === 'delivery') {
        $updateData['delivery_address'] = $validated['address'];
        $updateData['delivery_state'] = $validated['state'];
        $updateData['delivery_postal_code'] = $validated['postal_code'];
    } else {
        // Clear delivery address fields if pickup is selected
        $updateData['delivery_address'] = null;
        $updateData['delivery_state'] = null;
        $updateData['delivery_postal_code'] = null;
    }

    $booking->update($updateData);

    return redirect()->route('bookings.customer-show', $booking->id)
           ->with('success', 'Delivery method selected successfully!');
}

// إضافة دالة updatePhone
public function updatePhone(Request $request, Booking $booking)
{
    if (Auth::id() !== $booking->user_id) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $request->validate([
        'delivery_phone' => 'required|string|max:20',
    ]);

    $booking->update([
        'delivery_phone' => $request->delivery_phone,
    ]);

    return redirect()->back()->with('success', 'Phone number updated successfully!');
}
public function updateDelivery(Request $request, Booking $booking)
{
    // التحقق من صلاحيات المستخدم
    if (Auth::id() !== $booking->user_id) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    $validated = $request->validate([
        'address' => 'required_if:delivery_method,delivery|nullable|string',
        'state' => 'required_if:delivery_method,delivery|nullable|string',
        'postal_code' => 'required_if:delivery_method,delivery|nullable|string|size:5',
        'delivery_phone' => 'required|string|max:20',
        'delivery_notes' => 'nullable|string',
    ]);

    $booking->update([
        'delivery_address' => $validated['address'] ?? $booking->delivery_address,
        'delivery_state' => $validated['state'] ?? $booking->delivery_state,
        'delivery_postal_code' => $validated['postal_code'] ?? $booking->delivery_postal_code,
        'delivery_phone' => $validated['delivery_phone'],
        'delivery_notes' => $validated['delivery_notes'] ?? $booking->delivery_notes,
    ]);

    return redirect()->back()->with('success', 'Delivery information updated successfully!');
}
}
