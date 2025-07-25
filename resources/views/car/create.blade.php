<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        
        .form-container {
            position: relative;
            z-index: 10;
            width: 900px;
            max-width: 90%;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s ease-out;
        }
        
        .graphic-side {
            width: 40%;
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
            width: 60%;
            background: rgba(255, 255, 255, 0.811);
            padding: 50px;
        }
        
        .logo {
            width: 220px;
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
            background: url('{{ asset('images/illustrations/car-illustration.svg') }}') no-repeat center;
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
            margin-bottom: 20px;
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
            padding: 12px 15px;
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
        
        .select-field {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: rgba(255, 255, 255, 0.9);
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
        
        .select-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .submit-btn {
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
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .cancel-btn {
            width: 100%;
            padding: 15px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            color: #495057;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        
        .cancel-btn:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        
        .file-field {
            width: 100%;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .file-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }
        
        .subscription-warning {
            color: #dc3545;
            font-weight: bold;
            margin-top: 5px;
            font-size: 14px;
        }
        
        .readonly-field {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        
        .features-container {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .feature-checkbox {
        flex: 1;
    }
    
    .feature-checkbox input[type="checkbox"] {
        display: none;
    }
    
    .feature-checkbox label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 12px;
        background-color: rgba(255, 255, 255, 0.9);
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        height: 40px;
    }
    
    .feature-checkbox label:hover {
        border-color: #667eea;
    }
    
    .feature-checkbox input[type="checkbox"]:checked + label {
        background-color: #f0f7ff;
        border-color: #667eea;
        color: #667eea;
        font-weight: 500;
    }
    
    .feature-checkbox .check-icon {
        margin-right: 8px;
        font-size: 14px;
        color: #adb5bd;
    }
    
    .feature-checkbox input[type="checkbox"]:checked + label .check-icon {
        color: #667eea;
    }
    
    @media (max-width: 768px) {
        .features-container {
            flex-direction: column;
            gap: 8px;
        }
        
        .feature-checkbox label {
            justify-content: flex-start;
            padding: 10px 15px;
        }
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
            .form-container {
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
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .features-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .feature-checkbox {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Graphic Side -->
        <div class="graphic-side">
            <img src="{{ asset('images/demo/gallery/94d07275-ff2d-49a5-b847-24180c3e72ca.jpg') }}" alt="Logo" class="logo">
            <h3 class="graphic-title">Add Your Vehicle</h3>
            <p class="graphic-text">Fill out the form to add a new car to your fleet. Provide accurate details to ensure the best experience for your customers.</p>
            <div class="graphic-image"></div>
        </div>
        
        <!-- Form Side -->
        <div class="form-side">
            <h2 class="form-title"><i class="fas fa-car"></i> Add New Car</h2>
            
            @if ($errors->any())
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="addCarForm" action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="input-group">
                            <label for="brand" class="input-label"><i class="fas fa-car"></i> Brand</label>
                            <input type="text" name="brand" id="brand" class="input-field" value="{{ old('brand') }}" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="input-group">
                            <label for="model" class="input-label"><i class="fas fa-tools"></i> Model</label>
                            <input type="text" name="model" id="model" class="input-field" value="{{ old('model') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="input-group">
                            <label for="agency_number_display" class="input-label"><i class="fas fa-building"></i> Agency Number</label>
                            <input type="text" id="agency_number_display" class="input-field readonly-field" 
                                   value="{{Auth::user()->agency->id}}" 
                                   readonly>
                            <input type="hidden" name="agency_id" id="agency_id" value="{{ Auth::user()->agency->id}}">
                            <div id="subscriptionStatus" class="subscription-warning" style="display: none;">
                                <i class="fas fa-exclamation-triangle"></i> Agency is not subscribed!
                            </div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="input-group">
                            <label for="license_plate" class="input-label"><i class="fas fa-id-card"></i> License Plate</label>
                            <input type="text" name="license_plate" id="license_plate" class="input-field" value="{{ old('license_plate') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="input-group">
                            <label for="status" class="input-label"><i class="fas fa-check-circle"></i> Status</label>
                            <select name="status" id="status" class="select-field" required>
                                <option value="good">Good</option>
                                <option value="bad">Bad</option>
                                <option value="perfect">Perfect</option>
                                <option value="Available">Available</option>
                                <option value="Rented">Rented</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="input-group">
                            <label for="eco_friendly" class="input-label"><i class="fas fa-leaf"></i> Eco-Friendly</label>
                            <select name="eco_friendly" id="eco_friendly" class="select-field" required>
                                <option value="1" {{ old('eco_friendly', 1) ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !old('eco_friendly', 1) ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="input-group">
                            <label for="daily_rate" class="input-label"><i class="fas fa-dollar-sign"></i> Daily Rate ($)</label>
                            <input type="number" name="daily_rate" id="daily_rate" class="input-field" value="{{ old('daily_rate') }}" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="input-group">
                            <label for="fuel_type" class="input-label"><i class="fas fa-gas-pump"></i> Fuel Type</label>
                            <select name="fuel_type" id="fuel_type" class="select-field" required>
                                <option value="petrol" {{ old('fuel_type', 'petrol') === 'petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel" {{ old('fuel_type') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ old('fuel_type') === 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ old('fuel_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- New Fields Section -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="input-group">
                            <label for="family_friendly" class="input-label"><i class="fas fa-users"></i> Family Friendly</label>
                            <select name="family_friendly" id="family_friendly" class="select-field">
                                <option value="1" {{ old('family_friendly') ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !old('family_friendly') ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="input-group">
                            <label for="seats" class="input-label"><i class="fas fa-chair"></i> Number of Seats</label>
                            <input type="number" name="seats" id="seats" class="input-field" 
                                   value="{{ old('seats', 4) }}" min="1" max="12" required>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label style="padding: 7px" class="input-label"><i class="fas fa-star"></i> Features</label>
                    <div class="features-container">
                        <div   style="padding: 17px ;margin-left: 20px;" class="feature-checkbox">
                            <input  type="checkbox" name="child_seat" id="child_seat" value="1" {{ old('child_seat') ? 'checked' : '' }}>
                            <label for="child_seat">
                                <i class="fas fa-baby-carriage check-icon"></i> Child Seat
                            </label>
                        </div>
                        <div style="padding: 17px;margin-left: 20px;" class="feature-checkbox">
                            <input type="checkbox" name="air_conditioning" id="air_conditioning" value="1" {{ old('air_conditioning') ? 'checked' : '' }}>
                            <label for="air_conditioning">
                                <i  class="fas fa-snowflake check-icon"></i> Air Conditioning
                            </label>
                        </div>
                    </div>
                </div>
                
                
                <div class="input-group">
                    <label for="picture" class="input-label"><i class="fas fa-image"></i> Car Image</label>
                    <input type="file" name="picture" id="picture" class="file-field">
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <a href="{{ route('car.index') }}" class="cancel-btn"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                    <div class="form-col">
                        <button type="submit" id="submitBtn" class="submit-btn"><i class="fas fa-plus"></i> Add Car</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('addCarForm');
            const submitBtn = document.getElementById('submitBtn');
            const subscriptionWarning = document.getElementById('subscriptionStatus');
            
            // Check agency subscription via AJAX request
            function checkAgencySubscription() {
                fetch('/api/check-subscription')
                    .then(response => response.json())
                    .then(data => {
                        if (!data.is_subscribed) {
                            subscriptionWarning.style.display = 'block';
                            submitBtn.disabled = true;
                            submitBtn.style.background = 'linear-gradient(135deg, #dc3545, #c82333)';
                            submitBtn.innerHTML = '<i class="fas fa-ban"></i> Agency Not Subscribed';
                        }
                    })
                    .catch(error => {
                        console.error('Error checking subscription:', error);
                    });
            }

            // Call the function when the page loads
            checkAgencySubscription();
            
            form.addEventListener('submit', function(e) {
                // Check again before submitting to be sure
                fetch('/api/check-subscription')
                    .then(response => response.json())
                    .then(data => {
                        if (!data.is_subscribed) {
                            e.preventDefault();
                            alert('Your agency is not subscribed. Please subscribe to add new cars.');
                            return false;
                        }
                    })
                    .catch(error => {
                        console.error('Error checking subscription:', error);
                        // In case of error, allow submission to avoid blocking users
                    });
            });
        });
    </script>
</body>
</html>