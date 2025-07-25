@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Payment Successful</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Your booking for {{ $booking->car->brand }} {{ $booking->car->model }} has been confirmed.
                    </div>
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary">
                        View Booking Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection