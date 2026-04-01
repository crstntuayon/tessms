<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | Tugawe Elementary School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Prevent flash of unstyled content */
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar for sidebar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media print {
            aside, .no-print, .mobile-toggle, .desktop-toggle {
                display: none !important;
            }
            main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased"
      x-data="{ 
          sidebarCollapsed: false, 
          mobileOpen: false,
          init() {
              // Initialize based on screen size
              if (window.innerWidth >= 1024) {
                  this.sidebarCollapsed = false;
              } else {
                  this.mobileOpen = false;
              }
          }
      }"
      x-init="init()"
      @resize.window="
          if (window.innerWidth < 1024) {
              sidebarCollapsed = false;
          }
      ">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden"
         style="display: none;">
    </div>

    <!-- Mobile Toggle Button -->
    <button @click="mobileOpen = !mobileOpen" 
            class="mobile-toggle fixed top-4 left-4 z-50 lg:hidden w-12 h-12 bg-white rounded-2xl shadow-lg shadow-slate-200/50 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:scale-105 hover:shadow-xl transition-all duration-200 border border-slate-100">
        <i class="fas fa-bars text-lg" x-show="!mobileOpen"></i>
        <i class="fas fa-times text-lg" x-show="mobileOpen"></i>
    </button>



    <!-- Sidebar (Updated Version) -->
    @include('student.includes.sidebar')

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300 ease-out"
          :class="{ 
              'lg:ml-0': sidebarCollapsed, 
              'lg:ml-72': !sidebarCollapsed 
          }">

        <!-- Top Header -->
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-xl border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="hover:text-slate-700 cursor-pointer transition-colors">Home</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-800 font-medium">Dashboard</span>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-4">
                    <!-- Enhanced Clock -->
                    <div class="hidden md:flex items-center gap-3 bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-2 rounded-2xl border border-slate-200/80 shadow-sm">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                                <i class="fas fa-clock text-white text-sm"></i>
                            </div>
                            <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white animate-pulse"></div>
                        </div>
                        <div class="flex flex-col min-w-[100px]">
                            <div class="flex items-baseline gap-1">
                                <span id="liveClock" class="text-lg font-bold text-slate-800 font-mono tabular-nums tracking-tight">12:00:00</span>
                                <span id="ampm" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded-md">PM</span>
                            </div>
                            <span id="liveDate" class="text-[11px] text-slate-500 uppercase tracking-wider font-medium">{{ now()->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <button class="relative w-11 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition-all duration-200 hover:scale-105">
                        <i class="fas fa-bell text-lg"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white animate-bounce">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-6 max-w-7xl mx-auto space-y-6 animate-fade-in">

            <!-- Enhanced Welcome Section -->
            <div class="relative overflow-hidden bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50">
                <!-- Background Decorative Elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100/50 to-purple-100/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-100/40 to-cyan-100/40 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
                
                <div class="relative p-8 md:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                        
                        <!-- Left: Student Info -->
                        <div class="flex-1 space-y-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active Student
                            </div>
                            
                            <div>
                                <p class="text-slate-500 text-sm mb-1 font-medium">Welcome back,</p>
                                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">
                                    {{ $student->user->first_name ?? 'Student' }} 
                                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                                        {{ $student->user->last_name ?? '' }}
                                    </span>
                                </h1>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                @if(isset($student->grade_level) && isset($student->section))
                                    <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium">
                                        <i class="fas fa-graduation-cap text-indigo-600"></i>
                                        <span>Grade {{ $student->grade_level }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium">
                                        <i class="fas fa-users text-purple-600"></i>
                                        <span>{{ $student->section->name ?? 'Section' }}</span>
                                    </div>
                                @endif
                                
                                @if(isset($student->lrn))
                                    <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 text-xs font-mono">
                                        <i class="fas fa-id-card"></i>
                                        <span>LRN: {{ $student->lrn }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Stats Row -->
                            <div class="flex flex-wrap gap-4 pt-2">
                                @if(isset($attendanceRate))
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ number_format($attendanceRate, 1) }}%</p>
                                            <p class="text-xs text-slate-500">Attendance</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($generalAverage))
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $generalAverage }}</p>
                                            <p class="text-xs text-slate-500">Average</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Date & Actions -->
                        <div class="flex flex-col sm:flex-row lg:flex-col items-start sm:items-center lg:items-end gap-6">
                            <!-- Date Display -->
                            <div class="text-left sm:text-right lg:text-right">
                                <p class="text-5xl md:text-6xl font-bold text-slate-900 tracking-tighter leading-none mb-1">
                                    {{ now()->format('d') }}
                                </p>
                                <p class="text-lg font-semibold text-slate-700 uppercase tracking-wide">
                                    {{ now()->format('l') }}
                                </p>
                                <p class="text-sm text-slate-500 font-medium">
                                    {{ now()->format('F Y') }}
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <button class="group relative px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-800 transition-all duration-200 shadow-lg shadow-slate-900/20 hover:shadow-xl hover:shadow-slate-900/30 hover:-translate-y-0.5">
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-qrcode"></i>
                                        ID Card
                                    </span>
                                </button>
                                <a href="{{ route('student.profile') }}"  
                                   class="group relative px-5 py-2.5 bg-white text-slate-700 text-sm font-semibold rounded-xl border-2 border-slate-200 hover:border-indigo-300 hover:text-indigo-600 transition-all duration-200 hover:-translate-y-0.5 inline-block">
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-edit"></i>
                                        Edit Profile
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Info Bar -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-4 text-sm text-slate-500">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-indigo-500"></i>
                                <span>Last login: {{ now()->subHours(2)->format('M d, h:i A') }}</span>
                            </div>
                            <div class="hidden sm:block w-1 h-1 rounded-full bg-slate-300"></div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-emerald-500"></i>
                                <span>Account secure</span>
                            </div>
                        </div>
                        
                        @if(isset($announcements) && $announcements->count() > 0)
                            <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 border border-amber-100 text-amber-700 text-xs font-semibold">
                                <i class="fas fa-bullhorn"></i>
                                <span>{{ $announcements->count() }} new announcement{{ $announcements->count() > 1 ? 's' : '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Attendance Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                <i class="fas fa-calendar-check text-xl"></i>
                            </div>
                            @if(isset($attendanceTrend) && $attendanceTrend > 0)
                                <span class="text-emerald-600 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-arrow-up"></i>
                                    {{ $attendanceTrend }}%
                                </span>
                            @elseif(isset($attendanceTrend) && $attendanceTrend < 0)
                                <span class="text-rose-600 text-xs font-bold bg-rose-50 px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-arrow-down"></i>
                                    {{ abs($attendanceTrend) }}%
                                </span>
                            @endif
                        </div>
                        <h3 class="text-slate-500 text-sm font-medium">Attendance Rate</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($attendanceRate ?? 0, 1) }}%</p>
                        <div class="mt-3 w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $attendanceRate ?? 0 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">
                            {{ $presentDays ?? 0 }} of {{ $totalSchoolDays ?? 0 }} days present
                        </p>
                    </div>
                </div>

                <!-- Grades Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            @if(isset($gradeRank))
                                <span class="text-indigo-600 text-xs font-bold bg-indigo-50 px-2 py-1 rounded-full">
                                    Top {{ $gradeRank }}%
                                </span>
                            @endif
                        </div>
                        <h3 class="text-slate-500 text-sm font-medium">General Average</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $generalAverage ?? 'N/A' }}</p>
                        @if(isset($generalAverageNumeric))
                            <p class="text-xs text-slate-400 mt-2">
                                Numerical: {{ number_format($generalAverageNumeric, 2) }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Assignments Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:border-amber-200 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <i class="fas fa-clipboard-list text-xl"></i>
                            </div>
                            @if(isset($pendingAssignments) && $pendingAssignments > 0)
                                <span class="text-rose-600 text-xs font-bold bg-rose-50 px-2 py-1 rounded-full animate-pulse">
                                    {{ $pendingAssignments }} Pending
                                </span>
                            @endif
                        </div>
                        <h3 class="text-slate-500 text-sm font-medium">Assignments</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">
                            {{ $submittedAssignments ?? 0 }}/{{ $totalAssignments ?? 0 }}
                        </p>
                        @if(isset($assignmentsDueThisWeek) && $assignmentsDueThisWeek > 0)
                            <p class="text-xs text-amber-600 mt-2 font-medium">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $assignmentsDueThisWeek }} due this week
                            </p>
                        @else
                            <p class="text-xs text-slate-400 mt-2">No assignments due this week</p>
                        @endif
                    </div>
                </div>

                <!-- Behavior/Conduct Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:scale-110 transition-transform"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                                <i class="fas fa-heart text-xl"></i>
                            </div>
                            @if(isset($conductRating))
                                <span class="text-purple-600 text-xs font-bold bg-purple-50 px-2 py-1 rounded-full">
                                    {{ $conductRating }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-slate-500 text-sm font-medium">Conduct & Behavior</h3>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $behaviorPoints ?? 0 }}</p>
                        <p class="text-xs text-slate-400 mt-2">Behavior points this month</p>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Classmates Section -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fas fa-users"></i>
                            </div>
                            My Classmates
                        </h3>
                        <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $classmates->count() ?? 0 }} students
                        </span>
                    </div>
                    <div class="p-6">
                        @if($classmates->isEmpty())
                            <div class="text-center py-12 text-slate-400">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user-friends text-3xl opacity-50"></i>
                                </div>
                                <p class="font-medium">No classmates found</p>
                                <p class="text-sm mt-1">You might be the first student in this section!</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($classmates->take(8) as $mate)
                                <div class="flex items-center gap-3 p-4 rounded-xl hover:bg-slate-50 transition-all duration-200 border border-slate-100 hover:border-indigo-200 hover:shadow-sm group">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($mate->user->first_name . ' ' . $mate->user->last_name) }}&background=random&color=fff&size=128" 
                                             class="w-12 h-12 rounded-full shadow-sm group-hover:scale-110 transition-transform" 
                                             alt="{{ $mate->user->first_name }}">
                                        @if($loop->first)
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center border-2 border-white" title="Class Topper">
                                                <i class="fas fa-crown text-[10px] text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $mate->user->first_name }} {{ $mate->user->last_name }}</p>
                                       
                                    </div>
                                    <button class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-indigo-100 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all duration-200 hover:scale-105" title="Send Message">
                                        <i class="fas fa-envelope text-xs"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @if($classmates->count() > 8)
                                <div class="mt-4 text-center">
                                    <button class="text-sm text-indigo-600 hover:text-indigo-700 font-medium hover:underline">
                                        View all {{ $classmates->count() }} classmates
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Right Column: Calendar & Schedule -->
                <div class="space-y-6">
                    
                    <!-- Enhanced Mini Calendar -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                Calendar
                            </h3>
                            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-full border border-indigo-100">
                                {{ now()->format('F Y') }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] mb-3 text-slate-500 font-bold uppercase tracking-wide">
                            <span class="text-rose-500">S</span>
                            <span>M</span>
                            <span>T</span>
                            <span>W</span>
                            <span>T</span>
                            <span>F</span>
                            <span class="text-rose-500">S</span>
                        </div>
                        <div class="grid grid-cols-7 gap-1.5" id="miniCalendar">
                            <!-- Generated by JS -->
                        </div>
                        
                        <div class="mt-4 flex gap-3 text-[10px] justify-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/40"></div>
                                <span class="text-slate-600 font-medium">Present</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm shadow-rose-500/40"></div>
                                <span class="text-slate-600 font-medium">Absent</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/40"></div>
                                <span class="text-slate-600 font-medium">Late</span>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Schedule -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fas fa-clock"></i>
                            </div>
                            Today's Schedule
                        </h3>
                        
                        @if(isset($todaySchedule) && $todaySchedule->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($todaySchedule as $schedule)
                                    @php
                                        $isCurrentClass = now()->between(
                                            \Carbon\Carbon::parse($schedule->start_time),
                                            \Carbon\Carbon::parse($schedule->end_time)
                                        );
                                    @endphp
                                    <div class="flex gap-3 items-start p-3 rounded-xl border-l-4 {{ $isCurrentClass ? 'bg-indigo-50 border-indigo-500 shadow-sm' : 'bg-slate-50 border-slate-300' }} transition-all hover:shadow-md">
                                        <div class="text-xs font-bold {{ $isCurrentClass ? 'text-indigo-600' : 'text-slate-500' }} w-14 flex flex-col">
                                            <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i') }}</span>
                                            <span class="text-[9px] font-normal opacity-70">{{ \Carbon\Carbon::parse($schedule->start_time)->format('A') }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-800 text-sm flex items-center gap-2">
                                                {{ $schedule->subject->name ?? 'Subject' }}
                                                @if($isCurrentClass)
                                                    <span class="text-[10px] bg-indigo-500 text-white px-2 py-0.5 rounded-full animate-pulse">Now</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                Room {{ $schedule->room ?? 'TBA' }} • {{ $schedule->teacher->name ?? 'Teacher' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-400">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-coffee text-2xl opacity-50"></i>
                                </div>
                                <p class="text-sm font-medium">No classes scheduled</p>
                                <p class="text-xs mt-1">Enjoy your free time!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/25">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h3>
                        <div class="space-y-2">
                            <a href="#" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-200 backdrop-blur-sm group">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-file-upload text-sm"></i>
                                </div>
                                <span class="text-sm font-medium">Submit Assignment</span>
                                <i class="fas fa-chevron-right ml-auto text-xs opacity-70"></i>
                            </a>
                            <a href="#" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-200 backdrop-blur-sm group">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-qrcode text-sm"></i>
                                </div>
                                <span class="text-sm font-medium">View QR Code</span>
                                <i class="fas fa-chevron-right ml-auto text-xs opacity-70"></i>
                            </a>
                            <a href="#" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-200 backdrop-blur-sm group">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-print text-sm"></i>
                                </div>
                                <span class="text-sm font-medium">Print Grades</span>
                                <i class="fas fa-chevron-right ml-auto text-xs opacity-70"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-history"></i>
                        </div>
                        Recent Activity
                    </h3>
                    <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
                </div>
                <div class="p-6">
                    @if(isset($recentActivities) && $recentActivities->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($recentActivities->take(5) as $activity)
                                <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                                    <div class="w-10 h-10 rounded-full {{ $activity->color_class ?? 'bg-slate-100 text-slate-600' }} flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                        <i class="fas {{ $activity->icon ?? 'fa-circle' }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-800">{{ $activity->title }}</p>
                                        <p class="text-xs text-slate-500">{{ $activity->description }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-400">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-inbox text-2xl opacity-50"></i>
                            </div>
                            <p class="text-sm font-medium">No recent activities</p>
                            <p class="text-xs mt-1">Your activities will appear here</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        // Enhanced Clock with AM/PM
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            
            hours = hours % 12;
            hours = hours ? hours : 12;
            const hoursStr = hours.toString().padStart(2, '0');
            
            document.getElementById('liveClock').textContent = `${hoursStr}:${minutes}:${seconds}`;
            document.getElementById('ampm').textContent = ampm;
            
            // Update date
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            document.getElementById('liveDate').textContent = now.toLocaleDateString('en-US', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Mini Calendar with Attendance Data
        function generateCalendar() {
            const calendar = document.getElementById('miniCalendar');
            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth();
            const today = date.getDate();
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            // Attendance data from backend
            const attendanceData = @json($monthlyAttendance ?? []);
            
            let html = '';
            
            // Empty cells
            for (let i = 0; i < firstDay; i++) {
                html += `<div class="aspect-square"></div>`;
            }
            
            // Days
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = day === today;
                const isWeekend = (firstDay + day - 1) % 7 === 0 || (firstDay + day - 1) % 7 === 6;
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const status = attendanceData[dateString] || null;
                
                let classes = 'aspect-square flex items-center justify-center text-xs font-semibold rounded-lg transition-all duration-200 cursor-pointer hover:scale-110 ';
                
                if (isToday) {
                    classes += 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 ring-2 ring-indigo-200 ring-offset-2';
                } else if (status === 'present') {
                    classes += 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200';
                } else if (status === 'absent') {
                    classes += 'bg-rose-100 text-rose-700 hover:bg-rose-200';
                } else if (status === 'late') {
                    classes += 'bg-amber-100 text-amber-700 hover:bg-amber-200';
                } else if (isWeekend) {
                    classes += 'text-slate-300 bg-slate-50';
                } else {
                    classes += 'text-slate-600 hover:bg-slate-100';
                }
                
                const tooltip = status ? `title="${status.charAt(0).toUpperCase() + status.slice(1)}"` : '';
                html += `<div class="${classes}" ${tooltip}>${day}</div>`;
            }
            
            calendar.innerHTML = html;
        }
        generateCalendar();
    </script>
</body>
</html>