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
        display: flex;
        flex-direction: column;
        justify-content: center;
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
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
    }
    
    /* Hero Section */
    .hero-section {
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        padding: 1.5rem;
        background: rgba(42, 42, 64, 0.6);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(110, 142, 251, 0.2);
        max-width: 600px;
        width: 100%;
    }
    
    .hero-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1rem;
        color: var(--text-secondary);
        font-weight: 300;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Car Details Card */
    .car-card {
        background: var(--card-bg);
        border-radius: 15px;
        overflow: hidden;
        margin: 0 auto;
        max-width: 500px;
        width: 100%;
        backdrop-filter: blur(5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        border-color: rgba(110, 142, 251, 0.3);
    }
    
    .car-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.5s ease;
    }
    
    .car-card:hover .car-image {
        transform: scale(1.03);
    }
    
    .car-body {
        padding: 1.5rem;
    }
    
    .car-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gold);
        margin-bottom: 1rem;
        text-align: center;
        position: relative;
    }
    
    .car-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-dark));
        margin: 0.5rem auto 0;
        border-radius: 3px;
    }
    
    .car-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .detail-item:hover {
        background: rgba(110, 142, 251, 0.1);
    }
    
    .detail-icon {
        color: var(--gold);
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }
    
    .detail-label {
        color: var(--text-secondary);
        font-weight: 400;
        font-size: 0.9rem;
    }
    
    .detail-value {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .daily-rate {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gold);
        margin: 1.5rem 0;
        text-align: center;
        background: rgba(255, 193, 7, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }
    
    /* Features Section */
    .features-section {
        margin: 1.5rem 0;
    }
    
    .features-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .features-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .feature-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.4rem 0.8rem;
        background: rgba(110, 142, 251, 0.1);
        border-radius: 20px;
        font-size: 0.8rem;
        border: 1px solid rgba(110, 142, 251, 0.3);
    }
    
    .feature-badge.active {
        background: rgba(255, 193, 7, 0.1);
        border-color: rgba(255, 193, 7, 0.3);
        color: var(--gold);
    }
    
    .feature-icon {
        font-size: 0.8rem;
    }
    
    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .btn {
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #1a1a2e;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
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

    /* Badge for eco-friendly cars */
    .eco-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        z-index: 1;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Agency Info Section */
    .agency-section {
        background: rgba(26, 24, 53, 0.7);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.5rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
    }

    .agency-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .agency-info {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .agency-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .agency-icon {
        color: var(--gold);
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }

    .agency-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .agency-value {
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-container {
            padding: 1.5rem;
        }
        
        .hero-title {
            font-size: 1.75rem;
        }
        
        .car-details {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.5rem;
        }
        
        .car-image {
            height: 200px;
        }
        
        .btn-group {
            flex-direction: column;
        }
    }
</style>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <h1 class="hero-title">{{ $car->brand }} {{ $car->model }}</h1>
        <p class="hero-subtitle">Experience premium driving with this exceptional vehicle</p>
    </section>
    
    <!-- Car Details Card -->
    <div class="car-card animate__animated animate__fadeInUp">
        @if($car->eco_friendly)
            <div class="eco-badge">
                <i class="fas fa-leaf"></i> Eco-Friendly
            </div>
        @endif
        
        <img src="{{ asset('images/' . $car->picture) }}" alt="{{ $car->model }}" class="car-image">
        
        <div class="car-body">
            <h2 class="car-title">{{ $car->brand }} {{ $car->model }}</h2>
            
            <div class="car-details">
                <div class="detail-item">
                    <i class="fas fa-gas-pump detail-icon"></i>
                    <div>
                        <div class="detail-label">Fuel Type</div>
                        <div class="detail-value">{{ ucfirst($car->fuel_type) }}</div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <i class="fas fa-info-circle detail-icon"></i>
                    <div>
                        <div class="detail-label">Status</div>
                        <div class="detail-value">{{ ucfirst($car->status) }}</div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <i class="fas fa-users detail-icon"></i>
                    <div>
                        <div class="detail-label">Family Friendly</div>
                        <div class="detail-value">{{ $car->family_friendly ? 'Yes' : 'No' }}</div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <i class="fas fa-chair detail-icon"></i>



                    <div>
                        <div class="detail-label">Seats</div>
                        <div class="detail-value">{{ $car->seats }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="features-section">
                <h3 class="features-title">
                    <i class="fas fa-star"></i> Features
                </h3>
                <div class="features-list">
                    <span class="feature-badge {{ $car->child_seat ? 'active' : '' }}">
                        <i class="fas fa-baby-carriage feature-icon"></i> Child Seat
                    </span>
                    <span class="feature-badge {{ $car->air_conditioning ? 'active' : '' }}">
                        <i class="fas fa-snowflake feature-icon"></i> Air Conditioning
                    </span>
                    <span class="feature-badge {{ $car->eco_friendly ? 'active' : '' }}">
                        <i class="fas fa-leaf feature-icon"></i> Eco Friendly
                    </span>
                </div>
            </div>
            
            <div class="daily-rate">
                {{ number_format($car->daily_rate, 2) }} DZD / day
            </div>

            <!-- Agency Information Section -->
            @if($car->agency)
            <div class="agency-section">
                <h3 class="agency-title">
                    <i class="fas fa-building"></i> Agency Information
                </h3>
                <div class="agency-info">
                    <div class="agency-item">
                        <i class="fas fa-store agency-icon"></i>
                        <div>
                            <div class="agency-label">Agency Name</div>
                            <div class="agency-value">{{ $car->agency->name }}</div>
                        </div>
                    </div>
                    <div class="agency-item">
                        <i class="fas fa-phone agency-icon"></i>
                        <div>
                            <div class="agency-label">Phone</div>
                            <div class="agency-value">{{ $car->agency->phone }}</div>
                        </div>
                    </div>
                    <div class="agency-item">
                        <i class="fas fa-envelope agency-icon"></i>
                        <div>
                            <div class="agency-label">Email</div>
                            <div class="agency-value">{{ $car->agency->user->email }}</div>
                        </div>
                    </div>
                    <div class="agency-item">
                        <i class="fas fa-map-marker-alt agency-icon"></i>
                        <div>
                            <div class="agency-label">Location</div>
                            <div class="agency-value">{{ $car->agency->city }}, {{ $car->agency->address }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="btn-group">
                @if(auth()->user()->account_type === 'agency')
                    <a href="{{ route('car.edit', $car->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Car
                    </a>
                @else
                    <a href="{{ route('bookings.create', $car->id) }}" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </a>
                @endif
                
                <a href="{{ auth()->user()->account_type === 'agency' ? route('agency.dashboard') : route('customer.carlist') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
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

        // Add smooth hover effect to card
        $('.car-card').hover(
            function() {
                $(this).css('transform', 'translateY(-10px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
    });
</script>
@endsection