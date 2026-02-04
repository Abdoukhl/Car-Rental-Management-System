<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Aethoria Rental Drive</title>
    <!-- Font Awesome -->
    <link rel="icon" type="" href="images/demo/Gallery/Aethoria Rental Drive Logo.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --primary-blue: #1a56a7;
            --dark-blue: #0a192f;
            --light-blue: #64b5f6;
            --accent-blue: #2196f3;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --black: #000000;
            --sidebar-width: 280px;
            --mobile-sidebar-width: 90%;
            --transition-speed: 0.3s;
            --transition-easing: cubic-bezier(0.4, 0, 0.2, 1);
            --navbar-height: 80px;
            --mobile-navbar-height: 120px;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--white);
            color: var(--dark-gray);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            transition: padding-left var(--transition-speed) var(--transition-easing);
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: calc(-1 * var(--sidebar-width));
            background-color: var(--dark-blue);
            overflow-x: hidden;
            overflow-y: auto;
            transition: transform var(--transition-speed) var(--transition-easing);
            padding-top: 20px;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
            transform: translateX(0);
        }
        
        .sidebar.active {
            transform: translateX(var(--sidebar-width));
        }
        
        .sidebar a {
            padding: 14px 25px;
            text-decoration: none;
            font-size: 1rem;
            color: var(--white);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin: 5px 15px;
            border-radius: 6px;
        }
        
        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            color: var(--light-blue);
            border-left: 4px solid var(--light-blue);
            transform: translateX(5px);
        }
        
        .sidebar a i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .sidebar .closebtn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 1.8rem;
            color: var(--white);
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        
        .sidebar .closebtn:hover {
            opacity: 1;
            transform: rotate(90deg);
        }
        
        /* Sidebar overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) var(--transition-easing);
            backdrop-filter: blur(3px);
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Sidebar toggle button */
        .openbtn {
            font-size: 1.5rem;
            cursor: pointer;
            background-color: var(--dark-blue);
            border: none;
            color: var(--white);
            padding: 12px 15px;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .openbtn:hover {
            background-color: var(--primary-blue);
            transform: scale(1.1);
        }
        
        /* Profile dropdown */
        .profile-container {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }
        
        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .profile-avatar:hover {
            border-color: var(--light-blue);
            transform: scale(1.05);
        }
        
        .profile-info {
            margin-left: 15px;
            color: white;
        }
        
        .profile-name {
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 1rem;
        }
        
        .profile-email {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        /* Sidebar buttons */
        .sidebar-buttons {
            padding: 15px;
            margin-top: 10px;
        }
        
        .sidebar-btn {
            display: block;
            text-align: center;
            color: white;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-btn i {
            margin-right: 8px;
        }
        
        .sidebar-btn.sidebar-login-btn {
            background-color: rgb(4, 129, 4);
            color: white;
            transition: color 0.3s ease-in-out;
        }
        
        .sidebar-btn.sidebar-login-btn:hover {
            color: #c0ffb3;
        }
        
        .sidebar-register-btn {
            background-color: var(--accent-blue);
        }
        
        .sidebar-register-btn:hover {
            background-color: #090d10;
            transform: translateY(-2px);
        }
        
        .logout-btn {
            background-color: #e53935;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background-color: #c62828;
            transform: translateY(-2px);
        }
       
        .logout-btn i {
            margin-right: 8px;
        }
        
        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background-color: var(--dark-blue);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            box-shadow: 0 2px 15px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            height: var(--navbar-height);
        }
        
        .navbar.scrolled {
            padding: 10px 5%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            height: calc(var(--navbar-height) - 10px);
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .navbar a {
            color: var(--white);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .navbar a:hover {
            color: var(--light-blue);
        }
        
        .navbar a.active {
            color: var(--light-blue);
        }
        
        .navbar a.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--light-blue);
            bottom: -5px;
            left: 0;
            transform-origin: left;
            animation: underlineGrow 0.3s ease forwards;
        }
        
        @keyframes underlineGrow {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
        
        .auth-links {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .user-card {
            display: flex;
            align-items: center;
            background-color: rgba(255,255,255,0.1);
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            white-space: nowrap;
        }
        
        .user-card:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            padding: 10px 0;
            width: 200px;
            z-index: 1002;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        
        .user-card:hover .profile-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .profile-dropdown a {
            display: block;
            padding: 10px 15px;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .profile-dropdown a:hover {
            background-color: var(--light-gray);
            color: var(--primary-blue);
        }
        
        .profile-dropdown a i {
            margin-right: 8px;
            color: var(--primary-blue);
            width: 18px;
            text-align: center;
        }
        
        .auth-links button {
            background-color: var(--accent-blue);
            border: none;
            color: var(--white);
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        
        .auth-links button:hover {
            background-color: var(--primary-blue);
            transform: translateY(-2px);
        }
        
        /* Logo and Company Name Styles */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 50px;
            transition: transform 0.3s ease;
            border-radius: 5px;
        }

        .company-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--accent-blue) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            white-space: nowrap;
        }

        .company-name::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--light-blue), var(--accent-blue));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .logo-container:hover .company-name::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        /* Main Content */
        .main-content {
            margin-top: var(--navbar-height);
            padding: 20px;
            transition: margin-top 0.3s ease;
            min-height: calc(100vh - var(--navbar-height) - 80px);
        }
        
        .main-content.scrolled {
            margin-top: calc(var(--navbar-height) - 10px);
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 30px 0;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .footer a {
            color: var(--light-blue);
            text-decoration: none;
            transition: 0.3s;
        }
        
        .footer a:hover {
            color: var(--white);
            text-decoration: underline;
        }
        
        /* Subscription Button Styles */
        .subscribe-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        
        .subscribe-btn:hover {
            background-color: #3e8e41;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .subscribe-btn i {
            font-size: 0.9rem;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .navbar {
                flex-wrap: wrap;
                height: auto;
                padding: 10px 5%;
            }
            
            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                margin-top: 10px;
                gap: 15px;
            }
            
            .auth-links {
                order: 2;
                margin-left: auto;
                gap: 10px;
            }
            
            .logo-container {
                order: 1;
            }
            
            .main-content {
                margin-top: var(--mobile-navbar-height);
            }
            
            .main-content.scrolled {
                margin-top: calc(var(--mobile-navbar-height) - 10px);
            }
        }
        
        @media (max-width: 768px) {
            :root {
                --sidebar-width: var(--mobile-sidebar-width);
            }
            
            .navbar {
                padding: 8px 3%;
            }
            
            .nav-links {
                gap: 10px;
                font-size: 0.9rem;
            }
            
            .auth-links {
                gap: 8px;
            }
            
            .logo img {
                height: 40px;
            }

            .company-name {
                font-size: 1.2rem;
            }
            
            .navbar a {
                font-size: 0.9rem;
            }
            
            .auth-links button {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .user-card {
                padding: 6px 12px;
                font-size: 0.9rem;
            }
            
            .profile-dropdown {
                width: 180px;
            }
        }
        
        @media (max-width: 480px) {
            .navbar {
                padding: 5px 2%;
            }
            
            .nav-links {
                gap: 8px;
                font-size: 0.8rem;
            }
            
            .auth-links {
                gap: 5px;
            }
            
            .logo img {
                height: 35px;
            }

            .company-name {
                font-size: 1rem;
            }
            
            .navbar a {
                font-size: 0.8rem;
            }
            
            .auth-links button {
                padding: 5px 10px;
                font-size: 0.7rem;
            }
            
            .user-card {
                padding: 5px 10px;
                font-size: 0.8rem;
            }
            
            .profile-dropdown {
                width: 160px;
            }
            
            .openbtn {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                top: 10px;
                left: 10px;
            }
            
            .sidebar a {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
            
            .sidebar-buttons {
                padding: 10px;
            }
            
            .sidebar-btn {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 360px) {
            .logo-container {
                gap: 5px;
            }
            
            .company-name {
                font-size: 0.9rem;
            }
            
            .nav-links {
                gap: 5px;
            }
            
            .auth-links button {
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>
    <button class="openbtn" onclick="toggleSidebar()" aria-label="Toggle navigation" id="sidebarToggleBtn">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
      <br>
      <br>
        
        <!-- Profile Section -->
        @auth
        <div class="profile-container">
            <div class="user-card">
                <div class="user-icon" 
                title="User ID: {{ Auth::user()->agency ? Auth::user()->agency->id : Auth::user()->customer->id }}">
               <br>
                <i class="fas fa-user"></i>
               
               <span style="color: white" class="user-id">
                   {{ Auth::user()->agency ? Auth::user()->agency->id : Auth::user()->customer->id }}
               </span>
           </div>
           
                <span style="color: var(--white);">
                    @if(Auth::user()->account_type === 'agency' && Auth::user()->agency)
                    <i class="fas fa-building" style="color: var(--light-blue);"></i> {{ Auth::user()->agency->name }}
                    @elseif(Auth::user()->account_type === 'customer' && Auth::user()->customer)
                    <i class="fas fa-user" style="color: var(--light-blue);"></i> {{ Auth::user()->customer->name }}
                    @else
                    <i class="fas fa-user" style="color: var(--light-blue);"></i> {{ Auth::user()->name }}
                    @endif
                </span>
                <div class="profile-info">
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>
        @else
        <div class="logo" style="text-align: center; padding: 20px;">
            <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" 
                 alt="Logo" 
                 style="width: 180px; height: auto;">
        </div>
        
        @endauth
        
        <a href="{{ Auth::check() && Auth::user()->account_type === 'agency' ? route('agency.Aghome') : route('dashboard') }}">
            <i class="fas fa-home"></i> Home
        </a>
        @if(Auth::check() && Auth::user()->account_type === 'customer')
    <a href="/customer/carlist" class="nav-link {{ request()->is('customer/carlist*') ? 'active' : '' }}">
        <i class="fas fa-car"></i> Rent
    </a>
@elseif(Auth::check() && Auth::user()->account_type === 'agency')
    <a href="/agency/bookings" class="nav-link {{ request()->is('agency/bookings*') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt"></i> Bookings
    </a>
@endif

        <a href="/contact"><i class="fas fa-info-circle"></i> About</a>
        <a href="http://127.0.0.1:8000/dashboard#contact"><i class="fas fa-envelope"></i> Contact</a>
          
        @auth
        @if(auth()->user()->account_type === 'agency')
            @php
                $subscription = Auth::user()->agency->subscription ?? null;
                $daysRemaining = $subscription && $subscription->end_date > now() 
                    ? (int)now()->diffInDays($subscription->end_date)
                    : 0;
                   
                $totalDays = $daysRemaining;
            @endphp
    
            @if($subscription && $subscription->end_date > now())
                <div style="padding: 14px 25px; margin: 5px 15px; border-radius: 6px; 
                            background: rgba(76, 175, 80, 0.1); color: #4CAF50; 
                            font-weight: bold; display: flex; align-items: center;">
                    <i class="fas fa-clock" style="margin-right: 10px;"></i>
                    {{ $totalDays }} days left
                </div>
            @else
                <a href="{{ route('subscription.renew') }}" 
                   style="margin: 5px 15px; display: block; padding: 14px 25px; 
                          background: #4CAF50; color: white; border-radius: 6px; 
                          text-decoration: none; transition: all 0.3s;">
                    <i class="fas fa-crown"></i> Subscribe Now
                </a>
            @endif
        @endif
        @if(auth()->user()->account_type === 'customer')
        <a href="{{ route('bookings.customer-index') }}" class="{{ request()->routeIs('bookings.customer-index') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i> My Bookings
        </a>
        
                    @endif
    @endauth

        <div class="sidebar-buttons">
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @else
            <div style="padding: 3px">
                <a  href="{{ route('login') }}" class="sidebar-btn sidebar-login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
                <a   href="{{ route('register') }}" class="sidebar-btn sidebar-register-btn">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            @endif
        </div>
    </div>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="navbar" id="mainNavbar">
            <div class="logo-container">
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Company Logo">
                    </a>
                </div>
                <div class="company-name">AETHORIA</div>
            </div>

            <div class="nav-links">
                <a href="{{ Auth::check() && Auth::user()->account_type === 'agency' ? route('agency.Aghome') : route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') || request()->routeIs('agency.Aghome') ? 'active' : '' }}">
                     <i class="fas fa-home me-2"></i> Home
                 </a>
                 @if(Auth::check() && auth()->user()->account_type === 'customer')
    <a href="/customer/carlist" class="nav-link {{ request()->is('customer/carlist*') ? 'active' : '' }}">
        <i class="fas fa-car me-2"></i> Rent
    </a>
@elseif(Auth::check() && auth()->user()->account_type === 'agency')
    <a href="/agency/bookings" class="nav-link {{ request()->is('agency/bookings*') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt me-2"></i> Bookings
    </a>
@endif
                
                <a href="/contact">
                    <i class="fas fa-info-circle me-2"></i> About
                </a>
                <a href="http://127.0.0.1:8000/dashboard#contact"><i class="fas fa-envelope"></i> Contact</a>

                @auth
                @if(auth()->user()->account_type === 'agency')
                    @php
                        $subscription = Auth::user()->agency->subscription ?? null;
                        $daysRemaining = $subscription && $subscription->end_date > now() 
                            ? (int)now()->diffInDays($subscription->end_date)
                            : 0;
                        $totalDays = $daysRemaining;
                    @endphp
           
                    @if($subscription && $subscription->end_date > now())
                        <div style="display: inline-block; padding: 8px 16px; margin-left: 15px; 
                                    background: rgba(76, 175, 80, 0.1); border-radius: 5px; 
                                    color: #4CAF50; font-weight: bold;">
                            <i class="fas fa-clock" style="margin-right: 5px;"></i>
                            {{  $totalDays  }} days left
                        </div>
                    @else
                        <a href="{{ route('subscription.renew') }}" 
                           style="display: inline-block; padding: 8px 16px; 
                                  background: #4CAF50; color: white; border-radius: 5px; 
                                  text-decoration: none; transition: all 0.3s;">
                            <i class="fas fa-crown"></i> Subscribe Now 
                        </a>
                    @endif
                @endif
                @if(auth()->user()->account_type === 'customer')
        <a href="{{ route('bookings.customer-index') }}" class="{{ request()->routeIs('bookings.customer-index') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i> My Bookings
        </a>
        
                    @endif
            @endauth
            </div>

            <div class="auth-links">
                @auth
                <div class="user-card">
                    <span style="color: var(--white); display: flex; align-items: center; gap: 10px;">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile Photo"
                             style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid var(--light-blue);">
                
                        @if(Auth::user()->account_type === 'agency' && Auth::user()->agency)
                            {{ Auth::user()->agency->name }}
                        @elseif(Auth::user()->account_type === 'customer' && Auth::user()->customer)
                            {{ Auth::user()->name }}
                        @else
                            {{ Auth::user()->name }}
                        @endif
                    </span>
                    
                    <div class="profile-dropdown">
                        <a href="{{ route('profile') }}">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                   
                        <a href="#">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="sidebar-btn sidebar-login-btn" style="padding: 8px 16px;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="sidebar-btn sidebar-register-btn" style="padding: 8px 16px;">
                    <i class="fas fa-user-plus"></i> Register
                </a>
                @endauth
            </div>
        </nav>

        <div class="main-content" id="mainContent">
            {{ $slot }}
        </div>
    </div>
   
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} AETHORIA  Car Rental. All rights reserved.</p>
            <div style="margin-top: 15px;">
                <a href="/contact">About</a>  | <a href="http://127.0.0.1:8000/dashboard#contact">Contact Us</a>
            </div>
        </div>
    </footer>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // العناصر الأساسية
            const sidebar = document.getElementById("mySidebar");
            const overlay = document.querySelector(".sidebar-overlay");
            const toggleBtn = document.getElementById("sidebarToggleBtn");
            const body = document.body;
            const mainContent = document.getElementById("mainContent");

            // دالة تبديل السايدبار
            function toggleSidebar() {
                const isActive = sidebar.classList.contains("active");
                
                sidebar.classList.toggle("active", !isActive);
                overlay.classList.toggle("active", !isActive);
                toggleBtn.style.opacity = isActive ? "1" : "0";
                body.style.overflow = isActive ? "auto" : "hidden";
            }

            // إغلاق السايدبار عند النقر خارجها
            function closeSidebar() {
                sidebar.classList.remove("active");
                overlay.classList.remove("active");
                toggleBtn.style.opacity = "1";
                body.style.overflow = "auto";
            }

            // تعيين الأحداث
            toggleBtn.addEventListener("click", toggleSidebar);
            overlay.addEventListener("click", closeSidebar);

            // إغلاق السايدبار عند النقر على روابط معينة
            document.querySelectorAll(".sidebar a").forEach(link => {
                if (!link.classList.contains('closebtn') && !link.hasAttribute('data-keep-open')) {
                    link.addEventListener("click", function(e) {
                        const href = this.getAttribute('href');
                        if (!href.startsWith('http') && !href.startsWith('#') && !href.startsWith('javascript')) {
                            closeSidebar();
                        }
                    });
                }
            });

            // تأثير التمرير للناف بار
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('mainNavbar');
                const isScrolled = window.scrollY > 50;
                
                navbar?.classList.toggle('scrolled', isScrolled);
                mainContent?.classList.toggle('scrolled', isScrolled);
            });

            // تعديل حجم السايدبار ليتناسب مع ارتفاع الشاشة
            function adjustSidebarHeight() {
                const windowHeight = window.innerHeight;
                sidebar.style.height = windowHeight + 'px';
            }

            // تعديل الارتفاع عند تحميل الصفحة وعند تغيير حجم النافذة
            adjustSidebarHeight();
            window.addEventListener('resize', adjustSidebarHeight);
        });
    </script>
</body>
</html>