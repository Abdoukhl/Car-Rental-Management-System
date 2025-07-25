<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Documents - Ethoria Car Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #220a4a;
            --secondary-bg: #172a45;
            --accent-color: #64ffda;
            --text-primary: #e6f1ff;
            --text-secondary: #a8b2d1;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 90px;
            --top-nav-height: 70px;
            --transition-speed: 0.4s;
            --card-radius: 12px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--primary-bg);
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
            border-right: 1px solid rgba(100, 255, 218, 0.1);
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
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
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
            background: rgba(23, 42, 69, 0.8);
            backdrop-filter: blur(12px);
            padding: 0 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
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
            background: rgba(23, 42, 69, 0.6);
            border-radius: var(--card-radius);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(100, 255, 218, 0.1);
            margin-bottom: 25px;
            transition: all 0.4s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(100, 255, 218, 0.3);
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
        
        /* Document List Styles */
        .document-list {
            margin: 0;
            padding: 0;
        }
        
        .document-item {
            padding: 15px;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }
        
        .document-item:hover {
            background: rgba(100, 255, 218, 0.05);
        }
        
        .document-item:last-child {
            border-bottom: none;
        }
        
        .document-info {
            flex: 1;
            min-width: 250px;
            margin-bottom: 10px;
        }
        
        .document-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .document-meta-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .document-meta-label {
            color: var(--accent-color);
            font-weight: 500;
            min-width: 100px;
        }
        
        .document-meta-value {
            flex: 1;
            color: var(--text-primary);
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
        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .status-badge:before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .badge-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .badge-pending:before {
            background: #ffc107;
        }
        
        .badge-approved {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .badge-approved:before {
            background: #28a745;
        }
        
        .badge-rejected {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .badge-rejected:before {
            background: #dc3545;
        }
        
        /* Document Actions */
        .document-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        
       /* تحسين الأزرار */
.btn {
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.2s ease-in-out;
    border: none;
    padding: 8px 14px; /* تصغير الحجم */
    font-size: 0.85rem; /* تصغير الخط */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

/* تحسين الأيقونات */
.btn i {
    margin-right: 6px; /* تصغير المسافة */
    font-size: 0.9rem; /* تصغير حجم الأيقونة */
    transition: transform 0.2s ease-in-out;
}

/* تأثير عند التمرير */
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}

/* تحسين زر التحميل */
.btn-download {
    background: linear-gradient(135deg, #4ADE80, #16A34A);
    color: white;
    border: 1px solid rgba(22, 163, 74, 0.5);
}

.btn-download:hover {
    background: linear-gradient(135deg, #16A34A, #14532D);
}

/* تحسين زر الموافقة */
.btn-approve {
    background: linear-gradient(135deg, #FACC15, #EAB308);
    color: #18181B;
    border: 1px solid rgba(234, 179, 8, 0.5);
}

.btn-approve:hover {
    background: linear-gradient(135deg, #EAB308, #A16207);
}

/* تحسين زر الرفض */
.btn-reject {
    background: linear-gradient(135deg, #EF4444, #B91C1C);
    color: white;
    border: 1px solid rgba(185, 28, 28, 0.5);
}

.btn-reject:hover {
    background: linear-gradient(135deg, #B91C1C, #7F1D1D);
}

/* تأثير خفيف عند الضغط */
.btn:active {
    transform: scale(0.95);
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

        /* Rejection Form */
        .rejection-form {
            background: rgba(23, 42, 69, 0.8);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            display: none;
            width: 100%;
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .rejection-form.active {
            display: block;
        }
        
        .rejection-form .form-control {
            background: rgba(10, 25, 47, 0.5);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--text-primary);
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .rejection-form .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(100, 255, 218, 0.2);
            background: rgba(10, 25, 47, 0.7);
        }
        
        .rejection-form .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }
        
        .rejection-form .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .rejection-form .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Footer */
        .footer {
            background: rgba(23, 42, 69, 0.8);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(100, 255, 218, 0.1);
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
            .main-content {
                margin-left: 0;
            }
            
            .document-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .document-actions {
                width: 100%;
                margin-top: 10px;
                justify-content: flex-end;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
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
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.agencies.documents') }}" class="nav-link active">
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
                    <h4 class="page-title mb-0">Submitted Documents</h4>
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
                                <i class="fas fa-file me-2"></i>Submitted Documents
                            </div>
                            <div class="card-body">
                                @if($documents->count() > 0)
                                    <ul class="document-list">
                                        @foreach($documents as $document)
                                            <li class="document-item">
                                                <div class="document-info">
                                                    <div class="document-meta">
                                                        <div class="document-meta-row">
                                                            <span class="document-meta-label">Document:</span>
                                                            <span class="document-meta-value">{{ $document->document_name }}</span>
                                                        </div>
                                                        <div class="document-meta-row">
                                                            <span class="document-meta-label">Agency:</span>
                                                            <span class="document-meta-value">{{ $document->agency->name }}</span>
                                                        </div>
                                                        <div class="document-meta-row">
                                                            <span class="document-meta-label">Status:</span>
                                                            <span class="document-meta-value">
                                                                <span class="status-badge 
                                                                    @if($document->status === 'pending') badge-pending
                                                                    @elseif($document->status === 'approved') badge-approved
                                                                    @else badge-rejected @endif">
                                                                    {{ $document->status === 'pending' ? 'Pending Review' : 
                                                                       ($document->status === 'approved' ? 'Approved' : 'Rejected') }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                        @if($document->status === 'rejected' && $document->rejection_reason)
                                                        <div class="document-meta-row">
                                                            <span class="document-meta-label">Reason:</span>
                                                            <span class="document-meta-value text-danger">{{ $document->rejection_reason }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="document-actions">
                                                    <a href="{{ asset($document->document_path) }}?v={{ time() }}" 
                                                       target="_blank" 
                                                       class="btn btn-download">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                    
                                                    @if($document->status === 'pending' || $document->status === 'rejected')
                                                    <form action="{{ route('admin.documents.approve', $document->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-approve">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    @if($document->status === 'pending' || $document->status === 'approved')
                                                    <button class="btn btn-reject reject-btn" 
                                                            data-document-id="{{ $document->id }}">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                    @endif
                                                    
                                                    <div id="rejectForm-{{ $document->id }}" class="rejection-form">
                                                        <form action="{{ route('admin.documents.reject', $document->id) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <input type="text" name="rejection_reason" 
                                                                       class="form-control" 
                                                                       required
                                                                       placeholder="Enter rejection reason">
                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-reject">
                                                                    <i class="fas fa-paper-plane"></i> Submit
                                                                </button>
                                                                <button type="button" class="btn btn-secondary cancel-reject"
                                                                        data-document-id="{{ $document->id }}">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x mb-3" style="color: var(--text-secondary);"></i>
                                        <p class="mb-0">No documents submitted yet.</p>
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
        
        // Document rejection handling
        document.querySelectorAll('.reject-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const documentId = this.getAttribute('data-document-id');
                document.getElementById(`rejectForm-${documentId}`).classList.add('active');
            });
        });
        
        document.querySelectorAll('.cancel-reject').forEach(btn => {
            btn.addEventListener('click', function() {
                const documentId = this.getAttribute('data-document-id');
                document.getElementById(`rejectForm-${documentId}`).classList.remove('active');
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>