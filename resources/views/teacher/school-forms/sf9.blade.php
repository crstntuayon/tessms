<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Form 9 (SF9) - Learner's Progress Report Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f3f4f6;
        }
        
        /* Official DepEd SF9 Container - Standard Letter Size with border for screen only */
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
        
        /* Official Table Styling - Black borders only */
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
            text-transform: none;
        }
        
        /* Official Header Box */
        .header-box {
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
            background: #fff;
            margin-bottom: 0;
        }
        
        /* Print Button - Floating */
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
        
        /* Section Headers - Simple uppercase */
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
        
        /* Info Grid - Traditional form layout */
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
        
        /* Grade styling - Official colors */
        .grade-passed {
            color: #000;
            font-weight: normal;
        }
        
        .grade-failed {
            color: #000;
            font-weight: bold;
        }
        
        /* Underline fields for signatures */
        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            font-weight: bold;
        }
        
        /* Core values table */
        .core-values-table td {
            font-size: 8.5pt;
            text-align: left;
            padding: 3px 6px;
        }
        
        /* Attendance table */
        .attendance-table td {
            font-size: 8.5pt;
            padding: 3px 4px;
        }
        
        /* Student selector - Clean UI */
        .student-selector-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #d1d5db;
        }
        
        /* Print styles - Exact DepEd format, NO container border */
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
            
            /* Hide sidebar completely */
            aside,
            nav,
            .sidebar,
            [class*="sidebar"],
            #sidebar,
            .no-print {
                display: none !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
                position: absolute !important;
                left: -9999px !important;
            }
            
            /* Reset main content margins */
            .ml-72,
            [class*="ml-"],
            main,
            .main-content,
            #main-content {
                margin-left: 0 !important;
                padding-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            
            /* Container adjustments - NO BORDER when printing */
            .sf9-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important; /* REMOVED black border */
                page-break-inside: avoid;
                box-sizing: border-box;
            }
            
            .sf9-table {
                font-size: 8.5pt !important;
                width: 100% !important;
            }
            
            .sf9-table th,
            .sf9-table td {
                padding: 2px 4px !important;
                border: 1px solid #000 !important;
            }
            
            .header-box {
                border: 2px solid #000 !important;
            }
            
            .section-header {
                border: 1px solid #000 !important;
                border-bottom: 2px solid #000 !important;
            }
            
            .info-grid {
                border: 1px solid #000 !important;
            }
            
            .info-label {
                border-right: 1px solid #000 !important;
            }
            
            .info-row {
                border-bottom: 1px solid #000 !important;
            }
            
            /* Ensure background colors print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        
        /* Stats cards - Subtle design */
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
        
        /* Marking legend */
        .marking-box {
            border: 1px solid #000;
            padding: 6px;
            font-size: 8pt;
            margin-top: 6px;
        }
        
        /* Signature lines */
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            padding-top: 4px;
            text-align: center;
        }
        
        /* Certificate section */
        .certificate-box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 12px;
        }
        
        /* Footer */
        .sf9-footer {
            border-top: 1px solid #000;
            padding-top: 6px;
            margin-top: 12px;
            font-size: 7.5pt;
            text-align: center;
        }
        
        /* Parent signature box */
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
        
        /* Adviser message box */
        .message-box {
            border: 1px solid #000;
            padding: 8px;
            margin-top: 8px;
            font-style: italic;
            font-size: 8.5pt;
            text-align: center;
        }
        
        /* Grading scale table */
        .grading-scale-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        
        .grading-scale-table td {
            border: 1px solid #ccc;
            padding: 2px 4px;
        }
        
        /* Core values marking */
        .marking-legend {
            display: flex;
            gap: 12px;
            font-size: 8pt;
            margin-top: 4px;
        }
        
        .marking-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Two column layout for bottom sections */
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen">

    <!-- Include Sidebar -->
    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <div class="ml-72 p-6 transition-all duration-300" id="main-content">
        
        <!-- Page Header - UI Only -->
        <div class="mb-6 flex items-center justify-between no-print">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-900 flex items-center justify-center text-white">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        School Form 9 (SF9)
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

        <!-- Student Selector -->
        <div class="no-print mb-6 student-selector-card">
            <form method="GET" action="{{ route('teacher.sf9') }}" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-user-graduate text-blue-800"></i>
                        Select Student
                    </label>
                    <select name="student_id" onchange="this.form.submit()" 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-gray-700 font-medium bg-gray-50">
                        <option value="">-- Select a Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $selectedStudent && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                {{ $student->user->last_name ?? '' }}, {{ $student->user->first_name ?? '' }} {{ $student->user->middle_name ?? '' }} 
                                - {{ $student->section->name ?? '' }} ({{ $student->section->gradeLevel->name ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition font-semibold shadow flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Load Report Card
                </button>
            </form>
        </div>

        @if(!$selectedStudent)
            <div class="bg-amber-50 border-2 border-amber-300 rounded-lg p-8 text-center no-print mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-amber-600 text-2xl"></i>
                </div>
                <h3 class="text-amber-800 font-bold text-lg mb-2">No Student Selected</h3>
                <p class="text-amber-700">Please select a student from the dropdown above to view their report card.</p>
            </div>
        @endif

        @if($selectedStudent)
        @php
            $user = $selectedStudent->user;
            $section = $selectedStudent->section;
            $gradeLevel = $section->gradeLevel ?? null;
            
            $age = '';
            if ($selectedStudent->birthdate) {
                $birth = \Carbon\Carbon::parse($selectedStudent->birthdate);
                $now = \Carbon\Carbon::now();
                $age = $birth->diffInYears($now);
            }
        @endphp

        <!-- Quick Stats -->
        <div class="stats-grid no-print">
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
                    <p class="text-xs text-gray-500 font-semibold uppercase">Attendance</p>
                    <p class="text-xl font-bold text-amber-700">{{ $attendances->where('status', 'present')->count() }} Days</p>
                </div>
            </div>
        </div>

        <!-- OFFICIAL SF9 REPORT CARD -->
        <div class="sf9-container bg-white">
            
            <!-- Header Section - Official DepEd Format -->
            <div class="header-box">
                <div class="text-center">
                    <p class="text-xs font-normal mb-1">Republic of the Philippines</p>
                    <p class="text-sm font-bold uppercase tracking-wide border-b border-black pb-1 mb-1 inline-block">Department of Education</p>
                    <div class="flex justify-center gap-8 mt-2 text-xs">
                        <span>Region <span class="underline-field">{{ $schoolRegion ?? '__' }}</span></span>
                        <span>Division of <span class="underline-field">{{ $schoolDivision ?? '____________________' }}</span></span>
                        <span>District <span class="underline-field">{{ $schoolDistrict ?? '__________' }}</span></span>
                    </div>
                    <p class="text-base font-bold mt-2 uppercase tracking-wide">{{ $schoolName ?? 'SCHOOL NAME' }}</p>
                    <p class="text-lg font-bold mt-2 uppercase tracking-widest border-t-2 border-b-2 border-black inline-block px-6 py-1">
                        Learner's Progress Report Card
                    </p>
                    <p class="text-xs mt-2 font-bold">School Year <span class="underline-field">{{ $schoolYear }}</span></p>
                </div>
            </div>

            <!-- Student Information -->
            <div class="section-header">
                Learner's Information
            </div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">LRN:</span>
                    <span class="info-value" style="width: 140px;">{{ $selectedStudent->lrn ?? '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age:</span>
                    <span class="info-value">{{ floor($age) }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">Sex:</span>
                    <span class="info-value" style="width: 140px;">{{ $selectedStudent->gender ?? '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Grade Level:</span>
                    <span class="info-value">{{ $gradeLevel->name ?? '' }}</span>
                    <span class="info-label" style="width: 80px; border-left: 1px solid #000;">Section:</span>
                    <span class="info-value" style="width: 140px;">{{ $section->name ?? '' }}</span>
                </div>
            </div>

            <!-- Report on Learning Progress and Achievement -->
            @if($isKindergarten)
                <!-- KINDERGARTEN: Developmental Domains -->
                <div class="section-header">
                    {{ $lang == 'cebuano' ? 'Report sa Kalambuan sa Bata' : 'Developmental Progress Report' }}
                </div>
                
                @php
                $kinderConfig = config('kindergarten.domains');
                $ratingScale = config('kindergarten.rating_scale');
                
                // Helper function to get rating for domain indicator
                $getKinderRating = function($domainKey, $indicatorKey, $quarter) use ($kindergartenDomains) {
                    $domainData = $kindergartenDomains->get($domainKey);
                    if (!$domainData) return '';
                    
                    $indicatorData = $domainData->get($indicatorKey);
                    if (!$indicatorData) return '';
                    
                    $record = $indicatorData->firstWhere('quarter', $quarter);
                    return $record ? $record->rating : '';
                };
                @endphp
                
                @foreach($kinderConfig as $domainKey => $domainData)
                <div class="border border-black mb-2">
                    <div class="bg-gray-100 p-2 border-b border-black" style="background-color: #f3f4f6;">
                        <strong style="font-size: 9pt; text-transform: uppercase;">{{ $domainData['name'][$lang] ?? $domainData['name']['cebuano'] }}</strong>
                    </div>
                    <table class="sf9-table" style="font-size: 8pt;">
                        <thead>
                            <tr style="background-color: #f9fafb;">
                                <th rowspan="2" style="width: 50%; text-align: left; padding-left: 8px; vertical-align: middle;">{{ $lang == 'cebuano' ? 'Mga Tigpasiunod (Indicators)' : 'Indicators' }}</th>
                                <th colspan="4" style="text-align: center; border-bottom: 1px solid #000;">{{ $lang == 'cebuano' ? 'Kwarto (Quarter)' : 'Quarter' }}</th>
                            </tr>
                            <tr style="background-color: #f9fafb;">
                                <th style="width: 12.5%; text-align: center;">1</th>
                                <th style="width: 12.5%; text-align: center;">2</th>
                                <th style="width: 12.5%; text-align: center;">3</th>
                                <th style="width: 12.5%; text-align: center;">4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($domainData['indicators']))
                                @foreach($domainData['indicators'] as $indicatorKey => $indicatorData)
                                <tr style="{{ $loop->even ? 'background-color: #f9fafb;' : '' }}">
                                    <td class="text-left pl-2" style="font-size: 7.5pt; text-align: justify; text-justify: inter-word; padding: 5px 8px; line-height: 1.4;">{{ $indicatorData[$lang] ?? $indicatorData['cebuano'] }}</td>
                                    <td class="font-bold" style="text-align: center; vertical-align: middle;">{{ $getKinderRating($domainKey, $indicatorKey, 1) }}</td>
                                    <td class="font-bold" style="text-align: center; vertical-align: middle;">{{ $getKinderRating($domainKey, $indicatorKey, 2) }}</td>
                                    <td class="font-bold" style="text-align: center; vertical-align: middle;">{{ $getKinderRating($domainKey, $indicatorKey, 3) }}</td>
                                    <td class="font-bold" style="text-align: center; vertical-align: middle;">{{ $getKinderRating($domainKey, $indicatorKey, 4) }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @endforeach
                
                <!-- Rating Scale for Kindergarten -->
                <div class="border border-black p-2 mb-3">
                    <h4 class="font-bold text-xs mb-2 uppercase text-center border-b border-black pb-1">{{ $lang == 'cebuano' ? 'Rating Scale / Suklanan sa Marka' : 'Rating Scale' }}</h4>
                    <table class="grading-scale-table">
                        <tbody>
                            <tr>
                                <td class="text-center font-bold" style="width: 15%;">B</td>
                                <td class="text-left"><strong>{{ $ratingScale['B']['label'][$lang] }} ({{ $ratingScale['B']['label']['cebuano'] }})</strong> - {{ $ratingScale['B']['description'][$lang] }}</td>
                            </tr>
                            <tr>
                                <td class="text-center font-bold">D</td>
                                <td class="text-left"><strong>{{ $ratingScale['D']['label'][$lang] }} ({{ $ratingScale['D']['label']['cebuano'] }})</strong> - {{ $ratingScale['D']['description'][$lang] }}</td>
                            </tr>
                            <tr>
                                <td class="text-center font-bold">C</td>
                                <td class="text-left"><strong>{{ $ratingScale['C']['label'][$lang] }} ({{ $ratingScale['C']['label']['cebuano'] }})</strong> - {{ $ratingScale['C']['description'][$lang] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Teacher's Remarks Section for Kindergarten -->
                <div class="section-header">
                    {{ $lang == 'cebuano' ? 'Pasabot sa Magtutudlo (Teacher\'s Comments/Remarks)' : 'Teacher\'s Comments/Remarks' }}
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <div class="border border-black p-2">
                        <p class="text-xs font-bold text-center border-b border-black pb-1 mb-2">{{ $lang == 'cebuano' ? 'First Quarter (Semana 1-10)' : 'First Quarter (Weeks 1-10)' }}</p>
                        <div class="h-20 border-b border-black mb-1"></div>
                        <p class="text-xs text-center">{{ $lang == 'cebuano' ? 'Pirma sa Ginikanan / Guardian\'s Signature' : 'Guardian\'s Signature' }}</p>
                    </div>
                    <div class="border border-black p-2">
                        <p class="text-xs font-bold text-center border-b border-black pb-1 mb-2">{{ $lang == 'cebuano' ? 'Second Quarter (Semana 11-20)' : 'Second Quarter (Weeks 11-20)' }}</p>
                        <div class="h-20 border-b border-black mb-1"></div>
                        <p class="text-xs text-center">{{ $lang == 'cebuano' ? 'Pirma sa Ginikanan / Guardian\'s Signature' : 'Guardian\'s Signature' }}</p>
                    </div>
                    <div class="border border-black p-2">
                        <p class="text-xs font-bold text-center border-b border-black pb-1 mb-2">{{ $lang == 'cebuano' ? 'Third Quarter (Semana 21-30)' : 'Third Quarter (Weeks 21-30)' }}</p>
                        <div class="h-20 border-b border-black mb-1"></div>
                        <p class="text-xs text-center">{{ $lang == 'cebuano' ? 'Pirma sa Ginikanan / Guardian\'s Signature' : 'Guardian\'s Signature' }}</p>
                    </div>
                    <div class="border border-black p-2">
                        <p class="text-xs font-bold text-center border-b border-black pb-1 mb-2">{{ $lang == 'cebuano' ? 'Fourth Quarter (Semana 31-40)' : 'Fourth Quarter (Weeks 31-40)' }}</p>
                        <div class="h-20 border-b border-black mb-1"></div>
                        <p class="text-xs text-center">{{ $lang == 'cebuano' ? 'Pirma sa Ginikanan / Guardian\'s Signature' : 'Guardian\'s Signature' }}</p>
                    </div>
                </div>
                
                <!-- Certification for Kindergarten -->
                <div class="border border-black p-3 mb-3">
                    <p class="text-xs leading-relaxed">
                        @if($lang == 'cebuano')
                            Gipasabot niini nga si <strong class="underline">{{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? '' }}</strong> 
                            sa <strong>{{ $section->name ?? '' }}</strong> niini nga tulunghaan, nakalampos sa Kindergarten Curriculum Guide.
                        @else
                            This certifies that <strong class="underline">{{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? '' }}</strong> 
                            of <strong>{{ $section->name ?? '' }}</strong> has completed the Kindergarten Curriculum Guide.
                        @endif
                    </p>
                    <div class="mt-4 flex justify-between">
                        <div class="text-center">
                            <div class="border-t border-black pt-1 w-48">
                                <p class="font-bold uppercase text-xs">{{ $adviserName ?? '_________________' }}</p>
                                <p class="text-xs">{{ $lang == 'cebuano' ? 'Magtutudlo / Teacher' : 'Teacher' }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="border-t border-black pt-1 w-48">
                                <p class="font-bold uppercase text-xs">{{ $schoolHead ?? '_________________' }}</p>
                                <p class="text-xs">{{ $lang == 'cebuano' ? 'Principal / School Head' : 'School Head' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- GRADES 1-6: Regular Subject Grades -->
                <div class="section-header">
                    Report on Learning Progress and Achievement
                </div>
                
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
                                No subjects found for this grade level.
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
            @endif

       <!-- Report on Learner's Observed Values -->
<div class="section-header">
    Report on Learner's Observed Values
</div>

@php
// Get unique core values and their statement keys from the database records
$coreValueGroups = $coreValues->map(function($statements) {
    return $statements->keys()->sort()->values();
})->sortKeys();

// Define the proper ordering of core values
$coreValueOrder = ['Maka-Diyos', 'Makatao', 'Maka-Kalikasan', 'Maka-bansa'];

// Reorder according to standard
$sortedCoreValues = collect($coreValueOrder)->mapWithKeys(function($cv) use ($coreValues) {
    return $coreValues->has($cv) ? [$cv => $coreValues[$cv]] : [];
});

// Add any other core values not in standard order
foreach ($coreValues as $cv => $statements) {
    if (!in_array($cv, $coreValueOrder)) {
        $sortedCoreValues[$cv] = $statements;
    }
}

// Helper function to get rating for specific core value, statement_key, and quarter
$getCoreValueRating = function($coreValue, $statementKey, $quarter) use ($sortedCoreValues) {
    $cvData = $sortedCoreValues->get($coreValue);
    if (!$cvData) return '';
    
    $statementData = $cvData->get($statementKey);
    if (!$statementData) return '';
    
    $record = $statementData->firstWhere('quarter', $quarter);
    return $record ? $record->rating : '';
};

// Helper function to get behavior statement text
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
            <th rowspan="2" style="width: 12%; text-align: left; vertical-align: middle;">Core Values</th>
            <th rowspan="2" style="width: 55%; text-align: left; vertical-align: middle;">Behavior Statements</th>
            <th colspan="4" style="text-align: center;">Quarter</th>
        </tr>
        <tr>
            <th style="width: 8%; text-align: center; vertical-align: middle;">1st</th>
            <th style="width: 8%; text-align: center; vertical-align: middle;">2nd</th>
            <th style="width: 8%; text-align: center; vertical-align: middle;">3rd</th>
            <th style="width: 8%; text-align: center; vertical-align: middle;">4th</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $rowIndex = 0;
        $coreValueNumber = 1;
        @endphp
        
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
                    <td style="font-size: 8.5pt; text-align: left; vertical-align: middle;">
                        {{ $getBehaviorStatement($coreValue, $statementKey) }}
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: bold;">
                        {{ $getCoreValueRating($coreValue, $statementKey, 1) }}
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: bold;">
                        {{ $getCoreValueRating($coreValue, $statementKey, 2) }}
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: bold;">
                        {{ $getCoreValueRating($coreValue, $statementKey, 3) }}
                    </td>
                    <td style="text-align: center; vertical-align: middle; font-weight: bold;">
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
                    No core values records found for this student.
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



            <!-- Attendance Record -->
            <div class="section-header">
                @if($isKindergarten)
                    {{ $lang == 'cebuano' ? 'Rekord sa Pag-anhi (Attendance Record)' : 'Attendance Record' }}
                @else
                    Report on Attendance
                @endif
            </div>
            
            @if($isKindergarten)
                @php
                    // Kindergarten now uses monthly attendance like Grades 1-6
                    $months = ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR', 'MAY'];
                    $attendanceData = [];
                    $totalPresent = 0;
                    $totalAbsent = 0;
                    $totalLate = 0;
                    $totalSchoolDays = 0;
                    
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
                            <th class="text-left pl-2" style="width: 20%;">{{ $lang == 'cebuano' ? 'Bulan / Month' : 'Month' }}</th>
                            @foreach($months as $month)
                                <th style="width: 6%;">{{ $month }}</th>
                            @endforeach
                            <th style="width: 8%;">{{ $lang == 'cebuano' ? 'Total' : 'Total' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">{{ $lang == 'cebuano' ? 'Adlaw sa Eskwelahan / No. of School Days' : 'No. of School Days' }}</td>
                            @foreach($months as $month)
                                <td>{{ $attendanceData[$month]['days'] }}</td>
                            @endforeach
                            <td class="font-bold">{{ $totalSchoolDays > 0 ? $totalSchoolDays : '' }}</td>
                        </tr>
                        <tr style="background: #f9fafb;">
                            <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">{{ $lang == 'cebuano' ? 'Adlaw nga Mi-anhi / No. of Days Present' : 'No. of Days Present' }}</td>
                            @foreach($months as $month)
                                <td>{{ $attendanceData[$month]['present'] }}</td>
                            @endforeach
                            <td class="font-bold">{{ $totalPresent > 0 ? $totalPresent : '' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">{{ $lang == 'cebuano' ? 'Adlaw nga Wala / No. of Days Absent' : 'No. of Days Absent' }}</td>
                            @foreach($months as $month)
                                <td>{{ $attendanceData[$month]['absent'] }}</td>
                            @endforeach
                            <td class="font-bold">{{ $totalAbsent > 0 ? $totalAbsent : '' }}</td>
                        </tr>
                        <tr style="background: #f9fafb;">
                            <td class="text-left font-bold pl-2" style="font-size: 8.5pt;">{{ $lang == 'cebuano' ? 'Adlaw nga Niulahi / No. of Times Tardy' : 'No. of Times Tardy' }}</td>
                            @foreach($months as $month)
                                <td>{{ $attendanceData[$month]['late'] }}</td>
                            @endforeach
                            <td class="font-bold">{{ $totalLate > 0 ? $totalLate : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                @php
                    $months = ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR', 'MAY'];
                    $attendanceData = [];
                    $totalPresent = 0;
                    $totalAbsent = 0;
                    $totalLate = 0;
                    $totalSchoolDays = 0;
                    
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
            @endif

            @if(!$isKindergarten)
            <!-- Parent/Guardian Signature -->
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

            <!-- Cancellation of Eligibility -->
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
            @endif

            <!-- Footer -->
            <div class="sf9-footer">
                <p class="font-bold text-xs">DepEd School Form 9 (SF9) | Page 1 of 1</p>
                <p class="text-gray-600 mt-1" style="font-size: 7pt;">Generated: {{ now()->format('F d, Y h:i A') }}</p>
            </div>

        </div>
        @endif

    </div>

    <!-- Floating Print Button -->
    <button onclick="window.print()" class="no-print print-btn text-white hover:bg-blue-800 transition-colors">
        <i class="fas fa-print text-xl"></i>
    </button>

</body>
</html>