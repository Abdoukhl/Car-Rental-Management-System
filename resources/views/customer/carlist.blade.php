@extends('car.layout')


@section('content')

<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>

<style>
    :root {
        --primary: #6e8efb;
        --primary-dark: #4a6cf7;
        --secondary: #ff6b6b;
        --dark: #1a1835;
        --light: #f8f9fa;
        --gradient: linear-gradient(135deg, var(--primary), var(--primary-dark));
        --card-bg: rgba(42, 42, 64, 0.8);
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: var(--dark);
        color: white;
        min-height: 100vh;
        overflow-x: hidden;
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
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        background: linear-gradient(135deg, #FFC107, #E0A800);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .hero-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto 1.5rem;
    }
    
    /* Search & Filter Section */
    .search-section {
        background: rgba(42, 42, 64, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.2);
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.8rem;
    }
    
    .filter-group {
        margin-bottom: 0;
    }
    
    .filter-group label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 500;
        color: #FFC107;
        font-size: 0.9rem;
    }
    
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border-radius: 6px;
        border: none;
        background: rgba(30, 30, 47, 0.8);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(110, 142, 251, 0.5);
    }
    
    .search-btn {
        background: linear-gradient(135deg, #FFC107, #E0A800);
        border: none;
        border-radius: 6px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        color: #1a1a2e;
        cursor: pointer;
        transition: all 0.3s ease;
        align-self: flex-end;
        font-size: 0.9rem;
    }
    
    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }
    
    /* Cars Grid */
    .cars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.2rem;
        margin-top: 1.5rem;
    }
    
    /* Car Card */
    .car-card {
        background: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(110, 142, 251, 0.1);
        backdrop-filter: blur(5px);
        position: relative;
    }
    
    .car-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        border-color: rgba(110, 142, 251, 0.3);
    }
    
    /* Badge Styles */
    .car-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .available-badge {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
    }

    .rented-badge {
        background: linear-gradient(135deg, #F44336, #C62828);
        color: white;
    }

    .pending-badge {
        background: linear-gradient(135deg, #FF9800, #EF6C00);
        color: white;
    }

    /* Overlay for rented cars */
    .rented-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 1;
        border-radius: 12px;
    }

    /* Disabled button */
    .btn-details:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }
    
    .car-img-container {
        height: 150px;
        overflow: hidden;
        position: relative;
    }
    
    .car-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .car-card:hover .car-img {
        transform: scale(1.05);
    }
    
    .car-body {
        padding: 1rem;
        position: relative;
        z-index: 2;
    }
    
    .car-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.4rem;
        color: white;
    }
    
    .car-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
    }
    
    .car-meta-item {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
    }
    
    .car-meta-item i {
        margin-right: 0.4rem;
        color: #FFC107;
        font-size: 0.9rem;
    }
    
    .car-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #FFC107;
        margin: 0.8rem 0;
    }
    
    .car-price span {
        font-size: 0.8rem;
        font-weight: 400;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .car-rating {
        margin: 0.4rem 0;
    }
    
    .car-actions {
        margin-top: 0.8rem;
    }
    
    .btn-details {
        background: rgba(110, 142, 251, 0.2);
        color: white;
        border: 1px solid rgba(110, 142, 251, 0.5);
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
        font-size: 0.9rem;
    }
    
    .btn-details:hover {
        background: rgba(110, 142, 251, 0.4);
        color: white;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        grid-column: 1 / -1;
        padding: 2rem;
        background: rgba(42, 42, 64, 0.5);
        border-radius: 12px;
    }
    
    .no-results-icon {
        font-size: 2.5rem;
        color: #FFC107;
        margin-bottom: 0.8rem;
    }
    
    .pagination {
        display: flex;
        flex-direction: row;
        justify-content: center;
        list-style-type: none;
        padding: 10px;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-link {
        display: inline-block;
        padding: 10px 15px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-radius: 50px;
        text-decoration: none;
        color: #555;
        transition: all 0.3s ease-in-out;
        font-weight: bold;
        text-align: center;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #ddd;
        color: #aaa;
        pointer-events: none;
    }

    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
        transform: scale(1.1);
    }
    
    /* Rating Result */
    .rating-result {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(42, 42, 64, 0.95);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 1000;
        max-width: 400px;
        width: 90%;
        text-align: center;
    }
    
    .rating-success {
        color: #4CAF50;
        font-weight: 600;
    }
    
    .rating-error {
        color: #F44336;
        font-weight: 600;
    }
    
    .rating-comment-box {
        margin-top: 1rem;
    }
    
    .rating-comment-box textarea {
        width: 100%;
        padding: 0.8rem;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,0.2);
        background: rgba(30, 30, 47, 0.8);
        color: white;
        resize: vertical;
        min-height: 100px;
    }
    
    .rating-comment-box button {
        margin-top: 1rem;
        background: linear-gradient(135deg, #FFC107, #E0A800);
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        color: #1a1a2e;
        font-weight: 600;
        cursor: pointer;
    }

    /* Rating Hover Effect */
    .jq-ry-container {
        padding: 2px 0;
    }
    
    .jq-ry-normal-group svg {
        transition: all 0.2s ease;
    }
    
    .jq-ry-rated-group svg {
        transition: all 0.2s ease;
    }
    
    /* Chat Assistant */
    .chat-assistant {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 350px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow: hidden;
        z-index: 999;
        font-family: 'Poppins', sans-serif;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
        max-height: 500px;
        display: flex;
        flex-direction: column;
    }
    
    .chat-assistant.active {
        transform: translateY(0);
        opacity: 1;
    }
    
    .chat-header {
        background: linear-gradient(135deg, #6e8efb, #4a6cf7);
        color: white;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    
    .chat-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    
    .chat-toggle {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }
    
    .chat-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-height: 400px;
    }
    
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background: #f9f9f9;
    }
    
    .message {
        margin-bottom: 12px;
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.4;
        position: relative;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .bot-message {
        background: white;
        color: #333;
        border: 1px solid #e0e0e0;
        align-self: flex-start;
        border-bottom-left-radius: 5px;
    }
    
    .user-message {
        background: #6e8efb;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 5px;
        margin-left: auto;
    }
    
    .quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 10px 15px;
        background: #f1f1f1;
        border-top: 1px solid #e0e0e0;
    }
    
    .quick-reply {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .quick-reply:hover {
        background: #6e8efb;
        color: white;
        border-color: #6e8efb;
    }
    
    .chat-input-container {
        display: flex;
        border-top: 1px solid #e0e0e0;
        background: white;
    }
    
    .chat-input {
        flex: 1;
        padding: 12px 15px;
        border: none;
        outline: none;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
    }
    
    .chat-send-btn {
        background: #6e8efb;
        border: none;
        color: white;
        padding: 0 15px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .chat-send-btn:hover {
        background: #5b77d8;
    }
    
    .typing-indicator {
        display: inline-block;
        padding: 10px 15px;
        background: white;
        border-radius: 18px;
        border: 1px solid #e0e0e0;
        margin-bottom: 12px;
    }
    
    .typing-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #6e8efb;
        border-radius: 50%;
        margin: 0 2px;
        animation: typingAnimation 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) { animation-delay: 0s; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typingAnimation {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }
    
    /* أنماط جديدة لسيارات المحادثة */
    .chat-car-suggestion {
        background: white;
        border-radius: 10px;
        padding: 12px;
        margin: 8px 0;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #e0e0e0;
        position: relative;
        overflow: hidden;
    }

    .chat-car-suggestion::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(110, 142, 251, 0.1), rgba(74, 108, 247, 0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .chat-car-suggestion:hover::after {
        opacity: 1;
    }

    .chat-car-suggestion:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #6e8efb;
    }

    .chat-car-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        font-size: 15px;
    }

    .chat-car-details {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #666;
        margin-bottom: 3px;
    }

    .chat-car-price {
        color: #FFC107;
        font-weight: bold;
        font-size: 13px;
    }

    .chat-car-feature {
        display: flex;
        align-items: center;
        margin-right: 8px;
    }

    .chat-car-feature i {
        margin-right: 4px;
        font-size: 11px;
        color: #6e8efb;
    }

    .chat-car-features {
        display: flex;
        flex-wrap: wrap;
        margin-top: 5px;
    }

    .chat-car-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .chat-car-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #4CAF50;
        color: white;
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
    }
    
    .chat-launcher {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6e8efb, #4a6cf7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        cursor: pointer;
        z-index: 998;
        transition: all 0.3s ease;
    }
    
    .chat-launcher:hover {
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .filter-grid {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 1.5rem 1rem;
        }
        
        .hero-title {
            font-size: 1.8rem;
        }
        
        .cars-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
        
        .chat-assistant {
            width: 300px;
            right: 15px;
            bottom: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .main-container {
            padding: 1rem;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .cars-grid {
            grid-template-columns: 1fr;
        }
        
        .hero-title {
            font-size: 1.6rem;
        }
        
        .chat-assistant {
            width: calc(100% - 30px);
            right: 15px;
            bottom: 80px;
        }
    }
</style>

<!-- Chat Launcher -->
<div class="chat-launcher" id="chatLauncher">
    <i class="fas fa-robot"></i>
</div>

<!-- Chat Assistant -->
<div style="color: #1a1835" class="chat-assistant" id="chatAssistant">
    <div class="chat-header" id="chatHeader">
        <h4><i class="fas fa-robot me-2"></i>Rental Assistant</h4>
        <button class="chat-toggle" id="chatToggle">
            <i class="fas fa-minus"></i>
        </button>
    </div>
    <div class="chat-body">
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                Welcome to our car rental service! How can I help you find your perfect car today? Here are some quick suggestions:
            </div>
            <div class="quick-replies" id="quickReplies">
                <div class="quick-reply" onclick="sendQuickReply('Show me available cars in algiers')">Available in algiers</div>
                <div class="quick-reply" onclick="sendQuickReply('I need an electric car')">Electric Cars</div>
                <div class="quick-reply" onclick="sendQuickReply('Show me luxury cars')">Luxury Cars</div>
                <div class="quick-reply" onclick="sendQuickReply('Show me familial cars')">familial Cars</div>
            </div>
        </div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="userInput" placeholder="Ask me about cars... (e.g., 'Show electric cars in Algiers')" />
            <button class="chat-send-btn" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <h1 class="hero-title">Available Cars for Rent</h1>
        <p class="hero-subtitle">Choose from a wide range of luxury, family and economy cars</p>
    </section>
    
    <!-- Search & Filter Section -->
    <section class="search-section animate__animated animate__fadeInUp">
        <form action="{{ route('customer.carlist') }}" method="GET" id="searchForm">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="agency"><i class="fas fa-building me-2"></i>Agency</label>
                    <select name="agency" id="agency">
                        <option value="">All Agencies</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="city"><i class="fas fa-map-marker-alt me-2"></i>City</label>
                    <select name="city" id="city" class="form-select">
                        <option value="">All Cities</option>
                        <option value="adrar" {{ request('city') == 'adrar' ? 'selected' : '' }}>01 - Adrar</option>
                        <option value="chlef" {{ request('city') == 'chlef' ? 'selected' : '' }}>02 - Chlef</option>
                        <option value="laghouat" {{ request('city') == 'laghouat' ? 'selected' : '' }}>03 - Laghouat</option>
                        <option value="oum_el_bouaghi" {{ request('city') == 'oum_el_bouaghi' ? 'selected' : '' }}>04 - Oum El Bouaghi</option>
                        <option value="batna" {{ request('city') == 'batna' ? 'selected' : '' }}>05 - Batna</option>
                        <option value="bejaia" {{ request('city') == 'bejaia' ? 'selected' : '' }}>06 - Béjaïa</option>
                        <option value="biskra" {{ request('city') == 'biskra' ? 'selected' : '' }}>07 - Biskra</option>
                        <option value="bechar" {{ request('city') == 'bechar' ? 'selected' : '' }}>08 - Béchar</option>
                        <option value="blida" {{ request('city') == 'blida' ? 'selected' : '' }}>09 - Blida</option>
                        <option value="bouira" {{ request('city') == 'bouira' ? 'selected' : '' }}>10 - Bouira</option>
                        <option value="tamanrasset" {{ request('city') == 'tamanrasset' ? 'selected' : '' }}>11 - Tamanrasset</option>
                        <option value="tebessa" {{ request('city') == 'tebessa' ? 'selected' : '' }}>12 - Tébessa</option>
                        <option value="tlemcen" {{ request('city') == 'tlemcen' ? 'selected' : '' }}>13 - Tlemcen</option>
                        <option value="tiaret" {{ request('city') == 'tiaret' ? 'selected' : '' }}>14 - Tiaret</option>
                        <option value="tizi_ouzou" {{ request('city') == 'tizi_ouzou' ? 'selected' : '' }}>15 - Tizi Ouzou</option>
                        <option value="algiers" {{ request('city') == 'algiers' ? 'selected' : '' }}>16 - algiers</option>
                        <option value="djelfa" {{ request('city') == 'djelfa' ? 'selected' : '' }}>17 - Djelfa</option>
                        <option value="jijel" {{ request('city') == 'jijel' ? 'selected' : '' }}>18 - Jijel</option>
                        <option value="setif" {{ request('city') == 'setif' ? 'selected' : '' }}>19 - Sétif</option>
                        <option value="saida" {{ request('city') == 'saida' ? 'selected' : '' }}>20 - Saïda</option>
                        <option value="skikda" {{ request('city') == 'skikda' ? 'selected' : '' }}>21 - Skikda</option>
                        <option value="sidi_bel_abbes" {{ request('city') == 'sidi_bel_abbes' ? 'selected' : '' }}>22 - Sidi Bel Abbès</option>
                        <option value="annaba" {{ request('city') == 'annaba' ? 'selected' : '' }}>23 - Annaba</option>
                        <option value="guelma" {{ request('city') == 'guelma' ? 'selected' : '' }}>24 - Guelma</option>
                        <option value="constantine" {{ request('city') == 'constantine' ? 'selected' : '' }}>25 - Constantine</option>
                        <option value="medea" {{ request('city') == 'medea' ? 'selected' : '' }}>26 - Médéa</option>
                        <option value="mostaganem" {{ request('city') == 'mostaganem' ? 'selected' : '' }}>27 - Mostaganem</option>
                        <option value="msila" {{ request('city') == 'msila' ? 'selected' : '' }}>28 - M'Sila</option>
                        <option value="mascara" {{ request('city') == 'mascara' ? 'selected' : '' }}>29 - Mascara</option>
                        <option value="ouargla" {{ request('city') == 'ouargla' ? 'selected' : '' }}>30 - Ouargla</option>
                        <option value="oran" {{ request('city') == 'oran' ? 'selected' : '' }}>31 - Oran</option>
                        <option value="el_bayadh" {{ request('city') == 'el_bayadh' ? 'selected' : '' }}>32 - El Bayadh</option>
                        <option value="illizi" {{ request('city') == 'illizi' ? 'selected' : '' }}>33 - Illizi</option>
                        <option value="bordj_bou_arreridj" {{ request('city') == 'bordj_bou_arreridj' ? 'selected' : '' }}>34 - Bordj Bou Arréridj</option>
                        <option value="boumerdes" {{ request('city') == 'boumerdes' ? 'selected' : '' }}>35 - Boumerdès</option>
                        <option value="el_tarf" {{ request('city') == 'el_tarf' ? 'selected' : '' }}>36 - El Tarf</option>
                        <option value="tindouf" {{ request('city') == 'tindouf' ? 'selected' : '' }}>37 - Tindouf</option>
                        <option value="tissemsilt" {{ request('city') == 'tissemsilt' ? 'selected' : '' }}>38 - Tissemsilt</option>
                        <option value="el_oued" {{ request('city') == 'el_oued' ? 'selected' : '' }}>39 - El Oued</option>
                        <option value="khenchela" {{ request('city') == 'khenchela' ? 'selected' : '' }}>40 - Khenchela</option>
                        <option value="soukahras" {{ request('city') == 'soukahras' ? 'selected' : '' }}>41 - Souk Ahras</option>
                        <option value="tipaza" {{ request('city') == 'tipaza' ? 'selected' : '' }}>42 - Tipaza</option>
                        <option value="mila" {{ request('city') == 'mila' ? 'selected' : '' }}>43 - Mila</option>
                        <option value="ain_defla" {{ request('city') == 'ain_defla' ? 'selected' : '' }}>44 - Aïn Defla</option>
                        <option value="naama" {{ request('city') == 'naama' ? 'selected' : '' }}>45 - Naâma</option>
                        <option value="ain_temouchent" {{ request('city') == 'ain_temouchent' ? 'selected' : '' }}>46 - Aïn Témouchent</option>
                        <option value="ghardaia" {{ request('city') == 'ghardaia' ? 'selected' : '' }}>47 - Ghardaïa</option>
                        <option value="relizane" {{ request('city') == 'relizane' ? 'selected' : '' }}>48 - Relizane</option>
                        <option value="timimoun" {{ request('city') == 'timimoun' ? 'selected' : '' }}>49 - Timimoun</option>
                        <option value="bordj_badji_mokhtar" {{ request('city') == 'bordj_badji_mokhtar' ? 'selected' : '' }}>50 - Bordj Badji Mokhtar</option>
                        <option value="ouled_djellal" {{ request('city') == 'ouled_djellal' ? 'selected' : '' }}>51 - Ouled Djellal</option>
                        <option value="beni_abbes" {{ request('city') == 'beni_abbes' ? 'selected' : '' }}>52 - Béni Abbès</option>
                        <option value="in_salah" {{ request('city') == 'in_salah' ? 'selected' : '' }}>53 - In Salah</option>
                        <option value="in_guezzam" {{ request('city') == 'in_guezzam' ? 'selected' : '' }}>54 - In Guezzam</option>
                        <option value="touggourt" {{ request('city') == 'touggourt' ? 'selected' : '' }}>55 - Touggourt</option>
                        <option value="djanet" {{ request('city') == 'djanet' ? 'selected' : '' }}>56 - Djanet</option>
                        <option value="el_mghair" {{ request('city') == 'el_mghair' ? 'selected' : '' }}>57 - El M'Ghair</option>
                        <option value="el_menia" {{ request('city') == 'el_menia' ? 'selected' : '' }}>58 - El Menia</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="model"><i class="fas fa-car me-2"></i>Model</label>
                    <input type="text" name="model" id="model" value="{{ request('model') }}" placeholder="Search by model">
                </div>
                
                <div class="filter-group">
                    <label for="fuel_type"><i class="fas fa-gas-pump me-2"></i>Fuel Type</label>
                    <select name="fuel_type" id="fuel_type">
                        <option value="">All</option>
                        <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                        <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                        <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="status"><i class="fas fa-info-circle me-2"></i>Status</label>
                    <select name="status" id="status">
                        <option value="">All</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    </select>
                </div>
                
                <button type="submit" class="search-btn">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </div>
        </form>
    </section>
    
    <!-- Cars Grid -->
    <div class="cars-grid">
        @if ($cars->isEmpty())
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="fas fa-car-crash"></i>
                </div>
                <h3>No cars matching your search</h3>
                <p>Try adjusting your search criteria</p>
            </div>
        @else
            @foreach ($cars as $car)
                <div class="car-card animate__animated animate__fadeInUp">
                    @if($car->bookings->count() > 0)
                        @php
                            $currentBooking = $car->bookings->first();
                            $badgeText = '';
                            $badgeClass = '';
                            
                            if ($currentBooking->status == 'Confirmed') {
                                $badgeText = 'Rented until '. \Carbon\Carbon::parse($currentBooking->end_date)->format('d/m/Y');
                                $badgeClass = 'rented-badge';
                            } elseif ($currentBooking->status == 'Pending Payment') {
                                $badgeText = 'Pending Payment';
                                $badgeClass = 'pending-badge';
                            } elseif ($currentBooking->status == 'Pending Approval') {
                                $badgeText = 'Pending Approval';
                                $badgeClass = 'pending-badge';
                            }
                        @endphp
                        
                        <span class="car-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                        <div class="rented-overlay"></div>
                    @else
                        <span class="car-badge available-badge">Available</span>
                    @endif
                    
                    <div class="car-img-container">
                        <img src="{{ asset('images/' . $car->picture) }}" alt="{{ $car->model }}" class="car-img">
                    </div>
                    
                    <div class="car-body">
                        <h3 class="car-title">{{ $car->brand }} {{ $car->model }}</h3>
                        
                        <div class="car-meta">
                            <div class="car-meta-item">
                                <i class="fas fa-building"></i>
                                <span>{{ $car->agency->name }}</span>
                            </div>
                            <div class="car-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $car->agency->city }}</span>
                            </div>
                        </div>
                        
                        <div class="car-meta">
                            <div class="car-meta-item">
                                <i class="fas fa-gas-pump"></i>
                                <span>
                                    @if($car->fuel_type == 'petrol') Petrol
                                    @elseif($car->fuel_type == 'diesel') Diesel
                                    @elseif($car->fuel_type == 'electric') Electric
                                    @elseif($car->fuel_type == 'hybrid') Hybrid
                                    @endif
                                </span>
                            </div>
                            <div class="car-meta-item">
                                <i class="fas fa-leaf"></i>
                                <span>{{ $car->eco_friendly ? 'Eco-friendly' : 'Not eco-friendly' }}</span>
                            </div>
                        </div>
                        
                        <div class="car-price">
                            {{ number_format($car->daily_rate, 0) }} DZD <span>/ day</span>
                        </div>
                        
                        <div class="car-rating">
                            <div class="rateyo" id="rating-{{ $car->id }}" 
                                 data-rateyo-rating="{{ $car->average_rating ?? 0 }}"
                                 data-rateyo-star-width="18px"
                                 data-rateyo-read-only="{{ !auth()->check() }}"
                                 data-rateyo-spacing="4px"></div>
                            <small class="text-muted">({{ $car->ratings_count ?? 0 }} ratings)</small>
                        </div>
                        
                        <div class="car-actions">
                            @if($car->bookings->count() > 0)
                                <button class="btn-details" disabled>
                                    <i class="fas fa-times-circle me-2"></i>Not Available
                                </button>
                            @else
                                <a href="{{ route('car.show', $car->id) }}" class="btn-details">
                                    <i class="fas fa-info-circle me-2"></i>Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Pagination -->
    @if ($cars->hasPages())
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($cars->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $cars->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                    @if ($page == $cars->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                    </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($cars->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $cars->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif

    <!-- Rating Result Container -->
    <div id="ratingResult"></div>

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

            // Initialize star ratings with hover effect
            $(".rateyo").each(function() {
                $(this).rateYo({
                    rating: $(this).data("rateyo-rating"),
                    starWidth: $(this).data("rateyo-star-width"),
                    fullStar: true,
                    ratedFill: "#FFC107",
                    normalFill: "#444",
                    spacing: $(this).data("rateyo-spacing"),
                    readOnly: $(this).data("rateyo-read-only"),
                    onSet: function(rating, rateYoInstance) {
                        if (!$(rateYoInstance.node).data("rateyo-read-only")) {
                            let carId = $(rateYoInstance.node).attr("id").split("-")[1];
                            showRatingModal(carId, rating);
                        }
                    }
                });
            });

            // Show rating modal function
            function showRatingModal(carId, rating) {
                $("#ratingResult").html(`
                    <div class="rating-result animate__animated animate__fadeIn">
                        <h4>Rate this car</h4>
                        <p>You rated: ${rating} stars</p>
                        <div class="rating-comment-box">
                            <textarea id="ratingComment" placeholder="Add your comment (optional)"></textarea>
                            <button onclick="submitRating(${carId}, ${rating})">Submit Rating</button>
                            <button onclick="$('#ratingResult').empty();" style="background: rgba(255,255,255,0.1); color: white; margin-left: 10px;">Cancel</button>
                        </div>
                    </div>
                `);
            }

            // Animate cards on scroll
            function animateOnScroll() {
                $('.car-card').each(function() {
                    let cardTop = $(this).offset().top;
                    let windowBottom = $(window).scrollTop() + $(window).height();
                    
                    if (cardTop < windowBottom - 100) {
                        $(this).addClass('animate__fadeInUp');
                    }
                });
            }
            
            // Run once on load
            animateOnScroll();
            
            // Run on scroll
            $(window).scroll(function() {
                animateOnScroll();
            });

            // Chat Assistant Functionality
            const chatLauncher = $('#chatLauncher');
            const chatAssistant = $('#chatAssistant');
            const chatToggle = $('#chatToggle');
            const chatMessages = $('#chatMessages');
            const userInput = $('#userInput');
            const quickReplies = $('#quickReplies');
            
            let isChatMinimized = false;
            
            // Show chat assistant
            setTimeout(() => {
                chatAssistant.addClass('active');
            }, 1000);
            
            // Toggle chat with launcher
            chatLauncher.on('click', function() {
                chatAssistant.toggleClass('active');
                if (chatAssistant.hasClass('active')) {
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                }
            });
            
            // Toggle minimize/expand
            chatToggle.on('click', function(e) {
                e.stopPropagation();
                isChatMinimized = !isChatMinimized;
                
                if (isChatMinimized) {
                    chatAssistant.css('height', '50px');
                    chatToggle.html('<i class="fas fa-plus"></i>');
                } else {
                    chatAssistant.css('height', '');
                    chatToggle.html('<i class="fas fa-minus"></i>');
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                }
            });
            
            // Send message on Enter key
            userInput.on('keypress', function(e) {
                if (e.which === 13) {
                    sendMessage();
                }
            });
        });

        // Submit rating function
        function submitRating(carId, rating) {
            let comment = $("#ratingComment").val();
            
            $.ajax({
                url: "{{ route('car.rate') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    car_id: carId,
                    rating: rating,
                    comment: comment
                },
                beforeSend: function() {
                    $("#ratingResult").html('<div class="rating-result animate__animated animate__fadeIn"><p>Saving your rating...</p></div>');
                },
                success: function(response) {
                    if (response.success) {
                        // Update the rating display
                        $(`#rating-${carId}`).rateYo("rating", response.average_rating);
                        $(`#rating-${carId}`).next("small").text(`(${response.ratings_count} ratings)`);
                        
                        // Show success message
                        $("#ratingResult").html(`
                            <div class="rating-result animate__animated animate__fadeIn">
                                <p class="rating-success">Thank you for your rating!</p>
                                <p>Average rating: ${response.average_rating} (${response.ratings_count} ratings)</p>
                            </div>
                        `);
                        
                        // Hide after 3 seconds
                        setTimeout(function() {
                            $("#ratingResult").empty();
                        }, 3000);
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred while saving your rating';
                    $("#ratingResult").html(`
                        <div class="rating-result animate__animated animate__fadeIn">
                            <p class="rating-error">${errorMessage}</p>
                            <p>Please try again later.</p>
                        </div>
                    `);
                }
            });
        }
        
        // Chat functions
        function sendQuickReply(message) {
            $('#userInput').val(message);
            sendMessage();
        }
        
        function sendMessage() {
            const input = $('#userInput');
            const message = input.val().trim();
            const messagesDiv = $('#chatMessages');
            
            if (message === '') return;
            
            // Add user message
            messagesDiv.append(`
                <div class="message user-message">
                    ${message}
                </div>
            `);
            
            input.val('');
            
            // Show typing indicator
            messagesDiv.append(`
                <div class="message bot-message typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            `);
            
            messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            
            // Remove quick replies while processing
            $('#quickReplies').empty();
            
            // Send to server
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => {
                // Remove typing indicator
                $('.typing-indicator').remove();
                
                // Add bot response
                if (data.car_results && data.car_results.length > 0) {
                    let carsHtml = '<div class="message bot-message">';
                    carsHtml += '<p>Here are some cars that match your request:</p>';
                    
                    data.car_results.forEach(car => {
                        carsHtml += `
                            <div class="chat-car-suggestion">
                                ${car.bookings_count > 0 ? '<span class="chat-car-badge">Rented</span>' : '<span class="chat-car-badge" style="background:#4CAF50">Available</span>'}
                                <div class="chat-car-title">${car.brand} ${car.model}</div>
                                <div class="chat-car-details">
                                    <span><i class="fas fa-map-marker-alt"></i> ${car.agency.city}</span>
                                    <span class="chat-car-price">${car.daily_rate} DZD/day</span>
                                </div>
                                <div class="chat-car-features">
                                    <div class="chat-car-feature">
                                        <i class="fas fa-gas-pump"></i>
                                        <span>${car.fuel_type}</span>
                                    </div>
                                    <div class="chat-car-feature">
                                        <i class="fas fa-building"></i>
                                        <span>${car.agency.name}</span>
                                    </div>
                                </div>
                                <a href="/car/${car.id}" class="chat-car-link"></a>
                            </div>
                        `;
                    });
                    
                    carsHtml += '</div>';
                    messagesDiv.append(carsHtml);
                } else {
                    messagesDiv.append(`
                        <div class="message bot-message">
                            ${data.reply}
                        </div>
                    `);
                }
                
                
                // Add quick replies if any
                if (data.quick_replies && data.quick_replies.length > 0) {
                    let quickRepliesHtml = '';
                    data.quick_replies.forEach(reply => {
                        quickRepliesHtml += `<div class="quick-reply" onclick="sendQuickReply('${reply}')">${reply}</div>`;
                    });
                    $('#quickReplies').html(quickRepliesHtml);
                } else {
                    // Default quick replies
                    $('#quickReplies').html(`
                        <div class="quick-reply" onclick="sendQuickReply('Show me available cars in algiers')">Available in algiers</div>
                        <div class="quick-reply" onclick="sendQuickReply('I need an electric car')">Electric Cars</div>
                        <div class="quick-reply" onclick="sendQuickReply('Show me luxury cars')">Luxury Cars</div>
                        <div class="quick-reply" onclick="sendQuickReply('Show me familial cars')">familial Cars</div>
                    `);
                }
                
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            })
            .catch(error => {
                $('.typing-indicator').remove();
                messagesDiv.append(`
                    <div class="message bot-message">
                        Sorry, I encountered an error. Please try again later.
                    </div>
                `);
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            });
        }

    </script>

@endsection