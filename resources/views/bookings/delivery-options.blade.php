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
    /* جميع أنماط CSS من الصفحة الأصلية */
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
    
    #particles-js {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        pointer-events: none;
    }
    
    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .hero-section {
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        padding: 2rem 1rem;
        background: rgba(42, 42, 64, 0.6);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(110, 142, 251, 0.2);
    }
    
    .hero-title {
        font-size: 2.5rem;
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
        font-size: 1.1rem;
        color: var(--text-secondary);
        font-weight: 300;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .booking-card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.1);
        transition: all 0.3s ease;
    }
    
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        border-color: rgba(110, 142, 251, 0.3);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-dark));
        border-radius: 3px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        border-radius: 8px;
        background: rgba(30, 30, 47, 0.5);
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: rgba(110, 142, 251, 0.1);
    }
    
    .info-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .info-value {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 1.05rem;
    }
    
    .delivery-options {
        margin-top: 2rem;
    }
    
    .delivery-option {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        background: rgba(30, 30, 47, 0.5);
        border: 1px solid rgba(110, 142, 251, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .delivery-option:hover {
        border-color: var(--gold);
    }
    
    .delivery-option.selected {
        background: rgba(110, 142, 251, 0.1);
        border-color: var(--gold);
    }
    
    .delivery-option input[type="radio"] {
        margin-right: 1rem;
    }
    
    .delivery-option-content {
        flex: 1;
    }
    
    .delivery-option-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .delivery-option-desc {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .agency-location {
        background: rgba(30, 30, 47, 0.5);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
    }
    
    .delivery-form {
        background: rgba(30, 30, 47, 0.5);
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
    }
    
    .form-label {
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        background: rgba(20, 20, 35, 0.8);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .form-control:focus {
        background: rgba(20, 20, 35, 0.9);
        color: var(--text-primary);
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn {
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex: 1;
        min-width: 200px;
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
    
    @media (max-width: 768px) {
        .main-container {
            padding: 1.5rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
    }
</style>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <h1 class="hero-title"><i class="fas fa-truck me-2"></i>Delivery Options</h1>
        <p class="hero-subtitle">Booking #{{ $booking->id }}</p>
    </section>
    
    <!-- Booking Card -->
    <div class="booking-card animate__animated animate__fadeInUp">
        <!-- Car Information Summary -->
        <h3 class="section-title"><i class="fas fa-car me-2"></i>Car Details</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Brand</span>
                <span class="info-value">{{ $booking->car->brand }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Model</span>
                <span class="info-value">{{ $booking->car->model }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Agency</span>
                <span class="info-value">{{ $booking->car->agency->name }}</span>
            </div>
        </div>
        
        <!-- Delivery Options Section -->
        <div class="delivery-options">
            <h3 class="section-title"><i class="fas fa-truck me-2"></i>Car Delivery Options</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="deliveryForm" action="{{ route('bookings.select-delivery', $booking->id) }}" method="POST">
                @csrf
                <p class="text-muted mb-3">Please select your preferred delivery method</p>
                
                <div class="delivery-option" onclick="selectOption('pickup')">
                    <input type="radio" id="pickup" name="delivery_method" value="pickup" required>
                    <div class="delivery-option-content">
                        <div class="delivery-option-title">Pick up from agency location</div>
                        <div class="delivery-option-desc">You will pick up the car from the agency's location</div>
                    </div>
                </div>
                
                <div class="delivery-option" onclick="selectOption('delivery')">
                    <input type="radio" id="delivery" name="delivery_method" value="delivery">
                    <div class="delivery-option-content">
                        <div class="delivery-option-title">Car delivery to my location</div>
                        <div class="delivery-option-desc">The car will be delivered to your specified address (additional fees may apply)</div>
                    </div>
                </div>
                
                <!-- Agency Location Info -->
                <div class="agency-location">
                    <h5><i class="fas fa-map-marker-alt me-2"></i>Agency Location</h5>
                    <p>{{ $booking->car->agency->address }}</p>
                    <div class="mt-2">
                        <a href="https://maps.google.com/?q={{ urlencode($booking->car->agency->address) }}" 
                           target="_blank" class="btn btn-secondary btn-sm">
                            <i class="fas fa-map-marked-alt me-1"></i> View on Map
                        </a>
                    </div>
                </div>
                
                <!-- Delivery Address Form (Hidden by default) -->
                <div class="delivery-form" id="deliveryAddressForm" style="display: none;">
                    <h5><i class="fas fa-map-marked-alt me-2"></i>Delivery Address</h5>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Full Address</label>
                        <input type="text" class="form-control" id="address" name="address" 
                               placeholder="Enter your full address" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" 
                                   placeholder="Enter your state" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                   placeholder="Enter Postal Code (5 digits)" pattern="\d{5}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="delivery_notes" name="delivery_notes" rows="3" 
                                  placeholder="Any special instructions for delivery"></textarea>
                    </div>
                </div>
                
                <!-- Phone Number Field (Required) -->
                <div class="delivery-form mt-3">
                    <h5><i class="fas fa-phone me-2"></i>Contact Number</h5>
                    <div class="mb-3">
                        <label for="delivery_phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="delivery_phone" name="delivery_phone" 
                               placeholder="Enter your phone number" required
                               pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number"
                               @if($booking->delivery_phone) value="{{ $booking->delivery_phone }}" @endif>
                        <small class="text-muted">We'll contact you on this number for delivery coordination</small>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('bookings.customer-show', $booking->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Booking
                    </a>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i> Confirm Delivery Method
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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

    function selectOption(method) {
        const pickupOption = document.getElementById('pickup');
        const deliveryOption = document.getElementById('delivery');
        const deliveryForm = document.getElementById('deliveryAddressForm');
        
        if (method === 'pickup') {
            pickupOption.checked = true;
            deliveryForm.style.display = 'none';
        } else {
            deliveryOption.checked = true;
            deliveryForm.style.display = 'block';
        }
        
        // Add visual feedback for selection
        document.querySelectorAll('.delivery-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        if (method === 'pickup') {
            document.querySelector('label[for="pickup"]').parentElement.classList.add('selected');
        } else {
            document.querySelector('label[for="delivery"]').parentElement.classList.add('selected');
        }
    }
    
    // Form validation before submission
    document.getElementById('deliveryForm').addEventListener('submit', function(e) {
        const method = document.querySelector('input[name="delivery_method"]:checked').value;
        const phone = document.getElementById('delivery_phone').value;
        
        // Validate phone number
        if (!phone || !/^\d{10}$/.test(phone)) {
            e.preventDefault();
            Swal.fire({
                title: 'Error',
                text: 'Please enter a valid 10-digit phone number',
                icon: 'error'
            });
            return false;
        }
        
        if (method === 'delivery') {
            const address = document.getElementById('address').value;
            const state = document.getElementById('state').value;
            const postalCode = document.getElementById('postal_code').value;
            
            if (!address || !state || !postalCode) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error',
                    text: 'Please fill all required fields for delivery',
                    icon: 'error'
                });
                return false;
            }
        }
        return true;
    });

    // Initialize form
    document.addEventListener('DOMContentLoaded', function() {
        const pickupOption = document.getElementById('pickup');
        if (pickupOption) {
            pickupOption.checked = true;
            document.querySelector('label[for="pickup"]').parentElement.classList.add('selected');
        }
    });
</script>
@endsection