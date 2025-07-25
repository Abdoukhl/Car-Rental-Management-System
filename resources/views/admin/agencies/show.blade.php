<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Details | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4F73FF;
            --primary-light: rgba(79, 115, 255, 0.1);
            --secondary: #ff6f61;
            --dark: #2a2d38;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f8fd 0%, #e8f0fe 100%);
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .agency-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(79, 115, 255, 0.15);
            border: none;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .agency-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(79, 115, 255, 0.25);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), #6a5acd);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.75rem;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .header-icon {
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .agency-avatar {
            width: 80px;
            height: 170px;
            border-radius: 20px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: absolute;
            top: -50px;
            right: 30px;
            z-index: 3;
        }

        .agency-avatar:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(79, 115, 255, 0.1);
            border-color: rgba(79, 115, 255, 0.3);
        }

        .info-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }

        .info-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .info-value a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .info-value a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .subscription-card {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 15px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .subscription-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, var(--primary-light) 0%, rgba(79, 115, 255, 0) 70%);
            border-radius: 50%;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .status-active {
            background-color: white;
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-warning {
            background-color: white;
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .progress-container {
            width: 100%;
            height: 10px;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 5px;
            transition: width 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                          rgba(255,255,255,0) 0%, 
                          rgba(255,255,255,0.8) 50%, 
                          rgba(255,255,255,0) 100%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 2rem;
            background-color: #f8fafc;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #6a5acd);
            border: none;
            font-weight: 500;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(79, 115, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(79, 115, 255, 0.4);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover::after {
            opacity: 1;
        }

        .stats-container {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-item {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(79, 115, 255, 0.1);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .floating-icons {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.1;
            z-index: 0;
        }

        .floating-icons i {
            font-size: 6rem;
            margin: 0.5rem;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .agency-avatar {
                width: 80px;
                height: 80px;
                top: -40px;
                right: 20px;
            }
            
            .stats-container {
                flex-direction: column;
            }
        }

        /* Animation classes */
        .animate-delay-1 {
            animation-delay: 0.1s;
        }
        .animate-delay-2 {
            animation-delay: 0.2s;
        }
        .animate-delay-3 {
            animation-delay: 0.3s;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="agency-card mx-auto animate__animated animate__fadeInUp" style="max-width: 900px;">
            <div class="card-header">
                <div class="floating-icons">
                    <i class="fas fa-circle"></i>
                    <i class="fas fa-square"></i>
                    <i class="fas fa-building"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="header-title mb-0">
                        <div class="header-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <span>Agency Profile</span>
                    </h2>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agency->name) }}&background=4F73FF&color=fff&size=200" 
                         alt="Agency Logo" class="agency-avatar animate__animated animate__zoomIn">
                </div>
            </div>

            <div class="card-body p-0">
                <div class="info-grid">
                    <div class="info-card animate__animated animate__fadeIn animate-delay-1">
                        <div class="info-label">
                            <i class="fas fa-city"></i> City
                        </div>
                        <div class="info-value">
                            {{ $agency->city }}
                        </div>
                    </div>

                    <div class="info-card animate__animated animate__fadeIn animate-delay-2">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </div>
                        <div class="info-value">
                            {{ $agency->address }}
                        </div>
                    </div>

                    <div class="info-card animate__animated animate__fadeIn animate-delay-1">
                        <div class="info-label">
                            <i class="fas fa-phone-alt"></i> Phone
                        </div>
                        <div class="info-value">
                            <a href="tel:{{ $agency->phone }}">{{ $agency->phone }}</a>
                        </div>
                    </div>

                    <div class="info-card animate__animated animate__fadeIn animate-delay-2">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i> Email
                        </div>
                        <div class="info-value">
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    </div>

                    <div class="subscription-card animate__animated animate__fadeIn">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i> Subscription Status
                        </div>
                        @php
                        $newDays = request('plan') === 'monthly' ? 30 : 365;
                        $totalDays = $remainingDays;
                        $percentage = min(100, ($totalDays / 365) * 100);
                    
                        $days = floor($totalDays);
                        $hours = floor(($totalDays - $days) * 24);
                        $formattedRemaining = "$days days and $hours hours";
                    @endphp
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="status-badge {{ $totalDays > 60 ? 'status-active' : 'status-warning' }} animate__animated animate__pulse animate__infinite">
                            <i class="fas {{ $totalDays > 60 ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                            {{ $formattedRemaining }} remaining
                        </span>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                    </div>
                    
                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-value">{{ $agency->car_count ?? 0 }}</div>
                            <div class="stat-label">Total Cars</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $formattedRemaining }}</div>
                            <div class="stat-label">Time Left</div>
                        </div>
                    </div>
                    
                <div class="action-buttons">
                    <a href="{{ route('admin.agencies.index') }}" class="btn btn-primary animate__animated animate__fadeInUp">
                        <i class="fas fa-arrow-left me-2"></i> Back to Agencies
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add hover effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.info-card, .stat-item');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Animate progress bar on load
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                setTimeout(() => {
                    progressBar.style.transition = 'width 1.5s ease';
                }, 500);
            }
        });
    </script>
</body>
</html>