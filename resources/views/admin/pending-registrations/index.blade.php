<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pending Registrations - Tugawe ES Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background: #f8fafc; overflow: hidden; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        }
        
        .table-row { transition: all 0.2s ease; }
        .table-row:hover { background: #f8fafc; }
        
        .btn-enroll {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
        }
        .btn-enroll:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
        }
        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        
        .avatar-circle {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }
    </style>
</head>
<body class="h-screen flex">

    <!-- Sidebar -->
    @include('admin.includes.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen ml-72">
        
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Pending Registrations</h1>
                    <p class="text-sm text-slate-500">Review and enroll new student applications</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="searchInput" placeholder="Search students..." 
                           class="pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 w-64 transition-all">
                </div>
            </div>
        </header>

        <!-- Toast Container -->
        <div id="toast-container" class="fixed top-4 right-4 flex flex-col gap-2 z-50"></div>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const createToast = (message, type = 'success', duration = 4) => {
                const colors = {
                    success: { bg: 'bg-emerald-50', border: 'border-emerald-500', text: 'text-emerald-800', iconBg: 'bg-emerald-500' },
                    error: { bg: 'bg-red-50', border: 'border-red-500', text: 'text-red-800', iconBg: 'bg-red-500' }
                };

                const toast = document.createElement('div');
                toast.className = `flex items-center gap-3 px-4 py-2 rounded-xl shadow-lg border-l-4 ${colors[type].bg} ${colors[type].border} ${colors[type].text} relative overflow-hidden min-w-[240px] transform translate-x-20 opacity-0 transition-all duration-500 ease-out`;

                toast.innerHTML = `
                    <div class="flex-shrink-0 w-6 h-6 rounded-full ${colors[type].iconBg} text-white flex items-center justify-center text-xs">
                        <i class="fas fa-${type==='success'?'check':'exclamation-triangle'}"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">${message}</div>
                    <button class="text-current hover:opacity-70 transition-opacity text-sm ml-2">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="absolute bottom-0 left-0 h-1 ${colors[type].iconBg} rounded-b-xl" style="width:100%"></div>
                `;

                const container = document.getElementById('toast-container');
                container.appendChild(toast);

                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-20', 'opacity-0');
                });

                toast.querySelector('button').addEventListener('click', () => toast.remove());

                let timeLeft = duration;
                const progressBar = toast.querySelector('div.absolute');
                const interval = setInterval(() => {
                    timeLeft -= 0.05;
                    if (timeLeft <= 0) {
                        clearInterval(interval);
                        toast.remove();
                        return;
                    }
                    progressBar.style.width = (timeLeft / duration * 100) + '%';
                }, 50);
            };

            @if(session('success'))
                createToast("{{ session('success') }}", 'success', 4);
            @endif

            @if(session('error'))
                createToast("{{ session('error') }}", 'error', 4);
            @endif
        });
        </script>

        <!-- Content -->
        <main class="flex-1 overflow-auto p-8 custom-scroll">

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">{{ $students->total() }}</p>
                        <p class="text-sm text-slate-500 font-medium">Pending Enrollment</p>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">{{ $sidebarStudentCount ?? 0 }}</p>
                        <p class="text-sm text-slate-500 font-medium">Total Students</p>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">{{ $enrolledTodayCount ?? 0 }}</p>
                        <p class="text-sm text-slate-500 font-medium">Enrolled Today</p>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">Registration Requests</h2>
                    <span class="text-sm text-slate-500">Showing <span class="font-semibold text-slate-900">{{ $students->count() }}</span> of <span class="font-semibold text-slate-900">{{ $students->total() }}</span></span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Grade Level</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Applied</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $student)
                                <tr class="table-row animate-fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full avatar-circle flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ strtoupper(substr($student->user->first_name ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900">
                                                    {{ $student->user->last_name ?? 'N/A' }}, {{ $student->user->first_name ?? 'N/A' }} {{ $student->user->middle_name ? substr($student->user->middle_name, 0, 1) . '.' : '' }}
                                                </p>
                                                <p class="text-sm text-slate-500">{{ $student->user->email ?? 'No email' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold">
                                            <i class="fas fa-graduation-cap text-xs"></i>
                                            {{ $student->gradeLevel->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($student->enrollment)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-sm font-semibold">
                                                {{ $student->enrollment->type }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600">
                                            {{ $student->created_at?->diffForHumans() ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-1.5 w-fit bg-amber-100 text-amber-700">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" 
                                                    onclick="openStudentModal({{ $student->id }})"
                                                    class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-600 flex items-center justify-center transition-all"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="max-w-md mx-auto">
                                            <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-inbox text-3xl text-slate-400"></i>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900 mb-2">No Pending Registrations</h3>
                                            <p class="text-slate-500">All student registrations have been processed.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Student Details Slide-in Modal -->
    <div id="studentModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div id="modalBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" onclick="closeStudentModal()"></div>
        
        <!-- Slide-in Panel -->
        <div id="modalPanel" class="absolute right-0 top-0 h-full w-full max-w-2xl bg-white shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col">
            
            <!-- Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Student Details</h3>
                        <p class="text-sm text-slate-500">ID: <span id="modalStudentId">-</span></p>
                    </div>
                </div>
                <button onclick="closeStudentModal()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:border-slate-300 transition-all hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto custom-scroll p-6" id="modalBody">
                
                <!-- Loading State -->
                <div id="modalLoading" class="flex flex-col items-center justify-center h-64">
                    <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin mb-4"></div>
                    <p class="text-slate-500 font-medium">Loading student data...</p>
                </div>

                <!-- Error State -->
                <div id="modalError" class="hidden text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Failed to Load</h3>
                    <p id="modalErrorMessage" class="text-red-600 text-sm mb-4 font-mono"></p>
                    <button onclick="closeStudentModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-slate-700 transition-colors">
                        Close
                    </button>
                </div>

                <!-- Content -->
                <div id="modalContent" class="hidden space-y-6">
                    
                    <!-- Student Header Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-start gap-4">
                            <div id="modalPhoto" class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shrink-0">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 id="modalName" class="text-2xl font-bold text-slate-900 mb-1 truncate">-</h4>
                                <p id="modalEmail" class="text-slate-500 mb-3 truncate">-</p>
                                <div class="flex flex-wrap gap-2">
                                    <span id="modalGrade" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-sm font-semibold">-</span>
                                    <span class="px-3 py-1 rounded-lg bg-amber-100 text-amber-700 text-sm font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        Pending Enrollment
                                    </span>
                                    <span id="modalAge" class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-sm font-semibold">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Full Name</p>
                            <p id="modalFullName" class="font-semibold text-slate-900 truncate">-</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Birthdate</p>
                            <p id="modalBirthdate" class="font-semibold text-slate-900">-</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Gender</p>
                            <p id="modalGender" class="font-semibold text-slate-900 capitalize">-</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Nationality</p>
                            <p id="modalNationality" class="font-semibold text-slate-900">-</p>
                        </div>

                        <!-- ✅ ADD THESE NEW FIELDS -->
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Ethnicity</p>
        <p id="modalEthnicity" class="font-semibold text-slate-900">-</p>
    </div>
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Mother Tongue</p>
        <p id="modalMotherTongue" class="font-semibold text-slate-900">-</p>
    </div>
</div>

<!-- ✅ DISPLAY REMARKS BADGE (if exists) -->
<div id="modalRemarksContainer" class="mt-4 hidden">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200">
        <i class="fas fa-sticky-note text-amber-600"></i>
        <span class="text-xs text-amber-700 font-semibold uppercase tracking-wide">Remark:</span>
        <span id="modalRemarksBadge" class="text-sm font-bold text-amber-800">-</span>
    </div>

                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-3">
                        <h5 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Contact Information</h5>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-slate-400 mt-1 w-5"></i>
                                <div class="flex-1">
                                    <p class="text-xs text-slate-500 mb-1">Address</p>
                                    <p id="modalAddress" class="font-semibold text-slate-900">-</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone text-slate-400 w-5"></i>
                                <div class="flex-1">
                                    <p class="text-xs text-slate-500 mb-1">Guardian Contact</p>
                                    <p id="modalGuardianContact" class="font-semibold text-slate-900">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Info -->
                    <div class="space-y-3">
                        <h5 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Family Information</h5>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                                <p class="text-xs text-blue-600 mb-1 font-semibold uppercase">Father</p>
                                <p id="modalFather" class="font-semibold text-slate-900">-</p>
                                <p id="modalFatherOccupation" class="text-sm text-slate-500"></p>
                            </div>
                            <div class="p-4 bg-pink-50/50 rounded-xl border border-pink-100">
                                <p class="text-xs text-pink-600 mb-1 font-semibold uppercase">Mother</p>
                                <p id="modalMother" class="font-semibold text-slate-900">-</p>
                                <p id="modalMotherOccupation" class="text-sm text-slate-500"></p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-1 font-semibold uppercase">Guardian</p>
                                <p id="modalGuardian" class="font-semibold text-slate-900">-</p>
                                <p id="modalGuardianRelationship" class="text-sm text-slate-500"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Info -->
                    <div class="space-y-3">
                        <h5 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Academic Details</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Grade Level</p>
                                <p id="modalGradeLevel" class="font-semibold text-slate-900">-</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Student Type</p>
                                <p id="modalStudentType" class="font-semibold text-slate-900 capitalize"></p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">LRN</p>
                                <p id="modalLRN" class="font-semibold text-slate-900 font-mono">-</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs text-slate-500 mb-1 uppercase tracking-wide font-medium">Date Applied</p>
                                <p id="modalDateApplied" class="font-semibold text-slate-900">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex flex-col gap-4">
                
              <!-- Section Selection -->
<div>
    <label class="block text-sm font-semibold text-slate-700 mb-2">
        <i class="fas fa-chalkboard-teacher mr-1"></i> Assign to Section <span class="text-red-500">*</span>
    </label>
    <select name="section_id" form="modalApproveForm" required
            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm">
        <option value="">Select a section...</option>
        @foreach($sections as $section)
            <option value="{{ $section->id }}">
                {{ $section->name }} 
                (Grade Level: {{ $section->gradeLevel->name ?? 'N/A' }}) — 
                {{ $section->students_count }}/{{ $section->capacity }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-slate-500 mt-1">Student will be enrolled and assigned to this section</p>
</div>


    <!-- ✅ REMARKS SELECTION (NEW) -->
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            <i class="fas fa-sticky-note mr-1"></i> Remarks <span class="text-slate-400 font-normal">(Optional)</span>
        </label>
        <select name="remarks" form="modalApproveForm"
                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm">
            <option value="">-- Select Remark --</option>
            @foreach(\App\Models\Student::$remarksLegend as $code => $label)
                <option value="{{ $code }}">
                    {{ $code }} - {{ $label }}
                </option>
            @endforeach
        </select>
        <p class="text-xs text-slate-500 mt-1">Select a remark code for this student's enrollment record</p>
    </div>

                <!-- Buttons Row -->
                <div class="flex items-center gap-3">
                    <form id="modalApproveForm" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full btn-enroll py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2 transition-all">
                            <i class="fas fa-check"></i>
                            Enroll & Assign Section
                        </button>
                    </form>
                    <form id="modalRejectForm" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject px-6 py-3 rounded-xl text-white font-semibold flex items-center gap-2 transition-all" onclick="return confirm('Reject this application?')">
                            <i class="fas fa-times"></i>
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.table-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Modal functions
        async function openStudentModal(studentId) {
            console.log('Opening modal for student:', studentId);
            
            const modal = document.getElementById('studentModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const loading = document.getElementById('modalLoading');
            const error = document.getElementById('modalError');
            const content = document.getElementById('modalContent');
            
            // Reset section dropdown
            const sectionSelect = document.querySelector('select[name="section_id"]');
            if (sectionSelect) sectionSelect.value = '';
            
            // Show modal
            modal.classList.remove('hidden');
            document.getElementById('modalStudentId').textContent = studentId;
            
            // Animate in
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            }, 10);
            
            // Reset states
            loading.classList.remove('hidden');
            error.classList.add('hidden');
            content.classList.add('hidden');
            
            try {
                const url = `{{ url('/admin/pending-registrations') }}/${studentId}/details`;
                console.log('Fetching:', url);
                
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                
                console.log('Response status:', response.status);
                
                const responseText = await response.text();
                console.log('Raw response:', responseText.substring(0, 500));
                
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    throw new Error('Invalid server response. Check console for details.');
                }
                
                if (!response.ok) {
                    throw new Error(data.error || `HTTP ${response.status}: ${response.statusText}`);
                }
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                populateStudentModal(data, studentId);
                
                loading.classList.add('hidden');
                content.classList.remove('hidden');
                
            } catch (err) {
                console.error('Modal error:', err);
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                document.getElementById('modalErrorMessage').textContent = err.message;
            }
        }

        function populateStudentModal(data, studentId) {
            const s = data.student;
            const u = s.user || {};
            
            const photoEl = document.getElementById('modalPhoto');
            if (data.photo_url) {
                photoEl.innerHTML = `<img src="${data.photo_url}" class="w-full h-full object-cover rounded-2xl">`;
            } else {
                const initials = ((u.first_name?.[0] || '') + (u.last_name?.[0] || '')).toUpperCase();
                photoEl.textContent = initials || '?';
            }
            

                // ✅ SHOW REMARKS IF EXISTS
    const remarksContainer = document.getElementById('modalRemarksContainer');
    const remarksBadge = document.getElementById('modalRemarksBadge');
    
    if (s.remarks && s.remarks !== 'No remarks') {
        const legend = {
            'TI': 'Transferred In',
            'TO': 'Transferred Out',
            'DO': 'Dropped Out',
            'LE': 'Late Enrollee',
            'CCT': 'CCT Recipient',
            'BA': 'Balik Aral',
            'LWD': 'Learner With Disability'
        };
        remarksBadge.textContent = `${s.remarks} - ${legend[s.remarks] || ''}`;
        remarksContainer.classList.remove('hidden');
    } else {
        remarksContainer.classList.add('hidden');
    }
    
            document.getElementById('modalName').textContent = data.full_name || '-';
            document.getElementById('modalEmail').textContent = u.email || '-';
            document.getElementById('modalGrade').textContent = s.grade_level?.name || '-';
            document.getElementById('modalAge').textContent = data.age ? `${data.age} years old` : '-';
            document.getElementById('modalFullName').textContent = data.full_name || '-';
            
            document.getElementById('modalBirthdate').textContent = s.birthdate 
                ? new Date(s.birthdate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                : '-';
            
            document.getElementById('modalGender').textContent = s.gender || '-';
            document.getElementById('modalNationality').textContent = s.nationality || '-';

              // ✅ ADD THESE NEW LINES
    document.getElementById('modalEthnicity').textContent = s.ethnicity || '-';
    document.getElementById('modalMotherTongue').textContent = s.mother_tongue || '-';
  
            
            const addressParts = [s.street_address, s.barangay, s.city, s.province].filter(Boolean);
            document.getElementById('modalAddress').textContent = addressParts.join(', ') || '-';
            document.getElementById('modalGuardianContact').textContent = s.guardian_contact || '-';
            
            document.getElementById('modalFather').textContent = s.father_name || '-';
            document.getElementById('modalFatherOccupation').textContent = s.father_occupation || '';
            document.getElementById('modalMother').textContent = s.mother_name || '-';
            document.getElementById('modalMotherOccupation').textContent = s.mother_occupation || '';
            document.getElementById('modalGuardian').textContent = s.guardian_name || '-';
            document.getElementById('modalGuardianRelationship').textContent = s.guardian_relationship || '';
            
            document.getElementById('modalGradeLevel').textContent = s.grade_level?.name || '-';
            document.getElementById('modalStudentType').textContent = s.type || ' ';
            document.getElementById('modalLRN').textContent = s.lrn || '-';
            document.getElementById('modalDateApplied').textContent = s.created_at 
                ? new Date(s.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                : '-';
            
            const baseUrl = '{{ url("/admin/pending-registrations") }}';
            document.getElementById('modalApproveForm').action = `${baseUrl}/${studentId}/approve`;
            document.getElementById('modalRejectForm').action = `${baseUrl}/${studentId}/reject`;
        }

        function closeStudentModal() {
            const modal = document.getElementById('studentModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            
            backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeStudentModal();
        });
    </script>
</body>
</html>