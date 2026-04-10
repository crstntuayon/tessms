@extends('layouts.admin')

@section('title', 'School Year Closure')

@section('header-title', 'School Year Closure')

@section('content')
<style>
    .glass-card {
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    @keyframes fadeInUp { 
        from { opacity: 0; transform: translateY(20px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .animate-fade-in-up { 
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
    }
    .progress-bar {
        transition: width 0.5s ease;
    }
</style>

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-rose-600 to-pink-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-500/30">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-slate-900">School Year Closure</h2>
                <p class="text-slate-500 mt-1">Manage section finalizations and end the school year</p>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex items-start gap-4 animate-fade-in-up">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-emerald-900 text-lg">Success</h3>
            <p class="text-emerald-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl p-5 flex items-start gap-4 animate-fade-in-up">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-exclamation-circle text-rose-600 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-rose-900 text-lg">Error</h3>
            <p class="text-rose-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4 animate-fade-in-up">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-amber-600 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-amber-900 text-lg">Warning</h3>
            <p class="text-amber-700">{{ session('warning') }}</p>
        </div>
    </div>
    @endif

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6 animate-fade-in-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard text-blue-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600">Total Sections</span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $closure->total_sections }}</p>
        </div>

        <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-double text-emerald-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600">Finalized</span>
            </div>
            <p class="text-3xl font-bold text-emerald-600">{{ $closure->finalized_sections }}</p>
        </div>

        <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600">Pending</span>
            </div>
            <p class="text-3xl font-bold text-amber-600">{{ $closure->total_sections - $closure->finalized_sections }}</p>
        </div>

        <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-percentage text-purple-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600">Progress</span>
            </div>
            <p class="text-3xl font-bold text-purple-600">{{ $closure->getProgressPercentage() }}%</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="glass-card rounded-2xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.4s;">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-slate-900">Finalization Progress</h3>
            <span class="text-sm font-medium {{ $closure->all_sections_finalized ? 'text-emerald-600' : 'text-amber-600' }}">
                {{ $closure->finalized_sections }} / {{ $closure->total_sections }} Sections
            </span>
        </div>
        <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden">
            <div class="progress-bar h-full rounded-full {{ $closure->all_sections_finalized ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-blue-500 to-indigo-500' }}" 
                 style="width: {{ $closure->getProgressPercentage() }}%"></div>
        </div>
        @if($closure->finalization_deadline)
        <div class="mt-3 flex items-center gap-2 text-sm">
            <i class="fas fa-calendar-alt text-slate-400"></i>
            <span class="text-slate-600">Finalization Deadline:</span>
            <span class="font-semibold {{ now()->greaterThan($closure->finalization_deadline) ? 'text-rose-600' : 'text-slate-900' }}">
                {{ $closure->finalization_deadline->format('F d, Y') }}
            </span>
            @if($closure->auto_close_enabled)
            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                Auto-close enabled
            </span>
            @endif
        </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="glass-card rounded-2xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.5s;">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900 mb-1">End School Year</h3>
                <p class="text-sm text-slate-500">
                    @if($canEnd['all_finalized'])
                        All sections are finalized. You can now end the school year.
                    @elseif($canEnd['can_end'])
                        Deadline has passed. You may force end the school year with a reason.
                    @else
                        {{ $canEnd['pending_count'] }} section(s) still pending finalization.
                    @endif
                </p>
            </div>
            <div class="flex gap-3">
                @if($canEnd['all_finalized'])
                <form action="{{ route('admin.school-year.end') }}" method="POST">
                    @csrf
                    <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/30"
                            onclick="return confirm('Are you sure you want to end the school year? This will promote all students to the next grade level.')">
                        <i class="fas fa-check-circle mr-2"></i>
                        End School Year
                    </button>
                </form>
                @elseif($canEnd['can_end'])
                <button type="button" 
                        onclick="document.getElementById('forceEndModal').classList.remove('hidden')"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-amber-500/30">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Force End School Year
                </button>
                @else
                <button type="button" disabled
                        class="inline-flex items-center px-6 py-3 bg-slate-300 text-slate-500 font-semibold rounded-xl cursor-not-allowed">
                    <i class="fas fa-lock mr-2"></i>
                    End School Year
                </button>
                @endif

                <button type="button" 
                        onclick="document.getElementById('setDeadlineModal').classList.remove('hidden')"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Set Deadline
                </button>
            </div>
        </div>
    </div>

    <!-- Sections List -->
    <div class="glass-card rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.6s;">
        <div class="px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-indigo-600"></i>
                </div>
                <h3 class="font-bold text-xl text-slate-900">Section Finalization Status</h3>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/80">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Adviser</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Grades</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Attendance</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Core Values</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($sectionsStatus as $item)
                    <tr class="hover:bg-slate-50/80 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-sm">
                                    {{ substr($item['section']->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $item['section']->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $item['section']->gradeLevel->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700">{{ $item['section']->teacher->user->full_name ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item['finalization'] && $item['finalization']->grades_finalized)
                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                <i class="fas fa-check mr-1"></i> Done
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-medium">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item['finalization'] && $item['finalization']->attendance_finalized)
                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                <i class="fas fa-check mr-1"></i> Done
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-medium">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item['finalization'] && $item['finalization']->core_values_finalized)
                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                <i class="fas fa-check mr-1"></i> Done
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-medium">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $item['status']['class'] }}">
                                {{ $item['status']['text'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($item['finalization'] && $item['finalization']->is_locked)
                            <form action="{{ route('admin.school-year.unlock-section') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="section_id" value="{{ $item['section']->id }}">
                                <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                                <button type="button"
                                        onclick="showUnlockModal({{ $item['section']->id }}, '{{ $item['section']->name }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-unlock mr-1"></i> Unlock
                                </button>
                            </form>
                            @elseif($item['finalization'] && $item['finalization']->is_fully_finalized)
                            <form action="{{ route('admin.school-year.relock-section') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="section_id" value="{{ $item['section']->id }}">
                                <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-medium transition-colors"
                                        onclick="return confirm('Re-lock this section?')">
                                    <i class="fas fa-lock mr-1"></i> Re-lock
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-inbox text-3xl text-slate-300"></i>
                                </div>
                                <p class="text-slate-500 font-medium">No sections found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Set Deadline Modal -->
<div id="setDeadlineModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('setDeadlineModal').classList.add('hidden')" 
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Set Finalization Deadline</h3>
        </div>
        
        <form action="{{ route('admin.school-year.set-deadline') }}" method="POST">
            @csrf
            <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deadline Date</label>
                    <input type="date" name="deadline" required
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
                
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                    <input type="checkbox" name="auto_finalize" id="auto_finalize" value="1" class="w-5 h-5 text-blue-600 rounded">
                    <label for="auto_finalize" class="text-sm text-slate-700">
                        <span class="font-medium">Auto-finalize on deadline</span>
                        <p class="text-xs text-slate-500 mt-1">Automatically finalize all pending sections when deadline is reached</p>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="button" 
                        onclick="document.getElementById('setDeadlineModal').classList.add('hidden')"
                        class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-medium rounded-xl transition-all">
                    Set Deadline
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Force End Modal -->
<div id="forceEndModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('forceEndModal').classList.add('hidden')" 
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-rose-600 text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Force End School Year</h3>
        </div>
        
        <div class="mb-6">
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                <p class="text-sm text-amber-800">
                    <i class="fas fa-info-circle mr-1"></i>
                    {{ $canEnd['pending_count'] ?? 0 }} section(s) are not yet finalized. Please provide a reason for force ending the school year.
                </p>
            </div>
        </div>
        
        <form action="{{ route('admin.school-year.force-end') }}" method="POST">
            @csrf
            <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Reason <span class="text-rose-500">*</span></label>
                <textarea name="reason" required rows="3"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20"
                          placeholder="Enter reason for force ending..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('forceEndModal').classList.add('hidden')"
                        class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-rose-500 to-red-500 hover:from-rose-600 hover:to-red-600 text-white font-medium rounded-xl transition-all"
                        onclick="return confirm('Are you sure? This action cannot be undone.')">
                    Force End
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Unlock Section Modal -->
<div id="unlockModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('unlockModal').classList.add('hidden')" 
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-unlock text-amber-600 text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Unlock Section</h3>
        </div>
        
        <p class="text-sm text-slate-600 mb-4">
            Unlocking <strong id="unlockSectionName"></strong> will allow the teacher to edit grades, attendance, and core values again.
        </p>
        
        <form id="unlockForm" action="{{ route('admin.school-year.unlock-section') }}" method="POST">
            @csrf
            <input type="hidden" name="section_id" id="unlockSectionId">
            <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Reason <span class="text-rose-500">*</span></label>
                <textarea name="reason" required rows="3"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                          placeholder="Enter reason for unlocking..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('unlockModal').classList.add('hidden')"
                        class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-medium rounded-xl transition-all">
                    Unlock Section
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showUnlockModal(sectionId, sectionName) {
    document.getElementById('unlockSectionId').value = sectionId;
    document.getElementById('unlockSectionName').textContent = sectionName;
    document.getElementById('unlockModal').classList.remove('hidden');
}
</script>
@endsection
