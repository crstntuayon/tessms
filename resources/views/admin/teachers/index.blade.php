{{-- resources/views/admin/teachers/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers | Tugawe Elementary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        .dashboard-layout {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .sidebar-container {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
            flex-shrink: 0;
        }

        .main-wrapper {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            background: #f8fafc;
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
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-container.open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
        }

        .modern-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .modern-table th {
            background: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
            color: #64748b;
            padding: 16px 24px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .modern-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .modern-table tr {
            transition: all 0.2s ease;
        }
        
        .modern-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .status-inactive {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .status-on-leave {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            opacity: 0;
        }
        
        .modern-table tbody tr:hover .action-btn {
            opacity: 1;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }

        .custom-checkbox {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #cbd5e1;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        
        .custom-checkbox:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }
        
        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .animate-fade-in-up { 
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
        }

        .glass-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .search-input {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }
        
        .search-input:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .mobile-overlay {
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(4px);
        }

        .stat-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f1f5f9;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
        }

        .stat-pill i {
            color: #8b5cf6;
        }

        .subject-tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            background: #f3e8ff;
            color: #7c3aed;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        /* Floating Icon-Only Button */
.fab-icon-only {
    position: fixed;
    bottom: 32px;
    right: 32px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #9333ea 0%, #4f46e5 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 10px 40px -10px rgba(147, 51, 234, 0.5);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 45;
    text-decoration: none;
}

.fab-icon-only:hover {
    transform: scale(1.1) rotate(90deg);
    box-shadow: 0 20px 50px -10px rgba(147, 51, 234, 0.6);
}

/* Mobile */
@media (max-width: 1024px) {
    .fab-icon-only {
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
    }
}
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay fixed inset-0 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="dashboard-layout">
        <!-- Fixed Sidebar -->
        <div class="sidebar-container">
            @include('admin.includes.sidebar')
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Fixed Header -->
            <header class="main-header">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2.5 hover:bg-slate-100 rounded-xl transition-colors">
                            <i class="fas fa-bars text-slate-600"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Teachers Management</h2>
                            <p class="text-sm text-slate-500 font-medium flex items-center gap-2 mt-0.5">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                Manage faculty and teaching staff
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex items-center gap-3">
                            <div class="stat-pill">
                                <i class="fas fa-chalkboard-teacher text-sm"></i>
                                <span>{{ $teachers->count() }} Total</span>
                            </div>
                            <div class="stat-pill">
                                <i class="fas fa-user-check text-sm"></i>
                                <span>{{ $teachers->where('status', 'active')->count() }} Active</span>
                            </div>
                        </div>

                        <div class="search-input hidden md:flex">
                            <i class="fas fa-search text-slate-400"></i>
                            <input type="text" id="searchInput" placeholder="Search teachers..." class="bg-transparent border-none outline-none text-sm w-48 placeholder:text-slate-400">
                        </div>

                    
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="main-content">
                
                @php
                    use App\Models\Teacher;
                    $teachers = Teacher::with(['subjects', 'sections'])->latest()->get();
                @endphp

                <!-- Filters -->
                <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-fade-in-up">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 shadow-sm">
                            <i class="fas fa-filter text-slate-400"></i>
                            <select class="bg-transparent border-none outline-none text-sm text-slate-700 cursor-pointer font-medium" onchange="filterByStatus(this.value)">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="on_leave">On Leave</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 shadow-sm">
                            <i class="fas fa-book text-slate-400"></i>
                            <select class="bg-transparent border-none outline-none text-sm text-slate-700 cursor-pointer font-medium">
                                <option value="">All Subjects</option>
                                @php
                                    $allSubjects = $teachers->flatMap->subjects->pluck('name')->unique()->filter()->sort()->values();
                                @endphp
                                @foreach($allSubjects as $subject)
                                    <option value="{{ $subject }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button onclick="exportData()" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 rounded-xl transition-all flex items-center gap-2 bg-white shadow-sm">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Teachers Table -->
                <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                                <i class="fas fa-chalkboard-teacher text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Faculty List</h3>
                                <p class="text-sm text-slate-500">Showing all {{ $teachers->count() }} teaching staff</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">Sort by:</span>
                            <select class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-700 outline-none focus:border-purple-500" onchange="sortTable(this.value)">
                                <option value="newest">Newest First</option>
                                <option value="name">Name (A-Z)</option>
                                <option value="subject">Subject</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="modern-table" id="teachersTable">
                            <thead>
                                <tr>
                                    <th class="w-12">
                                        <input type="checkbox" class="custom-checkbox" id="selectAll" onclick="toggleSelectAll()">
                                    </th>
                                    <th>Teacher Information</th>
                                    <th>Subjects</th>
                                    <th>Sections</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Hired Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                <tr class="teacher-row" data-status="{{ $teacher->status }}" data-name="{{ strtolower($teacher->full_name) }}">
                                    <td>
                                        <input type="checkbox" class="custom-checkbox teacher-checkbox" value="{{ $teacher->id }}">
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                           <img src="{{ $teacher->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($teacher->full_name) . '&background=random&color=fff&size=128' }}"
                                                 alt="{{ $teacher->full_name }}" 
                                                 class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover">
                                            <div>
                                                <p class="font-bold text-slate-900 text-sm">{{ $teacher->full_name }}</p>
                                                <p class="text-xs text-slate-500">ID: {{ $teacher->id }} • {{ $teacher->employee_id ?? 'No ID' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap max-w-xs">
                                            @forelse($teacher->subjects->take(3) as $subject)
                                                <span class="subject-tag">{{ $subject->name }}</span>
                                            @empty
                                                <span class="text-xs text-slate-400 italic">No subjects assigned</span>
                                            @endforelse
                                            @if($teacher->subjects->count() > 3)
                                                <span class="subject-tag bg-slate-100 text-slate-600">+{{ $teacher->subjects->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                            @forelse($teacher->sections->take(2) as $section)
                                                <span class="text-xs text-slate-600 font-medium flex items-center gap-1">
                                                    <i class="fas fa-door-open text-slate-400"></i>
                                                    {{ $section->name }} ({{ $section->grade_level }})
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-400 italic">No sections assigned</span>
                                            @endforelse
                                            @if($teacher->sections->count() > 2)
                                                <span class="text-xs text-slate-500">+{{ $teacher->sections->count() - 2 }} more</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm text-slate-700 font-medium flex items-center gap-2">
                                                <i class="fas fa-envelope text-slate-400 text-xs"></i>
                                                {{ $teacher->email ?? 'No email' }}
                                            </span>
                                            @if($teacher->phone)
                                            <span class="text-xs text-slate-500 flex items-center gap-2">
                                                <i class="fas fa-phone text-slate-400"></i>
                                                {{ $teacher->phone }}
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $status = $teacher->status ?? 'active';
                                            $statusClass = match($status) {
                                                'active' => 'status-active',
                                                'on_leave' => 'status-on-leave',
                                                default => 'status-inactive'
                                            };
                                            $statusIcon = match($status) {
                                                'active' => 'fa-check-circle',
                                                'on_leave' => 'fa-clock',
                                                default => 'fa-ban'
                                            };
                                            $statusLabel = match($status) {
                                                'on_leave' => 'On Leave',
                                                default => ucfirst($status)
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }} capitalize">
                                            <i class="fas {{ $statusIcon }} mr-1.5 text-[10px]"></i>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-medium text-slate-700">
                                                {{ $teacher->created_at->format('M d, Y') }}
                                            </span>
                                            <span class="text-xs text-slate-500">
                                                {{ $teacher->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="action-btn text-blue-600 hover:bg-blue-50" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="action-btn text-amber-600 hover:bg-amber-50" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="deleteTeacher({{ $teacher->id }})" class="action-btn text-red-600 hover:bg-red-50" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-16">
                                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-user-slash text-3xl text-slate-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-700 mb-2">No teachers found</h3>
                                        <p class="text-slate-500 mb-6">Get started by adding your first teacher</p>
                                        <a href="{{ route('admin.teachers.create') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-700 transition-colors shadow-lg shadow-purple-500/30">
                                            <i class="fas fa-plus"></i>
                                            Add New Teacher
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">Showing</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $teachers->count() }}</span>
                            <span class="text-sm text-slate-500">teachers</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <button class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 rounded-lg transition-all bg-white shadow-sm disabled:opacity-50" disabled>
                                <i class="fas fa-chevron-left mr-1"></i>
                                Previous
                            </button>
                            <button class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 rounded-lg transition-all bg-white shadow-sm">
                                Next
                                <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                    @php
                        $statusDistribution = $teachers->groupBy('status')->map->count();
                        $subjectCount = $teachers->flatMap->subjects->unique('id')->count();
                    @endphp
                    
                    <div class="glass-card p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $statusDistribution['active'] ?? 0 }}</p>
                            <p class="text-sm text-slate-500 font-medium">Active Teachers</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $statusDistribution['on_leave'] ?? 0 }}</p>
                            <p class="text-sm text-slate-500 font-medium">On Leave</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $subjectCount }}</p>
                            <p class="text-sm text-slate-500 font-medium">Subjects Taught</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                            <i class="fas fa-chalkboard text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $teachers->flatMap->sections->unique('id')->count() }}</p>
                            <p class="text-sm text-slate-500 font-medium">Sections Handled</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-2xl shadow-2xl p-6 w-96">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Delete Teacher?</h3>
                <p class="text-sm text-slate-500">Are you sure you want to delete this teacher? This action cannot be undone.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-lg shadow-red-500/30">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-container');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        }

        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.teacher-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const email = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function filterByStatus(status) {
            const rows = document.querySelectorAll('.teacher-row');
            
            rows.forEach(row => {
                if (!status || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.teacher-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        function sortTable(sortBy) {
            const tbody = document.querySelector('#teachersTable tbody');
            const rows = Array.from(tbody.querySelectorAll('.teacher-row'));
            
            rows.sort((a, b) => {
                if (sortBy === 'name') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                }
                return 0;
            });
            
            rows.forEach(row => tbody.appendChild(row));
        }

        function deleteTeacher(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/teachers/${id}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function exportData() {
            const rows = document.querySelectorAll('.teacher-row');
            let csv = 'ID,Name,Email,Status,Hired Date\\n';
            
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const cells = row.querySelectorAll('td');
                    const id = cells[1].querySelector('p.text-xs').textContent.replace('ID: ', '').split('•')[0].trim();
                    const name = cells[1].querySelector('p.font-bold').textContent;
                    const email = cells[4].querySelector('span').textContent.trim();
                    const status = cells[5].textContent.trim();
                    const date = cells[6].querySelector('span.text-sm').textContent;
                    
                    csv += `"${id}","${name}","${email}","${status}","${date}"\\n`;
                }
            });
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `teachers_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
        }

        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('searchInput')?.focus();
            }
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

<!-- Floating Action Button -->
<a href="{{ route('admin.teachers.create') }}" class="fab-icon-only">
    <i class="fas fa-plus text-xl"></i>
</a>

</body>
</html>