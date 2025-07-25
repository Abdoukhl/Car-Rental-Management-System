<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
     public function sendPasswordResetLink(): void
{
    // تحقق من البيانات المستلمة (بدون استخدام $request)
    \Log::debug('Email submitted:', ['email' => $this->email]);
    
    $this->validate([
        'email' => ['required', 'string', 'email'],
    ]);

    $status = Password::sendResetLink(
        ['email' => $this->email] // الطريقة الصحيحة لتمرير البريد
    );

    if ($status != Password::RESET_LINK_SENT) {
        \Log::error('Password reset failed:', ['status' => $status]);
        $this->addError('email', __($status));
        return;
    }

    $this->reset('email');
    session()->flash('status', __($status));
}}
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
        
        .reset-container {
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
            padding: 14px 15px;
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
        
        .reset-btn {
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
        
        .reset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .reset-btn:active {
            transform: translateY(0);
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .back-to-login a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        .status-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
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
            .reset-container {
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
        <div class="reset-container">
            <!-- Graphic Side -->
            <div class="graphic-side">
                <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Logo" class="logo">
                <h3 class="graphic-title">Forgot Your Password?</h3>
                <p class="graphic-text">No problem. Just let us know your email address and we'll email you a password reset link.</p>
                <div class="graphic-image"></div>
            </div>
            
            <!-- Form Side -->
            <div class="form-side">
                <h2 class="form-title">Reset Password</h2>
                
                @if(session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="error-message">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                
                <form wire:submit="sendPasswordResetLink">
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input wire:model="email" type="email" class="input-field" placeholder="Enter your email" required>
                    </div>
                    
                    <button type="submit" class="reset-btn">
                        <i class="fas fa-paper-plane"></i> Email Password Reset Link
                    </button>
                </form>
                
                <div class="back-to-login">
                    Remember your password? <a href="{{ route('login') }}" wire:navigate>Back to login</a>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Google Fonts - Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    </body>
</div>