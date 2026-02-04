<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Agency;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Notifications\WelcomeEmailNotification;
use App\Models\Document;

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $account_type = 'customer'; // Set default to customer

    // حقول خاصة بالوكالة
    public string $city = '';
    public string $address = '';
    public $registration_document;
    public string $phone = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // قواعد التحقق
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:customer,agency'],
        ];

        if ($this->account_type === 'agency') {
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['registration_document'] = ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'];
            $rules['phone'] = ['required', 'string', 'max:20'];
        }

        $validated = $this->validate($rules);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'account_type' => $validated['account_type'],
        ]);

        if ($validated['account_type'] === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } elseif ($validated['account_type'] === 'agency') {
            $documentPath = $this->registration_document->store('documents', 'public');

            $agency = Agency::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'city' => $validated['city'],
                'address' => $validated['address'],
                'registration_document' => $documentPath,
                'phone' => $validated['phone'],
            ]);

            Document::create([
                'agency_id' => $agency->id,
                'document_name' => $this->registration_document->getClientOriginalName(),
                'document_path' => $documentPath,
                'status' => 'pending',
            ]);
        }

        event(new Registered($user));
        Auth::login($user);
        $user->notify(new WelcomeEmailNotification());

        if ($user->account_type === 'agency') {
            $this->redirect(route('agency.Aghome'), navigate: true);
        } else {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }
};
?>
<div x-data="{ account_type: 'customer' }">
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
            background: url('{{ asset('images/illustrations/register-illustration.svg') }}') no-repeat center;
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
        
        .account-type-select {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .account-type-option {
            flex: 1;
            min-width: 120px;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .account-type-option:hover {
            border-color: var(--primary-color);
        }
        
        .account-type-option input {
            display: none;
        }
        
        .account-type-label {
            display: block;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-color);
        }
        
        .account-type-option input:checked + .account-type-label {
            background: var(--primary-gradient);
            color: white;
            border-color: var(--primary-color);
        }
        
        .register-btn {
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
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--light-text);
        }
        
        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .file-input {
            display: none;
        }
        
        .file-label {
            display: block;
            padding: 12px;
            border: 2px dashed #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-label:hover {
            border-color: var(--primary-color);
        }
        
        .file-name {
            font-size: 13px;
            margin-top: 5px;
            color: var(--light-text);
            word-break: break-all;
        }
        
        .document-requirements {
            font-size: 12px;
            color: var(--error-color);
            margin-bottom: 8px;
            line-height: 1.4;
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
        
        .error-alert ul {
            margin: 0;
            padding-left: 20px;
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
            
            .account-type-option {
                min-width: calc(50% - 10px);
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
            
            .account-type-select {
                flex-direction: column;
            }
            
            .account-type-option {
                width: 100%;
                min-width: 100%;
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
        <div class="login-container">
            <!-- Graphic Side -->
            <div class="graphic-side">
                <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Logo" class="logo">
                <h3 class="graphic-title">Join Us Today!</h3>
                <p class="graphic-text">Create an account to access exclusive features and services tailored just for you.</p>
                <div class="graphic-image"></div>
            </div>
            
            <!-- Form Side -->
            <div class="form-side">
                <h2 class="form-title">Create Account</h2>
                
                @if($errors->any())
                    <div class="error-alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form wire:submit.prevent="register">
                    <!-- Name -->
                    <div class="input-group">
                        <label class="input-label">Full Name</label>
                        <input wire:model="name" type="text" class="input-field" placeholder="Enter your full name" required>
                        @error('name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <!-- Email -->
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input wire:model="email" type="email" class="input-field" placeholder="Enter your email" required>
                        @error('email') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <input wire:model="password" type="password" class="input-field" id="password-field" placeholder="Create a password" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                        @error('password') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="input-group">
                        <label class="input-label">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" class="input-field" placeholder="Confirm your password" required>
                    </div>
                    
                    <!-- Account Type -->
                    <div class="account-type-select">
                        <div class="account-type-option">
                            <input wire:model="account_type" x-model="account_type" type="radio" id="customer" name="account_type" value="customer" required>
                            <label for="customer" class="account-type-label">Customer</label>
                        </div>
                        <div class="account-type-option">
                            <input wire:model="account_type" x-model="account_type" type="radio" id="agency" name="account_type" value="agency" required>
                            <label for="agency" class="account-type-label">Agency</label>
                        </div>
                    </div>
                    @error('account_type') <div class="error-message">{{ $message }}</div> @enderror
                    
                    <!-- Agency Fields -->
                    <div x-show="account_type === 'agency'" x-transition>
                        <!-- City -->
                        <div class="input-group">
                            <label class="input-label">City</label>
                            <input wire:model="city" type="text" class="input-field" placeholder="Enter your city">
                            @error('city') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Address -->
                        <div class="input-group">
                            <label class="input-label">Address</label>
                            <input wire:model="address" type="text" class="input-field" placeholder="Enter your address">
                            @error('address') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Phone -->
                        <div class="input-group">
                            <label class="input-label">Phone Number</label>
                            <input wire:model="phone" type="text" class="input-field" placeholder="Enter your phone number">
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Agency Registration Documents -->
                        <div class="input-group">
                            <label class="input-label">Agency Registration Documents</label>
                            <div class="document-requirements">
                                The file must include a copy of the commercial register, the certificate of registration in the professional tax roll (Patente), a lease or ownership contract of the agency's headquarters, the certificate of affiliation with the National Social Security Fund, and a document showing the Tax Identification Number (NIF) and the Trade Register Number (RC).
                            </div>
                            <input wire:model="registration_document" type="file" id="file-input" class="file-input" accept=".pdf,.doc,.docx">
                            <label for="file-input" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i> Click to upload documents
                                <div class="file-name" id="file-name">
                                    @if($registration_document)
                                        {{ $registration_document->getClientOriginalName() }}
                                    @else
                                        No file chosen
                                    @endif
                                </div>
                            </label>
                            @error('registration_document') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="register-btn">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </form>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}" wire:navigate>Login here</a>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Google Fonts - Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password toggle functionality
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

                // Update file name display
                const fileInput = document.getElementById('file-input');
                if (fileInput) {
                    fileInput.addEventListener('change', function(e) {
                        const fileName = e.target.files[0]?.name || 'No file chosen';
                        const fileNameElement = document.getElementById('file-name');
                        if (fileNameElement) {
                            fileNameElement.textContent = fileName;
                        }
                    });
                }
            });
        </script>
    </body>
</div>