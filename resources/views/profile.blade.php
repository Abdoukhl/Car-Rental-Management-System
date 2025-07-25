@extends('car.layout')

@section('content')
<div class="profile-wrapper">
    <!-- Particles Background -->
    <div id="particles-js"></div>

    <!-- Animated Gradient Background -->
    <div class="animated-bg"></div>

    <!-- Main Profile Container -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="text-center mb-4 position-relative">
                <center>
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     class="rounded-circle" 
                     width="150" 
                     height="150"
                     id="profile-photo-preview">
                <button class="edit-photo-btn" id="change-photo-btn">
                    <i class="fas fa-camera"></i>
                </button>
                <input type="file" id="profile-photo-input" accept="image/*" style="display: none;">
            </div>
        </center>
            <h1 class="title">
                <i class="fas fa-user-circle"></i>
                <span class="glow-name">{{ auth()->user()->name }}'s Profile</span>
            </h1>
            <p class="subtitle">Manage your account settings in style.</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs">
            <button class="tab active" data-tab="info"><i class="fas fa-user"></i> Info</button>
            <button class="tab" data-tab="security"><i class="fas fa-lock"></i> Security</button>
            <button class="tab" data-tab="danger">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content">
            <div class="tab-pane active" id="info">
                <div class="glass-card">
                    <h2><i class="fas fa-id-card"></i> Personal Info</h2>
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>
            <div class="tab-pane" id="security">
                <div class="glass-card">
                    <h2><i class="fas fa-key"></i> Password Settings</h2>
                    <livewire:profile.update-password-form />
                </div>
            </div>
            <div class="tab-pane" id="danger">
                <div class="glass-card danger">
                    <h2><i class="fa-solid fa-trash"></i> Delete Account</h2>
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #0b0e1e;
    color: white;
    overflow-x: hidden;
}

.animated-bg {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(-45deg, #0a1e40, #0c2b60, #123c80, #1a4d99);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    z-index: -2;
}

@keyframes gradientBG {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}

#particles-js {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.profile-wrapper {
    padding: 60px 20px;
    display: flex;
    justify-content: center;
}

.profile-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 40px;
    width: 100%;
    max-width: 900px;
    box-shadow: 0 0 50px rgba(0,0,0,0.4);
    border: 1px solid rgba(0, 150, 255, 0.2);
    animation: fadeInCard 1s ease;
}

@keyframes fadeInCard {
    from {opacity: 0; transform: scale(0.95);}
    to {opacity: 1; transform: scale(1);}
}

.profile-header {
    text-align: center;
    margin-bottom: 30px;
    position: relative;
}

.title {
    font-size: 2.5rem;
    margin-bottom: 10px;
    font-weight: 700;
}

.glow-name {
    background: linear-gradient(to right, #5aa0ff, #6fb4ff, #9ac9ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 8px rgba(90,160,255,0.4);
}

.subtitle {
    text-align: center;
    color: #cbd5e0;
    margin-bottom: 30px;
}

.tabs {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
}

.tab {
    background: rgba(255,255,255,0.1);
    border: none;
    padding: 12px 25px;
    border-radius: 30px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.tab.active, .tab:hover {
    background: rgba(0, 153, 255, 0.4);
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 153, 255, 0.5);
}

.tab-content .tab-pane {
    display: none;
}

.tab-content .tab-pane.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px);}
    to { opacity: 1; transform: translateY(0);}
}

.glass-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 0 20px rgba(0, 136, 255, 0.1);
    border: 1px solid rgba(0, 153, 255, 0.2);
}

.glass-card h2 {
    margin-bottom: 20px;
    font-size: 1.4rem;
    color: #f0f0f0;
}

.glass-card.danger {
    border: 1px solid rgba(255, 99, 99, 0.4);
}

.rounded-circle {
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(90, 160, 255, 0.5);
    box-shadow: 0 0 20px rgba(90, 160, 255, 0.3);
}

.edit-photo-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(90, 160, 255, 0.8);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.edit-photo-btn:hover {
    background: rgba(90, 160, 255, 1);
    transform: scale(1.1);
}
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tabs
    const tabs = document.querySelectorAll('.tab');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(btn => btn.classList.remove('active'));
            panes.forEach(pane => pane.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });

    // Particles
    particlesJS('particles-js', {
        "particles": {
            "number": { "value": 90 },
            "color": { "value": "#7ab6ff" },
            "shape": { "type": "circle" },
            "opacity": { "value": 0.25 },
            "size": { "value": 3.5 },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#76b0ff",
                "opacity": 0.25,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1.2
            }
        }
    });

    // Profile Photo Upload
    const changePhotoBtn = document.getElementById('change-photo-btn');
    const photoInput = document.getElementById('profile-photo-input');
    const photoPreview = document.getElementById('profile-photo-preview');

    changePhotoBtn.addEventListener('click', () => {
        photoInput.click();
    });

    photoInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            
            reader.onload = (event) => {
                photoPreview.src = event.target.result;
                uploadPhoto(e.target.files[0]);
            };
            
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    function uploadPhoto(file) {
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("profile.update-photo") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                photoPreview.src = data.profile_photo_url;
                alert('Profile photo updated successfully!');
            } else {
                alert('Error updating profile photo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while uploading the photo.');
        });
    }
});
</script>
@endsection