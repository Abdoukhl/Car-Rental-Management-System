@extends('layouts.agency')

@section('title', 'Bookings Management')
@section('icon', 'fa-calendar-alt')
@section('page-title', 'Bookings Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Bookings Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #6e8efb;
            --secondary-color: #4a6cf7;
            --accent-color: #ff6b6b;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(15, 12, 41, 0);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(110, 142, 251, 0.3);
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover::after {
            transform: scaleX(1);
        }

        .card {
            background: linear-gradient(135deg, #2a2a40, #1e1e2f);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border-bottom: none;
            padding: 1.25rem;
        }

        .card-header.success {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
        }

        .card-header.warning {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
        }

        .stats-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 15px;
            background: rgba(110, 142, 251, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-card.warning i {
            background: linear-gradient(45deg, var(--warning-color), #e67e22);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-card.success i {
            background: linear-gradient(45deg, var(--success-color), #27ae60);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-card.info i {
            background: linear-gradient(45deg, var(--info-color), #2980b9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .table-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: rgba(110, 142, 251, 0.1);
        }

        .btn-accept {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-reject {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-view {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-view-details {
            background: rgba(110, 142, 251, 0.2);
            border: 1px solid rgba(110, 142, 251, 0.5);
            color: white;
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-view-details:hover {
            background: rgba(110, 142, 251, 0.4);
            transform: translateY(-2px);
        }

        #particles-js {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: -1 !important;
            background: transparent !important;
            pointer-events: none !important;
        }

        .notification-badge {
            font-size: 0.8rem;
            padding: 5px 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .notification-icon {
            font-size: 1.2rem;
            color: var(--primary-color);
            transition: color 0.3s ease;
        }

        .notification-icon:hover {
            color: var(--accent-color);
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
        }

        .dropdown-menu {
            background: rgba(15, 12, 41, 0.95);
            border: 1px solid rgba(110, 142, 251, 0.3);
            backdrop-filter: blur(15px);
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .dropdown-item {
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(110, 142, 251, 0.1);
            transform: translateX(5px);
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .modal-content {
            background: linear-gradient(135deg, #2a2a40, #1e1e2f);
            border: 1px solid rgba(110, 142, 251, 0.3);
            color: white;
        }

        .modal-header {
            border-bottom: 1px solid rgba(110, 142, 251, 0.3);
        }

        .modal-footer {
            border-top: 1px solid rgba(110, 142, 251, 0.3);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(110, 142, 251, 0.25);
        }

        .badge-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .badge-success {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <nav style="left: 25px;" class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-car me-2"></i>{{ auth()->user()->agency->name }} Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Notifications -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell notification-icon"></i>
                                @if($unreadNotifications > 0)
                                    <span class="badge bg-danger notification-badge">{{ $unreadNotifications }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if($notifications->count() > 0)
                                    @foreach($notifications as $notification)
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div>
                                                    <strong class="text-white mb-2">{{ $notification->message }}</strong>
                                                    @if($notification->rejection_reason)
                                                        <p class="text-light mb-0">{{ $notification->rejection_reason }}</p>
                                                    @endif
                                                    <small class="text-light mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endforeach
                                @else
                                    <li><a class="dropdown-item" href="#">No new notifications</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('agency.notifications') }}">View all notifications</a></li>
                            </ul>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a class="nav-link" href="/agency/dashboard">
                            <i  class="fas fa-puzzle-piece me-2"></i> dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/car">
                            <i class="fas fa-car"></i> Manage Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/agency/bookings">
                            <i class="fas fa-calendar-alt"></i> Bookings
                        </a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </nav>
    
    <div style="padding: 10px" class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" 
                id="agencyAccountDropdown" data-bs-toggle="dropdown" 
                aria-expanded="false">
            @auth
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" 
                         class="rounded-circle me-2" 
                         width="30" 
                         height="30"
                         style="object-fit: cover; border: 1px solid rgba(255,255,255,0.3)">
                @else
                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" 
                         style="width: 30px; height: 30px; background: linear-gradient(135deg, #6e8efb, #a777e3); color: white; font-weight: bold; font-size: 14px; border: 1px solid rgba(255,255,255,0.3)">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            @endauth
            <span>Agency Account</span>
        </button>
        <ul style="background: #0d1114" class="dropdown-menu dropdown-menu-end" aria-labelledby="agencyAccountDropdown">
            <li>
                <div class="d-flex align-items-center px-3 py-2">
                    @auth
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" 
                                 class="rounded-circle me-2" 
                                 width="40" 
                                 height="40"
                                 style="object-fit: cover; border: 1px solid rgba(255,255,255,0.3)">
                        @else
                            <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #6e8efb, #a777e3); color: white; font-weight: bold; font-size: 18px; border: 1px solid rgba(255,255,255,0.3)">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div class="text-white">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    @endauth
                </div>
            </li>
            <li><hr class="dropdown-divider mx-2"></li>
            <li><a class="dropdown-item text-white" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item text-white" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider mx-2"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-white">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="container mt-4">
        <h2 class="mb-4">
            <i class="fas fa-calendar-alt me-2"></i>Bookings Management
        </h2>
        
        <!-- Stats cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card warning">
                    <i class="fas fa-clock"></i>
                    <h3 class="mt-2">{{ $pendingBookings->count() }}</h3>
                    <p class="mb-0">Pending Bookings</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stats-card success">
                    <i class="fas fa-check-circle"></i>
                    <h3 class="mt-2">{{ $confirmedBookings->count() }}</h3>
                    <p class="mb-0">Confirmed Bookings</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stats-card info">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3 class="mt-2">
                        @php
                            $total = $confirmedBookings->sum('total_amount');
                            echo number_format($total, 2) . ' DZD';
                        @endphp
                    </h3>
                    <p class="mb-0">Total Revenue</p>
                </div>
            </div>
        </div>
        
        <!-- Pending bookings -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Pending Bookings
                </h4>
            </div>
            <div class="card-body">
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
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}<br>
                                        to {{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}
                                    </td>
                                    
                                    <td>{{ number_format($booking->total_amount, 2) }} DZD</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('agency.bookings.show', $booking->id) }}" class="btn btn-view-details" title="View Details">
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
                                        </div>
                                        
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
                                                                <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
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
        <div class="card">
            <div class="card-header success">
                <h4 class="mb-0">
                    <i class="fas fa-check-circle me-2"></i>Confirmed Bookings
                </h4>
            </div>
            <div class="card-body">
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
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}<br>
                                        to {{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        @if($booking->delivery_method)
                                            <span class="badge rounded-pill bg-{{ $booking->delivery_method === 'agency' ? 'primary' : 'secondary' }}">
                                                {{ $booking->delivery_method === 'agency' ? 'Agency Pickup' : 'Customer Delivery' }}
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

    <script>
        // GSAP animations
        gsap.from(".card", {
            duration: 0.6,
            scale: 0.95,
            opacity: 0,
            stagger: 0.05,
            ease: "back.out(1.2)"
        });

        // Enhanced particle settings
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 150,
                        "density": {
                            "enable": true,
                            "value_area": 2000
                        }
                    },
                    "color": {
                        "value": ["#6e8efb", "#4a6cf7", "#a678ff"]
                    },
                    "shape": {
                        "type": "circle"
                    },
                    "opacity": {
                        "value": 0.7,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#5d7cff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 3,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "window",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "repulse": {
                            "distance": 100,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });

            // Fix resize issue
            window.addEventListener('resize', function() {
                particlesJS('particles-js', particlesJSConfig);
            });
        });
    </script>
</body>
</html>
@endsection