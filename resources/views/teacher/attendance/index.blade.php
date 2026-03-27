<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - {{ $section->name }}</title>
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
        
        <!-- Breadcrumb & Header Section -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-4">
                <a href="{{ route('teacher.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('teacher.sections.index') }}" class="hover:text-indigo-600 transition-colors">Sections</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-700 font-medium">{{ $section->name }}</span>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-indigo-600 font-medium">Attendance</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <i class="fas fa-clipboard-check text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                                Attendance
                            </span>
                            <p class="text-sm font-normal text-slate-500 mt-1">
                                {{ $section->name }} • {{ $section->gradeLevel->name ?? 'N/A' }}
                            </p>
                        </div>
                    </h1>
                </div>

                <!-- Quick Stats Cards -->
                <div class="flex gap-3">
                    <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fas fa-users text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Students</p>
                                <p class="text-lg font-bold text-slate-900">{{ count($students) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                                <i class="fas fa-calendar-day text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Today</p>
                                <p class="text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($date)->format('M d') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-900">Success!</p>
                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto w-8 h-8 rounded-full hover:bg-emerald-100 flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-emerald-600"></i>
                </button>
            </div>
        @endif

        <!-- Date Selector Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-100 to-orange-50 border border-amber-200 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-amber-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Select Date</h3>
                        <p class="text-sm text-slate-500">Choose the attendance date</p>
                    </div>
                </div>
                
                <form method="GET" class="flex items-center gap-3">
                    <div class="relative">
                        <input type="date" name="date" value="{{ $date }}" 
                               class="pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all hover:border-slate-300"
                               onchange="this.form.submit()">
                        <i class="fas fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    
                    <button type="button" onclick="window.location.href='?date={{ now()->format('Y-m-d') }}'" 
                            class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-colors text-sm">
                        Today
                    </button>
                </form>
            </div>
        </div>

        <!-- Attendance Form -->
        <form method="POST" action="{{ route('teacher.sections.attendance.store', $section) }}" class="space-y-6">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">

            <!-- Bulk Actions Bar -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-4 border border-indigo-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-magic text-indigo-600"></i>
                    <span class="font-medium text-slate-700">Quick Actions:</span>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="setAllStatus('present')" 
                            class="px-4 py-2 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-medium transition-all hover:shadow-md flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Mark All Present
                    </button>
                    <button type="button" onclick="setAllStatus('absent')" 
                            class="px-4 py-2 bg-white hover:bg-red-50 text-red-700 border border-red-200 rounded-xl text-sm font-medium transition-all hover:shadow-md flex items-center gap-2">
                        <i class="fas fa-times-circle"></i> Mark All Absent
                    </button>
                </div>
            </div>

            <!-- Students Table -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">#</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Student Information</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Learner's Reference Number</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-48">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-32">Quick Set</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="attendanceTable">
                            @foreach($students as $index => $student)
                            @php
                                $currentStatus = $attendance[$student->id]->status ?? 'present';
                                $statusColors = [
                                    'present' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'absent' => 'bg-red-50 text-red-700 border-red-200',
                                    'late' => 'bg-amber-50 text-amber-700 border-amber-200'
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group" data-student-id="{{ $student->id }}">
                                <td class="px-6 py-4 text-sm text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-indigo-500/20">
                                            {{ strtoupper(substr($student->user->first_name, 0, 1)) }}{{ strtoupper(substr($student->user->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900 text-base">
                                                {{ $student->user->last_name }}, {{ $student->user->first_name }} {{ $student->user->middle_name ? substr($student->user->middle_name, 0, 1) . '.' : '' }}
                                            </p>
                                            <p class="text-sm text-slate-500">
                                                {{ $student->user->gender ?? 'Student' }} • Grade {{ $section->gradeLevel->name ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-sm font-mono">
                                        {{ $student->lrn ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <select name="attendance[{{ $student->id }}]" 
                                                class="attendance-select w-full appearance-none pl-10 pr-10 py-3 rounded-xl border-2 font-medium transition-all duration-200 focus:outline-none focus:ring-4 cursor-pointer {{ $statusColors[$currentStatus] }}"
                                                data-student="{{ $student->id }}"
                                                onchange="updateSelectStyle(this)">
                                            <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }} class="bg-white text-emerald-700">Present</option>
                                            <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }} class="bg-white text-red-700">Absent</option>
                                            <option value="late" {{ $currentStatus == 'late' ? 'selected' : '' }} class="bg-white text-amber-700">Late</option>
                                        </select>
                                        <i class="fas fa-user-check absolute left-3.5 top-1/2 -translate-y-1/2 status-icon"></i>
                                        <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <button type="button" onclick="quickSet({{ $student->id }}, 'present')" 
                                                class="w-10 h-10 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-600 transition-colors flex items-center justify-center tooltip" title="Present">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" onclick="quickSet({{ $student->id }}, 'absent')" 
                                                class="w-10 h-10 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition-colors flex items-center justify-center tooltip" title="Absent">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="button" onclick="quickSet({{ $student->id }}, 'late')" 
                                                class="w-10 h-10 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 transition-colors flex items-center justify-center tooltip" title="Late">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(count($students) == 0)
                <div class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                        <i class="fas fa-users-slash text-slate-300 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">No Students Found</h3>
                    <p class="text-slate-500">This section doesn't have any enrolled students yet.</p>
                </div>
                @endif

                <!-- Footer Actions -->
                <div class="bg-slate-50/80 border-t border-slate-100 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        Changes will be saved for <strong>{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</strong>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('teacher.sections.show', $section) }}" 
                           class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Attendance
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Attendance Summary Preview -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-user-check text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-emerald-700" id="countPresent">0</p>
                    <p class="text-sm text-emerald-600 font-medium">Present</p>
                </div>
            </div>
            
            <div class="bg-red-50/50 border border-red-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <i class="fas fa-user-times text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-700" id="countAbsent">0</p>
                    <p class="text-sm text-red-600 font-medium">Absent</p>
                </div>
            </div>
            
            <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-user-clock text-amber-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-700" id="countLate">0</p>
                    <p class="text-sm text-amber-600 font-medium">Late</p>
                </div>
            </div>
        </div>
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
    
    .tooltip {
        position: relative;
    }
    .tooltip:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #1e293b;
        color: white;
        font-size: 12px;
        border-radius: 6px;
        white-space: nowrap;
        margin-bottom: 6px;
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
</style>

<script>
    // Update select styling based on value
    function updateSelectStyle(select) {
        const value = select.value;
        const icon = select.parentElement.querySelector('.status-icon');
        
        // Remove all possible classes
        select.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
        select.classList.remove('bg-red-50', 'text-red-700', 'border-red-200');
        select.classList.remove('bg-amber-50', 'text-amber-700', 'border-amber-200');
        icon.classList.remove('text-emerald-600', 'text-red-600', 'text-amber-600');
        
        // Add appropriate classes
        if (value === 'present') {
            select.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
            icon.classList.add('text-emerald-600');
            icon.className = 'fas fa-check-circle absolute left-3.5 top-1/2 -translate-y-1/2 status-icon text-emerald-600';
        } else if (value === 'absent') {
            select.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            icon.className = 'fas fa-times-circle absolute left-3.5 top-1/2 -translate-y-1/2 status-icon text-red-600';
        } else if (value === 'late') {
            select.classList.add('bg-amber-50', 'text-amber-700', 'border-amber-200');
            icon.className = 'fas fa-clock absolute left-3.5 top-1/2 -translate-y-1/2 status-icon text-amber-600';
        }
        
        updateCounts();
    }

    // Quick set individual student
    function quickSet(studentId, status) {
        const select = document.querySelector(`select[name="attendance[${studentId}]"]`);
        if (select) {
            select.value = status;
            updateSelectStyle(select);
            
            // Add a brief highlight effect to the row
            const row = select.closest('tr');
            row.style.backgroundColor = status === 'present' ? '#ecfdf5' : status === 'absent' ? '#fef2f2' : '#fffbeb';
            setTimeout(() => {
                row.style.backgroundColor = '';
                row.style.transition = 'background-color 0.5s ease';
            }, 300);
        }
    }

    // Set all students to a specific status
    function setAllStatus(status) {
        const selects = document.querySelectorAll('.attendance-select');
        selects.forEach((select, index) => {
            setTimeout(() => {
                select.value = status;
                updateSelectStyle(select);
            }, index * 20); // Staggered animation
        });
    }

    // Update summary counts
    function updateCounts() {
        const selects = document.querySelectorAll('.attendance-select');
        let present = 0, absent = 0, late = 0;
        
        selects.forEach(select => {
            if (select.value === 'present') present++;
            else if (select.value === 'absent') absent++;
            else if (select.value === 'late') late++;
        });
        
        // Animate the numbers
        animateValue('countPresent', parseInt(document.getElementById('countPresent').textContent), present, 300);
        animateValue('countAbsent', parseInt(document.getElementById('countAbsent').textContent), absent, 300);
        animateValue('countLate', parseInt(document.getElementById('countLate').textContent), late, 300);
    }

    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        const range = end - start;
        const minTimer = 50;
        let stepTime = Math.abs(Math.floor(duration / range));
        stepTime = Math.max(stepTime, minTimer);
        
        let startTime = new Date().getTime();
        let endTime = startTime + duration;
        let timer;
        
        function run() {
            let now = new Date().getTime();
            let remaining = Math.max((endTime - now) / duration, 0);
            let value = Math.round(end - (remaining * range));
            obj.textContent = value;
            if (value == end) {
                clearInterval(timer);
            }
        }
        
        timer = setInterval(run, stepTime);
        run();
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.attendance-select').forEach(select => {
            updateSelectStyle(select);
        });
        updateCounts();
    });
</script>

</body>
</html>