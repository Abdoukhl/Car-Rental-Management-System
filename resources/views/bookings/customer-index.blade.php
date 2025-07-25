@extends('car.layout')

@section('content')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary: #6e8efb;
        --primary-dark: #4a6cf7;
        --secondary: #ff6b6b;
        --dark: #1a1835;
        --light: #f8f9fa;
        --gradient: linear-gradient(135deg, var(--primary), var(--primary-dark));
        --card-bg: rgba(42, 42, 64, 0.8);
        --gold: #FFC107;
        --gold-dark: #E0A800;
        --text-primary: #ffffff;
        --text-secondary: rgba(255, 255, 255, 0.8);
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: var(--dark);
        color: var(--text-primary);
        min-height: 100vh;
        overflow-x: hidden;
        line-height: 1.6;
    }
    
    /* Particle Background */
    #particles-js {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        pointer-events: none;
    }
    
    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    /* Hero Section */
    .hero-section {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        padding: 3rem 1rem;
        background: rgba(42, 42, 64, 0.6);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(110, 142, 251, 0.2);
        background-image: linear-gradient(135deg, rgba(110, 142, 251, 0.1), rgba(74, 108, 247, 0.1));
    }
    
    .hero-title {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        color: var(--text-secondary);
        font-weight: 300;
        max-width: 700px;
        margin: 0 auto;
    }
    
    /* Booking Card */
    .booking-card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 1.8rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gold);
        transition: all 0.3s ease;
    }
    
    .booking-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        border-color: rgba(110, 142, 251, 0.3);
    }
    
    .booking-card:hover::before {
        width: 6px;
        background: linear-gradient(to bottom, var(--gold), var(--gold-dark));
    }
    
    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .booking-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
    .booking-id {
        font-weight: 700;
        color: var(--primary);
    }
    
    .booking-status {
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: var(--gold);
        border: 1px solid rgba(255, 193, 7, 0.4);
    }
    
    .status-confirmed {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.4);
    }
    
    .status-cancelled {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.4);
    }
    
    .status-completed {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.4);
    }
    
    .status-pending-payment {
        background: rgba(13, 110, 253, 0.2);
        color: #0d6efd;
        border: 1px solid rgba(13, 110, 253, 0.4);
    }
    
    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .detail-icon {
        color: var(--gold);
        font-size: 1.2rem;
        margin-top: 0.2rem;
    }
    
    .detail-content {
        flex: 1;
    }
    
    .detail-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
    }
    
    .detail-value {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 1.05rem;
    }
    
    .detail-value.highlight {
        color: var(--gold);
        font-weight: 600;
    }
    
    .booking-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .btn {
        border: none;
        border-radius: 8px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        min-width: 120px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #1a1a2e;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        background: linear-gradient(135deg, var(--gold-dark), var(--gold));
    }
    
    .btn-secondary {
        background: rgba(110, 142, 251, 0.2);
        color: white;
        border: 1px solid rgba(110, 142, 251, 0.5);
    }
    
    .btn-secondary:hover {
        background: rgba(110, 142, 251, 0.4);
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(110, 142, 251, 0.2);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }
    
    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #218838, #28a745);
    }

    .btn-print {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }
    
    .btn-print:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        background: linear-gradient(135deg, #138496, #17a2b8);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
    
    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        background: linear-gradient(135deg, #c82333, #dc3545);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem;
        background: var(--card-bg);
        border-radius: 15px;
        backdrop-filter: blur(5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.1);
        margin: 2rem 0;
    }
    
    .empty-icon {
        font-size: 5rem;
        color: var(--gold);
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }
    
    .empty-title {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        color: var(--gold);
    }
    
    .empty-text {
        font-size: 1.1rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }
    
    .page-item .page-link {
        background: var(--card-bg);
        color: var(--text-primary);
        border: 1px solid rgba(110, 142, 251, 0.2);
        margin: 0 0.3rem;
        border-radius: 8px;
        padding: 0.6rem 1.1rem;
        transition: all 0.3s ease;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #1a1a2e;
        border-color: var(--gold);
        font-weight: 600;
    }
    
    .page-item:not(.active) .page-link:hover {
        background: rgba(110, 142, 251, 0.3);
        border-color: rgba(110, 142, 251, 0.5);
    }
    
    /* Progress Bar */
    .booking-progress {
        margin: 1.5rem 0;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 1rem;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }
    
    .progress-bar {
        position: absolute;
        top: 50%;
        left: 0;
        height: 2px;
        background: var(--gold);
        z-index: 2;
        transition: width 0.3s ease;
    }
    
    .step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .step.active .step-icon {
        background: var(--gold);
        color: #1a1a2e;
        border-color: var(--gold-dark);
        box-shadow: 0 0 0 5px rgba(255, 193, 7, 0.3);
    }
    
    .step.completed .step-icon {
        background: var(--gold-dark);
        color: #1a1a2e;
    }
    
    .step-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-align: center;
        opacity: 0.8;
    }
    
    .step.active .step-label,
    .step.completed .step-label {
        color: var(--gold);
        opacity: 1;
        font-weight: 500;
    }
    
    /* Enhanced Receipt Styles */
    .receipt-container {
        background: white;
        color: #333;
        border-radius: 10px;
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .receipt-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #4a6cf7;
    }

    .receipt-logo {
        height: 80px;
        margin-right: 2rem;
        border-radius: 8px;
    }

    .receipt-company-info h1 {
        margin: 0 0 5px 0;
        font-size: 24px;
        color: #2c3e50;
    }

    .receipt-company-address {
        color: #666;
        margin-bottom: 5px;
    }

    .receipt-company-contacts {
        display: flex;
        gap: 1rem;
        color: #555;
        font-size: 0.9rem;
    }

    .receipt-title-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .receipt-title-section h2 {
        margin: 0 0 10px 0;
        font-size: 20px;
        text-transform: uppercase;
        color: #4a6cf7;
    }

    .receipt-number {
        padding: 5px 20px;
        background: #4a6cf7;
        color: white;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }

    .receipt-meta-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .receipt-meta-item {
        display: flex;
        flex-direction: column;
    }

    .receipt-meta-label {
        font-weight: 600;
        color: #555;
        font-size: 0.9rem;
    }

    .receipt-meta-value {
        font-weight: 500;
    }

    .receipt-status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .receipt-status-badge.pending {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .receipt-status-badge.confirmed {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }

    .receipt-status-badge.completed {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
    }

    .receipt-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .receipt-info-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.2rem;
        background: #f9f9f9;
    }

    .receipt-info-card h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .receipt-info-content p {
        margin: 0 0 8px 0;
    }

    .receipt-info-content p strong {
        font-weight: 600;
    }

    .receipt-vehicle-section {
        margin-bottom: 2rem;
    }

    .receipt-vehicle-section h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .receipt-vehicle-details {
        display: flex;
        gap: 1.5rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.2rem;
        background: #f9f9f9;
    }

    .receipt-vehicle-image {
        width: 200px;
        height: 120px;
        flex-shrink: 0;
    }

    .receipt-vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .receipt-vehicle-specs {
        flex: 1;
    }

    .receipt-spec-row {
        display: flex;
        margin-bottom: 8px;
    }

    .receipt-spec-label {
        font-weight: 600;
        width: 120px;
        color: #555;
    }

    .receipt-spec-value {
        flex: 1;
    }

    .receipt-rental-period {
        margin-bottom: 2rem;
    }

    .receipt-rental-period h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .receipt-period-dates {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.2rem;
        background: #f9f9f9;
    }

    .receipt-date-card {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        width: 40%;
    }

    .receipt-date-card.pickup {
        background: #e3f2fd;
    }

    .receipt-date-card.return {
        background: #e8f5e9;
    }

    .receipt-date-icon {
        margin-right: 10px;
        font-size: 1.5rem;
        color: #4a6cf7;
    }

    .receipt-date-details h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #555;
    }

    .receipt-date-details p {
        margin: 0;
        font-weight: 500;
    }

    .receipt-duration {
        font-weight: 700;
        color: #4a6cf7;
        padding: 5px 15px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .receipt-delivery-info {
        margin-bottom: 2rem;
    }

    .receipt-delivery-info h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .receipt-payment-summary {
        margin-bottom: 2rem;
    }

    .receipt-payment-summary h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .receipt-payment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .receipt-payment-table td {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .receipt-total-row td {
        font-weight: 700;
        border-top: 2px solid #333;
        border-bottom: none;
    }

    .receipt-footer {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 2px solid #4a6cf7;
    }

    .receipt-terms {
        margin-bottom: 2rem;
    }

    .receipt-terms h4 {
        margin: 0 0 10px 0;
        color: #4a6cf7;
    }

    .receipt-terms ol {
        padding-left: 20px;
        margin: 0;
        color: #555;
    }

    .receipt-terms li {
        margin-bottom: 5px;
    }

    .receipt-signature {
        text-align: right;
        margin-top: 2rem;
    }

    .receipt-signature-line {
        width: 200px;
        height: 1px;
        background: #333;
        margin-left: auto;
        margin-bottom: 5px;
    }

    .receipt-footer-meta {
        text-align: center;
        color: #777;
        font-size: 0.9rem;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.4rem;
        }
        
        .booking-details {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .main-container {
            padding: 1.5rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-section {
            padding: 2rem 1rem;
        }
        
        .booking-details {
            grid-template-columns: 1fr 1fr;
        }
        
        .booking-actions {
            flex-wrap: wrap;
        }
        
        .btn {
            flex: 1;
            min-width: auto;
        }

        .receipt-info-grid {
            grid-template-columns: 1fr;
        }

        .receipt-vehicle-details {
            flex-direction: column;
        }

        .receipt-vehicle-image {
            width: 100%;
            height: auto;
        }

        .receipt-period-dates {
            flex-direction: column;
            gap: 1rem;
        }

        .receipt-date-card {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .booking-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .booking-details {
            grid-template-columns: 1fr;
        }
        
        .empty-state {
            padding: 2rem 1rem;
        }
        
        .empty-title {
            font-size: 1.5rem;
        }
        
        .empty-text {
            font-size: 1rem;
        }
    }
</style>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <h1 class="hero-title"><i class="fas fa-calendar-check me-2"></i>My Bookings</h1>
        <p class="hero-subtitle">View and manage all your car rental bookings</p>
    </section>
    
    @if($bookings->isEmpty())
    <div class="empty-state animate__animated animate__fadeIn">
        <div class="empty-icon">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3 class="empty-title">No Bookings Yet</h3>
        <p class="empty-text">You haven't made any bookings yet. Start by browsing our available cars.</p>
        <a href="{{ route('customer.carlist') }}" class="btn btn-primary px-4">
            <i class="fas fa-car me-2"></i>Browse Cars
        </a>
    </div>
    @else
    <div class="row">
        @foreach($bookings as $booking)
        <div class="col-lg-6 animate__animated animate__fadeInUp">
            <div class="booking-card">
                <div class="booking-header">
                    <h3 class="booking-title">
                        <span class="booking-id">#{{ $booking->id }}</span>
                        {{ $booking->car->brand }} {{ $booking->car->model }}
                    </h3>
                    <span class="booking-status status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                        {{ $booking->status }}
                    </span>
                </div>
                
                <!-- Booking Progress -->
                <div class="booking-progress">
                    <div class="progress-steps">
                        <div class="progress-bar" style="width: 
                            @if($booking->status == 'Pending Payment') 0%
                            @elseif($booking->status == 'Pending Approval') 33%
                            @elseif($booking->status == 'Confirmed') 66%
                            @elseif($booking->status == 'Completed') 100%
                            @else 0%
                            @endif">
                        </div>
                        
                        <div class="step @if(in_array($booking->status, ['Pending Payment', 'Pending Approval', 'Confirmed', 'Completed'])) active @endif">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="step-label">Booking</span>
                        </div>
                        
                        <div class="step @if(in_array($booking->status, ['Pending Approval', 'Confirmed', 'Completed'])) active @endif">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="step-label">Approval</span>
                        </div>
                        
                        <div class="step @if(in_array($booking->status, ['Confirmed', 'Completed'])) active @endif">
                            <div class="step-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <span class="step-label">Delivery</span>
                        </div>
                        
                        <div class="step @if($booking->status == 'Completed') active @endif">
                            <div class="step-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <span class="step-label">Completion</span>
                        </div>
                    </div>
                </div>
                
                <div class="booking-details">
                    <div class="detail-item">
                        <i class="fas fa-building detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">Agency</div>
                            <div class="detail-value">{{ $booking->car->agency->name }}</div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">City</div>
                            <div class="detail-value">{{ $booking->car->agency->city }}</div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-calendar-day detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">Dates</div>
                            <div class="detail-value">
                                {{ $booking->start_date->format('Y/m/d') }} - {{ $booking->end_date->format('Y/m/d') }}
                                <br>
                                <small>({{ $booking->start_date->diffInDays($booking->end_date) }} days)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-money-bill-wave detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">Total Amount</div>
                            <div class="detail-value highlight">{{ number_format($booking->total_amount, 2) }} DZD</div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-car detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">Fuel Type</div>
                            <div class="detail-value">
                                {{ ucfirst($booking->car->fuel_type) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-tachometer-alt detail-icon"></i>
                        <div class="detail-content">
                            <div class="detail-label">Car Status</div>
                            <div class="detail-value">
                                {{ ucfirst($booking->car->status) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="booking-actions">
                    <a href="{{ route('bookings.customer-show', $booking->id) }}" class="btn btn-secondary">
                        <i class="fas fa-eye me-1"></i> Details
                    </a>
                    
                    @if($booking->status === 'Pending Payment')
                    <a href="{{ route('bookings.payment', $booking->id) }}" class="btn btn-success">
                        <i class="fas fa-credit-card me-1"></i> Pay Now
                    </a>
                    
                    <button type="button" class="btn btn-danger" onclick="cancelBooking({{ $booking->id }})">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    @endif
                    
                    @if($booking->status === 'Pending Approval')
                    <button type="button" class="btn btn-danger" onclick="cancelBooking({{ $booking->id }})">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    @endif
                    
                    @if($booking->status === 'Confirmed' && $booking->start_date > now())
                    <button type="button" class="btn btn-danger" onclick="cancelBooking({{ $booking->id }})">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    @endif
                    
                    @if($booking->status === 'Confirmed' && $booking->start_date <= now() && $booking->end_date >= now())
                    <a href="{{ route('bookings.delivery-options', $booking->id) }}" class="btn btn-primary">
                        <i class="fas fa-truck me-1"></i> Delivery
                    </a>
                    @endif
                    
                    @if($booking->status === 'Confirmed')
                    <button type="button" class="btn btn-print" onclick="showPrintReceipt({{ json_encode($booking) }}, {{ json_encode($booking->car) }}, {{ json_encode($booking->user) }}, {{ json_encode($booking->car->agency) }}, {{ json_encode($booking->car->images ?? []) }})">
                        <i class="fas fa-receipt me-1"></i> Receipt
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="pagination animate__animated animate__fadeIn">
        {{ $bookings->links() }}
    </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        // Initialize particles.js
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#6e8efb" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#6e8efb", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 3, direction: "none", random: true, straight: false, out_mode: "out" }
            },
            interactivity: {
                detect_on: "window",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
            }
        });
    });

    // Format date function
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    // Show printable receipt
    function showPrintReceipt(booking, car, user, agency, images) {
        // Format dates
        const startDate = formatDate(booking.start_date);
        const endDate = formatDate(booking.end_date);
        const createdAt = formatDate(booking.created_at);
        
        // Format currency
        const totalAmount = parseFloat(booking.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        const dailyRate = parseFloat(car.daily_rate).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        
        // Calculate duration
        const duration = Math.round((new Date(booking.end_date) - new Date(booking.start_date)) / (1000 * 60 * 60 * 24));
        
        // Create receipt HTML
        const receiptHTML = `
            <div class="receipt-container">
                <!-- Header -->
                <div class="receipt-header">
                    <img src="{{ asset('images/demo/gallery/q.jpg') }}" alt="Company Logo" class="receipt-logo">
                    <div class="receipt-company-info">
                        <h1>AETHORIA RENTAL</h1>
                        <p class="receipt-company-address">123 Business Avenue, Algiers, Algeria</p>
                        <div class="receipt-company-contacts">
                            <span><i class="fas fa-phone"></i> +213 123 456 789</span>
                            <span><i class="fas fa-envelope"></i> contact@aethoria.dz</span>
                            <span><i class="fas fa-globe"></i> www.aethoria.dz</span>
                        </div>
                    </div>
                </div>

                <!-- Invoice Title -->
                <div class="receipt-title-section">
                    <h2>RENTAL RECEIPT</h2>
                    <div class="receipt-number">
                        REC-${String(booking.id).padStart(6, '0')}
                    </div>
                </div>

                <!-- Invoice Meta -->
                <div class="receipt-meta-info">
                    <div class="receipt-meta-item">
                        <span class="receipt-meta-label">Issued Date:</span>
                        <span class="receipt-meta-value">${createdAt}</span>
                    </div>
                    <div class="receipt-meta-item">
                        <span class="receipt-meta-label">Rental Status:</span>
                        <span class="receipt-status-badge ${booking.status.toLowerCase()}">${booking.status}</span>
                    </div>
                </div>

                <!-- Client and Agency Info -->
                <div class="receipt-info-grid">
                    <div class="receipt-info-card client">
                        <h3><i class="fas fa-user-tie"></i> CLIENT INFORMATION</h3>
                        <div class="receipt-info-content">
                            <p><strong>Name:</strong> ${user.name}</p>
                            <p><strong>Email:</strong> ${user.email}</p>
                            <p><strong>Phone:</strong> ${booking.delivery_phone || 'N/A'}</p>
                        </div>
                    </div>
                    
                    <div class="receipt-info-card agency">
                        <h3><i class="fas fa-building"></i> AGENCY INFORMATION</h3>
                        <div class="receipt-info-content">
                            <p><strong>Agency:</strong> ${agency.name_agency}</p>
                            <p><strong>Address:</strong> ${agency.address}</p>
                            <p><strong>Contact:</strong> ${agency.phone}</p>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Details -->
                <div class="receipt-vehicle-section">
                    <h3><i class="fas fa-car"></i> VEHICLE DETAILS</h3>
                    <div class="receipt-vehicle-details">
                        <div class="receipt-vehicle-image">
                            ${images.length > 0 ? 
                                `<img src="/storage/${images[0].image_path}" alt="${car.brand} ${car.model}">` : 
                                `<div style="background:#eee;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#777;">
                                    <i class="fas fa-car" style="font-size:2rem;margin-bottom:10px;"></i>
                                    <span>No Image Available</span>
                                </div>`
                            }
                        </div>
                        <div class="receipt-vehicle-specs">
                            <div class="receipt-spec-row">
                                <span class="receipt-spec-label">Brand/Model:</span>
                                <span class="receipt-spec-value">${car.brand} ${car.model}</span>
                            </div>
                            <div class="receipt-spec-row">
                                <span class="receipt-spec-label">Year:</span>
                                <span class="receipt-spec-value">${car.year}</span>
                            </div>
                            <div class="receipt-spec-row">
                                <span class="receipt-spec-label">Type:</span>
                                <span class="receipt-spec-value">${car.type}</span>
                            </div>
                            <div class="receipt-spec-row">
                                <span class="receipt-spec-label">Fuel Type:</span>
                                <span class="receipt-spec-value">${car.fuel_type}</span>
                            </div>
                            <div class="receipt-spec-row">
                                <span class="receipt-spec-label">Daily Rate:</span>
                                <span class="receipt-spec-value">${dailyRate} DZD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Period -->
                <div class="receipt-rental-period">
                    <h3><i class="fas fa-calendar-alt"></i> RENTAL PERIOD</h3>
                    <div class="receipt-period-dates">
                        <div class="receipt-date-card pickup">
                            <div class="receipt-date-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="receipt-date-details">
                                <h4>PICKUP DATE</h4>
                                <p>${startDate}</p>
                            </div>
                        </div>
                        
                        <div class="receipt-duration">
                            ${duration} DAYS
                        </div>
                        
                        <div class="receipt-date-card return">
                            <div class="receipt-date-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="receipt-date-details">
                                <h4>RETURN DATE</h4>
                                <p>${endDate}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="receipt-delivery-info">
                    <h3><i class="fas fa-truck"></i> DELIVERY INFORMATION</h3>
                    <div class="receipt-info-content">
                        <p><strong>Method:</strong> ${booking.delivery_method ? booking.delivery_method.charAt(0).toUpperCase() + booking.delivery_method.slice(1) : 'Pickup'}</p>
                        ${booking.delivery_method === 'delivery' ? 
                            `<p><strong>Address:</strong> ${booking.delivery_address}</p>
                            <p><strong>City:</strong> ${booking.delivery_state}</p>
                            <p><strong>Postal Code:</strong> ${booking.delivery_postal_code}</p>` : 
                            `<p><strong>Pickup Location:</strong> ${agency.address}</p>`
                        }
                        ${booking.delivery_notes ? 
                            `<p><strong>Special Instructions:</strong> ${booking.delivery_notes}</p>` : ''
                        }
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="receipt-payment-summary">
                    <h3><i class="fas fa-receipt"></i> PAYMENT SUMMARY</h3>
                    <table class="receipt-payment-table">
                        <tr>
                            <td>Subtotal:</td>
                            <td>${totalAmount} DZD</td>
                        </tr>
                        <tr>
                            <td>Delivery Fee:</td>
                            <td>0.00 DZD</td>
                        </tr>
                        <tr class="receipt-total-row">
                            <td>Total Amount:</td>
                            <td>${totalAmount} DZD</td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div class="receipt-footer">
                    <div class="receipt-terms">
                        <h4>TERMS & CONDITIONS</h4>
                        <ol>
                            <li>Payment is due upon vehicle pickup/delivery</li>
                            <li>Cancellation must be made 24 hours prior to rental</li>
                            <li>Late returns will incur additional charges</li>
                            <li>Fuel policy: full-to-full</li>
                            <li>Any damages will be charged according to agency policy</li>
                        </ol>
                    </div>
                    
                    <div class="receipt-signature">
                        <div class="receipt-signature-line"></div>
                        <p>Authorized Signature</p>
                    </div>
                    
                    <div class="receipt-footer-meta">
                        <p>Receipt generated on ${formatDate(new Date())}</p>
                    </div>
                </div>
            </div>
        `;

        // Show receipt in SweetAlert
        Swal.fire({
            title: 'Rental Receipt',
            html: receiptHTML,
            width: '90%',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Close',
            confirmButtonText: 'Print',
            focusConfirm: false,
            scrollbarPadding: false,
            customClass: {
                popup: 'receipt-popup',
                content: 'receipt-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Open print window
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Rental Receipt #${booking.id}</title>
                        <style>
                            body { 
                                font-family: Arial, sans-serif; 
                                margin: 0; 
                                padding: 20px; 
                                color: #333; 
                                background: white;
                            }
                            .receipt-container {
                                max-width: 800px;
                                margin: 0 auto;
                                padding: 2rem;
                            }
                            .receipt-header {
                                display: flex;
                                align-items: center;
                                margin-bottom: 2rem;
                                padding-bottom: 1.5rem;
                                border-bottom: 2px solid #4a6cf7;
                            }
                            .receipt-logo {
                                height: 80px;
                                margin-right: 2rem;
                                border-radius: 8px;
                            }
                            .receipt-company-info h1 {
                                margin: 0 0 5px 0;
                                font-size: 24px;
                                color: #2c3e50;
                            }
                            .receipt-company-address {
                                color: #666;
                                margin-bottom: 5px;
                            }
                            .receipt-company-contacts {
                                display: flex;
                                gap: 1rem;
                                color: #555;
                                font-size: 0.9rem;
                            }
                            .receipt-title-section {
                                text-align: center;
                                margin-bottom: 2rem;
                            }
                            .receipt-title-section h2 {
                                margin: 0 0 10px 0;
                                font-size: 20px;
                                text-transform: uppercase;
                                color: #4a6cf7;
                            }
                            .receipt-number {
                                padding: 5px 20px;
                                background: #4a6cf7;
                                color: white;
                                border-radius: 20px;
                                font-weight: 600;
                                display: inline-block;
                            }
                            .receipt-meta-info {
                                display: flex;
                                justify-content: space-between;
                                margin-bottom: 2rem;
                            }
                            .receipt-meta-item {
                                display: flex;
                                flex-direction: column;
                            }
                            .receipt-meta-label {
                                font-weight: 600;
                                color: #555;
                                font-size: 0.9rem;
                            }
                            .receipt-meta-value {
                                font-weight: 500;
                            }
                            .receipt-status-badge {
                                padding: 5px 15px;
                                border-radius: 20px;
                                font-weight: 600;
                                font-size: 0.85rem;
                            }
                            .receipt-status-badge.pending {
                                background: rgba(255, 193, 7, 0.2);
                                color: #ffc107;
                            }
                            .receipt-status-badge.confirmed {
                                background: rgba(40, 167, 69, 0.2);
                                color: #28a745;
                            }
                            .receipt-status-badge.completed {
                                background: rgba(108, 117, 125, 0.2);
                                color: #6c757d;
                            }
                            .receipt-info-grid {
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                gap: 1.5rem;
                                margin-bottom: 2rem;
                            }
                            .receipt-info-card {
                                border: 1px solid #e0e0e0;
                                border-radius: 8px;
                                padding: 1.2rem;
                                background: #f9f9f9;
                            }
                            .receipt-info-card h3 {
                                margin: 0 0 15px 0;
                                font-size: 16px;
                                color: #4a6cf7;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }
                            .receipt-info-content p {
                                margin: 0 0 8px 0;
                            }
                            .receipt-info-content p strong {
                                font-weight: 600;
                            }
                            .receipt-vehicle-section {
                                margin-bottom: 2rem;
                            }
                            .receipt-vehicle-section h3 {
                                margin: 0 0 15px 0;
                                font-size: 16px;
                                color: #4a6cf7;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }
                            .receipt-vehicle-details {
                                display: flex;
                                gap: 1.5rem;
                                border: 1px solid #e0e0e0;
                                border-radius: 8px;
                                padding: 1.2rem;
                                background: #f9f9f9;
                            }
                            .receipt-vehicle-image {
                                width: 200px;
                                height: 120px;
                                flex-shrink: 0;
                            }
                            .receipt-vehicle-image img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 5px;
                            }
                            .receipt-vehicle-specs {
                                flex: 1;
                            }
                            .receipt-spec-row {
                                display: flex;
                                margin-bottom: 8px;
                            }
                            .receipt-spec-label {
                                font-weight: 600;
                                width: 120px;
                                color: #555;
                            }
                            .receipt-spec-value {
                                flex: 1;
                            }
                            .receipt-rental-period {
                                margin-bottom: 2rem;
                            }
                            .receipt-rental-period h3 {
                                margin: 0 0 15px 0;
                                font-size: 16px;
                                color: #4a6cf7;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }
                            .receipt-period-dates {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                border: 1px solid #e0e0e0;
                                border-radius: 8px;
                                padding: 1.2rem;
                                background: #f9f9f9;
                            }
                            .receipt-date-card {
                                display: flex;
                                align-items: center;
                                padding: 10px;
                                border-radius: 5px;
                                width: 40%;
                            }
                            .receipt-date-card.pickup {
                                background: #e3f2fd;
                            }
                            .receipt-date-card.return {
                                background: #e8f5e9;
                            }
                            .receipt-date-icon {
                                margin-right: 10px;
                                font-size: 1.5rem;
                                color: #4a6cf7;
                            }
                            .receipt-date-details h4 {
                                margin: 0 0 5px 0;
                                font-size: 14px;
                                color: #555;
                            }
                            .receipt-date-details p {
                                margin: 0;
                                font-weight: 500;
                            }
                            .receipt-duration {
                                font-weight: 700;
                                color: #4a6cf7;
                                padding: 5px 15px;
                                background: white;
                                border-radius: 20px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            }
                            .receipt-delivery-info {
                                margin-bottom: 2rem;
                            }
                            .receipt-delivery-info h3 {
                                margin: 0 0 15px 0;
                                font-size: 16px;
                                color: #4a6cf7;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }
                            .receipt-payment-summary {
                                margin-bottom: 2rem;
                            }
                            .receipt-payment-summary h3 {
                                margin: 0 0 15px 0;
                                font-size: 16px;
                                color: #4a6cf7;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }
                            .receipt-payment-table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            .receipt-payment-table td {
                                padding: 10px 0;
                                border-bottom: 1px solid #eee;
                            }
                            .receipt-total-row td {
                                font-weight: 700;
                                border-top: 2px solid #333;
                                border-bottom: none;
                            }
                            .receipt-footer {
                                margin-top: 3rem;
                                padding-top: 1.5rem;
                                border-top: 2px solid #4a6cf7;
                            }
                            .receipt-terms {
                                margin-bottom: 2rem;
                            }
                            .receipt-terms h4 {
                                margin: 0 0 10px 0;
                                color: #4a6cf7;
                            }
                            .receipt-terms ol {
                                padding-left: 20px;
                                margin: 0;
                                color: #555;
                            }
                            .receipt-terms li {
                                margin-bottom: 5px;
                            }
                            .receipt-signature {
                                text-align: right;
                                margin-top: 2rem;
                            }
                            .receipt-signature-line {
                                width: 200px;
                                height: 1px;
                                background: #333;
                                margin-left: auto;
                                margin-bottom: 5px;
                            }
                            .receipt-footer-meta {
                                text-align: center;
                                color: #777;
                                font-size: 0.9rem;
                                margin-top: 2rem;
                            }
                            @media print {
                                body { padding: 0; }
                                .receipt-container { box-shadow: none; }
                            }
                        </style>
                    </head>
                    <body>
                        ${receiptHTML}
                        <script>
                            window.onload = function() { 
                                window.print(); 
                                setTimeout(function() { window.close(); }, 1000);
                            }
                        <\/script>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            }
        });
    }
 // Cancel booking function
 function cancelBooking(bookingId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! The car will become available again.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel booking!',
            cancelButtonText: 'Go back'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to cancel booking
                $.ajax({
                    url: `/bookings/${bookingId}/cancel`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the page to reflect changes
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while trying to cancel the booking.',
                            'error'
                        );
                    }
                });
            }
        });
    }
   
</script>
@endsection