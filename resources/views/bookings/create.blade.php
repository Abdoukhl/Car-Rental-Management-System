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
    
    /* Booking Card */
    .booking-card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 2.5rem;
        margin: 0 auto;
        max-width: 600px;
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
    
    .form-label {
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        background: rgba(30, 30, 47, 0.8);
        border: none;
        border-radius: 8px;
        padding: 0.9rem 1.2rem;
        color: var(--text-primary);
        width: 100%;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    
    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.3);
    }
    
    #total_amount {
        background: rgba(30, 30, 47, 0.8);
        color: var(--gold);
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .alert {
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.2);
        border: 1px solid rgba(220, 53, 69, 0.5);
        color: #ff6b6b;
    }
    
    .alert-info {
        background-color: rgba(13, 110, 253, 0.2);
        border: 1px solid rgba(13, 110, 253, 0.5);
        color: #6e8efb;
    }
    
    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .btn {
        border: none;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
        font-size: 1rem;
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
    
    .text-danger {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: -1rem;
        margin-bottom: 1rem;
        display: block;
    }
    
    /* تنسيقات حقول رفع الملفات */
    .form-control[type="file"] {
        padding: 0.5rem;
        background: rgba(30, 30, 47, 0.5);
    }
    
    .form-control[type="file"]::file-selector-button {
        background: var(--gold);
        color: var(--dark);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        margin-right: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .form-control[type="file"]::file-selector-button:hover {
        background: var(--gold-dark);
    }
    
    .text-muted {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 0.8rem;
        display: block;
        margin-top: 0.5rem;
    }
    
    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1050;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal.show {
        display: block;
    }
    
    .modal-dialog {
        position: relative;
        width: auto;
        margin: 0.5rem;
        max-width: 500px;
        pointer-events: none;
        transition: transform 0.3s ease-out;
    }
    
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }
    
    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: var(--card-bg);
        background-clip: padding-box;
        border: 1px solid rgba(110, 142, 251, 0.3);
        border-radius: 15px;
        outline: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
    }
    
    .modal-header {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .modal-title {
        margin-bottom: 0;
        line-height: 1.5;
        color: var(--gold);
        font-weight: 600;
        font-size: 1.5rem;
        text-align: center;
        width: 100%;
    }
    
    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 2rem 1.5rem;
        color: var(--text-secondary);
        text-align: center;
    }
    
    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        gap: 1rem;
    }
    
    .close {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: white;
        text-shadow: 0 1px 0 #fff;
        opacity: 0.8;
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
    }
    
    #warning-message {
        margin: -0.5rem 0 1.5rem;
        padding: 1rem;
        font-size: 0.9rem;
    }
    
    .success-icon {
        font-size: 4rem;
        color: var(--gold);
        margin-bottom: 1.5rem;
        animation: bounceIn 0.6s ease-out;
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.5); opacity: 0; }
        50% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); }
    }
    
    /* Responsive */
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }
        
        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem);
        }
    }
    
    @media (max-width: 768px) {
        .main-container {
            padding: 1.5rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .booking-card {
            padding: 1.5rem;
        }
        
        .btn-group {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }
        
        .form-control {
            padding: 0.8rem 1rem;
        }
        
        .btn {
            padding: 0.9rem 1rem;
            font-size: 0.95rem;
        }
        
        .modal-footer {
            flex-direction: column;
        }
    }
</style>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <h1 class="hero-title">Book {{ $car->brand }} {{ $car->model }}</h1>
        <p class="hero-subtitle">Complete your booking details and upload required documents</p>
    </section>
    
    <!-- Booking Card -->
    <div class="booking-card animate__animated animate__fadeInUp">
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
        @endif
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Please upload clear copies of all required documents. After submitting, you will be redirected to complete the payment.
        </div>
        
        <form action="{{ route('bookings.store', $car->id) }}" method="POST" id="bookingForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required 
                       min="{{ date('Y-m-d') }}" value="{{ old('start_date') }}">
                @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('end_date') }}">
                @error('end_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Required Documents Section -->
            <div class="mb-4">
                <label class="form-label">Required Documents</label>
                
                <!-- Driving License -->
                <div class="mb-3">
                    <label for="driving_license" class="form-label">Driving License Copy</label>
                    <input type="file" name="driving_license" id="driving_license" class="form-control" required accept="image/*,.pdf">
                    <small class="text-muted">Upload a clear copy of your valid driving license (JPEG, PNG, JPG or PDF, max 2MB)</small>
                    @error('driving_license')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- ID Proof -->
                <div class="mb-3">
                    <label for="id_proof" class="form-label">ID Card/Passport Copy</label>
                    <input type="file" name="id_proof" id="id_proof" class="form-control" required accept="image/*,.pdf">
                    <small class="text-muted">Upload a copy of your national ID card or passport (JPEG, PNG, JPG or PDF, max 2MB)</small>
                    @error('id_proof')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Residence Proof -->
                <div class="mb-3">
                    <label for="residence_proof" class="form-label">Residence Proof</label>
                    <input type="file" name="residence_proof" id="residence_proof" class="form-control" required accept="image/*,.pdf">
                    <small class="text-muted">Upload a recent utility bill or residence certificate (JPEG, PNG, JPG or PDF, max 2MB)</small>
                    @error('residence_proof')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Total Amount</label>
                <input type="text" id="total_amount" class="form-control" readonly>
                <input type="hidden" name="calculated_amount" id="calculated_amount">
            </div>

            <div id="warning-message" class="alert-danger" style="display: none;">
                <i class="fas fa-exclamation-triangle me-2"></i> Please enter valid dates. The end date must be after the start date.
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-calendar-check"></i> Proceed to Payment
                </button>
                
                <a href="{{ route('car.show', $car->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Details
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Confirmation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p id="modalMessage">Your booking request has been submitted successfully!</p>
                <p class="text-muted">You will be redirected to the payment page shortly.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <a id="paymentLink" href="#" class="btn btn-primary">
                    <i class="fas fa-credit-card me-2"></i>Proceed to Payment
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

        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalAmountInput = document.getElementById('total_amount');
        const calculatedAmountInput = document.getElementById('calculated_amount');
        const warningMessage = document.getElementById('warning-message');
        const submitBtn = document.getElementById('submitBtn');
        const dailyRate = {{ $car->daily_rate }};

        function calculateTotalAmount() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && endDate > startDate) {
                const timeDiff = endDate - startDate;
                const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                const totalAmount = daysDiff * dailyRate;
                totalAmountInput.value = totalAmount.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'DZD',
                    minimumFractionDigits: 2
                });
                calculatedAmountInput.value = totalAmount.toFixed(2);
                warningMessage.style.display = 'none';
                submitBtn.disabled = false;
            } else {
                totalAmountInput.value = '';
                calculatedAmountInput.value = '';
                warningMessage.style.display = 'block';
                submitBtn.disabled = true;
            }
        }

        startDateInput.addEventListener('change', function() {
            if (this.value) {
                const minEndDate = new Date(this.value);
                minEndDate.setDate(minEndDate.getDate() + 1);
                endDateInput.min = minEndDate.toISOString().split('T')[0];
                
                if (endDateInput.value && new Date(endDateInput.value) < minEndDate) {
                    endDateInput.value = '';
                }
            }
            calculateTotalAmount();
        });

        endDateInput.addEventListener('change', calculateTotalAmount);
        submitBtn.disabled = true;

        if (startDateInput.value && endDateInput.value) {
            calculateTotalAmount();
        }

        // التحقق من الملفات المرفوعة قبل الإرسال
        function validateFiles() {
            const files = [
                document.getElementById('driving_license').files.length,
                document.getElementById('id_proof').files.length,
                document.getElementById('residence_proof').files.length
            ];
            
            return files.every(count => count > 0);
        }

        // Handle form submission
        $('#bookingForm').on('submit', function(e) {
            if (!validateFiles()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Documents',
                    text: 'Please upload all required documents before proceeding.',
                });
                return;
            }

            const form = $(this);
            const submitBtn = $('#submitBtn');
            
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    
                    if (data.payment_url) {
                        $('#paymentLink').attr('href', data.payment_url);
                        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                        modal.show();
                        
                        // Auto-redirect after 5 seconds if user doesn't click
                        setTimeout(function() {
                            if ($('#confirmationModal').is(':visible')) {
                                window.location.href = data.payment_url;
                            }
                        }, 5000);
                    } else {
                        throw new Error('Payment URL is missing');
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="fas fa-calendar-check me-2"></i> Proceed to Payment');
                }
            });
        });
    });
    
    function closeModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
        if (modal) {
            modal.hide();
        }
        window.location.href = "{{ route('customer.bookings') }}";
    }
</script>
@endsection