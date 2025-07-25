<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // توجيه المستخدم بناءً على نوع الحساب
        if (!Auth::user()->account_type) {
            session()->flash('error', 'Your account type is not defined.');
            return;
        }

        // توجيه المستخدم بناءً على نوع الحساب
        if (Auth::user()->account_type === 'agency') {
            $this->redirectIntended(default: route('agency.Aghome'), navigate: true);
        } elseif (Auth::user()->account_type === 'admin') {
            $this->redirectIntended(default: route('admin.dashboard'), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard'), navigate: true);
        }
    }
};
?>
<div>
    <style>
        body {
            background: url('{{ asset('images/backgrounds/modern-background-with-geometrical-shapes.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        .login-container {
            position: relative;
            z-index: 10;
            width: 800px;
            max-width: 90%;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s ease-out;
        }
        
        .graphic-side {
            width: 45%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        
        .form-side {
            width: 55%;
            background: rgba(255, 255, 255, 0.811);
            padding: 50px;
        }
        
        .logo {
            width: 280px; /* Increased from 120px */
            margin-bottom: 30px;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.849));
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .graphic-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .graphic-text {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .graphic-image {
            width: 180px;
            height: 180px;
            background: url('{{ asset('images/illustrations/login-illustration.svg') }}') no-repeat center;
            background-size: contain;
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
            position: relative;
        }
        
        .form-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin-top: 10px;
            border-radius: 2px;
        }
        
        .input-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .input-field {
            width: 100%;
            padding: 14px 45px 14px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            color: #6c757d;
            transition: all 0.3s;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0 30px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: #667eea;
        }
        
        .forgot-password {
            color: #667eea;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .graphic-side, .form-side {
                width: 100%;
            }
            
            .graphic-side {
                padding: 30px;
            }
            
            .form-side {
                padding: 30px;
            }
            
            .logo {
                width: 160px;
            }
        }
    </style>

    <body>
        <div class="login-container">
            <!-- Graphic Side -->
            <div class="graphic-side">
                <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Logo" class="logo">
                <h3 class="graphic-title">Welcome Back!</h3>
                <p class="graphic-text">Sign in to access your personalized dashboard, settings, and more.</p>
                <div class="graphic-image"></div>
            </div>
            
            <!-- Form Side -->
            <div class="form-side">
                <h2 class="form-title">Login to your account</h2>
                
                @if(session('error'))
                    <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form wire:submit="login">
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input wire:model="form.email" type="email" class="input-field" placeholder="Enter your email" required>
                        @error('form.email') <div style="color: #c62828; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <input wire:model="form.password" type="password" class="input-field" id="password-field" placeholder="Enter your password" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                        @error('form.password') <div style="color: #c62828; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input wire:model="form.remember" type="checkbox" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password" wire:navigate>Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Google Fonts - Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Password Toggle Script -->
        <script>
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordField = document.getElementById('password-field');
                const icon = this;
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        </script>
    </body>
</div>