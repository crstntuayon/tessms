@extends('layouts.admin')

@section('title', 'Enrollment Applications')

@section('content')
<style>
    /* Hide Alpine elements before Alpine loads */
    [x-cloak] { display: none !important; }
    /* Ensure modal is hidden by default */
    .modal-hidden { display: none !important; }
</style>
<div class="max-w-7xl mx-auto" x-data="enrollmentIndexApp()">
    <!-- Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-50 flex flex-col rounded-xl shadow-lg overflow-hidden min-w-[300px]"
         :class="toast.type === 'success' ? 'bg-emerald-500' : toast.type === 'error' ? 'bg-rose-500' : 'bg-amber-500'">
        <div class="flex items-center gap-2 px-4 py-3 text-white">
            <i class="fas" :class="toast.type === 'success' ? 'fa-check-circle' : toast.type === 'error' ? 'fa-exclamation-circle' : 'fa-exclamation-triangle'"></i>
            <span class="font-medium text-sm" x-text="toast.message"></span>
            <button @click="toast.show = false" class="ml-auto text-white/80 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="h-1 bg-white/20">
            <div class="h-full bg-white/60 transition-all ease-linear"
                 :style="`width: ${toast.progress}%; transition-duration: ${toast.duration}ms`">
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div x-show="bulkModal.open" 
         x-cloak 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm" @click.prevent="bulkModal.open = false; bulkModal.sectionId = ''; bulkModal.rejectionReason = '';"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="bulkModal.open"
                 x-cloak
                 style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:max-w-lg w-full">
                <!-- Close Button -->
                <button type="button" 
                        @click.prevent="bulkModal.open = false; bulkModal.sectionId = ''; bulkModal.rejectionReason = '';"
                        class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors z-10">
                    <i class="fas fa-times"></i>
                </button>
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                             :class="bulkModal.action === 'approve' ? 'bg-emerald-100' : 'bg-red-100'">
                            <i class="fas text-lg" :class="bulkModal.action === 'approve' ? 'fa-check text-emerald-600' : 'fa-times text-red-600'"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-semibold leading-6 text-slate-900" x-text="bulkModal.action === 'approve' ? 'Bulk Approve Applications' : 'Bulk Reject Applications'"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500" x-show="bulkModal.action">
                                    You are about to <span x-text="bulkModal.action" class="font-semibold lowercase"></span> <span x-text="selectedApplications.length" class="font-semibold"></span> application(s).
                                </p>
                                <p x-show="!bulkModal.action" class="text-sm text-slate-500 mt-1">Preparing bulk action for <span x-text="selectedApplications.length" class="font-semibold"></span> application(s)...</p>
                                
                                <template x-if="bulkModal.action === 'approve'">
                                    <div class="mt-4 space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Section *</label>
                                            <select x-model="bulkModal.sectionId" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                                <option value="">Select section...</option>
                                                @foreach($allSections ?? [] as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->gradeLevel->name ?? 'N/A' }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="bulkModal.action === 'reject'">
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Rejection Reason *</label>
                                        <textarea x-model="bulkModal.rejectionReason" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg" placeholder="Enter reason for rejection..."></textarea>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button" 
                            @click.prevent="submitBulkAction()"
                            :disabled="(bulkModal.action === 'approve' && !bulkModal.sectionId) || (bulkModal.action === 'reject' && !bulkModal.rejectionReason)"
                            class="inline-flex w-full justify-center rounded-lg px-3 py-2 text-sm font-semibold text-white shadow-sm sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="bulkModal.action === 'approve' ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-red-600 hover:bg-red-500'">
                        <span x-text="bulkModal.action === 'approve' ? 'Approve All' : 'Reject All'"></span>
                    </button>
                    <button type="button" 
                            @click.prevent="bulkModal.open = false; bulkModal.sectionId = ''; bulkModal.rejectionReason = '';" 
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $enrollmentEnabledValue = \App\Models\Setting::get('enrollment_enabled', false);
        $enrollmentEnabled = $enrollmentEnabledValue === true || $enrollmentEnabledValue === '1' || $enrollmentEnabledValue === 1;
    @endphp

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Continuing Student Enrollments</h1>
            <p class="text-slate-500">
                Manage online enrollment for {{ $activeSchoolYear->name ?? 'current school year' }}
                @if($activeSchoolYear && $activeSchoolYear->is_active)
                    <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-full">Active</span>
                @endif
            </p>
        </div>
        
        <!-- Enrollment Toggle -->
        <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-xl shadow-sm border border-slate-200">
            <div class="text-right">
                <p class="text-sm font-medium text-slate-700">Student Enrollment</p>
                <p class="text-xs text-slate-500">Allow students to submit requests</p>
            </div>
            <form action="{{ route('admin.settings.toggle-enrollment') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="enrollment_enabled" value="{{ $enrollmentEnabled ? '0' : '1' }}">
                <button type="submit" 
                        class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $enrollmentEnabled ? 'bg-emerald-500' : 'bg-slate-300' }}">
                    <span class="sr-only">Toggle enrollment</span>
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition-transform {{ $enrollmentEnabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </form>
            <span class="text-xs font-medium {{ $enrollmentEnabled ? 'text-emerald-600' : 'text-slate-500' }}">
                {{ $enrollmentEnabled ? 'OPEN' : 'CLOSED' }}
            </span>
        </div>
    </div>

    @if(!$enrollmentEnabled)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                <i class="fas fa-lock text-amber-600"></i>
            </div>
            <div>
                <p class="font-medium text-amber-800">Enrollment is currently closed</p>
                <p class="text-sm text-amber-700">Students cannot submit enrollment requests. Toggle the switch above to open enrollment.</p>
            </div>
        </div>
    @endif
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Total</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-amber-600 font-medium">Pending</p>
            <p class="text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-blue-600 font-medium">Under Review</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['under_review'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-emerald-600 font-medium">Approved</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $stats['approved'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-red-600 font-medium">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
        </div>
    </div>
    
    <!-- Filters -->
    <form method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
        <div class="flex flex-wrap gap-4">
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search LRN, student name, email..." class="px-4 py-2 border border-slate-200 rounded-lg flex-1 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-search mr-1"></i>Filter
            </button>
            <a href="{{ route('admin.enrollment.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors">
                <i class="fas fa-undo mr-1"></i>Reset
            </a>
        </div>
    </form>

    <!-- Bulk Actions Bar -->
    <div x-show="selectedApplications.length > 0" 
         x-transition
         class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-indigo-600 text-white rounded-full text-sm font-semibold" x-text="selectedApplications.length"></span>
            <span class="text-indigo-800 font-medium">application(s) selected</span>
        </div>
        <div class="flex gap-2">
            <button @click="openBulkModal('approve')" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center gap-2">
                <i class="fas fa-check"></i>Approve Selected
            </button>
            <button @click="openBulkModal('reject')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                <i class="fas fa-times"></i>Reject Selected
            </button>
            <button @click="selectAll = false; selectedApplications = []" class="px-4 py-2 border border-indigo-300 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                Clear
            </button>
        </div>
    </div>
    
    <!-- Applications Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <input type="checkbox" 
                               x-model="selectAll" 
                               @change="toggleSelectAll()"
                               class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Application #</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Student</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">LRN</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Next Grade</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Submitted</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($applications as $app)
                    <tr class="hover:bg-slate-50 transition-colors" :class="selectedApplications.includes({{ $app->id }}) ? 'bg-indigo-50/50' : ''">
                        <td class="px-4 py-4">
                            <input type="checkbox" 
                                   value="{{ $app->id }}"
                                   x-model="selectedApplications"
                                   :checked="selectedApplications.includes({{ $app->id }})"
                                   class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-4 font-medium text-indigo-600">{{ $app->application_number }}</td>
                        <td class="px-4 py-4">
                            <p class="font-medium text-slate-800">{{ $app->student_full_name }}</p>
                            <p class="text-sm text-slate-500">{{ $app->parent_email }}</p>
                        </td>
                        <td class="px-4 py-4 text-slate-600 font-mono text-sm">{{ $app->student_lrn ?? 'N/A' }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium">
                                {{ $app->gradeLevel->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($app->status == 'approved') bg-emerald-100 text-emerald-700
                                @elseif($app->status == 'rejected') bg-red-100 text-red-700
                                @elseif($app->status == 'pending') bg-amber-100 text-amber-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $app->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-500">{{ $app->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-4">
                            <a href="{{ route('admin.enrollment.show', $app) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg font-medium text-sm transition-colors">
                                <i class="fas fa-eye"></i>View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-inbox text-2xl opacity-50"></i>
                            </div>
                            <p class="text-sm font-medium">No applications found</p>
                            <p class="text-xs mt-1">Try adjusting your filters</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $applications->withQueryString()->links() }}
    </div>

    <script>
        function enrollmentIndexApp() {
            return {
                selectedApplications: [],
                selectAll: false,
                bulkModal: {
                    open: false,
                    action: '',
                    sectionId: '',
                    rejectionReason: ''
                },
                toast: { 
                    show: false, 
                    message: '', 
                    type: 'success',
                    progress: 100,
                    duration: 3000
                },

                init() {
                    // Handle session flash messages
                    @if(session('success'))
                        this.showToast('{{ session('success') }}', 'success');
                    @endif
                    @if(session('error'))
                        this.showToast('{{ session('error') }}', 'error');
                    @endif
                    @if(session('warning'))
                        this.showToast('{{ session('warning') }}', 'warning');
                    @endif
                },

                toggleSelectAll() {
                    if (this.selectAll) {
                        // Get all visible checkbox values
                        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                        this.selectedApplications = Array.from(checkboxes).map(cb => parseInt(cb.value));
                    } else {
                        this.selectedApplications = [];
                    }
                },

                openBulkModal(action) {
                    this.bulkModal.action = action;
                    this.bulkModal.sectionId = '';
                    this.bulkModal.rejectionReason = '';
                    this.bulkModal.open = true;
                },

                submitBulkAction() {
                    if (this.bulkModal.action === 'approve') {
                        this.bulkApprove();
                    } else {
                        this.bulkReject();
                    }
                },

                bulkApprove() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.enrollment.bulk-approve') }}';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    this.selectedApplications.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'applications[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    const sectionInput = document.createElement('input');
                    sectionInput.type = 'hidden';
                    sectionInput.name = 'section_id';
                    sectionInput.value = this.bulkModal.sectionId;
                    form.appendChild(sectionInput);

                    const schoolYearInput = document.createElement('input');
                    schoolYearInput.type = 'hidden';
                    schoolYearInput.name = 'school_year_id';
                    schoolYearInput.value = '{{ request('school_year', \App\Models\SchoolYear::where('is_active', true)->first()?->id) }}';
                    form.appendChild(schoolYearInput);

                    document.body.appendChild(form);
                    form.submit();
                },

                bulkReject() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.enrollment.bulk-reject') }}';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    this.selectedApplications.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'applications[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'rejection_reason';
                    reasonInput.value = this.bulkModal.rejectionReason;
                    form.appendChild(reasonInput);

                    document.body.appendChild(form);
                    form.submit();
                },

                showToast(message, type = 'success', duration = 3000) {
                    if (this.toast.timeout) {
                        clearTimeout(this.toast.timeout);
                    }
                    
                    this.toast = { 
                        show: true, 
                        message, 
                        type, 
                        progress: 100, 
                        duration: duration 
                    };
                    
                    setTimeout(() => {
                        this.toast.progress = 0;
                    }, 50);
                    
                    this.toast.timeout = setTimeout(() => {
                        this.toast.show = false;
                    }, duration);
                }
            }
        }
    </script>
</div>
@endsection
