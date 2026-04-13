<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student | Tugawe Elementary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #f8fafc;
        }

        .dashboard-layout {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .sidebar-container {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
            flex-shrink: 0;
        }

        .main-wrapper {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            background: #f8fafc;
        }

        .main-header {
            height: 80px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 32px;
            flex-shrink: 0;
            z-index: 40;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 32px;
        }

        .main-content::-webkit-scrollbar { 
            width: 8px; 
        }
        .main-content::-webkit-scrollbar-track { 
            background: transparent; 
        }
        .main-content::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 4px; 
        }

        @media (max-width: 1024px) {
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-container.open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
        }

        .glass-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .form-section {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 24px;
            margin-bottom: 24px;
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 20px;
            padding-right: 40px;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.23);
        }

        .btn-secondary {
            background: white;
            color: #64748b;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

       /* Floating Back Button - Bottom Right */
.floating-back-btn {
    position: fixed;
    right: 32px;
    bottom: 32px;
    top: auto;
    transform: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
    transition: all 0.3s ease;
    z-index: 100;
    text-decoration: none;
}

.floating-back-btn:hover {
    transform: scale(1.1) rotate(-10deg);
    box-shadow: 0 6px 30px rgba(59, 130, 246, 0.5);
}

.floating-back-btn:active {
    transform: scale(0.95);
}

/* Tooltip for floating button - now above the button */
.floating-back-btn::before {
   
    position: absolute;
    bottom: 70px;
    right: 50%;
    transform: translateX(50%) translateY(10px);
    background: #1e293b;
    color: white;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.floating-back-btn:hover::before {
    opacity: 1;
    visibility: visible;
    transform: translateX(50%) translateY(0);
}

/* Arrow pointing down for tooltip */
.floating-back-btn::after {
    content: '';
    position: absolute;
    bottom: 64px;
    right: 50%;
    transform: translateX(50%);
    border-width: 6px 6px 0;
    border-style: solid;
    border-color: #1e293b transparent transparent;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.floating-back-btn:hover::after {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 1024px) {
    .floating-back-btn {
        right: 24px;
        bottom: 24px;
        width: 56px;
        height: 56px;
        font-size: 1.125rem;
    }
    
    .floating-back-btn::before {
        bottom: 66px;
    }
    
    .floating-back-btn::after {
        bottom: 60px;
    }
}

        /* Success Alert with Countdown */
        .alert-success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border: 1px solid #86efac;
            color: #166534;
            padding: 20px 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(34, 197, 94, 0.15);
        }

        .alert-success::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: #22c55e;
            width: 100%;
            transform-origin: left;
            animation: countdown 5s linear forwards;
        }

        @keyframes countdown {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .countdown-timer {
            font-size: 0.75rem;
            font-weight: 700;
            color: #15803d;
            background: rgba(255, 255, 255, 0.6);
            padding: 4px 10px;
            border-radius: 20px;
        }

        .mobile-overlay {
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(4px);
        }

        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .animate-fade-in-up { 
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-with-icon {
            padding-left: 44px;
        }

        .required::after {
            content: '*';
            color: #ef4444;
            margin-left: 4px;
        }

        .input-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 4px;
        }

        .lrn-prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #3b82f6;
            font-weight: 600;
            font-size: 0.875rem;
            pointer-events: none;
        }

        .input-with-prefix {
            padding-left: 70px;
        }

        /* Username field styling */
        .username-hint {
            font-size: 0.75rem;
            color: #3b82f6;
            margin-top: 4px;
            font-weight: 500;
        }
    </style>
</head>
<body class="text-slate-800">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay fixed inset-0 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Floating Back Button -->
    <a href="{{ route('admin.students.index') }}" class="floating-back-btn" title="Back to List">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="dashboard-layout">
        <!-- Fixed Sidebar -->
        <div class="sidebar-container">
            @include('admin.includes.sidebar')
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Fixed Header -->
            <header class="main-header">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                        <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2.5 hover:bg-slate-100 rounded-xl transition-colors">
                            <i class="fas fa-bars text-slate-600"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Create Student</h2>
                            <p class="text-sm text-slate-500 font-medium flex items-center gap-2 mt-0.5">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                Add new student enrollment
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="main-content">
                
                @if(session('success'))
                    <div class="alert-success animate-fade-in-up" id="successAlert">
                        <div class="alert-content">
                            <i class="fas fa-check-circle text-2xl text-green-600"></i>
                            <div>
                                <div class="font-bold text-lg">{{ session('success') }}</div>
                                <div class="text-sm text-green-700">Redirecting in <span id="countdown">5</span> seconds...</div>
                            </div>
                        </div>
                        <div class="countdown-timer" id="timerBadge">5s</div>
                    </div>

                    <script>
                        // Countdown timer for redirect
                        let seconds = 5;
                        const countdownEl = document.getElementById('countdown');
                        const timerBadgeEl = document.getElementById('timerBadge');
                        
                        const timer = setInterval(function() {
                            seconds--;
                            countdownEl.textContent = seconds;
                            timerBadgeEl.textContent = seconds + 's';
                            
                            if (seconds <= 0) {
                                clearInterval(timer);
                                window.location.href = "{{ route('admin.students.index') }}";
                            }
                        }, 1000);
                    </script>
                @endif

                <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="glass-card p-8 animate-fade-in-up" id="studentForm">
                    @csrf

{{-- DEBUG: Show all errors --}}
@if($errors->any() || session('error'))
    <div id="errorAlert" class="transition-all duration-500"
         style="position: relative; background: #fee2e2; border: 2px solid #ef4444; color: #991b1b; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <strong>{{ $errors->any() ? 'VALIDATION ERRORS:' : 'ERROR:' }}</strong>
        @if($errors->any())
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @elseif(session('error'))
            <span>{{ session('error') }}</span>
        @endif
        <span id="countdown" style="position:absolute; top:8px; right:12px; font-weight:600;">3</span>
    </div>

    <script>
        (function() {
            const alertBox = document.getElementById('errorAlert');
            const countdownEl = document.getElementById('countdown');
            let timeLeft = 3;

            const countdownInterval = setInterval(() => {
                timeLeft--;
                countdownEl.textContent = timeLeft;
                if(timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500); // fade out smoothly
                }
            }, 1000);
        })();
    </script>
@endif

                   <!-- Account Information Section -->
<div class="form-section">
    <div class="section-title">
        <div class="section-icon bg-indigo-50 text-indigo-600">
            <i class="fas fa-id-card"></i>
        </div>
        <span>Account Information</span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Username -->
        <div>
            <label class="form-label required">Username</label>
            <div class="input-group">
                <i class="fas fa-user-circle input-icon"></i>
                <input 
                    type="text" 
                    name="username" 
                    id="usernameInput"
                    class="form-input input-with-icon" 
                    placeholder="Enter unique username"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="[a-zA-Z0-9_]+"
                    oninput="validateUsername(this)"
                >
            </div>
            <p class="username-hint">4-20 characters, letters, numbers and underscores only</p>
            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="form-label required">Email</label>
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input input-with-icon" 
                    placeholder="student@tugaweelem.edu"
                    required
                >
            </div>
            <p class="input-hint">Valid email address required for account activation</p>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label class="form-label required">Password</label>
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input 
                    type="password" 
                    name="password" 
                    id="passwordInput"
                    class="form-input input-with-icon" 
                    placeholder="Enter password"
                    required
                    minlength="8"
                    oninput="validatePassword(this)"
                >
                <button type="button" onclick="togglePassword('passwordInput', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <p class="input-hint">Minimum 8 characters</p>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="form-label required">Confirm Password</label>
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="confirmPasswordInput"
                    class="form-input input-with-icon" 
                    placeholder="Confirm password"
                    required
                    oninput="validateMatch()"
                >
                <button type="button" onclick="togglePassword('confirmPasswordInput', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <p class="input-hint" id="matchHint">Passwords must match</p>
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
<script>
    // Toggle password visibility
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password validation (basic strength check)
function validatePassword(input) {
    validateMatch();
}

// Check if passwords match
function validateMatch() {
    const password = document.getElementById('passwordInput').value;
    const confirm = document.getElementById('confirmPasswordInput').value;
    const hint = document.getElementById('matchHint');
    const confirmInput = document.getElementById('confirmPasswordInput');
    
    if (confirm && password !== confirm) {
        hint.textContent = 'Passwords do not match!';
        hint.style.color = '#ef4444';
        confirmInput.style.borderColor = '#ef4444';
    } else if (confirm && password === confirm) {
        hint.textContent = 'Passwords match!';
        hint.style.color = '#22c55e';
        confirmInput.style.borderColor = '#22c55e';
    } else {
        hint.textContent = 'Passwords must match';
        hint.style.color = '#64748b';
        confirmInput.style.borderColor = '#e2e8f0';
    }
}
</script>


                    <!-- Photo Upload Section -->
<div class="form-section">
    <div class="section-title">
        <div class="section-icon bg-purple-50 text-purple-600">
            <i class="fas fa-camera"></i>
        </div>
        <span>Profile Photo</span>
    </div>
    
    <div class="flex items-center gap-6">
        <!-- Preview Container -->
        <div class="relative">
            <div id="photoPreview" class="w-32 h-32 rounded-full bg-slate-100 border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                <i class="fas fa-user text-4xl text-slate-300"></i>
            </div>
            <button type="button" id="removePhoto" class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full shadow-md hidden hover:bg-red-600 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <div class="flex-1">
            <label class="form-label">Upload Photo</label>
            <div class="relative">
                <input 
                    type="file" 
                    name="photo" 
                    id="photoInput"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    class="hidden"
                    onchange="previewPhoto(this)"
                >
                <button 
                    type="button" 
                    onclick="document.getElementById('photoInput').click()"
                    class="btn-secondary w-full md:w-auto"
                >
                    <i class="fas fa-upload"></i>
                    Choose Photo
                </button>
                <p class="input-hint mt-2">JPEG, PNG, GIF up to 2MB</p>
            </div>
            @error('photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
<script>
    // Photo Preview Function
function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    const removeBtn = document.getElementById('removePhoto');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            removeBtn.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove Photo
document.getElementById('removePhoto').addEventListener('click', function() {
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('photoPreview');
    
    input.value = '';
    preview.innerHTML = '<i class="fas fa-user text-4xl text-slate-300"></i>';
    this.classList.add('hidden');
});
</script>

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon bg-blue-50 text-blue-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Basic Information</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="form-label required">First Name</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" name="first_name" class="form-input input-with-icon" placeholder="First name" required>
                                </div>
                            </div>

                             <!-- Middle Name -->
                            <div>
                                <label class="form-label">Middle Name</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" name="middle_name" class="form-input input-with-icon" placeholder="Middle name">
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="form-label required">Last Name</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" name="last_name" class="form-input input-with-icon" placeholder="Last name" required>
                                </div>
                            </div>

                            <!-- LRN -->
                            <div>
                                <label class="form-label">LRN (Learner Reference Number)</label>
                                <div class="input-group">
                                    <span class="lrn-prefix">120231</span>
                                   <input 
    type="text" 
    name="lrn" 
    id="lrnInput"
    class="form-input input-with-prefix" 
    placeholder="XXXXXX"
    maxlength="6"
    pattern="\d{6}"
    inputmode="numeric"
    oninput="validateLRN(this)"
    title="Please enter exactly 6 numbers"
>
                                </div>
                                <p class="input-hint">Enter last 6 digits only (12 digits total)</p>
                            </div>

                            <!-- Birthdate -->
                            <div>
                                <label class="form-label">Birthdate</label>
                                <div class="input-group">
                                    <i class="fas fa-calendar input-icon"></i>
                                    <input 
                                        type="date" 
                                        name="birthdate" 
                                        class="form-input input-with-icon"
                                        min="1900-01-01"
                                        max="{{ date('Y-m-d') }}"
                                    >
                                </div>
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <label class="form-label">Birth Place</label>
                                <div class="input-group">
                                    <i class="fas fa-map-marker-alt input-icon"></i>
                                    <input type="text" name="birth_place" class="form-input input-with-icon" placeholder="City, Province">
                                </div>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Nationality -->
                            <div>
                                <label class="form-label">Nationality</label>
                                <div class="input-group">
                                    <i class="fas fa-globe input-icon"></i>
                                    <input type="text" name="nationality" class="form-input input-with-icon" placeholder="e.g., Filipino">
                                </div>
                            </div>

                            <!-- Religion -->
                            <div>
                                <label class="form-label">Religion</label>
                                <div class="input-group">
                                    <i class="fas fa-praying-hands input-icon"></i>
                                    <input type="text" name="religion" class="form-input input-with-icon" placeholder="e.g., Roman Catholic">
                                </div>
                            </div>

                            <!-- ADD THESE TWO FIELDS HERE -->
<div>
    <label class="form-label">Ethnicity</label>
    <div class="input-group">
        <i class="fas fa-users input-icon"></i>
        <input type="text" name="ethnicity" class="form-input input-with-icon" placeholder="e.g., Cebuano, Tagalog">
    </div>
</div>

<div>
    <label class="form-label">Mother Tongue</label>
    <div class="input-group">
        <i class="fas fa-language input-icon"></i>
        <input type="text" name="mother_tongue" class="form-input input-with-icon" placeholder="e.g., Cebuano, Filipino">
    </div>
</div>
                        </div>
                    </div>


                    <!-- Enrollment Information Section -->
<div class="form-section">
    <div class="section-title">
        <div class="section-icon bg-rose-50 text-rose-600">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <span>Enrollment Information</span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Grade Level -->
        <div>
            <label class="form-label required">Grade Level</label>
            <select name="grade_level_id" id="gradeLevel" class="form-select" required>
                <option value="">Select Grade Level</option>
                <option value="1">Kindergarten</option>
                <option value="2">Grade 1</option>
                <option value="3">Grade 2</option>
                <option value="4">Grade 3</option>
                <option value="5">Grade 4</option>
                <option value="6">Grade 5</option>
                <option value="7">Grade 6</option>
            </select>
            <p class="input-hint">Select current grade level for enrollment</p>
        </div>

        <!-- Student Type -->
        <div>
            <label class="form-label required">Student Type</label>
            <select name="type" id="studentType" class="form-select" required onchange="togglePreviousSchool()">
                <option value="">Select Type</option>
                <option value="new">New Student</option>
                <option value="continuing">Continuing Student</option>
                <option value="transferee">Transferee</option>
            </select>
            <p class="input-hint">Select based on student's enrollment status</p>
        </div>

        <!-- Previous School (for Transferees) -->
        <div id="previousSchoolContainer" class="hidden">
            <label class="form-label required">Previous School</label>
            <div class="input-group">
                <i class="fas fa-school input-icon"></i>
                <input 
                    type="text" 
                    name="previous_school" 
                    id="previousSchoolInput"
                    class="form-input input-with-icon" 
                    placeholder="Name of previous school"
                >
            </div>
            <p class="input-hint">Required for transferee students</p>
        </div>
    </div>
</div>

<script>
    function togglePreviousSchool() {
        const typeSelect = document.getElementById('studentType');
        const previousSchoolContainer = document.getElementById('previousSchoolContainer');
        const previousSchoolInput = document.getElementById('previousSchoolInput');
        
        if (typeSelect.value === 'transferee') {
            previousSchoolContainer.classList.remove('hidden');
            previousSchoolInput.required = true;
        } else {
            previousSchoolContainer.classList.add('hidden');
            previousSchoolInput.required = false;
            previousSchoolInput.value = '';
        }
    }
</script>



                    <!-- Family Information -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon bg-emerald-50 text-emerald-600">
                                <i class="fas fa-users"></i>
                            </div>
                            <span>Family Information</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Father -->
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                                    <i class="fas fa-male text-blue-500"></i>
                                    Father's Information
                                </h4>
                            </div>
                            
                            <div>
                                <label class="form-label">Father's Name</label>
                                <input type="text" name="father_name" class="form-input" placeholder="Full name">
                            </div>

                            <div>
                                <label class="form-label">Father's Occupation</label>
                                <input type="text" name="father_occupation" class="form-input" placeholder="e.g., Farmer, Teacher, OFW">
                            </div>

                            <!-- Mother -->
                            <div class="md:col-span-2 mt-4">
                                <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                                    <i class="fas fa-female text-pink-500"></i>
                                    Mother's Information
                                </h4>
                            </div>

                            <div>
                                <label class="form-label">Mother's Name</label>
                                <input type="text" name="mother_name" class="form-input" placeholder="Full name">
                            </div>

                            <div>
                                <label class="form-label">Mother's Occupation</label>
                                <input type="text" name="mother_occupation" class="form-input" placeholder="e.g., Housewife, Teacher, OFW">
                            </div>

                            <!-- Guardian -->
                            <div class="md:col-span-2 mt-4">
                                <h4 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-amber-500"></i>
                                    Guardian's Information (if applicable)
                                </h4>
                            </div>

                            <div>
                                <label class="form-label">Guardian's Name</label>
                                <input type="text" name="guardian_name" class="form-input" placeholder="Full name">
                            </div>

                            <div>
                                <label class="form-label">Relationship to Student</label>
                                <input type="text" name="guardian_relationship" class="form-input" placeholder="e.g., Grandmother, Uncle">
                            </div>

                            <div class="md:col-span-2">
                                <label class="form-label">Guardian's Contact Number</label>
                                <div class="input-group">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input 
                                        type="tel" 
                                        name="guardian_contact" 
                                        id="contactInput"
                                        class="form-input input-with-icon" 
                                        placeholder="09XX XXX XXXX"
                                        maxlength="11"
                                        pattern="[0-9]{11}"
                                        inputmode="numeric"
                                        oninput="validateContact(this)"
                                    >
                                </div>
                                <p class="input-hint">Must be 11 digits (e.g., 09123456789)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon bg-amber-50 text-amber-600">
                                <i class="fas fa-home"></i>
                            </div>
                            <span>Address</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label class="form-label">Street Address</label>
                                <div class="input-group">
                                    <i class="fas fa-road input-icon"></i>
                                    <input type="text" name="street_address" class="form-input input-with-icon" placeholder="House number, Street name">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Barangay</label>
                                <input type="text" name="barangay" class="form-input" placeholder="Barangay name">
                            </div>

                            <div>
                                <label class="form-label">City / Municipality</label>
                                <input type="text" name="city" class="form-input" placeholder="City name">
                            </div>

                            <div>
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-input" placeholder="Province name">
                            </div>

                            <div>
                                <label class="form-label">Zip Code</label>
                                <div class="input-group">
                                    <i class="fas fa-mail-bulk input-icon"></i>
                                    <input type="text" name="zip_code" class="form-input input-with-icon" placeholder="4-digit code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks Section -->
<div class="form-section">
    <div class="section-title">
        <div class="section-icon bg-gray-50 text-gray-600">
            <i class="fas fa-sticky-note"></i>
        </div>
        <span>Remarks</span>
    </div>
    
    <div>
        <label class="form-label">Student Remark</label>
        <select name="remarks" class="form-select">
            <option value="">Select Remark (Optional)</option>
            @foreach(\App\Models\Student::$remarksLegend as $code => $description)
                <option value="{{ $code }}">{{ $code }} - {{ $description }}</option>
            @endforeach
        </select>
        <p class="input-hint">Select a remark code for this student's status</p>
    </div>
</div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-between pt-4">
                        <div class="text-sm text-slate-500">
                            Fields marked with <span class="text-red-500">*</span> are required
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.students.index') }}" class="btn-secondary lg:hidden">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Save Student
                            </button>
                        </div>
                    </div>

                </form>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-container');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
            }
        }

        // Username Validation - Only letters, numbers, and underscores
        function validateUsername(input) {
            // Remove any characters that are not letters, numbers, or underscores
            input.value = input.value.replace(/[^a-zA-Z0-9_]/g, '');
            
            // Convert to lowercase
            input.value = input.value.toLowerCase();
        }

   
        // LRN Validation - Only numbers, exactly 6 digits
        function validateLRN(input) {
            // Remove any non-numeric characters
            input.value = input.value.replace(/[^0-9]/g, '');
            
            // Limit to 6 digits
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
            
            // Visual feedback - red border if not 6 digits
            if (input.value.length > 0 && input.value.length !== 6) {
                input.style.borderColor = '#ef4444';
            } else {
                input.style.borderColor = '#e2e8f0';
            }
        }

        // Contact Number Validation - Only numbers, exactly 11 digits, must start with 09
        function validateContact(input) {
            // Remove any non-numeric characters
            input.value = input.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 digits
            if (input.value.length > 11) {
                input.value = input.value.slice(0, 11);
            }
            
            // Ensure starts with 09
            if (input.value.length >= 2 && !input.value.startsWith('09')) {
                input.value = '09' + input.value.slice(2);
            }
        }


        
// Form submission validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    const lrnInput = document.getElementById('lrnInput');
    const contactInput = document.getElementById('contactInput');
    const usernameInput = document.getElementById('usernameInput');
    const passwordInput = document.getElementById('passwordInput');
    const confirmInput = document.getElementById('confirmPasswordInput');
    
    // Validate Username
    if (usernameInput.value.length < 4) {
        e.preventDefault();
        alert('Username must be at least 4 characters long');
        usernameInput.focus();
        return false;
    }
    
    // Validate Password length
    if (passwordInput.value.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long');
        passwordInput.focus();
        return false;
    }
    
    // Validate Password match
    if (passwordInput.value !== confirmInput.value) {
        e.preventDefault();
        alert('Passwords do not match!');
        confirmInput.focus();
        return false;
    }
    
    // Validate LRN - must be exactly 6 digits
    if (lrnInput.value && lrnInput.value.length !== 6) {
        e.preventDefault();
        alert('LRN must be exactly 6 digits');
        lrnInput.focus();
        return false;
    }
    
    // Validate contact
    if (contactInput.value && contactInput.value.length !== 11) {
        e.preventDefault();
        alert('Contact number must be exactly 11 digits');
        contactInput.focus();
        return false;
    }
    
    // ✅ Create hidden input with FULL 12-digit LRN (120231 + 6 user digits)
    if (lrnInput.value && lrnInput.value.length === 6) {
        // Remove any existing hidden field
        const existingHidden = this.querySelector('input[name="lrn_full"]');
        if (existingHidden) {
            existingHidden.remove();
        }
        
        // Create hidden input with full LRN
        const fullLRN = '120231' + lrnInput.value;
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'lrn_full';
        hiddenInput.value = fullLRN;
        this.appendChild(hiddenInput);
        
        // Disable original input so only lrn_full submits
        lrnInput.disabled = true;
    }
});
        // Auto-hide success message after 5 seconds (backup)
        setTimeout(function() {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>