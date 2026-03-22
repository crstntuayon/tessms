<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details | Tugawe Elementary</title>
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

        /* Enhanced Header from Teacher Profile */
        .profile-header {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .photo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            border: 4px solid white;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }

        .photo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-indicator {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .status-indicator.active {
            background: #10b981;
            color: white;
        }

        .status-indicator.inactive {
            background: #ef4444;
            color: white;
        }

        /* Tab Navigation from Teacher */
        .tab-btn {
            padding: 12px 20px;
            font-weight: 600;
            font-size: 14px;
            color: #64748b;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            cursor: pointer;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: #6366f1;
        }

        .tab-btn.active {
            color: #6366f1;
            border-bottom-color: #6366f1;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        /* Enhanced Stat Cards from Teacher */
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        /* Enhanced Info Items from Teacher */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .info-item:hover {
            background: #f1f5f9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.05);
        }

        .info-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* Enhanced Badges from Teacher */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge-info {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        /* Section Badge from Teacher */
        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border: 1px solid #c7d2fe;
            border-radius: 12px;
            font-weight: 700;
            color: #4338ca;
            font-size: 0.875rem;
        }

        /* Parent Cards Enhancement */
        .parent-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .parent-card:hover {
            background: white;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .parent-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .parent-avatar.father {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }

        .parent-avatar.mother {
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            color: #9d174d;
        }

        .parent-avatar.guardian {
            background: linear-gradient(135deg, #e9d5ff, #ddd6fe);
            color: #5b21b6;
        }

        /* Document Cards from Teacher */
        .document-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .document-card:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        .document-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Audit Trail from Teacher */
        .audit-item {
            position: relative;
            padding-left: 32px;
            padding-bottom: 24px;
            border-left: 2px solid #e2e8f0;
            margin-left: 16px;
        }

        .audit-item::before {
            content: '';
            position: absolute;
            left: -9px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #6366f1;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #6366f1;
        }

        .audit-item:last-child {
            border-left: 2px solid transparent;
            padding-bottom: 0;
        }

        .change-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            margin-top: 4px;
        }

        .change-field {
            font-weight: 600;
            color: #64748b;
        }

        .change-old {
            text-decoration: line-through;
            color: #ef4444;
            background: #fee2e2;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .change-new {
            color: #10b981;
            font-weight: 600;
            background: #d1fae5;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Enhanced Buttons from Teacher */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 12px 24px;
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
            color: white;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            padding: 12px 24px;
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

        /* Floating Action Buttons - Enhanced from Teacher */
        .fab-container {
            position: fixed;
            bottom: 32px;
            right: 32px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 50;
        }

        .fab-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 15px -3px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            border: none;
            position: relative;
        }

        .fab-btn:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.4);
        }

        .fab-btn.edit {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .fab-btn.delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .fab-btn.back {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .fab-btn.print {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .fab-tooltip {
            position: absolute;
            right: 70px;
            background: rgba(15, 23, 42, 0.9);
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .fab-btn:hover .fab-tooltip {
            opacity: 1;
            visibility: visible;
            right: 75px;
        }

        /* Toast */
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

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }

        /* Print styles */
        @media print {
            .fab-container, .sidebar, .toast { display: none !important; }
            .main-wrapper { margin-left: 0 !important; }
            .main-content { overflow: visible !important; }
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

    <div class="dashboard-container">
        @include('admin.includes.sidebar')

        <div class="main-wrapper">
            <div class="main-content">
                <div class="max-w-6xl mx-auto pb-24">

                    <!-- Enhanced Header Section -->
                    <div class="profile-header animate-fade-in">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <div class="photo-placeholder">
                                @php
                                    $name = $student->user->name ?? $student->full_name ?? 'Student';
                                    $initials = '';
                                    $words = explode(' ', $name);
                                    foreach($words as $word) {
                                        $initials .= strtoupper(substr($word, 0, 1));
                                        if(strlen($initials) >= 2) break;
                                    }
                                @endphp
                                @if($student->photo_path)
                                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Profile">
                                @else
                                    <span class="text-3xl font-bold">{{ $initials ?: 'ST' }}</span>
                                @endif
                                <div class="status-indicator {{ $student->status === 'active' ? 'active' : 'inactive' }}">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    <h1 class="text-3xl font-bold text-slate-900">{{ $name }}</h1>
                                    <span class="badge {{ $student->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        <i class="fas fa-circle text-[8px]"></i>
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </div>
                                <p class="text-slate-500 flex items-center gap-2 flex-wrap">
                                    <span class="section-badge">
                                        <i class="fas fa-graduation-cap text-xs"></i>
                                        {{ $student->grade_level ?? 'N/A' }}
                                    </span>
                                    <span class="text-slate-400">•</span>
                                    <span><i class="fas fa-id-card mr-1"></i> LRN: {{ $student->lrn ?? 'N/A' }}</span>
                                    <span class="text-slate-400">•</span>
                                    <span><i class="fas fa-envelope mr-1"></i> {{ $student->user->email ?? 'N/A' }}</span>
                                    <span class="text-slate-400">•</span>
                                    <span><i class="fas fa-hashtag mr-1"></i> ID: {{ $student->id }}</span>
                                </p>
                            </div>
                           
                        </div>
                    </div>

                    <!-- Enhanced Stats Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in stagger-1">
                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-indigo-600"></i>
                                </div>
                                <span class="text-lg font-bold text-slate-900">{{ $student->grade_level ?? 'N/A' }}</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">Grade Level</p>
                            <p class="text-xs text-slate-400 mt-1">Current enrollment</p>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-emerald-600"></i>
                                </div>
                                <span class="text-lg font-bold text-slate-900">{{ $student->section ?? 'N/A' }}</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">Section</p>
                            <p class="text-xs text-slate-400 mt-1">Class assignment</p>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-amber-600"></i>
                                </div>
                                <span class="text-lg font-bold text-slate-900">{{ $student->school_year ?? 'N/A' }}</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">School Year</p>
                            <p class="text-xs text-slate-400 mt-1">Academic period</p>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-birthday-cake text-purple-600"></i>
                                </div>
                                <span class="text-lg font-bold text-slate-900">
                                   {{ $student->age ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">Age</p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $student->birthdate ? $student->birthdate->format('M d, Y') : 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="glass-card mb-6 animate-fade-in stagger-2">
                        <div class="flex border-b border-slate-100 overflow-x-auto">
                            <button class="tab-btn active" onclick="switchTab('personal')">
                                <i class="fas fa-user mr-2"></i>Personal
                            </button>
                            <button class="tab-btn" onclick="switchTab('school')">
                                <i class="fas fa-school mr-2"></i>School Info
                            </button>
                            <button class="tab-btn" onclick="switchTab('family')">
                                <i class="fas fa-users mr-2"></i>Family
                            </button>
                            <button class="tab-btn" onclick="switchTab('address')">
                                <i class="fas fa-map-marker-alt mr-2"></i>Address
                            </button>
                            <button class="tab-btn" onclick="switchTab('documents')">
                                <i class="fas fa-folder-open mr-2"></i>Documents
                            </button>
                            <button class="tab-btn" onclick="switchTab('history')">
                                <i class="fas fa-history mr-2"></i>History
                            </button>
                        </div>
                    </div>

                    <!-- Personal Information Tab -->
                    <div id="personal" class="tab-content active">
                        <div class="glass-card p-6 mb-6 animate-fade-in stagger-3">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-user-circle text-indigo-500"></i>
                                Personal Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="info-item">
                                    <div class="info-icon bg-blue-100 text-blue-600">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Birthdate</p>
                                        <p class="font-bold text-slate-900">{{ $student->birthdate ? date('F d, Y', strtotime($student->birthdate)) : 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-indigo-100 text-indigo-600">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Birth Place</p>
                                        <p class="font-bold text-slate-900">{{ $student->birth_place ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-pink-100 text-pink-600">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Gender</p>
                                        <p class="font-bold text-slate-900 capitalize">{{ $student->gender ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-amber-100 text-amber-600">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Nationality</p>
                                        <p class="font-bold text-slate-900">{{ $student->nationality ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-rose-100 text-rose-600">
                                        <i class="fas fa-pray"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Religion</p>
                                        <p class="font-bold text-slate-900">{{ $student->religion ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">LRN</p>
                                        <p class="font-bold text-slate-900">{{ $student->lrn ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School Information Tab -->
                    <div id="school" class="tab-content">
                        <div class="glass-card p-6 mb-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-school text-emerald-500"></i>
                                School Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="info-item">
                                    <div class="info-icon bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Grade Level</p>
                                        <p class="font-bold text-slate-900">{{ $student->grade_level ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-cyan-100 text-cyan-600">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Section</p>
                                        <p class="font-bold text-slate-900">{{ $student->section ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-violet-100 text-violet-600">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Section ID</p>
                                        <p class="font-bold text-slate-900">{{ $student->section_id ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-amber-100 text-amber-600">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">School Year</p>
                                        <p class="font-bold text-slate-900">{{ $student->school_year ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-rose-100 text-rose-600">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Status</p>
                                        <span class="badge {{ $student->status === 'active' ? 'badge-success' : ($student->status === 'inactive' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon bg-blue-100 text-blue-600">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold uppercase">Enrolled Since</p>
                                        <p class="font-bold text-slate-900">{{ $student->created_at ? $student->created_at->format('F d, Y') : 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Tab -->
                    <div id="family" class="tab-content">
                        <div class="glass-card p-6 mb-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-users text-purple-500"></i>
                                Parents / Guardian Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Father -->
                                <div class="parent-card">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="parent-avatar father">
                                            <i class="fas fa-male"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">Father</p>
                                            <p class="text-xs text-slate-500">{{ $student->father_occupation ?? 'Occupation not specified' }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-slate-800 mb-2">{{ $student->father_name ?? 'Not provided' }}</p>
                                    @if($student->father_contact)
                                    <p class="text-sm text-slate-600 flex items-center gap-2">
                                        <i class="fas fa-phone text-blue-500"></i>
                                        {{ $student->father_contact }}
                                    </p>
                                    @endif
                                </div>

                                <!-- Mother -->
                                <div class="parent-card">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="parent-avatar mother">
                                            <i class="fas fa-female"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">Mother</p>
                                            <p class="text-xs text-slate-500">{{ $student->mother_occupation ?? 'Occupation not specified' }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-slate-800 mb-2">{{ $student->mother_name ?? 'Not provided' }}</p>
                                    @if($student->mother_contact)
                                    <p class="text-sm text-slate-600 flex items-center gap-2">
                                        <i class="fas fa-phone text-pink-500"></i>
                                        {{ $student->mother_contact }}
                                    </p>
                                    @endif
                                </div>

                                <!-- Guardian -->
                                <div class="parent-card">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="parent-avatar guardian">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">Guardian</p>
                                            <p class="text-xs text-slate-500">{{ $student->guardian_relationship ?? 'Relationship not specified' }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-slate-800 mb-2">{{ $student->guardian_name ?? 'Not provided' }}</p>
                                    @if($student->guardian_contact)
                                    <p class="text-sm text-slate-600 flex items-center gap-2 mt-2">
                                        <i class="fas fa-phone text-purple-500"></i>
                                        {{ $student->guardian_contact }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div id="address" class="tab-content">
                        <div class="glass-card p-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-amber-500"></i>
                                Address Information
                            </h3>
                            <div class="flex items-start gap-4 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-home text-amber-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-lg font-semibold text-slate-900 mb-2">Complete Address</p>
                                    <p class="text-slate-600 leading-relaxed">
                                        {{ $student->street_address ?? 'Street not provided' }}, 
                                        {{ $student->barangay ?? 'Barangay not provided' }}, 
                                        {{ $student->city ?? 'City not provided' }}, 
                                        {{ $student->province ?? 'Province not provided' }} 
                                        {{ $student->zip_code ?? '' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Street</p>
                                    <p class="font-semibold text-slate-900">{{ $student->street_address ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Barangay</p>
                                    <p class="font-semibold text-slate-900">{{ $student->barangay ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <p class="text-xs text-slate-500 font-semibold uppercase mb-1">City</p>
                                    <p class="font-semibold text-slate-900">{{ $student->city ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Zip Code</p>
                                    <p class="font-semibold text-slate-900">{{ $student->zip_code ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Tab -->
                    <div id="documents" class="tab-content">
                        <div class="glass-card p-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-folder-open text-indigo-500"></i>
                                Documents & Attachments
                            </h3>
                            
                            @php
                                $documents = [
                                    ['path' => $student->birth_certificate_path, 'name' => 'Birth Certificate', 'icon' => 'fa-file-alt', 'color' => 'blue'],
                                    ['path' => $student->report_card_path, 'name' => 'Report Card', 'icon' => 'fa-graduation-cap', 'color' => 'emerald'],
                                    ['path' => $student->good_moral_path, 'name' => 'Good Moral Certificate', 'icon' => 'fa-certificate', 'color' => 'amber'],
                                    ['path' => $student->medical_record_path, 'name' => 'Medical Record', 'icon' => 'fa-file-medical', 'color' => 'rose'],
                                    ['path' => $student->id_picture_path, 'name' => 'ID Picture', 'icon' => 'fa-image', 'color' => 'purple'],
                                    ['path' => $student->enrollment_form_path, 'name' => 'Enrollment Form', 'icon' => 'fa-file-signature', 'color' => 'cyan']
                                ];
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($documents as $doc)
                                    <div class="document-card">
                                        <div class="flex items-center gap-4">
                                            <div class="document-icon bg-{{ $doc['color'] }}-100 text-{{ $doc['color'] }}-600">
                                                <i class="fas {{ $doc['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $doc['name'] }}</p>
                                                <p class="text-xs text-slate-500">
                                                    {{ $doc['path'] ? 'Uploaded' : 'Not uploaded' }}
                                                </p>
                                            </div>
                                        </div>
                                        @if($doc['path'])
                                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn-primary text-sm py-2 px-4">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @else
                                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-sm font-semibold">Missing</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- History Tab -->
                    <div id="history" class="tab-content">
                        <div class="glass-card p-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <i class="fas fa-history text-indigo-500"></i>
                                Edit History & Audit Trail
                            </h3>
                            
                            @if(isset($auditLogs) && count($auditLogs) > 0)
                                <div class="space-y-0">
                                    @foreach($auditLogs as $log)
                                        <div class="audit-item">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-bold text-slate-900">{{ $log->action }} by {{ $log->user->name ?? 'System' }}</p>
                                                    <p class="text-sm text-slate-500">{{ $log->created_at->format('F d, Y h:i A') }}</p>
                                                </div>
                                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                                                    {{ $log->ip_address ?? 'N/A' }}
                                                </span>
                                            </div>
                                            @if($log->changes)
                                                <div class="bg-slate-50 rounded-lg p-3 space-y-1">
                                                    @foreach($log->changes as $field => $change)
                                                        <div class="change-item">
                                                            <span class="change-field">{{ ucwords(str_replace('_', ' ', $field)) }}:</span>
                                                            <span class="change-old">{{ $change['old'] ?? 'N/A' }}</span>
                                                            <i class="fas fa-arrow-right text-slate-400"></i>
                                                            <span class="change-new">{{ $change['new'] ?? 'N/A' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-clipboard-check text-2xl text-slate-400"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-900 mb-2">No Edit History</h4>
                                    <p class="text-slate-500 text-sm max-w-md mx-auto">
                                        No changes have been recorded yet. When the student record is edited, those changes will appear here.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="flex items-center justify-between text-sm text-slate-500 mt-8 animate-fade-in">
                        <div class="flex items-center gap-6">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-clock"></i>
                                Created: {{ $student->created_at ? $student->created_at->format('M d, Y h:i A') : 'N/A' }}
                            </span>
                            @if($student->updated_at && $student->updated_at != $student->created_at)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-sync"></i>
                                Updated: {{ $student->updated_at->format('M d, Y h:i A') }}
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span>Active Record</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="fab-container">
        <form id="deleteForm" action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="m-0 p-0">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete()" class="fab-btn delete">
                <i class="fas fa-trash-alt"></i>
                <span class="fab-tooltip">Delete Student</span>
            </button>
        </form>
        
        <button onclick="window.print()" class="fab-btn print">
            <i class="fas fa-print"></i>
            <span class="fab-tooltip">Print Profile</span>
        </button>
        
        <a href="{{ route('admin.students.edit', $student->id) }}" class="fab-btn edit">
            <i class="fas fa-edit"></i>
            <span class="fab-tooltip">Edit Student</span>
        </a>
        
        <a href="{{ route('admin.students.index') }}" class="fab-btn back">
            <i class="fas fa-arrow-left"></i>
            <span class="fab-tooltip">Back to List</span>
        </a>
    </div>

    <script>
        // Toast auto-hide
        @if(session('success'))
        setTimeout(() => {
            document.getElementById('successToast')?.classList.remove('show');
        }, 4000);
        @endif

        // Tab switching
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // Confirm delete
        function confirmDelete() {
            if(confirm('⚠️ Are you sure you want to delete this student?\\n\\nThis action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if(e.altKey && e.key === 'e') {
                e.preventDefault();
                window.location.href = "{{ route('admin.students.edit', $student->id) }}";
            }
            if(e.altKey && e.key === 'b') {
                e.preventDefault();
                window.location.href = "{{ route('admin.students.index') }}";
            }
            if(e.altKey && e.key === 'd') {
                e.preventDefault();
                confirmDelete();
            }
            if(e.altKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>

</body>
</html>