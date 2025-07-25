@extends('layouts.agency')

@section('title', 'Booking Details')
@section('icon', 'fa-file-invoice')
@section('page-title', 'Booking Management')

@section('content')
<div class="booking-detail-container">
    <!-- Header Section -->
    <div class="booking-header">
        <div class="header-content">
            <h1 class="booking-title">
                <i class="fas fa-file-invoice"></i> Booking Invoice #{{ $booking->id }}
            </h1>
            <div class="status-badge {{ strtolower($booking->status) }}">
                {{ $booking->status }}
            </div>
        </div>
        <div class="header-meta">
            <span><i class="far fa-calendar-alt"></i> {{ $booking->created_at->format('d M Y, h:i A') }}</span>
            <span><i class="fas fa-user"></i> {{ $booking->user->name }}</span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="booking-grid">
        <!-- Car Information Card -->
        <div class="card car-card">
            <div class="card-header">
                <i class="fas fa-car"></i> Vehicle Details
            </div>
            <div class="card-body">
                <div class="car-image-placeholder">
                    @if(optional($booking->car->images)->first())
                    <img src="{{ Storage::url(optional($booking->car->images->first())->path) }}" alt="{{ $booking->car->brand }} {{ $booking->car->model }}">
                @else
                    <i class="fas fa-car-side"></i>
                @endif
                </div>
                <div class="car-details">
                    <h3>{{ $booking->car->brand }} {{ $booking->car->model }}</h3>
                    <div class="detail-row">
                        <span class="detail-label">Agency:</span>
                        <span class="detail-value">{{ $booking->car->agency->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Daily Rate:</span>
                        <span class="detail-value">{{ number_format($booking->car->daily_rate, 2) }} DZD</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Vehicle ID:</span>
                        <span class="detail-value">#{{ $booking->car->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Plate Number:</span>
                        <span class="detail-value">{{ $booking->car->license_plate }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Timeline Card -->
        <div class="card timeline-card">
            <div class="card-header">
                <i class="fas fa-calendar-week"></i> Rental Period
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item start">
                        <div style="margin: 5px" class="timeline-date">{{ $booking->start_date->format('d M Y') }}</div>
                        <div class="timeline-content">
                            <i class="fas fa-play-circle"></i>
                            <h4>Pickup Date</h4>
                            <p>{{ $booking->start_date->format('l, h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="timeline-duration">
                        <i class="fas fa-clock"></i> {{ $booking->start_date->diffInDays($booking->end_date) }} Days Rental
                    </div>
                    
                    <div class="timeline-item end">
                        <div style="margin: 5px" class="timeline-date">{{ $booking->end_date->format('d M Y') }}</div>
                        <div class="timeline-content">
                            <i class="fas fa-flag-checkered"></i>
                            <h4>Return Date</h4>
                            <p>{{ $booking->end_date->format('l, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Information Card -->
        <div class="card delivery-card">
            <div class="card-header">
                <i class="fas fa-truck"></i> Delivery Information
            </div>
            <div class="card-body">
                <div class="delivery-method {{ $booking->delivery_method }}">
                    @if($booking->delivery_method === 'pickup')
                        <i class="fas fa-store"></i> Agency Pickup
                    @else
                        <i class="fas fa-truck"></i> Vehicle Delivery
                    @endif
                </div>
                
                @if($booking->delivery_method === 'delivery')
                <div class="delivery-details">
                    <div class="detail-section">
                        <h4><i class="fas fa-map-marked-alt"></i> Delivery Address</h4>
                        <p>{{ $booking->delivery_address }}</p>
                        <div class="address-meta">
                            <span>{{ $booking->delivery_state }}</span>
                            <span>{{ $booking->delivery_postal_code }}</span>
                        </div>
                    </div>
                    
                    <a href="https://maps.google.com?q={{ urlencode($booking->delivery_address) }}" 
                       target="_blank" class="map-btn">
                        <i class="fas fa-map-marker-alt"></i> View on Map
                    </a>
                </div>
                @else
                <div class="delivery-details">
                    <div class="detail-section">
                        <h4><i class="fas fa-store"></i> Pickup Location</h4>
                        <p>{{ $booking->car->agency->address }}</p>
                    </div>
                    
                    <a href="https://maps.google.com?q={{ urlencode($booking->car->agency->address) }}" 
                       target="_blank" class="map-btn">
                        <i class="fas fa-map-marker-alt"></i> View on Map
                    </a>
                </div>
                @endif
                
                @if($booking->delivery_notes)
                <div class="notes-section">
                    <h4><i class="fas fa-sticky-note"></i> Special Instructions</h4>
                    <p>{{ $booking->delivery_notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Contact & Payment Card -->
        <div class="card contact-card">
            <div class="card-header">
                <i class="fas fa-user-tie"></i> Client Information
            </div>
            <div class="card-body">
                <div class="client-info">
                    <div class="client-avatar">
                        @if($booking->user->profile_photo_path)
                            <img src="{{ Storage::url($booking->user->profile_photo_path) }}" alt="{{ $booking->user->name }}">
                        @else
                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="client-details">
                        <h3>{{ $booking->user->name }}</h3>
                        <p><i class="fas fa-envelope"></i> {{ $booking->user->email }}</p>
                        @if($booking->delivery_phone)
                        <p><i class="fas fa-phone"></i> {{ $booking->delivery_phone }}</p>
                        <div class="contact-actions">
                            <a href="tel:{{ $booking->delivery_phone }}" class="btn-call">
                                <i class="fas fa-phone-alt"></i> Call
                            </a>
                            <a href="https://wa.me/213{{ substr($booking->delivery_phone, 1) }}" 
                               target="_blank" class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                        @else
                        <p class="no-phone"><i class="fas fa-exclamation-circle"></i> Phone number not provided</p>
                        @endif
                    </div>
                </div>
                
                <div class="payment-summary">
                    <h4><i class="fas fa-receipt"></i> Payment Summary</h4>
                    <div class="payment-row">
                        <span>Subtotal:</span>
                        <span>{{ number_format($booking->total_amount, 2) }} DZD</span>
                    </div>
                    <div class="payment-row">
                        <span>Delivery Fee:</span>
                        <span>0.00 DZD</span>
                    </div>
                    <div class="payment-row total">
                        <span>Total Amount:</span>
                        <span>{{ number_format($booking->total_amount, 2) }} DZD</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Card -->
        <div class="card documents-card">
            <div class="card-header">
                <i class="fas fa-file-contract"></i> Customer Documents
            </div>
            <div class="card-body">
                <div class="document-grid">
                    <!-- Driving License -->
                    <div class="document-item">
                        <div class="document-preview">
                            @if(pathinfo($booking->driving_license_path, PATHINFO_EXTENSION) === 'pdf')
                                <i class="fas fa-file-pdf pdf-icon"></i>
                            @else
                                <img src="{{ Storage::url($booking->driving_license_path) }}" alt="Driving License">
                            @endif
                        </div>
                        <div class="document-info">
                            <h4>Driving License</h4>
                            <p>Submitted: {{ $booking->created_at->format('d M Y') }}</p>
                            <a href="{{Storage::url($booking->driving_license_path) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-eye"></i> View Full Document
                            </a>
                        </div>
                    </div>

                    <!-- ID Proof -->
                    <div class="document-item">
                        <div class="document-preview">
                            @if(pathinfo($booking->id_proof_path, PATHINFO_EXTENSION) === 'pdf')
                                <i class="fas fa-file-pdf pdf-icon"></i>
                            @else
                                <img src="{{  Storage::url($booking->id_proof_path) }}" alt="ID Proof">
                            @endif
                        </div>
                        <div class="document-info">
                            <h4>National ID Proof</h4>
                            <p>Submitted: {{ $booking->created_at->format('d M Y') }}</p>
                            <a href="{{Storage::url($booking->id_proof_path) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-eye"></i> View Full Document
                            </a>
                        </div>
                    </div>

                    <!-- Residence Proof -->
                    <div class="document-item">
                        <div class="document-preview">
                            @if(pathinfo($booking->residence_proof_path, PATHINFO_EXTENSION) === 'pdf')
                                <i class="fas fa-file-pdf pdf-icon"></i>
                            @else
                                <img src="{{ Storage::url($booking->residence_proof_path)}}" alt="Residence Proof">
                            @endif
                        </div>
                        <div class="document-info">
                            <h4>Residence Proof</h4>
                            <p>Submitted: {{ $booking->created_at->format('d M Y') }}</p>
                            <a href="{{ Storage::url($booking->residence_proof_path) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-eye"></i> View Full Document
                            </a>
                        </div>
                    </div>

                    <!-- Additional Documents if any -->
                    @if($booking->additional_documents)
                        @foreach(json_decode($booking->additional_documents) as $doc)
                        <div class="document-item">
                            <div class="document-preview">
                                @if(pathinfo($doc, PATHINFO_EXTENSION) === 'pdf')
                                    <i class="fas fa-file-pdf pdf-icon"></i>
                                @else
                                    <img src="{{ Storage::url($doc) }}" alt="Additional Document">
                                @endif
                            </div>
                            <div class="document-info">
                                <h4>Additional Document</h4>
                                <p>Submitted: {{ $booking->created_at->format('d M Y') }}</p>
                                <a href="{{ Storage::url($doc) }}" 
                                   target="_blank" class="btn-view-doc">
                                    <i class="fas fa-eye"></i> View Full Document
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        @if($booking->status === 'Pending Approval')
        <button class="btn-approve" id="approveBtn">
            <i class="fas fa-check-circle"></i> Approve Booking
        </button>
        
        <button class="btn-reject" id="rejectBtn">
            <i class="fas fa-times-circle"></i> Reject Booking
        </button>
        
        <div class="reject-modal" id="rejectModal">
            <div class="modal-content">
                <h3>Reason for Rejection</h3>
                <form method="POST" action="{{ route('agency.bookings.reject', $booking->id) }}">
                    @csrf
                    <textarea name="rejection_reason" placeholder="Please specify the reason for rejection..." required></textarea>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" id="cancelReject">Cancel</button>
                        <button type="submit" class="btn-confirm-reject">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        
        <a href="{{ route('agency.bookings') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Bookings
        </a>
        
        <button class="btn-print" onclick="printInvoice()">
            <i class="fas fa-print"></i> Print Invoice
        </button>
    </div>
</div>
<!-- Printable Invoice -->
<div id="printable-invoice" style="display:none;">
    <div class="print-container" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 900px; margin: 0 auto; color: #333;">
        <!-- Header with Watermark Effect -->
        <div style="position: relative;">
            <div class="print-header" style="border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; margin-bottom: 30px;">
                <div class="print-logo-container" style="text-align: center; margin-bottom: 20px;">
                    <img style="max-width: 300px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));" 
                         src="{{ asset('images/demo/gallery/q.jpg') }}" 
                         alt="AETHORIA RENTAL">
                </div>
                
                <div class="print-company-info" style="text-align: center;">
                    <h1 style="color: #e67e22; margin: 0; font-size: 28px; letter-spacing: 1px; font-weight: 600;">AETHORIA RENTAL</h1>
                    <p style="margin: 5px 0; color: #666; font-size: 14px;">Premium Vehicle Rental Services</p>
                    <div style="display: flex; justify-content: center; gap: 15px; margin-top: 10px;">
                        <span style="display: flex; align-items: center; gap: 5px; font-size: 13px;">
                            <i class="fas fa-phone" style="color: #e67e22;"></i> +213 123 456 789
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px; font-size: 13px;">
                            <i class="fas fa-envelope" style="color: #e67e22;"></i> contact@aethoria.dz
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px; font-size: 13px;">
                            <i class="fas fa-globe" style="color: #e67e22;"></i> www.aethoria.dz
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Watermark Background -->
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                        opacity: 0.05; z-index: -1; pointer-events: none;">
                <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#e67e22" d="M50,-50C62.5,-37.5,68.8,-18.8,68.8,0C68.8,18.8,62.5,37.5,50,50C37.5,62.5,18.8,68.8,0,68.8C-18.8,68.8,-37.5,62.5,-50,50C-62.5,37.5,-68.8,18.8,-68.8,0C-68.8,-18.8,-62.5,-37.5,-50,-50C-37.5,-62.5,-18.8,-68.8,0,-68.8C18.8,-68.8,37.5,-62.5,50,-50Z" transform="translate(100 100)" />
                </svg>
            </div>
        </div>

        <!-- Invoice Title Section -->
        <div class="print-title-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h2 style="color: #e67e22; margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 0.5px;">RENTAL INVOICE</h2>
                <p style="margin: 5px 0 0; color: #666; font-size: 13px;">Invoice Date: {{ $booking->created_at->format('d M Y') }}</p>
            </div>
            <div style="background: #e67e22; color: white; padding: 8px 15px; border-radius: 4px; font-weight: 600; font-size: 18px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <!-- Status Ribbon -->
        <div style="background: #f8f9fa; padding: 10px 15px; border-left: 4px solid #e67e22; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-weight: 600; color: #555;">Status:</span>
                <span class="print-status-badge {{ strtolower($booking->status) }}" 
                      style="padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; margin-left: 8px;
                             background: {{ $booking->status == 'Confirmed' ? '#d4edda' : ($booking->status == 'Pending' ? '#fff3cd' : '#f8d7da') }};
                             color: {{ $booking->status == 'Confirmed' ? '#155724' : ($booking->status == 'Pending' ? '#856404' : '#721c24') }};">
                    {{ $booking->status }}
                </span>
            </div>
            <div>
                <span style="font-weight: 600; color: #555;">Due Date:</span>
                <span style="margin-left: 8px;">{{ $booking->start_date->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Client and Agency Info -->
        <div class="print-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <!-- Client Card -->
            <div style="border: 1px solid #eee; border-radius: 6px; padding: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-tie" style="font-size: 14px;"></i> CLIENT INFORMATION
                </h3>
                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 8px; font-size: 13px;">
                    <span style="font-weight: 600; color: #555;">Name:</span>
                    <span>{{ $booking->user->name }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Email:</span>
                    <span>{{ $booking->user->email }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Phone:</span>
                    <span>{{ $booking->delivery_phone ?? 'N/A' }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Customer ID:</span>
                    <span>CUST-{{ str_pad($booking->user->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            
            <!-- Agency Card -->
            <div style="border: 1px solid #eee; border-radius: 6px; padding: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-building" style="font-size: 14px;"></i> AGENCY INFORMATION
                </h3>
                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 8px; font-size: 13px;">
                    <span style="font-weight: 600; color: #555;">Agency:</span>
                    <span>{{ $booking->car->agency->name }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Address:</span>
                    <span>{{ $booking->car->agency->address }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Contact:</span>
                    <span>{{ $booking->car->agency->phone }}</span>
                    
                    <span style="font-weight: 600; color: #555;">Agency ID:</span>
                    <span>AG-{{ str_pad($booking->car->agency->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div style="border: 1px solid #eee; border-radius: 6px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-car" style="font-size: 14px;"></i> VEHICLE DETAILS
            </h3>
            
            <div style="display: flex; gap: 20px;">
                <div style="flex: 0 0 150px; height: 100px; background: #f5f5f5; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-car" style="font-size: 30px; color: #ddd;"></i>
                </div>
                
                <div style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; font-size: 13px;">
                    <div>
                        <span style="font-weight: 600; color: #555;">Brand/Model:</span>
                        <p style="margin: 5px 0;">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                    </div>
                    
                    <div>
                        <span style="font-weight: 600; color: #555;">Daily Rate:</span>
                        <p style="margin: 5px 0;">{{ number_format($booking->car->daily_rate, 2) }} DZD</p>
                    </div>
                    
                    <div>
                        <span style="font-weight: 600; color: #555;">Plate Number:</span>
                        <p style="margin: 5px 0;">{{ $booking->car->license_plate }}</p>
                    </div>
                    
                    <div>
                        <span style="font-weight: 600; color: #555;">Vehicle Type:</span>
                        <p style="margin: 5px 0;">{{ $booking->car->type }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Period -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-calendar-alt" style="font-size: 14px;"></i> RENTAL PERIOD
            </h3>
            
            <div style="display: flex; align-items: center; justify-content: space-between; background: #f8f9fa; padding: 15px; border-radius: 6px;">
                <div style="text-align: center; flex: 1;">
                    <div style="background: #e67e22; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                        <i class="fas fa-play"></i>
                    </div>
                    <h4 style="margin: 0; font-size: 13px; color: #555; font-weight: 600;">PICKUP DATE</h4>
                    <p style="margin: 5px 0 0; font-size: 14px; font-weight: 500;">{{ $booking->start_date->format('d M Y h:i A') }}</p>
                </div>
                
                <div style="text-align: center; flex: 0 0 auto; padding: 0 20px; position: relative;">
                    <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #ddd; z-index: 1;"></div>
                    <div style="background: white; padding: 0 10px; position: relative; z-index: 2; display: inline-block;">
                        <span style="background: #e67e22; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            {{ $booking->start_date->diffInDays($booking->end_date) }} DAYS
                        </span>
                    </div>
                </div>
                
                <div style="text-align: center; flex: 1;">
                    <div style="background: #e67e22; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <h4 style="margin: 0; font-size: 13px; color: #555; font-weight: 600;">RETURN DATE</h4>
                    <p style="margin: 5px 0 0; font-size: 14px; font-weight: 500;">{{ $booking->end_date->format('d M Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div style="border: 1px solid #eee; border-radius: 6px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-truck" style="font-size: 14px;"></i> DELIVERY INFORMATION
            </h3>
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                <div style="background: {{ $booking->delivery_method === 'pickup' ? '#e67e22' : '#f0f0f0' }}; 
                            color: {{ $booking->delivery_method === 'pickup' ? 'white' : '#666' }}; 
                            padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    <i class="fas {{ $booking->delivery_method === 'pickup' ? 'fa-store' : 'fa-truck' }}" style="margin-right: 5px;"></i>
                    {{ $booking->delivery_method === 'pickup' ? 'AGENCY PICKUP' : 'VEHICLE DELIVERY' }}
                </div>
                
                @if($booking->delivery_method === 'delivery')
                <div style="font-size: 13px;">
                    <span style="font-weight: 600; color: #555;">Delivery Fee:</span>
                    <span>0.00 DZD (Free)</span>
                </div>
                @endif
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px;">
                <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #555; font-weight: 600;">
                    {{ $booking->delivery_method === 'pickup' ? 'Pickup Location' : 'Delivery Address' }}
                </h4>
                <p style="margin: 0; font-size: 13px;">
                    {{ $booking->delivery_method === 'pickup' ? $booking->car->agency->address : $booking->delivery_address }}
                </p>
                
                @if($booking->delivery_method === 'delivery')
                <div style="display: flex; gap: 15px; margin-top: 10px; font-size: 13px;">
                    <span><strong>State:</strong> {{ $booking->delivery_state }}</span>
                    <span><strong>Postal Code:</strong> {{ $booking->delivery_postal_code }}</span>
                </div>
                @endif
            </div>
            
            @if($booking->delivery_notes)
            <div style="margin-top: 15px; padding: 10px 15px; background: #fff8e1; border-left: 3px solid #ffc107; border-radius: 0 4px 4px 0;">
                <h4 style="margin: 0 0 5px 0; font-size: 14px; color: #555; font-weight: 600;">Special Instructions</h4>
                <p style="margin: 0; font-size: 13px;">{{ $booking->delivery_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Payment Summary -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-receipt" style="font-size: 14px;"></i> PAYMENT SUMMARY
            </h3>
            
            <div style="border: 1px solid #eee; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 12px 15px; font-weight: 600; color: #555;">Description</td>
                        <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #555;">Amount</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 15px; border-bottom: 1px solid #eee;">Daily Rental ({{ $booking->start_date->diffInDays($booking->end_date) }} days)</td>
                        <td style="padding: 10px 15px; text-align: right; border-bottom: 1px solid #eee;">{{ number_format($booking->total_amount, 2) }} DZD</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 15px; border-bottom: 1px solid #eee;">Delivery Fee</td>
                        <td style="padding: 10px 15px; text-align: right; border-bottom: 1px solid #eee;">0.00 DZD</td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 12px 15px; font-weight: 600;">Subtotal</td>
                        <td style="padding: 12px 15px; text-align: right; font-weight: 600;">{{ number_format($booking->total_amount, 2) }} DZD</td>
                    </tr>
                    <tr style="background: #fff8e1;">
                        <td style="padding: 12px 15px; font-weight: 600;">Amount Paid</td>
                        <td style="padding: 12px 15px; text-align: right; font-weight: 600;">0.00 DZD</td>
                    </tr>
                    <tr style="background: #e67e22; color: white;">
                        <td style="padding: 12px 15px; font-weight: 600;">Balance Due</td>
                        <td style="padding: 12px 15px; text-align: right; font-weight: 600;">{{ number_format($booking->total_amount, 2) }} DZD</td>
                    </tr>
                </table>
            </div>
            
            <div style="text-align: right; margin-top: 10px;">
                <p style="font-size: 12px; color: #666; margin: 0;">Payment due upon vehicle pickup/delivery</p>
            </div>
        </div>

        <!-- Documents Section -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-file-contract" style="font-size: 14px;"></i> CUSTOMER DOCUMENTS
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                <!-- Driving License -->
                <div style="border: 1px solid #eee; border-radius: 6px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                    <h4 style="margin: 0 0 10px 0; font-size: 13px; color: #555; font-weight: 600;">Driving License</h4>
                    <div style="height: 120px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        @if(pathinfo($booking->driving_license_path, PATHINFO_EXTENSION) === 'pdf')
                            <div style="text-align: center;">
                                <i class="fas fa-file-pdf" style="font-size: 30px; color: #e74c3c;"></i>
                                <p style="margin: 5px 0 0; font-size: 12px;">PDF Document</p>
                            </div>
                        @else
                            <img style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                 src="{{ Storage::url($booking->driving_license_path) }}" 
                                 alt="Driving License">
                        @endif
                    </div>
                    <p style="font-size: 11px; color: #999; margin: 0; word-break: break-all;">{{ Storage::url($booking->driving_license_path) }}</p>
                </div>

                <!-- ID Proof -->
                <div style="border: 1px solid #eee; border-radius: 6px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                    <h4 style="margin: 0 0 10px 0; font-size: 13px; color: #555; font-weight: 600;">ID Proof</h4>
                    <div style="height: 120px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        @if(pathinfo($booking->id_proof_path, PATHINFO_EXTENSION) === 'pdf')
                            <div style="text-align: center;">
                                <i class="fas fa-file-pdf" style="font-size: 30px; color: #e74c3c;"></i>
                                <p style="margin: 5px 0 0; font-size: 12px;">PDF Document</p>
                            </div>
                        @else
                            <img style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                 src="{{ Storage::url($booking->id_proof_path) }}" 
                                 alt="ID Proof">
                        @endif
                    </div>
                    <p style="font-size: 11px; color: #999; margin: 0; word-break: break-all;">{{ Storage::url($booking->id_proof_path) }}</p>
                </div>

                <!-- Residence Proof -->
                <div style="border: 1px solid #eee; border-radius: 6px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                    <h4 style="margin: 0 0 10px 0; font-size: 13px; color: #555; font-weight: 600;">Residence Proof</h4>
                    <div style="height: 120px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        @if(pathinfo($booking->residence_proof_path, PATHINFO_EXTENSION) === 'pdf')
                            <div style="text-align: center;">
                                <i class="fas fa-file-pdf" style="font-size: 30px; color: #e74c3c;"></i>
                                <p style="margin: 5px 0 0; font-size: 12px;">PDF Document</p>
                            </div>
                        @else
                            <img style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                 src="{{ Storage::url($booking->residence_proof_path) }}" 
                                 alt="Residence Proof">
                        @endif
                    </div>
                    <p style="font-size: 11px; color: #999; margin: 0; word-break: break-all;">{{ Storage::url($booking->residence_proof_path) }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 2px solid #f0f0f0; padding-top: 20px; margin-top: 30px; text-align: center;">
            <p style="font-size: 12px; color: #999; margin: 5px 0;">Thank you for choosing AETHORIA RENTAL</p>
            <p style="font-size: 11px; color: #bbb; margin: 5px 0;">This is a computer generated document. No signature is required.</p>
            <p style="font-size: 10px; color: #ddd; margin: 5px 0;">Invoice generated on {{ now()->format('d M Y h:i A') }}</p>
        </div>
    </div>
</div>
        <!-- Footer -->
        <div style="color: black"  class="print-footer">
            <div class="print-terms">
                <h4  style="color: rgb(237, 145, 8); padding: 4px;">TERMS & CONDITIONS</h4>
                <ol>
                    <li>Payment is due upon vehicle pickup/delivery</li>
                    <li>Cancellation must be made 24 hours prior to rental</li>
                    <li>Late returns will incur additional charges</li>
                    <li>Fuel policy: full-to-full</li>
                    <li>All documents must be verified before vehicle handover</li>
                    <li>Security deposit may be required</li>
                </ol>
            </div>
            
            <div class="print-signature">
                <div class="print-signature-line"></div>
                <p>Authorized Signature</p>
            </div>
            
            <div class="print-footer-meta">
                <p>Invoice generated on {{ now()->format('d M Y H:i') }}</p>
                <p>AETHORIA Rental Management System v1.0</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Main Styles */
    .booking-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        background: #f8f9fa;
    }
    
    .booking-header {
        background: linear-gradient(135deg, #2c3e50, #4a6cf7);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .booking-title {
        font-weight: 600;
        font-size: 1.8rem;
        margin: 0;
        color: white;
    }
    
    .booking-title i {
        margin-right: 10px;
        color: #ffc107;
    }
    
    .status-badge {
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge.pending {
        background: rgba(255, 193, 7, 0.9);
        color: #343a40;
    }
    
    .status-badge.confirmed {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }
    
    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }
    
    .header-meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.9);
    }
    
    .header-meta i {
        margin-right: 5px;
        color: #ffc107;
    }
    
    /* Grid Layout */
    .booking-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Card Styles */
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .card-header {
        background: #4a6cf7;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .card-header i {
        margin-right: 10px;
        color: #ffc107;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Car Card */
    .car-card .card-body {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }
    
    .car-image-placeholder {
        width: 120px;
        height: 80px;
        background: #f0f4ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4a6cf7;
        font-size: 2.5rem;
        overflow: hidden;
    }
    
    .car-image-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .car-details {
        flex: 1;
    }
    
    .car-details h3 {
        margin: 0 0 0.5rem 0;
        color: #2c3e50;
        font-size: 1.3rem;
    }
    
    .detail-row {
        display: flex;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .detail-label {
        font-weight: 600;
        min-width: 100px;
        color: #555;
    }
    
    .detail-value {
        color: #333;
    }
    
    /* Timeline Card */
    .timeline {
        position: relative;
        padding: 1rem 0;
    }
    
    .timeline-item {
        display: flex;
        margin-bottom: 1rem;
    }
    
    .timeline-date {
        min-width: 80px;
        font-weight: 600;
        color: #4a6cf7;
        font-size: 0.9rem;
    }
    
    .timeline-content {
        flex: 1;
        padding-left: 1rem;
        border-left: 2px solid #4a6cf7;
        position: relative;
    }
    
    .timeline-content:before {
        content: '';
        position: absolute;
        left: -8px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4a6cf7;
    }
    
    .timeline-content h4 {
        margin: 0 0 0.3rem 0;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .timeline-content p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
    }
    
    .timeline-content i {
        color: #4a6cf7;
        margin-right: 8px;
    }
    
    .timeline-duration {
        text-align: center;
        margin: 1rem 0;
        padding: 0.5rem;
        background: #f0f4ff;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #4a6cf7;
        font-weight: 500;
    }
    
    .timeline-duration i {
        margin-right: 5px;
    }
    
    /* Delivery Card */
    .delivery-method {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .delivery-method.pickup {
        background: rgba(74, 108, 247, 0.1);
        color: #4a6cf7;
    }
    
    .delivery-method.delivery {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .delivery-method i {
        margin-right: 8px;
    }
    
    .detail-section h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        color: #444;
        display: flex;
        align-items: center;
    }
    
    .detail-section h4 i {
        color: #4a6cf7;
        margin-right: 8px;
    }
    
    .address-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.9rem;
        color: #666;
        margin-top: 0.3rem;
    }
    
    .map-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #4a6cf7;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        margin-top: 1rem;
        transition: background 0.3s;
    }
    
    .map-btn:hover {
        background: #3a5bd9;
    }
    
    .map-btn i {
        margin-right: 8px;
    }
    
    .notes-section {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid #4a6cf7;
        margin-top: 1rem;
    }
    
    .notes-section h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        color: #444;
    }
    
    .notes-section p {
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
        color: #555;
    }
    
    /* Contact Card */
    .client-info {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .client-avatar {
        width: 60px;
        height: 60px;
        background: #4a6cf7;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        flex-shrink: 0;
        overflow: hidden;
    }
    
    .client-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .client-details {
        flex: 1;
    }
    
    .client-details h3 {
        margin: 0 0 0.5rem 0;
        color: #2c3e50;
        font-size: 1.2rem;
    }
    
    .client-details p {
        margin: 0 0 0.3rem 0;
        font-size: 0.95rem;
        color: #555;
        display: flex;
        align-items: center;
    }
    
    .client-details i {
        color: #4a6cf7;
        margin-right: 8px;
        width: 16px;
        text-align: center;
    }
    
    .no-phone {
        color: #dc3545;
        font-size: 0.9rem;
    }
    
    .contact-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .btn-call, .btn-whatsapp {
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .btn-call {
        background: #f0f4ff;
        color: #4a6cf7;
    }
    
    .btn-call:hover {
        background: #e0e8ff;
    }
    
    .btn-whatsapp {
        background: #25D366;
        color: white;
    }
    
    .btn-whatsapp:hover {
        background: #1da851;
    }
    
    /* Payment Summary */
    .payment-summary {
        border-top: 1px dashed #ddd;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    
    .payment-summary h4 {
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
        color: #444;
        display: flex;
        align-items: center;
    }
    
    .payment-summary h4 i {
        color: #4a6cf7;
        margin-right: 10px;
    }
    
    .payment-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .payment-row.total {
        font-weight: 600;
        color: #2c3e50;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #eee;
        font-size: 1.05rem;
    }
    
    /* Documents Card */
    .documents-card .card-body {
        padding: 0;
    }
    
    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
        padding: 1rem;
    }
    
    .document-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid #4a6cf7;
    }
    
    .document-preview {
        width: 80px;
        height: 80px;
        background: #f0f4ff;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .document-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .pdf-icon {
        font-size: 2rem;
        color: #d32f2f;
        margin-bottom: 5px;
    }
    
    .document-info {
        flex: 1;
    }
    
    .document-info h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .document-info p {
        margin: 0 0 0.5rem 0;
        font-size: 0.85rem;
        color: #666;
    }
    
    .btn-view-doc {
        display: inline-flex;
        align-items: center;
        padding: 0.3rem 0.8rem;
        background: rgba(74, 108, 247, 0.1);
        color: #4a6cf7;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-view-doc:hover {
        background: rgba(74, 108, 247, 0.2);
    }
    
    .btn-view-doc i {
        margin-right: 5px;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    
    .btn-approve, .btn-reject, .btn-back, .btn-print {
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    
    .btn-approve {
        background: #28a745;
        color: white;
    }
    
    .btn-approve:hover {
        background: #218838;
    }
    
    .btn-reject {
        background: #dc3545;
        color: white;
    }
    
    .btn-reject:hover {
        background: #c82333;
    }
    
    .btn-back {
        background: #6c757d;
        color: white;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: #5a6268;
    }
    
    .btn-print {
        background: #17a2b8;
        color: white;
    }
    
    .btn-print:hover {
        background: #138496;
    }
    
    .btn-approve i, .btn-reject i, .btn-back i, .btn-print i {
        margin-right: 8px;
    }
    
    /* Reject Modal */
    .reject-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    
    .reject-modal.active {
        display: flex;
    }
    
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .modal-content h3 {
        margin: 0 0 1.5rem 0;
        color: #2c3e50;
        font-size: 1.3rem;
    }
    
    .modal-content textarea {
        width: 100%;
        min-height: 150px;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 1.5rem;
        font-family: inherit;
        resize: vertical;
    }
    
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    
    .btn-cancel, .btn-confirm-reject {
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-cancel {
        background: #f8f9fa;
        border: 1px solid #ddd;
    }
    
    .btn-cancel:hover {
        background: #e9ecef;
    }
    
    .btn-confirm-reject {
        background: #dc3545;
        color: white;
        border: none;
    }
    
    .btn-confirm-reject:hover {
        background: #c82333;
    }
    
    /* Print Styles */
    .print-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        font-family: 'Arial', sans-serif;
        color: #333;
        background: white;
    }

    .print-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #4a6cf7;
    }

    .print-logo-container {
        margin-right: 30px;
        padding: 10px;
        border: 2px solid #4a6cf7;
        border-radius: 8px;
        background: white;
    }

    .print-logo {
        height: 80px;
        width: auto;
        display: block;
    }

    .print-company-details h1 {
        margin: 0 0 5px 0;
        color: #2c3e50;
        font-size: 28px;
        font-weight: 700;
    }

    .print-company-address {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #555;
        display: flex;
        align-items: center;
    }

    .print-company-address i {
        margin-right: 8px;
        color: #4a6cf7;
    }

    .print-company-contacts {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 13px;
        color: #666;
    }

    .print-company-contacts i {
        margin-right: 5px;
        color: #4a6cf7;
    }

    .print-title-section {
        margin-bottom: 30px;
        text-align: center;
    }

    .print-title-section h2 {
        margin: 0 0 10px 0;
        color: #2c3e50;
        font-size: 24px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .print-invoice-meta {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 15px;
    }

    .print-invoice-number {
        padding: 5px 20px;
        background: #4a6cf7;
        color: white;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .print-invoice-date {
        padding: 5px 15px;
        background: #f0f4ff;
        border-radius: 20px;
        font-weight: 500;
        font-size: 14px;
    }

    .print-info-sections {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .print-client-info, .print-agency-info {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .print-client-info h3, .print-agency-info h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-client-info h3 i, .print-agency-info h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .print-info-table td {
        padding: 5px 0;
        font-size: 14px;
        vertical-align: top;
    }

    .print-info-table td:first-child {
        font-weight: 600;
        color: #555;
        min-width: 100px;
    }

    .print-vehicle-section {
        margin-bottom: 30px;
    }

    .print-vehicle-section h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-vehicle-section h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-vehicle-details {
        display: flex;
        gap: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .print-vehicle-image {
        width: 150px;
    }

    .print-image-placeholder {
        height: 100px;
        background: #f5f7ff;
        border: 1px dashed #4a6cf7;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #4a6cf7;
    }

    .print-image-placeholder i {
        font-size: 30px;
        margin-bottom: 5px;
    }

    .print-image-placeholder span {
        font-size: 12px;
        text-align: center;
    }

    .print-vehicle-specs {
        flex: 1;
    }

    .print-specs-table {
        width: 100%;
        border-collapse: collapse;
    }

    .print-specs-table td {
        padding: 5px 0;
        font-size: 14px;
    }

    .print-specs-table td:first-child {
        font-weight: 600;
        color: #555;
        min-width: 120px;
    }

    .print-rental-period {
        margin-bottom: 30px;
    }

    .print-rental-period h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-rental-period h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-period-dates {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .print-date-card {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        width: 40%;
    }

    .print-date-card.pickup {
        background: #e3f2fd;
    }

    .print-date-card.return {
        background: #e8f5e9;
    }

    .print-date-icon {
        margin-right: 15px;
    }

    .print-date-icon i {
        font-size: 24px;
        color: #4a6cf7;
    }

    .print-date-card.return .print-date-icon i {
        color: #28a745;
    }

    .print-date-info h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #555;
        text-transform: uppercase;
    }

    .print-date-info p {
        margin: 0;
        font-size: 14px;
    }

    .print-date-info .print-date {
        font-weight: 500;
    }

    .print-date-info .print-time {
        color: #666;
    }

    .print-duration {
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        color: #4a6cf7;
        display: flex;
        flex-direction: column;
    }

    .print-duration small {
        font-size: 12px;
        color: #666;
        font-weight: normal;
    }

    .print-delivery-section {
        margin-bottom: 30px;
    }

    .print-delivery-section h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-delivery-section h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-delivery-method {
        display: inline-flex;
        align-items: center;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .print-delivery-method.pickup {
        background: #e3f2fd;
        color: #1565c0;
    }

    .print-delivery-method.delivery {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .print-delivery-method i {
        margin-right: 8px;
        font-size: 16px;
    }

    .print-delivery-address {
        margin-bottom: 15px;
    }

    .print-delivery-address h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #555;
    }

    .print-delivery-address p {
        margin: 0 0 5px 0;
        font-size: 14px;
    }

    .print-address-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #666;
    }

    .print-notes {
        padding-top: 15px;
        border-top: 1px dashed #ddd;
    }

    .print-notes h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #555;
    }

    .print-notes p {
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Documents Print Section */
    .print-documents-section {
        margin-bottom: 30px;
    }

    .print-documents-section h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-documents-section h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .print-document-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .print-document-item h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #2c3e50;
    }

    .print-document-preview {
        height: 120px;
        background: #f5f7ff;
        border: 1px dashed #4a6cf7;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .print-document-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .print-document-preview i {
        font-size: 30px;
        color: #d32f2f;
        margin-bottom: 5px;
    }

    .print-document-preview p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }

    .print-document-url {
        font-size: 10px;
        color: #666;
        word-break: break-all;
        margin: 5px 0 0 0;
    }

    /* Payment Summary */
    .print-payment-summary {
        margin-bottom: 30px;
    }

    .print-payment-summary h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-payment-summary h3 i {
        margin-right: 10px;
        font-size: 18px;
    }

    .print-payment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .print-payment-table td {
        padding: 8px 0;
        font-size: 14px;
        border-bottom: 1px solid #eee;
    }

    .print-total-row td {
        font-weight: 700;
        font-size: 15px;
        border-top: 2px solid #333;
        border-bottom: none;
    }

    .print-paid-row td {
        color: #28a745;
    }

    .print-due-row td {
        color: #dc3545;
        font-weight: 600;
    }

    /* Footer */
    .print-footer {
        margin-top: 40px;
    }

    .print-terms {
        margin-bottom: 30px;
    }

    .print-terms h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }

    .print-terms h4 i {
        margin-right: 8px;
        color: #4a6cf7;
    }

    .print-terms ol {
        margin: 0;
        padding-left: 20px;
        font-size: 12px;
        color: #555;
    }

    .print-terms li {
        margin-bottom: 5px;
    }

    .print-signature {
        margin: 40px 0;
        text-align: right;
    }

    .print-signature-line {
        width: 200px;
        height: 1px;
        background: #333;
        margin-left: auto;
        margin-bottom: 5px;
    }

    .print-signature p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }

    .print-footer-notes {
        text-align: center;
        margin-top: 30px;
    }

    .print-footer-notes p {
        margin: 0;
        font-size: 14px;
        color: #555;
    }

    .print-system-info {
        font-size: 11px;
        color: #999;
        margin-top: 5px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #printable-invoice, #printable-invoice * {
            visibility: visible;
        }
        #printable-invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }
        .print-container {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .booking-grid {
            grid-template-columns: 1fr;
        }
        
        .print-header {
            flex-direction: column;
            text-align: center;
        }
        .print-logo-wrapper {
            margin-right: 0;
            margin-bottom: 20px;
        }
        .print-info-sections {
            grid-template-columns: 1fr;
        }
        .print-period-dates {
            flex-direction: column;
            gap: 15px;
        }
        .print-date-card {
            width: 100%;
        }
    }
</style>

<script>
    // Reject Modal Handling
    document.addEventListener('DOMContentLoaded', function() {
        const rejectBtn = document.getElementById('rejectBtn');
        const cancelReject = document.getElementById('cancelReject');
        const rejectModal = document.getElementById('rejectModal');
        
        if (rejectBtn) {
            rejectBtn.addEventListener('click', function() {
                rejectModal.classList.add('active');
            });
            
            cancelReject.addEventListener('click', function() {
                rejectModal.classList.remove('active');
            });
        }
        
        // Approve Button Handling
        const approveBtn = document.getElementById('approveBtn');
        if (approveBtn) {
            approveBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to approve this booking?')) {
                    window.location.href = "{{ route('agency.bookings.approve', $booking->id) }}";
                }
            });
        }
    });
    
    // Print Invoice Function
    function printInvoice() {
        const printContent = document.getElementById('printable-invoice').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }
</script>
@endsection