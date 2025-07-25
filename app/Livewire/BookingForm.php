<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingForm extends Component
{
    public $car_id, $start_date, $end_date, $total_amount;
    public $cars; // متغير لحفظ قائمة السيارات

    // تحميل البيانات عند تشغيل المكون
    public function mount()
    {
        $this->cars = Car::all(); // جلب السيارات من قاعدة البيانات
    }

    // تحديث القيم وحساب السعر عند تغيير المدخلات
    public function updated($property)
    {
        $this->validateOnly($property, [
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($this->car_id && $this->start_date && $this->end_date) {
            $this->calculateTotal();
        }
    }

    // حساب السعر الإجمالي للحجز
    public function calculateTotal()
    {
        $car = Car::find($this->car_id);
        if ($car) {
            $days = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date));
            $this->total_amount = $days * $car->daily_rate; // استخدام `daily_rate` بدلاً من `price_per_day`
        }
    }

    // تنفيذ عملية الحجز
    public function bookCar()
    {
        $this->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0'
        ]);

        // التحقق من توفر السيارة
        if (!$this->isCarAvailable($this->car_id, $this->start_date, $this->end_date)) {
            session()->flash('error', '🚗 هذه السيارة محجوزة بالفعل في هذه الفترة!');
            return;
        }

        Booking::create([
            'booking_date' => now(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => 'Pending',
            'total_amount' => $this->total_amount,
            'user_id' => Auth::id(),
            'car_id' => $this->car_id,
        ]);

        session()->flash('message', '✅ تم إرسال الحجز بنجاح!');
    }

    // التحقق من توفر السيارة
    public function isCarAvailable($car_id, $start_date, $end_date)
    {
        return !Booking::where('car_id', $car_id)
            ->where('status', '!=', 'Cancelled')
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                      ->orWhereBetween('end_date', [$start_date, $end_date])
                      ->orWhere(function ($q) use ($start_date, $end_date) {
                          $q->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                      });
            })
            ->exists();
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
