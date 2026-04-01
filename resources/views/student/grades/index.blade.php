<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Form 9 (SF9) - Learner's Progress Report Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f3f4f6;
        }
        
        /* Prevent flash of unstyled content */
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar for sidebar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
        
        /* Official DepEd SF9 Container */
        .sf9-container {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #000;
            padding: 0.4in;
            position: relative;
            box-sizing: border-box;
        }
        
        .sf9-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 9.5pt;
        }
        
        .sf9-table th,
        .sf9-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }
        
        .sf9-table th {
            background: #fff;
            color: #000;
            font-weight: bold;
            font-size: 8.5pt;
        }
        
        .header-box {
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
            background: #fff;
            margin-bottom: 0;
        }
        
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 50;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1e40af;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }
        
        .section-header {
            background: #fff;
            color: #000;
            padding: 5px 8px;
            font-weight: bold;
            font-size: 9.5pt;
            text-transform: uppercase;
            border: 1px solid #000;
            border-bottom: 2px solid #000;
            margin-top: 12px;
            margin-bottom: 0;
        }
        
        .info-grid {
            border: 1px solid #000;
            border-top: none;
        }
        
        .info-row {
            display: flex;
            border-bottom: 1px solid #000;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: bold;
            width: 100px;
            font-size: 9pt;
            padding: 4px 8px;
            border-right: 1px solid #000;
            background: #f9f9f9;
            text-transform: uppercase;
        }
        
        .info-value {
            flex: 1;
            font-weight: normal;
            font-size: 9pt;
            padding: 4px 8px;
            text-transform: uppercase;
        }
        
        .grade-passed {
            color: #000;
            font-weight: normal;
        }
        
        .grade-failed {
            color: #000;
            font-weight: bold;
        }
        
        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            font-weight: bold;
        }
        
        .core-values-table td {
            font-size: 8.5pt;
            text-align: left;
            padding: 3px 6px;
        }
        
        .attendance-table td {
            font-size: 8.5pt;
            padding: 3px 4px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 6px;
            padding: 16px;
            border: 1px solid #d1d5db;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .stat-icon.blue { background: #dbeafe; color: #1e40af; }
        .stat-icon.green { background: #dcfce7; color: #166534; }
        .stat-icon.purple { background: #f3e8ff; color: #7c3aed; }
        .stat-icon.amber { background: #fef3c7; color: #92400e; }
        
        .marking-box {
            border: 1px solid #000;
            padding: 6px;
            font-size: 8pt;
            margin-top: 6px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            padding-top: 4px;
            text-align: center;
        }
        
        .certificate-box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 12px;
        }
        
        .sf9-footer {
            border-top: 1px solid #000;
            padding-top: 6px;
            margin-top: 12px;
            font-size: 7.5pt;
            text-align: center;
        }
        
        .parent-sig-box {
            border: 1px solid #000;
            padding: 8px;
            margin-top: 10px;
        }
        
        .parent-sig-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        
        .sig-line {
            border-bottom: 1px solid #000;
            height: 24px;
            margin-bottom: 2px;
        }
        
        .message-box {
            border: 1px solid #000;
            padding: 8px;
            margin-top: 8px;
            font-style: italic;
            font-size: 8.5pt;
            text-align: center;
        }
        
        .grading-scale-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        
        .grading-scale-table td {
            border: 1px solid #ccc;
            padding: 2px 4px;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
        }
        
        /* Print styles */
        @media print {
            @page {
                size: letter portrait;
                margin: 0.25in;
            }
            
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            aside,
            nav,
            .sidebar,
            [class*="sidebar"],
            #sidebar,
            .no-print,
            .mobile-toggle {
                display: none !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
            }
            
            main {
                margin-left: 0 !important;
                padding-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            
            .sf9-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
                page-break-inside: avoid;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen"
      x-data="{ 
          sidebarCollapsed: false, 
          mobileOpen: false,
          init() {
              this.handleResize();
              window.addEventListener('resize', () => this.handleResize());
          },
          handleResize() {
              if (window.innerWidth >= 1024) {
                  this.mobileOpen = false;
              } else {
                  // On small screens, sidebar is hidden by default (handled by sidebar component)
                  this.sidebarCollapsed = false;
              }
          }
      }"
      x-init="init()">

    <!-- Mobile Overlay - only shows when mobile menu is open -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden"
         style="display: none;">
    </div>

    <!-- Mobile Toggle Button -->
    <button @click="mobileOpen = !mobileOpen" 
            class="mobile-toggle fixed top-4 left-4 z-50 lg:hidden w-12 h-12 bg-white rounded-2xl shadow-lg shadow-slate-200/50 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:scale-105 hover:shadow-xl transition-all duration-200 border border-slate-100">
        <i class="fas fa-bars text-lg" x-show="!mobileOpen"></i>
        <i class="fas fa-times text-lg" x-show="mobileOpen"></i>
    </button>

    <!-- Sidebar - Pass the shared state to sidebar -->
    <div x-data="{ parentCollapsed: sidebarCollapsed, parentMobile: mobileOpen }" 
         @sidebar-collapse-change.window="sidebarCollapsed = $event.detail.collapsed">
        @include('student.includes.sidebar')
    </div>

    <!-- Main Content - Adjusts margin based on sidebar state -->
    <main class="min-h-screen transition-all duration-300 ease-out p-4 lg:p-6"
          :class="{ 
              'lg:ml-20': sidebarCollapsed, 
              'lg:ml-72': !sidebarCollapsed,
              'ml-0': true
          }">

        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between no-print max-w-[8.5in] mx-auto">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-900 flex items-center justify-center text-white">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        My Report Card (SF9)
                        <p class="text-sm font-normal text-gray-500 mt-0">Learner's Progress Report Card</p>
                    </div>
                </h1>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-lg bg-blue-50 border border-blue-200 text-blue-900 text-sm font-semibold flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $schoolYear }}
                </div>
            </div>
        </div>

        @php
            $user = $student->user;
            $section = $student->section;
            $gradeLevel = $section->gradeLevel ?? null;
            
            $age = '';
            if ($user->date_of_birth) {
                $birth = \Carbon\Carbon::parse($user->date_of_birth);
                $age = $birth->age;
            } elseif ($student->age) {
                $age = $student->age;
            }
        @endphp

        <!-- Quick Stats -->
        <div class="stats-grid no-print max-w-[8.5in] mx-auto">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Subjects</p>
                    <p class="text-xl font-bold text-gray-800">{{ $subjectGrades->count() }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Passed</p>
                    <p class="text-xl font-bold text-green-700">{{ $subjectGrades->where('remarks', 'Passed')->count() }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">General Average</p>
                    <p class="text-xl font-bold text-purple-700">{{ $generalAverage ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Attendance Rate</p>
                    <p class="text-xl font-bold text-amber-700">{{ $attendanceRate ?? 0 }}%</p>
                </div>
            </div>
        </div>

        <!-- OFFICIAL SF9 REPORT CARD -->
        <div class="sf9-container bg-white">
            
            <!-- Header Section -->
            <div class="header-box">
                <div class="text-center">
                    <p class="text-xs font-normal mb-1">Republic of the Philippines</p>
                    <p class="text-sm font-bold uppercase tracking-wide border-b border-black pb-1 mb-1 inline-block">Department of Education</p>
                    <div class="flex justify-center gap-8 mt-2 text-xs">
                        <span>Region <span class="underline-field">{{ $schoolRegion ?? '__' }}</span></span>
                        <span>Division of <span class="underline-field">{{ $schoolDivision ?? '____________________' }}</span></span>
                        <span>District <span class="underline-field">{{ $schoolDistrict ?? '__________' }}</span></span>
                    </div>
                    <p class="text-base font-bold mt-2 uppercase tracking-wide">{{ $schoolName ?? 'TUGAWE ELEMENTARY SCHOOL' }}</p>
                    <p class="text-lg font-bold mt-2 uppercase tracking-widest border-t-2 border-b-2 border-black inline-block px-6 py-1">
                        Learner's Progress Report Card
                    </p>
                    <p class="text-xs mt-2 font-bold">School Year <span class="underline-field">{{ $schoolYear }}</span></p>
                </div>
            </div>

            <!-- Student Information -->
            <div class="section-header">Learner's Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">LRN:</span>
                    <span class="info-value" style="width: 140px;">{{ $student->lrn ?? '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age:</span>
                    <span class="info-value">{{ floor($age) }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">Sex:</span>
                    <span class="info-value" style="width: 140px;">{{ $student->gender ?? '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Grade Level:</span>
                    <span class="info-value">{{ $gradeLevel->name ?? '' }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">Section:</span>
                    <span class="info-value" style="width: 140px;">{{ $section->name ?? '' }}</span>
                </div>
            </div>

            <!-- Report on Learning Progress -->
            <div class="section-header">Report on Learning Progress and Achievement</div>
            
            <table class="sf9-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 32%; text-align: left; padding-left: 8px;">Learning Areas</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th rowspan="2" style="width: 12%;">Final Rating</th>
                        <th rowspan="2" style="width: 12%;">Remarks</th>
                    </tr>
                    <tr>
                        <th style="width: 9%;">1st</th>
                        <th style="width: 9%;">2nd</th>
                        <th style="width: 9%;">3rd</th>
                        <th style="width: 9%;">4th</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjectGrades as $subjectGrade)
                    <tr>
                        <td class="text-left pl-2 text-sm" style="font-size: 9pt;">{{ $subjectGrade['subject_name'] }}</td>
                        <td>{{ $subjectGrade['quarter_1'] ?: '' }}</td>
                        <td>{{ $subjectGrade['quarter_2'] ?: '' }}</td>
                        <td>{{ $subjectGrade['quarter_3'] ?: '' }}</td>
                        <td>{{ $subjectGrade['quarter_4'] ?: '' }}</td>
                        <td class="font-bold {{ $subjectGrade['final_grade'] >= 75 ? '' : 'grade-failed' }}">
                            {{ $subjectGrade['final_grade'] ?: '' }}
                        </td>
                        <td class="{{ $subjectGrade['remarks'] == 'Failed' ? 'grade-failed' : '' }}">
                            {{ $subjectGrade['remarks'] ?: '' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-gray-500 text-center">
                            No subjects found for your grade level.
                        </td>
                    </tr>
                    @endforelse

                    @if($generalAverage !== null)
                    <tr style="background: #f3f4f6; font-weight: bold;">
                        <td colspan="5" class="text-right pr-4" style="font-size: 9pt;">GENERAL AVERAGE</td>
                        <td class="{{ $generalAverage >= 75 ? '' : 'grade-failed' }}">{{ $generalAverage }}</td>
                        <td class="{{ $generalAverage >= 75 ? '' : 'grade-failed' }}">
                            {{ $generalAverage >= 75 ? 'Passed' : 'Failed' }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Descriptors and Grading Scale -->
            <div class="two-column">
                <div class="border border-black p-2">
                    <h4 class="font-bold text-xs mb-2 uppercase text-center border-b border-black pb-1">Descriptors & Grading Scale</h4>
                    <table class="grading-scale-table">
                        <tbody>
                            <tr>
                                <td class="text-left">Outstanding</td>
                                <td class="text-center font-bold">90-100</td>
                                <td class="text-center">Passed</td>
                            </tr>
                            <tr>
                                <td class="text-left">Very Satisfactory</td>
                                <td class="text-center font-bold">85-89</td>
                                <td class="text-center">Passed</td>
                            </tr>
                            <tr>
                                <td class="text-left">Satisfactory</td>
                                <td class="text-center font-bold">80-84</td>
                                <td class="text-center">Passed</td>
                            </tr>
                            <tr>
                                <td class="text-left">Fairly Satisfactory</td>
                                <td class="text-center font-bold">75-79</td>
                                <td class="text-center">Passed</td>
                            </tr>
                            <tr>
                                <td class="text-left">Did Not Meet Expectations</td>
                                <td class="text-center font-bold">Below 75</td>
                                <td class="text-center font-bold">Failed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="border border-black p-2 flex flex-col justify-center">
                    <p class="text-xs italic text-center leading-relaxed">
                        "This report card shows the ability and progress your child has made in different learning areas as well as their growth in core values. The school welcomes you should you desire to know more about your child's progress."
                    </p>
                </div>
            </div>

            <!-- Core Values -->
            <div class="section-header">Report on Learner's Observed Values</div>

            @php
            $coreValueOrder = ['Maka-Diyos', 'Makatao', 'Maka-Kalikasan', 'Maka-bansa'];
            $sortedCoreValues = collect($coreValueOrder)->mapWithKeys(function($cv) use ($coreValues) {
                return $coreValues->has($cv) ? [$cv => $coreValues[$cv]] : [];
            });
            foreach ($coreValues as $cv => $statements) {
                if (!in_array($cv, $coreValueOrder)) {
                    $sortedCoreValues[$cv] = $statements;
                }
            }
            $getCoreValueRating = function($coreValue, $statementKey, $quarter) use ($sortedCoreValues) {
                $cvData = $sortedCoreValues->get($coreValue);
                if (!$cvData) return '';
                $statementData = $cvData->get($statementKey);
                if (!$statementData) return '';
                $record = $statementData->firstWhere('quarter', $quarter);
                return $record ? $record->rating : '';
            };
            $getBehaviorStatement = function($coreValue, $statementKey) use ($sortedCoreValues) {
                $cvData = $sortedCoreValues->get($coreValue);
                if (!$cvData) return '';
                $statementData = $cvData->get($statementKey);
                if (!$statementData || $statementData->isEmpty()) return '';
                return $statementData->first()->behavior_statement ?? '';
            };
            @endphp

            <table class="sf9-table core-values-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 12%; text-align: left;">Core Values</th>
                        <th rowspan="2" style="width: 55%; text-align: left;">Behavior Statements</th>
                        <th colspan="4" style="text-align: center;">Quarter</th>
                    </tr>
                    <tr>
                        <th style="width: 8%;">1st</th>
                        <th style="width: 8%;">2nd</th>
                        <th style="width: 8%;">3rd</th>
                        <th style="width: 8%;">4th</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowIndex = 0; $coreValueNumber = 1; @endphp
                    @foreach($sortedCoreValues as $coreValue => $statements)
                        @php
                        $statementKeys = $statements->keys()->sort()->values();
                        $behaviorCount = $statementKeys->count();
                        @endphp
                        @foreach($statementKeys as $index => $statementKey)
                            <tr @if($rowIndex % 2 == 1) style="background: #f9fafb;" @endif>
                                @if($index === 0)
                                    <td rowspan="{{ $behaviorCount }}" class="font-bold align-top bg-gray-50" style="font-size: 8.5pt; text-align: left; vertical-align: top;">
                                        {{ $coreValueNumber }}. {{ $coreValue }}
                                    </td>
                                @endif
                                <td style="font-size: 8.5pt; text-align: left;">
                                    {{ $getBehaviorStatement($coreValue, $statementKey) }}
                                </td>
                                <td style="text-align: center; font-weight: bold;">
                                    {{ $getCoreValueRating($coreValue, $statementKey, 1) }}
                                </td>
                                <td style="text-align: center; font-weight: bold;">
                                    {{ $getCoreValueRating($coreValue, $statementKey, 2) }}
                                </td>
                                <td style="text-align: center; font-weight: bold;">
                                    {{ $getCoreValueRating($coreValue, $statementKey, 3) }}
                                </td>
                                <td style="text-align: center; font-weight: bold;">
                                    {{ $getCoreValueRating($coreValue, $statementKey, 4) }}
                                </td>
                            </tr>
                            @php $rowIndex++; @endphp
                        @endforeach
                        @php $coreValueNumber++; @endphp
                    @endforeach
                    @if($sortedCoreValues->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                No core values records found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="marking-box">
                <span class="font-bold text-xs">Marking:</span>
                <span class="text-xs ml-2"><strong>AO</strong> - Always Observed</span>
                <span class="text-xs ml-2"><strong>SO</strong> - Sometimes Observed</span>
                <span class="text-xs ml-2"><strong>RO</strong> - Rarely Observed</span>
                <span class="text-xs ml-2"><strong>NO</strong> - Not Observed</span>
            </div>

            <!-- Attendance -->
            <div class="section-header">Report on Attendance</div>
            
            @php
                $months = ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR', 'MAY'];
                $attendanceData = [];
                $totalPresent = $totalAbsent = $totalLate = $totalSchoolDays = 0;
                
                foreach ($months as $month) {
                    $monthAttendances = $attendances->filter(function($a) use ($month) {
                        return strtoupper(date('M', strtotime($a->date))) === $month;
                    });
                    $present = $monthAttendances->where('status', 'present')->count();
                    $absent = $monthAttendances->where('status', 'absent')->count();
                    $late = $monthAttendances->where('status', 'late')->count();
                    $schoolDays = $present + $absent + $late;
                    $attendanceData[$month] = [
                        'days' => $schoolDays > 0 ? $schoolDays : '',
                        'present' => $present > 0 ? $present : '',
                        'absent' => $absent > 0 ? $absent : '',
                        'late' => $late > 0 ? $late : ''
                    ];
                    $totalPresent += $present;
                    $totalAbsent += $absent;
                    $totalLate += $late;
                    $totalSchoolDays += $schoolDays;
                }
            @endphp

            <table class="sf9-table attendance-table">
                <thead>
                    <tr>
                        <th class="text-left pl-2" style="width: 20%;">Month</th>
                        @foreach($months as $month)
                            <th style="width: 6%;">{{ $month }}</th>
                        @endforeach
                        <th style="width: 8%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">No. of School Days</td>
                        @foreach($months as $month)
                            <td>{{ $attendanceData[$month]['days'] }}</td>
                        @endforeach
                        <td class="font-bold">{{ $totalSchoolDays > 0 ? $totalSchoolDays : '' }}</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">No. of Days Present</td>
                        @foreach($months as $month)
                            <td>{{ $attendanceData[$month]['present'] }}</td>
                        @endforeach
                        <td class="font-bold">{{ $totalPresent > 0 ? $totalPresent : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">No. of Days Absent</td>
                        @foreach($months as $month)
                            <td>{{ $attendanceData[$month]['absent'] }}</td>
                        @endforeach
                        <td class="font-bold">{{ $totalAbsent > 0 ? $totalAbsent : '' }}</td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">No. of Times Tardy</td>
                        @foreach($months as $month)
                            <td>{{ $attendanceData[$month]['late'] }}</td>
                        @endforeach
                        <td class="font-bold">{{ $totalLate > 0 ? $totalLate : '' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Parent Signature -->
            <div class="parent-sig-box">
                <h4 class="font-bold text-xs mb-2 uppercase">Parent/Guardian's Signature</h4>
                <div class="parent-sig-grid">
                    @foreach(['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'] as $quarter)
                    <div class="text-center">
                        <div class="sig-line"></div>
                        <span class="text-xs text-gray-700 font-semibold">{{ $quarter }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Signatures -->
            <div class="grid grid-cols-2 gap-8 mt-6 px-8">
                <div class="text-center">
                    <div class="signature-line w-56 mx-auto">
                        <p class="font-bold text-sm uppercase">{{ $adviserName ?? '_________________' }}</p>
                        <p class="text-xs text-gray-700 font-semibold">Class Adviser</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="signature-line w-56 mx-auto">
                        <p class="font-bold text-sm uppercase">{{ $schoolHead ?? '_________________' }}</p>
                        <p class="text-xs text-gray-700 font-semibold">School Head</p>
                    </div>
                </div>
            </div>

            <!-- Certificate of Transfer -->
            <div class="certificate-box">
                <h3 class="text-xs font-bold mb-2 uppercase border-b border-black pb-1">Certificate of Transfer</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-2">
                        <span>Admitted to Grade:</span>
                        <span class="underline-field flex-1"></span>
                        <span>Section:</span>
                        <span class="underline-field w-32"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Eligible for Admission to Grade:</span>
                        <span class="underline-field flex-1"></span>
                    </div>
                    <div class="flex justify-end mt-3">
                        <div class="text-center">
                            <div class="border-t border-black pt-1 w-48">
                                <p class="font-bold text-xs uppercase">{{ $schoolHead ?? '_________________' }}</p>
                                <p class="text-xs text-gray-700">School Head</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancellation -->
            <div class="certificate-box" style="margin-top: 8px;">
                <h3 class="text-xs font-bold mb-2 uppercase border-b border-black pb-1">Cancellation of Eligibility to Transfer</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-2">
                        <span>Admitted in:</span>
                        <span class="underline-field flex-1"></span>
                        <span>Date:</span>
                        <span class="underline-field w-32"></span>
                    </div>
                    <div class="flex justify-end">
                        <div class="text-center">
                            <div class="border-t border-black pt-1 w-48">
                                <p class="text-xs text-gray-700">Principal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sf9-footer">
                <p class="font-bold text-xs">DepEd School Form 9 (SF9) | Page 1 of 1</p>
                <p class="text-gray-600 mt-1" style="font-size: 7pt;">Generated: {{ now()->format('F d, Y h:i A') }}</p>
            </div>

        </div>

    </main>

    <!-- Floating Print Button -->
    <button onclick="window.print()" class="no-print print-btn text-white hover:bg-blue-800 transition-colors">
        <i class="fas fa-print text-xl"></i>
    </button>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</body>
</html>