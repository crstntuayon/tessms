<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tugawe Elementary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { overflow: hidden; }
        
        .dashboard-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #e2e8f0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-wrapper {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
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
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }

        .stat-card {
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
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
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

        .nav-item {
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #3b82f6, #8b5cf6);
            border-radius: 0 4px 4px 0;
            transition: transform 0.2s ease;
        }
        .nav-item:hover::before,
        .nav-item.active::before {
            transform: translateY(-50%) scaleY(1);
        }
        .nav-item.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
        }

        .glass-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .chart-container {
            position: relative;
            height: 320px;
            width: 100%;
        }

        .fab {
            box-shadow: 0 10px 40px -10px rgba(37, 99, 235, 0.5);
            transition: all 0.3s ease;
        }
        .fab:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 50px -10px rgba(37, 99, 235, 0.6);
        }

        .progress-bar {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 1s ease-out;
        }

        .custom-checkbox {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #cbd5e1;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .custom-checkbox:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
        .status-active { @apply bg-emerald-50 text-emerald-700 border border-emerald-200; }
        .status-inactive { @apply bg-slate-50 text-slate-600 border border-slate-200; }
        .status-pending { @apply bg-amber-50 text-amber-700 border border-amber-200; }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay fixed inset-0 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="dashboard-container">
        <!-- Fixed Sidebar -->
      @include('admin.includes.sidebar')
      <script>
        // Sidebar Toggle for mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('mobileOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('hidden');
}

// Quick Actions Modal
function openQuickActions() {
    document.getElementById('quickActionsModal').classList.remove('hidden');
}

function closeQuickActions() {
    document.getElementById('quickActionsModal').classList.add('hidden');
}

// Close menus when clicking outside (keep existing, but exclude userMenu since sidebar handles it)
document.addEventListener('click', function(e) {
    const quickModal = document.getElementById('quickActionsModal');
    const button = e.target.closest('button');
    
    // Close quick actions when clicking outside
    if (!quickModal.classList.contains('hidden') && !e.target.closest('#quickActionsModal') && !button?.onclick?.toString().includes('openQuickActions')) {
        closeQuickActions();
    }
});
      </script>

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Fixed Header -->
            <header class="main-header">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2.5 hover:bg-slate-100 rounded-xl transition-colors">
                            <i class="fas fa-bars text-slate-600"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard Overview</h2>
                            <p class="text-sm text-slate-500 font-medium flex items-center gap-2 mt-0.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                {{ now()->format('l, F j, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex items-center bg-white border border-slate-200 rounded-2xl px-4 py-2.5 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all">
                            <i class="fas fa-search text-slate-400 mr-3"></i>
                            <input type="text" placeholder="Search students, teachers..." class="bg-transparent border-none outline-none text-sm w-56 placeholder:text-slate-400">
                            <kbd class="hidden lg:inline-block px-2 py-1 text-xs font-semibold text-slate-400 bg-slate-100 rounded border border-slate-200">⌘K</kbd>
                        </div>

                        <button class="relative p-2.5 text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="notification-badge animate-pulse"></span>
                        </button>

                        <button onclick="openQuickActions()" class="fab bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all flex items-center gap-2">
                            <i class="fas fa-plus text-sm"></i>
                            <span class="hidden sm:inline">Quick Add</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Scrollable Main Content -->
            <main class="main-content">
                
                <!-- Welcome Banner -->
                <div class="mb-8 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden animate-fade-in-up">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-2xl"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name ?? 'Admin' }}! 👋</h1>
                            <p class="text-blue-100 text-lg">Here's what's happening at Tugawe Elementary today.</p>
                        </div>
                        <div class="hidden md:block text-right">
                            <p class="text-4xl font-bold" id="liveClock">09:32 AM</p>
                            <p class="text-blue-200 text-sm">Philippine Standard Time</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid - REAL DATABASE DATA -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                    
                    <!-- Total Students - From Database -->
                    <div class="stat-card glass-card rounded-2xl p-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg shadow-blue-500/30">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <!-- Calculate growth from last month -->
                            @php
                                $lastMonthStudents = \App\Models\Student::whereMonth('created_at', now()->subMonth()->month)->count();
                                $thisMonthStudents = \App\Models\Student::whereMonth('created_at', now()->month)->count();
                                $growth = $lastMonthStudents > 0 ? round((($thisMonthStudents - $lastMonthStudents) / $lastMonthStudents) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center gap-1 {{ $growth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-2.5 py-1 rounded-full text-xs font-bold border {{ $growth >= 0 ? 'border-emerald-200' : 'border-red-200' }}">
                                <i class="fas fa-arrow-{{ $growth >= 0 ? 'up' : 'down' }} text-[10px]"></i>
                                <span>{{ abs($growth) }}%</span>
                            </div>
                        </div>
                        <!-- REAL COUNT FROM DATABASE -->
                        <h3 class="text-3xl font-bold text-slate-900 mb-1">
                            {{ number_format(\App\Models\Student::count()) }}
                        </h3>
                        <p class="text-sm text-slate-500 font-medium mb-4">Total Students</p>
                        <!-- Gender breakdown from DB -->
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                <span class="text-slate-600 font-medium">
                                    Male: {{ \App\Models\Student::where('gender', 'Male')->count() }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-pink-500"></div>
                                <span class="text-slate-600 font-medium">
                                    Female: {{ \App\Models\Student::where('gender', 'Female')->count() }}
                                </span>
                            </div>
                        </div>
                        <!-- Progress bar based on capacity -->
                        @php
                            $totalStudents = \App\Models\Student::count();
                            $schoolCapacity = 2000; // Set your school capacity
                            $percentage = min(($totalStudents / $schoolCapacity) * 100, 100);
                        @endphp
                        <div class="mt-4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full progress-bar" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <!-- Total Teachers - From Database -->
                    <div class="stat-card glass-card rounded-2xl p-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg shadow-purple-500/30">
                                <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                            </div>
                            @php
                                $activeTeachers = \App\Models\Teacher::where('status', 'active')->count();
                                $totalTeachers = \App\Models\Teacher::count();
                                $activePercentage = $totalTeachers > 0 ? round(($activeTeachers / $totalTeachers) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-200">
                                <i class="fas fa-check text-[10px]"></i>
                                <span>{{ $activePercentage }}% Active</span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 mb-1">
                            {{ number_format($totalTeachers) }}
                        </h3>
                        <p class="text-sm text-slate-500 font-medium mb-4">Total Teachers</p>
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-slate-600 font-medium">
                                    Active: {{ $activeTeachers }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <span class="text-slate-600 font-medium">
                                    On Leave: {{ \App\Models\Teacher::where('status', 'on_leave')->count() }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full progress-bar" style="width: {{ $activePercentage }}%"></div>
                        </div>
                    </div>

                    <!-- Today's Attendance - From Database -->
                    <div class="stat-card glass-card rounded-2xl p-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg shadow-emerald-500/30">
                                <i class="fas fa-calendar-check text-white text-xl"></i>
                            </div>
                            @php
                                $today = now()->format('Y-m-d');
                                $totalStudents = \App\Models\Student::count();
                                $presentToday = \App\Models\Attendance::whereDate('date', $today)->where('status', 'present')->count();
                                $attendanceRate = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center gap-1 {{ $attendanceRate >= 90 ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50' }} px-2.5 py-1 rounded-full text-xs font-bold border {{ $attendanceRate >= 90 ? 'border-emerald-200' : 'border-amber-200' }}">
                                <i class="fas fa-check text-[10px]"></i>
                                <span>{{ $attendanceRate }}%</span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $attendanceRate }}%</h3>
                        <p class="text-sm text-slate-500 font-medium mb-4">Today's Attendance</p>
                        @php
                            $absentToday = \App\Models\Attendance::whereDate('date', $today)->where('status', 'absent')->count();
                            $lateToday = \App\Models\Attendance::whereDate('date', $today)->where('status', 'late')->count();
                        @endphp
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-slate-600 font-medium">Present: {{ $presentToday }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                <span class="text-slate-600 font-medium">Absent: {{ $absentToday }}</span>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full progress-bar" style="width: {{ $attendanceRate }}%"></div>
                        </div>
                    </div>

                    <!-- Average Grade - From Database -->
                    <div class="stat-card glass-card rounded-2xl p-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.4s;">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg shadow-amber-500/30">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                           @php
    $avgGrade = \App\Models\Grade::where('component_type', 'final_grade')->avg('final_grade') ?? 0;

    $above90 = \App\Models\Grade::where('component_type', 'final_grade')
        ->where('final_grade', '>=', 90)
        ->count();

    $below75 = \App\Models\Grade::where('component_type', 'final_grade')
        ->where('final_grade', '<', 75)
        ->count();

    $totalGrades = \App\Models\Grade::where('component_type', 'final_grade')->count();

    $above90Pct = $totalGrades > 0 
        ? round(($above90 / $totalGrades) * 100) 
        : 0;
@endphp
                            <div class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full text-xs font-bold border border-amber-200">
                                <i class="fas fa-chart-line text-[10px]"></i>
                                <span>{{ number_format($avgGrade, 1) }}</span>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ number_format($avgGrade, 1) }}</h3>
                        <p class="text-sm text-slate-500 font-medium mb-4">Average Grade</p>
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <span class="text-slate-600 font-medium">Above 90: {{ $above90Pct }}%</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                <span class="text-slate-600 font-medium">Below 75: {{ $below75 }}</span>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full progress-bar" style="width: {{ min($avgGrade, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Analytics - REAL DATA -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Attendance Chart - Last 7 Days from DB -->
                    <div class="lg:col-span-2 glass-card rounded-2xl p-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.5s;">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Attendance Trends</h3>
                                <p class="text-sm text-slate-500">Last 7 days overview</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Grade Distribution - From DB -->
                    <div class="space-y-6 animate-fade-in-up" style="animation-delay: 0.6s;">
                        <div class="glass-card rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Grade Distribution</h3>
                            <div class="space-y-3">
                            @php
$gradeDistribution = \App\Models\Student::join('grade_levels', 'students.grade_level_id', '=', 'grade_levels.id')
    ->selectRaw('grade_levels.name as grade, count(*) as count')
    ->groupBy('grade_levels.name')
    ->orderBy('grade_levels.name')
    ->pluck('count', 'grade')
    ->toArray();

$maxCount = !empty($gradeDistribution) ? max($gradeDistribution) : 1;
@endphp
                                @foreach($gradeDistribution as $grade => $count)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md">
                                            {{ $grade }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="font-semibold text-slate-700 text-sm">{{ $grade }}</span>
                                                <span class="font-bold text-slate-900 text-sm">{{ $count }}</span>
                                            </div>
                                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full progress-bar" style="width: {{ ($count / $maxCount) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Upcoming Events - From DB -->
                        <div class="glass-card rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-slate-900">Upcoming Events</h3>
                                <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All</a>
                            </div>
                            <div class="space-y-4">
                                @php
                                    $upcomingEvents = \App\Models\Event::where('date', '>=', now())
                                        ->orderBy('date')
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @forelse($upcomingEvents as $event)
                                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer group">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 text-blue-600 flex flex-col items-center justify-center font-bold text-xs border border-blue-200 group-hover:shadow-md transition-all">
                                            <span class="text-[10px] uppercase">{{ $event->date->format('M') }}</span>
                                            <span class="text-lg">{{ $event->date->format('d') }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-slate-800 text-sm truncate group-hover:text-blue-600 transition-colors">{{ $event->title }}</p>
                                            <p class="text-slate-500 text-xs mt-0.5">{{ $event->date->format('l') }} • {{ $event->type }}</p>
                                        </div>
                                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-2"></div>
                                    </div>
                                @empty
                                    <p class="text-slate-400 text-sm text-center py-4">No upcoming events</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Students Table - REAL DATA -->
                <div class="glass-card rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden animate-fade-in-up" style="animation-delay: 0.7s;">
                    <div class="p-6 border-b border-slate-200/80 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Recent Enrollments</h3>
                            <p class="text-sm text-slate-500">Latest student registrations</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.students.index') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl font-semibold text-sm transition-all flex items-center gap-2">
                                View All <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" class="custom-checkbox">
                                            <span>Student</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Grade & Section</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">LRN</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Enrolled</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php
                                    $recentStudents = \App\Models\Student::with('section')
                                        ->latest()
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($recentStudents as $student)
                                    <tr class="group hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <input type="checkbox" class="custom-checkbox">
                                                <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&background=random&color=fff' }}" 
                                                     alt="" 
                                                     class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                                                <div>
                                                    <p class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition-colors">{{ $student->full_name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $student->gender }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-sm">
                                                 {{ $student->grade_level }}-{{ $student->section->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-sm text-slate-600 bg-slate-50 px-2 py-1 rounded border border-slate-200">{{ $student->lrn }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="status-badge status-{{ $student->status }} capitalize">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5 inline-block"></span>
                                                {{ $student->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 text-sm font-medium">
                                            {{ $student->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.students.show', $student) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.students.edit', $student) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" title="More">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-inbox text-2xl text-slate-400"></i>
                                            </div>
                                            <p class="text-slate-500 font-medium">No students found</p>
                                            <p class="text-slate-400 text-sm mt-1">No recent enrollments</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($recentStudents->count() > 0)
                        <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex items-center justify-between">
                            <p class="text-sm text-slate-500">Showing <span class="font-semibold text-slate-900">1-{{ $recentStudents->count() }}</span> of <span class="font-semibold text-slate-900">{{ \App\Models\Student::count() }}</span> students</p>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 rounded-lg transition-all disabled:opacity-50" disabled>
                                    Previous
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 rounded-lg transition-all">
                                    Next
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Quick Actions Modal -->
    <div id="quickActionsModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm" onclick="closeQuickActions()"></div>
        <div class="absolute top-24 right-6 bg-white rounded-2xl shadow-2xl p-2 w-80 animate-fade-in-up border border-slate-200">
            <div class="p-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Quick Actions</h3>
                <p class="text-sm text-slate-500">What would you like to do?</p>
            </div>
            <div class="p-2 space-y-1">
                <a href="{{ route('admin.students.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-sm">Add Student</p>
                        <p class="text-xs text-slate-500">Enroll a new student</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 ml-auto text-xs group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                </a>
                <a href="{{ route('admin.teachers.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-tie text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-sm">Add Teacher</p>
                        <p class="text-xs text-slate-500">Register new faculty</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 ml-auto text-xs group-hover:text-purple-500 group-hover:translate-x-1 transition-all"></i>
                </a>
                <a href="{{ route('admin.sections.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-all group">
    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
        <i class="fas fa-th-large text-sm"></i>
    </div>
    <div>
        <p class="font-bold text-slate-900 text-sm">Sections</p>
        <p class="text-xs text-slate-500">Manage class sections</p>
    </div>
    <i class="fas fa-chevron-right text-slate-300 ml-auto text-xs group-hover:text-emerald-500 group-hover:translate-x-1 transition-all"></i>
</a>
            </div>
        </div>
    </div>

    <!-- User Dropdown Menu -->
    <div id="userMenu" class="hidden fixed bottom-24 left-4 lg:left-72 lg:bottom-auto lg:top-20 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 p-2">
        <div class="p-3 border-b border-slate-100">
            <p class="font-bold text-slate-900 text-sm">{{ auth()->user()->name ?? 'Administrator' }}</p>
            <p class="text-xs text-slate-500">{{ auth()->user()->email ?? 'admin@tugaweelem.edu' }}</p>
        </div>
        <div class="p-1 space-y-1">
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg transition-colors">
                <i class="fas fa-user text-slate-400 w-4"></i> Profile
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg transition-colors">
                <i class="fas fa-cog text-slate-400 w-4"></i> Settings
            </a>
            <div class="border-t border-slate-100 my-1"></div>
            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors text-left">
                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        }

        // Quick Actions Modal
        function openQuickActions() {
            document.getElementById('quickActionsModal').classList.remove('hidden');
        }

        function closeQuickActions() {
            document.getElementById('quickActionsModal').classList.add('hidden');
        }

        // User Menu Toggle
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }


        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            const clockElement = document.getElementById('liveClock');
            if (clockElement) {
                clockElement.textContent = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Attendance Chart - Real Data from Database
        @php
            $last7Days = collect(range(0, 6))->map(function($i) {
                return now()->subDays($i)->format('Y-m-d');
            })->reverse()->values();

            $attendanceLabels = $last7Days->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('D');
            });

            $presentData = $last7Days->map(function($date) {
                return \App\Models\Attendance::whereDate('date', $date)->where('status', 'present')->count();
            });

            $absentData = $last7Days->map(function($date) {
                return \App\Models\Attendance::whereDate('date', $date)->where('status', 'absent')->count();
            });
        @endphp

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        
        const gradientPresent = ctx.createLinearGradient(0, 0, 0, 400);
        gradientPresent.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradientPresent.addColorStop(1, 'rgba(59, 130, 246, 0.0)');
        
        const gradientAbsent = ctx.createLinearGradient(0, 0, 0, 400);
        gradientAbsent.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
        gradientAbsent.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

        const attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($attendanceLabels) !!},
                datasets: [{
                    label: 'Present',
                    data: {!! json_encode($presentData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: gradientPresent,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Absent',
                    data: {!! json_encode($absentData) !!},
                    borderColor: '#ef4444',
                    backgroundColor: gradientAbsent,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12,
                                weight: 600
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13,
                            weight: 600
                        },
                        bodyFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12,
                                weight: 500
                            },
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('input[type="text"]').focus();
            }
            if (e.key === 'Escape') {
                closeQuickActions();
                document.getElementById('userMenu').classList.add('hidden');
            }
        });

        // Animate progress bars
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>
</body>
</html>