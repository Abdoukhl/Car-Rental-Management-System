@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-info-circle"></i> Booking Status</h2>

    <div class="card">
        <div class="card-body text-center">
            <h4>Booking #{{ $booking->id }}</h4>
            <p><strong>Status:</strong> <span class="badge bg-{{ $booking->status === 'Confirmed' ? 'success' : ($booking->status === 'Rejected' ? 'danger' : 'warning') }}">{{ ucfirst($booking->status) }}</span></p>
            
            @if($booking->status === 'Rejected')
                <p class="text-danger"><strong>Rejection Reason:</strong> {{ $booking->rejection_reason }}</p>
            @elseif($booking->status === 'Confirmed')
                <h5>Choose Pickup Option</h5>
                <form action="{{ route('bookings.delivery', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" name="delivery_option" value="agency" class="btn btn-primary">Pickup from Agency</button>
                    <button type="submit" name="delivery_option" value="delivery" class="btn btn-secondary">Deliver to My Location</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
