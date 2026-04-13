<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- PWA Meta Tags --}}
    @include('partials.pwa-meta')
    
    <title>@yield('title', 'Admin') - Tugawe Elementary School</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
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
        
        /* Sidebar Transition */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
        }
        
        /* Responsive Tables */
        .responsive-table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Card Grid Responsive */
        .responsive-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .responsive-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .responsive-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1280px) {
            .responsive-grid { grid-template-columns: repeat(4, 1fr); }
        }
        
        /* Stats Grid Responsive */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        @media (min-width: 640px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        }
        @media (min-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(5, 1fr); }
        }
        
        /* Form Grid Responsive */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .form-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        /* Action Buttons Responsive */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        @media (min-width: 640px) {
            .action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 lg:hidden mobile-overlay"
         @click="sidebarOpen = false">
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('admin.includes.sidebar')
        
        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-72">
            
            <!-- Mobile Header -->
            <header class="lg:hidden sticky top-0 z-30 bg-white/95 backdrop-blur-xl border-b border-slate-200 h-16 flex-shrink-0">
                <div class="flex items-center justify-between h-full px-4">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="p-2.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-graduation-cap text-sm"></i>
                            </div>
                            <span class="font-bold text-slate-800">Tugawe Elem</span>
                        </div>
                    </div>
                    
                    <!-- Mobile User Avatar -->
                    <div class="flex items-center gap-2">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                 alt="Admin" 
                                 class="w-9 h-9 rounded-full border-2 border-slate-200 object-cover">
                        @else
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 border-2 border-slate-200 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->first_name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Desktop Header -->
            <header class="hidden lg:flex sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 h-16 flex-shrink-0 items-center justify-between px-8">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">@yield('header-title', 'Dashboard')</h2>
                    <p class="text-xs text-slate-500">{{ now()->format('l, F d, Y') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2.5 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-hidden">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
