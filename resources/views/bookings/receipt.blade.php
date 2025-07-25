<div id="receipt{{ $booking->id }}" class="printable-receipt">
    <div class="print-container">
        <!-- Header -->
        <div class="print-header">
            <div class="print-logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="print-logo">
            </div>
            <div class="print-company-info">
                <h1>AETHORIA RENTAL</h1>
                <p class="print-company-address">123 Business Avenue, Algiers, Algeria</p>
                <div class="print-company-contacts">
                    <span><i class="fas fa-phone"></i> +213 123 456 789</span>
                    <span><i class="fas fa-envelope"></i> contact@aethoria.dz</span>
                    <span><i class="fas fa-globe"></i> www.aethoria.dz</span>
                </div>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="print-title-section">
            <h2>RENTAL RECEIPT</h2>
            <div class="print-invoice-number">
                REC-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <!-- Invoice Meta -->
        <div class="print-meta-info">
            <div class="print-meta-item">
                <span class="print-meta-label">Issued Date:</span>
                <span class="print-meta-value">{{ $booking->created_at->format('d M Y') }}</span>
            </div>
            <div class="print-meta-item">
                <span class="print-meta-label">Rental Status:</span>
                <span class="print-status-badge {{ strtolower($booking->status) }}">{{ $booking->status }}</span>
            </div>
        </div>

        <!-- Client and Agency Info -->
        <div class="print-info-grid">
            <div class="print-info-card client">
                <h3><i class="fas fa-user-tie"></i> CLIENT INFORMATION</h3>
                <div class="print-info-content">
                    <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $booking->delivery_phone ?? 'N/A' }}</p>
                </div>
            </div>
            
            <div class="print-info-card agency">
                <h3><i class="fas fa-building"></i> AGENCY INFORMATION</h3>
                <div class="print-info-content">
                    <p><strong>Agency:</strong> {{ $booking->car->agency->name }}</p>
                    <p><strong>Address:</strong> {{ $booking->car->agency->address }}</p>
                    <p><strong>Contact:</strong> {{ $booking->car->agency->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div class="print-vehicle-section">
            <h3><i class="fas fa-car"></i> VEHICLE DETAILS</h3>
            <div class="print-vehicle-details">
               
                <div class="print-vehicle-specs">
                    <div class="print-spec-row">
                        <span class="print-spec-label">Brand/Model:</span>
                        <span class="print-spec-value">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                    </div>
                   
                    <div class="print-spec-row">
                        <span class="print-spec-label">Daily Rate:</span>
                        <span class="print-spec-value">{{ number_format($booking->car->daily_rate, 2) }} DZD</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Period -->
        <div class="print-rental-period">
            <h3><i class="fas fa-calendar-alt"></i> RENTAL PERIOD</h3>
            <div class="print-period-dates">
                <div class="print-date-card pickup">
                    <div class="print-date-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="print-date-details">
                        <h4>PICKUP DATE</h4>
                        <p>{{ $booking->start_date->format('d M Y h:i A') }}</p>
                    </div>
                </div>
                
                <div class="print-duration">
                    {{ $booking->start_date->diffInDays($booking->end_date) }} DAYS
                </div>
                
                <div class="print-date-card return">
                    <div class="print-date-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div class="print-date-details">
                        <h4>RETURN DATE</h4>
                        <p>{{ $booking->end_date->format('d M Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="print-payment-summary">
            <h3><i class="fas fa-receipt"></i> PAYMENT SUMMARY</h3>
            <table class="print-payment-table">
                <tr>
                    <td>Subtotal:</td>
                    <td>{{ number_format($booking->total_amount, 2) }} DZD</td>
                </tr>
                <tr>
                    <td>Delivery Fee:</td>
                    <td>0.00 DZD</td>
                </tr>
                <tr class="print-total-row">
                    <td>Total Amount:</td>
                    <td>{{ number_format($booking->total_amount, 2) }} DZD</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="print-footer">
            <div class="print-terms">
                <h4>TERMS & CONDITIONS</h4>
                <ol>
                    <li>Payment is due upon vehicle pickup/delivery</li>
                    <li>Cancellation must be made 24 hours prior to rental</li>
                    <li>Late returns will incur additional charges</li>
                    <li>Fuel policy: full-to-full</li>
                </ol>
            </div>
            
            <div class="print-signature">
                <div class="print-signature-line"></div>
                <p>Authorized Signature</p>
            </div>
            
            <div class="print-footer-meta">
                <p>Receipt generated on {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Print-specific styles */
    .printable-receipt {
        display: none;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        .printable-receipt, .printable-receipt * {
            visibility: visible;
        }
        .printable-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
            margin: 0;
            background: white;
            color: black;
        }
    }

    .print-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Arial', sans-serif;
        color: #333;
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
    }

    .print-logo {
        height: 80px;
        width: auto;
    }

    .print-company-info h1 {
        margin: 0 0 5px 0;
        color: #2c3e50;
        font-size: 24px;
    }

    .print-company-address {
        margin: 0 0 8px 0;
        font-size: 14px;
    }

    .print-company-contacts {
        display: flex;
        gap: 15px;
        font-size: 13px;
    }

    .print-title-section {
        margin-bottom: 30px;
        text-align: center;
    }

    .print-title-section h2 {
        margin: 0 0 10px 0;
        color: #2c3e50;
        font-size: 20px;
        text-transform: uppercase;
    }

    .print-invoice-number {
        padding: 5px 20px;
        background: #4a6cf7;
        color: white;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
    }

    .print-meta-info {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 20px;
    }

    .print-meta-item {
        font-size: 14px;
    }

    .print-meta-label {
        font-weight: 600;
    }

    .print-status-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .print-status-badge.confirmed {
        background: #e6f7e6;
        color: #28a745;
    }

    .print-status-badge.pending {
        background: #fff8e6;
        color: #ffc107;
    }

    .print-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .print-info-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
    }

    .print-info-card h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #4a6cf7;
        display: flex;
        align-items: center;
    }

    .print-info-card h3 i {
        margin-right: 10px;
    }

    .print-info-content p {
        margin: 5px 0;
        font-size: 14px;
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

    .print-vehicle-image img {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .print-image-placeholder {
        height: 100px;
        background: #f5f5f5;
        border: 1px dashed #ccc;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }

    .print-vehicle-specs {
        flex: 1;
    }

    .print-spec-row {
        display: flex;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .print-spec-label {
        font-weight: 600;
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

    .print-date-details h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #555;
    }

    .print-date-details p {
        margin: 0;
        font-size: 14px;
    }

    .print-duration {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #4a6cf7;
    }

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
    }

    .print-payment-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
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

    .print-footer {
        margin-top: 40px;
    }

    .print-terms {
        margin-bottom: 30px;
    }

    .print-terms h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
    }

    .print-terms ol {
        margin: 0;
        padding-left: 20px;
        font-size: 12px;
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
    }

    .print-footer-meta {
        text-align: center;
        font-size: 12px;
        color: #666;
    }
</style>