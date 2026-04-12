@extends('layouts.admin')

@section('title', 'Report Builder - ' . $template->name)
@section('header-title', 'Report Builder')

@push('styles')
<style>
    .filter-card {
        transition: all 0.2s ease;
    }
    .filter-card:hover {
        border-color: #3b82f6;
    }
    .preview-table th {
        background-color: #f8fafc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    .chart-preview {
        min-height: 300px;
    }
    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="flex items-center text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.reports.index') }}" class="hover:text-gray-700">Reports</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span>Report Builder</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $template->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $template->description }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="saveReport()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Save Report
                </button>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <button onclick="exportReport('pdf')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Export as PDF
                            </button>
                            <button onclick="exportReport('excel')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Export as Excel
                            </button>
                            <button onclick="exportReport('csv')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Export as CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Filters Panel -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
                        <button onclick="resetFilters()" class="text-sm text-blue-600 hover:text-blue-800">Reset</button>
                    </div>

                    <form id="report-filters" class="space-y-4">
                        <!-- School Year Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                            <select name="school_year_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All School Years</option>
                                @foreach($filterOptions['school_years'] as $year)
                                    <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Grade Level Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                            <select name="grade_level_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All Grade Levels</option>
                                @foreach($filterOptions['grade_levels'] as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                            <select name="section_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All Sections</option>
                                @foreach($filterOptions['sections'] as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->gradeLevel?->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <select name="subject_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All Subjects</option>
                                @foreach($filterOptions['subjects'] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All Genders</option>
                                @foreach($filterOptions['genders'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">All Statuses</option>
                                @foreach($filterOptions['statuses'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="filter-card">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="date" name="start_date" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <input type="date" name="end_date" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Generate Button -->
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Generate Report
                        </button>
                    </form>
                </div>

                <!-- Report Settings -->
                <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Report Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Output Format</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="html" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">HTML (Interactive)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="pdf" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">PDF Document</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="excel" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Excel Spreadsheet</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="format" value="csv" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">CSV File</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6 relative min-h-[600px]">
                    <!-- Loading Overlay -->
                    <div id="loading-overlay" class="loading-overlay hidden">
                        <div class="flex flex-col items-center">
                            <svg class="animate-spin h-10 w-10 text-blue-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-600">Generating report...</p>
                        </div>
                    </div>

                    <!-- Report Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h2 id="report-title" class="text-xl font-bold text-gray-900">{{ $template->name }}</h2>
                        <p id="report-date" class="text-sm text-gray-500 mt-1">Generated: {{ now()->format('F d, Y h:i A') }}</p>
                    </div>

                    <!-- Summary Stats -->
                    <div id="report-summary" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <!-- Summary cards will be inserted here -->
                    </div>

                    <!-- Chart Preview (if applicable) -->
                    @if(in_array($template->type, ['chart', 'combined']))
                        <div id="chart-container" class="chart-preview mb-6 {{ $template->type === 'combined' ? '' : 'hidden' }}">
                            <canvas id="report-chart"></canvas>
                        </div>
                    @endif

                    <!-- Table Preview -->
                    <div id="table-container" class="overflow-x-auto {{ $template->type === 'chart' ? 'hidden' : '' }}">
                        <table class="min-w-full divide-y divide-gray-200 preview-table">
                            <thead id="report-table-head">
                                <!-- Headers will be inserted here -->
                            </thead>
                            <tbody id="report-table-body" class="bg-white divide-y divide-gray-200">
                                <!-- Data will be inserted here -->
                            </tbody>
                        </table>
                        
                        <!-- Empty State -->
                        <div id="empty-state" class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No data</h3>
                            <p class="mt-1 text-sm text-gray-500">Select filters and click "Generate Report" to see results.</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="mt-6 flex items-center justify-between hidden">
                        <div class="text-sm text-gray-500">
                            Showing <span id="showing-start">0</span> to <span id="showing-end">0</span> of <span id="total-records">0</span> results
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="prevPage()" id="btn-prev" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                                Previous
                            </button>
                            <button onclick="nextPage()" id="btn-next" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Report Modal -->
<div id="save-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeSaveModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modal-title">Save Report</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Report Name</label>
                        <input type="text" id="save-report-name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter a name for this report">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                        <textarea id="save-report-notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Add any notes about this report"></textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="save-report-favorite" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="save-report-favorite" class="ml-2 block text-sm text-gray-900">Add to favorites</label>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="confirmSaveReport()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                </button>
                <button type="button" onclick="closeSaveModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentReportData = null;
    let currentPage = 1;
    let reportChart = null;

    // Form submission
    document.getElementById('report-filters').addEventListener('submit', function(e) {
        e.preventDefault();
        generateReport();
    });

    // Generate report
    function generateReport() {
        const formData = new FormData(document.getElementById('report-filters'));
        const params = Object.fromEntries(formData);
        const format = document.querySelector('input[name="format"]:checked').value;

        document.getElementById('loading-overlay').classList.remove('hidden');

        fetch('{{ route("admin.reports.generate", $template) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                parameters: params,
                format: format
            })
        })
        .then(response => {
            if (format === 'html') {
                return response.json();
            }
            return response.blob();
        })
        .then(data => {
            document.getElementById('loading-overlay').classList.add('hidden');

            if (format === 'html') {
                currentReportData = data;
                displayReport(data.data);
            } else {
                // Handle file download
                const url = window.URL.createObjectURL(data);
                const a = document.createElement('a');
                a.href = url;
                a.download = '{{ $template->slug }}_' + new Date().toISOString().split('T')[0] + '.' + format;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
        })
        .catch(error => {
            document.getElementById('loading-overlay').classList.add('hidden');
            console.error('Error:', error);
            alert('Error generating report');
        });
    }

    // Display report data
    function displayReport(data) {
        // Update title
        document.getElementById('report-title').textContent = data.title || '{{ $template->name }}';
        document.getElementById('report-date').textContent = 'Generated: ' + new Date().toLocaleString();

        // Display summary
        const summaryContainer = document.getElementById('report-summary');
        summaryContainer.innerHTML = '';
        
        if (data.summary) {
            Object.entries(data.summary).forEach(([key, value]) => {
                summaryContainer.innerHTML += `
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-600 font-medium">${key}</p>
                        <p class="text-2xl font-bold text-blue-900">${value}</p>
                    </div>
                `;
            });
        }

        // Display chart if applicable
        @if(in_array($template->type, ['chart', 'combined']))
            if (data.chart_data && document.getElementById('report-chart')) {
                document.getElementById('chart-container').classList.remove('hidden');
                
                if (reportChart) {
                    reportChart.destroy();
                }

                reportChart = new Chart(document.getElementById('report-chart'), {
                    type: '{{ $template->chart_config?.type ?? "line" }}',
                    data: {
                        labels: data.chart_data.map(d => d.date || d.label),
                        datasets: [{
                            label: data.title,
                            data: data.chart_data.map(d => d.rate || d.value || d.count),
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        @endif

        // Display table
        const tableContainer = document.getElementById('table-container');
        const emptyState = document.getElementById('empty-state');
        
        if (data.rows && data.rows.length > 0) {
            emptyState.classList.add('hidden');
            tableContainer.classList.remove('hidden');

            // Build headers
            const headers = Object.keys(data.rows[0]);
            const thead = document.getElementById('report-table-head');
            thead.innerHTML = '<tr>' + headers.map(h => 
                `<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">${h.replace(/_/g, ' ')}</th>`
            ).join('') + '</tr>';

            // Build body
            const tbody = document.getElementById('report-table-body');
            tbody.innerHTML = data.rows.map(row => 
                '<tr class="hover:bg-gray-50">' + 
                headers.map(h => `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${row[h] || '-'}</td>`).join('') + 
                '</tr>'
            ).join('');

            // Update pagination info
            document.getElementById('showing-start').textContent = '1';
            document.getElementById('showing-end').textContent = data.rows.length;
            document.getElementById('total-records').textContent = data.rows.length;
            document.getElementById('pagination').classList.remove('hidden');
        } else {
            emptyState.classList.remove('hidden');
            tableContainer.classList.add('hidden');
            document.getElementById('pagination').classList.add('hidden');
        }
    }

    // Export report
    function exportReport(format) {
        document.querySelector(`input[name="format"][value="${format}"]`).checked = true;
        generateReport();
    }

    // Save report modal
    function saveReport() {
        document.getElementById('save-modal').classList.remove('hidden');
    }

    function closeSaveModal() {
        document.getElementById('save-modal').classList.add('hidden');
    }

    function confirmSaveReport() {
        const name = document.getElementById('save-report-name').value;
        const notes = document.getElementById('save-report-notes').value;
        const isFavorite = document.getElementById('save-report-favorite').checked;
        const format = document.querySelector('input[name="format"]:checked').value;

        if (!name) {
            alert('Please enter a report name');
            return;
        }

        const formData = new FormData(document.getElementById('report-filters'));
        const params = Object.fromEntries(formData);

        fetch('{{ route("admin.reports.save", $template) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: name,
                parameters: params,
                format: format,
                is_favorite: isFavorite,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeSaveModal();
                alert('Report saved successfully!');
            } else {
                alert('Error saving report');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving report');
        });
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('report-filters').reset();
    }

    // Pagination functions
    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            // Implement pagination logic
        }
    }

    function nextPage() {
        currentPage++;
        // Implement pagination logic
    }
</script>
@endpush
