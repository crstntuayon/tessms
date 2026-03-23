<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tugawe ES - SMS - Teacher Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 18rem; /* 288px = w-72 */
            --header-height: 4rem;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        
        /* ===== LAYOUT FIXES ===== */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Fixed: Sidebar uses w-72 (18rem), main content uses lg:ml-72 */
        .main-content {
            flex: 1;
            margin-left: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        
        @media (min-width: 1024px) {
            .main-content {
                margin-left: var(--sidebar-width); /* 18rem = w-72 */
            }
        }
        
        /* ===== GLASSMORPHISM ENHANCEMENTS ===== */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        
        .glass-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            transform: translateY(-2px);
        }
        
        .gradient-primary { 
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-primary::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        
        /* ===== ANIMATIONS ===== */
        @keyframes slideIn { 
            from { transform: translateX(100%); opacity: 0; } 
            to { transform: translateX(0); opacity: 1; } 
        }
        
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
        
        /* ===== UTILITY CLASSES ===== */
        .card-hover { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
        .attendance-btn { 
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
        .attendance-btn.active-present { 
            background-color: #10b981; 
            border-color: #10b981; 
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .attendance-btn.active-absent { 
            background-color: #ef4444; 
            border-color: #ef4444; 
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .attendance-btn.active-late { 
            background-color: #f59e0b; 
            border-color: #f59e0b; 
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        
        .grade-excellent { color: #059669; background-color: #d1fae5; }
        .grade-good { color: #d97706; background-color: #fef3c7; }
        .grade-needs-improvement { color: #dc2626; background-color: #fee2e2; }
        
        .loading { opacity: 0.6; pointer-events: none; }
        
        .toast { 
            animation: slideIn 0.3s ease-out; 
            backdrop-filter: blur(8px);
        }
        
        /* Clock Styles */
        .live-clock {
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.05em;
            font-feature-settings: "tnum";
        }
        
        /* Success Modal */
        .success-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        .success-modal {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255,255,255,0.5) inset;
            animation: scaleIn 0.3s ease;
            border: 1px solid rgba(255,255,255,0.6);
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .countdown-ring {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(#10b981 calc(var(--progress) * 1%), #e5e7eb 0);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .countdown-ring::before {
            content: '';
            position: absolute;
            inset: 8px;
            background: white;
            border-radius: 50%;
        }
        
        .countdown-number {
            position: relative;
            font-size: 1.5rem;
            font-weight: 700;
            color: #059669;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Mobile Optimizations */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">

    <!-- Login Success Message with Countdown -->
    @if(session('login_success'))
    <div id="loginSuccessModal" class="success-overlay">
        <div class="success-modal">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/30">
                <i class="fas fa-check-circle text-3xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Welcome Back!</h3>
            <p class="text-slate-600 mb-4">Login successful. Redirecting to dashboard...</p>
            
            <div class="countdown-ring" id="countdownRing" style="--progress: 100;">
                <span class="countdown-number" id="countdownNumber">3</span>
            </div>
            
            <p class="text-sm text-slate-500">Please wait while we prepare your workspace</p>
        </div>
    </div>
    
    <script>
        (function() {
            let countdown = 3;
            const countdownNumber = document.getElementById('countdownNumber');
            const countdownRing = document.getElementById('countdownRing');
            const modal = document.getElementById('loginSuccessModal');
            
            const interval = setInterval(() => {
                countdown--;
                countdownNumber.textContent = countdown;
                countdownRing.style.setProperty('--progress', (countdown / 3) * 100);
                
                if (countdown <= 0) {
                    clearInterval(interval);
                    modal.style.opacity = '0';
                    modal.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => modal.remove(), 300);
                }
            }, 1000);
        })();
    </script>
    @endif

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 z-40 hidden lg:hidden bg-slate-900/30 backdrop-blur-sm transition-opacity duration-300" onclick="toggleSidebar()"></div>

    <!-- Main Layout - FIXED -->
    <div class="dashboard-container">
        
        <!-- Sidebar - Fixed at w-72 (18rem) -->
        @include('teacher.includes.sidebar')

        <!-- Main Content - ml-72 matches sidebar width exactly -->
        <div class="main-content w-full">
            
            <!-- Enhanced Glass Header -->
            <header class="glass-header sticky top-0 z-30 h-16 flex-shrink-0">
                <div class="flex items-center justify-between h-full px-4 lg:px-8">
                    <div class="flex items-center gap-4">
                        <button class="lg:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all" onclick="toggleMobileMenu()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="hidden sm:block">
                            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Teacher Dashboard</h2>
                            <div class="flex items-center gap-2 text-sm text-slate-500 mt-0.5">
                                <span>SY {{ $schoolYear ?? '2024-2025' }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-indigo-600 font-medium">{{ $currentQuarter ?? '1st' }} Quarter</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 lg:gap-6">
                        <!-- Enhanced Real-time Clock Widget -->
                        <div class="hidden md:flex items-center gap-3 bg-gradient-to-r from-indigo-50 to-blue-50 px-4 py-2 rounded-2xl border border-indigo-100/80 shadow-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-indigo-600 animate-pulse"></i>
                                <div class="flex flex-col">
                                    <span id="liveClock" class="live-clock text-sm font-bold text-indigo-900 font-mono">00:00:00</span>
                                    <span id="liveDate" class="text-[10px] text-indigo-600 font-medium uppercase tracking-wider">{{ now()->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="h-6 w-px bg-indigo-200"></div>
                            <div class="flex items-center gap-1.5 text-sm text-indigo-700 font-medium">
                                <i class="fas fa-calendar-day text-indigo-500"></i>
                                <span>{{ now()->format('l') }}</span>
                            </div>
                        </div>
                        
                        <!-- Enhanced Notifications -->
                        <div class="relative">
                            <button class="relative p-2.5 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all group" onclick="toggleNotifications()">
                                <i class="fas fa-bell text-xl group-hover:scale-110 transition-transform"></i>
                                @if(($unreadNotifications ?? 0) > 0)
                                    <span class="absolute top-1 right-1 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-pulse">
                                        {{ $unreadNotifications }}
                                    </span>
                                @endif
                            </button>
                            
                            <!-- Glass Notifications Dropdown -->
                            <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-slate-200/50 border border-slate-100/80 z-50 max-h-96 overflow-hidden transform origin-top-right transition-all duration-200">
                                <div class="p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex justify-between items-center">
                                    <h4 class="font-bold text-slate-800">Notifications</h4>
                                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-medium">{{ $unreadNotifications ?? 0 }} new</span>
                                </div>
                                <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                    @forelse($notifications ?? [] as $notification)
                                        <div class="p-4 border-b border-slate-50 hover:bg-indigo-50/50 cursor-pointer transition-colors {{ $notification->read_at ? '' : 'bg-indigo-50/30 border-l-4 border-l-indigo-500' }}">
                                            <div class="flex gap-3">
                                                <div class="w-8 h-8 rounded-full {{ $notification->read_at ? 'bg-slate-100' : 'bg-indigo-100' }} flex items-center justify-center flex-shrink-0">
                                                    <i class="fas {{ $notification->data['icon'] ?? 'fa-info' }} text-xs {{ $notification->read_at ? 'text-slate-500' : 'text-indigo-600' }}"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-slate-800">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                    <p class="text-xs text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() ?? 'Just now' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center">
                                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-bell-slash text-slate-400"></i>
                                            </div>
                                            <p class="text-sm text-slate-500">No notifications yet</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if(($notifications ?? collect())->count() > 0)
                                <div class="p-3 border-t border-slate-100 bg-slate-50 text-center">
                                    <a href="{{ route('teacher.notifications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline">View All</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Enhanced User Profile -->
                        <div class="flex items-center gap-3 pl-3 lg:pl-6 border-l border-slate-200">
                            <div class="hidden lg:block text-right">
                                <p class="text-sm font-bold text-slate-800">{{ $teacher->user->name ?? 'Teacher' }}</p>
                                <p class="text-xs text-slate-500">Class Adviser</p>
                            </div>
                            <div class="relative group cursor-pointer">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white group-hover:ring-indigo-200 transition-all">
                                    {{ substr($teacher->user->name ?? 'T', 0, 1) }}
                                </div>
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-8 bg-slate-50/50 custom-scrollbar">
                <div class="max-w-7xl mx-auto space-y-6">
                    
                    <!-- Enhanced Welcome Banner -->
                    <div class="gradient-primary rounded-3xl p-6 lg:p-8 text-white shadow-2xl relative overflow-hidden animate-fade-in">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-16 -mb-16 blur-3xl"></div>
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="max-w-2xl">
                                <h1 class="text-2xl md:text-4xl font-bold mb-3 tracking-tight">
                                    @php
                                        $hour = now()->format('H');
                                        $greeting = $hour < 12 ? 'Magandang Umaga' : ($hour < 18 ? 'Magandang Hapon' : 'Magandang Gabi');
                                    @endphp
                                    {{ $greeting }}, {{ explode(' ', $teacher->user->name ?? 'Teacher')[0] }}! 👋
                                </h1>
                                <p class="text-indigo-100 text-lg font-light">Ready to nurture young minds today? Let's make learning magical.</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="bg-white/20 backdrop-blur-md rounded-2xl p-4 text-center min-w-[120px] border border-white/20 shadow-lg">
                                    <div class="text-3xl font-bold">{{ $schoolDaysTotal ?? 0 }}</div>
                                    <div class="text-xs text-indigo-100 uppercase tracking-wider font-medium mt-1">School Days</div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-md rounded-2xl p-4 text-center min-w-[120px] border border-white/20 shadow-lg">
                                    <div class="text-3xl font-bold">{{ $daysCompleted ?? 0 }}</div>
                                    <div class="text-xs text-indigo-100 uppercase tracking-wider font-medium mt-1">Completed</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Metrics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Pupils -->
                        <div class="glass-card rounded-2xl p-6 card-hover border-l-4 border-indigo-500">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-slate-500 text-sm font-medium mb-1 uppercase tracking-wider">Total Pupils</p>
                                    <h3 class="text-3xl font-bold text-slate-800">{{ $totalStudents ?? 0 }}</h3>
                                </div>
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <span class="flex items-center gap-1.5 text-emerald-600 font-medium bg-emerald-50 px-2 py-1 rounded-lg">
                                    <i class="fas fa-mars text-xs"></i> {{ $maleStudents ?? 0 }}
                                </span>
                                <span class="flex items-center gap-1.5 text-rose-600 font-medium bg-rose-50 px-2 py-1 rounded-lg">
                                    <i class="fas fa-venus text-xs"></i> {{ $femaleStudents ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <!-- Today's Attendance -->
                        <div class="glass-card rounded-2xl p-6 card-hover border-l-4 border-emerald-500">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-slate-500 text-sm font-medium mb-1 uppercase tracking-wider">Attendance</p>
                                    <h3 class="text-3xl font-bold text-slate-800">{{ $todayAttendanceRate ?? 0 }}%</h3>
                                </div>
                                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shadow-sm">
                                    <i class="fas fa-clipboard-check text-xl"></i>
                                </div>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 mb-3 overflow-hidden">
                                <div class="bg-emerald-500 h-2 rounded-full transition-all duration-700 ease-out shadow-sm" style="width: {{ $todayAttendanceRate ?? 0 }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-slate-500 font-medium">
                                <span class="text-emerald-600">{{ $todayStats['present'] ?? 0 }} Present</span>
                                <span class="text-rose-600">{{ $todayStats['absent'] ?? 0 }} Absent</span>
                                <span class="text-amber-600">{{ $todayStats['late'] ?? 0 }} Late</span>
                            </div>
                        </div>

                        <!-- Pending Grades -->
                        <div class="glass-card rounded-2xl p-6 card-hover border-l-4 border-violet-500">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-slate-500 text-sm font-medium mb-1 uppercase tracking-wider">Pending Grades</p>
                                    <h3 class="text-3xl font-bold text-slate-800">{{ $pendingGradesCount ?? 0 }}</h3>
                                </div>
                                <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 shadow-sm">
                                    <i class="fas fa-tasks text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                @if(($overdueGrading ?? 0) > 0)
                                    <span class="text-rose-600 font-medium flex items-center gap-1.5 bg-rose-50 px-2 py-1 rounded-lg">
                                        <i class="fas fa-exclamation-circle text-xs"></i> {{ $overdueGrading }} Overdue
                                    </span>
                                @else
                                    <span class="text-emerald-600 font-medium flex items-center gap-1.5 bg-emerald-50 px-2 py-1 rounded-lg">
                                        <i class="fas fa-check-circle text-xs"></i> All Caught Up
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- At Risk Pupils -->
                        <div class="glass-card rounded-2xl p-6 card-hover border-l-4 border-rose-500">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-slate-500 text-sm font-medium mb-1 uppercase tracking-wider">At Risk</p>
                                    <h3 class="text-3xl font-bold text-slate-800">{{ $atRiskCount ?? 0 }}</h3>
                                </div>
                                <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 shadow-sm">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="text-rose-600 font-medium bg-rose-50 px-2 py-1 rounded-lg">{{ $failingGradesCount ?? 0 }} Failing</span>
                                <span class="text-amber-600 font-medium bg-amber-50 px-2 py-1 rounded-lg">{{ $chronicAbsentees ?? 0 }} Chronic</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Grid Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Daily Attendance -->
                        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Daily Attendance</h3>
                                    <p class="text-sm text-slate-500 mt-1">{{ now()->format('F d, Y') }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="px-4 py-2 text-sm bg-emerald-100 text-emerald-700 rounded-xl hover:bg-emerald-200 transition-all font-medium flex items-center gap-2 shadow-sm" onclick="markAllPresent()">
                                        <i class="fas fa-check"></i> All Present
                                    </button>
                                    <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 text-sm font-medium shadow-lg shadow-indigo-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2" onclick="saveAttendance()" id="saveAttendanceBtn">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                            
                            <form id="attendanceForm" action="{{ route('teacher.attendance.bulk-store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
                                <input type="hidden" name="section_id" value="{{ $activeSection->id ?? '' }}">
                                
                                <div class="overflow-x-auto max-h-[500px] overflow-y-auto rounded-2xl border border-slate-200 custom-scrollbar bg-white/50">
                                    <table class="w-full">
                                        <thead class="bg-slate-50/80 backdrop-blur-sm text-left sticky top-0 z-10">
                                            <tr>
                                                <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Learner Name</th>
                                                <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center tracking-wider">Status</th>
                                                <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100" id="attendanceTableBody">
                                            @forelse($students ?? [] as $student)
                                            @php
                                                $todayRecord = $student->attendances->where('date', now()->format('Y-m-d'))->first();
                                                $currentStatus = $todayRecord ? $todayRecord->status : null;
                                            @endphp
                                            <tr class="hover:bg-slate-50/80 transition-colors" data-student-id="{{ $student->id }}">
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 text-white flex items-center justify-center text-sm font-bold shadow-md">
                                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold text-slate-800">{{ $student->last_name }}, {{ $student->first_name }}</p>
                                                            <p class="text-xs text-slate-500 font-mono">LRN: {{ $student->lrn }}</p>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="attendance[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center gap-3">
                                                        <button type="button" 
                                                                class="attendance-btn w-10 h-10 rounded-full border-2 {{ $currentStatus === 'present' ? 'active-present' : 'border-slate-200 hover:border-emerald-400 bg-white' }} hover:scale-110 transition-all flex items-center justify-center shadow-sm" 
                                                                data-status="present"
                                                                onclick="setAttendance(this, '{{ $student->id }}', 'present')"
                                                                title="Present">
                                                            <i class="fas fa-check text-sm"></i>
                                                        </button>
                                                        <button type="button" 
                                                                class="attendance-btn w-10 h-10 rounded-full border-2 {{ $currentStatus === 'absent' ? 'active-absent' : 'border-slate-200 hover:border-rose-400 bg-white' }} hover:scale-110 transition-all flex items-center justify-center shadow-sm" 
                                                                data-status="absent"
                                                                onclick="setAttendance(this, '{{ $student->id }}', 'absent')"
                                                                title="Absent">
                                                            <i class="fas fa-times text-sm"></i>
                                                        </button>
                                                        <button type="button" 
                                                                class="attendance-btn w-10 h-10 rounded-full border-2 {{ $currentStatus === 'late' ? 'active-late' : 'border-slate-200 hover:border-amber-400 bg-white' }} hover:scale-110 transition-all flex items-center justify-center shadow-sm" 
                                                                data-status="late"
                                                                onclick="setAttendance(this, '{{ $student->id }}', 'late')"
                                                                title="Late">
                                                            <i class="fas fa-clock text-sm"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="attendance[{{ $student->id }}][status]" id="status-{{ $student->id }}" value="{{ $currentStatus }}">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="text" 
                                                           name="attendance[{{ $student->id }}][remarks]" 
                                                           class="w-full text-sm border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 bg-slate-50 focus:bg-white transition-all" 
                                                           placeholder="e.g., Excused, Sick"
                                                           value="{{ $todayRecord->remarks ?? '' }}">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-12 text-center text-slate-500">
                                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <i class="fas fa-users-slash text-2xl text-slate-400"></i>
                                                    </div>
                                                    <p class="font-medium text-slate-700">No pupils enrolled yet</p>
                                                    <a href="{{ route('teacher.sections.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mt-3 inline-block font-medium hover:underline">Select a section</a>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <!-- Sidebar Widgets -->
                        <div class="space-y-6">
                            <!-- Section Selector -->
                            <div class="glass-card rounded-2xl p-6">
                                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-chalkboard-teacher text-indigo-500"></i>
                                    Active Section
                                </h3>
                                <form action="{{ route('teacher.dashboard') }}" method="GET" id="sectionForm">
                                    <select name="section_id" onchange="document.getElementById('sectionForm').submit()" 
        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 hover:bg-white transition-all cursor-pointer font-medium text-slate-700 shadow-sm">
    
    @foreach($sections ?? [] as $section)
        <option value="{{ $section->id }}" {{ ($activeSection->id ?? '') == $section->id ? 'selected' : '' }}>
            Grade {{ $section->gradeLevel->name ?? 'N/A' }} 
            - {{ $section->name }} 
            ({{ $section->students->count() }} students)
        </option>
    @endforeach

</select>
                                </form>
                                
                                @if($activeSection ?? false)
                                <div class="mt-4 p-4 bg-indigo-50/50 rounded-xl border border-indigo-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-indigo-800">Adviser:</span>
                                        <span class="text-sm text-indigo-600 font-medium">{{ 
    ($activeSection->teacher->first_name ?? '') . ' ' . 
    ($activeSection->teacher->middle_name ?? '') . ' ' . 
    ($activeSection->teacher->last_name ?? '') 
    ?: 'N/A' 
}}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-indigo-800">Room:</span>
                                        <span class="text-sm text-indigo-600 font-medium">{{ $activeSection->room_number ?? 'TBA' }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Calendar -->
                            <div class="glass-card rounded-2xl p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-slate-800">Attendance Calendar</h3>
                                    <span class="text-sm text-slate-500 font-medium bg-slate-100 px-3 py-1 rounded-full">{{ now()->format('F Y') }}</span>
                                </div>
                                
                                <div class="grid grid-cols-7 gap-1 text-center text-xs mb-3 text-slate-400 font-bold">
                                    <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                                </div>
                                <div class="grid grid-cols-7 gap-1" id="attendanceCalendar"></div>
                                
                                <div class="mt-4 flex gap-3 text-xs justify-center bg-slate-50 p-3 rounded-xl">
                                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm"></div><span class="text-slate-600 font-medium">Present</span></div>
                                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-rose-500 shadow-sm"></div><span class="text-slate-600 font-medium">Absent</span></div>
                                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-amber-500 shadow-sm"></div><span class="text-slate-600 font-medium">Late</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subject Performance -->
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-chart-line text-indigo-500"></i>
                                    Subject Performance
                                </h3>
                                <p class="text-sm text-slate-500 mt-1">{{ $currentQuarter ?? '1st' }} Quarter • Based on encoded grades</p>
                            </div>
                            <div class="flex gap-2">
                                <select id="subjectFilter" onchange="filterSubjects(this.value)" class="px-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 hover:border-slate-300 transition-all cursor-pointer bg-white shadow-sm font-medium">
                                    <option value="all">All Subjects</option>
                                    @foreach($subjects ?? [] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('teacher.exports.sf9', ['section_id' => $activeSection->id ?? '']) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 text-sm font-medium shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                    <i class="fas fa-download"></i> SF9
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6" id="subjectCards">
                            @foreach($subjectStats ?? [] as $stats)
                            <div class="subject-card border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all hover:border-indigo-300 cursor-pointer bg-white/50 backdrop-blur-sm" data-subject-id="{{ $stats['subject_id'] }}">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-{{ $stats['color'] ?? 'indigo' }}-100 rounded-lg flex items-center justify-center text-{{ $stats['color'] ?? 'indigo' }}-600 shadow-sm">
                                        <i class="fas {{ $stats['icon'] ?? 'fa-book' }}"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">{{ $stats['name'] }}</h4>
                                        <p class="text-xs text-slate-500">WW:{{ $stats['ww_weight'] ?? 0 }}% PT:{{ $stats['pt_weight'] ?? 0 }}%</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['class_average'] ?? 0, 1) }}</p>
                                        <p class="text-xs text-slate-500">Class Average</p>
                                    </div>
                                    <div class="text-right">
                                        @if(($stats['class_average'] ?? 0) >= 90)
                                            <span class="grade-excellent px-2 py-1 rounded-lg text-xs font-bold shadow-sm">Advanced</span>
                                        @elseif(($stats['class_average'] ?? 0) >= 85)
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">Proficient</span>
                                        @elseif(($stats['class_average'] ?? 0) >= 80)
                                            <span class="grade-good px-2 py-1 rounded-lg text-xs font-bold shadow-sm">Approaching</span>
                                        @elseif(($stats['class_average'] ?? 0) >= 75)
                                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">Developing</span>
                                        @else
                                            <span class="grade-needs-improvement px-2 py-1 rounded-lg text-xs font-bold shadow-sm">Beginning</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-{{ $stats['color'] ?? 'indigo' }}-500 h-1.5 rounded-full transition-all duration-700 ease-out shadow-sm" style="width: {{ min($stats['class_average'] ?? 0, 100) }}%"></div>
                                </div>
                                <div class="mt-2 flex justify-between text-xs text-slate-500 font-medium">
                                    <span>{{ $stats['encoded_count'] ?? 0 }}/{{ $totalStudents ?? 0 }} encoded</span>
                                    <span class="{{ ($stats['at_risk_count'] ?? 0) > 0 ? 'text-rose-600 font-bold' : '' }}">{{ $stats['at_risk_count'] ?? 0 }} at risk</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- At Risk Students -->
                        @if(($atRiskStudents ?? collect())->count() > 0)
                        <div class="border-t border-slate-100 pt-6">
                            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2 text-lg">
                                <i class="fas fa-user-shield text-rose-500"></i>
                                Pupils Requiring Intervention
                            </h4>
                            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white/50 custom-scrollbar">
                                <table class="w-full text-sm">
                                    <thead class="bg-slate-50/80 text-left">
                                        <tr>
                                            <th class="px-4 py-3 font-bold text-slate-600">Learner</th>
                                            @foreach($subjects ?? [] as $subject)
                                                <th class="px-4 py-3 font-bold text-slate-600 text-center">{{ $subject->code }}</th>
                                            @endforeach
                                            <th class="px-4 py-3 font-bold text-slate-600 text-center">Absences</th>
                                            <th class="px-4 py-3 font-bold text-slate-600">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($atRiskStudents as $student)
                                        <tr class="hover:bg-rose-50/50 transition-colors">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-slate-800">{{ $student->last_name }}, {{ $student->first_name }}</p>
                                                        <p class="text-xs text-slate-500 font-mono">LRN: {{ $student->lrn }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            @foreach($subjects ?? [] as $subject)
                                                @php
                                                    $grade = $student->grades->where('subject_id', $subject->id)->where('quarter', $currentQuarterNumber ?? 1)->first();
                                                    $finalGrade = $grade ? calculateFinalGrade($grade) : null;
                                                @endphp
                                                <td class="px-4 py-3 text-center">
                                                    @if($finalGrade)
                                                        <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $finalGrade < 75 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                            {{ number_format($finalGrade, 0) }}
                                                        </span>
                                                    @else
                                                        <span class="text-slate-300">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="px-4 py-3 text-center">
                                                @php
                                                    $absenceCount = $student->attendances->where('status', 'absent')->whereBetween('date', [$schoolYearStart ?? now()->subYear(), now()])->count();
                                                    $absenceRate = ($absenceCount / max($daysCompleted ?? 1, 1)) * 100;
                                                @endphp
                                                <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $absenceRate > 20 ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                                    {{ $absenceCount }} ({{ number_format($absenceRate, 0) }}%)
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button onclick="openInterventionModal('{{ $student->id }}', '{{ $student->first_name }} {{ $student->last_name }}')" 
                                                        class="text-indigo-600 hover:text-indigo-800 font-medium text-xs bg-indigo-50 px-3 py-2 rounded-lg hover:bg-indigo-100 transition-all hover:shadow-sm">
                                                    Plan Intervention
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="border-t border-slate-100 pt-6 text-center py-8">
                            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-3xl text-emerald-500"></i>
                            </div>
                            <p class="text-slate-700 font-bold text-lg">Excellent! No pupils at risk.</p>
                            <p class="text-sm text-slate-500 mt-2">All students have passing grades and good attendance.</p>
                        </div>
                        @endif
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Recent Grades -->
                        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fas fa-file-signature text-indigo-500"></i>
                                    Recent Grade Encoding
                                </h3>
                                <a href="{{ route('teacher.grades.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium hover:underline transition-all">View All</a>
                            </div>
                            
                            <div class="space-y-3">
                                @forelse($recentGrades ?? [] as $grade)
                                <div class="flex items-center gap-4 p-4 bg-slate-50/80 rounded-xl hover:bg-indigo-50/50 transition-all border border-transparent hover:border-indigo-200 cursor-pointer group">
                                    <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:shadow-md transition-all">
                                        <i class="fas fa-file-signature text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-semibold text-slate-800">{{ $grade->student->last_name }}, {{ $grade->student->first_name }}</h4>
                                                <p class="text-sm text-slate-500">{{ $grade->subject->name }} • {{ $grade->quarter }} Quarter</p>
                                            </div>
                                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-medium shadow-sm">Encoded</span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-4 text-xs text-slate-500 font-medium">
                                            <span class="bg-white px-2 py-1 rounded-lg border border-slate-100">WW: {{ $grade->written_works_avg }}%</span>
                                            <span class="bg-white px-2 py-1 rounded-lg border border-slate-100">PT: {{ $grade->performance_tasks_avg }}%</span>
                                            <span class="bg-white px-2 py-1 rounded-lg border border-slate-100">QA: {{ $grade->quarterly_assessment ?? 'N/A' }}</span>
                                            <span class="font-bold text-slate-700 bg-indigo-50 px-2 py-1 rounded-lg">Final: {{ calculateFinalGrade($grade) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8 text-slate-500">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-clipboard-list text-2xl text-slate-400"></i>
                                    </div>
                                    <p class="font-medium text-slate-700">No grades encoded yet</p>
                                    <a href="{{ route('teacher.grades.create') }}" class="mt-4 inline-block px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5">Encode First Grades</a>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-6">
                            <div class="glass-card rounded-2xl p-6">
                                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-bolt text-amber-500"></i>
                                    Quick Actions
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="{{ route('teacher.grades.create') }}" class="p-4 bg-indigo-50 hover:bg-indigo-100 rounded-xl text-center transition-all group border border-transparent hover:border-indigo-200 hover:shadow-md">
                                        <i class="fas fa-plus-circle text-2xl text-indigo-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                                        <p class="text-xs font-bold text-indigo-800">Encode Grades</p>
                                    </a>
                                    <a href="{{ route('teacher.exports.sf1') }}" class="p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl text-center transition-all group border border-transparent hover:border-emerald-200 hover:shadow-md">
                                        <i class="fas fa-file-excel text-2xl text-emerald-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                                        <p class="text-xs font-bold text-emerald-800">Export SF1</p>
                                    </a>
                                    <a href="{{ route('teacher.reports.index') }}" class="p-4 bg-violet-50 hover:bg-violet-100 rounded-xl text-center transition-all group border border-transparent hover:border-violet-200 hover:shadow-md">
                                        <i class="fas fa-chart-pie text-2xl text-violet-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                                        <p class="text-xs font-bold text-violet-800">View Reports</p>
                                    </a>
                                    <button onclick="printClassRecord()" class="p-4 bg-amber-50 hover:bg-amber-100 rounded-xl text-center transition-all group border border-transparent hover:border-amber-200 hover:shadow-md">
                                        <i class="fas fa-print text-2xl text-amber-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                                        <p class="text-xs font-bold text-amber-800">Print Record</p>
                                    </button>
                                </div>
                            </div>

                            <!-- Deadlines -->
                            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full -ml-8 -mb-8 blur-xl"></div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-bold text-lg flex items-center gap-2">
                                            <i class="fas fa-clock"></i>
                                            Deadlines
                                        </h3>
                                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm">{{ $upcomingDeadlines->count() ?? 0 }} upcoming</span>
                                    </div>
                                    <ul class="space-y-3 text-sm">
                                        @forelse($upcomingDeadlines ?? [] as $deadline)
                                        <li class="flex items-start gap-3 bg-white/10 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                                            <i class="fas fa-circle text-xs mt-1.5 {{ $deadline->is_urgent ? 'text-rose-300' : 'text-amber-300' }}"></i>
                                            <div>
                                                <span class="font-medium block">{{ $deadline->title }}</span>
                                                <p class="text-xs text-indigo-200 mt-0.5">Due {{ $deadline->due_date->diffForHumans() }}</p>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="text-indigo-200 text-center py-6 bg-white/5 rounded-xl border border-white/10">
                                            <i class="fas fa-check-circle mb-2 block text-2xl"></i>
                                            <span class="text-sm">No upcoming deadlines</span>
                                        </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Enhanced Intervention Modal -->
    <div id="interventionModal" class="fixed inset-0 bg-slate-900/40 hidden items-center justify-center z-50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 transform scale-95 transition-transform duration-300 border border-white/60" id="interventionModalContent">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-shield text-indigo-500"></i>
                    Learning Intervention Plan
                </h3>
                <button onclick="closeInterventionModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-2 hover:bg-slate-100 rounded-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="interventionForm" action="{{ route('teacher.interventions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="interventionStudentId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Learner</label>
                        <input type="text" id="interventionStudentName" class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-700 font-semibold" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Subject Area <span class="text-rose-500">*</span></label>
                        <select name="subject_id" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer hover:border-slate-300 bg-white shadow-sm">
                            <option value="">Select Subject</option>
                            @foreach($subjects ?? [] as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Intervention Type</label>
                        <select name="intervention_type" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer hover:border-slate-300 bg-white shadow-sm">
                            <option value="remedial">Remedial Classes</option>
                            <option value="peer_tutoring">Peer Tutoring</option>
                            <option value="parent_conference">Parent Conference</option>
                            <option value="module_based">Module-Based Learning</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Schedule <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="schedule" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all hover:border-slate-300 cursor-pointer bg-white shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Intervention Strategy <span class="text-rose-500">*</span></label>
                        <textarea name="description" required rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none hover:border-slate-300 bg-white shadow-sm" placeholder="Describe specific intervention strategies..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeInterventionModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 transition-all font-medium">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all font-medium">Save Plan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            const clockElement = document.getElementById('liveClock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
            
            const dateElement = document.getElementById('liveDate');
            if (dateElement) {
                const options = { month: 'short', day: 'numeric', year: 'numeric' };
                dateElement.textContent = now.toLocaleDateString('en-US', options);
            }
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        // Attendance Functions
        function setAttendance(btn, studentId, status) {
            const row = btn.closest('tr');
            row.querySelectorAll('.attendance-btn').forEach(b => {
                b.classList.remove('active-present', 'active-absent', 'active-late', 'shadow-md');
                b.classList.add('border-slate-200', 'bg-white');
            });
            
            btn.classList.remove('border-slate-200', 'bg-white');
            btn.classList.add(`active-${status}`, 'shadow-md');
            
            const input = document.getElementById(`status-${studentId}`);
            if (input) input.value = status;
            
            showToast(`Marked as ${status.charAt(0).toUpperCase() + status.slice(1)}`, 'info');
        }
        
        function markAllPresent() {
            document.querySelectorAll('tr[data-student-id]').forEach(row => {
                const studentId = row.dataset.studentId;
                const presentBtn = row.querySelector('[data-status="present"]');
                if (presentBtn) setAttendance(presentBtn, studentId, 'present');
            });
            showToast('All students marked as present', 'success');
        }
        
        function saveAttendance() {
            const form = document.getElementById('attendanceForm');
            const btn = document.getElementById('saveAttendanceBtn');
            
            const unmarked = [];
            document.querySelectorAll('input[name^="attendance["][name$="[status]"]').forEach(input => {
                if (!input.value) {
                    const studentId = input.id.replace('status-', '');
                    unmarked.push(studentId);
                }
            });
            
            if (unmarked.length > 0) {
                if (!confirm(`${unmarked.length} student(s) have no attendance marked. Continue saving?`)) {
                    return;
                }
            }
            
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.classList.remove('loading');
                btn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Attendance';
                
                if (data.success) {
                    showToast('Attendance saved successfully!', 'success');
                    updateCalendar(data.attendance_summary);
                } else {
                    showToast(data.message || 'Error saving attendance', 'error');
                }
            })
            .catch(error => {
                btn.classList.remove('loading');
                btn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Attendance';
                showToast('Network error. Please try again.', 'error');
            });
        }
        
        // Calendar
        function generateCalendar() {
            const calendar = document.getElementById('attendanceCalendar');
            if (!calendar) return;
            
            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = date.getDate();
            
            fetch(`{{ route('teacher.attendance.monthly') }}?month=${month + 1}&year=${year}&section_id={{ $activeSection->id ?? '' }}`)
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    for (let i = 0; i < firstDay; i++) {
                        html += '<div></div>';
                    }
                    
                    for (let day = 1; day <= daysInMonth; day++) {
                        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                        const dayData = data[dateStr];
                        let statusClass = 'bg-slate-100 text-slate-600 hover:bg-slate-200';
                        let indicator = '';
                        
                        if (dayData) {
                            if (dayData.present_rate > 90) statusClass = 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200';
                            else if (dayData.present_rate > 75) statusClass = 'bg-amber-100 text-amber-700 hover:bg-amber-200';
                            else statusClass = 'bg-rose-100 text-rose-700 hover:bg-rose-200';
                            indicator = `<div class="w-1.5 h-1.5 rounded-full bg-current mx-auto mt-0.5"></div>`;
                        }
                        
                        if (day === today) statusClass += ' ring-2 ring-indigo-500 font-bold bg-indigo-50 text-indigo-700 shadow-sm';
                        
                        html += `<div class="h-8 flex flex-col items-center justify-center rounded-lg text-xs cursor-pointer transition-all ${statusClass}" 
                                      onclick="viewDayAttendance('${dateStr}')" title="${dayData ? dayData.present_rate + '% present' : 'No data'}">
                                    ${day}${indicator}
                                </div>`;
                    }
                    calendar.innerHTML = html;
                })
                .catch(err => console.error('Calendar fetch error:', err));
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', generateCalendar);
        } else {
            generateCalendar();
        }
        
        function viewDayAttendance(date) {
            window.location.href = `{{ route('teacher.attendance.index') }}?date=${date}`;
        }
        
        function updateCalendar(summary) {
            setTimeout(generateCalendar, 500);
        }
        
        // Modal Functions
        function openInterventionModal(studentId, studentName) {
            const modal = document.getElementById('interventionModal');
            const content = document.getElementById('interventionModalContent');
            
            document.getElementById('interventionStudentId').value = studentId;
            document.getElementById('interventionStudentName').value = studentName;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }
        
        function closeInterventionModal() {
            const modal = document.getElementById('interventionModal');
            const content = document.getElementById('interventionModalContent');
            
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
        
        // Filter Functions
        function filterSubjects(subjectId) {
            const cards = document.querySelectorAll('.subject-card');
            cards.forEach(card => {
                if (subjectId === 'all' || card.dataset.subjectId === subjectId) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // UI Functions
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function toggleMobileMenu() {
            const sidebar = document.querySelector('aside');
            const overlay = document.getElementById('mobileOverlay');
            
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
                overlay.classList.toggle('hidden');
            }
        }
        
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const overlay = document.getElementById('mobileOverlay');
            
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }
        
        function printClassRecord() {
            const url = `{{ route('teacher.reports.class-record') }}?section_id={{ $activeSection->id ?? '' }}`;
            window.open(url, '_blank');
        }

        // Toast Notifications
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            
            const toast = document.createElement('div');
            
            const colors = {
                success: 'bg-emerald-500',
                error: 'bg-rose-500',
                info: 'bg-indigo-500',
                warning: 'bg-amber-500'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };
            
            toast.className = `toast flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-white ${colors[type]} min-w-[300px] cursor-pointer transform transition-all duration-300 hover:scale-105 backdrop-blur-sm bg-opacity-90`;
            toast.innerHTML = `
                <i class="fas ${icons[type]}"></i>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto hover:opacity-75 transition-opacity">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toast.onclick = () => toast.remove();
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
        
        // Event Listeners
        document.getElementById('interventionModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeInterventionModal();
        });
        
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notificationDropdown');
            const bell = e.target.closest('[onclick="toggleNotifications()"]');
            if (!bell && dropdown && !dropdown.classList.contains('hidden') && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        document.getElementById('interventionForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                
                if (data.success) {
                    showToast('Intervention plan saved successfully!', 'success');
                    closeInterventionModal();
                    this.reset();
                } else {
                    showToast(data.message || 'Error saving intervention plan', 'error');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                showToast('Network error. Please try again.', 'error');
            });
        });
        
        // Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeInterventionModal();
                const notifDropdown = document.getElementById('notificationDropdown');
                if (notifDropdown) notifDropdown.classList.add('hidden');
            }
            
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (document.getElementById('attendanceForm')) {
                    saveAttendance();
                }
            }
        });
    </script>

</body>
</html>