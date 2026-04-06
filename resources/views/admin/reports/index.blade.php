<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        html, body { 
            height: 100%;
            overflow: hidden;
        }
        
        body { 
            background: #f8fafc;
        }
        
        /* Custom scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .glass-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
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
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .report-tab {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .report-tab.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            color: #3b82f6;
            border-left: 3px solid #3b82f6;
        }
        
        .report-tab:hover:not(.active) {
            background: #f1f5f9;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 1s ease-out;
        }
        
        .trend-up { color: #10b981; }
        .trend-down { color: #ef4444; }
        .trend-neutral { color: #64748b; }
        
        /* Ensure proper flex layout for scrolling */
        .layout-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        
        .main-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            margin-left: 18rem;
        }
        
        .scrollable-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Report content sections */
        .report-content {
            display: none;
        }
        
        .report-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        /* Export dropdown styles */
        .export-dropdown {
            position: relative;
        }
        
        .export-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 160px;
            z-index: 50;
            display: none;
        }
        
        .export-menu.show {
            display: block;
        }
        
        .export-menu button {
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            border: none;
            background: none;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .export-menu button:hover {
            background: #f1f5f9;
        }
        
        .export-menu button:first-child {
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        .export-menu button:last-child {
            border-radius: 0 0 0.75rem 0.75rem;
        }
        
        /* School year selector styles */
        .school-year-selector {
            position: relative;
        }
        
        .school-year-selector select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
    </style>
</head>
<body>
    @php
        // Get selected school year from query parameter or use active one
        $selectedSchoolYearId = request('school_year');
        $selectedSchoolYear = $selectedSchoolYearId 
            ? \App\Models\SchoolYear::find($selectedSchoolYearId)
            : \App\Models\SchoolYear::where('is_active', true)->first();
        
        $activeSchoolYearId = $selectedSchoolYear ? $selectedSchoolYear->id : null;
        $activeSchoolYearName = $selectedSchoolYear ? $selectedSchoolYear->name : 'No School Year Selected';
        
        // Get all school years for dropdown
        $schoolYears = \App\Models\SchoolYear::orderBy('start_date', 'desc')->get();
        
        // Period filter
        $period = request('period', 'month');
        
        // Calculate date range based on period
        $endDate = now();
        switch($period) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                break;
            case 'quarter':
                $startDate = now()->startOfQuarter();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                break;
            default:
                $startDate = now()->startOfMonth();
        }
        
        // Total Students - based on enrollments with valid statuses in selected school year
        $totalStudents = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->count()
            : \App\Models\Student::where('status', 'active')->count();
        
        // Student growth calculation
        $previousPeriodStart = (clone $startDate)->subDays($startDate->diffInDays($endDate));
        $previousPeriodStudents = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->whereBetween('created_at', [$previousPeriodStart, $startDate])
                ->count()
            : \App\Models\Student::where('status', 'active')
                ->whereBetween('created_at', [$previousPeriodStart, $startDate])
                ->count();
        
        $currentPeriodStudents = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count()
            : \App\Models\Student::where('status', 'active')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
        
        $studentGrowth = $previousPeriodStudents > 0 
            ? round((($currentPeriodStudents - $previousPeriodStudents) / $previousPeriodStudents) * 100, 1) 
            : 0;
        
        // Total Teachers - all teachers (not filtered by school year)
        $totalTeachers = \App\Models\Teacher::count();
        $activeTeachers = \App\Models\Teacher::where('status', 'active')->count();
        $inactiveTeachers = \App\Models\Teacher::where('status', 'inactive')->count();
        
        // Teacher growth (new teachers in period)
        $previousPeriodTeachers = \App\Models\Teacher::whereBetween('created_at', [$previousPeriodStart, $startDate])->count();
        $currentPeriodTeachers = \App\Models\Teacher::whereBetween('created_at', [$startDate, $endDate])->count();
        $teacherGrowth = $previousPeriodTeachers > 0 
            ? round((($currentPeriodTeachers - $previousPeriodTeachers) / $previousPeriodTeachers) * 100, 1) 
            : 0;
        
        // Total Sections - filtered by school year
        $totalSections = $activeSchoolYearId
            ? \App\Models\Section::where('school_year_id', $activeSchoolYearId)->count()
            : \App\Models\Section::count();
        
        // Average students per section
        $averageStudentsPerSection = $totalSections > 0 ? round($totalStudents / $totalSections, 1) : 0;
        
        // Pending Registrations - pending enrollments in selected school year
        $pendingRegistrations = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->where('status', 'pending')
                ->count()
            : \App\Models\Enrollment::where('status', 'pending')->count();
        
        // Gender distribution via enrollments
        $maleCount = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->whereHas('student', function($q) { $q->where('gender', 'Male'); })
                ->count()
            : \App\Models\Student::where('status', 'active')->where('gender', 'Male')->count();
        
        $femaleCount = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->whereHas('student', function($q) { $q->where('gender', 'Female'); })
                ->count()
            : \App\Models\Student::where('status', 'active')->where('gender', 'Female')->count();
        
        $totalGenderCount = $maleCount + $femaleCount;
        $malePercentage = $totalGenderCount > 0 ? round(($maleCount / $totalGenderCount) * 100) : 0;
        $femalePercentage = $totalGenderCount > 0 ? round(($femaleCount / $totalGenderCount) * 100) : 0;
        
        // Grade level distribution via enrollments
        $gradeDistribution = $activeSchoolYearId
            ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                ->whereIn('status', ['approved', 'enrolled', 'completed'])
                ->join('grade_levels', 'enrollments.grade_level_id', '=', 'grade_levels.id')
                ->selectRaw('grade_levels.name as grade, count(*) as count')
                ->groupBy('grade_levels.name')
                ->orderBy('grade_levels.name')
                ->pluck('count', 'grade')
                ->toArray()
            : \App\Models\Student::where('status', 'active')
                ->join('grade_levels', 'students.grade_level_id', '=', 'grade_levels.id')
                ->selectRaw('grade_levels.name as grade, count(*) as count')
                ->groupBy('grade_levels.name')
                ->orderBy('grade_levels.name')
                ->pluck('count', 'grade')
                ->toArray();
        
        $gradeLevels = array_keys($gradeDistribution);
        $gradeDistributionValues = array_values($gradeDistribution);
        
        // Enrollment trend data (last 6 months or period)
        $enrollmentLabels = [];
        $enrollmentData = [];
        for($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $enrollmentLabels[] = $month->format('M');
            
            $count = $activeSchoolYearId
                ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYearId)
                    ->whereIn('status', ['approved', 'enrolled', 'completed'])
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count()
                : \App\Models\Student::where('status', 'active')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
            
            $enrollmentData[] = $count;
        }
        
        // Section performance data
        $sectionData = $activeSchoolYearId
            ? \App\Models\Section::where('school_year_id', $activeSchoolYearId)
                ->with(['enrollments' => function($q) {
                    $q->whereIn('status', ['approved', 'enrolled', 'completed']);
                }])
                ->get()
            : \App\Models\Section::with(['enrollments' => function($q) {
                $q->whereIn('status', ['approved', 'enrolled', 'completed']);
            }])->get();
        
        $sectionNames = [];
        $sectionAverages = [];
        $topSections = [];
        
        foreach($sectionData->take(5) as $index => $section) {
            $sectionNames[] = $section->name;
            // Mock average for demo - replace with actual grade calculation
            $avg = rand(75, 95);
            $sectionAverages[] = $avg;
            
            $topSections[] = [
                'name' => $section->name,
                'teacher' => $section->teacher->user->name ?? 'Unassigned',
                'students' => $section->enrollments->count(),
                'average' => $avg
            ];
        }
        
        // Sort top sections by average
        usort($topSections, function($a, $b) {
            return $b['average'] - $a['average'];
        });
        
        // Additional stats
        $totalUsers = \App\Models\User::count();
        $totalSubjects = \App\Models\Subject::count();
        $averageClassSize = $totalSections > 0 ? round($totalStudents / $totalSections, 1) : 0;
        
        // Passing rate and attendance rate (mock data - replace with actual calculations)
        $passingRate = rand(85, 95);
        $attendanceRate = rand(90, 98);
        
        // Recent activities (mock data - replace with actual activity log)
        $recentActivities = [
            [
                'title' => 'New Student Enrolled',
                'description' => 'Juan Dela Cruz enrolled in Grade 1-A',
                'time' => '2 mins ago',
                'icon' => 'fa-user-plus',
                'icon_bg' => 'bg-blue-100',
                'icon_color' => 'text-blue-600'
            ],
            [
                'title' => 'Grade Updated',
                'description' => 'Mathematics grades updated for Grade 2-B',
                'time' => '15 mins ago',
                'icon' => 'fa-edit',
                'icon_bg' => 'bg-green-100',
                'icon_color' => 'text-green-600'
            ],
            [
                'title' => 'Attendance Marked',
                'description' => 'Daily attendance completed for Grade 3 sections',
                'time' => '1 hour ago',
                'icon' => 'fa-calendar-check',
                'icon_bg' => 'bg-purple-100',
                'icon_color' => 'text-purple-600'
            ],
            [
                'title' => 'New Teacher Added',
                'description' => 'Maria Santos registered as new faculty',
                'time' => '3 hours ago',
                'icon' => 'fa-chalkboard-teacher',
                'icon_bg' => 'bg-amber-100',
                'icon_color' => 'text-amber-600'
            ],
        ];
    @endphp

    <div class="layout-container">
        @include('admin.includes.sidebar')
        
        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">
            <!-- Fixed Header -->
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200 flex-shrink-0">
                <div class="px-8 py-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span class="text-slate-700 font-medium">Reports & Analytics</span>
                            </nav>
                            <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                    <i class="fas fa-chart-line text-lg"></i>
                                </div>
                                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                                    Reports & Analytics
                                </span>
                            </h1>
                        </div>
                        
                        <!-- Date Range Filter & School Year -->
                        <div class="flex items-center gap-3">
                            <!-- School Year Selector -->
                            <div class="school-year-selector">
                                <select id="schoolYearSelect" onchange="changeSchoolYear(this.value)" 
                                    class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer hover:bg-white transition-colors min-w-[180px]">
                                    @foreach($schoolYears as $year)
                                        <option value="{{ $year->id }}" {{ $activeSchoolYearId == $year->id ? 'selected' : '' }}>
                                            {{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex items-center gap-2 bg-slate-50 rounded-xl border border-slate-200 p-1">
                                <button onclick="changePeriod('today')" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $period == 'today' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}" data-period="today">Today</button>
                                <button onclick="changePeriod('week')" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $period == 'week' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}" data-period="week">This Week</button>
                                <button onclick="changePeriod('month')" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $period == 'month' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}" data-period="month">This Month</button>
                                <button onclick="changePeriod('quarter')" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $period == 'quarter' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}" data-period="quarter">This Quarter</button>
                                <button onclick="changePeriod('year')" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $period == 'year' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}" data-period="year">This Year</button>
                            </div>
                            
                            <!-- Export Dropdown -->
                            <div class="export-dropdown">
                                <button id="exportBtn" onclick="toggleExportMenu()" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl font-medium shadow-lg shadow-blue-500/30 hover:shadow-xl transition-all flex items-center gap-2">
                                    <i class="fas fa-download"></i>
                                    Export
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div id="exportMenu" class="export-menu">
                                    <button onclick="exportReport('pdf')">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        Export PDF
                                    </button>
                                    <button onclick="exportReport('excel')">
                                        <i class="fas fa-file-excel text-green-500"></i>
                                        Export Excel
                                    </button>
                                    <button onclick="exportReport('csv')">
                                        <i class="fas fa-file-csv text-blue-500"></i>
                                        Export CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Main Content -->
            <main class="scrollable-content custom-scrollbar p-8">
                
                <!-- Current School Year Display -->
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-sm font-medium text-slate-600">
                            Showing data for: <span class="text-slate-900 font-bold">{{ $activeSchoolYearName }}</span>
                        </span>
                    </div>
                    @if($selectedSchoolYear && $selectedSchoolYear->is_active)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Active Year
                        </span>
                    @endif
                </div>

                <!-- Report Content Sections -->
                <div id="overview-content" class="report-content active">
                    <!-- KPI Cards Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Students -->
                        <div class="glass-card stat-card rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500 mb-1">Total Students</p>
                                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalStudents) }}</h3>
                                    <div class="flex items-center gap-1 mt-2">
                                        <i class="fas fa-arrow-{{ $studentGrowth >= 0 ? 'up' : 'down' }} {{ $studentGrowth >= 0 ? 'trend-up' : 'trend-down' }}"></i>
                                        <span class="text-sm font-medium {{ $studentGrowth >= 0 ? 'trend-up' : 'trend-down' }}">{{ abs($studentGrowth) }}%</span>
                                        <span class="text-xs text-slate-400">vs last period</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ min($totalStudents / 10, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Total Teachers -->
                        <div class="glass-card stat-card rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500 mb-1">Total Teachers</p>
                                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalTeachers) }}</h3>
                                    <div class="flex items-center gap-1 mt-2">
                                        <i class="fas fa-arrow-{{ $teacherGrowth >= 0 ? 'up' : 'down' }} {{ $teacherGrowth >= 0 ? 'trend-up' : 'trend-down' }}"></i>
                                        <span class="text-sm font-medium {{ $teacherGrowth >= 0 ? 'trend-up' : 'trend-down' }}">{{ abs($teacherGrowth) }}%</span>
                                        <span class="text-xs text-slate-400">vs last period</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-purple-500 rounded-full" style="width: {{ min($totalTeachers / 5, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Active Sections -->
                        <div class="glass-card stat-card rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500 mb-1">Active Sections</p>
                                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalSections) }}</h3>
                                    <div class="flex items-center gap-1 mt-2">
                                        <span class="text-sm text-slate-600">{{ $averageStudentsPerSection }} avg students</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-th-large text-emerald-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min($totalSections / 20, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Pending Registrations -->
                        <div class="glass-card stat-card rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500 mb-1">Pending Registrations</p>
                                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($pendingRegistrations) }}</h3>
                                    <div class="flex items-center gap-1 mt-2">
                                        <span class="text-xs px-2 py-1 bg-amber-100 text-amber-700 rounded-full font-medium">Needs Action</span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-user-clock text-amber-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-500 rounded-full" style="width: {{ min($pendingRegistrations / 50, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Student Enrollment Trend -->
                        <div class="glass-card rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Student Enrollment Trend</h3>
                                    <p class="text-sm text-slate-500">New student registrations over time</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                    <span class="text-xs text-slate-500">New Students</span>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="enrollmentChart"></canvas>
                            </div>
                        </div>

                        <!-- Grade Level Distribution -->
                        <div class="glass-card rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Grade Level Distribution</h3>
                                    <p class="text-sm text-slate-500">Students by grade level</p>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="gradeDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Second Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Gender Distribution -->
                        <div class="glass-card rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Gender Distribution</h3>
                            <p class="text-sm text-slate-500 mb-6">Student gender breakdown</p>
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="genderChart"></canvas>
                            </div>
                            <div class="flex justify-center gap-6 mt-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                    <span class="text-sm text-slate-600">Male ({{ $malePercentage }}%)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-pink-500"></span>
                                    <span class="text-sm text-slate-600">Female ({{ $femalePercentage }}%)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section Performance -->
                        <div class="glass-card rounded-2xl p-6 lg:col-span-2">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Section Performance</h3>
                                    <p class="text-sm text-slate-500">Average grades by section</p>
                                </div>
                                <select class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                    <option>All Subjects</option>
                                    <option>Mathematics</option>
                                    <option>Language</option>
                                    <option>Science</option>
                                </select>
                            </div>
                            <div class="chart-container">
                                <canvas id="sectionPerformanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Reports Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                    <!-- Report Types Sidebar -->
                    <div class="glass-card rounded-2xl p-4">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 px-2">Report Types</h3>
                        <nav class="space-y-1">
                            <a href="#" class="report-tab active flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all" data-target="overview">
                                <i class="fas fa-chart-pie w-5"></i>
                                <span>Overview Dashboard</span>
                            </a>
                            <a href="#" class="report-tab flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 transition-all" data-target="student">
                                <i class="fas fa-users w-5"></i>
                                <span>Student Reports</span>
                            </a>
                            <a href="#" class="report-tab flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 transition-all" data-target="teacher">
                                <i class="fas fa-chalkboard-teacher w-5"></i>
                                <span>Teacher Reports</span>
                            </a>
                            <a href="#" class="report-tab flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 transition-all" data-target="grade">
                                <i class="fas fa-graduation-cap w-5"></i>
                                <span>Grade Reports</span>
                            </a>
                            <a href="#" class="report-tab flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 transition-all" data-target="attendance">
                                <i class="fas fa-calendar-check w-5"></i>
                                <span>Attendance Reports</span>
                            </a>
                            <a href="#" class="report-tab flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 transition-all" data-target="export">
                                <i class="fas fa-file-export w-5"></i>
                                <span>Export Data</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Top Performing Sections -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="glass-card rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Top Performing Sections</h3>
                                <a href="#" class="text-sm text-primary hover:text-primary/80 font-medium">View All</a>
                            </div>
                            <div class="space-y-4">
                                @forelse($topSections as $index => $section)
                                <div class="flex items-center gap-4 p-3 rounded-xl bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-slate-900">{{ $section['name'] }}</h4>
                                        <p class="text-sm text-slate-500">{{ $section['teacher'] }} • {{ $section['students'] }} students</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold text-slate-900">{{ $section['average'] }}%</span>
                                        <p class="text-xs text-slate-500">Class Average</p>
                                    </div>
                                    <div class="w-24">
                                        <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full" style="width: {{ $section['average'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8 text-slate-500">
                                    <i class="fas fa-chart-bar text-4xl mb-3 text-slate-300"></i>
                                    <p>No data available</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="glass-card rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Recent Activity</h3>
                                <a href="#" class="text-sm text-primary hover:text-primary/80 font-medium">View All</a>
                            </div>
                            <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar pr-2">
                                @forelse($recentActivities as $activity)
                                <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-10 h-10 rounded-xl {{ $activity['icon_bg'] }} flex items-center justify-center flex-shrink-0">
                                        <i class="fas {{ $activity['icon'] }} {{ $activity['icon_color'] }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-slate-900">{{ $activity['title'] }}</p>
                                        <p class="text-sm text-slate-500">{{ $activity['description'] }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ $activity['time'] }}</span>
                                </div>
                                @empty
                                <div class="text-center py-8 text-slate-500">
                                    <i class="fas fa-clock text-4xl mb-3 text-slate-300"></i>
                                    <p>No recent activity</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 pb-8">
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                        <p class="text-xs text-slate-500">Total Users</p>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $activeSchoolYearName }}</p>
                        <p class="text-xs text-slate-500">Selected School Year</p>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $totalSubjects }}</p>
                        <p class="text-xs text-slate-500">Subjects</p>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $averageClassSize }}</p>
                        <p class="text-xs text-slate-500">Avg Class Size</p>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $passingRate }}%</p>
                        <p class="text-xs text-slate-500">Passing Rate</p>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $attendanceRate }}%</p>
                        <p class="text-xs text-slate-500">Attendance Rate</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Chart configurations
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748b';
        
        // Student Enrollment Trend Chart
        const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
        const enrollmentChart = new Chart(enrollmentCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($enrollmentLabels) !!},
                datasets: [{
                    label: 'New Students',
                    data: {!! json_encode($enrollmentData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Grade Level Distribution Chart
        const gradeCtx = document.getElementById('gradeDistributionChart').getContext('2d');
        const gradeChart = new Chart(gradeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($gradeLevels) !!},
                datasets: [{
                    label: 'Students',
                    data: {!! json_encode($gradeDistributionValues) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Gender Distribution Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: {!! json_encode([$maleCount, $femaleCount]) !!},
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });

        // Section Performance Chart
        const sectionCtx = document.getElementById('sectionPerformanceChart').getContext('2d');
        const sectionChart = new Chart(sectionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($sectionNames) !!},
                datasets: [{
                    label: 'Average Grade',
                    data: {!! json_encode($sectionAverages) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });

        // Change Period Function
        function changePeriod(period) {
            document.querySelectorAll('.period-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-primary', 'shadow-sm');
                btn.classList.add('text-slate-600');
            });
            event.target.classList.remove('text-slate-600');
            event.target.classList.add('bg-white', 'text-primary', 'shadow-sm');
            
            const url = new URL(window.location.href);
            url.searchParams.set('period', period);
            window.location.href = url.toString();
        }

        // School Year Change Function
        function changeSchoolYear(yearId) {
            const url = new URL(window.location.href);
            url.searchParams.set('school_year', yearId);
            window.location.href = url.toString();
        }

        // Export Dropdown Toggle
        function toggleExportMenu() {
            const menu = document.getElementById('exportMenu');
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.export-dropdown');
            if (!dropdown.contains(e.target)) {
                document.getElementById('exportMenu').classList.remove('show');
            }
        });

        // Export Report Function
        function exportReport(format) {
            const period = '{{ $period }}';
            const schoolYear = document.getElementById('schoolYearSelect')?.value || '';
            
            let url = `{{ url('admin/reports/export') }}/${format}?period=${period}`;
            if (schoolYear) {
                url += `&school_year=${schoolYear}`;
            }
            
            const btn = document.getElementById('exportBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            btn.disabled = true;
            
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = url;
            document.body.appendChild(iframe);
            
            setTimeout(() => {
                document.body.removeChild(iframe);
                btn.innerHTML = originalText;
                btn.disabled = false;
                document.getElementById('exportMenu').classList.remove('show');
            }, 2000);
        }

        // Report Tab Switching
        document.querySelectorAll('.report-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelectorAll('.report-tab').forEach(t => {
                    t.classList.remove('active');
                    t.classList.add('text-slate-600');
                });
                this.classList.add('active');
                this.classList.remove('text-slate-600');
                
                document.querySelectorAll('.report-content').forEach(content => {
                    content.classList.remove('active');
                });
                
                const targetId = this.getAttribute('data-target') + '-content';
                const targetContent = document.getElementById(targetId);
                if (targetContent) {
                    targetContent.classList.add('active');
                    document.querySelector('.scrollable-content').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>