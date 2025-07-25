<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- تحميل مكتبة FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #00c6ff;
            --primary-dark: #0072ff;
            --secondary: #8be8fd;
            --danger: #ff4b5c;
            --text: #1e2a38;
            --light: #f1faff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }
       
        body {
            background: linear-gradient(135deg, #052692 0%, #1b223f 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
        }

        .profile-container {
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 1;
        }

        #particles-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 198, 255, 0.2);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-title {
            font-size: 2.2rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--secondary), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .profile-subtitle {
            color: #d3dce6;
            font-size: 1rem;
        }

        .tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab.active, .tab:hover {
            background: rgba(0, 198, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 198, 255, 0.2);
        }

        .tab.danger:hover {
            background: rgba(255, 75, 92, 0.3);
            box-shadow: 0 5px 15px rgba(255, 75, 92, 0.2);
        }

        .tab-content {
            margin-top: 20px;
        }

        .tab-pane {
            display: none;
            animation: fadeInPane 0.5s ease;
        }

        @keyframes fadeInPane {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tab-pane.active {
            display: block;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(0, 198, 255, 0.15);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .glass-card h2 {
            margin-bottom: 20px;
            color: var(--light);
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .glass-card.danger {
            border-color: rgba(255, 75, 92, 0.3);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-bottom: 15px;
            transition: background 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-card {
                padding: 25px;
            }

            .profile-title {
                font-size: 1.8rem;
            }

            .tabs {
                gap: 10px;
            }

            .tab {
                padding: 10px 15px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div id="particles-bg"></div>

    <div class="profile-container">
        <div class="profile-card">
            
            <div class="profile-header">
                <h1 class="profile-title">
                    <div class="text-center mb-4 position-relative d-inline-block">
                    <center>
                            <!-- زر تعديل بشكل قلم فقط، صغير الحجم -->
                            <a href="{{ route('admin.profile.edit') }}" 
                            class="btn btn-light position-absolute p-1" 
                            style="top: 5px; right: 5px; border-radius: 50%; box-shadow: 0 0 5px rgba(0,0,0,0.2); width: 30px; height: 28px; display: flex; align-items: center; justify-content: center;">
                             <i class="fas fa-edit" style="font-size: 12px;"></i>
                         </a>
                        </center>
                        <img 
                            style="border-radius: 80px;"  
                            src="{{ $admin->profile_photo_url }}" 
                            class="rounded-circle" 
                            width="150" 
                            height="150"
                        >
                       
                        
                    </div>
                    
                    <i class="fas fa-user-shield"></i>
                    Admin Profile
                </h1>
                <p class="profile-subtitle">Manage your account settings with ease</p>
            </div>

            <div class="tabs">
                <button class="tab active" data-tab="info">
                    <i class="fas fa-user"></i> Info
                </button>
                
                <button class="tab" data-tab="security">
                    <i class="fas fa-lock"></i> Security
                </button>
                <button class="tab danger" data-tab="danger">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <div class="glass-card">
                        <h2><i class="fas fa-id-card"></i> Personal Information</h2>
                        <!-- Personal Info Form -->
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="tab-pane" id="security">
                    <div class="glass-card">
                        <h2><i class="fas fa-key"></i> Password Settings</h2>
                        <!-- Security Form -->
                        <livewire:profile.update-password-form />
                    </div>
                </div>

                <div class="tab-pane" id="danger">
                    <div class="glass-card danger">
                        <h2><i class="fas fa-exclamation-triangle"></i> Delete Account</h2>
                        <!-- Delete Account -->
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
            <br>
            <br>
            <a href="{{ route('admin.dashboard') }}">
                <button class="custom-back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </button>
            </a>
            
            <style>
            .custom-back-btn {
                background-color: #4CAF50; /* Green */
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 0 8px rgba(76, 175, 80, 0.6); /* Glow effect */
            }
            
            .custom-back-btn:hover {
                background-color: #45a049;
                box-shadow: 0 0 20px rgba(76, 175, 80, 1), 0 0 30px rgba(76, 175, 80, 0.8); /* Stronger glow */
            }
            
            .custom-back-btn:focus {
                outline: none;
                box-shadow: 0 0 20px rgba(76, 175, 80, 1), 0 0 30px rgba(76, 175, 80, 0.8);
            }
            </style>
            
            
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });

        // Particles.js config
        particlesJS('particles-bg', {
            "particles": {
                "number": { "value": 80 },
                "color": { "value": "#00c6ff" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.3 },
                "size": { "value": 3 },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#00c6ff",
                    "opacity": 0.2,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 1
                }
            }
        });
    });
    </script>
</body>
</html>
