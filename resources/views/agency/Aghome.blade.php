@extends('car.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLBC Car Rental</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-blue: #1a56a7;
            --dark-blue: #0a192f;
            --light-blue: #64b5f6;
            --accent-blue: #2196f3;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --black: #000000;
            --gradient: linear-gradient(135deg, var(--accent-blue) 0%, var(--primary-blue) 100%);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark-gray);
            background-color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            background-color: var(--dark-blue);
            color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .header.scrolled {
            padding: 0.5rem 0;
            background-color: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Hero Section - Enhanced */
        .hero {
            background: linear-gradient(rgba(10, 25, 47, 0.85), rgba(10, 25, 47, 0.85)), 
                        url('{{ asset("images/backgrounds/empty-underground-parking-bay.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--white);
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-top: -80px;
            padding-top: 80px;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, var(--white), transparent);
            z-index: 1;
        }
        
        .hero-content {
            max-width: 1200px;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--white);
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            line-height: 1.2;
            animation: fadeInUp 1s ease;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: var(--light-gray);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
            animation: fadeInUp 1s ease 0.2s forwards;
            opacity: 0;
        }
        
        .btn-hero {
            background: var(--gradient);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s;
            font-size: 1rem;
            display: inline-block;
            border: none;
            animation: fadeInUp 1s ease 0.4s forwards;
            opacity: 0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }
        
        .btn-hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            z-index: -1;
            transition: opacity 0.4s;
        }
        
        .btn-hero:hover::after {
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Scroll Down Indicator */
        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            animation: bounce 2s infinite;
        }
        
        .scroll-down i {
            color: var(--white);
            font-size: 1.5rem;
            opacity: 0.8;
            transition: all 0.3s;
        }
        
        .scroll-down:hover i {
            color: var(--light-blue);
            transform: scale(1.2);
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-15px) translateX(-50%);
            }
            60% {
                transform: translateY(-7px) translateX(-50%);
            }
        }
        
        /* Features Section */
        .features {
            padding: 4rem 0;
            background-color: var(--white);
            position: relative;
        }
        
        .features::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%230a192f' fill-opacity='1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z'%3E%3C/path%3E%3C/svg%3E") no-repeat center top;
            background-size: cover;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: var(--dark-blue);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--gradient);
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--dark-gray);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            z-index: -1;
            opacity: 0;
            transition: all 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            color: var(--white);
        }
        
        .feature-card:hover::before {
            opacity: 1;
        }
        
        .feature-card:hover .feature-icon,
        .feature-card:hover h3,
        .feature-card:hover p {
            color: var(--white);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        
        .feature-card h3 {
            color: var(--dark-blue);
            margin-bottom: 1rem;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        
        .feature-card p {
            color: var(--dark-gray);
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        /* Image Gallery */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 4rem 0;
            background-color: var(--light-gray);
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 250px;
            transition: all 0.3s;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: var(--white);
            padding: 1.5rem 1rem 1rem;
            text-align: center;
            transform: translateY(100%);
            transition: all 0.3s;
        }
        
        .gallery-item:hover .gallery-caption {
            transform: translateY(0);
        }
        
        .gallery-caption h3 {
            margin-bottom: 0.3rem;
            font-size: 1.2rem;
        }
        
        /* Services Section */
        .services {
            padding: 4rem 0;
            background: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                        url('{{ asset("images/backgrounds/01.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        .services::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.85);
            z-index: 0;
        }
        
        .services .container {
            position: relative;
            z-index: 1;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .service-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: var(--gradient);
            color: var(--white);
        }
        
        .service-card:hover i,
        .service-card:hover h3,
        .service-card:hover p {
            color: var(--white);
        }
        
        .service-card i {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        
        .service-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--dark-blue);
            transition: all 0.3s;
        }
        
        .service-card p {
            color: var(--dark-gray);
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        /* Additional Services */
        .additional-services {
            padding: 4rem 0;
            background: var(--dark-blue);
            color: var(--white);
            position: relative;
        }
        
        .additional-services::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z'%3E%3C/path%3E%3C/svg%3E") no-repeat center top;
            background-size: cover;
        }
        
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .service-item {
            background-color: rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            background-color: rgba(255,255,255,0.15);
        }
        
        .service-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .service-item:hover img {
            transform: scale(1.05);
        }
        
        .service-content {
            padding: 1.5rem;
        }
        
        .service-content strong {
            color: var(--light-blue);
            font-size: 1.1rem;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .service-content em {
            color: var(--light-gray);
            font-style: normal;
            display: block;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        /* Testimonials */
        .testimonials {
            padding: 4rem 0;
            background-color: var(--light-gray);
            position: relative;
        }
        
        .testimonials::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%230a192f' fill-opacity='1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z'%3E%3C/path%3E%3C/svg%3E") no-repeat center top;
            background-size: cover;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .testimonial-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .testimonial-card::before {
            content: '\201C';
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 4rem;
            color: rgba(10, 25, 47, 0.05);
            font-family: Georgia, serif;
            line-height: 1;
            z-index: 0;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .author-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
            border: 2px solid var(--accent-blue);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .author-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-info h4 {
            margin: 0;
            color: var(--dark-blue);
            font-size: 1.1rem;
        }
        
        .author-info em {
            color: var(--dark-gray);
            font-style: normal;
            font-size: 0.8rem;
            display: block;
            margin-top: 0.2rem;
        }
        
        .testimonial-card blockquote {
            position: relative;
            z-index: 1;
            font-style: italic;
            color: var(--dark-gray);
            line-height: 1.6;
            font-size: 0.9rem;
        }
        
        /* Contact Section */
        .contact {
            padding: 4rem 0;
            background-color: var(--white);
        }
        
        .contact-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        @media (min-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr 2fr;
            }
        }
        
        .contact-card, .contact-form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .contact-icon {
            width: 45px;
            height: 45px;
            background: #f0f7ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #3a86ff;
            font-size: 1rem;
        }
        
        .contact-text h4 {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.3rem;
        }
        
        .contact-text p {
            color: #666;
            margin: 0;
            line-height: 1.5;
            font-size: 0.9rem;
        }
        
        .form-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .form-control {
            border-radius: 5px;
            border: 1px solid #e1e1e1;
            padding: 0.8rem;
            transition: all 0.3s;
            width: 100%;
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            border-color: #3a86ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 134, 255, 0.25);
        }
        
        .btn-send {
            background: #3a86ff;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            cursor: pointer;
        }
        
        .btn-send:hover {
            background: #2667d4;
            transform: translateY(-2px);
        }
        
        /* Footer */
        .footer {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 4rem 0 2rem;
            position: relative;
        }
        
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .footer-about {
            margin-bottom: 2rem;
        }
        
        .footer-about img {
            max-width: 180px;
            margin-bottom: 1.5rem;
        }
        
        .footer-about p {
            color: var(--light-gray);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            color: var(--white);
            font-size: 1.1rem;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .social-links a:hover {
            color: var(--light-blue);
            transform: translateY(-3px);
            background: rgba(255,255,255,0.2);
        }
        
        .footer-links h3 {
            color: var(--white);
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-links h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--light-blue);
            border-radius: 2px;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: var(--light-gray);
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        
        .footer-links a::before {
            content: '\f054';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.6rem;
            color: var(--light-blue);
            transition: all 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--light-blue);
            transform: translateX(5px);
        }
        
        .footer-links a:hover::before {
            color: var(--white);
        }
        
        .footer-newsletter h3 {
            color: var(--white);
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-newsletter h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--light-blue);
            border-radius: 2px;
        }
        
        .footer-newsletter p {
            color: var(--light-gray);
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 0.9rem;
        }
        
        .newsletter-form {
            display: flex;
            background: var(--white);
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 0.7rem 1rem;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }
        
        .newsletter-form button {
            background: var(--gradient);
            color: var(--white);
            border: none;
            padding: 0 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .newsletter-form button:hover {
            opacity: 0.9;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: var(--light-gray);
            font-size: 0.8rem;
            position: relative;
            z-index: 1;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--gradient);
            color: var(--white);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 3px 15px rgba(0,0,0,0.2);
            transition: all 0.3s;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .back-to-top:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        
        .back-to-top i {
            font-size: 1.2rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Responsive Adjustments */
        @media (min-width: 768px) {
            .hero h1 {
                font-size: 3rem;
            }
            
            .hero p {
                font-size: 1.2rem;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
            }
        }
        
        @media (min-width: 992px) {
            .hero h1 {
                font-size: 3.5rem;
            }
            
            .hero p {
                font-size: 1.3rem;
            }
            
            .section-title h2 {
                font-size: 2.5rem;
            }
            
            .features {
                padding: 6rem 0;
            }
            
            .services {
                padding: 6rem 0;
            }
            
            .additional-services {
                padding: 6rem 0;
            }
            
            .testimonials {
                padding: 6rem 0;
            }
            
            .contact {
                padding: 6rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header (if needed) -->
    <header class="header" id="header">
        <div class="container">
            <!-- Header content can be added here -->
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="top">
        <div class="hero-content">
            <h1 class="animate__animated animate__fadeInDown">Premium Car Rental Experience</h1>
            <p>Discover the freedom of the open road with our exceptional fleet of vehicles. Whether for business or leisure, we have the perfect car for your journey.</p>
            <a href="{{ route('agency.dashboard') }}" class="btn-hero animate__animated animate__fadeInUp">Access your management panel</a>
        </div>
        <div class="scroll-down">
            <a href="#features"><i class="fas fa-chevron-down"></i></a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose AETHORIA?</h2>
                <p>We offer the best car rental experience with our premium services</p>
            </div>
            
            <div class="features-grid">
                <a  class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <h3>Vehicle Variety</h3>
                    <p>Choose from a wide range of cars for every need and budget</p>
                </a>

                <a  class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Family Friendly</h3>
                    <p>Spacious cars perfect for family trips and vacations</p>
                </a>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Round-the-clock assistance for all your rental needs</p>
                </div>

                <a  class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Insurance Included</h3>
                    <p>Drive worry-free with comprehensive insurance coverage</p>
                </a>

                <a class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Flexible Payment</h3>
                    <p>Multiple payment options to suit your convenience</p>
                </a>

                <a  class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <h3>Trusted by Thousands</h3>
                    <p>Join a growing number of satisfied renters across Algeria</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Image Gallery -->
    <section class="container">
        <div class="image-gallery">
            <div class="gallery-item">
                <img src="{{ asset('images/backgrounds/alger-2471643_1280.jpg') }}" alt="Car Rentals in the City">
                <div class="gallery-caption">
                    <h3>Car Rentals in the City</h3>
                    <p>Perfect for urban adventures</p>
                </div>
            </div>
            
            <div class="gallery-item">
                <img src="{{ asset('images/backgrounds/photo_6024068709749998579_y.jpg') }}" alt="Explore Scenic Areas">
                <div class="gallery-caption">
                    <h3>Explore Scenic Areas</h3>
                    <p>Discover beautiful landscapes</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <div class="section-title">
                <h2>Features and Services</h2>
                <p>Explore all the benefits and options we offer for your perfect rental experience</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Easy Booking Process</h3>
                    <p>Reserve your car in just a few simple steps with our user-friendly system.</p>
                </div>
                
                <div class="service-card">
                    <i class="fas fa-lock"></i>
                    <h3>Secure Transactions</h3>
                    <p>Your safety is our priority with secure payments.</p>
                </div>
                
                <div class="service-card">
                    <i class="fas fa-thumbs-up"></i>
                    <h3>Trusted by Thousands</h3>
                    <p>Join a trusted network of happy customers.</p>
                </div>
                
                <div class="service-card">
                    <i class="fas fa-tasks"></i>
                    <h3>Fleet Management</h3>
                    <p>Manage your fleet with ease and efficiency.</p>
                </div>
                
                <div class="service-card">
                    <i class="fas fa-tags"></i>
                    <h3>Exclusive Offers</h3>
                    <p>Save more with our seasonal promotions.</p>
                </div>
                
                <div class="service-card">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h3>Flexible Payments</h3>
                    <p>Pay securely with flexible options tailored for you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Services - Night Blue Edition -->
    <section class="additional-services" style="background: linear-gradient(135deg, #0a192f 0%, #172a45 50%, #1e3a8a 100%); padding: 4rem 0; position: relative; overflow: hidden;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px; position: relative; z-index: 2;">
            <div class="section-title" style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Explore Our Premium Services</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 1rem; max-width: 700px; margin: 0 auto; line-height: 1.6;">Enhance your rental experience with these exclusive services</p>
            </div>
            
            <div class="service-grid">
                <!-- Service Item 1 - Enhanced (Now Rent A Car) -->
                <div class="service-item" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; position: relative;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="{{ asset('images/backgrounds/vw-1835506_1280.jpg') }}" alt="Rent A Car" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    </div>
                    <div class="service-content" style="padding: 1.5rem; position: relative;">
                        <div style="position: absolute; top: -15px; left: 15px; background: #4cc9f0; color: white; padding: 3px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">Popular!</div>
                        <strong style="display: block; font-size: 1.2rem; color: #333; margin-bottom: 0.8rem;">Rent A Car</strong>
                        <em style="display: block; color: #666; line-height: 1.5; margin-bottom: 1rem; font-size: 0.9rem;">Find your perfect vehicle from our premium collection</em>
                        <a href="/customer/carlist" style="display: inline-block; background: linear-gradient(to right, #4361ee, #3a0ca3); color: white; padding: 8px 16px; border-radius: 30px; text-decoration: none; font-weight: bold; transition: all 0.3s; font-size: 0.9rem;">Browse Cars</a>
                    </div>
                </div>
                
                <!-- Service Item 2 - Enhanced -->
                <div class="service-item" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;">
                    <div style="height: 180px; overflow: hidden; position: relative;">
                        <img src="{{ asset('images/backgrounds/car-4760008_1280.jpg') }}" alt="Seamless Returns" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                        <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.7rem;">
                            <i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i> All Locations
                        </div>
                    </div>
                    <div class="service-content" style="padding: 1.5rem;">
                        <strong style="display: block; font-size: 1.2rem; color: #333; margin-bottom: 0.8rem;">Flexible Returns</strong>
                        <em style="display: block; color: #666; line-height: 1.5; margin-bottom: 1rem; font-size: 0.9rem;">Hassle-free returns at any of our locations</em>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 35px; height: 35px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                <i class="fas fa-clock" style="color: #6c757d; font-size: 0.9rem;"></i>
                            </div>
                            <span style="font-size: 0.8rem; color: #6c757d;">Available 24/7</span>
                        </div>
                    </div>
                </div>
                
                <!-- Service Item 3 - Enhanced -->
                <div class="service-item" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="{{ asset('images/backgrounds/car-8906098_1280.jpg') }}" alt="Loyalty Program" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    </div>
                    <div class="service-content" style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <strong style="font-size: 1.2rem; color: #333;">Loyalty Rewards</strong>
                            <div style="background: #f72585; color: white; padding: 2px 8px; border-radius: 15px; font-size: 0.7rem; font-weight: bold;">Coming Soon</div>
                        </div>
                        <em style="display: block; color: #666; line-height: 1.5; margin-bottom: 1rem; font-size: 0.9rem;">Earn points with every rental and unlock exclusive benefits</em>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 1rem; text-align: center; position: relative;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                <div style="background: #3a0ca3; color: white; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">Launching Q4 2026</div>
                            </div>
                            <div style="font-size: 0.8rem; color: #6c757d; margin-bottom: 5px;">Earn up to</div>
                            <div style="font-size: 1.2rem; font-weight: bold; color: #343a40;">2,500 <span style="font-size: 0.8rem; color: #6c757d;">points</span></div>
                            <div style="height: 4px; background: #e9ecef; border-radius: 5px; margin: 8px 0;">
                                <div style="width: 0%; height: 100%; background: linear-gradient(to right, #7209b7, #f72585); border-radius: 5px;"></div>
                            </div>
                            <div style="font-size: 0.7rem; color: #6c757d;">Per rental</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contact Us</h2>
                <p class="lead">Get in touch with our team for support, inquiries, or just to say hello</p>
            </div>
            
            <div class="contact-container">
                <!-- Contact Info Column -->
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Phone</h4>
                                <p>+00 (123) 456 7890</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Email</h4>
                                <p>support@aethoria-rental.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Working Hours</h4>
                                <p>24/7 Availability</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Location</h4>
                                <p>BARAL SALLEH, Souk Ahras, Algeria</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form Column -->
                <div class="contact-form-wrapper">
                    <div class="contact-form-card">
                        <h3 class="form-title" style="color: #2563EB">Send Us a Message:</h3>
                        <form action="{{ route('messages.store') }}" method="POST">
                            @csrf
                            <div class="form-row" style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label for="name">Your Name</label>
                                    <input type="text" id="name" name="name" class="form-control" 
                                           placeholder="Enter your name" required 
                                           value="{{ auth()->user() ? auth()->user()->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email</label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                           placeholder="Enter your email" required
                                           value="{{ auth()->user() ? auth()->user()->email : '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Your Message</label>
                                <textarea id="message" name="message" class="form-control" rows="5" 
                                          placeholder="How can we help you?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-send">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <a href="#top" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Header scroll effect
        const header = document.getElementById('header');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Animation on scroll
        const animateElements = document.querySelectorAll('.feature-card, .service-card, .service-item, .testimonial-card');
        
        const animateOnScroll = () => {
            animateElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };
        
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>

@endsection