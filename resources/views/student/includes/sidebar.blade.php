@php
// Calculate unread announcement count for the student
$unreadAnnouncements = 0;
$currentStudent = auth()->user()->student;
if ($currentStudent) {
    $activeSchoolYear = \App\Models\SchoolYear::getActive();
    $unreadAnnouncements = \App\Models\Announcement::visibleToStudent($currentStudent)
        ->active()
        ->when($activeSchoolYear, fn($q) => $q->forSchoolYear($activeSchoolYear->id))
        ->unreadBy(auth()->id())
        ->count();
}
@endphp
<!-- Tugawe Elementary School Sidebar - Alpine.js Only -->
<aside id="sidebar" 
       x-cloak
       x-data="{ 
           init() {
               this.handleResize();
               window.addEventListener('resize', () => this.handleResize());
           },
           handleResize() {
               if (window.innerWidth >= 1024) {
                   // Desktop: always show sidebar
                   this.$dispatch('force-desktop');
               }
           }
       }"
       x-on:force-desktop.window="
           if (window.innerWidth >= 1024) {
               mobileOpen = false; // Reset mobile state
           }
       "
       :class="{
           'w-20': sidebarCollapsed && window.innerWidth >= 1024,
           'w-72': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen,
           '-translate-x-full': window.innerWidth < 1024 && !mobileOpen,
           'translate-x-0': window.innerWidth >= 1024 || mobileOpen
       }"
       class="fixed left-0 top-0 h-full bg-white border-r border-slate-200 flex flex-col z-40 shadow-xl shadow-slate-200/50 transition-all duration-300 ease-out overflow-hidden">

 <!-- Desktop Toggle Button - Floating Orb -->
<button @click="sidebarCollapsed = !sidebarCollapsed" 
        class="hidden lg:flex absolute -right-5 top-1/2 -translate-y-1/2 z-50 w-12 h-12 bg-gradient-to-br from-indigo-500 to-violet-600 hover:from-indigo-400 hover:to-violet-500 rounded-full shadow-2xl shadow-indigo-500/50 text-white transition-all duration-500 hover:scale-110 hover:-right-4 items-center justify-center border-4 border-white group overflow-hidden">
    
    <!-- Animated rings -->
    <div class="absolute inset-0 rounded-full border-2 border-white/30 animate-ping opacity-40"></div>
    <div class="absolute inset-2 rounded-full border border-white/20 animate-pulse"></div>
    
    <!-- Rotating background shine -->
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
    
    <!-- Icon with flip animation -->
    <i class="fas relative z-10 transition-all duration-500 transform" 
       :class="sidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="rotate-180 scale-50 opacity-0"
       x-transition:enter-end="rotate-0 scale-100 opacity-100"></i>
    
    <!-- Tooltip -->
    <span class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-slate-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-all whitespace-nowrap pointer-events-none shadow-lg">
        <span x-text="sidebarCollapsed ? 'Expand' : 'Collapse'"></span>
    </span>
</button>


    <!-- Header Section -->
    <div class="flex items-center justify-between h-16 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-white px-5 shrink-0">
        <!-- Logo -->
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-200 shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"/>
                </svg>
            </div>
            
            <div class="flex-1 min-w-0 overflow-hidden transition-all duration-300" 
                 :class="{ 'opacity-0 w-0': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">
                <h1 class="font-bold text-slate-900 text-sm leading-tight tracking-tight truncate">Tugawe Elementary</h1>
                <p class="text-[11px] font-medium text-slate-500 flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    ID: {{ $schoolId ?? '120231' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin">
        
        <!-- Student Profile Card -->
        @if(isset($student) && $student)
        <div x-show="(!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="p-4 mx-4 mt-4 bg-gradient-to-br from-indigo-50/80 to-white rounded-2xl border border-indigo-100/50 shadow-sm hover:shadow-md transition-all duration-300 group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-100/30 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            
            <div class="relative flex items-center gap-3">
                <div class="relative shrink-0">
                    @if($student->user && $student->user->photo)
                        <img src="{{ asset('storage/' . $student->user->photo) }}" 
                             class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md group-hover:ring-indigo-200 transition-all" 
                             alt="{{ $student->user->first_name ?? 'Student' }}">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white">
                            {{ substr($student->user->first_name ?? 'S', 0, 1) }}{{ substr($student->user->last_name ?? 'T', 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ $student->user->first_name ?? 'Student' }} {{ $student->user->last_name ?? '' }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[10px] font-bold rounded-full">
                            {{ $student->gradeLevel->name ?? 'N/A' }}
                        </span>
                        @if(isset($section) && $section)
                            <span class="text-[10px] text-slate-500 font-medium truncate">{{ $section->name ?? '' }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-2 mt-3 pt-3 border-t border-indigo-100/50">
                <div class="text-center">
                    <p class="text-base font-bold text-slate-900">{{ number_format($attendanceRate ?? 0, 0) }}%</p>
                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Attend</p>
                </div>
                <div class="text-center border-x border-indigo-100/50">
                    <p class="text-base font-bold text-slate-900">{{ $generalAverage ?? '—' }}</p>
                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Avg</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-slate-900">{{ $pendingAssignments ?? 0 }}</p>
                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Pending</p>
                </div>
            </div>
        </div>

        @endif
        
        <!-- Collapsed Profile Icon (shown when collapsed on desktop) -->
        @if(isset($student) && $student)
        <div x-show="sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen" 
             x-transition
             class="flex justify-center mt-4 mb-2">
            <div class="relative">
                @if($student->user && $student->user->photo)
                    <img src="{{ asset('storage/' . $student->user->photo) }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-md" 
                         alt="{{ $student->user->first_name ?? 'Student' }}">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs shadow-md ring-2 ring-white">
                        {{ substr($student->user->first_name ?? 'S', 0, 1) }}
                    </div>
                @endif
                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <nav class="py-4 px-3 space-y-6">
            
            <!-- Main Menu Section -->
            <div>
                <div x-show="(!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen" class="px-3 mb-2 h-5">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Main Menu</p>
                </div>
                <div x-show="sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen" class="flex justify-center mb-2">
                    <div class="w-8 h-px bg-slate-200"></div>
                </div>
                
                <div class="space-y-1">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('student.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('student.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50' }}">
                        
                        @if(request()->routeIs('student.dashboard'))
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 opacity-100"></div>
                        @endif
                        
                        <span class="relative flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="whitespace-nowrap transition-all duration-300" 
                                  :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Dashboard</span>
                        </span>
                    </a>

                    <!-- My Subjects -->
                    <a href="{{ route('student.subjects') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.subjects*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.subjects*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">My Subjects</span>
                    </a>

                    <!-- Attendance -->
                    <a href="{{ route('student.attendance') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.attendance*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.attendance*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Attendance</span>
                    </a>

                    <!-- Grades -->
                    <a href="{{ route('student.grades') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.grades*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.grades*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Report Card</span>
                    </a>

                    <!-- Enrollment -->
                    <a href="{{ route('student.enrollment.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.enrollment*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.enrollment*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Enrollment</span>
                        @php
                            $enrollmentEnabledValue = \App\Models\Setting::get('enrollment_enabled', false);
                            $enrollmentEnabled = $enrollmentEnabledValue === true || $enrollmentEnabledValue === '1' || $enrollmentEnabledValue === 1;
                        @endphp
                        @if($enrollmentEnabled)
                            <span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-[9px] font-bold rounded-full shrink-0">OPEN</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Classroom Section -->
            <div>
                <div x-show="(!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen" class="px-3 mb-2 h-5">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Classroom</p>
                </div>
                <div x-show="sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen" class="flex justify-center mb-2">
                    <div class="w-8 h-px bg-slate-200"></div>
                </div>
                
      
                
                <div class="space-y-1">
                    
        

                    <!-- Messages -->
                    <a href="{{ route('student.messenger') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.messenger') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <div class="relative">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.messenger') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            @php
                                $unreadMessages = \App\Models\Message::receivedBy(auth()->id())->unread()->count();
                            @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                                    {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
                                </span>
                            @endif
                        </div>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Messages</span>
                    </a>

                    <!-- Announcements -->
                    <a href="{{ route('student.announcements') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.announcements*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <div class="relative">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.announcements*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            @if($unreadAnnouncements > 0)
                                <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                                    {{ $unreadAnnouncements > 9 ? '9+' : $unreadAnnouncements }}
                                </span>
                            @endif
                        </div>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Announcements</span>
                    </a>

                    <!-- Events -->
                    <a href="{{ route('student.events.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.events*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.events*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="flex-1 whitespace-nowrap transition-all duration-300" 
                              :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Events</span>
                    </a>
                </div>
            </div>

        </nav>
    </div>

    <!-- Bottom Actions -->
    <div class="p-3 border-t border-slate-100 bg-slate-50/50 shrink-0 space-y-1">
        
        <!-- Help -->
        <a href="{{ route('student.help') }}" 
           class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:text-slate-900 hover:bg-white rounded-xl font-medium text-sm transition-all duration-200 group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="whitespace-nowrap transition-all duration-300" 
                  :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Help & Support</span>
        </a>
        
        <!-- Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit()" 
                class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-xl font-medium text-sm transition-all duration-200 group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-rose-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="whitespace-nowrap transition-all duration-300" 
                  :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed && window.innerWidth >= 1024 && !mobileOpen, 'opacity-100': (!sidebarCollapsed && window.innerWidth >= 1024) || mobileOpen }">Logout</span>
        </button>
    </div>
</aside>