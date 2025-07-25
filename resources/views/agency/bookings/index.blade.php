@extends('layouts.agency')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar p-0 vh-100 sticky-top">
            <div class="p-4">
                <h4 class="text-center mb-4">
                    <i class="fas fa-car me-2"></i>Dashboard
                </h4>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-car me-2"></i> Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-calendar-alt me-2"></i> Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-line me-2"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="col-md-9 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Bookings Management
                </h2>
                
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>Agency Account
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Stats cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="booking-card h-100">
                        <div class="booking-body text-center">
                            <i class="fas fa-clock fa-3x mb-3" style="color: #f39c12;"></i>
                            <h3 class="mb-2">{{ $pendingBookings->count() }}</h3>
                            <p class="mb-0">Pending Bookings</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="booking-card h-100">
                        <div class="booking-body text-center">
                            <i class="fas fa-check-circle fa-3x mb-3" style="color: #2ecc71;"></i>
                            <h3 class="mb-2">{{ $confirmedBookings->count() }}</h3>
                            <p class="mb-0">Confirmed Bookings</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="booking-card h-100">
                        <div class="booking-body text-center">
                            <i class="fas fa-money-bill-wave fa-3x mb-3" style="color: #9b59b6;"></i>
                            <h3 class="mb-2">{{ number_format($confirmedBookings->sum('total_amount'), 2) }} DZD</h3>
                            <p class="mb-0">Total Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending bookings -->
            <div class="booking-card mb-4">
                <div class="booking-header">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Pending Bookings
                    </h4>
                </div>
                <div class="booking-body">
                    @if($pendingBookings->isEmpty())
                        <div class="alert alert-info text-center">No pending bookings</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                        <td>
                                            {{ $booking->start_date->format('Y-m-d') }}<br>
                                            to {{ $booking->end_date->format('Y-m-d') }}
                                        </td>
                                        <td>{{ number_format($booking->total_amount, 2) }} DZD</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('agency.bookings.show', $booking->id) }}" class="btn btn-view btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('agency.bookings.approve', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-accept btn-sm">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-reject btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $booking->id }}">
                                                    <i class="fas fa-times me-1"></i> Reject
                                                </button>
                                                
                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $booking->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Booking #{{ $booking->id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('agency.bookings.reject', $booking->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="reason" class="form-label">Rejection Reason</label>
                                                                        <textarea class="form-control" id="reason" name="rejection_reason" rows="3" required></textarea>
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
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Confirmed bookings -->
            <div class="booking-card">
                <div class="booking-header" style="background: linear-gradient(135deg, #2ecc71, #27ae60);">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>Confirmed Bookings
                    </h4>
                </div>
                <div class="booking-body">
                    @if($confirmedBookings->isEmpty())
                        <div class="alert alert-info text-center">No confirmed bookings</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Delivery Method</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($confirmedBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                        <td>
                                            {{ $booking->start_date->format('Y-m-d') }}<br>
                                            to {{ $booking->end_date->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            @if($booking->delivery_method)
                                                <span class="badge rounded-pill bg-{{ $booking->delivery_method === 'pickup' ? 'primary' : 'secondary' }}">
                                                    {{ $booking->delivery_method === 'pickup' ? 'Pickup' : 'Delivery' }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-warning">Not Specified</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($booking->total_amount, 2) }} DZD</td>
                                        <td>
                                            <a href="{{ route('agency.bookings.show', $booking->id) }}" class="btn btn-view btn-sm">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .booking-card {
        background: rgba(42, 42, 64, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        border: 1px solid rgba(110, 142, 251, 0.2);
        transition: all 0.3s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }
    
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        border-color: rgba(110, 142, 251, 0.4);
    }
    
    .booking-header {
        background: linear-gradient(135deg, #6e8efb, #4a6cf7);
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .table-custom {
        background: rgba(42, 42, 64, 0.7);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table-custom thead th {
        background: rgba(74, 108, 247, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 600;
    }
    
    .btn-view {
        background: rgba(110, 142, 251, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.5);
        color: white;
    }
    
    .btn-view:hover {
        background: rgba(110, 142, 251, 0.4);
    }
    
    .btn-accept {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border: none;
    }
    
    .btn-reject {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border: none;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection