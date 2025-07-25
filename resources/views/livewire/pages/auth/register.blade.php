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
use Illuminate\Support\Facades\Log;
use App\Models\Document;
new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $account_type = '';

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

    // إذا كان نوع الحساب "وكالة"، نضيف قواعد التحقق الإضافية
    if ($this->account_type === 'agency') {
        $rules['city'] = ['required', 'string', 'max:255'];
        $rules['address'] = ['required', 'string', 'max:255'];
        $rules['registration_document'] = ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'];
        $rules['phone'] = ['required', 'string', 'max:20'];
    }

    // التحقق من البيانات
    $validated = $this->validate($rules);

    // تشفير كلمة المرور
    $validated['password'] = Hash::make($validated['password']);

    // إنشاء المستخدم
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'account_type' => $validated['account_type'],
    ]);

    // إنشاء حساب زبون أو وكالة
    if ($validated['account_type'] === 'customer') {
        Customer::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    } elseif ($validated['account_type'] === 'agency') {
        // تحميل وثيقة التسجيل
        $documentPath = $this->registration_document->store('documents', 'public');


        // إنشاء الوكالة
        $agency = Agency::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'registration_document' => $documentPath,
            'phone' => $validated['phone'],
        ]);

        // حفظ الوثيقة في جدول documents
        Document::create([
            'agency_id' => $agency->id,
            'document_name' => $this->registration_document->getClientOriginalName(),
            'document_path' => $documentPath,
            'status' => 'pending',
        ]);
    }

    // إطلاق حدث التسجيل
    event(new Registered($user));

    // تسجيل دخول المستخدم
    Auth::login($user);

    // إرسال بريد الترحيب
    $user->notify(new WelcomeEmailNotification());

    // توجيه المستخدم بناءً على نوع الحساب
    if ($user->account_type === 'agency') {
        $this->redirect(route('agency.Aghome'), navigate: true);
    } else {
        $this->redirect(route('dashboard'), navigate: true);
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
            background: rgba(255, 255, 255, 0.801);
            padding: 50px;
        }
        
        .logo {
            width: 280px;
            margin-bottom: 30px;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.838));
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
            background: url('{{ asset('images/illustrations/register-illustration.svg') }}') no-repeat center;
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
            margin-bottom: 22px;
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
            padding: 13px 45px 13px 15px;
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
        
        .account-type-select {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            gap: 10px;
        }
        
        .account-type-option {
            flex: 1;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .account-type-option:hover {
            border-color: #667eea;
        }
        
        .account-type-option input {
            display: none;
        }
        
        .account-type-option input:checked + label {
            color: white;
        }
        
        .account-type-option input:checked ~ .account-type-label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        .account-type-label {
            display: block;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .register-btn {
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
            margin-top: 10px;
        }
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .login-link a {
            color: #667eea;
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
            border-color: #667eea;
        }
        
        .file-name {
            font-size: 13px;
            margin-top: 5px;
            color: #6c757d;
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
            
            .account-type-select {
                flex-direction: column;
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
                    <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                        <ul style="margin: 0; padding-left: 20px;">
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
                    </div>
                    
                    <!-- Email -->
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input wire:model="email" type="email" class="input-field" placeholder="Enter your email" required>
                    </div>
                    
                    <!-- Password -->
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <input wire:model="password" type="password" class="input-field" id="password-field" placeholder="Create a password" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="input-group">
                        <label class="input-label">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" class="input-field" placeholder="Confirm your password" required>
                    </div>
                    
                    <!-- Account Type -->
                    <div class="account-type-select">
                        <div class="account-type-option">
                            <input wire:model="account_type" type="radio" id="customer" name="account_type" value="customer" required>
                            <label for="customer" class="account-type-label">Customer</label>
                        </div>
                        <div class="account-type-option">
                            <input wire:model="account_type" type="radio" id="agency" name="account_type" value="agency" required>
                            <label for="agency" class="account-type-label">Agency</label>
                        </div>
                    </div>
                    
                    <!-- Agency Fields (Hidden by default) -->
                    <div id="agency-fields" style="display: none;">
                        <!-- City -->
                        <div class="input-group">
                            <label class="input-label">City</label>
                            <input wire:model="city" type="text" class="input-field" placeholder="Enter your city">
                        </div>
                        
                        <!-- Address -->
                        <div class="input-group">
                            <label class="input-label">Address</label>
                            <input wire:model="address" type="text" class="input-field" placeholder="Enter your address">
                        </div>
                          <!-- Phone -->
                          <div class="input-group">
                            <label class="input-label">Phone Number</label>
                            <input wire:model="phone" type="text" class="input-field" placeholder="Enter your phone number">
                        </div>
                         <!-- Agency Registration Documents -->
<div class="input-group">
    <label class="input-label">Agency Registration Documents</label>
    <small style="color: #c62828" class="text-muted d-block mb-2">
        The file must include a copy of the commercial register, the certificate of registration in the professional tax roll (Patente), a lease or ownership contract of the agency's headquarters, the certificate of affiliation with the National Social Security Fund, and a document showing the Tax Identification Number (NIF) and the Trade Register Number (RC).
    </small>
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
</div>
                      
                    </div>
                    
                    <button type="submit" class="register-btn">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </form>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Google Fonts - Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <script>
            // Password toggle functionality
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
            
            // Show/hide agency fields based on account type
            document.getElementById('customer').addEventListener('change', function() {
                document.getElementById('agency-fields').style.display = 'none';
            });
            
            document.getElementById('agency').addEventListener('change', function() {
                document.getElementById('agency-fields').style.display = 'block';
            });
            
            // Initialize based on current selection
            document.addEventListener('DOMContentLoaded', function() {
                const agencyRadio = document.getElementById('agency');
                if (agencyRadio && agencyRadio.checked) {
                    document.getElementById('agency-fields').style.display = 'block';
                }
            });
            
            // Update file name display
            document.getElementById('file-input')?.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'No file chosen';
                document.getElementById('file-name').textContent = fileName;
            });
        </script>
    </body>
</div>