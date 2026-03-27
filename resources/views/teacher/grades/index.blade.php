<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades - {{ $section->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#8b5cf6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50/50 min-h-screen">

<div class="flex">
    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <div class="ml-72 w-full min-h-screen p-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-4">
                <a href="{{ route('teacher.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('teacher.sections.index') }}" class="hover:text-indigo-600 transition-colors">Sections</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-700 font-medium">{{ $section->name }}</span>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-indigo-600 font-medium">Grades</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                                Grade Management
                            </span>
                            <p class="text-sm font-normal text-slate-500 mt-1">
                                {{ $section->name }} • {{ $section->gradeLevel->name ?? 'N/A' }} • DepEd K-12 System
                            </p>
                        </div>
                    </h1>
                </div>

                <!-- Quarter Selector -->
                <div class="flex items-center gap-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-sm p-2">
                    <span class="text-sm font-medium text-slate-600 px-2">Quarter:</span>
                    <select id="quarterSelect" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="1" {{ request('quarter', 1) == 1 ? 'selected' : '' }}>1st Quarter</option>
                        <option value="2" {{ request('quarter', 1) == 2 ? 'selected' : '' }}>2nd Quarter</option>
                        <option value="3" {{ request('quarter', 1) == 3 ? 'selected' : '' }}>3rd Quarter</option>
                        <option value="4" {{ request('quarter', 1) == 4 ? 'selected' : '' }}>4th Quarter</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-900">Success!</p>
                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-red-900">Error!</p>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Grading System Info Card -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i class="fas fa-info-circle text-indigo-600"></i>
                </div>
                <h3 class="font-semibold text-slate-900">DepEd Grading System</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/60 rounded-xl p-4 border border-white">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-pen text-blue-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-slate-700">Written Work</span>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">40%</p>
                    <p class="text-xs text-slate-500">Quizzes, Assignments, etc.</p>
                </div>
                <div class="bg-white/60 rounded-xl p-4 border border-white">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-tasks text-purple-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-slate-700">Performance Tasks</span>
                    </div>
                    <p class="text-2xl font-bold text-purple-600">40%</p>
                    <p class="text-xs text-slate-500">Projects, Activities, etc.</p>
                </div>
                <div class="bg-white/60 rounded-xl p-4 border border-white">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-file-alt text-amber-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-slate-700">Quarterly Exam</span>
                    </div>
                    <p class="text-2xl font-bold text-amber-600">20%</p>
                    <p class="text-xs text-slate-500">Periodical Tests</p>
                </div>
            </div>
        </div>

        <!-- Grade Level & Subject Selection -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-100 to-pink-50 border border-rose-200 flex items-center justify-center">
                        <i class="fas fa-book text-rose-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Select Subject</h3>
                        <p class="text-sm text-slate-500">Grade Level: <span class="font-medium text-indigo-600">{{ $section->gradeLevel->name ?? 'N/A' }}</span></p>
                    </div>
                </div>
                
                <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3" id="subjectForm">
                    <input type="hidden" name="quarter" id="quarterInput" value="{{ request('quarter', 1) }}">
                    <input type="hidden" name="grade_level" value="{{ $section->grade_level_id }}">
                    
                    <!-- Subject Selector -->
                    <div class="relative">
                        <select name="subject" id="subjectSelect" 
                                class="pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all min-w-[250px]">
                            <option value="">Select Subject</option>
                            @foreach($filteredSubjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-book-open absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>

                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-colors shadow-lg shadow-indigo-500/30 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="loadGradesBtn"
                            {{ !request('subject') ? 'disabled' : '' }}>
                        Load Grades
                    </button>
                </form>
            </div>

            <!-- Quick Stats -->
            @if(isset($selectedGradeLevel))
            <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center gap-3 p-3 bg-indigo-50 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Grade Level</p>
                        <p class="font-semibold text-slate-900">{{ $selectedGradeLevel->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-book text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Available Subjects</p>
                        <p class="font-semibold text-slate-900">{{ $filteredSubjects->count() }} Subjects</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-users text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Students</p>
                        <p class="font-semibold text-slate-900">{{ $students->count() }} Students</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if(isset($selectedSubject))
        <!-- Grade Entry Form -->
        <form method="POST" action="{{ route('teacher.sections.grades.store', $section) }}" class="space-y-6" id="gradeForm">
            @csrf
            <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">
            <input type="hidden" name="grade_level_id" value="{{ $selectedGradeLevel->id }}">
            <input type="hidden" name="quarter" value="{{ request('quarter', 1) }}">

            <!-- Selected Subject Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl shadow-indigo-500/30 p-6 text-white flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-indigo-200 text-sm">Currently Managing</p>
                        <h2 class="text-2xl font-bold">{{ $selectedSubject->name }}</h2>
                        <p class="text-indigo-200 text-sm">{{ $selectedGradeLevel->name }} • {{ $section->name }} • Quarter {{ request('quarter', 1) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-indigo-200 text-sm">Subject Code</p>
                    <p class="text-xl font-bold">{{ $selectedSubject->code ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Component Weight Configuration -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="bg-slate-50/80 border-b border-slate-100 p-4 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-sliders-h text-indigo-600"></i>
                        Component Weights
                    </h3>
                    <button type="button" onclick="resetWeights()" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Reset to Default
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Written Work Weight (%)</label>
                        <input type="number" name="ww_weight" id="wwWeight" value="40" min="0" max="100" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-semibold text-blue-600"
                               onchange="validateWeights()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Performance Task Weight (%)</label>
                        <input type="number" name="pt_weight" id="ptWeight" value="40" min="0" max="100" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 font-semibold text-purple-600"
                               onchange="validateWeights()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Quarterly Exam Weight (%)</label>
                        <input type="number" name="qe_weight" id="qeWeight" value="20" min="0" max="100" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-semibold text-amber-600"
                               onchange="validateWeights()">
                    </div>
                </div>
                <div id="weightWarning" class="hidden px-6 pb-4 text-red-600 text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Total weight must equal 100%
                </div>
            </div>

            <!-- Written Work Section -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-pen text-blue-600"></i>
                            Written Work (WW)
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-600">Total Items:</span>
                            <input type="number" id="wwTotal" value="100" class="w-20 px-3 py-1 rounded-lg border border-blue-200 text-sm font-semibold text-blue-600" onchange="calculateAllWW()">
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
                        <button type="button" onclick="addWWColumn()" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i> Add Activity
                        </button>
                        <button type="button" onclick="removeLastWW()" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-minus"></i> Remove Last
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="wwTable">
                            <thead>
                                <tr class="bg-slate-50" id="wwHeaderRow">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 w-16">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Student Name</th>
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 ww-col-header" data-col="1">WW 1<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title"></th>
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 ww-col-header" data-col="2">WW 2<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title"></th>
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 ww-col-header" data-col="3">WW 3<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title"></th>
                                    <th class="px-4 py-3 text-center font-semibold text-blue-700 bg-blue-50">Total Score</th>
                                    <th class="px-4 py-3 text-center font-semibold text-blue-700 bg-blue-50">PS</th>
                                    <th class="px-4 py-3 text-center font-semibold text-blue-700 bg-blue-50">WS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="wwTableBody">
                                @foreach($students as $index => $student)
                                <tr class="hover:bg-slate-50/50 transition-colors" data-student-id="{{ $student->id }}">
                                    <td class="px-4 py-3 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xs">
                                                {{ strtoupper(substr($student->user->first_name, 0, 1)) }}{{ strtoupper(substr($student->user->last_name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-slate-900">{{ $student->user->last_name }}, {{ $student->user->first_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 text-center ww-col" data-col="1">
                                        <input type="number" name="ww[{{ $student->id }}][]" class="ww-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" min="0" onchange="calculateStudentWW({{ $student->id }})">
                                    </td>
                                    <td class="px-2 py-3 text-center ww-col" data-col="2">
                                        <input type="number" name="ww[{{ $student->id }}][]" class="ww-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" min="0" onchange="calculateStudentWW({{ $student->id }})">
                                    </td>
                                    <td class="px-2 py-3 text-center ww-col" data-col="3">
                                        <input type="number" name="ww[{{ $student->id }}][]" class="ww-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" min="0" onchange="calculateStudentWW({{ $student->id }})">
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold text-slate-700">
                                        <span class="ww-total" id="ww-total-{{ $student->id }}">0</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="ww-ps px-2 py-1 rounded bg-blue-50 text-blue-700 font-semibold" id="ww-ps-{{ $student->id }}">0.00</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="ww-ws px-2 py-1 rounded bg-blue-100 text-blue-800 font-bold" id="ww-ws-{{ $student->id }}">0.00</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Performance Tasks Section -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100 p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-tasks text-purple-600"></i>
                            Performance Tasks (PT)
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-600">Total Items:</span>
                            <input type="number" id="ptTotal" value="100" class="w-20 px-3 py-1 rounded-lg border border-purple-200 text-sm font-semibold text-purple-600" onchange="calculateAllPT()">
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
                        <button type="button" onclick="addPTColumn()" class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i> Add Task
                        </button>
                        <button type="button" onclick="removeLastPT()" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-minus"></i> Remove Last
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="ptTable">
                            <thead>
                                <tr class="bg-slate-50" id="ptHeaderRow">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 w-16">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Student Name</th>
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 pt-col-header" data-col="1">PT 1<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title"></th>
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 pt-col-header" data-col="2">PT 2<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title"></th>
                                    <th class="px-4 py-3 text-center font-semibold text-purple-700 bg-purple-50">Total Score</th>
                                    <th class="px-4 py-3 text-center font-semibold text-purple-700 bg-purple-50">PS</th>
                                    <th class="px-4 py-3 text-center font-semibold text-purple-700 bg-purple-50">WS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="ptTableBody">
                                @foreach($students as $index => $student)
                                <tr class="hover:bg-slate-50/50 transition-colors" data-student-id="{{ $student->id }}">
                                    <td class="px-4 py-3 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-xs">
                                                {{ strtoupper(substr($student->user->first_name, 0, 1)) }}{{ strtoupper(substr($student->user->last_name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-slate-900">{{ $student->user->last_name }}, {{ $student->user->first_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 text-center pt-col" data-col="1">
                                        <input type="number" name="pt[{{ $student->id }}][]" class="pt-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" min="0" onchange="calculateStudentPT({{ $student->id }})">
                                    </td>
                                    <td class="px-2 py-3 text-center pt-col" data-col="2">
                                        <input type="number" name="pt[{{ $student->id }}][]" class="pt-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" min="0" onchange="calculateStudentPT({{ $student->id }})">
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold text-slate-700">
                                        <span class="pt-total" id="pt-total-{{ $student->id }}">0</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="pt-ps px-2 py-1 rounded bg-purple-50 text-purple-700 font-semibold" id="pt-ps-{{ $student->id }}">0.00</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="pt-ws px-2 py-1 rounded bg-purple-100 text-purple-800 font-bold" id="pt-ws-{{ $student->id }}">0.00</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quarterly Exam Section -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100 p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-file-alt text-amber-600"></i>
                            Quarterly Exam (QE)
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-600">Total Items:</span>
                            <input type="number" id="qeTotal" value="100" class="w-20 px-3 py-1 rounded-lg border border-amber-200 text-sm font-semibold text-amber-600" onchange="calculateAllQE()">
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="qeTable">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 w-16">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Student Name</th>
                                    <th class="px-4 py-3 text-center font-semibold text-slate-700">Raw Score</th>
                                    <th class="px-4 py-3 text-center font-semibold text-amber-700 bg-amber-50">PS</th>
                                    <th class="px-4 py-3 text-center font-semibold text-amber-700 bg-amber-50">WS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="qeTableBody">
                                @foreach($students as $index => $student)
                                <tr class="hover:bg-slate-50/50 transition-colors" data-student-id="{{ $student->id }}">
                                    <td class="px-4 py-3 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-xs">
                                                {{ strtoupper(substr($student->user->first_name, 0, 1)) }}{{ strtoupper(substr($student->user->last_name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-slate-900">{{ $student->user->last_name }}, {{ $student->user->first_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="number" name="qe[{{ $student->id }}]" class="qe-score w-20 px-3 py-2 text-center rounded-lg border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all font-semibold" min="0" onchange="calculateStudentQE({{ $student->id }})">
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="qe-ps px-2 py-1 rounded bg-amber-50 text-amber-700 font-semibold" id="qe-ps-{{ $student->id }}">0.00</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="qe-ws px-2 py-1 rounded bg-amber-100 text-amber-800 font-bold" id="qe-ws-{{ $student->id }}">0.00</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Final Grade Summary -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl shadow-indigo-500/30 overflow-hidden text-white">
                <div class="p-6 border-b border-white/10">
                    <h3 class="font-semibold text-lg flex items-center gap-2">
                        <i class="fas fa-calculator"></i>
                        Initial Grade & Transmutation
                    </h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm" id="summaryTable">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="px-4 py-3 text-left font-semibold text-white/80">Student</th>
                                <th class="px-4 py-3 text-center font-semibold text-white/80">WW (40%)</th>
                                <th class="px-4 py-3 text-center font-semibold text-white/80">PT (40%)</th>
                                <th class="px-4 py-3 text-center font-semibold text-white/80">QE (20%)</th>
                                <th class="px-4 py-3 text-center font-semibold text-white/80">Initial Grade</th>
                                <th class="px-4 py-3 text-center font-semibold text-white bg-white/10 rounded-t-lg">Transmuted Grade</th>
                                <th class="px-4 py-3 text-center font-semibold text-white/80">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTableBody">
                            @foreach($students as $student)
                            <tr class="border-b border-white/10" data-student-id="{{ $student->id }}">
                                <td class="px-4 py-3 font-medium">{{ $student->user->last_name }}, {{ $student->user->first_name }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="final-ww" id="final-ww-{{ $student->id }}">0.00</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="final-pt" id="final-pt-{{ $student->id }}">0.00</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="final-qe" id="final-qe-{{ $student->id }}">0.00</span>
                                </td>
                                <td class="px-4 py-3 text-center font-semibold">
                                    <span class="initial-grade" id="initial-grade-{{ $student->id }}">0.00</span>
                                </td>
                                <td class="px-4 py-3 text-center bg-white/5">
                                    <span class="transmuted-grade text-xl font-bold" id="transmuted-{{ $student->id }}">0.00</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="remarks px-3 py-1 rounded-full text-xs font-bold" id="remarks-{{ $student->id }}">-</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end gap-4">
                <button type="button" onclick="calculateAllGrades()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-colors flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i> Recalculate All
                </button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transform hover:-translate-y-0.5 transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i> Save All Grades
                </button>
            </div>
        </form>
        @else
        <!-- No Subject Selected State -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                <i class="fas fa-book-open text-indigo-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">Select a Subject</h3>
            <p class="text-slate-500 max-w-md mx-auto">Choose a subject from the dropdown above to start managing student grades for {{ $selectedGradeLevel->name ?? 'this section' }}.</p>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<script>
    // Store existing grades data from PHP
    const existingGrades = @json($existingGrades ?? []);
    
    // DepEd Transmutation Table
    const transmutationTable = [
        {range: [100, 100], grade: 100},
        {range: [98.40, 99.99], grade: 99},
        {range: [96.80, 98.39], grade: 98},
        {range: [95.20, 96.79], grade: 97},
        {range: [93.60, 95.19], grade: 96},
        {range: [92.00, 93.59], grade: 95},
        {range: [90.40, 91.99], grade: 94},
        {range: [88.80, 90.39], grade: 93},
        {range: [87.20, 88.79], grade: 92},
        {range: [85.60, 87.19], grade: 91},
        {range: [84.00, 85.59], grade: 90},
        {range: [82.40, 83.99], grade: 89},
        {range: [80.80, 82.39], grade: 88},
        {range: [79.20, 80.79], grade: 87},
        {range: [77.60, 79.19], grade: 86},
        {range: [76.00, 77.59], grade: 85},
        {range: [74.40, 75.99], grade: 84},
        {range: [72.80, 74.39], grade: 83},
        {range: [71.20, 72.79], grade: 82},
        {range: [69.60, 71.19], grade: 81},
        {range: [68.00, 69.59], grade: 80},
        {range: [66.40, 67.99], grade: 79},
        {range: [64.80, 66.39], grade: 78},
        {range: [63.20, 64.79], grade: 77},
        {range: [61.60, 63.19], grade: 76},
        {range: [60.00, 61.59], grade: 75},
        {range: [56.00, 59.99], grade: 74},
        {range: [52.00, 55.99], grade: 73},
        {range: [48.00, 51.99], grade: 72},
        {range: [44.00, 47.99], grade: 71},
        {range: [40.00, 43.99], grade: 70},
        {range: [36.00, 39.99], grade: 69},
        {range: [32.00, 35.99], grade: 68},
        {range: [28.00, 31.99], grade: 67},
        {range: [24.00, 27.99], grade: 66},
        {range: [20.00, 23.99], grade: 65},
        {range: [16.00, 19.99], grade: 64},
        {range: [12.00, 15.99], grade: 63},
        {range: [8.00, 11.99], grade: 62},
        {range: [4.00, 7.99], grade: 61},
        {range: [0, 3.99], grade: 60}
    ];

    function transmuteGrade(initialGrade) {
        for (let item of transmutationTable) {
            if (initialGrade >= item.range[0] && initialGrade <= item.range[1]) {
                return item.grade;
            }
        }
        return 60;
    }

    function getRemarks(grade) {
        if (grade >= 75) return {text: 'Passed', class: 'bg-emerald-100 text-emerald-700'};
        if (grade >= 70) return {text: 'Almost Passed', class: 'bg-amber-100 text-amber-700'};
        return {text: 'Failed', class: 'bg-red-100 text-red-700'};
    }

    function validateWeights() {
        const ww = parseFloat(document.getElementById('wwWeight').value) || 0;
        const pt = parseFloat(document.getElementById('ptWeight').value) || 0;
        const qe = parseFloat(document.getElementById('qeWeight').value) || 0;
        const total = ww + pt + qe;
        
        const warning = document.getElementById('weightWarning');
        if (Math.round(total) !== 100) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }

    function resetWeights() {
        document.getElementById('wwWeight').value = 40;
        document.getElementById('ptWeight').value = 40;
        document.getElementById('qeWeight').value = 20;
        document.getElementById('weightWarning').classList.add('hidden');
        calculateAllGrades();
    }

    // Written Work Calculations
    function calculateStudentWW(studentId) {
        const row = document.querySelector(`tr[data-student-id="${studentId}"]`);
        if (!row) return;
        
        const inputs = row.querySelectorAll('.ww-score');
        let total = 0;
        let count = 0;
        
        inputs.forEach(input => {
            if (input.value && input.value !== '') {
                total += parseFloat(input.value) || 0;
                count++;
            }
        });
        
        const totalItems = parseFloat(document.getElementById('wwTotal').value) || 100;
        const ps = count > 0 ? (total / (totalItems * count)) * 100 : 0;
        const wwWeight = parseFloat(document.getElementById('wwWeight').value) || 40;
        const ws = (ps * (wwWeight / 100)).toFixed(2);
        
        const totalEl = document.getElementById(`ww-total-${studentId}`);
        const psEl = document.getElementById(`ww-ps-${studentId}`);
        const wsEl = document.getElementById(`ww-ws-${studentId}`);
        
        if (totalEl) totalEl.textContent = total.toFixed(0);
        if (psEl) psEl.textContent = ps.toFixed(2);
        if (wsEl) wsEl.textContent = ws;
        
        calculateFinalGrade(studentId);
    }

    function calculateAllWW() {
        document.querySelectorAll('#wwTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            if (studentId) calculateStudentWW(studentId);
        });
    }

    // Performance Task Calculations
    function calculateStudentPT(studentId) {
        const row = document.querySelector(`#ptTableBody tr[data-student-id="${studentId}"]`);
        if (!row) return;
        
        const inputs = row.querySelectorAll('.pt-score');
        let total = 0;
        let count = 0;
        
        inputs.forEach(input => {
            if (input.value && input.value !== '') {
                total += parseFloat(input.value) || 0;
                count++;
            }
        });
        
        const totalItems = parseFloat(document.getElementById('ptTotal').value) || 100;
        const ps = count > 0 ? (total / (totalItems * count)) * 100 : 0;
        const ptWeight = parseFloat(document.getElementById('ptWeight').value) || 40;
        const ws = (ps * (ptWeight / 100)).toFixed(2);
        
        const totalEl = document.getElementById(`pt-total-${studentId}`);
        const psEl = document.getElementById(`pt-ps-${studentId}`);
        const wsEl = document.getElementById(`pt-ws-${studentId}`);
        
        if (totalEl) totalEl.textContent = total.toFixed(0);
        if (psEl) psEl.textContent = ps.toFixed(2);
        if (wsEl) wsEl.textContent = ws;
        
        calculateFinalGrade(studentId);
    }

    function calculateAllPT() {
        document.querySelectorAll('#ptTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            if (studentId) calculateStudentPT(studentId);
        });
    }

    // Quarterly Exam Calculations
    function calculateStudentQE(studentId) {
        const row = document.querySelector(`#qeTableBody tr[data-student-id="${studentId}"]`);
        if (!row) return;
        
        const input = row.querySelector('.qe-score');
        if (!input) return;
        
        const score = parseFloat(input.value) || 0;
        const totalItems = parseFloat(document.getElementById('qeTotal').value) || 100;
        const ps = (score / totalItems) * 100;
        const qeWeight = parseFloat(document.getElementById('qeWeight').value) || 20;
        const ws = (ps * (qeWeight / 100)).toFixed(2);
        
        const psEl = document.getElementById(`qe-ps-${studentId}`);
        const wsEl = document.getElementById(`qe-ws-${studentId}`);
        
        if (psEl) psEl.textContent = ps.toFixed(2);
        if (wsEl) wsEl.textContent = ws;
        
        calculateFinalGrade(studentId);
    }

    function calculateAllQE() {
        document.querySelectorAll('#qeTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            if (studentId) calculateStudentQE(studentId);
        });
    }

    // Final Grade Calculation
    function calculateFinalGrade(studentId) {
        const wwEl = document.getElementById(`ww-ws-${studentId}`);
        const ptEl = document.getElementById(`pt-ws-${studentId}`);
        const qeEl = document.getElementById(`qe-ws-${studentId}`);
        
        const ww = wwEl ? parseFloat(wwEl.textContent) || 0 : 0;
        const pt = ptEl ? parseFloat(ptEl.textContent) || 0 : 0;
        const qe = qeEl ? parseFloat(qeEl.textContent) || 0 : 0;
        
        const initialGrade = ww + pt + qe;
        const transmuted = transmuteGrade(initialGrade);
        const remarks = getRemarks(transmuted);
        
        const finalWwEl = document.getElementById(`final-ww-${studentId}`);
        const finalPtEl = document.getElementById(`final-pt-${studentId}`);
        const finalQeEl = document.getElementById(`final-qe-${studentId}`);
        const initialEl = document.getElementById(`initial-grade-${studentId}`);
        const transmutedEl = document.getElementById(`transmuted-${studentId}`);
        const remarksEl = document.getElementById(`remarks-${studentId}`);
        
        if (finalWwEl) finalWwEl.textContent = ww.toFixed(2);
        if (finalPtEl) finalPtEl.textContent = pt.toFixed(2);
        if (finalQeEl) finalQeEl.textContent = qe.toFixed(2);
        if (initialEl) initialEl.textContent = initialGrade.toFixed(2);
        
        if (transmutedEl) {
            transmutedEl.textContent = transmuted.toFixed(0);
            transmutedEl.className = 'transmuted-grade text-xl font-bold ';
            if (transmuted >= 90) transmutedEl.classList.add('text-emerald-300');
            else if (transmuted >= 75) transmutedEl.classList.add('text-white');
            else transmutedEl.classList.add('text-red-300');
        }
        
        if (remarksEl) {
            remarksEl.textContent = remarks.text;
            remarksEl.className = `remarks px-3 py-1 rounded-full text-xs font-bold ${remarks.class}`;
        }
    }

    function calculateAllGrades() {
        document.querySelectorAll('#summaryTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            if (studentId) {
                calculateStudentWW(studentId);
                calculateStudentPT(studentId);
                calculateStudentQE(studentId);
            }
        });
    }

    // Dynamic Column Management for Written Work
    let wwColCount = 3;

    function addWWColumn() {
        wwColCount++;
        const headerRow = document.getElementById('wwHeaderRow');
        
        // Add header
        const newTh = document.createElement('th');
        newTh.className = 'px-2 py-3 text-center font-semibold text-slate-700 ww-col-header';
        newTh.setAttribute('data-col', wwColCount);
        newTh.innerHTML = `WW ${wwColCount}<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title">`;
        
        const totalTh = headerRow.querySelector('th:nth-last-child(3)');
        headerRow.insertBefore(newTh, totalTh);
        
        // Add cells to each row
        document.querySelectorAll('#wwTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const newTd = document.createElement('td');
            newTd.className = 'px-2 py-3 text-center ww-col';
            newTd.setAttribute('data-col', wwColCount);
            newTd.innerHTML = `<input type="number" name="ww[${studentId}][]" class="ww-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" min="0" onchange="calculateStudentWW(${studentId})">`;
            
            const totalTd = row.querySelector('td:nth-last-child(3)');
            row.insertBefore(newTd, totalTd);
        });
    }

    function removeLastWW() {
        if (wwColCount <= 1) return;
        
        document.querySelectorAll(`#wwTable .ww-col-header[data-col="${wwColCount}"], #wwTable .ww-col[data-col="${wwColCount}"]`).forEach(el => {
            el.remove();
        });
        wwColCount--;
        calculateAllWW();
    }

    // Dynamic Column Management for Performance Tasks
    let ptColCount = 2;

    function addPTColumn() {
        ptColCount++;
        const headerRow = document.getElementById('ptHeaderRow');
        
        const newTh = document.createElement('th');
        newTh.className = 'px-2 py-3 text-center font-semibold text-slate-700 pt-col-header';
        newTh.setAttribute('data-col', ptColCount);
        newTh.innerHTML = `PT ${ptColCount}<br><input type="text" class="w-16 text-center bg-transparent border-b border-slate-300 text-xs mt-1" placeholder="Title">`;
        
        const totalTh = headerRow.querySelector('th:nth-last-child(3)');
        headerRow.insertBefore(newTh, totalTh);
        
        document.querySelectorAll('#ptTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const newTd = document.createElement('td');
            newTd.className = 'px-2 py-3 text-center pt-col';
            newTd.setAttribute('data-col', ptColCount);
            newTd.innerHTML = `<input type="number" name="pt[${studentId}][]" class="pt-score w-16 px-2 py-2 text-center rounded-lg border border-slate-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" min="0" onchange="calculateStudentPT(${studentId})">`;
            
            const totalTd = row.querySelector('td:nth-last-child(3)');
            row.insertBefore(newTd, totalTd);
        });
    }

    function removeLastPT() {
        if (ptColCount <= 1) return;
        
        document.querySelectorAll(`#ptTable .pt-col-header[data-col="${ptColCount}"], #ptTable .pt-col[data-col="${ptColCount}"]`).forEach(el => {
            el.remove();
        });
        ptColCount--;
        calculateAllPT();
    }

    // Populate existing grades on page load
    function populateExistingGrades() {
        if (!existingGrades || Object.keys(existingGrades).length === 0) return;
        
        // Populate Written Work grades
        document.querySelectorAll('#wwTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const key = `${studentId}_written_work`;
            
            if (existingGrades[key] && existingGrades[key].scores) {
                const scores = existingGrades[key].scores;
                const inputs = row.querySelectorAll('.ww-score');
                
                scores.forEach((score, index) => {
                    if (inputs[index]) {
                        inputs[index].value = score;
                    } else if (index >= inputs.length) {
                        // Add more columns if needed
                        while (inputs.length <= index) {
                            addWWColumn();
                        }
                        const newInputs = row.querySelectorAll('.ww-score');
                        if (newInputs[index]) newInputs[index].value = score;
                    }
                });
            }
        });
        
        // Populate Performance Task grades
        document.querySelectorAll('#ptTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const key = `${studentId}_performance_task`;
            
            if (existingGrades[key] && existingGrades[key].scores) {
                const scores = existingGrades[key].scores;
                const inputs = row.querySelectorAll('.pt-score');
                
                scores.forEach((score, index) => {
                    if (inputs[index]) {
                        inputs[index].value = score;
                    } else if (index >= inputs.length) {
                        while (inputs.length <= index) {
                            addPTColumn();
                        }
                        const newInputs = row.querySelectorAll('.pt-score');
                        if (newInputs[index]) newInputs[index].value = score;
                    }
                });
            }
        });
        
        // Populate Quarterly Exam grades
        document.querySelectorAll('#qeTableBody tr').forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const key = `${studentId}_quarterly_exam`;
            
            if (existingGrades[key]) {
                const input = row.querySelector('.qe-score');
                if (input && existingGrades[key].total_score) {
                    input.value = existingGrades[key].total_score;
                }
            }
        });
        
        // Recalculate all grades after populating
        setTimeout(() => {
            calculateAllGrades();
        }, 100);
    }

    // Quarter selection
    document.getElementById('quarterSelect')?.addEventListener('change', function() {
        document.getElementById('quarterInput').value = this.value;
        // Reload page with new quarter
        const url = new URL(window.location.href);
        url.searchParams.set('quarter', this.value);
        window.location.href = url.toString();
    });

    // Enable/disable load button based on subject selection
    document.getElementById('subjectSelect')?.addEventListener('change', function() {
        const loadGradesBtn = document.getElementById('loadGradesBtn');
        if (loadGradesBtn) {
            loadGradesBtn.disabled = !this.value;
        }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        populateExistingGrades();
        calculateAllGrades();
    });
</script>

</body>
</html>