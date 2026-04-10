@extends('layouts.admin')

@section('title', 'School Year Management')

@section('header-title', 'School Year Management')

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
</style>

<div class="max-w-7xl mx-auto" x-data="{ open: false }">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900">School Year Management</h2>
                        <p class="text-slate-500 mt-1">Manage school years, generate enrollment QR codes, and control enrollment periods.</p>
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
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
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
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
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
                <button onclick="this.parentElement.remove()" class="text-amber-400 hover:text-amber-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Active School Year & QR Code Section -->
            @if(session('qr_code') && isset($activeSchoolYear))
            <div class="glass-card rounded-3xl p-8 mb-8 animate-fade-in-up">
                <div class="flex flex-col lg:flex-row items-start justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ $activeSchoolYear->name }}</h3>
                            <p class="text-sm text-slate-500">Enrollment QR Code Generated</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-bold shadow-sm">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                        ACTIVE
                    </span>
                </div>
                
                <div class="flex flex-col xl:flex-row items-start gap-8">
                    <!-- QR Code Image -->
                    <div class="flex-shrink-0 bg-slate-50 p-6 rounded-2xl border-2 border-dashed border-slate-200">
                        <img src="{{ Storage::url(session('qr_code')->qr_code_image_path) }}" 
                             alt="Enrollment QR Code" 
                             class="w-56 h-56 object-contain">
                    </div>
                    
                    <!-- QR Code Info & Actions -->
                    <div class="flex-1 space-y-5 w-full min-w-0">
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                            <p class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-blue-500"></i>
                                Enrollment URL
                            </p>
                            <div class="flex gap-3">
                                <code class="flex-1 bg-slate-800 text-emerald-400 px-4 py-3.5 rounded-xl text-sm break-all font-mono min-w-0">
                                    {{ route('admin.enrollment.form.qr', ['token' => session('qr_code')->qr_code_token]) }}
                                </code>
                                <button onclick="copyToClipboard('{{ route('admin.enrollment.form.qr', ['token' => session('qr_code')->qr_code_token]) }}')" 
                                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 font-semibold whitespace-nowrap"
                                        title="Copy URL">
                                    <i class="fas fa-copy"></i>
                                    <span class="hidden sm:inline">Copy</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('admin.school-year.download-qr', session('qr_code')) }}" 
                               class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5">
                                <i class="fas fa-download mr-2"></i>Download QR
                            </a>
                            
                            <form action="{{ route('admin.school-year.regenerate-qr') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-0.5"
                                        onclick="return confirm('Regenerate QR code? Old QR codes will be invalidated.')">
                                    <i class="fas fa-sync mr-2"></i>Regenerate
                                </button>
                            </form>

                            <form action="{{ route('admin.school-year.end') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5"
                                        onclick="return confirm('End this school year? All students will be unenrolled.')">
                                    <i class="fas fa-stop-circle mr-2"></i>End School Year
                                </button>
                            </form>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <p class="text-sm text-blue-800 leading-relaxed">
                                    Students can scan this QR code or visit the URL to submit their enrollment application. Download and print this QR code for physical distribution.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(isset($activeSchoolYear) && $activeSchoolYear->qrCode)
            <!-- Show existing QR code if school year is active but page was refreshed -->
            <div class="glass-card rounded-3xl p-8 mb-8 animate-fade-in-up">
                <div class="flex flex-col lg:flex-row items-start justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ $activeSchoolYear->name }}</h3>
                            <p class="text-sm text-slate-500">Existing QR Code</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-bold shadow-sm">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                        ACTIVE
                    </span>
                </div>
                
                <div class="flex flex-col xl:flex-row items-start gap-8">
                    <div class="flex-shrink-0 bg-slate-50 p-6 rounded-2xl border-2 border-dashed border-slate-200">
                        <img src="{{ Storage::url($activeSchoolYear->qrCode->qr_code_image_path) }}" 
                             alt="Enrollment QR Code" 
                             class="w-56 h-56 object-contain">
                    </div>
                    
                    <div class="flex-1 space-y-5 w-full min-w-0">
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                            <p class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-blue-500"></i>
                                Enrollment URL
                            </p>
                            <div class="flex gap-3">
                                <code class="flex-1 bg-slate-800 text-emerald-400 px-4 py-3.5 rounded-xl text-sm break-all font-mono min-w-0">
                                    {{ route('admin.enrollment.form.qr', ['token' => $activeSchoolYear->qrCode->qr_code_token]) }}
                                </code>
                                <button onclick="copyToClipboard('{{ route('admin.enrollment.form.qr', ['token' => $activeSchoolYear->qrCode->qr_code_token]) }}')" 
                                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 font-semibold whitespace-nowrap"
                                        title="Copy URL">
                                    <i class="fas fa-copy"></i>
                                    <span class="hidden sm:inline">Copy</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('admin.school-year.download-qr', $activeSchoolYear->qrCode) }}" 
                               class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5">
                                <i class="fas fa-download mr-2"></i>Download QR
                            </a>
                            
                            <form action="{{ route('admin.school-year.regenerate-qr') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-0.5"
                                        onclick="return confirm('Regenerate QR code? Old QR codes will be invalidated.')">
                                    <i class="fas fa-sync mr-2"></i>Regenerate
                                </button>
                            </form>

                            <form action="{{ route('admin.school-year.end') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5"
                                        onclick="return confirm('End this school year? All students will be unenrolled.')">
                                    <i class="fas fa-stop-circle mr-2"></i>End School Year
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(isset($activeSchoolYear))
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8 animate-fade-in-up">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-amber-900 text-lg">Active School Year: {{ $activeSchoolYear->name }}</h3>
                        <p class="text-amber-700">No QR code generated yet. Generate one to enable student enrollment.</p>
                    </div>
                    <form action="{{ route('admin.school-year.regenerate-qr') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="school_year_id" value="{{ $activeSchoolYear->id }}">
                        <button type="submit" 
                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-0.5 whitespace-nowrap"
                                onclick="return confirm('Generate QR code for enrollment?')">
                            <i class="fas fa-magic mr-2"></i>Generate QR
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- School Years List -->
            <div class="glass-card rounded-3xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list text-indigo-600"></i>
                        </div>
                        <h3 class="font-bold text-xl text-slate-900">All School Years</h3>
                    </div>
                   <div class="flex gap-3">
                @if($activeSchoolYear)
                <a href="{{ route('admin.school-year.closure') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5">
                    <i class="fas fa-calendar-check mr-2"></i>Closure Dashboard
                </a>
                @endif
                
                <div x-data="{ open: false }">
                    <!-- Button to trigger modal -->
                    <button @click="open = true" 
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>Create New
                    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click.away="open = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <h2 class="text-2xl font-bold mb-6 text-center">Create School Year</h2>
            
            <form action="{{ route('admin.school-years.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block font-medium mb-1">Name</label>
                    <input type="text" name="name" id="name" placeholder="e.g., 2026-2027" 
                           class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>

                <div>
                    <label for="start_date" class="block font-medium mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                           class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>

                <div>
                    <label for="end_date" class="block font-medium mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                           class="border border-gray-300 rounded px-3 py-2 w-full" required>
                </div>

                <div>
                    <label for="description" class="block font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="border border-gray-300 rounded px-3 py-2 w-full" placeholder="Optional description"></textarea>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="mr-2">
                    <label for="is_active" class="font-medium">Set as active</label>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" @click="open = false" 
                            class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                        Save
                    </button>
                </div>
            </form>

            <!-- Close button -->
            <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
</div>

<!-- Include Alpine.js if not already -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>



                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">School Year</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">End Date</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($schoolYears as $year)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-sm">
                                            {{ substr($year->name, 0, 2) }}
                                        </div>
                                        <span class="font-semibold text-slate-900">{{ $year->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-slate-600">{{ $year->start_date->format('M d, Y') }}</td>
                                <td class="px-8 py-5 text-slate-600">{{ optional($year->end_date)->format('M d, Y') ?? '—' }}</td>
                                <td class="px-8 py-5">
                                    @if($year->is_active)
                                        <span class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-bold shadow-sm">
                                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                            ACTIVE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-600 rounded-full text-sm font-medium">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    @if(!$year->is_active)
                                    <form action="{{ route('admin.school-year.start') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="school_year_id" value="{{ $year->id }}">
                                        <button type="submit" 
                                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5"
                                                onclick="return confirm('Start this school year? This will generate a QR code for enrollment.')">
                                            <i class="fas fa-play mr-2"></i>Start & Generate QR
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-slate-400 text-sm italic flex items-center gap-2">
                                        <i class="fas fa-check-circle text-emerald-500"></i>
                                        Currently Active
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center">
                                            <i class="fas fa-inbox text-4xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="text-slate-500 font-medium text-lg">No school years found</p>
                                            <p class="text-slate-400 text-sm mt-1">Create your first school year to get started</p>
                                        </div>
                                        <a href="{{ route('admin.school-years.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 mt-2 hover:shadow-xl hover:-translate-y-0.5">
                                            <i class="fas fa-plus mr-2"></i>Create School Year
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($schoolYears->hasPages())
                <div class="px-8 py-5 border-t border-slate-200 bg-slate-50/50">
                    {{ $schoolYears->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3"></div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('sidebar')?.classList.toggle('open');
        });

        // Copy to clipboard with toast notification
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('URL copied to clipboard!', 'success');
            }, function(err) {
                console.error('Could not copy text: ', err);
                showToast('Failed to copy URL. Please copy manually.', 'error');
            });
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const bgColor = type === 'success' ? 'bg-slate-800' : 'bg-rose-600';
            const icon = type === 'success' ? 'fa-check-circle text-emerald-400' : 'fa-exclamation-circle text-white';
            
            toast.className = `${bgColor} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300 min-w-[300px]`;
            toast.innerHTML = `
                <i class="fas ${icon} text-lg"></i>
                <span class="font-medium">${message}</span>
            `;
            
            container.appendChild(toast);
            
            // Animate in
            requestAnimationFrame(() => {
                toast.style.transform = 'translateY(0)';
                toast.style.opacity = '1';
            });
            
            /* Remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateY(10px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000); */
        }

        /* Auto-hide alerts after 5 seconds
        document.querySelectorAll('[class*="animate-fade-in-up"]').forEach(alert => {
            setTimeout(() => {
                if (alert && alert.parentElement) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'all 0.3s ease';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }); */
    </script>
</div>
@endsection