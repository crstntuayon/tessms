<!-- Teacher Sidebar - Light Theme with Glass Morphism -->

@php
$sections = \App\Models\Section::with('gradeLevel')
    ->where('teacher_id', auth()->user()->teacher->id ?? null)
    ->where('is_active', true) // only active sections
    ->get();
@endphp

<div class="flex flex-col w-72 h-screen bg-white/80 backdrop-blur-xl text-slate-800 fixed border-r border-white/50 shadow-2xl shadow-slate-200/50">
    
    <!-- Logo/Brand Section -->
    <div class="p-6 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg text-slate-900">Teacher Portal</h1>
                <p class="text-xs text-slate-500">Tugawe Elementary</p>
            </div>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="p-4 mx-4 mt-4">
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-4 border border-indigo-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">
                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-900 text-sm truncate">{{ auth()->user()->name ?? 'Teacher' }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'teacher@tugaweelem.edu' }}</p>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-xs text-emerald-600 font-medium">Online</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-4 px-3 overflow-y-auto custom-scrollbar">
        <p class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Main Menu</p>
        
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('teacher.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('teacher.dashboard') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all
                        {{ request()->routeIs('teacher.dashboard') ? 'bg-white/20' : 'bg-indigo-50 group-hover:bg-indigo-100' }}">
                        <i class="fas fa-home {{ request()->routeIs('teacher.dashboard') ? 'text-white' : 'text-indigo-500' }}"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- School Forms -->
<li x-data="{ open: {{ request()->routeIs('teacher.sf*') ? 'true' : 'false' }} }">
    
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
        text-slate-600 hover:bg-slate-50 hover:text-indigo-600">

        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-indigo-50 group-hover:bg-indigo-100">
                <i class="fas fa-folder text-indigo-500"></i>
            </div>
            <span>School Forms</span>
        </div>

        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
    </button>

    <!-- Dropdown -->
    <ul x-show="open" x-transition class="mt-2 ml-10 space-y-2">

        <!-- SF1 -->
        <li>
            <a href="{{ route('teacher.sf1') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf1') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF1 - School Register
            </a>
        </li>

        <!-- SF2 -->
        <li>
            <a href="{{ route('teacher.sf2') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf2') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF2 - Daily Attendance
            </a>
        </li>

         <!-- SF3 -->
        <li>
            <a href="{{ route('teacher.sf3') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf3') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF3 - Books
            </a>
        </li>

        <!-- SF5 -->
        <li>
            <a href="{{ route('teacher.sf5') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf5') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF5 - Learning Progress
            </a>
        </li>

        <!-- SF9 -->
        <li>
            <a href="{{ route('teacher.sf9') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf9') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF9 - Report Card
            </a>
        </li>

        <!-- SF10 -->
        <li>
            <a href="{{ route('teacher.sf10') }}" 
               class="block px-3 py-2 rounded-lg text-sm transition
               {{ request()->routeIs('teacher.sf10') ? 'bg-indigo-100 text-indigo-600 font-medium' : 'text-slate-500 hover:text-indigo-600' }}">
                SF10 - Permanent Record
            </a>
        </li>


    </ul>
</li>

            <!-- Sections Header -->
            <li class="mt-4">
                <p class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">My Sections</p>
            </li>

            <!-- Section Items with Accordion -->
            @foreach($sections as $section)
            <li class="mb-1">
                <details class="group" {{ request()->route('section')?->id == $section->id ? 'open' : '' }}>
                    <summary class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium cursor-pointer transition-all duration-200 text-slate-600 hover:bg-slate-50 hover:text-indigo-600 select-none">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center border border-emerald-100">
                            <span class="text-emerald-600 font-bold text-xs">{{ strtoupper(substr($section->name, 0, 2)) }}</span>
                        </div>
                      <div class="flex-1 min-w-0">
    <p class="truncate">
        {{ $section->name }} ({{ $section->gradeLevel->name ?? 'N/A' }})
    </p>
</div>
                        <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform group-open:rotate-180"></i>
                    </summary>
                    
                    <ul class="mt-1 ml-4 pl-4 border-l-2 border-slate-100 space-y-1">
                        <li>
                            <a href="{{ route('teacher.sections.students', $section) }}" 
                               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                <i class="fas fa-users text-xs w-4"></i>
                                <span>Students</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teacher.sections.attendance', $section) }}" 
                               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                <i class="fas fa-clipboard-check text-xs w-4"></i>
                                <span>Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teacher.sections.grades', $section) }}" 
                               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                <i class="fas fa-chart-line text-xs w-4"></i>
                                <span>Grades</span>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endforeach
        </ul>
    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-slate-100 bg-white/50">
        <!-- Quick Actions -->
        <div class="grid grid-cols-2 gap-2 mb-4">
            <a href="{{ route('teacher.profile') }}" class="flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-slate-50 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 transition-all text-xs font-medium">
                <i class="fas fa-user-circle"></i>
                Profile
            </a>
            <a href="{{ route('teacher.settings') }}" class="flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-slate-50 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-all text-xs font-medium">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white hover:from-red-600 hover:to-rose-600 transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/40 text-sm font-medium">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Custom Scrollbar Styles -->
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth details animation */
details > summary {
    list-style: none;
}
details > summary::-webkit-details-marker {
    display: none;
}
details[open] summary ~ * {
    animation: sweep 0.3s ease-in-out;
}
@keyframes sweep {
    0%    {opacity: 0; transform: translateY(-10px)}
    100%  {opacity: 1; transform: translateY(0)}
}
</style>