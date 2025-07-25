<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Car Agency</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: auto;
            margin-top: 0.125rem;
        }
        
        /* Other adjustments to improve appearance */
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            white-space: nowrap;
        }
        
        .dropdown-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 0.5rem 0;
        }
        :root {
            --primary: #6e8efb;
            --primary-dark: #4a6cf7;
            --secondary: #ff6b6b;
            --dark: #0f0c29;
            --darker: #1a1835;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: var(--darker);
        }
        
        .sidebar {
            background: rgba(15, 12, 41, 0.9);
            backdrop-filter: blur(15px);
            border-right: 1px solid rgba(110, 142, 251, 0.2);
            height: 100vh;
            position: sticky;
            top: 0;
        }
        
        .booking-card {
            background: rgba(42, 42, 64, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(110, 142, 251, 0.2);
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(110, 142, 251, 0.4);
        }
        
        .booking-header {
            background: var(--gradient);
            padding: 15px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .booking-body {
            padding: 20px;
        }
        
        /* Navigation */
        .nav-link {
            border-radius: 8px;
            margin: 5px 0;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8); /* Default text color */
        }
        
        .nav-link:hover {
            background: rgba(110, 142, 251, 0.2);
            color: white !important; /* White text on hover */
        }
        
        .nav-link.active {
            background: var(--gradient);
            color: white !important; /* White text for active item */
            box-shadow: 0 4px 15px rgba(110, 142, 251, 0.4);
        }
        
        /* Ensure icons also change color */
        .nav-link.active i,
        .nav-link:hover i {
            color: rgb(255, 255, 255) !important;
        }
        
        .dropdown-menu {
            background: rgba(42, 42, 64, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: none;
            position: absolute;
            z-index: 1000;
            left: 0;
            right: auto;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1.5rem;
        }
        
        .dropdown-item:hover {
            background: rgba(110, 142, 251, 0.2);
            color: white;
        }
        
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .table-custom {
            background: rgba(42, 42, 64, 0.7);
            border-radius: 10px;
            overflow: hidden;
            color: white;
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
        .dropdown-menu {
            z-index: 1050; /* Ensure it's above other elements */
            position: absolute; /* Or use fixed if you want it to stay in place when scrolling */
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Animated particles background -->
    <div id="particles-js"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div  class="col-md-3 p-0 sidebar">
                <div class="p-4">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-car me-2"></i>Dashboard
                    </h4>
                    
                    <ul  class="nav flex-column">
                        <li class="nav-item">
                            <a style="color: white" class="nav-link {{ request()->is('Aghome') ? 'active' : '' }}" href="/Aghome">
                                <i class="fas fa-home me-2"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="color: white" class="nav-link {{ request()->is('agency/dashboard') ? 'active' : '' }}" href="/agency/dashboard">
                                <i class="fas fa-puzzle-piece me-2"></i> Dashboard
                            </a>
                        </li>
                        
                        
                        
                        <li  style="color: white" class="nav-item">
                            <a style="color: white" class="nav-link {{ request()->is('subscription/status') ? 'active' : '' }}" href="{{ route('subscription.renew') }}">
                                <i class="fas fa-info-circle me-2"></i> Subscription Status
                            </a>
                        </li>
                        
                        <li  class="nav-item">
                            <a style="color: white"  class="nav-link {{ request()->is('/car') ? 'active' : '' }}" href="/car">
                                <i class="fas fa-car me-2"></i> Manages Cars
                            </a>
                        </li>
                        <li  class="nav-item">
                            <a style="color: white" class="nav-link {{ request()->is('agency/bookings*') ? 'active' : '' }}" href="/agency/bookings">
                                <i class="fas fa-calendar-alt me-2"></i> Bookings
                            </a>
                        </li>
                        <li  class="nav-item">
                            <a style="color: white" class="nav-link {{ request()->is('agency/'.Auth::user()->agency_id.'/notifications') ? 'active' : '' }}" 
                                href="{{ route('agency.notifications', Auth::user()->agency_id) }}">
                                <i  class="fas fa-bell me-2"></i> All Notifications
                             </a>
                             
                              
                        </li>
                       
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-white" style="background: none; border: none; width: 100%; text-align: left;">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                        
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <!-- Top Navigation Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
                    
                    
                </div>
                
                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    
    <script>
        // Initialize particles background
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#6e8efb" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#6e8efb", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
            }
        });
        
        // Card effects on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.animate__animated');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = 1;
                }, index * 100);
            });
            
            // Initialize dropdown menus
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    const menu = this.nextElementSibling;
                    menu.classList.toggle('show');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(otherMenu) {
                        if (otherMenu !== menu) {
                            otherMenu.classList.remove('show');
                        }
                    });
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>