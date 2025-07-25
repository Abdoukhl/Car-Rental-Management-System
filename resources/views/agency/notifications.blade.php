@extends('layouts.agency')

@section('title', 'Agency Notifications')
@section('icon', 'fa-bell')
@section('page-title', 'Agency Notifications')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Notifications</title>
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

        .list-group-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(20px);
            margin-bottom: 10px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-mark-read, .btn-mark-all {
            background: linear-gradient(135deg, var(--accent-color), #ff9a9e);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-mark-read:hover, .btn-mark-all:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.4);
        }

        .btn-clear-history {
            background: linear-gradient(135deg, #ff6b6b, #ff9a9e);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-clear-history:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.4);
        }

        .btn-back-to-dashboard {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back-to-dashboard:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(110, 142, 251, 0.4);
        }

        .alert-info {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .text-light {
            color: rgba(255, 255, 255, 0.9) !important;
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
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('agency.notifications') }}">
                            <i class="fas fa-bell notification-icon"></i> Notifications
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
        <h2 class="mb-4 text-center">
            <i class="fas fa-bell me-2"></i>Agency Notifications
        </h2>

        @if($notifications->where('status', 'unread')->count() > 0)
            <form action="{{ route('agency.notifications.markAllAsRead') }}" method="POST" class="mb-3 text-center">
                @csrf
                <button type="submit" class="btn btn-mark-all">
                    <i class="fas fa-check-circle"></i> Mark All as Read
                </button>
            </form>
        @endif

        @if ($notifications->count() > 0)
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item">
                        <div>
                            <strong class="text-white">{{ $notification->message }}</strong>
                            @if($notification->rejection_reason)
                                <p class="text-muted mb-1">🔴 Rejection Reason: {{ $notification->rejection_reason }}</p>
                            @endif
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        @if($notification->status === 'unread')
                            <form action="{{ route('agency.notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-mark-read">
                                    <i class="fas fa-check"></i> Mark as Read
                                </button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('agency.dashboard') }}" class="btn btn-back-to-dashboard">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <div>
                    <form action="{{ route('agency.notifications.clearHistory') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-clear-history">
                            <i class="fas fa-trash"></i> Clear History
                        </button>
                    </form>
                </div>
                <div>
                    {{ $notifications->links('pagination::bootstrap-4') }}
                </div>
            </div>

        @else
            <p class="alert alert-info text-center">No new notifications.</p>
        @endif
    </div>

    <script>
        // GSAP animations
        gsap.from(".list-group-item", {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.1,
            ease: "power2.out"
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