@extends('layouts.agency')

@section('title', 'Subscription Management')
@section('icon', 'fa-sync-alt')
@section('page-title', 'Subscription Management')

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
                            <i class="fas fa-puzzle-piece me-2"></i> dashboard
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agency.notifications') }}">
                            <i class="fas fa-bell"></i> Notifications
                            @if($unreadNotifications > 0)
                                <span class="badge bg-danger notification-badge">{{ $unreadNotifications }}</span>
                            @endif
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
                    <h3><i class="fas fa-crown me-2"></i> Premium Subscription</h3>
                    @if($subscription)
                        <div style="right: 360px;" class="plan-badge">
                            @if($subscription->plan === 'Yearly')
                                <span class="badge-yearly"><i class="fas fa-calendar-week me-1"></i> YEARLY PLAN</span>
                            @else
                                <span class="badge-monthly"><i class="fas fa-calendar-alt me-1"></i>  MONTHLY PLAN</span>
                            @endif
                        </div>
                    @endif
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
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Plan Type</span>
                                <span class="info-value">
                                    @if($subscription->plan === 'Yearly ')
                                          Yearly Subscription  
                                 
                                    @else
                                    Monthly Subscription 
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Start Date</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($subscription->start_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Expiration Date</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="status-details">
                                <span class="info-title">Vehicles Listed</span>
                                <span class="info-value">{{ auth()->user()->agency->cars->count() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Countdown Timer -->
                    <div class="countdown-container">
                        <div class="countdown-wrapper">
                            <div class="countdown-title">
                                <i class="fas fa-clock me-2"></i> Time Remaining
                            </div>
                            <div class="countdown" id="countdown">
                                <div class="countdown-segment">
                                    <span class="segment-value" id="days">00</span>
                                    <span class="segment-label">Days</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="hours">00</span>
                                    <span class="segment-label">Hours</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="minutes">00</span>
                                    <span class="segment-label">Minutes</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="segment-value" id="seconds">00</span>
                                    <span class="segment-label">Seconds</span>
                                </div>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar" id="progressBar"></div>
                            </div>
                        </div>
                        <br>
                        <div class="status-item">
                            <div class="status-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            @php
                                $remainingDays = now()->diffInDays($subscription->end_date);
                            
                               
                            @endphp
                            <p><span class="info-title">Total Days After Renewal:</span> <span class="info-value">{{ $remainingDays}} days</span></p>
                        </div>
                        <br>
                    </div>
                @else
                    <div class="no-subscription">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> You don't have an active subscription.
                        </div>
                        <p>Please choose a subscription plan below to get started.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <div class="payment-header">
                <h3><i class="fas fa-credit-card me-2"></i> Payment Gateway</h3>
                <p>Secure payment processed through Chargily</p>
            </div>

            <form id="paymentForm" method="POST" action="{{ route('subscription.renew.post') }}">
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

                <div id="payment-section" style="position: relative; overflow: hidden;">
                    <canvas id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></canvas>
                
                    <div class="payment-methods" style="position: relative; background: rgba(255, 255, 255, 0.9); border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); margin-bottom: 25px; backdrop-filter: blur(5px); z-index: 1;">
                        <h4 style="color: #2c3e50; font-size: 1.4rem; margin-bottom: 20px; font-weight: 600; text-align: center; position: relative;">
                            Payment Method
                            <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 50px; height: 3px; background: linear-gradient(90deg, #3498db, #2ecc71); border-radius: 3px;"></span>
                        </h4>
                        
                        <div class="methods-grid" style="display: flex; justify-content: center;">
                            <div class="method-option active" 
                                 data-method="chargily"
                                 style="position: relative; text-align: center; cursor: pointer; padding: 20px; border-radius: 12px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.3s ease; overflow: hidden;">
                                
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, rgba(52, 152, 219, 0.1) 0%, transparent 70%); opacity: 0; transition: opacity 0.3s ease;"></div>
                                
                                <img src="{{ asset('images/demo/gallery/logo2Light.jpg') }}"
                                     alt="Chargily"
                                     style="max-width: 250px;
                                            width: 100%;
                                            height: auto;
                                            border-radius: 12px;
                                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                                            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
                                            position: relative;"
                                     onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 12px 28px rgba(0, 0, 0, 0.15)'; this.parentElement.querySelector('div').style.opacity='1';"
                                     onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.1)'; this.parentElement.querySelector('div').style.opacity='0';" />
                                
                                <span style="display: block; margin-top: 15px; font-size: 1.1rem; color: #3498db; font-weight: 500; position: relative;">
                                    Chargily Pay
                                    <span style="position: absolute; bottom: -5px; left: 0; width: 100%; height: 2px; background: #2ecc71; transform: scaleX(0); transition: transform 0.3s ease; transform-origin: center;"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                
                    <button type="submit" 
                            class="payment-button"
                            style="position: relative;
                                   background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
                                   color: white;
                                   border: none;
                                   padding: 15px 30px;
                                   font-size: 1.1rem;
                                   border-radius: 50px;
                                   cursor: pointer;
                                   display: block;
                                   width: 100%;
                                   max-width: 300px;
                                   margin: 25px auto 0;
                                   box-shadow: 0 5px 15px rgba(41, 128, 185, 0.4);
                                   transition: all 0.3s ease;
                                   font-weight: 600;
                                   overflow: hidden;
                                   z-index: 1;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(41, 128, 185, 0.6)'; this.querySelector('span').style.opacity='1'; this.querySelector('span').style.transform='rotate(30deg) translate(20px, -40px)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(41, 128, 185, 0.4)'; this.querySelector('span').style.opacity='0'; this.querySelector('span').style.transform='rotate(30deg) translate(-20px, -40px)';">
                        <i class="fas fa-lock" style="margin-right: 10px;"></i> 
                        @if($subscription)
                            Renew Subscription
                        @else
                            Subscribe Now
                        @endif
                        <span style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%); transform: rotate(30deg) translate(-20px, -40px); transition: all 0.7s ease; opacity: 0;"></span>
                    </button>
                </div>
            </form>
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
                    document.getElementById('days').textContent = '00';
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';
                    document.getElementById('progressBar').style.width = '100%';
                    document.getElementById('progressBar').classList.add('expired');
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
                
                animateValueChanges();
            }
            
            function animateValueChanges() {
                const segments = document.querySelectorAll('.segment-value');
                segments.forEach(segment => {
                    if (segment.dataset.prevValue && segment.dataset.prevValue !== segment.textContent) {
                        segment.classList.add('changed');
                        setTimeout(() => segment.classList.remove('changed'), 500);
                    }
                    segment.dataset.prevValue = segment.textContent;
                });
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        startCountdown('{{ $subscription->end_date }}');
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
    /* Add this new style for no subscription message */
    .no-subscription {
        text-align: center;
        padding: 30px;
    }
    
    .no-subscription .alert {
        max-width: 500px;
        margin: 0 auto 20px;
    }
    
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

    .plan-badge {
        position: absolute;
        top: 20px;
        right: 25px;
        z-index: 1;
    }

    .badge-monthly, .badge-yearly {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
    }

    .badge-monthly {
        background: rgba(52, 152, 219, 0.2);
        border: 1px solid rgba(52, 152, 219, 0.5);
        color: #3498db;
    }

    .badge-yearly {
        background: rgba(46, 204, 113, 0.2);
        border: 1px solid rgba(46, 204, 113, 0.5);
        color: #2ecc71;
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

    /* Countdown Timer */
    .countdown-container {
        margin-top: 20px;
    }

    .countdown-wrapper {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(110, 142, 251, 0.2);
    }

    .countdown-title {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .countdown {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        gap: 10px;
    }

    .countdown-segment {
        flex: 1;
        position: relative;
    }

    .segment-value {
        display: block;
        font-size: 2.2rem;
        font-weight: 700;
        color: white;
        background: rgba(74, 108, 247, 0.2);
        border-radius: 8px;
        padding: 15px 0;
        margin-bottom: 5px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .segment-value::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(74, 108, 247, 0.4) 0%, transparent 100%);
        z-index: 0;
    }

    .segment-value.changed {
        animation: valueChange 0.5s ease;
    }

    .segment-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
    }

    .progress-container {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        margin-top: 20px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 3px;
        transition: width 1s linear;
        position: relative;
    }

    .progress-bar.warning {
        background: linear-gradient(90deg, var(--warning), #f1c40f);
    }

    .progress-bar.danger {
        background: linear-gradient(90deg, var(--danger), #c0392b);
    }

    .progress-bar.expired {
        background: linear-gradient(90deg, #7f8c8d, #95a5a6);
    }

    /* Payment Section */
    .payment-section {
        background: rgba(30, 30, 47, 0.8);
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(110, 142, 251, 0.2);
        overflow: hidden;
    }

    .payment-header {
        padding: 18px 25px;
        background: linear-gradient(135deg, #2a2a40, #1e1e2f);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .payment-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .payment-header i {
        margin-right: 10px;
        color: var(--gold);
    }

    .payment-header p {
        margin: 5px 0 0;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    #paymentForm {
        padding: 25px;
    }

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

    .payment-methods {
        margin-bottom: 25px;
    }

    .payment-methods h4 {
        font-size: 1.1rem;
        margin-bottom: 15px;
        font-weight: 600;
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
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
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
        height: 30px;
        margin-bottom: 8px;
    }

    .method-option span {
        font-size: 0.9rem;
    }

    .payment-button {
        width: 100%;
        padding: 14px;
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

    @keyframes valueChange {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); box-shadow: 0 0 15px rgba(74, 108, 247, 0.5); }
        100% { transform: scale(1); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulseWarning {
        0% { box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(243, 156, 18, 0); }
        100% { box-shadow: 0 0 0 0 rgba(243, 156, 18, 0); }
    }

    @keyframes pulseDanger {
        0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(231, 76, 60, 0); }
        100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
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
        
        .countdown {
            flex-wrap: wrap;
        }
        
        .countdown-segment {
            flex: 0 0 calc(50% - 10px);
            margin-bottom: 10px;
        }
        
        .segment-value {
            font-size: 1.8rem;
            padding: 10px 0;
        }
    }
</style>
@endsection