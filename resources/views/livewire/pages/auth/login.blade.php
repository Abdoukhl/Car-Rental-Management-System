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
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --text-color: #2c3e50;
            --light-text: #6c757d;
            --input-bg: rgba(255, 255, 255, 0.9);
            --form-bg: rgba(255, 255, 255, 0.95);
            --error-color: #c62828;
            --shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            background: url('{{ asset('images/backgrounds/modern-background-with-geometrical-shapes.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }
        
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 900px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: fadeInUp 0.6s ease-out;
            min-height: 550px;
        }
        
        .graphic-side {
            width: 45%;
            background: var(--primary-gradient);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .form-side {
            width: 55%;
            background: var(--form-bg);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            width: 100%;
            max-width: 280px;
            margin-bottom: 30px;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .graphic-title {
            font-size: clamp(20px, 2vw, 24px);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .graphic-text {
            font-size: clamp(12px, 1.2vw, 14px);
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .graphic-image {
            width: 100%;
            max-width: 180px;
            height: 180px;
            background: url('{{ asset('images/illustrations/login-illustration.svg') }}') no-repeat center;
            background-size: contain;
        }
        
        .form-title {
            font-size: clamp(22px, 2.5vw, 28px);
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 30px;
            position: relative;
        }
        
        .form-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 4px;
            background: var(--primary-gradient);
            margin-top: 10px;
            border-radius: 2px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 8px;
        }
        
        .input-field {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: var(--input-bg);
        }
        
        .input-field:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            color: var(--light-text);
            transition: all 0.3s;
            font-size: 16px;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0 25px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: var(--primary-color);
        }
        
        .forgot-password {
            color: var(--primary-color);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--light-text);
        }
        
        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 13px;
            margin-top: 5px;
        }
        
        .error-alert {
            background: #ffebee;
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--error-color);
            font-size: 14px;
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
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                min-height: auto;
                max-width: 500px;
            }
            
            .graphic-side, .form-side {
                width: 100%;
                padding: 30px 25px;
            }
            
            .graphic-side {
                padding-bottom: 20px;
            }
            
            .form-side {
                padding-top: 30px;
            }
            
            .logo {
                max-width: 180px;
                margin-bottom: 20px;
            }
            
            .graphic-image {
                max-width: 120px;
                height: 120px;
                margin-bottom: 10px;
            }
            
            .form-title {
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .login-container {
                border-radius: 15px;
            }
            
            .graphic-side, .form-side {
                padding: 25px 20px;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .forgot-password {
                margin-top: 10px;
            }
            
            .input-field {
                padding: 12px 35px 12px 12px;
            }
            
            .password-toggle {
                right: 10px;
            }
        }
    </style>

    <body>
    <div style="direction: rtl; background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; padding: 15px; margin: 20px 0; border-radius: 8px; font-family: 'Tajawal', sans-serif; text-align: right;">
    <div style="background: #fee2e2; color: #991b1b; padding: 8px 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
        ⚠️ هذا الحساب مؤقت ومخصص للفحص فقط
    </div>
    <strong>ملاحظة مهمة للمصحح:</strong><br>
    في حال رغبت بفتح جزء <strong>الإدارة (Admin)</strong> يرجى استعمال الحساب التالي:<br>
    <ul style="margin: 8px 15px 0 0; padding: 0;">
        <li><strong>البريد الإلكتروني:</strong> khialabderrahman@gmail.com</li>
        <li><strong>كلمة المرور:</strong> 36329720</li>
    </ul>
</div>




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
                    <div class="error-alert">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form wire:submit="login">
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input wire:model="form.email" type="email" class="input-field" placeholder="Enter your email" required>
                        @error('form.email') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <input wire:model="form.password" type="password" class="input-field" id="password-field" placeholder="Enter your password" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                        @error('form.password') <div class="error-message">{{ $message }}</div> @enderror
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
                    Don't have an account? <a href="{{ route('register') }}" wire:navigate>Sign up</a>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Google Fonts - Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Password Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePassword = document.getElementById('toggle-password');
                if (togglePassword) {
                    togglePassword.addEventListener('click', function() {
                        const passwordField = document.getElementById('password-field');
                        if (passwordField) {
                            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordField.setAttribute('type', type);
                            this.classList.toggle('fa-eye-slash');
                        }
                    });
                }
            });
        </script>
    </body>
</div>