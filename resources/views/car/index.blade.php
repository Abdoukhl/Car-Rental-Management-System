@extends('layouts.agency')

@section('title', 'Cars Management')
@section('icon', 'fa-car')
@section('page-title', 'Cars Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Cars</title>
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
            height: 100%;
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

        /* Improved Car Card Styles */
        .car-card {
            padding: 15px;
            margin-bottom: 20px;
        }

        .card-img-top {
            border-radius: 15px 15px 0 0;
            height: 180px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 180px);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #FFC107;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 0.9rem;
            color: #DDDDDD;
            flex-grow: 1;
            margin-bottom: 1rem;
        }

        .card-text span {
            color: #FFC107;
            font-weight: bold;
        }

        .btn-modern {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            min-width: 80px;
            margin: 0 2px;
        }

        .btn-modern:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        }

        .btn-modern.btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-modern.btn-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-modern.btn-danger {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-modern.btn-danger:hover {
            background: #ff4757;
            border-color: #ff4757;
        }

        .btn-modern.btn-success {
            background: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-modern.btn-success:hover {
            background: #218838;
            border-color: #218838;
        }

        .btn-group {
            display: flex;
            gap: 5px;
            margin-top: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-group .btn-modern {
            flex: 1 1 auto;
            min-width: 70px;
            max-width: 100px;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
        }

        .add-car-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .add-car-button .btn-modern {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 20px 0;
            margin-top: 30px;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #110c5e, #0073ff);
            color: white;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
            border: none;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #8a15ff, #007bff);
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #0f700f, #8c9b2d);
            box-shadow: 0 4px 15px rgba(255, 118, 140, 0.5);
            transform: scale(1.1);
        }

        .pagination .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.5);
            box-shadow: none;
            pointer-events: none;
        }

        .pagination .page-link i {
            font-size: 16px;
        }

        .img-container {
            position: relative;
        }

        @media (max-width: 768px) {
            .car-card {
                padding: 10px;
            }
            
            .btn-group .btn-modern {
                min-width: 60px;
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
            }
            
            .card-title {
                font-size: 1.1rem;
            }
            
            .card-text {
                font-size: 0.8rem;
            }
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
                            <i class="fas fa-puzzle-piece me-2"></i> dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="/car">
                            <i class="fas fa-car"></i> Manage Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/agency/bookings">
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
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <h2 class="mb-4">
            <i class="fas fa-car me-2"></i>Cars Management
        </h2>

        <div class="row">
            @if($allCars->isEmpty())
            <div class="col-12 text-center">
                <h3>🚗 No cars available for your agency currently.</h3>
            </div>
            @else
            @foreach ($allCars as $item)
            @if($item->agency_id == Auth::user()->agency->id)
            <div class="col-md-4 col-sm-6 car-card">
                <div class="card h-100">
                    <div class="img-container">
                        <img src="{{ asset('images/' . $item->picture) }}" class="card-img-top img-hover" alt="{{ $item->model }}">
                        <span class="badge bg-{{ $item->status === 'available' ? 'success' : 'secondary' }} status-badge">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->brand }} {{ $item->model }}</h5>
                        <p class="card-text">
                            <i class="fas fa-id-card-alt me-2"></i>License: {{ $item->license_plate }}<br>
                            <i class="fas fa-gas-pump me-2"></i>Fuel: {{ $item->fuel_type }}<br>
                            <i class="fas fa-dollar-sign me-2"></i>${{ $item->daily_rate }}/day<br>
                            <i class="fas fa-leaf me-2"></i>{{ $item->eco_friendly ? 'Eco-Friendly' : 'Not Eco-Friendly' }}
                        </p>
                        <div class="btn-group">
                            <a class="btn-modern btn-primary" href="{{ route('car.show', $item->id) }}">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a class="btn-modern btn-success" href="{{ route('car.edit', $item->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('car.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this car? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-modern btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
        </div>

        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                <!-- Previous Page Link -->
                @if ($allCars->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $allCars->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif
        
                <!-- Pagination Elements -->
                @foreach ($allCars->getUrlRange(1, $allCars->lastPage()) as $page => $url)
                    @if ($page == $allCars->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
        
                <!-- Next Page Link -->
                @if ($allCars->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $allCars->nextPageUrl() }}" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="text-center my-4">
            <a href="{{ route('agency.dashboard') }}" class="btn-modern btn-danger">
                <i class="fas fa-arrow-left"></i> BACK
            </a>
        </div>
    </div>

    <!-- Floating Add Car Button -->
    <div class="add-car-button">
        <a class="btn-modern btn-success" href="{{ route('car.create') }}">
            <i class="fas fa-plus"></i> ADD CAR
        </a>
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