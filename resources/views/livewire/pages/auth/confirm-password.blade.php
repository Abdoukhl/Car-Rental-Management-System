<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

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
        
        .confirm-container {
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
            width: 280px;
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
        
        .confirm-btn {
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
        
        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .confirm-btn:active {
            transform: translateY(0);
        }
        
        .info-message {
            background: #e3f2fd;
            color: #1565c0;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #1565c0;
        }
        
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
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
            .confirm-container {
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
        <div class="confirm-container">
            <!-- Graphic Side -->
            <div class="graphic-side">
                <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Logo" class="logo">
                <h3 class="graphic-title">Security Check</h3>
                <p class="graphic-text">This is a secure area of the application. Please confirm your identity to continue.</p>
                <div class="graphic-image"></div>
            </div>
            
            <!-- Form Side -->
            <div class="form-side">
                <h2 class="form-title">Confirm Password</h2>
                
                <div class="info-message">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>
                
                @if($errors->any())
                    <div class="error-message">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                
                <form wire:submit="confirmPassword">
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <input wire:model="password" type="password" class="input-field" id="password-field" placeholder="Enter your password" required autocomplete="current-password">
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                    </div>
                    
                    <button type="submit" class="confirm-btn">
                        <i class="fas fa-shield-alt"></i> Confirm
                    </button>
                </form>
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