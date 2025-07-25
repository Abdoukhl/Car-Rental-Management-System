@extends('car.layout')

@section('content')
<section class="vision-section py-5 position-relative" style="background: linear-gradient(to right, #0f0c29, #302b63, #24243e); color: #fff;">
    <div class="container">

        <!-- Logo -->
        <div class="text-center mb-5" data-aos="fade-down">
            <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="AETHORIA Logo" class="img-fluid logo-img">
        </div>

        <!-- Heading -->
        <div class="text-center mb-4" data-aos="zoom-in">
            <h1 class="display-4 fw-bold gradient-text">Our Vision for the Future of Car Rentals</h1>
            <p class="lead mt-3 text-muted-light">Experience trust, innovation, and luxury – all in one drive.</p>
        </div>

        <!-- Key Highlights -->
        <div class="row g-4 text-center mb-5">
            @php
                $highlights = [
                    ['icon' => 'fa-car-side', 'title' => 'Luxury Fleet', 'desc' => 'Modern, safe, and high-performance vehicles'],
                    ['icon' => 'fa-headset', 'title' => '24/7 Support', 'desc' => 'Responsive and helpful customer service'],
                    ['icon' => 'fa-file-contract', 'title' => 'Clear Contracts', 'desc' => 'Transparent pricing with no hidden fees'],
                ];
            @endphp
            @foreach($highlights as $item)
            <div class="col-md-4" data-aos="fade-up">
                <div class="feature-card p-4 h-100 text-start">
                    <div class="icon-circle mb-3">
                        <i class="fas {{ $item['icon'] }}"></i>
                    </div>
                    <h5 class="fw-bold">{{ $item['title'] }}</h5>
                    <p class="text-muted-light">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Statistics -->
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-6 col-md-3">
                <h2 class="stat-number">+50K</h2>
                <p class="text-muted-light">Trusted Users</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="stat-number">120+</h2>
                <p class="text-muted-light">Partners Across Algeria</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="stat-number">98%</h2>
                <p class="text-muted-light">Customer Satisfaction</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="stat-number">10 Yrs</h2>
                <p class="text-muted-light">Reliable Service</p>
            </div>
        </div>

        <!-- Image with Text Overlay -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="glass-box p-5 rounded-4">
                    <h3 class="fw-bold mb-4">Why Choose AETHORIA?</h3>
                    <ul class="list-unstyled text-muted-light">
                        <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Pre-inspected luxury vehicles</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Flexible pricing & seasonal offers</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Fast, secure booking process</li>
                        <li><i class="fas fa-check-circle text-warning me-2"></i> Personalized rental solutions</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="image-box position-relative">
                    <img src="https://images.unsplash.com/photo-1489824904134-891ab64532f1?auto=format&fit=crop&w=1200&q=80" alt="Luxury Car" class="img-fluid rounded-4 shadow-lg">
                    <div class="image-overlay">
                        <span>Drive Your Dreams</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1200, once: true });</script>

<!-- Styles -->
<style>
    .logo-img {
        max-height: 110px;
        filter: drop-shadow(0 0 6px #FFD700);
    }
    .gradient-text {
        background: linear-gradient(90deg, #FFD700, #9D50BB);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-muted-light {
        color: rgba(255, 255, 255, 0.75);
    }
    .feature-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: 0.3s;
    }
    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    .icon-circle {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #9D50BB, #6E48AA);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 1.5rem;
    }
    .stat-number {
        font-size: 2.2rem;
        color: #FFD700;
        font-weight: bold;
    }
    .glass-box {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .image-box {
        position: relative;
    }
    .image-overlay {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(0,0,0,0.5);
        padding: 10px 20px;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8);
    }
</style>
@endsection
