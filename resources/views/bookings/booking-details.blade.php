@extends('layouts.agency')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3><i class="fas fa-file-invoice me-2"></i> Booking Details #{{ $booking->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-car me-2"></i> Car Information</h4>
                    <p><strong>Brand:</strong> {{ $booking->car->brand }}</p>
                    <p><strong>Model:</strong> {{ $booking->car->model }}</p>
                    <p><strong>Daily Rate:</strong> {{ number_format($booking->car->daily_rate, 2) }} DZD</p>
                </div>
                <div class="col-md-6">
                    <h4><i class="fas fa-calendar-alt me-2"></i> Booking Dates</h4>
                    <p><strong>Start Date:</strong> {{ $booking->start_date->format('Y-m-d') }}</p>
                    <p><strong>End Date:</strong> {{ $booking->end_date->format('Y-m-d') }}</p>
                    <p><strong>Duration:</strong> {{ $booking->start_date->diffInDays($booking->end_date) }} days</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h4><i class="fas fa-truck me-2"></i> Delivery Method</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-{{ $booking->delivery_method === 'pickup' ? 'info' : 'success' }}">
                <h5 class="alert-heading">
                    @if($booking->delivery_method === 'pickup')
                        <i class="fas fa-store me-2"></i> Pickup from Agency
                    @else
                        <i class="fas fa-truck me-2"></i> Delivery to Address
                    @endif
                </h5>
            </div>

            @if($booking->delivery_method === 'delivery')
            <div class="delivery-details mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-map-marker-alt me-2"></i> Delivery Address</h5>
                        <p><strong>Address:</strong> {{ $booking->delivery_address }}</p>
                        <p><strong>State:</strong> {{ $booking->delivery_state }}</p>
                        <p><strong>Postal Code:</strong> {{ $booking->delivery_postal_code }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($booking->delivery_notes)
                        <div class="card">
                            <div class="card-header"><i class="fas fa-sticky-note me-2"></i> Additional Notes</div>
                            <div class="card-body">
                                {{ $booking->delivery_notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="https://www.google.com/maps?q={{ urlencode($booking->delivery_address) }}" 
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-map-marked-alt me-2"></i> View on Map
                    </a>
                </div>
            </div>
            @else
            <div class="pickup-details mt-4">
                <h5><i class="fas fa-store me-2"></i> Pickup Location</h5>
                <p>{{ $booking->car->agency->address }}</p>
                <div class="mt-3">
                    <a href="https://www.google.com/maps?q={{ urlencode($booking->car->agency->address) }}" 
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-map-marked-alt me-2"></i> View on Map
                    </a>
                </div>
            </div>
            @endif

            <!-- Contact Information Section -->
            <div class="contact-info mt-4 p-3 bg-light rounded">
                <h5><i class="fas fa-phone me-2"></i> Contact Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Customer Name:</strong> {{ $booking->user->name }}</p>
                        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($booking->delivery_phone)
                            <p><strong>Phone Number:</strong> {{ $booking->delivery_phone }}</p>
                            <div class="mt-2">
                                <a href="tel:{{ $booking->delivery_phone }}" class="btn btn-success me-2">
                                    <i class="fas fa-phone me-1"></i> Call
                                </a>
                                <a href="https://wa.me/213{{ substr($booking->delivery_phone, 1) }}" 
                                   target="_blank" class="btn btn-success">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        @else
                            <p class="text-muted">Customer hasn't provided a phone number yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h4><i class="fas fa-cog me-2"></i> Booking Management</h4>
        </div>
        <div class="card-body">
            @if($booking->status === 'Pending Approval')
                <form method="POST" action="{{ route('agency.bookings.approve', $booking->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-check-circle me-1"></i> Approve Booking
                    </button>
                </form>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times-circle me-1"></i> Reject Booking
                </button>
                
                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Booking #{{ $booking->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('agency.bookings.reject', $booking->id) }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($booking->status === 'Confirmed')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> This booking has been confirmed
                </div>
            @elseif($booking->status === 'Rejected')
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle me-2"></i> This booking has been rejected
                </div>
            @endif
            
            <div class="mt-3">
                <a href="{{ route('agency.bookings') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Bookings List
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-info {
        border-left: 4px solid #4a6cf7;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>

<script>
    // Activate reject modal
    document.addEventListener('DOMContentLoaded', function() {
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    });
</script>
@endsection