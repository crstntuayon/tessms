<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $section->name }} - My Section</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50 font-sans text-slate-800" x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">

<!-- Mobile Overlay -->
<div x-show="mobileOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="mobileOpen = false"
     class="fixed inset-0 z-40 lg:hidden bg-slate-900/30 backdrop-blur-sm"
     style="display: none;"></div>

<div class="flex min-h-screen">
    
    <!-- Sidebar -->
    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <div class="flex-1 lg:ml-72 transition-all duration-300">
        
        <!-- Top Navigation -->
        <header class="bg-white/95 backdrop-blur-xl sticky top-0 z-30 border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="fas fa-bars text-slate-600"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">My Section</h1>
                        <p class="text-sm text-slate-500">{{ $section->name }}</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-6">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('teacher.sections.index') }}" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-slate-800">{{ $section->name }}</h2>
                </div>
                <p class="text-slate-500 ml-8">{{ $section->gradeLevel->name ?? 'Grade Level' }} | School Year {{ $section->schoolYear->name ?? 'N/A' }}</p>
            </div>

            <!-- Section Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Students Card -->
                <a href="{{ route('teacher.sections.students', $section) }}" class="block bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Students</h3>
                            <p class="text-sm text-slate-500">View student list</p>
                        </div>
                    </div>
                </a>

                <!-- Grades Card -->
                <a href="{{ route('teacher.sections.grades', $section) }}" class="block bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Grades</h3>
                            <p class="text-sm text-slate-500">Manage student grades</p>
                        </div>
                    </div>
                </a>

                <!-- Attendance Card -->
                <a href="{{ route('teacher.sections.attendance', $section) }}" class="block bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Attendance</h3>
                            <p class="text-sm text-slate-500">Daily attendance records</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Section Info -->
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Section Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-500">Grade Level:</span>
                        <span class="ml-2 font-medium text-slate-800">{{ $section->gradeLevel->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500">School Year:</span>
                        <span class="ml-2 font-medium text-slate-800">{{ $section->schoolYear->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500">Capacity:</span>
                        <span class="ml-2 font-medium text-slate-800">{{ $section->capacity ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500">Status:</span>
                        <span class="ml-2 font-medium {{ $section->is_active ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $section->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
