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
    <title>Subscription Status</title>
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
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }

        /* Subscription Card New Design */
        .subscription-card-new {
            background: rgba(30, 30, 47, 0.8);
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(110, 142, 251, 0.3);
            margin-bottom: 30px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 800px;
            margin: 20px auto;
        }

        .subscription-card-new:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .card-header-new {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .card-header-new h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .card-header-new i {
            margin-right: 12px;
            color: #FFD700;
            font-size: 1.3rem;
        }

        .plan-badge {
            position: absolute;
            top: 20px;
            right: 25px;
        }

        .badge-monthly, .badge-yearly {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
        }

        .badge-monthly {
            background: rgba(52, 152, 219, 0.2);
            border: 1px solid rgba(52, 152, 219, 0.5);
            color: #3498db;
        }

        .badge-yearly {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.5);
            color: #2ecc71;
        }

        .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 8px 20px;
            border-top-left-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
        }

        .active-pulse {
            color: var(--success-color);
            animation: pulseActive 2s infinite;
        }

        .expired-pulse {
            color: var(--danger-color);
            animation: pulseExpired 1.5s infinite;
        }

        .card-body-new {
            padding: 25px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .status-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid var(--primary-color);
        }

        .status-icon {
            width: 50px;
            height: 50px;
            background: rgba(74, 108, 247, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .status-details {
            flex: 1;
        }

        .info-title {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
        }

        /* Countdown Timer - New Design */
        .countdown-container {
            margin-top: 20px;
        }

        .countdown-wrapper {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(110, 142, 251, 0.2);
        }

        .countdown-title {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .countdown {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            gap: 10px;
        }

        .countdown-segment {
            flex: 1;
            position: relative;
        }

        .segment-value {
            display: block;
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            background: rgba(74, 108, 247, 0.2);
            border-radius: 8px;
            padding: 15px 0;
            margin-bottom: 5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .segment-value::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 108, 247, 0.4) 0%, transparent 100%);
            z-index: 0;
        }

        .segment-value.changed {
            animation: valueChange 0.5s ease;
        }

        .segment-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }

        .total-days-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
            border-left: 3px solid var(--success-color);
        }

        /* New Button Style */
        .btn-renew {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none !important;
            cursor: pointer;
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 20px auto 0;
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.4);
            transition: all 0.3s ease;
            font-weight: 600;
            text-align: center;
        }

        .btn-renew:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(41, 128, 185, 0.6);
        }

        /* Animations */
        @keyframes pulseActive {
            0% { text-shadow: 0 0 5px rgba(46, 204, 113, 0.5); }
            50% { text-shadow: 0 0 15px rgba(46, 204, 113, 0.8); }
            100% { text-shadow: 0 0 5px rgba(46, 204, 113, 0.5); }
        }

        @keyframes pulseExpired {
            0% { text-shadow: 0 0 5px rgba(231, 76, 60, 0.5); }
            50% { text-shadow: 0 0 15px rgba(231, 76, 60, 0.8); }
            100% { text-shadow: 0 0 5px rgba(231, 76, 60, 0.5); }
        }

        @keyframes valueChange {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); box-shadow: 0 0 15px rgba(74, 108, 247, 0.5); }
            100% { transform: scale(1); }
        }

        /* Original Styles (kept as is) */
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
    </style>
    <script>
        function startCountdown(expirationDate) {
            const expiry = new Date(expirationDate).getTime();
            
            function updateCountdown() {
                const now = new Date().getTime();
                const diff = expiry - now;
                
                if (diff <= 0) {
                    // Subscription expired
                    document.getElementById('days').textContent = '00';
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';
                    return;
                }
                
                // Calculate time units
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                // Update display
                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
                
                // Animate numbers when they change
                animateValueChanges();
            }
            
            function animateValueChanges() {
                const segments = document.querySelectorAll('.segment-value');
                segments.forEach(segment => {
                    if (segment.dataset.prevValue && segment.dataset.prevValue !== segment.textContent) {
                        segment.classList.add('changed');
                        setTimeout(() => segment.classList.remove('changed'), 500);
                    }
                    segment.dataset.prevValue = segment.textContent;
                });
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    </script>
</head>
<body onload="startCountdown('{{ $subscription->end_date ?? '' }}')">
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
    <div class="container py-5">
        @if(isset($subscription) && $subscription)
            <!-- New Subscription Card Design -->
            <div class="subscription-card-new">
                <div class="card-header-new">
                    <h3><i class="fas fa-crown me-2"></i> Subscription Status</h3>
                    <div style="right: 360px;" class="plan-badge">
                        @if($subscription->plan === 'monthly')
                            <span class="badge-monthly"><i class="fas fa-calendar-week me-1"></i> MONTHLY PLAN</span>
                        @else
                            <span class="badge-yearly"><i class="fas fa-calendar-alt me-1"></i> YEARLY PLAN</span>
                        @endif
                    </div>
                    <div class="status-indicator">
                        @if($subscription->status === 'active')
                            <span class="active-pulse"><i class="fas fa-circle"></i> ACTIVE</span>
                        @else
                            <span class="expired-pulse"><i class="fas fa-circle"></i> EXPIRED</span>
                        @endif
                    </div>
                </div>
                <div class="card-body-new">
                    <div class="status-grid">
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Plan Type</span>
                                <span class="info-value">
                                    @if($subscription->plan === 'monthly')
                                        Monthly Subscription
                                    @else
                                        Yearly Subscription
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Start Date</span>
                                <span class="info-value">{{ $subscription->start_date }}</span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Expiration Date</span>
                                <span class="info-value">{{ $subscription->end_date }}</span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Status</span>
                                <span class="info-value">{{ $subscription->status }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="countdown-container">
                        <div class="countdown-wrapper">
                            <div class="countdown-title">
                                <i class="fas fa-clock me-2"></i> Time Remaining
                            </div>
                            <div class="countdown">
                                <div class="countdown-segment">
                                    <span class="segment-value" id="days">00</span>
                                    <span class="segment-label">Days</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="hours">00</span>
                                    <span class="segment-label">Hours</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="minutes">00</span>
                                    <span class="segment-label">Minutes</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="seconds">00</span>
                                    <span class="segment-label">Seconds</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
    // Calculate days remaining in CURRENT subscription
    $currentDaysRemaining = now()->diffInDays($subscription->end_date);
    
    // Days to be added for NEW subscription
    $newDays = request('plan') === 'monthly' ? 30 : 365;
    
    // For display purposes only - show them separately
@endphp

<div class="total-days-container">
    <p><span class="info-title">Current Days Remaining:</span> 
       <span class="info-value">{{ $currentDaysRemaining }} days</span></p>
    
    <p><span class="info-title">New Days to Add:</span> 
       <span class="info-value">{{ $newDays }} days</span></p>
    
    <p class="total-summary"><span class="info-title">After Renewal:</span> 
       <span class="info-value">Your subscription will be valid until {{ $subscription->end_date->addDays($newDays)->format('Y-m-d') }}</span></p>
</div>

                    <!-- Renew Button -->
                    <div class="text-center">
                        <a href="{{ route('subscription.renew') }}" class="btn-renew">
                            <i class="fas fa-sync-alt me-2"></i>Renew Subscription
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- New Subscription Card Design for No Subscription -->
            <div class="subscription-card-new">
                <div class="card-header-new">
                    <h3><i class="fas fa-exclamation-circle me-2"></i> No Active Subscription</h3>
                </div>
                <div class="card-body-new">
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times mb-3" style="font-size: 3rem; color: #e74c3c;"></i>
                        <h4 class="mb-3">You don't have an active subscription</h4>
                        <p class="mb-4">Subscribe now to access all premium features</p>
                        
                        <a href="{{ route('subscription.renew') }}" class="btn-renew">
                            <i class="fas fa-plus-circle me-2"></i>Subscribe Now
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // GSAP animations
        gsap.from(".subscription-card-new", {
            duration: 0.6,
            scale: 0.95,
            opacity: 0,
            ease: "back.out(1.2)"
        });

        // Enhanced particle background with full coverage
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particles with enhanced settings
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#6e8efb"
                    },
                    "shape": {
                        "type": "circle"
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true
                    },
                    "size": {
                        "value": 3,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#4a6cf7",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out"
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
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
@endsection