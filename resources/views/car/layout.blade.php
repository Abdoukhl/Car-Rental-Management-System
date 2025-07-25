<x-app-layout>
  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>KLBC Car Rental</title>
      
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      
      <!-- Alpine JS -->
      <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
      
      @livewireStyles
      
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
              --orange: #ff5722;
              --danger-red: #e53935;
              --sidebar-width: 280px;
              --transition-speed: 0.4s;
              --transition-easing: cubic-bezier(0.4, 0, 0.2, 1);
          }
          
          body {
              font-family: 'Poppins', sans-serif;
              background-color: var(--white);
              color: var(--dark-gray);
              margin: 0;
              padding: 0;
              line-height: 1.6;
              transition: padding-left var(--transition-speed) var(--transition-easing);
          }
          
          /* Sidebar Styles */
          .sidebar {
              height: 100vh;
              width: var(--sidebar-width);
              position: fixed;
              top: 0;
              left: calc(-1 * var(--sidebar-width));
              background-color: var(--dark-blue);
              overflow-x: hidden;
              overflow-y: auto;
              transition: transform var(--transition-speed) var(--transition-easing);
              padding-top: 20px;
              z-index: 1000;
              box-shadow: 2px 0 15px rgba(0,0,0,0.15);
              transform: translateX(0);
          }
          
          .sidebar.active {
              transform: translateX(var(--sidebar-width));
          }
          
          .sidebar a {
              padding: 14px 25px;
              text-decoration: none;
              font-size: 1rem;
              color: var(--white);
              display: flex;
              align-items: center;
              transition: all 0.3s ease;
              border-left: 4px solid transparent;
              margin: 5px 15px;
              border-radius: 6px;
          }
          
          .sidebar a:hover {
              background-color: rgba(255,255,255,0.1);
              color: var(--light-blue);
              border-left: 4px solid var(--light-blue);
              transform: translateX(5px);
          }
          
          .sidebar a i {
              width: 24px;
              text-align: center;
              margin-right: 12px;
              font-size: 1.1rem;
          }
          
          .sidebar .closebtn {
              position: absolute;
              top: 10px;
              right: 20px;
              font-size: 1.8rem;
              color: var(--white);
              opacity: 0.8;
              transition: all 0.3s ease;
          }
          
          .sidebar .closebtn:hover {
              opacity: 1;
              transform: rotate(90deg);
          }
          
          /* Sidebar overlay */
          .sidebar-overlay {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: rgba(0,0,0,0.6);
              z-index: 999;
              opacity: 0;
              visibility: hidden;
              transition: all var(--transition-speed) var(--transition-easing);
              backdrop-filter: blur(3px);
          }
          
          .sidebar-overlay.active {
              opacity: 1;
              visibility: visible;
          }
          
          /* Sidebar toggle button */
          .openbtn {
              font-size: 1.5rem;
              cursor: pointer;
              background-color: var(--dark-blue);
              border: none;
              color: var(--white);
              padding: 12px 15px;
              position: fixed;
              top: 20px;
              left: 20px;
              z-index: 1001;
              border-radius: 50%;
              transition: all 0.3s ease;
              box-shadow: 0 2px 10px rgba(0,0,0,0.2);
              width: 50px;
              height: 50px;
              display: flex;
              align-items: center;
              justify-content: center;
          }
          
          .openbtn:hover {
              background-color: var(--primary-blue);
              transform: scale(1.1);
          }
          
          /* Profile section */
          .profile-container {
              display: flex;
              align-items: center;
              padding: 20px;
              margin-bottom: 15px;
              border-bottom: 1px solid rgba(255,255,255,0.1);
              position: relative;
          }
          
          .profile-avatar {
              width: 70px;
              height: 70px;
              border-radius: 50%;
              object-fit: cover;
              border: 3px solid rgba(255,255,255,0.2);
              transition: all 0.3s ease;
              cursor: pointer;
              position: relative;
              overflow: hidden;
          }
          
          .profile-avatar:hover {
              border-color: var(--light-blue);
              transform: scale(1.05);
          }
          
          .profile-avatar-edit {
              position: absolute;
              bottom: 0;
              left: 0;
              right: 0;
              background: rgba(0,0,0,0.5);
              color: white;
              text-align: center;
              padding: 5px;
              font-size: 0.8rem;
              transform: translateY(100%);
              transition: transform 0.3s ease;
          }
          
          .profile-avatar:hover .profile-avatar-edit {
              transform: translateY(0);
          }
          
          .profile-info {
              margin-left: 15px;
              color: white;
          }
          
          .profile-name {
              font-weight: 600;
              margin-bottom: 3px;
              font-size: 1rem;
          }
          
          .profile-email {
              font-size: 0.8rem;
              opacity: 0.8;
          }
          
          /* Sidebar buttons */
          .sidebar-buttons {
              padding: 15px;
              margin-top: 10px;
          }
          
          .sidebar-btn {
              display: block;
              text-align: center;
              color: white;
              padding: 12px;
              border-radius: 6px;
              margin-bottom: 12px;
              text-decoration: none;
              font-weight: 500;
              transition: all 0.3s ease;
              display: flex;
              align-items: center;
              justify-content: center;
          }
          
          .sidebar-btn i {
              margin-right: 8px;
          }
          
          .sidebar-login-btn {
              background-color: var(--primary-blue);
          }
          
          .sidebar-login-btn:hover {
              background-color: #134a94;
              transform: translateY(-2px);
          }
          
          .sidebar-register-btn {
              background-color: var(--accent-blue);
          }
          
          .sidebar-register-btn:hover {
              background-color: #1e88e5;
              transform: translateY(-2px);
          }
          
          .logout-btn {
              background-color: var(--danger-red);
              border: none;
              width: 100%;
              padding: 12px;
              border-radius: 6px;
              color: white;
              font-weight: 500;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
              transition: all 0.3s ease;
          }
          
          .logout-btn:hover {
              background-color: #c62828;
              transform: translateY(-2px);
          }
          
          .logout-btn i {
              margin-right: 8px;
          }
          
          /* Main Content */
          .main-content {
              margin-left: 0;
           
              padding: 0px;
              transition: margin-left var(--transition-speed) var(--transition-easing);
          }
          
          /* Footer Styles */
          .footer {
              background-color: var(--dark-blue);
              color: var(--white);
              padding: 60px 0 30px;
          }
          
          .footer-container {
              max-width: 1200px;
              margin: 0 auto;
              padding: 0 20px;
              display: grid;
              grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
              gap: 30px;
          }
          
          .footer-logo {
              width: 180px;
              margin-bottom: 20px;
              border-radius: 8px;
          }
          
          .footer-section h3 {
              color: var(--white);
              font-size: 1.2rem;
              margin-bottom: 20px;
              position: relative;
              padding-bottom: 10px;
          }
          
          .footer-section h3::after {
              content: '';
              position: absolute;
              left: 0;
              bottom: 0;
              width: 50px;
              height: 2px;
              background: var(--orange);
          }
          
          .footer-links li {
              margin-bottom: 10px;
              list-style: none;
          }
          
          .footer-links a {
              color: #ccc;
              text-decoration: none;
              transition: 0.3s;
              display: flex;
              align-items: center;
          }
          
          .footer-links a:hover {
              color: var(--orange);
              transform: translateX(5px);
          }
          
          .footer-links i {
              margin-right: 8px;
              color: var(--orange);
          }
          
          .contact-info li {
              margin-bottom: 15px;
              display: flex;
              align-items: flex-start;
              color: #ccc;
          }
          
          .contact-info i {
              margin-right: 10px;
              color: var(--orange);
              margin-top: 3px;
          }
          
          .social-icons {
              display: flex;
              gap: 15px;
              margin-top: 20px;
          }
          
          .social-icons a {
              color: var(--white);
              background: rgba(255,255,255,0.1);
              width: 40px;
              height: 40px;
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;
              transition: 0.3s;
          }
          
          .social-icons a:hover {
              background: var(--orange);
              transform: translateY(-3px);
          }
          
          .payment-methods {
              display: flex;
              gap: 15px;
              margin-top: 15px;
          }
          
          .payment-methods i {
              font-size: 1.8rem;
              color: #ccc;
              transition: 0.3s;
          }
          
          .payment-methods i:hover {
              color: var(--orange);
          }
          
          .copyright {
              text-align: center;
              padding-top: 30px;
              margin-top: 30px;
              border-top: 1px solid rgba(255,255,255,0.1);
              color: #ccc;
              font-size: 0.9rem;
          }
          
          /* Profile Picture Upload Modal */
          .modal {
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0,0,0,0.7);
              z-index: 1100;
              justify-content: center;
              align-items: center;
          }
          
          .modal-content {
              background-color: var(--white);
              padding: 30px;
              border-radius: 10px;
              width: 90%;
              max-width: 500px;
              box-shadow: 0 5px 20px rgba(0,0,0,0.3);
              position: relative;
          }
          
          .close-modal {
              position: absolute;
              top: 15px;
              right: 15px;
              font-size: 1.5rem;
              color: var(--dark-gray);
              cursor: pointer;
              transition: all 0.3s ease;
          }
          
          .close-modal:hover {
              color: var(--danger-red);
              transform: rotate(90deg);
          }
          
          .upload-area {
              border: 2px dashed var(--light-gray);
              border-radius: 8px;
              padding: 30px;
              text-align: center;
              margin: 20px 0;
              cursor: pointer;
              transition: all 0.3s ease;
          }
          
          .upload-area:hover {
              border-color: var(--accent-blue);
              background-color: rgba(100, 181, 246, 0.05);
          }
          
          .upload-area i {
              font-size: 3rem;
              color: var(--accent-blue);
              margin-bottom: 15px;
          }
          
          .upload-btn {
              background-color: var(--accent-blue);
              color: white;
              border: none;
              padding: 10px 20px;
              border-radius: 5px;
              cursor: pointer;
              font-weight: 500;
              transition: all 0.3s ease;
          }
          
          .upload-btn:hover {
              background-color: var(--primary-blue);
              transform: translateY(-2px);
          }
          
          .preview-image {
              max-width: 100%;
              max-height: 200px;
              margin: 15px auto;
              display: block;
              border-radius: 5px;
          }
          
          /* Loading spinner */
          .spinner {
              animation: spin 1s linear infinite;
              display: inline-block;
          }
          
          @keyframes spin {
              from { transform: rotate(0deg); }
              to { transform: rotate(360deg); }
          }
          
          /* Responsive Design */
          @media (max-width: 768px) {
              .footer-container {
                  grid-template-columns: 1fr 1fr;
              }
          }
          
          @media (max-width: 480px) {
              .footer-container {
                  grid-template-columns: 1fr;
              }
              
              .footer-section {
                  text-align: center;
              }
              
              .footer-section h3::after {
                  left: 50%;
                  transform: translateX(-50%);
              }
              
              .social-icons, .payment-methods {
                  justify-content: center;
              }
              
              .sidebar {
                  width: 100%;
                  left: -100%;
              }
              
              .sidebar.active {
                  transform: translateX(100%);
              }
          }
      </style>
  </head>
  
  <body>
      <!-- Sidebar Toggle Button -->
      <button class="openbtn" onclick="toggleSidebar()" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
      </button>
      
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
  
      <!-- Sidebar -->
      <div id="mySidebar" class="sidebar">
          <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()" aria-label="Close navigation">
              <i class="fas fa-times"></i>
          </a>
          
          <!-- Profile Section -->
          @auth
          <div class="profile-container" style="cursor: pointer;" onclick="window.location.href='{{ route('profile') }}'">
            <div class="auth-links">
              @auth
              <div class="user-card">
                  <div class="user-icon" title="User ID: {{ Auth::id() }}">
                      <i class="fas fa-user"></i>
                      <span class="user-id">{{ Auth::id() }}</span>
                  </div>
                  <span style="color: var(--white);">
                      @if(Auth::user()->account_type === 'agency' && Auth::user()->agency)
                      <i class="fas fa-building" style="color: var(--light-blue);"></i> {{ Auth::user()->agency->name }}
                      @elseif(Auth::user()->account_type === 'customer' && Auth::user()->customer)
                      <i class="fas fa-user" style="color: var(--light-blue);"></i> {{ Auth::user()->customer->name }}
                      @else
                      <i class="fas fa-user" style="color: var(--light-blue);"></i> {{ Auth::user()->name }}
                      @endif
                  </span>
              </div>
              @endauth
          </div>
              <div class="profile-info">
                  <div class="profile-name">{{ Auth::user()->name }}</div>
                  <div class="profile-email">{{ Auth::user()->email }}</div>
              </div>
          </div>
          @else
          <div class="logo" style="text-align: center; padding: 20px 20px 30px;">
              <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" 
                   alt="Logo" 
                   style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.2);">
          </div>
          @endauth
          
          <a href="{{ Auth::check() && Auth::user()->user_type == 'agency' ? route('dashboard') : route('agency.Aghome') }}">
              <i class="fas fa-home"></i> Home
          </a>
          <a href="/customer/carlist"><i class="fas fa-car"></i> Rent</a>
          <a href="#"><i class="fas fa-info-circle"></i> About</a>
          <a href="#"><i class="fas fa-envelope"></i> Contact</a>
          @auth
              @if(auth()->user()->account_type === 'customer')
              <a href="{{ route('bookings.customer-index') }}"><i class="fas fa-calendar-alt"></i> My Bookings</a>
              @endif
          @endauth
          
          <div class="sidebar-buttons">
              @if(Auth::check())
                  <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="submit" class="logout-btn">
                          <i class="fas fa-sign-out-alt"></i> Logout
                      </button>
                  </form>
              @else
                  <a href="{{ route('login') }}" class="sidebar-btn sidebar-login-btn">
                      <i class="fas fa-sign-in-alt"></i> Login
                  </a>
                  <a href="{{ route('register') }}" class="sidebar-btn sidebar-register-btn">
                      <i class="fas fa-user-plus"></i> Register
                  </a>
              @endif
          </div>
      </div>
  
      <!-- Profile Picture Upload Modal -->
      <div id="profileModal" class="modal">
          <div class="modal-content">
              <span class="close-modal" onclick="closeProfileModal()">&times;</span>
              <h2 style="color: var(--dark-blue); margin-bottom: 20px;">Update Profile Picture</h2>
              
              @livewire('profile-photo-upload')
          </div>
      </div>
  
      <!-- Main Content -->
      <div class="main-content">
          @yield('content')
      </div>
  
      <!-- Footer -->
      <footer class="footer">
          <div class="footer-container">
              <!-- Logo and About -->
              <div class="footer-section">
                  <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Company Logo" class="footer-logo">
                  <p style="color: #ccc; margin-bottom: 20px;">AETHORIA Car Rental offers premium vehicles for your travel needs with exceptional service and competitive prices.</p>
                  <div class="social-icons">
                      <a href="#"><i class="fab fa-facebook-f"></i></a>
                      <a href="#"><i class="fab fa-twitter"></i></a>
                      <a href="#"><i class="fab fa-instagram"></i></a>
                      <a href="#"><i class="fab fa-linkedin-in"></i></a>
                  </div>
              </div>
              
              <!-- Quick Links -->
              <div class="footer-section">
                  <h3>Quick Links</h3>
                  <ul class="footer-links">
                      <li><a href="{{ route('dashboard') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                      <li><a href="/customer/carlist"><i class="fas fa-chevron-right"></i> Rent a Car</a></li>
                      <li><a href="/contact"><i class="fas fa-chevron-right"></i> About Us</a></li>
                      <li><a href="http://127.0.0.1:8000/dashboard#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
            
                  </ul>
              </div>
              
              <!-- Contact Info -->
              <div class="footer-section">
                  <h3>Contact Us</h3>
                  <ul class="contact-info">
                      <li>
                          <i class="fas fa-map-marker-alt"></i>
                          <span>380 baral saleh, Souk Ahras, Algeria</span>
                      </li>
                      <li>
                          <i class="fas fa-phone-alt"></i>
                          <span>0668362039</span>
                      </li>
                      <li>
                          <i class="fas fa-envelope"></i>
                          <span>AETHORIA@company.com</span>
                      </li>
                  </ul>
              </div>
              
              <!-- Payment Methods -->
              <div class="footer-section">
                  <h3>Payment Methods</h3>
                  <div class="payment-methods">
                      <i class="fab fa-cc-visa"></i>
                      <i class="fab fa-cc-mastercard"></i>
                      <i class="fab fa-cc-paypal"></i>
                      <i class="fab fa-cc-amazon-pay"></i>
                  </div>
                  
                  <h3 style="margin-top: 25px;">Newsletter</h3>
                  <p style="color: #ccc;">Subscribe to our newsletter for special offers</p>
                  <form style="display: flex; margin-top: 15px;">
                      <input type="email" placeholder="Your Email" style="flex: 1; padding: 10px; border: none; border-radius: 4px 0 0 4px;">
                      <button type="submit" style="background: var(--orange); color: white; border: none; padding: 0 15px; border-radius: 0 4px 4px 0; cursor: pointer;">
                          <i class="fas fa-paper-plane"></i>
                      </button>
                  </form>
              </div>
          </div>
          
         
      </footer>
  
      @livewireScripts
      <script>
          // Sidebar Toggle Function
          function toggleSidebar() {
              const sidebar = document.getElementById("mySidebar");
              const overlay = document.querySelector(".sidebar-overlay");
              const body = document.body;
              
              sidebar.classList.toggle("active");
              overlay.classList.toggle("active");
              
              if (sidebar.classList.contains("active")) {
                  body.style.overflow = "hidden";
              } else {
                  body.style.overflow = "auto";
              }
          }
  
          // Profile Modal Functions
          function openProfileModal() {
              document.getElementById('profileModal').style.display = 'flex';
              Livewire.emit('openProfilePhotoUpload');
          }
          
          function closeProfileModal() {
              document.getElementById('profileModal').style.display = 'none';
          }
          
          // Close modal when clicking outside
          window.onclick = function(event) {
              const modal = document.getElementById('profileModal');
              if (event.target == modal) {
                  closeProfileModal();
              }
          }
          
          // Listen for Livewire events
          document.addEventListener('DOMContentLoaded', function() {
              Livewire.on('profilePhotoUpdated', (photoUrl) => {
                  document.getElementById('profileAvatar').src = photoUrl + '?' + new Date().getTime();
                  closeProfileModal();
              });
          });
      </script>
  </body>
  </html>
</x-app-layout>