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
    <title>Agency Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #6e8efb;
            --secondary-color: #4a6cf7;
            --accent-color: #ff6b6b;
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
            width: 85%;
            max-width: 400px;
            margin: 1rem auto;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .card img {
            border-radius: 15px 15px 0 0;
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FFC107;
            margin-bottom: 1rem;
        }

        .card-text {
            font-size: 1rem;
            color: #DDDDDD;
        }

        .card-text span {
            color: #FFC107;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FFC107, #E0A800);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #212121;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #333, #444);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #444, #555);
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .container {
            padding-top: 3rem;
            padding-bottom: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #FFC107;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .footer {
            background-color: #000000;
        }

        .stats-card {
            padding: 20px;
            text-align: center;
            background: linear-gradient(145deg, rgba(110,142,251,0.15), rgba(74,108,247,0.1));
            border-radius: 15px;
            margin-bottom: 1rem;
        }

        .stats-card i {
            font-size: 2rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .img-hover {
            transition: transform 0.3s ease;
            border-radius: 10px;
        }

        .img-hover:hover {
            transform: scale(1.03);
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

        .container {
            position: relative;
            z-index: 1;
        }

        .form-container {
            position: relative;
            z-index: 10;
        }

        /* Loader CSS */
        .loader {
            width: 6em;
            height: 6em;
            font-size: 10px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader .face {
            position: absolute;
            border-radius: 50%;
            border-style: solid;
            animation: animate023845 3s linear infinite;
        }

        .loader .face:nth-child(1) {
            width: 100%;
            height: 100%;
            color: gold;
            border-color: currentColor transparent transparent currentColor;
            border-width: 0.2em 0.2em 0em 0em;
            --deg: -45deg;
            animation-direction: normal;
        }

        .loader .face:nth-child(2) {
            width: 70%;
            height: 70%;
            color: lime;
            border-color: currentColor currentColor transparent transparent;
            border-width: 0.2em 0em 0em 0.2em;
            --deg: -135deg;
            animation-direction: reverse;
        }

        .loader .face .circle {
            position: absolute;
            width: 50%;
            height: 0.1em;
            top: 50%;
            left: 50%;
            background-color: transparent;
            transform: rotate(var(--deg));
            transform-origin: left;
        }

        .loader .face .circle::before {
            position: absolute;
            top: -0.5em;
            right: -0.5em;
            content: '';
            width: 1em;
            height: 1em;
            background-color: currentColor;
            border-radius: 50%;
            box-shadow: 0 0 2em,
                        0 0 4em,
                        0 0 6em,
                        0 0 8em,
                        0 0 10em,
                        0 0 0 0.5em rgba(255, 255, 0, 0.1);
        }

        @keyframes animate023845 {
            to {
                transform: rotate(1turn);
            }
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
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #110c5e, #0073ff);
    color: white;
    font-weight: bold;
    text-decoration: none;
    font-size: 18px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
    border: none;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #8a15ff, #007bff);
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #0f700f, #8c9b2d);
    box-shadow: 0 4px 20px rgba(255, 118, 140, 0.5);
    transform: scale(1.1);
}

.pagination .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.5);
    box-shadow: none;
    pointer-events: none;
}

.pagination .page-link i {
    font-size: 20px;
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
                        <a class="nav-link" href="/car">
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
        <!-- Cars, Bookings, Payments and Notifications Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stats-card" onclick="window.location.href='/car'">
                    <i class="fas fa-car"></i>
                    <h3 class="mt-2">{{ $car->where('agency_id', auth()->user()->agency->id)->count() }}</h3>
                    <p class="mb-0">Total Cars</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3 class="mt-2">0</h3>
                    <p class="mb-0">Total Bookings</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <i class="fas fa-wallet"></i>
                    <h3 class="mt-2">0</h3>
                    <p class="mb-0">Pending Payments</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <i class="fas fa-bell"></i>
                    <h3 class="mt-2">0</h3>
                    <p class="mb-0">Unread Notifications</p>
                </div>
            </div>
        </div>
        
        <!-- Agency Status and Subscription Button -->
        <div class="row mb-4">
            <div class="col-md-8">
                @php
                    $documentStatus = \App\Models\Document::where('agency_id', auth()->user()->agency->id)
                        ->latest()
                        ->value('status');
                @endphp

                @if($documentStatus !== 'approved')
                    <div style="left: 25%" class="card form-container">
                        <div class="card-body">
                            <h3 style="color: #fff" class="mb-3">
                                <i class="fas fa-gem me-2"></i>Agency Status
                                @if($documentStatus === 'pending')
                                    <div class="loader" style="display: inline-block; vertical-align: middle;">
                                        <div class="face">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="face">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                @endif
                            </h3>
                            
                            <div class="alert alert-{{ $documentStatus === 'pending' ? 'warning' : 'danger' }} d-flex align-items-center">
                                <i class="fas fa-{{ $documentStatus === 'pending' ? 'clock' : 'times-circle' }} me-3 fs-4"></i>
                                <div>
                                    <h5 class="mb-1">
                                        @if($documentStatus === 'pending')
                                            Under Review
                                        @else
                                            Rejected
                                        @endif
                                    </h5>
                                    @if($documentStatus === 'rejected')
                                        <p class="mb-0">Rejection Reason: {{ $notification->rejection_reason ?? 'Please check notifications' }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header bg-{{ $documentStatus === 'pending' ? 'warning' : 'danger' }} text-white">
                                    <i class="fas fa-upload me-2"></i>
                                    {{ $documentStatus === 'pending' ? 'Upload Documents' : 'Re-upload' }}
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('agency.reuploadDocument', ['id' => auth()->user()->agency->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label style="color: #fff" class="form-label"><i class="fas fa-file-pdf me-2"></i>Select Document File</label>
                                            <input type="file" name="registration_document" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-{{ $documentStatus === 'pending' ? 'warning' : 'danger' }} w-100">
                                            <i class="fas fa-upload me-2"></i>
                                            {{ $documentStatus === 'pending' ? 'Upload Document' : 'Re-upload' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

       <!-- Recent Cars Section -->
<h2 class="mb-3"><i class="fas fa-car me-2"></i>Recent Cars</h2>
<div class="row g-3">
    @foreach($cars as $car)

    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card h-100 w-100">
            <img src="{{ asset('images/' . $car->picture) }}" class="card-img-top img-hover" alt="{{ $car->model }}">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">{{ $car->brand }} {{ $car->model }}</h5>
                    <span class="badge bg-primary">{{ $car->year }}</span>
                </div>

                <div class="row g-2 mb-3 flex-grow-1">
                    <div class="col-6">
                        <div class="d-flex align-items-center h-100">
                            <i class="fas fa-id-card-alt me-2"></i>
                            <span class="card-text">License Plate: {{ $car->license_plate }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center h-100">
                            <i class="fas fa-gas-pump me-2"></i>
                            <span class="card-text">{{ $car->fuel_type }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge bg-{{ $car->status === 'available' ? 'success' : 'secondary' }}">
                        {{ ucfirst($car->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
<div class="d-flex justify-content-center mt-5">
    <nav>
        <ul class="pagination">
           
            @if ($cars->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-angle-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $cars->previousPageUrl() }}" aria-label="Previous">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $cars->lastPage(); $i++)
                <li class="page-item {{ $cars->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $cars->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- زر "التالي" -->
            @if ($cars->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $cars->nextPageUrl() }}" aria-label="Next">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
</div>

        </div>
       <br>
       <br>
       <br>
       <h2 class="my-3"><i class="fas fa-calendar-alt me-2"></i>Recent Bookings</h2>
       <div class="row g-3">
           @foreach($bookings->where('agency_id', auth()->user()->agency->id) as $booking)
           <div class="col-md-6">
               <div class="card">
                   <div class="card-body">
                       <div class="d-flex justify-content-between align-items-center mb-3">
                           <h5 class="card-title mb-0">Booking #{{ $booking->id }}</h5>
                           <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                               {{ ucfirst($booking->status) }}
                           </span>
                       </div>
                       <div class="row g-3">
                           <div class="col-md-6">
                               <div class="d-flex align-items-center">
                                   <i class="fas fa-user me-2"></i>
                                   <span>Customer: #{{ $booking->customer_id }}</span>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="d-flex align-items-center">
                                   <i class="fas fa-car me-2"></i>
                                   <span>Car: #{{ $booking->car_id }}</span>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="d-flex align-items-center">
                                   <i class="fas fa-calendar-day me-2"></i>
                                   <span>{{ $booking->start_date }}</span>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="d-flex align-items-center">
                                   <i class="fas fa-calendar-day me-2"></i>
                                   <span>{{ $booking->end_date }}</span>
                               </div>
                           </div>
                           <div class="col-12">
                               <hr class="my-2">
                               <div class="d-flex justify-content-between align-items-center">
                                   <span class="fw-bold">Total Price:</span>
                                   <span class="text-primary">${{ $booking->total_price }}</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           @endforeach
       </div>
       <div class="d-flex justify-content-center mt-5">
        <nav>
            <ul class="pagination">
                <!-- زر "السابق" -->
                @if ($bookings->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-angle-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $bookings->previousPageUrl() }}" aria-label="Previous">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                @endif
    
                <!-- أرقام الصفحات -->
                @for ($i = 1; $i <= $bookings->lastPage(); $i++)
                    <li class="page-item {{ $bookings->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $bookings->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
    
                <!-- زر "التالي" -->
                @if ($bookings->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $bookings->nextPageUrl() }}" aria-label="Next">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-angle-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    
    </div>
    <script>
        // GSAP animations
        gsap.from(".stats-card", {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.1,
            ease: "power2.out"
        });
    
        gsap.from(".card", {
            duration: 0.6,
            scale: 0.95,
            opacity: 0,
            stagger: 0.05,
            ease: "back.out(1.2)"
        });
    
        // Enhanced particle background with full coverage
        document.addEventListener('DOMContentLoaded', function() {
            // Reset element size first
            const particlesEl = document.getElementById('particles-js');
            particlesEl.style.position = 'fixed';
            particlesEl.style.top = '0';
            particlesEl.style.left = '0';
            particlesEl.style.width = '100vw';
            particlesEl.style.height = '100vh';
            particlesEl.style.z-index = '-1';
    
            // Initialize particles with enhanced settings
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 200,
                        "density": {
                            "enable": true,
                            "value_area": 1500  // Better distribution
                        }
                    },
                    "color": {
                        "value": ["#6e8efb", "#4a6cf7", "#a678ff"]
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.7,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.3
                        }
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
                        "out_mode": "bounce",
                        "bounce": true,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "window",  // Changed from canvas to window
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse",
                            "distance": 150
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
    
            // Fix resize on window change
            window.addEventListener('resize', function() {
                particlesJS('particles-js', particlesJSConfig);
            });
        });
    
        // GSAP card effects (optional)
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, { 
                    duration: 0.2,
                    y: -5,
                    boxShadow: "0 10px 25px rgba(0,0,0,0.3)",
                    ease: "power2.out"
                });
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { 
                    duration: 0.3,
                    y: 0,
                    boxShadow: "0 4px 15px rgba(0,0,0,0.2)",
                    ease: "back.out"
                });
            });
        });
    </script>
</body>
</html>
@endsection