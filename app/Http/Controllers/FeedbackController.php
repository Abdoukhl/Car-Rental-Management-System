<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * عرض نموذج إضافة تقييم.
     */
    public function create($car_id)
    {
        $car = Car::findOrFail($car_id);
        return view('feedback.create', compact('car'));
    }

    /**
     * حفظ التقييم في قاعدة البيانات.
     */
    public function store(Request $request, $car_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Feedback::create([
            'customer_id' => Auth::id(),
            'car_id' => $car_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('cars.show', $car_id)->with('success', 'تم إضافة التقييم بنجاح!');
    }

    /**
     * عرض تقييمات سيارة معينة.
     */
    public function show($car_id)
    {
        $car = Car::findOrFail($car_id);
        $feedbacks = $car->feedbacks()->with('customer')->get();
        return view('feedback.show', compact('car', 'feedbacks'));
    }
}