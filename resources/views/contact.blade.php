@extends('car.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Prestige Motors</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a56a7;
            --dark-blue: #0a192f;
            --light-blue: #64b5f6;
            --accent-blue: #2196f3;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --gradient: linear-gradient(135deg, var(--accent-blue) 0%, var(--primary-blue) 100%);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.8;
            color: var(--dark-gray);
            margin: 0;
            padding: 0;
            background: var(--white);
            overflow-x: hidden;
        }
        
        .hero-section {
            height: 100vh;
            min-height: 800px;
            background: linear-gradient(rgba(10, 25, 47, 0.34), rgba(10, 25, 47, 0.619)), 
            url('../images/demo/gallery/jon-flobrant-lRSChvh1Mhs-unsplash.JPG');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            max-width: 800px;
            padding: 0 20px;
            transform: translateY(-50px);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }
        
        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            line-height: 1.2;
            color: var(--white);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            font-weight: 300;
            letter-spacing: 1.5px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            color: var(--light-gray);
        }
        
        .scroll-hint {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .scroll-hint:after {
            content: '';
            display: block;
            width: 1px;
            height: 60px;
            background: rgba(255,255,255,0.5);
            margin-top: 15px;
        }
        
        .section {
            padding: 120px 0;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark-blue);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient);
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--dark-gray);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.1rem;
        }
        
        .about-intro {
            background: white;
            overflow: hidden;
        }
        
        .intro-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .intro-text {
            flex: 1;
            min-width: 400px;
            padding: 0 60px;
        }
        
        .intro-image {
            flex: 1.2;
            min-width: 400px;
            height: 600px;
            background: url('https://images.unsplash.com/photo-1504215680853-026ed2a45def?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.2);
            transform: translateX(-100px);
            opacity: 0;
            transition: all 1.2s ease;
            border-radius: 10px;
        }
        
        .intro-image.in-view {
            transform: translateX(0);
            opacity: 1;
        }
        .philosophy-section {
    background: linear-gradient(rgba(10, 25, 47, 0.438), rgba(1, 28, 69, 0.516)), 
                url('./images/demo/gallery/PH.jpg');
    background-size: 100% auto; /* أو أي قيمة تناسبك مثل 30% أو 200px */
  
    color: white;
}
        .philosophy-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 40px;
            text-align: center;
        }
        
        .philosophy-quote {
            font-size: 2.2rem;
            line-height: 1.6;
            margin-bottom: 40px;
            position: relative;
        }
        
        .philosophy-quote:before,
        .philosophy-quote:after {
            content: '"';
            font-size: 4rem;
            color: var(--light-blue);
            opacity: 0.3;
            position: absolute;
        }
        
        .philosophy-quote:before {
            top: -30px;
            left: -40px;
        }
        
        .philosophy-quote:after {
            bottom: -60px;
            right: -40px;
        }
        
        .philosophy-author {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--light-blue);
        }
        
        .experience-section {
            background: white;
        }
        
        .experience-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            padding: 0 40px;
        }
        
        .experience-card {
            flex: 1;
            min-width: 300px;
            padding: 60px 40px;
            background: white;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--accent-blue);
            transition: all 0.4s ease;
            border-radius: 10px;
        }
        
        .experience-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            background: var(--gradient);
            color: var(--white);
        }
        
        .experience-card:hover .experience-icon,
        .experience-card:hover .experience-title,
        .experience-card:hover p {
            color: var(--white);
        }
        
        .experience-icon {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 30px;
            transition: all 0.4s;
        }
        
        .experience-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: var(--dark-blue);
            transition: all 0.4s;
        }
        
        .cta-section {
            background: linear-gradient(rgba(10, 25, 47, 0.486), rgba(10, 25, 47, 0.518)), 
                        url('./images/demo/gallery/pexels-rakeshkumar-9767198.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
            padding: 180px 20px;
        }
        
        .cta-title {
            font-size: 3.5rem;
            margin-bottom: 40px;
            color: var(--white);
        }
        
        .cta-text {
            max-width: 700px;
            margin: 0 auto 60px;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            color: var(--light-gray);
        }
        
        .btn {
            display: inline-block;
            padding: 18px 45px;
            background: transparent;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            border: 2px solid var(--light-blue);
            position: relative;
            overflow: hidden;
            margin: 0 10px;
        }
        
        .btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            transition: all 0.4s ease;
            z-index: -1;
        }
        
        .btn:hover {
            color: var(--white);
        }
        
        .btn:hover:before {
            left: 0;
        }
        
        .btn-solid {
            background: var(--gradient);
            color: var(--white);
            border: 2px solid transparent;
        }
        
        .btn-solid:hover {
            background: transparent;
            border-color: var(--light-blue);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }
        
        .animate-on-scroll.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        
        .delay-1 {
            transition-delay: 0.2s;
        }
        
        .delay-2 {
            transition-delay: 0.4s;
        }
        
        .delay-3 {
            transition-delay: 0.6s;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3.5rem;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
            }
            
            .intro-content {
                flex-direction: column;
            }
            
            .intro-image {
                margin-top: 60px;
                width: 100%;
                height: 500px;
            }
            
            .experience-container {
                flex-direction: column;
            }
            
            .cta-title {
                font-size: 2.8rem;
            }
            
            .btn {
                display: block;
                margin: 20px auto !important;
                max-width: 300px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .section {
                padding: 80px 0;
            }
            
            .intro-text {
                min-width: 100%;
                padding: 0 20px;
            }
            
            .intro-image {
                min-width: 100%;
                height: 400px;
            }
            
            .philosophy-quote {
                font-size: 1.8rem;
            }
            
            .cta-title {
                font-size: 2.2rem;
            }
            
            .cta-section {
                padding: 120px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title animate-on-scroll">Prestige Motors</h1>
            <p class="hero-subtitle animate-on-scroll delay-1">Where automotive excellence meets unparalleled service. Discover the art of luxury mobility with our hand-selected collection of the world's finest vehicles.</p>
            @auth
                @if(auth()->user()->account_type === 'agency')
                    <a href="{{ route('agency.Aghome') }}" class="btn btn-solid animate-on-scroll delay-2">AGENCY DASHBOARD</a>
                @elseif(auth()->user()->account_type === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-solid animate-on-scroll delay-2">ADMIN DASHBOARD</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-solid animate-on-scroll delay-2">MY ACCOUNT</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-solid animate-on-scroll delay-2">GET STARTED</a>
            @endauth
        </div>
        <div class="scroll-hint animate-on-scroll delay-3">
            <span>Explore</span>
        </div>
    </section>

    <!-- About Intro Section -->
    <section class="section about-intro">
        <div class="intro-content">
            <div class="intro-text animate-on-scroll">
                <div class="section-title">
                    <h2>Our Legacy</h2>
                    <p>Discover what makes us the preferred choice for discerning clients</p>
                </div>
                <p>Founded on principles of excellence and passion for automotive perfection, Prestige Motors has redefined luxury car rental in the region. We don't simply provide vehicles - we curate driving experiences that inspire.</p>
                <p>Our story began with a single showroom and an uncompromising vision. Today, we stand as the preferred choice for discerning clients who demand nothing but the best. Each vehicle in our collection is meticulously maintained and presented to meet our exacting standards.</p>
                <p>What sets us apart is not just our inventory, but our dedication to crafting personalized experiences that begin long before you take the wheel and continue well after your journey ends.</p>
            </div>
            <div class="intro-image animate-on-scroll delay-1">
                <!-- Image loaded via CSS -->
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="section philosophy-section">
        <div class="philosophy-container animate-on-scroll">
            <div class="section-title">
                <h2 style="color: white;">Our Philosophy</h2>
            </div>
            <p class="philosophy-quote">True luxury is found in the details - the flawless finish, the perfect service moment, the anticipation of needs before they arise. This is the standard we live by.</p>
            <p class="philosophy-author">— Prestige Motors Founder</p>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="section experience-section">
        <div class="section-title animate-on-scroll">
            <h2>The Prestige Experience</h2>
            <p>Discover what makes our service truly exceptional</p>
        </div>
        <div class="experience-container">
            <div class="experience-card animate-on-scroll">
                <div class="experience-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="experience-title">White Glove Service</h3>
                <p>From your initial inquiry to vehicle return, experience concierge-level attention from our dedicated specialists.</p>
            </div>
            <div class="experience-card animate-on-scroll delay-1">
                <div class="experience-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="experience-title">Meticulous Selection</h3>
                <p>Each vehicle undergoes our rigorous 150-point inspection to ensure peak performance and presentation.</p>
            </div>
            <div class="experience-card animate-on-scroll delay-2">
                <div class="experience-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3 class="experience-title">Discreet Excellence</h3>
                <p>We understand the importance of privacy. Your experience with us remains completely confidential.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2 class="cta-title animate-on-scroll">Ready to Elevate Your Drive?</h2>
        <p class="cta-text animate-on-scroll delay-1">Contact our concierge team to discuss your specific requirements and discover how we can tailor the perfect driving experience for you.</p>
        
        @auth
            @if(auth()->user()->account_type === 'agency')
                <a href="{{ route('agency.dashboard') }}" class="btn btn-solid animate-on-scroll delay-2">Agency Dashboard</a>
            @else
                <a href="{{ route('customer.carlist') }}" class="btn btn-solid animate-on-scroll delay-2">Reserve Now</a>
            @endif
        @else
            <a href="{{ route('customer.carlist') }}" class="btn btn-solid animate-on-scroll delay-2">Reserve Now</a>
        @endauth
        
        <a href="{{ route('contact') }}" class="btn animate-on-scroll delay-3">Concierge Inquiry</a>
    </section>

    <script>
        // Animation on scroll functionality
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
            
            // Scroll hint functionality
            document.querySelector('.scroll-hint').addEventListener('click', () => {
                window.scrollBy({
                    top: window.innerHeight - 100,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
@endsection