<!-- Tugawe Elementary School Sidebar - Fixed Layout -->
<aside id="sidebar" 
       x-data="{ 
           collapsed: false, 
           mobileOpen: false,
           init() {
               // Only restore collapsed state on desktop
               if (window.innerWidth >= 1024) {
                   this.collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
               }
               this.$watch('collapsed', value => {
                   if (window.innerWidth >= 1024) {
                       localStorage.setItem('sidebarCollapsed', value);
                   }
               });
           }
       }"
       class="fixed left-0 top-0 h-full bg-white border-r border-slate-200 flex flex-col z-40 transition-all duration-300 ease-out shadow-xl shadow-slate-200/50"
       :class="{
           'w-20': collapsed && !mobileOpen,
           'w-72': !collapsed || mobileOpen,
           '-translate-x-full': !mobileOpen && window.innerWidth < 1024,
           'translate-x-0': mobileOpen || window.innerWidth >= 1024
       }"
       @resize.window="
           if (window.innerWidth < 1024) {
               collapsed = false;
               mobileOpen = false;
           }
       ">
    
    <!-- Mobile Overlay - Only show when mobileOpen is true -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden">
    </div>

    <!-- Header Section -->
    <div class="relative flex items-center h-16 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white shrink-0"
         :class="collapsed && !mobileOpen ? 'justify-center px-2' : 'justify-between px-5'">
        
        <!-- Logo -->
        <div class="flex items-center gap-3 overflow-hidden transition-all duration-300"
             :class="{ 'justify-center w-full': collapsed && !mobileOpen }">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-200 shrink-0 transition-transform duration-300 hover:scale-105">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"/>
                </svg>
            </div>
            
            <div class="flex-1 min-w-0 overflow-hidden transition-all duration-300"
                 :class="{ 'w-0 opacity-0': collapsed && !mobileOpen, 'w-auto opacity-100': !collapsed || mobileOpen }">
                <h1 class="font-bold text-slate-900 text-sm leading-tight tracking-tight truncate">Tugawe Elementary</h1>
                <p class="text-[11px] font-medium text-slate-500 flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    ID: {{ $schoolId ?? '120231' }}
                </p>
            </div>
        </div>

        <!-- Collapse Toggle (Desktop Only) -->
        <button @click="collapsed = !collapsed; $dispatch('sidebar-toggle', { collapsed: collapsed })"
                class="hidden lg:flex absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white border border-slate-200 rounded-full items-center justify-center shadow-md hover:shadow-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group z-50">
            <svg class="w-3 h-3 text-slate-500 group-hover:text-indigo-600 transition-transform duration-300" 
                 :class="{ 'rotate-180': collapsed }"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-slate-300 scrollbar-track-transparent hover:scrollbar-thumb-slate-400">
        
        <!-- Student Profile Card (Hidden when collapsed on desktop) -->
        <div class="p-4 mx-4 mt-4 bg-gradient-to-br from-indigo-50/80 to-white rounded-2xl border border-indigo-100/50 shadow-sm hover:shadow-md transition-all duration-300 group overflow-hidden relative"
             :class="{ 
                 'hidden': collapsed && !mobileOpen, 
                 'block': !collapsed || mobileOpen 
             }">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-100/30 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            
            <div class="relative flex items-center gap-3">
                <div class="relative shrink-0">
                    @if($student->profile_photo)
                        <img src="{{ asset('storage/' . $student->profile_photo) }}" 
                             class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md group-hover:ring-indigo-200 transition-all" 
                             alt="{{ $student->user->first_name }}">
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
                        @if(isset($section))
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

        <!-- Collapsed Profile Avatar (Visible only when collapsed on desktop) -->
        <div class="p-3 flex justify-center"
             :class="{ 'flex': collapsed && !mobileOpen, 'hidden': !collapsed || mobileOpen }">
            <div class="relative cursor-pointer hover:scale-110 transition-transform duration-200 group">
                @if($student->profile_photo)
                    <img src="{{ asset('storage/' . $student->profile_photo) }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-100 group-hover:ring-indigo-300 transition-all" 
                         alt="{{ $student->user->first_name ?? 'Student' }}">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs shadow-md group-hover:shadow-lg transition-all">
                        {{ substr($student->user->first_name ?? 'S', 0, 1) }}{{ substr($student->user->last_name ?? 'T', 0, 1) }}
                    </div>
                @endif
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></div>
                
                <!-- Tooltip -->
                <div class="absolute left-full ml-2 px-2 py-1 bg-slate-800 text-white text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 hidden lg:block">
                    {{ $student->user->first_name ?? 'Student' }}
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="py-4 px-3 space-y-6">
            
            <!-- Main Menu Section -->
            <div>
                <div class="px-3 mb-2 overflow-hidden transition-all duration-300 h-5"
                     :class="{ 'opacity-0 h-0 mb-0': collapsed && !mobileOpen, 'opacity-100': !collapsed || mobileOpen }">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Main Menu</p>
                </div>
                <div class="flex justify-center mb-2 overflow-hidden transition-all duration-300"
                     :class="{ 'h-4 opacity-100': collapsed && !mobileOpen, 'h-0 opacity-0 mb-0': !collapsed || mobileOpen }">
                    <div class="w-8 h-px bg-slate-200 mt-2"></div>
                </div>
                
                <div class="space-y-1">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('student.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('student.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        
                        @if(request()->routeIs('student.dashboard'))
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 opacity-100"></div>
                        @endif
                        
                        <span class="relative flex items-center gap-3" :class="collapsed && !mobileOpen ? 'flex-col gap-1' : ''">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            
                            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap"
                                  :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Dashboard</span>
                            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                                  :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Home</span>
                        </span>
                    </a>

                    <!-- My Subjects -->
                    <a href="{{ route('student.subjects') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.subjects*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.subjects*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">My Subjects</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Subjects</span>
                    </a>

                    <!-- Attendance -->
                    <a href="{{ route('student.attendance') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.attendance*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.attendance*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Attendance</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Attend</span>
                    </a>

                    <!-- Grades -->
                    <a href="{{ route('student.grades') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.grades*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.grades*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">My Grades</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Grades</span>
                    </a>
                </div>
            </div>

            <!-- Classroom Section -->
            <div>
                <div class="px-3 mb-2 overflow-hidden transition-all duration-300 h-5"
                     :class="{ 'opacity-0 h-0 mb-0': collapsed && !mobileOpen, 'opacity-100': !collapsed || mobileOpen }">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Classroom</p>
                </div>
                <div class="flex justify-center mb-2 overflow-hidden transition-all duration-300"
                     :class="{ 'h-4 opacity-100': collapsed && !mobileOpen, 'h-0 opacity-0 mb-0': !collapsed || mobileOpen }">
                    <div class="w-8 h-px bg-slate-200 mt-2"></div>
                </div>
                
                <div class="space-y-1">
                    
                    <!-- Classmates -->
                    <a href="{{ route('student.classmates') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.classmates*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.classmates*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Classmates</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Class</span>
                    </a>

                    <!-- Assignments -->
                    <a href="{{ route('student.assignments') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.assignments*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <div class="relative shrink-0">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.assignments*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            @if(isset($pendingAssignments) && $pendingAssignments > 0)
                                <span class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm animate-pulse"
                                      :class="collapsed && !mobileOpen ? 'w-3 h-3 -top-1 -right-1 text-[7px]' : ''">
                                    {{ $pendingAssignments }}
                                </span>
                            @endif
                        </div>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Assignments</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Tasks</span>
                    </a>
                </div>
            </div>

            <!-- Communication Section -->
            <div>
                <div class="px-3 mb-2 overflow-hidden transition-all duration-300 h-5"
                     :class="{ 'opacity-0 h-0 mb-0': collapsed && !mobileOpen, 'opacity-100': !collapsed || mobileOpen }">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Communication</p>
                </div>
                <div class="flex justify-center mb-2 overflow-hidden transition-all duration-300"
                     :class="{ 'h-4 opacity-100': collapsed && !mobileOpen, 'h-0 opacity-0 mb-0': !collapsed || mobileOpen }">
                    <div class="w-8 h-px bg-slate-200 mt-2"></div>
                </div>
                
                <div class="space-y-1">
                    
                    <!-- Messages -->
                    <a href="{{ route('student.messages') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.messages*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <div class="relative shrink-0">
                            <svg class="w-5 h-5 {{ request()->routeIs('student.messages*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            @if(isset($unreadMessages) && $unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-rose-500 rounded-full border-2 border-white shadow-sm"
                                      :class="collapsed && !mobileOpen ? 'w-2 h-2' : ''"></span>
                            @endif
                        </div>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Messages</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Chat</span>
                    </a>

                    <!-- Announcements -->
                    <a href="{{ route('student.announcements') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 group {{ request()->routeIs('student.announcements*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}"
                       :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.announcements*') ? 'text-indigo-600' : 'text-slate-500 group-hover:text-indigo-600' }} transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span class="flex-1 overflow-hidden transition-all duration-300 whitespace-nowrap"
                              :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Announcements</span>
                        <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                              :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">News</span>
                    </a>
                </div>
            </div>

          
        </nav>
    </div>

    <!-- Bottom Actions -->
    <div class="p-3 border-t border-slate-100 bg-slate-50/50 shrink-0 space-y-1">
        
        <!-- Help -->
        <a href="{{ route('student.help') }}" 
           class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:text-slate-900 hover:bg-white rounded-xl font-medium text-sm transition-all duration-200 group"
           :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap"
                  :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Help & Support</span>
            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                  :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Help</span>
        </a>
        
        <!-- Logout -->
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit()" 
                class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-xl font-medium text-sm transition-all duration-200 group"
                :class="collapsed && !mobileOpen ? 'justify-center px-2' : ''">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-rose-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap"
                  :class="collapsed && !mobileOpen ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100'">Logout</span>
            <span class="overflow-hidden transition-all duration-300 whitespace-nowrap text-[9px] font-medium"
                  :class="collapsed && !mobileOpen ? 'w-auto opacity-100 block' : 'w-0 opacity-0 hidden'">Exit</span>
        </button>
    </div>
</aside>

<!-- Mobile Toggle Button -->
<button @click="mobileOpen = !mobileOpen" 
        class="fixed top-4 left-4 z-50 lg:hidden w-10 h-10 bg-white rounded-xl shadow-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:border-indigo-300 hover:shadow-xl transition-all duration-200">
    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>

<!-- Main Content Spacer - Use this in your main layout file -->
<div class="transition-all duration-300 ease-out min-h-screen"
     :class="{ 
         'lg:ml-20': collapsed && !mobileOpen, 
         'lg:ml-72': (!collapsed && !mobileOpen) || mobileOpen,
         'ml-0': !mobileOpen && window.innerWidth < 1024
     }">