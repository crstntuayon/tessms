{{-- resources/views/admin/includes/sidebar.blade.php --}}
@php
// Get the active school year
$activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();

// Students count - based on enrollments in active school year
$sidebarStudentCount = $activeSchoolYear 
    ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYear->id)
        ->whereIn('status', ['approved', 'enrolled', 'completed'])
        ->count() 
    : \App\Models\Student::where('status', 'active')->count();

// Teachers count - ALL teachers (same across all school years)
$sidebarTeacherCount = \App\Models\Teacher::count();

// Sections count - ALL sections (same across all school years)
$sidebarSectionCount = \App\Models\Section::count();

// Users count - students with enrollments in active year + all teachers + all admins
$sidebarUserCount = $activeSchoolYear 
    ? \App\Models\User::where(function ($query) use ($activeSchoolYear) {
        // Students with enrollments in active school year
        $query->whereHas('student.enrollments', function ($q) use ($activeSchoolYear) {
            $q->where('school_year_id', $activeSchoolYear->id)
              ->whereIn('status', ['approved', 'enrolled', 'completed']);
        })
        // OR all teachers
        ->orWhereHas('teacher')
        // OR all admins (role = admin)
        ->orWhere('role_id', 1);
      })
      ->count()
    : \App\Models\User::count();

// Pending registrations - pending enrollments for active school year
$sidebarPendingCount = $activeSchoolYear 
    ? \App\Models\Enrollment::where('school_year_id', $activeSchoolYear->id)
        ->where('status', 'pending')
        ->count() 
    : \App\Models\Enrollment::where('status', 'pending')->count();

// Online enrollment applications count - for active school year only (continuing students)
if ($activeSchoolYear) {
    $sidebarEnrollmentCount = \App\Models\EnrollmentApplication::where('school_year_id', $activeSchoolYear->id)
        ->where('application_type', 'continuing')
        ->where('status', 'pending')
        ->count();
} else {
    $sidebarEnrollmentCount = 0;
}
@endphp

<style>
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
    
    /* User menu positioning fix */
    .user-menu-container {
        position: relative;
    }
    
    #userMenu {
        position: absolute;
        bottom: 100%;
        left: 0;
        right: 0;
        margin-bottom: 8px;
        width: 100%;
        z-index: 60;
    }
    
    /* Scrollbar for sidebar nav */
    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-nav::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 2px;
    }
</style>

<!-- Sidebar -->
<aside id="sidebar" 
       class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col sidebar-transition transform -translate-x-full lg:translate-x-0"
       :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen && window.innerWidth < 1024 }"
       @click.outside="if (window.innerWidth < 1024) sidebarOpen = false">
    
    <!-- Logo -->
    <div class="p-4 lg:p-6 border-b border-slate-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/30">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="min-w-0">
                <h1 class="font-bold text-base lg:text-lg text-slate-900 tracking-tight truncate">Tugawe Elem</h1>
                <p class="text-xs text-slate-500 font-medium truncate">Admin Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 lg:px-4 py-4 lg:py-6 space-y-1 overflow-y-auto sidebar-nav custom-scrollbar">
        <a href="{{ route('admin.dashboard') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100' : 'bg-slate-100' }} flex items-center justify-center flex-shrink-0">
                <i class="fas fa-chart-pie text-sm {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}"></i>
            </div>
            <span class="truncate">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.students.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.students.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.students.*') ? 'bg-blue-100' : 'bg-slate-100 group-hover:bg-blue-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-users text-sm {{ request()->routeIs('admin.students.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
            </div>
            <span class="truncate">Students</span>
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarStudentCount }}</span>
        </a>
        
        <a href="{{ route('admin.teachers.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.teachers.*') ? 'text-purple-600 bg-purple-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.teachers.*') ? 'bg-purple-100' : 'bg-slate-100 group-hover:bg-purple-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-chalkboard-teacher text-sm {{ request()->routeIs('admin.teachers.*') ? 'text-purple-600' : 'group-hover:text-purple-600' }}"></i>
            </div>
            <span class="truncate">Teachers</span>
            <span class="ml-auto bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarTeacherCount }}</span>
        </a>
        
        <a href="{{ route('admin.sections.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.sections.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.sections.*') ? 'text-emerald-600 bg-emerald-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.sections.*') ? 'bg-emerald-100' : 'bg-slate-100 group-hover:bg-emerald-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-th-large text-sm {{ request()->routeIs('admin.sections.*') ? 'text-emerald-600' : 'group-hover:text-emerald-600' }}"></i>
            </div>
            <span class="truncate">Sections</span>
            <span class="ml-auto bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarSectionCount }}</span>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.users.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-100' : 'bg-slate-100 group-hover:bg-blue-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-users text-sm {{ request()->routeIs('admin.users.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
            </div>
            <span class="truncate">Users</span>
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarUserCount }}</span>
        </a>

        <a href="{{ route('admin.pending-registrations.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.pending-registrations.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.pending-registrations.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.pending-registrations.*') ? 'bg-amber-100' : 'bg-slate-100 group-hover:bg-amber-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-user-clock text-sm {{ request()->routeIs('admin.pending-registrations.*') ? 'text-amber-600' : 'group-hover:text-amber-600' }}"></i>
            </div>
            <span class="truncate">Pending Registrations</span>
            <span class="ml-auto bg-amber-100 text-amber-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarPendingCount }}</span>
        </a>

        <!-- Online Enrollment Applications -->
        <a href="{{ route('admin.enrollment.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.enrollment.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.enrollment.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.enrollment.*') ? 'bg-indigo-100' : 'bg-slate-100 group-hover:bg-indigo-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-file-signature text-sm {{ request()->routeIs('admin.enrollment.*') ? 'text-indigo-600' : 'group-hover:text-indigo-600' }}"></i>
            </div>
            <span class="truncate">Online Enrollments</span>
            @if($sidebarEnrollmentCount > 0)
                <span class="ml-auto bg-indigo-100 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0">{{ $sidebarEnrollmentCount }}</span>
            @endif
        </a>
        
        <a href="{{ route('admin.reports.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-xl font-medium transition-all group">
            <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-rose-50 flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-file-alt text-sm group-hover:text-rose-600"></i>
            </div>
            <span class="truncate">Reports</span>
        </a>

        <a href="{{ route('admin.activity-logs.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.activity-logs.*') ? 'text-slate-900 bg-slate-100' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-200' : 'bg-slate-100 group-hover:bg-slate-200' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-history text-sm {{ request()->routeIs('admin.activity-logs.*') ? 'text-slate-700' : 'group-hover:text-slate-700' }}"></i>
            </div>
            <span class="truncate">Activity Logs</span>
        </a>
        
        <a href="{{ route('admin.school-years.index') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.school-years.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.school-years.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.school-years.*') ? 'bg-blue-100' : 'bg-slate-100 group-hover:bg-blue-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-calendar-alt text-sm {{ request()->routeIs('admin.school-years.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
            </div>
            <span class="truncate">School Year</span>
        </a>

        <a href="{{ route('admin.import.students') }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="nav-item {{ request()->routeIs('admin.import.*') ? 'active' : '' }} flex items-center gap-3 px-3 lg:px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.import.*') ? 'text-violet-600 bg-violet-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.import.*') ? 'bg-violet-100' : 'bg-slate-100 group-hover:bg-violet-50' }} flex items-center justify-center flex-shrink-0 transition-colors">
                <i class="fas fa-file-csv text-sm {{ request()->routeIs('admin.import.*') ? 'text-violet-600' : 'group-hover:text-violet-600' }}"></i>
            </div>
            <span class="truncate">Bulk Import</span>
        </a>

        <!-- School Year Section -->
        <div class="pt-4 mt-4 border-t border-slate-100">
            <p class="px-3 lg:px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">School Year</p>
            <form action="{{ route('admin.school-year.set-active') }}" method="POST" class="px-3 lg:px-4">
                @csrf
                <div class="relative">
                    <select name="school_year_id" onchange="this.form.submit()" 
                            class="w-full appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2 pl-3 pr-8 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer transition-all hover:bg-slate-100">
                        @foreach(\App\Models\SchoolYear::orderBy('start_date', 'desc')->get() as $year)
                            <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>
                                {{ $year->name }} {{ $year->is_active ? '✓' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </form>
            @if($activeSchoolYear)
                <p class="px-3 lg:px-4 mt-2 text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    <span class="truncate">Active: {{ $activeSchoolYear->name }}</span>
                </p>
                
                {{-- End School Year Button --}}
                <div class="px-3 lg:px-4 mt-3">
                    <button onclick="confirmEndSchoolYear()" 
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl text-sm font-semibold shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 hover:from-rose-600 hover:to-red-700 transition-all duration-300 group">
                        <i class="fas fa-calendar-times group-hover:rotate-12 transition-transform"></i>
                        <span class="truncate">End School Year</span>
                    </button>
                    <p class="text-[10px] text-slate-400 mt-1.5 text-center">Marks enrolled students as completed</p>
                </div>
            @else
                <p class="px-3 lg:px-4 mt-2 text-xs text-amber-600 font-medium flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>No active school year</span>
                </p>
            @endif
        </div>
    </nav>

    <!-- Bottom Section: Logout & User Profile -->
    <div class="border-t border-slate-100 flex-shrink-0">
        <!-- Logout -->
        <div class="p-3 lg:p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 lg:px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-all">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </div>
                    <span class="truncate">Logout</span>
                </button>
            </form>
        </div>

        <!-- User Profile -->
        <div class="p-3 lg:p-4 border-t border-slate-100 user-menu-container">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-slate-50 to-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleUserMenu()">
                <div class="relative flex-shrink-0">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'Admin') . '&background=2563eb&color=fff' }}" 
                         alt="Admin" 
                         class="w-9 h-9 lg:w-10 lg:h-10 rounded-full border-2 border-white shadow-sm object-cover">
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 truncate font-medium">Administrator</p>
                </div>
                <button class="text-slate-400 hover:text-slate-600 transition-colors p-1 flex-shrink-0">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
            
            <!-- User Dropdown Menu -->
            <div id="userMenu" class="hidden bg-white rounded-2xl shadow-2xl border border-slate-200 p-2 w-56">
                <div class="p-3 border-b border-slate-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-900 text-sm truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@tugaweelem.edu' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full uppercase tracking-wide">Admin</span>
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    </div>
                </div>
                <div class="p-1 space-y-0.5">
                    <a href="{{ route('admin.users.edit', auth()->user()) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center flex-shrink-0 transition-colors">
                            <i class="fas fa-user text-blue-500 text-sm"></i>
                        </div>
                        <span class="font-medium">Profile</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center flex-shrink-0 transition-colors">
                            <i class="fas fa-cog text-amber-500 text-sm"></i>
                        </div>
                        <span class="font-medium">Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- End School Year Confirmation Modal --}}
    <div id="endSchoolYearModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeEndSchoolYearModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full transform transition-all scale-100 p-6 mx-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-rose-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">End School Year?</h3>
                    <p class="text-slate-600 text-sm mb-2">
                        This will mark <span class="font-bold text-rose-600" id="studentCount">{{ $sidebarStudentCount }}</span> students as 
                        <span class="font-semibold">completed</span> for 
                        <span class="font-semibold">{{ $activeSchoolYear?->name }}</span>.
                    </p>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4 text-left">
                        <p class="text-xs text-amber-800 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span>Students with 'enrolled' or 'approved' status will be marked as 'completed'. They will need to submit new enrollment requests for the next school year.</span>
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="closeEndSchoolYearModal()" 
                                class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                            Cancel
                        </button>
                        <form action="{{ route('admin.school-year.end') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2.5 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl font-semibold hover:from-rose-600 hover:to-red-700 transition-all shadow-lg shadow-rose-500/30">
                                Yes, End School Year
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.classList.toggle('hidden');
}

function confirmEndSchoolYear() {
    document.getElementById('endSchoolYearModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEndSchoolYearModal() {
    document.getElementById('endSchoolYearModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    const profileCard = e.target.closest('.user-menu-container');
    
    if (!menu.classList.contains('hidden') && !profileCard) {
        menu.classList.add('hidden');
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEndSchoolYearModal();
    }
});
</script>
