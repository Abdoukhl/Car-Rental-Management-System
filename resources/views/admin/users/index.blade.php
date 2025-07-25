<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Ethoria Car Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #220a4a;
            --secondary-bg: #172a45;
            --accent-color: #64ffda;
            --text-primary: #f7f7f7;
            --text-secondary: #8892b0;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 90px;
            --top-nav-height: 70px;
            --transition-speed: 0.4s;
            --card-radius: 12px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-bg), var(--secondary-bg));
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Layout */
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            height: 100vh;
            position: fixed;
            transition: all var(--transition-speed) ease;
            z-index: 1000;
            overflow: hidden;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            left: 0;
        }
        
        .sidebar-collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            height: var(--top-nav-height);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            transition: opacity var(--transition-speed);
            width: 100%;
        }
        
        .logo-img {
            height: 40px;
            width: auto;
            transition: all var(--transition-speed);
            margin-right: 12px;
        }
        
        .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-color), #00bcd4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            white-space: nowrap;
        }
        
        .sidebar-collapsed .logo-text {
            opacity: 0;
            width: 0;
        }
        
        .sidebar-collapsed .logo-img {
            height: 32px;
            margin-right: 0;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            height: calc(100vh - var(--top-nav-height));
            overflow-y: auto;
        }
        
        .nav-item {
            position: relative;
            margin-bottom: 8px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--accent-color);
            background: rgba(100, 255, 218, 0.08);
            border-left: 3px solid var(--accent-color);
        }
        
        .nav-link i {
            font-size: 1.3rem;
            margin-right: 18px;
            min-width: 24px;
            text-align: center;
            transition: margin var(--transition-speed);
        }
        
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
        }
        
        .nav-text {
            transition: all var(--transition-speed);
            font-size: 0.95rem;
        }
        
        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
            margin-left: 0;
        }
        
        .badge-notification {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            transition: right var(--transition-speed);
        }
        
        .sidebar-collapsed .badge-notification {
            right: 10px;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            color: var(--accent-color);
            font-size: 1.4rem;
            cursor: pointer;
            transition: all var(--transition-speed);
            padding: 8px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toggle-btn:hover {
            background: rgba(100, 255, 218, 0.1);
        }
        
        .sidebar-collapsed .toggle-btn {
            transform: rotate(180deg);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed);
            min-height: 100vh;
        }
        
        .sidebar-collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }
        /* User Info Section */
.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-link {
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.profile-link:hover {
    transform: translateY(-2px);
}

.profile-text {
    margin-left: 8px;
    font-weight: 500;
    color: var(--text-primary);
    transition: color 0.3s ease;
}

.profile-link:hover .profile-text {
    color: var(--accent-color);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(100, 255, 218, 0.3);
    transition: all 0.3s ease;
}

.user-avatar:hover {
    transform: scale(1.1);
    border-color: var(--accent-color);
}

.logout-btn {
    transition: all 0.3s ease;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
}
        /* Top Navigation */
        .top-nav {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            padding: 0 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            height: var(--top-nav-height);
        }
        
        .page-title {
            font-size: 1.4rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--accent-color), #00bcd4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(100, 255, 218, 0.3);
        }
        
        /* Content Area */
        .content-area {
           
            min-height: calc(100vh - var(--top-nav-height));
        }
        
        /* Card Styles */
        .card {
            background: rgba(255, 255, 255, 0.04);
            border-radius: var(--card-radius);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 25px;
            transition: all 0.4s ease;
            overflow: hidden;
         
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(100, 255, 218, 0.2);
        }
        
        .card-header {
            background: linear-gradient(90deg, var(--accent-color), #00bcd4);
            color: var(--primary-bg);
            padding: 16px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .card-header i {
            margin-right: 10px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .border-primary {
            border: 2px solid var(--accent-color) !important;
        }
       /* تغيير لون placeholder لعناصر input */
.form-control::placeholder {
    color: #999; /* اللون الرمادي الفاتح */
    opacity: 1; /* تأكد من أن العتامة كاملة (مهم لبعض المتصفحات) */
}

/* إذا كنت تريد تطبيقه على جميع العناصر */
input::placeholder {
    color: #999999;
} 
        /* Search and Filter Section */
        .search-filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 8px;
            border: 1px solid rgba(100, 255, 218, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            outline: none;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
        }
        
        .filter-select {
            min-width: 200px;
        }
        
        .filter-select select {
            width: 100%;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid rgba(100, 255, 218, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364ffda' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
        }
        
        .filter-select select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            outline: none;
        }
        
        .reset-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .reset-btn:hover {
            background: rgba(100, 255, 218, 0.1);
            color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            color: var(--text-primary);
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: rgba(100, 255, 218, 0.1);
            color: var(--accent-color);
            border-bottom: 1px solid rgba(100, 255, 218, 0.2);
            padding: 12px 15px;
            font-weight: 600;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(100, 255, 218, 0.05);
        }
        
        .table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }
        
        /* User Avatar in Table */
        .user-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(100, 255, 218, 0.2);
            margin-right: 10px;
        }
        
        .user-name {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
        }
        
        /* Badges */
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 6px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }
        
        .badge i {
            margin-right: 5px;
            font-size: 0.7rem;
        }
        
        .badge-admin {
            background: linear-gradient(135deg, #ff1744, #d50000);
        }
        
        .badge-agency {
            background: linear-gradient(135deg, #ff9100, #ff6d00);
        }
        
        .badge-customer {
            background: linear-gradient(135deg, #00c853, #64dd17);
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            padding: 8px 16px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 8px;
            font-size: 0.8rem;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), #00bcd4);
            color: var(--primary-bg);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff1744, #d50000);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* Status Indicators */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-active {
            background-color: #00c853;
            box-shadow: 0 0 8px #00c853;
        }
        
        .status-inactive {
            background-color: #ff1744;
            box-shadow: 0 0 8px #ff1744;
        }
        
        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }
            
            .sidebar .nav-text,
            .sidebar .logo-text {
                opacity: 0;
                width: 0
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
                
            }
            
            .sidebar-header {
                justify-content: center;
            }
            
            .toggle-btn {
                display: none;
            }
            
            .table td, .table th {
                white-space: nowrap;
            }
        }
        
        @media (max-width: 768px) {
            :root {
                --sidebar-collapsed-width: 0;
            }
            
            .sidebar {
                transform: translateX(-100%);
                z-index: 1100;
            }
            
            .sidebar.active {
                transform: translateX(0);
                width: 260px;
                
            }
            
            .sidebar.active .nav-text,
            .sidebar.active .logo-text {
                opacity: 1;
                width: auto;
            }
            
            .main-content {
                margin-left: 0;
                
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
            
            .search-filter-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box, .filter-select {
                min-width: 100%;
            }
            
            .table td, .table th {
                white-space: normal;
                font-size: 0.9rem;
                padding: 8px 10px;
            }
            
            .user-avatar-sm {
                width: 28px;
                height: 28px;
            }
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--accent-color);
            font-size: 1.5rem;
            margin-right: 15px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--accent-color);
        }
        
        .empty-state h4 {
            color: var(--text-primary);
            margin-bottom: 15px;
        }
        
       /* Pagination Styles */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.page-item {
    margin: 0;
    transition: all 0.3s ease;
}

.page-item:first-child .page-link,
.page-item:last-child .page-link {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(100, 255, 218, 0.1) !important;
    color: var(--text-primary);
    transition: all 0.3s ease;
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
}

.page-link:hover {
    background: rgba(100, 255, 218, 0.1);
    color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(100, 255, 218, 0.1);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--accent-color), #00bcd4);
    border-color: var(--accent-color) !important;
    color: var(--primary-bg);
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(100, 255, 218, 0.3);
}

.page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.02);
    color: var(--text-secondary);
    cursor: not-allowed;
    opacity: 0.7;
}

.page-link:focus {
    box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
    z-index: 3;
}

/* Arrow icons */
.page-item:first-child .page-link::before,
.page-item:last-child .page-link::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    margin-right: 6px;
}

.page-item:first-child .page-link::before {
    content: "\f104";
}

.page-item:last-child .page-link::before {
    content: "\f105";
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .pagination {
        gap: 4px;
    }
    
    .page-link {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
    }
    
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        padding: 6px 12px;
    }
}

/* Animation for active page */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.page-item.active .page-link {
    animation: pulse 1.5s infinite;
}
        
        .page-item .page-link {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            margin: 0 5px;
            border-radius: 6px !important;
        }
        
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--accent-color), #00bcd4);
            border-color: var(--accent-color);
            color: var(--primary-bg);
        }
        
        .page-item.disabled .page-link {
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Ethoria Logo" class="logo-img">
                    <span class="logo-text">AETHORIA</span>
                </div>
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-money-check-alt"></i> 
                            <span class="nav-text">Subscription Center</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.agencies.index') }}" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span class="nav-text">Agencies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.messages.index') }}" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span class="nav-text">Messages</span>
                            @if($unreadMessages > 0)
                            <span class="badge-notification">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link active">
                            <i class="fas fa-users"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.agencies.documents') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i> 
                            <span class="nav-text">Documents</span>
                        </a>
                    </li>
                   
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="d-flex align-items-center">
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="page-title mb-0">Manage Users</h4>
                </div>
                <div  class="user-info">
                    <div  class="profile-link">
                        <a href="{{ route('admin.profile') }}" class="nav-link">
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="user-avatar"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=64ffda&color=0a192f'">
                            <span  class="profile-text">My Profile</span>
                        </a>
                    </div>
  <div style="padding: 22px; margin: 25px;">
                    <form  action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-md-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            </nav>
            <!-- Content Area -->
            <div  class="content-area">
                <div  class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-users me-2"></i>
                                Users List
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                
                                <!-- Search and Filter Form -->
                                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
                                    <div class="search-filter-container">
                                        <div class="search-box">
                                            <i class="fas fa-search"></i>
                                            <input type="text" name="search" placeholder="Search by name or email..." 
                                                   value="{{ request('search') }}" class="form-control">
                                        </div>
                                        
                                        <div class="filter-select">
                                            <select name="account_type" class="form-select">
                                                <option style="color: black" value="">All Account Types</option>
                                                <option style="color: black" value="admin" {{ request('account_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option style="color: black" value="agency" {{ request('account_type') == 'agency' ? 'selected' : '' }}>Agency</option>
                                                <option style="color: black" value="customer" {{ request('account_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                                            </select>
                                        </div>
                                        
                                        <div class="filter-select">
                                            <select name="status" class="form-select">
                                                <option style="color: black" value="">All Statuses</option>
                                                <option style="color: black" value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option style="color: black" value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter"></i> Apply Filters
                                        </button>
                                        
                                        @if(request('search') || request('account_type') || request('status'))
                                            <a href="{{ route('admin.users.index') }}" class="reset-btn">
                                                <i class="fas fa-times"></i> Reset
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Contact</th>
                                                <th>Account Type</th>
                                                <th>Status</th>
                                                <th>Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="user-name">
                                                        <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=172a45&color=ccd6f6' }}" 
                                                             class="user-avatar-sm" alt="{{ $user->name }}">
                                                        <div>
                                                            <strong>{{ $user->name }}</strong>
                                                            <div class="text-muted small">ID: {{ $user->id }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>{{ $user->email }}</div>
                                                    @if($user->phone)
                                                    <div class="text-muted small">{{ $user->phone }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->account_type == 'admin')
                                                        <span class="badge badge-admin">
                                                            <i class="fas fa-crown"></i> Admin
                                                        </span>
                                                    @elseif($user->account_type == 'agency')
                                                        <span class="badge badge-agency">
                                                            <i class="fas fa-building"></i> Agency
                                                        </span>
                                                    @else
                                                        <span class="badge badge-customer">
                                                            <i class="fas fa-user"></i> Customer
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->is_active)
                                                        <span class="d-flex align-items-center">
                                                            <span class="status-indicator status-active"></span>
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="d-flex align-items-center">
                                                            <span class="status-indicator status-inactive"></span>
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                                                    <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            @if($user->account_type == 'admin')
                                                                <button type="button" class="btn btn-sm btn-secondary" disabled 
                                                                    title="Admin accounts cannot be deleted" data-bs-toggle="tooltip">
                                                                    <i class="fas fa-shield-alt"></i>
                                                                </button>
                                                            @else
                                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="fas fa-user-slash"></i>
                                                        <h4>No Users Found</h4>
                                                        <p>There are currently no users matching your criteria.</p>
                                                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-3">
                                                            <i class="fas fa-sync-alt"></i> Reset Filters
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($users->hasPages())
                                <div class="pagination-container">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($users->onFirstPage())
                                                <li class="page-item disabled" aria-disabled="true">
                                                    <span class="page-link">Previous</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                                </li>
                                            @endif
                                
                                            {{-- Pagination Elements --}}
                                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                                @if ($page == $users->currentPage())
                                                    <li class="page-item active" aria-current="page">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                
                                            {{-- Next Page Link --}}
                                            @if ($users->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled" aria-disabled="true">
                                                    <span class="page-link">Next</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <p class="mb-0">© 2025 AETHORIA Car Agency. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar
        const toggleBtn = document.getElementById('toggleSidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
        });
        
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
        
        // Responsive sidebar
        function handleResize() {
            if (window.innerWidth < 992) {
                sidebar.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.remove('active');
            }
        }
        
        window.addEventListener('resize', handleResize);
        handleResize(); // Initialize
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>