<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AgencyBookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || !$user->agency) {
            abort(403, 'You are not authorized to access this page.');
        }
    
        $pendingBookings = Booking::with(['car', 'user'])
            ->whereHas('car', function($query) use ($user) {
                $query->where('agency_id', $user->agency->id);
            })
            ->where('status', 'Pending Approval')
            ->get();
    
        $confirmedBookings = Booking::with(['car', 'user'])
            ->whereHas('car', function($query) use ($user) {
                $query->where('agency_id', $user->agency->id);
            })
            ->where('status', 'Confirmed')
            ->get();
    
        return view('agency.bookings.index', compact('pendingBookings', 'confirmedBookings'));
    }
    public function show(Booking $booking)
    {
        // Check if the booking belongs to the agency
        if ($booking->car->agency_id != Auth::user()->agency->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('agency.bookings.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        // Authorization check
        if ($booking->car->agency_id != Auth::user()->agency->id) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => 'Confirmed']);
        return redirect()->route('agency.bookings')->with('success', 'Booking approved successfully!');
    }

    public function reject(Request $request, Booking $booking)
    {
        // Authorization check
        if ($booking->car->agency_id != Auth::user()->agency->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $booking->update([
            'status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);

        return redirect()->route('agency.bookings')->with('success', 'Booking rejected successfully!');
    }
    
}