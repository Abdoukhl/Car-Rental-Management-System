@extends('layouts.agency')

@section('title', 'Subscription Renewal')
@section('icon', 'fa-sync-alt')
@section('page-title', 'Subscription Renewal')

@section('content')
<div class="subscription-container">
    <!-- Background Particles -->
    <div id="particles-js"></div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-car me-2"></i>{{ auth()->user()->agency->name }} Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/agency/dashboard">
                            <i class="fas fa-puzzle-piece me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/car">
                            <i class="fas fa-car"></i> Manage Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/agency/subscription">
                            <i class="fas fa-sync-alt"></i> Subscription
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="subscription-content">
        <!-- Subscription Status Card -->
        <div class="subscription-card">
            <div class="card-header">
                <div class="header-gradient">
                    <h3><i class="fas fa-sync-alt me-2"></i> Subscription Renewal</h3>
                </div>
                <div class="status-indicator">
                    @if($subscription)
                        @if($subscription->status === 'active')
                            <span class="active-pulse"><i class="fas fa-circle"></i> ACTIVE</span>
                        @else
                            <span class="expired-pulse"><i class="fas fa-circle"></i> EXPIRED</span>
                        @endif
                    @else
                        <span class="expired-pulse"><i class="fas fa-circle"></i> NO SUBSCRIPTION</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($subscription)
                    <div class="status-grid">
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Current Plan</span>
                                <span class="info-value">
                                    {{ $subscription->plan === 'monthly' ? 'Monthly' : 'Yearly' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Expiration Date</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Days Remaining</span>
                                <span class="info-value">{{ $remainingDays }} days</span>
                            </div>
                        </div>
                    </div>

                    @if($remainingDays > 7)
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Your subscription is still active. You can renew now, and the new period will start after the current one ends.
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No active subscription found. Please subscribe to continue.
                    </div>
                @endif

                <!-- Renewal Form -->
                <form id="paymentForm" method="POST" action="{{ route('subscription.renew.post') }}" class="mt-4">
                    @csrf
                    <div class="plan-selection">
                        <div class="plan-option @if(!$subscription || $subscription->plan === 'monthly') active @endif" data-plan="monthly">
                            <div class="plan-radio">
                                <input type="radio" name="plan" id="monthlyPlan" value="monthly" @if(!$subscription || $subscription->plan === 'monthly') checked @endif>
                                <label for="monthlyPlan"></label>
                            </div>
                            <div class="plan-details">
                                <h4>Monthly Plan</h4>
                                <div class="plan-price">3,000 DZD</div>
                                <div class="plan-period">per month</div>
                            </div>
                        </div>

                        <div class="plan-option @if($subscription && $subscription->plan === 'yearly') active @endif" data-plan="yearly">
                            <div class="plan-radio">
                                <input type="radio" name="plan" id="yearlyPlan" value="yearly" @if($subscription && $subscription->plan === 'yearly') checked @endif>
                                <label for="yearlyPlan"></label>
                            </div>
                            <div class="plan-details">
                                <h4>Yearly Plan</h4>
                                <div class="plan-price">30,000 DZD</div>
                                <div class="plan-period">per year</div>
                                <div class="plan-savings">Save 6,000 DZD</div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-methods mt-4">
                        <h4><i class="fas fa-credit-card me-2"></i> Payment Method</h4>
                        <div class="methods-grid">
                            <div class="method-option active" data-method="chargily">
                                <img src="{{ asset('images/demo/gallery/logo2Light.jpg') }}" alt="Chargily">
                                <span>Chargily Pay</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="payment-button mt-4">
                        <i class="fas fa-sync-alt me-2"></i>
                        @if($subscription)
                            Renew Subscription
                        @else
                            Subscribe Now
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Processing Modal -->
    <div class="payment-modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-spinner fa-spin me-2"></i> Processing Payment</h3>
            </div>
            <div class="modal-body">
                <div class="processing-animation">
                    <div class="loader"></div>
                    <p>Connecting to secure payment gateway...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div class="payment-modal success" id="successModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-check-circle me-2"></i> Payment Ready</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="success-content">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h4>Payment Link Generated!</h4>
                    <p>You will be redirected to our secure payment page to complete your subscription renewal.</p>
                    <a href="#" id="paymentRedirect" class="redirect-button">
                        <i class="fas fa-external-link-alt me-2"></i> Go to Payment Page
                    </a>
                    <button class="cancel-button" onclick="closeModal()">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize countdown timer if subscription exists
    @if(isset($subscription) && $subscription)
        function startCountdown(expirationDate) {
            const expiry = new Date(expirationDate).getTime();
            const totalDuration = expiry - new Date({{ \Carbon\Carbon::parse($subscription->start_date)->getTimestamp() }} * 1000);
            
            function updateCountdown() {
                const now = new Date().getTime();
                const diff = expiry - now;
                
                if (diff <= 0) {
                    return;
                }
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
                
                const elapsed = now - (expiry - totalDuration);
                const progressPercent = (elapsed / totalDuration) * 100;
                document.getElementById('progressBar').style.width = `${progressPercent}%`;
                
                if (days < 7) {
                    document.getElementById('progressBar').classList.add('warning');
                    document.getElementById('progressBar').classList.remove('danger');
                } else if (days < 3) {
                    document.getElementById('progressBar').classList.add('danger');
                    document.getElementById('progressBar').classList.remove('warning');
                } else {
                    document.getElementById('progressBar').classList.remove('warning', 'danger');
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    @endif

    // Plan selection
    document.querySelectorAll('.plan-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.plan-option').forEach(opt => {
                opt.classList.remove('active');
            });
            
            this.classList.add('active');
            const plan = this.getAttribute('data-plan');
            document.querySelector(`input[value="${plan}"]`).checked = true;
        });
    });

    // Handle form submission
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        document.getElementById('paymentModal').style.display = 'flex';
        
        fetch(this.action, {
            method: this.method,
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('paymentModal').style.display = 'none';
            
            if (data.payment_url) {
                document.getElementById('paymentRedirect').href = data.payment_url;
                document.getElementById('successModal').style.display = 'flex';
            } else if (data.error) {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('paymentModal').style.display = 'none';
            alert('An error occurred. Please try again.');
        });
    });

    // Close modal
    function closeModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    // Redirect to payment when clicking the button
    document.getElementById('paymentRedirect').addEventListener('click', function(e) {
        e.preventDefault();
        window.open(this.href, '_blank');
        closeModal();
    });

    // Initialize particles.js
    document.addEventListener('DOMContentLoaded', function() {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#6e8efb" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#4a6cf7", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
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
</script>

<style>
    /* Add this new style for alerts */
    .alert {
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    
    .alert-info {
        background-color: rgba(74, 108, 247, 0.1);
        border-color: rgba(74, 108, 247, 0.3);
        color: #4a6cf7;
    }
    
    .alert-danger {
        background-color: rgba(231, 76, 60, 0.1);
        border-color: rgba(231, 76, 60, 0.3);
        color: #e74c3c;
    }
    
    /* Rest of your existing styles... */
    :root {
        --primary: #4a6cf7;
        --secondary: #6e8efb;
        --accent: #ff6b6b;
        --success: #2ecc71;
        --warning: #f39c12;
        --danger: #e74c3c;
        --dark: #1e1e2f;
        --light: #f8f9fa;
        --gold: #FFD700;
        --silver: #C0C0C0;
        --platinum: #E5E4E2;
    }

    /* Base Styles */
    body {
        font-family: 'Poppins', sans-serif;
        color: white;
        overflow-x: hidden;
    }

    .subscription-container {
        position: relative;
        min-height: 100vh;
        padding: 20px;
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }

    #particles-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* Navigation Styles */
    .navbar {
        background: rgba(15, 12, 41, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(110, 142, 251, 0.3);
        margin-bottom: 20px;
    }

    .navbar-brand {
        font-weight: 600;
    }

    .navbar-brand i {
        margin-right: 8px;
    }

    .dropdown-menu {
        background: #0d1114;
        border: 1px solid rgba(110, 142, 251, 0.3);
    }

    .dropdown-item {
        color: white;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: rgba(110, 142, 251, 0.1);
    }

    /* Main Content Styles */
    .subscription-content {
        position: relative;
        z-index: 1;
        max-width: 1200px;
        margin: 0 auto;
        padding-top: 20px;
    }

    /* Subscription Card */
    .subscription-card {
        background: rgba(30, 30, 47, 0.8);
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(110, 142, 251, 0.3);
        margin-bottom: 30px;
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .subscription-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    .card-header {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: white;
        padding: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .header-gradient {
        padding: 20px 25px;
        background: linear-gradient(90deg, rgba(74, 108, 247, 0.2) 0%, rgba(30, 30, 47, 0) 100%);
        position: relative;
    }

    .header-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(74, 108, 247, 0.1) 0%, transparent 100%);
        z-index: 0;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-header i {
        margin-right: 12px;
        color: var(--gold);
        font-size: 1.3rem;
    }

    .status-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        padding: 8px 20px;
        border-top-left-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
    }

    .active-pulse {
        color: var(--success);
        animation: pulseActive 2s infinite;
    }

    .expired-pulse {
        color: var(--danger);
        animation: pulseExpired 1.5s infinite;
    }

    .status-indicator i {
        margin-right: 6px;
        font-size: 0.6rem;
    }

    .card-body {
        padding: 25px;
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .status-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 15px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        border-left: 3px solid var(--primary);
    }

    .status-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.08);
    }

    .status-icon {
        width: 50px;
        height: 50px;
        background: rgba(74, 108, 247, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.2rem;
        color: var(--primary);
        flex-shrink: 0;
    }

    .status-details {
        flex: 1;
    }

    .info-title {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        font-weight: 500;
        display: block;
        margin-bottom: 5px;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        display: block;
    }

    /* Plan Selection */
    .plan-selection {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .plan-option {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(110, 142, 251, 0.2);
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .plan-option:hover {
        border-color: var(--primary);
    }

    .plan-option.active {
        border-color: var(--gold);
        background: rgba(74, 108, 247, 0.1);
    }

    .plan-radio {
        position: relative;
        margin-right: 15px;
    }

    .plan-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .plan-radio label {
        position: relative;
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid var(--primary);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .plan-radio input:checked + label {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .plan-radio input:checked + label::after {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        width: 8px;
        height: 8px;
        background-color: white;
        border-radius: 50%;
    }

    .plan-details {
        flex: 1;
    }

    .plan-details h4 {
        margin: 0 0 5px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .plan-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--gold);
    }

    .plan-period {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .plan-savings {
        font-size: 0.85rem;
        color: var(--success);
        font-weight: 500;
        margin-top: 5px;
    }

    /* Payment Methods */
    .payment-methods {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .payment-methods h4 {
        font-size: 1.1rem;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
    }

    .method-option {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(110, 142, 251, 0.2);
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .method-option:hover {
        border-color: var(--primary);
    }

    .method-option.active {
        border-color: var(--gold);
        background: rgba(74, 108, 247, 0.1);
    }

    .method-option img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    /* Payment Button */
    .payment-button {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(74, 108, 247, 0.4);
    }

    .payment-button i {
        margin-right: 10px;
    }

    /* Payment Modals */
    .payment-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        display: none;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(5px);
    }

    .payment-modal.success {
        background: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
        background: linear-gradient(135deg, #1e1e2f, #2a2a40);
        border-radius: 12px;
        width: 90%;
        max-width: 450px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        border: 1px solid rgba(110, 142, 251, 0.3);
    }

    .modal-header {
        padding: 18px 25px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .modal-header i {
        margin-right: 10px;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .close-modal:hover {
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 25px;
    }

    .processing-animation {
        text-align: center;
    }

    .loader {
        border: 5px solid rgba(255, 255, 255, 0.1);
        border-top: 5px solid var(--primary);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    .processing-animation p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
    }

    .success-content {
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--success);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .success-icon i {
        color: white;
        font-size: 2.5rem;
    }

    .success-content h4 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: white;
    }

    .success-content p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        margin-bottom: 25px;
    }

    .redirect-button {
        display: inline-block;
        padding: 12px 25px;
        background: linear-gradient(135deg, var(--success), #27ae60);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        width: 100%;
        text-align: center;
    }

    .redirect-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
    }

    .redirect-button i {
        margin-right: 8px;
    }

    .cancel-button {
        display: inline-block;
        padding: 12px 25px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
    }

    .cancel-button:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .cancel-button i {
        margin-right: 8px;
    }

    /* Animations */
    @keyframes pulseActive {
        0% { text-shadow: 0 0 5px rgba(46, 204, 113, 0.5); }
        50% { text-shadow: 0 0 15px rgba(46, 204, 113, 0.8); }
        100% { text-shadow: 0 0 5px rgba(46, 204, 113, 0.5); }
    }

    @keyframes pulseExpired {
        0% { text-shadow: 0 0 5px rgba(231, 76, 60, 0.5); }
        50% { text-shadow: 0 0 15px rgba(231, 76, 60, 0.8); }
        100% { text-shadow: 0 0 5px rgba(231, 76, 60, 0.5); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .status-grid {
            grid-template-columns: 1fr;
        }
        
        .plan-selection {
            grid-template-columns: 1fr;
        }
        
        .methods-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection