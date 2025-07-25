<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency List - Ethoria Car Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #220a4a;
            --secondary-bg: #172a45;
            --accent-color: #64ffda;
            --text-primary: #ccd6f6;
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
            padding: 25px;
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
        
        /* Agency Grid Styles */
        .agency-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .agency-card {
            background: rgba(23, 42, 69, 0.7);
            border-radius: var(--card-radius);
            padding: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .agency-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(100, 255, 218, 0.3);
        }
        
        .agency-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), #00bcd4);
        }
        
        .agency-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--accent-color);
            display: flex;
            align-items: center;
        }
        
        .agency-name i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .agency-details {
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .detail-label {
            color: var(--text-secondary);
            min-width: 100px;
            font-weight: 500;
        }
        
        .detail-value {
            color: var(--text-primary);
            font-weight: 400;
        }
        
        .agency-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
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
        
        .btn-view {
            background: rgba(100, 255, 218, 0.1);
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
        }
        
        .btn-view:hover {
            background: rgba(100, 255, 218, 0.2);
        }
        
        .btn-edit {
            background: rgba(0, 200, 83, 0.1);
            color: #00c853;
            border: 1px solid #00c853;
        }
        
        .btn-edit:hover {
            background: rgba(0, 200, 83, 0.2);
        }
        
        .btn-delete {
            background: rgba(255, 23, 68, 0.1);
            color: #ff1744;
            border: 1px solid #ff1744;
        }
        
        .btn-delete:hover {
            background: rgba(255, 23, 68, 0.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }
        
        .empty-state h4 {
            color: var(--text-primary);
            margin-bottom: 10px;
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
                width: 0;
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
            
            .agency-grid {
                grid-template-columns: 1fr;
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
        
        /* Search and Filter Bar */
        .search-filter-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap;
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
        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }
        
        .filter-dropdown {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 15px;
            color: var(--text-primary);
            font-size: 0.9rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar (unchanged) -->
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
                        <a href="{{ route('admin.agencies.index') }}" class="nav-link active">
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
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
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
                    <h4 class="page-title mb-0">Agency Management</h4>
                </div>
                <div class="user-info">
                    <div class="profile-link">
                        <a href="{{ route('admin.profile') }}" class="nav-link">
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="user-avatar"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=64ffda&color=0a192f'">
                            <span class="profile-text">My Profile</span>
                        </a>
                    </div>
                
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-md-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
            <!-- Content Area -->
            <div class="content-area">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-building me-2"></i>Registered Agencies
                               
                            </div>
                            <div class="card-body">
                                <!-- Search and Filter Bar -->
                                <div class="search-filter-bar">
                                    <div class="search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" placeholder="Search agencies...">
                                    </div>
                                    <div class="filter-dropdown">
                                        <i class="fas fa-filter me-2"></i>
                                        Filter by Status
                                    </div>
                                </div>
                                
                                @if($agenciesWithCarCount->count() > 0)
                                    <div class="agency-grid">
                                        @foreach($agenciesWithCarCount as $agency)
                                            <div class="agency-card">
                                                <div class="agency-name">
                                                    <i class="fas fa-building"></i>
                                                    {{ $agency->name }}
                                                </div>
                                                
                                                <div class="agency-details">
                                                    <div class="detail-row">
                                                        <span class="detail-label">Location:</span>
                                                        <span class="detail-value">{{ $agency->city }}, {{ $agency->country }}</span>
                                                    </div>
                                                    <div class="detail-row">
                                                        <span class="detail-label">Contact:</span>
                                                        <span class="detail-value">{{ $agency->email }}</span>
                                                    </div>
                                                     <div class="detail-row">
                                                        <span class="detail-label">Phone:</span>
                                                        <span class="detail-value">{{ $agency->phone }}</span>
                                                    </div>
                                             
                                                    <div class="detail-row">
                                                        <span class="detail-label">Status:</span>
                                                        <span class="detail-value">
                                                            <span class="badge bg-{{ $agency->is_active ? 'success' : 'danger' }}">
                                                                {{ $agency->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="detail-row">
                                                        <span class="detail-label">Vehicles:</span>
                                                        <span class="detail-value">{{ $agency->car_count  ?? 0 }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="agency-actions">
                                                    <a href="{{ route('admin.agencies.show', $agency->id) }}" class="btn btn-view btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                 
                                                    <form action="{{ route('admin.agencies.destroy', $agency->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-delete btn-sm">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-building"></i>
                                        <h4>No Agencies Found</h4>
                                        <p>There are currently no registered agencies. Click the button above to add a new one.</p>
                                       
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
                    <p class="mb-0">© 2025 AETHORIA Car Agency. All Rights Reserved.</p>
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
        
        // Agency card hover effect enhancement
        document.querySelectorAll('.agency-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.4)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>