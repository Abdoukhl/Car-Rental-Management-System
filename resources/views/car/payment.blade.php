@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Car: {{ $car->brand }} {{ $car->model }}</h5>
            <p class="card-text">
                <strong>Start Date:</strong> {{ $startDate }}<br>
                <strong>End Date:</strong> {{ $endDate }}<br>
                <strong>Total Amount:</strong> {{ $totalAmount }} DAZ
            </p>
            <form action="{{ route('cars.processPayment', $car->id) }}" method="POST">
                @csrf
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-credit-card"></i> Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection