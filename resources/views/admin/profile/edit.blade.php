<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل البروفايل</title>
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

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(0, 198, 255, 0.15);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .glass-card h2 {
            margin-bottom: 20px;
            color: var(--light);
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
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

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--secondary);
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 15px rgba(0, 198, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 198, 255, 0.4);
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .rounded-circle {
            border-radius: 50%;
        }

        .form-control {
            display: block;
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-card {
                padding: 25px;
            }

            .profile-title {
                font-size: 1.8rem;
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
                    <i class="fas fa-user-edit"></i>
                    تعديل البروفايل
                </h1>
                <p class="profile-subtitle">قم بتحديث معلوماتك الشخصية</p>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="glass-card">
                    <div class="text-center mb-4">
                        <img src="{{ $admin->profile_photo_url }}" 
                             class="rounded-circle" 
                             width="150" 
                             height="150">
                        <input type="file" name="profile_photo" class="form-control mt-3" style="text-align: center;">
                    </div>
                    
                    <div class="form-group">
                        <label>الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        حفظ التغييرات
                    </button>
                    
                    <a href="{{ route('admin.profile') }}" class="btn-primary" style="background: rgba(255, 255, 255, 0.1); margin-right: 10px;">
                        <i class="fas fa-arrow-right"></i>
                        رجوع
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
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