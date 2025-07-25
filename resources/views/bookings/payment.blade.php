<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Complete Payment</h3>
                    </div>
                    <div class="card-body text-center py-5">
                        <h4 class="mb-4">Booking #{{ $booking->id }}</h4>
                        <p class="lead">Total Amount: {{ number_format($booking->total_amount, 2) }} DZD</p>
                        
                        <div class="mt-5">
                            <a href="{{ $paymentUrl }}" class="btn btn-success btn-lg" target="_blank">
                                <i class="fas fa-credit-card"></i> Proceed to Payment
                            </a>
                            <a href="{{ route('bookings.customer-show', $booking->id) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Back to Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>