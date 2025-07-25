<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\AgencyNotification;
use App\Models\Rating;
use App\Models\Customer;

class CarController extends Controller
{
    /**
     * Display list of available cars.
     */
    public function index()
    {
        // Get the user's agency
        $agency = Auth::user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                   ->with('error', 'You do not have a registered agency');
        }
        $notifications = AgencyNotification::where('agency_id', $agency->id)
        ->latest()
        ->take(10)
        ->get();
    
    $unreadNotifications = AgencyNotification::where('agency_id', $agency->id)
        ->where('status', 'unread')
        ->count();
        // Get all agency cars regardless of booking status
        $allCars = $agency->cars()
                   ->with(['bookings' => function($query) {
                       $query->whereIn('status', ['Confirmed', 'Pending']);
                   }])
                   ->paginate(12);

                   return view('car.index', [
                    'allCars' => $allCars,
                    'unreadNotifications' => $unreadNotifications,
                    'notifications' => $notifications,
                ]);
            }                
   
   
    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        $agency = Agency::where('user_id', Auth::id())->first();

        // Check for active subscription
        if (!$agency || !$agency->subscription || $agency->subscription->end_date < now()) {
            return redirect()->route('subscription.expired')->with('error', 'You must subscribe to add cars.');
        }

        $agencies = Agency::all();
        return view('car.create', compact('agencies'));
    }

    /**
     * Store a newly created car in database.
     */
    public function store(Request $request)
    {
        $agency = Agency::where('user_id', Auth::id())->first();

        // Check for active subscription
        if (!$agency || !$agency->subscription || $agency->subscription->end_date < now()) {
            return redirect()->route('subscription.expired')->with('error', 'You must subscribe to add cars.');
        }

        $request->validate([
            'brand' => 'required|string',
    'model' => 'required|string',
    'picture' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
    'agency_id' => 'required|integer',
    'license_plate' => 'required|string',
    'status' => 'required|string|in:good,bad,perfect,Available,Rented',
    'eco_friendly' => 'required|boolean',
    'daily_rate' => 'required|numeric|min:0',
    'fuel_type' => 'required|string|in:petrol,diesel,electric,hybrid',
    'family_friendly' => 'boolean', 
    'seats' => 'required|integer|min:1|max:12', 
    'child_seat' => 'boolean', 
    'air_conditioning' => 'boolean', 
        ]);

        $input = $request->all();
        if ($image = $request->file('picture')) {
            $destinationPath = public_path('images/');
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['picture'] = $profileImage;
        }

        Car::create($input);
        return redirect()->route('car.index')->with('success', 'Car added successfully!');
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car)
    {
        return view('car.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit(Car $car)
    {
        $agencies = Agency::all();
        return view('car.edit', compact('car', 'agencies'));
    }

    /**
     * Update the specified car in database.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required|string',
    'model' => 'required|string',
    'picture' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
    'agency_id' => 'required|integer',
    'license_plate' => 'required|string',
    'status' => 'required|string|in:good,bad,perfect,Available,Rented',
    'eco_friendly' => 'required|boolean',
    'daily_rate' => 'required|numeric|min:0',
    'fuel_type' => 'required|string|in:petrol,diesel,electric,hybrid',
    'family_friendly' => 'boolean', 
    'seats' => 'required|integer|min:1|max:12', 
    'child_seat' => 'boolean', 
    'air_conditioning' => 'boolean', 
        ]);

        $input = $request->all();

        if ($image = $request->file('picture')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['picture'] = $profileImage;
        } else {
            unset($input['picture']);
        }

        $car->update($input);
        return redirect()->route('car.index')->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified car from database.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('car.index')->with('success', 'Car deleted successfully!');
    }

    /**
     * Display list of available cars for customers.
     */
   /**
 * Display list of available cars for customers.
 */
public function carList(Request $request)
{
    // نبدأ بالسيارات المتاحة أساساً (available = true)
    $query = Car::with(['agency', 'bookings' => function($q) {
            $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
              ->where('end_date', '>=', now());
        }])
        ->withCount('ratings')
        ->withAvg('ratings', 'rating');
    
    // فلتر حسب الوكالة
    if ($request->filled('agency')) {
        $query->where('agency_id', $request->agency);
    }
    
    // فلتر حسب المدينة
    if ($request->filled('city')) {
        $query->whereHas('agency', function($q) use ($request) {
            $q->where('city', $request->city);
        });
    }
    
    // فلتر حسب الموديل
    if ($request->filled('model')) {
        $query->where('model', 'like', '%'.$request->model.'%');
    }
    
    // فلتر حسب نوع الوقود
    if ($request->filled('fuel_type')) {
        $query->where('fuel_type', $request->fuel_type);
    }
    
    // فلتر حسب الحالة (متاح/غير متاح)
    if ($request->filled('status')) {
        if ($request->status == 'available') {
            $query->whereDoesntHave('bookings', function($q) {
                $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
                  ->where('end_date', '>=', now());
            });
        } elseif ($request->status == 'rented') {
            $query->whereHas('bookings', function($q) {
                $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
                  ->where('end_date', '>=', now());
            });
        }
    }
    
    // تحديث السيارات التي انتهى إيجارها (لكن يتم التعامل معها في المشغل اليومي)
    $cars = $query->paginate(12);
    $agencies = Agency::all();
    
    return view('customer.carlist', compact('cars', 'agencies'));
}
    /**
     * Show payment page.
     */
    public function payment(Request $request, Car $car)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $daysDiff = (new \DateTime($endDate))->diff(new \DateTime($startDate))->days;
        $totalAmount = $daysDiff * $car->daily_rate;

        return view('car.payment', compact('car', 'startDate', 'endDate', 'totalAmount'));
    }

    /**
     * Process payment.
     */
    public function processPayment(Request $request, Car $car)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $daysDiff = $startDate->diff($endDate)->days;
        $amount = $daysDiff * $car->daily_rate;

        // Create product
        $product = $this->createPaymentProduct('Car Rental - ' . $car->brand . ' ' . $car->model);

        if (!$product || !isset($product['id'])) {
            return redirect()->back()->with('error', 'Failed to create product.');
        }

        // Create price
        $price = $this->createPaymentPrice($product['id'], $amount);

        if (!$price || !isset($price['id'])) {
            return redirect()->back()->with('error', 'Failed to create price.');
        }

        // Create payment link
        $paymentLink = $this->createPaymentLink([
            [
                'price' => $price['id'],
                'quantity' => 1,
            ],
        ]);

        if (!$paymentLink || !isset($paymentLink['url'])) {
            return redirect()->back()->with('error', 'Failed to create payment link.');
        }

        // Redirect user to payment page
        return redirect()->away($paymentLink['url']);
    }

    /**
     * Create product in Chargily.
     */
    private function createPaymentProduct($name)
    {
        $data = [
            'name' => $name,
        ];

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
    private function createPaymentLink($items)
    {
        $data = [
            'name' => 'Car Rental Payment',
            'items' => $items,
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
     * Rate a car.
     */
    public function rate(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:car,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
    
        try {
            $car = Car::findOrFail($request->car_id);
            $user = Auth::user();
    
            // Get customer ID from `customer` table
            $customer = Customer::where('user_id', $user->id)->first();
    
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'No customer account found associated with this user.'
                ], 404);
            }
    
            // Save or update rating
            $rating = Rating::updateOrCreate(
                [
                    'car_id' => $car->id,
                    'customer_id' => $customer->id,
                ],
                [
                    'rating' => $request->rating,
                    'comment' => $request->comment
                ]
            );
    
            // Calculate average rating
            $car->average_rating = Rating::where('car_id', $car->id)->avg('rating');
            $car->save();
    
            // Send notification to agency
            $this->sendRatingNotification($car, $rating, $customer);
    
            return response()->json([
                'success' => true,
                'message' => 'Rating saved successfully',
                'average_rating' => $car->average_rating,
                'ratings_count' => Rating::where('car_id', $car->id)->count(),
                'html' => view('partials.rating_success', [
                    'average_rating' => $car->average_rating,  
                    'ratings_count' => Rating::where('car_id', $car->id)->count()
                ])->render()
            ]);
    
        } catch (\Exception $e) {
            Log::error('Failed to save rating: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the rating: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function sendRatingNotification($car, $rating, $customer)
    {
        $message = "New rating: {$rating->rating} stars for {$car->brand} {$car->model}";
        $message .= $rating->comment ? "\nComment: {$rating->comment}" : "";
    
        AgencyNotification::create([
            'agency_id' => $car->agency_id,
            'message' => $message,
            'type' => 'new_rating',
            'status' => 'unread',
            'related_id' => $rating->id,
            'related_type' => 'rating'
        ]);
    }
    
}