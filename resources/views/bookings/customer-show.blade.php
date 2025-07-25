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
    
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        display: inline-block;
    }
    
    .status-confirmed {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.4);
    }
    
    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: var(--gold);
        border: 1px solid rgba(255, 193, 7, 0.4);
    }
    
    .status-cancelled {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.4);
    }
    
    .status-rejected {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.4);
    }
    
    .documents-section {
        margin-top: 2rem;
    }
    
    .document-card {
        background: rgba(30, 30, 47, 0.5);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
    }
    
    .document-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        background: rgba(20, 20, 35, 0.5);
        border-radius: 6px;
    }
    
    .document-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        color: var(--gold);
    }
    
    .document-info {
        flex: 1;
    }
    
    .document-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .document-actions {
        margin-left: 1rem;
    }
    
    .btn-view {
        background: rgba(110, 142, 251, 0.2);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: rgba(110, 142, 251, 0.4);
        transform: translateY(-2px);
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
    
    .contact-info {
        background: rgba(30, 30, 47, 0.5);
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
        border-left: 4px solid var(--gold);
    }
    
    .contact-info h5 {
        color: var(--gold);
        margin-bottom: 1rem;
    }
    
    .contact-info .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
    }
    
    .contact-info .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }
    
    .delivery-info {
        background: rgba(30, 30, 47, 0.5);
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
        border: 1px solid rgba(110, 142, 251, 0.2);
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
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }
    
    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
    
    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    }
    
    .btn-edit-delivery {
        background: linear-gradient(135deg, #6e8efb, #4a6cf7);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
        margin-top: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-edit-delivery:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(110, 142, 251, 0.3);
    }
    
    @media (max-width: 768px) {
        .main-container {
            padding: 1.5rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
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
        <h1 class="hero-title"><i class="fas fa-file-invoice me-2"></i>Booking Details</h1>
        <p class="hero-subtitle">Booking #{{ $booking->id }}</p>
    </section>
    
    <!-- Booking Card -->
    <div class="booking-card animate__animated animate__fadeInUp">
        <!-- Car Information -->
        <h3 class="section-title"><i class="fas fa-car me-2"></i>Car Information</h3>
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
                <span class="info-label">family friendly</span>
                <span class="info-value">{{ $booking->car->family_friendly ? 'Yes' : 'No'}}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Agency</span>
                <span class="info-value">{{ $booking->car->agency->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Daily Rate</span>
                <span class="info-value">{{ number_format($booking->car->daily_rate, 2) }} DZD</span>
            </div>
            <div class="info-item">
                <span class="info-label">Seats </span>
                <span class="info-value">{{ $booking->car->seats}} seats</span>
            </div>
            <div class="info-item">
                <span class="info-label">child seat </span>
                <span class="info-value">{{ $booking->car->child_seat ? 'Yes' : 'No' }}</span>

            </div>
            <div class="info-item">
                <span class="info-label">Air Conditioning </span>
                <span class="info-value">{{  $booking->car->air_conditioning ? 'Yes' : 'No'  }} </span>
            </div>
            <div class="info-item">
                <span class="info-label"> Eco Friendly </span>
                <span class="info-value">{{ $booking->car->eco_friendly ? 'Yes' : 'No' }} </span>
            </div>
           
                  
        
            
        </div>
        
        <!-- Booking Details -->
        <h3 class="section-title"><i class="fas fa-calendar-check me-2"></i>Booking Details</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Start Date</span>
                <span class="info-value">{{ $booking->start_date->format('l, F j, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">End Date</span>
                <span class="info-value">{{ $booking->end_date->format('l, F j, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Days</span>
                <span class="info-value">{{ $booking->start_date->diffInDays($booking->end_date) }} days</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Amount</span>
                <span class="info-value">{{ number_format($booking->total_amount, 2) }} DZD</span>
            </div>
            <div class="info-item">
                <span class="info-label">Booking Date</span>
                <span class="info-value">{{ $booking->created_at->format('l, F j, Y \a\t h:i A') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="status-badge 
                    @if($booking->status === 'Confirmed') status-confirmed
                    @elseif($booking->status === 'Pending Payment') status-pending
                    @elseif($booking->status === 'Cancelled') status-cancelled
                    @elseif($booking->status === 'Rejected') status-rejected
                    @else status-pending @endif">
                    {{ $booking->status }}
                </span>
            </div>
        </div>
        
        <!-- Required Documents Section -->
        <div class="documents-section">
            <h3 class="section-title"><i class="fas fa-file-alt me-2"></i>Required Documents</h3>
            <div class="document-card">
                <!-- Driving License -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="document-info">
                        <div class="document-title">Driving License</div>
                        <div class="text-muted">Valid driver's license copy</div>
                    </div>
                    <div class="document-actions">
                        @if($booking->driving_license_path)
                            <a href="{{ Storage::url($booking->driving_license_path) }}" target="_blank" class="btn btn-view">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>
                </div>
                
                <!-- ID Proof -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-passport"></i>
                    </div>
                    <div class="document-info">
                        <div class="document-title">ID Card / Passport</div>
                        <div class="text-muted">Copy of national ID or passport</div>
                    </div>
                    <div class="document-actions">
                        @if($booking->id_proof_path)
                            <a href="{{ Storage::url($booking->id_proof_path) }}" target="_blank" class="btn btn-view">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>
                </div>
                
                <!-- Residence Proof -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="document-info">
                        <div class="document-title">Residence Proof</div>
                        <div class="text-muted">Utility bill or residence certificate</div>
                    </div>
                    <div class="document-actions">
                        @if($booking->residence_proof_path)
                            <a href="{{ Storage::url($booking->residence_proof_path) }}" target="_blank" class="btn btn-view">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        @else
                            <span class="text-danger">Not uploaded</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Information Section -->
        <div class="contact-info">
            <h5><i class="fas fa-phone me-2"></i> Contact Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Customer Name:</strong> {{ $booking->user->name }}</p>
                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                </div>
                <div class="col-md-6">
                    @if($booking->delivery_phone)
                        <p><strong>Phone Number:</strong> {{ $booking->delivery_phone }}</p>
                        @auth
                            @if(auth()->user()->account_type === 'agency')
                                <div class="mt-2">
                                    <a href="tel:{{ $booking->delivery_phone }}" class="btn btn-success me-2">
                                        <i class="fas fa-phone me-1"></i> Call
                                    </a>
                                    <a href="https://wa.me/213{{ substr($booking->delivery_phone, 1) }}" 
                                       target="_blank" class="btn btn-success">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                </div>
                            @endif
                        @endauth
                    @else
                        <form method="POST" action="{{ route('bookings.update-phone', $booking->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="delivery_phone" 
                                       placeholder="Enter your phone number" required
                                       pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                                <small class="text-muted">We'll use this number to contact you about your booking</small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Phone Number
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Delivery Options (Only for Confirmed Bookings) -->
        @if($booking->status === 'Confirmed' && !$booking->delivery_method)
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
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i> Confirm Delivery Method
                    </button>
                </div>
            </form>
        </div>
        @endif
        
        <!-- Display Selected Delivery Method -->
        @if($booking->delivery_method)
        <div class="delivery-info">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title">
                    <i class="fas fa-truck me-2"></i> Delivery Information
                </h3>
                <!-- زر التعديل الجديد -->
                <button class="btn-edit-delivery" onclick="toggleEditDeliveryForm()">
                    <i class="fas fa-edit"></i> Edit Delivery
                </button>
            </div>
            
            <!-- نموذج التعديل (مخفي بشكل افتراضي) -->
            <div id="editDeliveryForm" style="display: none;">
                <form method="POST" action="{{ route('bookings.update-delivery', $booking->id) }}">
                    @csrf
                    @method('PUT')
                    
                    @if($booking->delivery_method === 'delivery')
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Full Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address" 
                               value="{{ $booking->delivery_address }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_state" class="form-label">State</label>
                            <input type="text" class="form-control" id="edit_state" name="state" 
                                   value="{{ $booking->delivery_state }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="edit_postal_code" name="postal_code" 
                                   value="{{ $booking->delivery_postal_code }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_delivery_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="edit_delivery_notes" name="delivery_notes" rows="3">{{ $booking->delivery_notes }}</textarea>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="edit_delivery_phone" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="edit_delivery_phone" name="delivery_phone" 
                               value="{{ $booking->delivery_phone }}" required
                               pattern="[0-9]{10}">
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-secondary me-2" onclick="toggleEditDeliveryForm()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
            
            <!-- محتوى معلومات التسليم الأصلي -->
            <div id="deliveryInfoContent">
                @if($booking->delivery_method === 'pickup')
                <div class="info-item">
                    <span class="info-label">Method</span>
                    <span class="info-value"><i class="fas fa-store me-2"></i> Pickup from Agency</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Agency Address</span>
                    <span class="info-value">{{ $booking->car->agency->address }}</span>
                </div>
                <div class="mt-3">
                    <a href="https://www.google.com/maps?q={{ urlencode($booking->car->agency->address) }}" 
                       target="_blank" class="btn btn-secondary">
                        <i class="fas fa-map-marked-alt me-1"></i> View on Map
                    </a>
                </div>
                @else
                <div class="info-item">
                    <span class="info-label">Method</span>
                    <span class="info-value"><i class="fas fa-truck me-2"></i> Car Delivery to Your Location</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Delivery Address</span>
                    <span class="info-value">{{ $booking->delivery_address }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">State & Postal Code</span>
                    <span class="info-value">{{ $booking->delivery_state }}, {{ $booking->delivery_postal_code }}</span>
                </div>
                @if($booking->delivery_notes)
                <div class="info-item">
                    <span class="info-label">Additional Notes</span>
                    <span class="info-value">{{ $booking->delivery_notes }}</span>
                </div>
                @endif
                <div class="mt-3">
                    <a href="https://www.google.com/maps?q={{ urlencode($booking->delivery_address) }}" 
                       target="_blank" class="btn btn-secondary">
                        <i class="fas fa-map-marked-alt me-1"></i> View on Map
                    </a>
                </div>
                @endif
                
                <div class="info-item">
                    <span class="info-label">Contact Number</span>
                    <span class="info-value">{{ $booking->delivery_phone }}</span>
                    @auth
                        @if(auth()->user()->account_type === 'agency')
                            <div class="mt-2">
                                <a href="tel:{{ $booking->delivery_phone }}" class="btn btn-success me-2">
                                    <i class="fas fa-phone me-1"></i> Call
                                </a>
                                <a href="https://wa.me/213{{ substr($booking->delivery_phone, 1) }}" 
                                   target="_blank" class="btn btn-success">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('bookings.customer-index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Bookings
            </a>
            
            @if($booking->status === 'Pending Payment')
            <a href="{{ route('bookings.payment', $booking->id) }}" class="btn btn-success">
                <i class="fas fa-credit-card me-2"></i> Complete Payment
            </a>
            @endif
            
            @if($booking->status === 'Pending Payment' || $booking->status === 'Pending Approval')
            <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                    <i class="fas fa-times-circle me-2"></i> Cancel Booking
                </button>
            </form>
            @endif
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

    // دالة لعرض/إخفاء نموذج التعديل
    function toggleEditDeliveryForm() {
        const form = document.getElementById('editDeliveryForm');
        const content = document.getElementById('deliveryInfoContent');
        
        if (form.style.display === 'none') {
            form.style.display = 'block';
            content.style.display = 'none';
        } else {
            form.style.display = 'none';
            content.style.display = 'block';
        }
    }
</script>
@endsection