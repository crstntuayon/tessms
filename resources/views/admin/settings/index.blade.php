<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings | Tugawe Elementary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { 
            margin: 0; 
            padding: 0; 
            background: #f8fafc;
            overflow: hidden;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .main-wrapper {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 32px;
            background: #f8fafc;
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
            .main-wrapper { margin-left: 0; }
        }

        .glass-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-radius: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        /* Settings Header */
        .settings-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 40px;
            border-radius: 24px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .settings-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 50%;
            filter: blur(60px);
        }

        /* Tab Navigation */
        .settings-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 16px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            background: transparent;
            text-align: left;
            width: 100%;
        }

        .nav-item:hover {
            background: #f1f5f9;
            color: #475569;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4);
        }

        .nav-item i {
            width: 24px;
            text-align: center;
            font-size: 16px;
        }

        /* Settings Content */
        .settings-content {
            display: none;
        }

        .settings-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-label span {
            color: #ef4444;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.2s ease;
            background: white;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        .form-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Toggle Switch */
        .toggle-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .toggle-wrapper:hover {
            background: #f1f5f9;
        }

        .toggle-info h4 {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .toggle-info p {
            font-size: 13px;
            color: #64748b;
        }

        .toggle-switch {
            position: relative;
            width: 52px;
            height: 28px;
            background: #cbd5e1;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .toggle-switch.active {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-switch.active::after {
            transform: translateX(24px);
        }

        /* File Upload */
        .file-upload {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .file-upload:hover {
            border-color: #6366f1;
            background: #eef2ff;
        }

        .file-upload i {
            font-size: 32px;
            color: #6366f1;
            margin-bottom: 12px;
        }

        .file-upload p {
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }

        .file-upload span {
            font-size: 13px;
            color: #64748b;
        }

        /* Color Picker */
        .color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-picker {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            overflow: hidden;
        }

        .color-picker input {
            width: 150%;
            height: 150%;
            transform: translate(-25%, -25%);
            cursor: pointer;
            border: none;
            padding: 0;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(99, 102, 241, 0.5);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: #475569;
            border-color: #cbd5e1;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px -3px rgba(239, 68, 68, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(239, 68, 68, 0.5);
        }

        /* Section Cards */
        .section-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #6366f1;
        }

        /* Danger Zone */
        .danger-zone {
            border: 1px solid #fecaca;
            background: #fef2f2;
            border-radius: 20px;
            padding: 24px;
        }

        .danger-zone-title {
            color: #991b1b;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .danger-zone p {
            color: #7f1d1d;
            font-size: 14px;
            margin-bottom: 16px;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            background: white;
            border-left: 4px solid #10b981;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 100;
            transform: translateX(400px);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.error {
            border-left-color: #ef4444;
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }

        /* Responsive */
        @media (max-width: 1024px) {
            .settings-layout {
                flex-direction: column;
            }
            .settings-sidebar {
                width: 100%;
                margin-bottom: 24px;
            }
            .settings-nav {
                flex-direction: row;
                overflow-x: auto;
                padding: 12px;
            }
            .nav-item {
                white-space: nowrap;
            }
        }
    </style>
</head>
<body class="antialiased text-slate-800">

    <!-- Toast Notification -->
    @if(session('success'))
    <div id="successToast" class="toast show">
        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-emerald-600"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-900">Success!</p>
            <p class="text-sm text-slate-500">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="errorToast" class="toast error show">
        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation text-red-600"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-900">Error!</p>
            <p class="text-sm text-slate-500">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="dashboard-container">
        @include('admin.includes.sidebar')

        <div class="main-wrapper">
            <div class="main-content">
                <div class="max-w-7xl mx-auto pb-24">

                    <!-- Header -->
                    <div class="settings-header animate-fade-in">
                        <div class="relative z-10">
                            <h1 class="text-3xl font-bold mb-2">System Settings</h1>
                            <p class="text-slate-300">Manage your school management system preferences and configurations</p>
                        </div>
                    </div>

                    <!-- Settings Layout -->
                    <div class="flex flex-col lg:flex-row gap-6 animate-fade-in stagger-1">
                        
                        <!-- Settings Navigation Sidebar -->
                        <div class="lg:w-72 flex-shrink-0">
                            <div class="glass-card settings-sidebar">
                                <div class="settings-nav">
                                    <button class="nav-item active" onclick="switchTab('general')">
                                        <i class="fas fa-cog"></i>
                                        General Settings
                                    </button>
                                    <button class="nav-item" onclick="switchTab('school')">
                                        <i class="fas fa-school"></i>
                                        School Info
                                    </button>
                                    <button class="nav-item" onclick="switchTab('academic')">
                                        <i class="fas fa-graduation-cap"></i>
                                        Academic Year
                                    </button>
                                    <button class="nav-item" onclick="switchTab('notifications')">
                                        <i class="fas fa-bell"></i>
                                        Notifications
                                    </button>
                                    <button class="nav-item" onclick="switchTab('security')">
                                        <i class="fas fa-shield-alt"></i>
                                        Security
                                    </button>
                                    <button class="nav-item" onclick="switchTab('appearance')">
                                        <i class="fas fa-paint-brush"></i>
                                        Appearance
                                    </button>
                                    <button class="nav-item" onclick="switchTab('backup')">
                                        <i class="fas fa-database"></i>
                                        Backup & Data
                                    </button>
                                    <button class="nav-item" onclick="switchTab('advanced')">
                                        <i class="fas fa-sliders-h"></i>
                                        Advanced
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Content Area -->
                        <div class="flex-1 min-w-0">
                            
                            <!-- General Settings -->
                            <div id="general" class="settings-content active">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-info-circle"></i>
                                            General Information
                                        </h3>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">System Name <span>*</span></label>
                                                <input type="text" name="system_name" class="form-input" 
                                                    value="{{ $settings['system_name'] ?? 'Tugawe Elementary School' }}" 
                                                    placeholder="Enter system name">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Timezone</label>
                                                <select name="timezone" class="form-select">
                                                    <option value="Asia/Manila" {{ ($settings['timezone'] ?? '') == 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (GMT+8)</option>
                                                    <option value="Asia/Tokyo" {{ ($settings['timezone'] ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (GMT+9)</option>
                                                    <option value="Asia/Singapore" {{ ($settings['timezone'] ?? '') == 'Asia/Singapore' ? 'selected' : '' }}>Asia/Singapore (GMT+8)</option>
                                                    <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Date Format</label>
                                                <select name="date_format" class="form-select">
                                                    <option value="F d, Y" {{ ($settings['date_format'] ?? '') == 'F d, Y' ? 'selected' : '' }}>January 01, 2024</option>
                                                    <option value="Y-m-d" {{ ($settings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>2024-01-01</option>
                                                    <option value="d/m/Y" {{ ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>01/01/2024</option>
                                                    <option value="m/d/Y" {{ ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>01/01/2024</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Default Language</label>
                                                <select name="default_language" class="form-select">
                                                    <option value="en" {{ ($settings['default_language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                                    <option value="fil" {{ ($settings['default_language'] ?? '') == 'fil' ? 'selected' : '' }}>Filipino</option>
                                                    <option value="ceb" {{ ($settings['default_language'] ?? '') == 'ceb' ? 'selected' : '' }}>Cebuano</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-toggle-on"></i>
                                            System Features
                                        </h3>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Maintenance Mode</h4>
                                                <p>Temporarily disable access to the system for maintenance</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['maintenance_mode'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="maintenance_mode"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>User Registration</h4>
                                                <p>Allow new users to register accounts</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['user_registration'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="user_registration"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Email Verification</h4>
                                                <p>Require email verification for new accounts</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['email_verification'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="email_verification"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" class="btn-secondary" onclick="resetForm()">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- School Info -->
                            <div id="school" class="settings-content">
                                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-school"></i>
                                            School Details
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group md:col-span-2">
                                                <label class="form-label">School Name <span>*</span></label>
                                                <input type="text" name="school_name" class="form-input" 
                                                    value="{{ $settings['school_name'] ?? 'Tugawe Elementary School' }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">School Code</label>
                                                <input type="text" name="school_code" class="form-input" 
                                                    value="{{ $settings['school_code'] ?? '' }}"
                                                    placeholder="e.g., TES-2024">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">DepEd School ID</label>
                                                <input type="text" name="deped_school_id" class="form-input" 
                                                    value="{{ $settings['deped_school_id'] ?? '' }}">
                                            </div>

                                            <div class="form-group md:col-span-2">
                                                <label class="form-label">School Address</label>
                                                <textarea name="school_address" class="form-textarea" rows="3">{{ $settings['school_address'] ?? '' }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Contact Email</label>
                                                <input type="email" name="school_email" class="form-input" 
                                                    value="{{ $settings['school_email'] ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Contact Phone</label>
                                                <input type="tel" name="school_phone" class="form-input" 
                                                    value="{{ $settings['school_phone'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-image"></i>
                                            School Logo
                                        </h3>

                                        <div class="file-upload" onclick="document.getElementById('school_logo').click()">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p>Click to upload school logo</p>
                                            <span>Recommended: 400x400px, PNG or JPG</span>
                                            <input type="file" id="school_logo" name="school_logo" accept="image/*" style="display: none;">
                                        </div>

                                        @if($settings['school_logo'] ?? false)
                                        <div class="mt-4 flex items-center gap-4">
                                            <img src="{{ asset('storage/' . $settings['school_logo']) }}" alt="School Logo" class="w-24 h-24 object-contain border rounded-lg">
                                            <button type="button" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                                                <i class="fas fa-trash"></i> Remove Logo
                                            </button>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Academic Year -->
                            <div id="academic" class="settings-content">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-calendar-alt"></i>
                                            Current Academic Year
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">School Year <span>*</span></label>
                                                <input type="text" name="current_school_year" class="form-input" 
                                                    value="{{ $settings['current_school_year'] ?? '2024-2025' }}"
                                                    placeholder="e.g., 2024-2025">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" name="school_year_start" class="form-input" 
                                                    value="{{ $settings['school_year_start'] ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">End Date</label>
                                                <input type="date" name="school_year_end" class="form-input" 
                                                    value="{{ $settings['school_year_end'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-clock"></i>
                                            Grading Periods
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">Grading System</label>
                                                <select name="grading_system" class="form-select">
                                                    <option value="quarterly" {{ ($settings['grading_system'] ?? '') == 'quarterly' ? 'selected' : '' }}>Quarterly (4 Quarters)</option>
                                                    <option value="semestral" {{ ($settings['grading_system'] ?? '') == 'semestral' ? 'selected' : '' }}>Semestral (2 Semesters)</option>
                                                    <option value="trimestral" {{ ($settings['grading_system'] ?? '') == 'trimestral' ? 'selected' : '' }}>Trimestral (3 Terms)</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Passing Grade (%)</label>
                                                <input type="number" name="passing_grade" class="form-input" 
                                                    value="{{ $settings['passing_grade'] ?? '75' }}"
                                                    min="0" max="100">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Notifications -->
                            <div id="notifications" class="settings-content">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-envelope"></i>
                                            Email Notifications
                                        </h3>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>New Student Enrollment</h4>
                                                <p>Send email when new student is enrolled</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['notify_new_student'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="notify_new_student"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Attendance Alerts</h4>
                                                <p>Notify parents when student is absent</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['notify_attendance'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="notify_attendance"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Grade Updates</h4>
                                                <p>Send notification when grades are published</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['notify_grades'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="notify_grades"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>System Announcements</h4>
                                                <p>Send system-wide announcements to all users</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['notify_announcements'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="notify_announcements"></div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-mobile-alt"></i>
                                            SMS Notifications
                                        </h3>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Enable SMS Notifications</h4>
                                                <p>Send SMS alerts to parents and teachers</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['sms_enabled'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="sms_enabled"></div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="form-label">SMS Provider</label>
                                            <select name="sms_provider" class="form-select">
                                                <option value="twilio" {{ ($settings['sms_provider'] ?? '') == 'twilio' ? 'selected' : '' }}>Twilio</option>
                                                <option value="vonage" {{ ($settings['sms_provider'] ?? '') == 'vonage' ? 'selected' : '' }}>Vonage (Nexmo)</option>
                                                <option value="plivo" {{ ($settings['sms_provider'] ?? '') == 'plivo' ? 'selected' : '' }}>Plivo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Security -->
                            <div id="security" class="settings-content">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-lock"></i>
                                            Password Policy
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">Minimum Password Length</label>
                                                <input type="number" name="min_password_length" class="form-input" 
                                                    value="{{ $settings['min_password_length'] ?? '8' }}"
                                                    min="6" max="32">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Password Expiry (days)</label>
                                                <input type="number" name="password_expiry" class="form-input" 
                                                    value="{{ $settings['password_expiry'] ?? '90' }}"
                                                    min="0" placeholder="0 = never">
                                            </div>
                                        </div>

                                        <div class="toggle-wrapper mt-4">
                                            <div class="toggle-info">
                                                <h4>Require Strong Passwords</h4>
                                                <p>Require uppercase, lowercase, numbers, and symbols</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['strong_passwords'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="strong_passwords"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Two-Factor Authentication</h4>
                                                <p>Require 2FA for admin accounts</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['require_2fa'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="require_2fa"></div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-user-shield"></i>
                                            Session & Login
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">Session Timeout (minutes)</label>
                                                <input type="number" name="session_timeout" class="form-input" 
                                                    value="{{ $settings['session_timeout'] ?? '30' }}"
                                                    min="5" max="480">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Max Login Attempts</label>
                                                <input type="number" name="max_login_attempts" class="form-input" 
                                                    value="{{ $settings['max_login_attempts'] ?? '5' }}"
                                                    min="3" max="10">
                                            </div>
                                        </div>

                                        <div class="toggle-wrapper mt-4">
                                            <div class="toggle-info">
                                                <h4>Login Notifications</h4>
                                                <p>Send email alert on new device login</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['login_notifications'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="login_notifications"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Appearance -->
                            <div id="appearance" class="settings-content">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-palette"></i>
                                            Theme Colors
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="form-group">
                                                <label class="form-label">Primary Color</label>
                                                <div class="color-picker-wrapper">
                                                    <div class="color-picker">
                                                        <input type="color" name="primary_color" 
                                                            value="{{ $settings['primary_color'] ?? '#6366f1' }}">
                                                    </div>
                                                    <input type="text" class="form-input" style="width: 120px;"
                                                        value="{{ $settings['primary_color'] ?? '#6366f1' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Secondary Color</label>
                                                <div class="color-picker-wrapper">
                                                    <div class="color-picker">
                                                        <input type="color" name="secondary_color" 
                                                            value="{{ $settings['secondary_color'] ?? '#10b981' }}">
                                                    </div>
                                                    <input type="text" class="form-input" style="width: 120px;"
                                                        value="{{ $settings['secondary_color'] ?? '#10b981' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Accent Color</label>
                                                <div class="color-picker-wrapper">
                                                    <div class="color-picker">
                                                        <input type="color" name="accent_color" 
                                                            value="{{ $settings['accent_color'] ?? '#f59e0b' }}">
                                                    </div>
                                                    <input type="text" class="form-input" style="width: 120px;"
                                                        value="{{ $settings['accent_color'] ?? '#f59e0b' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <h3 class="section-title">
                                            <i class="fas fa-desktop"></i>
                                            Layout Options
                                        </h3>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Compact Mode</h4>
                                                <p>Use compact spacing for dense information display</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['compact_mode'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="compact_mode"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Dark Mode</h4>
                                                <p>Enable dark theme for the admin panel</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['dark_mode'] ?? false) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="dark_mode"></div>
                                        </div>

                                        <div class="toggle-wrapper">
                                            <div class="toggle-info">
                                                <h4>Animations</h4>
                                                <p>Enable page transitions and hover effects</p>
                                            </div>
                                            <div class="toggle-switch {{ ($settings['animations'] ?? true) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this)" data-name="animations"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="submit" class="btn-primary">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Backup & Data -->
                            <div id="backup" class="settings-content">
                                <div class="section-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-cloud-download-alt"></i>
                                        Database Backup
                                    </h3>

                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                                            <div>
                                                <p class="font-semibold text-blue-900">Last Backup</p>
                                                <p class="text-sm text-blue-700">{{ $settings['last_backup'] ?? 'Never' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <button type="button" class="btn-primary" onclick="createBackup()">
                                            <i class="fas fa-download"></i> Download Backup Now
                                        </button>
                                        <button type="button" class="btn-secondary" onclick="scheduleBackup()">
                                            <i class="fas fa-calendar"></i> Schedule Auto-Backup
                                        </button>
                                    </div>

                                    <div class="toggle-wrapper">
                                        <div class="toggle-info">
                                            <h4>Auto-Backup</h4>
                                            <p>Automatically backup database daily</p>
                                        </div>
                                        <div class="toggle-switch {{ ($settings['auto_backup'] ?? false) ? 'active' : '' }}" 
                                             onclick="toggleSwitch(this)" data-name="auto_backup"></div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-file-export"></i>
                                        Data Export
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <button type="button" class="btn-secondary" onclick="exportData('students')">
                                            <i class="fas fa-users"></i> Export Students
                                        </button>
                                        <button type="button" class="btn-secondary" onclick="exportData('teachers')">
                                            <i class="fas fa-chalkboard-teacher"></i> Export Teachers
                                        </button>
                                        <button type="button" class="btn-secondary" onclick="exportData('grades')">
                                            <i class="fas fa-graduation-cap"></i> Export Grades
                                        </button>
                                        <button type="button" class="btn-secondary" onclick="exportData('attendance')">
                                            <i class="fas fa-calendar-check"></i> Export Attendance
                                        </button>
                                    </div>
                                </div>

                                <div class="danger-zone">
                                    <div class="danger-zone-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Danger Zone
                                    </div>
                                    <p>These actions are irreversible. Please proceed with caution.</p>
                                    <div class="flex gap-3">
                                        <button type="button" class="btn-danger" onclick="clearCache()">
                                            <i class="fas fa-broom"></i> Clear Cache
                                        </button>
                                        <button type="button" class="btn-danger" onclick="resetSettings()">
                                            <i class="fas fa-undo"></i> Reset to Default
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Advanced -->
                            <div id="advanced" class="settings-content">
                                <div class="section-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-code"></i>
                                        API Settings
                                    </h3>

                                    <div class="form-group">
                                        <label class="form-label">API Key</label>
                                        <div class="flex gap-2">
                                            <input type="text" class="form-input font-mono" 
                                                value="{{ $settings['api_key'] ?? '************************' }}" readonly>
                                            <button type="button" class="btn-secondary" onclick="regenerateApiKey()">
                                                <i class="fas fa-sync"></i> Regenerate
                                            </button>
                                        </div>
                                    </div>

                                    <div class="toggle-wrapper mt-4">
                                        <div class="toggle-info">
                                            <h4>API Access</h4>
                                            <p>Enable external API access</p>
                                        </div>
                                        <div class="toggle-switch {{ ($settings['api_enabled'] ?? false) ? 'active' : '' }}" 
                                             onclick="toggleSwitch(this)" data-name="api_enabled"></div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-terminal"></i>
                                        System Logs
                                    </h3>

                                    <div class="bg-slate-900 rounded-xl p-4 font-mono text-sm text-green-400 overflow-x-auto">
                                        <p class="opacity-50">// Recent system logs will appear here</p>
                                        <p>[2024-03-22 14:32:15] INFO: System backup completed successfully</p>
                                        <p>[2024-03-22 13:45:22] INFO: User admin logged in from 192.168.1.1</p>
                                        <p>[2024-03-22 12:20:00] INFO: Database optimized</p>
                                        <p>[2024-03-22 10:15:33] WARNING: Failed login attempt for user 'admin'</p>
                                    </div>

                                    <div class="flex gap-3 mt-4">
                                        <button type="button" class="btn-secondary" onclick="viewLogs()">
                                            <i class="fas fa-eye"></i> View Full Logs
                                        </button>
                                        <button type="button" class="btn-secondary" onclick="downloadLogs()">
                                            <i class="fas fa-download"></i> Download Logs
                                        </button>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-info-circle"></i>
                                        System Information
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div class="flex justify-between py-2 border-b border-slate-100">
                                            <span class="text-slate-500">Laravel Version</span>
                                            <span class="font-semibold">{{ app()->version() }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-slate-100">
                                            <span class="text-slate-500">PHP Version</span>
                                            <span class="font-semibold">{{ phpversion() }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-slate-100">
                                            <span class="text-slate-500">Database</span>
                                            <span class="font-semibold">{{ config('database.default') }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-slate-100">
                                            <span class="text-slate-500">Environment</span>
                                            <span class="font-semibold">{{ config('app.env') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.settings-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active from all nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Show selected content
            document.getElementById(tabId).classList.add('active');
            
            // Add active to clicked nav item
            event.target.classList.add('active');
        }

        // Toggle switch
        function toggleSwitch(element) {
            element.classList.toggle('active');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = element.dataset.name;
            input.value = element.classList.contains('active') ? '1' : '0';
            element.appendChild(input);
        }

        // Toast auto-hide
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(toast => {
                toast.classList.remove('show');
            });
        }, 4000);

        // Form functions
        function resetForm() {
            if(confirm('Reset all changes?')) {
                location.reload();
            }
        }

        function createBackup() {
            alert('Creating backup... This may take a moment.');
            // Add AJAX call here
        }

        function scheduleBackup() {
            alert('Backup scheduling modal would open here');
        }

        function exportData(type) {
            alert('Exporting ' + type + ' data...');
        }

        function clearCache() {
            if(confirm('Are you sure you want to clear system cache?')) {
                alert('Cache cleared successfully!');
            }
        }

        function resetSettings() {
            if(confirm('⚠️ WARNING: This will reset ALL settings to default values. This action cannot be undone.\\n\\nAre you sure?')) {
                alert('Settings reset to default');
            }
        }

        function regenerateApiKey() {
            if(confirm('Regenerate API key? The old key will stop working immediately.')) {
                alert('New API key generated');
            }
        }

        function viewLogs() {
            alert('Opening system logs viewer...');
        }

        function downloadLogs() {
            alert('Downloading system logs...');
        }

        // Color picker sync
        document.querySelectorAll('input[type="color"]').forEach(picker => {
            picker.addEventListener('input', function() {
                this.parentElement.nextElementSibling.value = this.value;
            });
        });
    </script>

</body>
</html>