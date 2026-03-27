{{-- resources/views/admin/includes/sidebar.blade.php --}}
@php
// Get the active school year
$activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();

// Students count filtered by active school year
$sidebarStudentCount = $activeSchoolYear 
    ? \App\Models\Student::where('school_year_id', $activeSchoolYear->id)->count() 
    : \App\Models\Student::count();

// Teachers count filtered by active school year
$sidebarTeacherCount = $activeSchoolYear 
    ? \App\Models\Teacher::where('school_year_id', $activeSchoolYear->id)->count() 
    : \App\Models\Teacher::count();

// Sections count filtered by active school year
$sidebarSectionCount = $activeSchoolYear 
    ? \App\Models\Section::where('school_year_id', $activeSchoolYear->id)->count() 
    : \App\Models\Section::count();

// Users count filtered by related students and teachers (Option 2)
$sidebarUserCount = $activeSchoolYear 
    ? \App\Models\User::whereHas('student', function ($q) use ($activeSchoolYear) {
        $q->where('school_year_id', $activeSchoolYear->id);
      })
      ->orWhereHas('teacher', function ($q) use ($activeSchoolYear) {
        $q->where('school_year_id', $activeSchoolYear->id);
      })
      ->count()
    : \App\Models\User::count();

// Pending registrations count (students with status pending, filtered by active school year)
$sidebarPendingCount = $activeSchoolYear 
    ? \App\Models\Student::where('status', 'pending')
        ->where('school_year_id', $activeSchoolYear->id)
        ->count() 
    : \App\Models\Student::where('status', 'pending')->count();
@endphp


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
</style>

<aside id="sidebar" class="sidebar w-72 bg-white border-r border-slate-200 h-screen flex flex-col">
    <!-- Logo -->
    <div class="p-6 border-b border-slate-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg text-slate-900 tracking-tight">Tugawe Elem</h1>
                <p class="text-xs text-slate-500 font-medium">Administration Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto scroll-smooth">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100' : 'bg-slate-100' }} flex items-center justify-center">
                <i class="fas fa-chart-pie text-sm {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}"></i>
            </div>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.students.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.students.*') ? 'bg-blue-100' : 'bg-slate-100 group-hover:bg-blue-50' }} flex items-center justify-center transition-colors">
                <i class="fas fa-users text-sm {{ request()->routeIs('admin.students.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
            </div>
            <span>Students</span>
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">{{ $sidebarStudentCount }}</span>
        </a>
        
        <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.teachers.*') ? 'text-purple-600 bg-purple-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.teachers.*') ? 'bg-purple-100' : 'bg-slate-100 group-hover:bg-purple-50' }} flex items-center justify-center transition-colors">
                <i class="fas fa-chalkboard-teacher text-sm {{ request()->routeIs('admin.teachers.*') ? 'text-purple-600' : 'group-hover:text-purple-600' }}"></i>
            </div>
            <span>Teachers</span>
            <span class="ml-auto bg-purple-100 text-purple-700 text-xs px-2.5 py-1 rounded-full font-bold">{{ $sidebarTeacherCount }}</span>
        </a>
        
        <a href="{{ route('admin.sections.index') }}" class="nav-item {{ request()->routeIs('admin.sections.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.sections.*') ? 'text-emerald-600 bg-emerald-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.sections.*') ? 'bg-emerald-100' : 'bg-slate-100 group-hover:bg-emerald-50' }} flex items-center justify-center transition-colors">
                <i class="fas fa-th-large text-sm {{ request()->routeIs('admin.sections.*') ? 'text-emerald-600' : 'group-hover:text-emerald-600' }}"></i>
            </div>
            <span>Sections</span>
            <span class="ml-auto bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">{{ $sidebarSectionCount }}</span>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }} 
                  flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group 
                  {{ request()->routeIs('admin.users.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            
            <div class="w-8 h-8 rounded-lg 
                        {{ request()->routeIs('admin.users.*') ? 'bg-blue-100' : 'bg-slate-100 group-hover:bg-blue-50' }} 
                        flex items-center justify-center transition-colors">
                <i class="fas fa-users text-sm 
                          {{ request()->routeIs('admin.users.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
            </div>
            
            <span>Users</span>
            
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">
                {{ $sidebarUserCount }}
            </span>
        </a>

        <a href="{{ route('admin.pending-registrations.index') }}" 
           class="nav-item {{ request()->routeIs('admin.pending-registrations.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.pending-registrations.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.pending-registrations.*') ? 'bg-amber-100' : 'bg-slate-100 group-hover:bg-amber-50' }} flex items-center justify-center transition-colors">
                <i class="fas fa-user-clock text-sm {{ request()->routeIs('admin.pending-registrations.*') ? 'text-amber-600' : 'group-hover:text-amber-600' }}"></i>
            </div>
            <span>Pending Registrations</span>
            <span class="ml-auto bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full font-bold">
                {{ $sidebarPendingCount }}
            </span>
        </a>
        
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-xl font-medium transition-all group">
            <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-rose-50 flex items-center justify-center transition-colors">
                <i class="fas fa-file-alt text-sm group-hover:text-rose-600"></i>
            </div>
            <span>Reports</span>
        </a>
        
        <div class="pt-4 mt-4 border-t border-slate-100">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">School Year</p>
            <form action="{{ route('admin.school-year.set-active') }}" method="POST" class="px-4">
                @csrf
                <div class="relative">
                    <select name="school_year_id" onchange="this.form.submit()" 
                            class="w-full appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2.5 pl-3 pr-10 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer transition-all hover:bg-slate-100">
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
                <p class="px-4 mt-2 text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    Active: {{ $activeSchoolYear->name }}
                </p>
            @else
                <p class="px-4 mt-2 text-xs text-amber-600 font-medium flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    No active school year
                </p>
            @endif
        </div>
    </nav>

    <!-- Bottom Section: Logout & User Profile -->
    <div class="border-t border-slate-100 flex-shrink-0">
        <!-- Logout -->
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-all">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </div>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-slate-100 user-menu-container">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-slate-50 to-white border border-slate-200 shadow-sm cursor-pointer" onclick="toggleUserMenu()">
                <div class="relative">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'Admin') . '&background=2563eb&color=fff' }}" 
                         alt="Admin" 
                         class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 truncate font-medium">Administrator</p>
                </div>
                <button class="text-slate-400 hover:text-slate-600 transition-colors p-1">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
            
            <!-- User Dropdown Menu -->
            <div id="userMenu" class="hidden bg-white rounded-2xl shadow-2xl border border-slate-200 p-2 w-56">
                <div class="p-3 border-b border-slate-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
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
                        <div class="w-8 h-8 rounded-lg bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                            <i class="fas fa-user text-blue-500 text-sm"></i>
                        </div>
                        <span class="font-medium">Profile</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center transition-colors">
                            <i class="fas fa-cog text-amber-500 text-sm"></i>
                        </div>
                        <span class="font-medium">Settings</span>
                    </a>
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

// Close menu when clicking outside
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    const profileCard = e.target.closest('.user-menu-container');
    
    if (!menu.classList.contains('hidden') && !profileCard) {
        menu.classList.add('hidden');
    }
});
</script>