<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Form 10 (SF10-ES) - Learner's Permanent Academic Record</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f1f5f9;
        }
        
        .sf10-container {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 2px solid #000;
            padding: 0.3in;
            position: relative;
            box-sizing: border-box;
        }
        
        .sf10-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 9px;
        }
        
        .sf10-table th,
        .sf10-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .sf10-table th {
            background-color: #f3f4f6;
            font-weight: 600;
            font-size: 8px;
        }
        
        .header-box {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            background: #fff;
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
        }
        
        /* Print styles - Match SF9 */
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
            
            /* Hide sidebars */
            aside,
            nav,
            .sidebar,
            [class*="sidebar"],
            #sidebar,
            .no-print,
            .fixed.w-72,
            .fixed[class*="w-72"],
            [x-show*="mobileOpen"],
            .lg\:translate-x-0,
            .backdrop-blur-xl {
                display: none !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
                position: absolute !important;
                left: -9999px !important;
            }
            
            /* Reset main content */
            .ml-72, [class*="ml-72"],
            [class*="ml-"],
            main,
            .main-content,
            #main-content {
                margin-left: 0 !important;
                padding-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            
            /* Container - NO border/padding when printing */
            .sf10-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
                min-height: auto !important;
            }
            
            /* Fix two-column layout */
            .flex.gap-6 {
                display: block !important;
            }
            
            .flex.gap-6 > div:last-child {
                display: none !important;
            }
            
            .flex-1 {
                width: 100% !important;
                max-width: 100% !important;
                flex: none !important;
            }
            
            /* Fix all borders to 1px */
            .border-2, .border-b-2, .border-t-2 {
                border-width: 1px !important;
            }
            
            /* Tables - prevent overflow */
            .sf10-table {
                font-size: 7.5pt !important;
                table-layout: fixed !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow: hidden !important;
            }
            
            .sf10-table th,
            .sf10-table td {
                padding: 2px 3px !important;
                border: 1px solid #000 !important;
                word-wrap: break-word !important;
                overflow-wrap: break-word !important;
            }
            
            /* Prevent horizontal overflow */
            * {
                max-width: 100% !important;
                box-sizing: border-box !important;
            }
            
            /* Fix grid layouts */
            .grid {
                display: block !important;
            }
            
            .grid > * {
                width: 100% !important;
                margin-bottom: 2px !important;
            }
            
            /* Fix flex layouts */
            .flex {
                display: block !important;
            }
            
            .flex > * {
                width: 100% !important;
            }
            
            /* Ensure sections don't overflow */
            .border-2, .border, .border-black, [class*="border-"] {
                box-sizing: border-box !important;
                max-width: 100% !important;
            }
            
            /* Fix underline fields */
            .underline-field {
                min-width: 20px !important;
                max-width: 100% !important;
            }
            
            /* Fix school info header - stack vertically */
            .scholastic-record .bg-gray-100 .flex {
                display: block !important;
            }
            
            .scholastic-record .bg-gray-100 .flex span {
                display: inline !important;
                font-size: 6.5pt !important;
            }
            
            /* Fix col-span layouts */
            .col-span-1, .col-span-5, .col-span-6 {
                grid-column: span 12 !important;
                width: 100% !important;
                display: block !important;
            }
            
            /* Force all content to fit */
            html, body {
                width: 100% !important;
                overflow-x: hidden !important;
            }
            
            /* Fix learner information grid - organize for printing */
            /* Names on left (rows 1-3), Other info on right (rows 1-3) */
            .grid.grid-cols-2 {
                display: grid !important;
                grid-template-columns: 1.2fr 1fr !important;
                grid-template-rows: repeat(3, auto) !important;
                gap: 4px 16px !important;
            }
            
            /* Row 1: Last Name | LRN */
            .grid.grid-cols-2 > div:nth-child(1) { grid-row: 1; grid-column: 1; }
            .grid.grid-cols-2 > div:nth-child(2) { grid-row: 1; grid-column: 2; }
            
            /* Row 2: First Name | Birthdate */
            .grid.grid-cols-2 > div:nth-child(3) { grid-row: 2; grid-column: 1; }
            .grid.grid-cols-2 > div:nth-child(4) { grid-row: 2; grid-column: 2; }
            
            /* Row 3: Middle Name | Sex */
            .grid.grid-cols-2 > div:nth-child(5) { grid-row: 3; grid-column: 1; }
            .grid.grid-cols-2 > div:nth-child(6) { grid-row: 3; grid-column: 2; }
            
            .grid.grid-cols-2 > div {
                display: flex !important;
                align-items: center !important;
                margin-bottom: 0 !important;
                padding: 2px 0 !important;
            }
            
            .grid.grid-cols-2 > div > span:first-child {
                width: auto !important;
                white-space: nowrap !important;
                font-size: 7.5pt !important;
            }
            
            .grid.grid-cols-2 > div > span:last-child {
                font-size: 8pt !important;
                font-weight: bold !important;
            }
            
            /* Reduce font sizes */
            .text-\[10px\] {
                font-size: 8pt !important;
            }
            
            .text-\[11px\] {
                font-size: 8pt !important;
            }
            
            /* Reduce padding */
            .p-2 {
                padding: 2px !important;
            }
            
            .p-3 {
                padding: 3px !important;
            }
            
            .section-header {
                padding: 2px 4px !important;
                font-size: 8pt !important;
            }
            
            /* Make learner info box more compact */
            .border-2.border-black.p-2 {
                padding: 4px !important;
            }
            
            /* Scholastic records */
            .scholastic-record {
                margin-bottom: 6px !important;
                border: 1px solid #000 !important;
                page-break-inside: auto;
            }
            
            /* Background colors */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Fix text overflow in eligibility section */
            .text-\[9px\] {
                font-size: 7pt !important;
            }
            
            /* Make eligibility section grid single column */
            .grid.grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
            
            /* Tighten checkbox row */
            .flex.gap-6.ml-4 {
                flex-wrap: wrap !important;
                gap: 0.25rem !important;
            }
            
            /* Reduce checkbox size */
            .checkbox {
                width: 8px !important;
                height: 8px !important;
            }
            
            .space-y-2 > * + * {
                margin-top: 1px !important;
            }
            
            .gap-6 {
                gap: 0.5rem !important;
            }
            
            .gap-4 {
                gap: 0.25rem !important;
            }
            
            .gap-2 {
                gap: 0.125rem !important;
            }
            
            .ml-4 {
                margin-left: 0.5rem !important;
            }
            
            .mt-1, .mt-2, .mt-3 {
                margin-top: 0.125rem !important;
            }
            
            .mb-3 {
                margin-bottom: 0.25rem !important;
            }
            
            .p-2 {
                padding: 0.25rem !important;
            }
        }
        
        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 60px;
            font-weight: 600;
        }
        
        .scholastic-record {
            margin-bottom: 10px;
            border: 1px solid #000;
        }
        
        .section-header {
            background: #1e3a8a;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            display: inline-block;
        }
        
        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
            margin-right: 4px;
        }
    </style>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-100 min-h-screen" x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">

    <!-- Mobile Hamburger -->
    <button @click="mobileOpen = !mobileOpen" 
            class="fixed top-4 left-4 z-50 lg:hidden w-10 h-10 bg-white rounded-lg shadow-md flex items-center justify-center text-slate-600 hover:text-indigo-600 transition-all">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 z-40 lg:hidden bg-slate-900/30 backdrop-blur-sm"
         style="display: none;"></div>

    <!-- Include Sidebar -->
    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-72 p-6" id="main-content">
        
        <!-- Page Header -->
        <div class="mb-4 flex items-center justify-between no-print">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">School Form 10 (SF10-ES)</h1>
                <p class="text-slate-500">Learner's Permanent Academic Record</p>
            </div>
            <div class="px-4 py-2 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-sm font-medium">
                <i class="fas fa-calendar-alt mr-2"></i>{{ $schoolYear }}
            </div>
        </div>

        @if(!$selectedStudent)
        <!-- Student Selector - Shows only when no student selected -->
        <div class="no-print mb-4 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <form method="GET" action="{{ route('teacher.sf10') }}" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Student</label>
                    <select name="student_id" onchange="this.form.submit()" 
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->user->last_name ?? '' }}, {{ $student->user->first_name ?? '' }} {{ $student->user->middle_name ?? '' }} ({{ $student->lrn ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Load Permanent Record
                </button>
            </form>
        </div>
        @endif

        @if(!$selectedStudent)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center no-print mb-4">
                <i class="fas fa-exclamation-triangle text-amber-500 text-3xl mb-2"></i>
                <p class="text-amber-800 font-medium">Please select a student to view their permanent academic record.</p>
            </div>
        @endif

        @if($selectedStudent)
        @php
            $user = $selectedStudent->user;
        @endphp

        <!-- TWO COLUMN LAYOUT: Report Card (Left) + Sidebar (Right) -->
        <div class="flex gap-6" style="align-items: flex-start;">
            
            <!-- LEFT COLUMN: Official SF10 Permanent Record -->
            <div class="flex-1">
            <div class="sf10-container bg-white p-4 rounded-xl shadow-lg border border-slate-200">
            
            <!-- Header Section -->
            <div class="header-box mb-3">
                <div class="text-center space-y-1">
                    <p class="text-[10px] font-normal">Republic of the Philippines</p>
                    <p class="text-[11px] font-bold uppercase">Department of Education</p>
                    <p class="text-xl font-bold text-black mt-2">SF10-ES</p>
                    <p class="text-sm font-bold uppercase">Learner's Permanent Academic Record</p>
                    <p class="text-[11px] font-bold uppercase">TUGAWE ELEMENTARY SCHOOL</p>
                    <p class="text-[9px] italic">(Formerly Form 137)</p>
                </div>
            </div>

            <!-- Learner Information -->
            @php
                $user = $selectedStudent->user;
                $age = '';
                if ($selectedStudent->birthdate) {
                    $birth = \Carbon\Carbon::parse($selectedStudent->birthdate);
                    $now = \Carbon\Carbon::now();
                    $age = $birth->diffInYears($now);
                }
            @endphp

            <div class="mb-3 border-2 border-black p-2">
                <h3 class="section-header">LEARNER'S INFORMATION</h3>
                
                <div class="grid grid-cols-2 gap-x-6 gap-y-2 mt-3 text-[10px]">
                    <!-- Left Side: Names -->
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-24">LAST NAME:</span>
                        <span class="flex-1 px-1 font-bold uppercase text-[11px]">{{ $user->last_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-16">LRN:</span>
                        <span class="flex-1 px-1 font-mono text-[11px]">{{ $selectedStudent->lrn ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-24">FIRST NAME:</span>
                        <span class="flex-1 px-1 font-bold uppercase text-[11px]">{{ $user->first_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-16">Birthdate:</span>
                        <span class="flex-1 px-1">{{ $selectedStudent->birthdate ? \Carbon\Carbon::parse($selectedStudent->birthdate)->format('m/d/Y') : '' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-24">MIDDLE NAME:</span>
                        <span class="flex-1 px-1 font-bold uppercase text-[11px]">{{ $user->middle_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-16">Sex:</span>
                        <span class="flex-1 px-1 uppercase">{{ $selectedStudent->gender ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Eligibility for Elementary School Admission -->
            <div class="mb-3 border-2 border-black p-2">
                <h3 class="section-header">ELIGIBILITY FOR ELEMENTARY SCHOOL ADMISSION</h3>
                
                <div class="mt-3 text-[9px] space-y-2">
                    <p class="font-semibold">Credential Presented for Grade 1:</p>
                    <div class="flex gap-6 mt-1 ml-4">
                        <label class="flex items-center gap-2">
                            <span class="checkbox"></span> Kinder Progress Report
                        </label>
                        <label class="flex items-center gap-2">
                            <span class="checkbox"></span> ECD Checklist
                        </label>
                        <label class="flex items-center gap-2">
                            <span class="checkbox"></span> Kindergarten Certificate of Completion
                        </label>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="font-semibold">Other Credential Presented:</span>
                        <span class="flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="font-semibold">Name and Address of Testing Center:</span>
                        <span class="flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="font-semibold">Date of Examination/Assessment:</span>
                        <span class="w-32"></span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="font-semibold">Remark:</span>
                        <span class="flex-1"></span>
                    </div>
                </div>
            </div>

            <!-- Scholastic Records -->
            <div class="mb-3">
                <h3 class="section-header">SCHOLASTIC RECORDS</h3>
                
                @if(isset($allGradeLevels) && count($allGradeLevels) > 0)
                    @foreach($allGradeLevels as $gradeLevel)
                        @php
                            $subjectsForGrade = $subjectsByGrade[$gradeLevel] ?? collect();
                            $gradeRecords = $historicalGrades[$gradeLevel] ?? collect();
                            $schoolInfo = $schoolHistory[$gradeLevel] ?? null;
                            $hasData = $gradeRecords->count() > 0 || ($currentGradeLevel === $gradeLevel);
                        @endphp
                        
                        @if($hasData || in_array($gradeLevel, ['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6']))
                        <div class="scholastic-record mt-3 border-2 border-black">
                            <!-- School Info Header -->
                            <div class="bg-gray-100 p-2 text-[9px] border-b-2 border-black">
                                <div class="grid grid-cols-6 gap-2 mb-1">
                                    <div class="col-span-1 font-bold text-[10px]">{{ $gradeLevel }}</div>
                                    <div class="col-span-5 flex justify-between">
                                        <span>School: <span class="underline-field">{{ $schoolInfo->school_name ?? $schoolName }}</span></span>
                                        <span>School ID: <span class="underline-field">{{ $schoolInfo->school_id ?? $schoolId }}</span></span>
                                        <span>District: <span class="underline-field">{{ $schoolInfo->district ?? $schoolDistrict }}</span></span>
                                        <span>Division: <span class="underline-field">{{ $schoolInfo->division ?? $schoolDivision }}</span></span>
                                        <span>Region: <span class="underline-field">{{ $schoolInfo->region ?? $schoolRegion }}</span></span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-4 gap-4">
                                    <span>Classified as Grade: <span class="underline-field">{{ str_replace(['Grade ', 'Kindergarten'], ['', 'K'], $gradeLevel) }}</span></span>
                                    <span>Section: <span class="underline-field">{{ $schoolInfo->section ?? '' }}</span></span>
                                    <span>School Year: <span class="underline-field">{{ $schoolInfo->school_year ?? '' }}</span></span>
                                    <span>Name of Adviser/Teacher: <span class="underline-field">{{ $schoolInfo->adviser ?? '' }}</span></span>
                                </div>
                            </div>

                            @php
                                $isKindergartenGrade = (stripos($gradeLevel, 'kinder') !== false);
                                $kinderConfig = config('kindergarten.domains');
                                $kinderDomainData = $kinderDomainsByGrade[$gradeLevel] ?? collect();
                                
                                // Helper to get kindergarten rating
                                $getKinderRatingSF10 = function($domainKey, $indicatorKey, $quarter) use ($kinderDomainData) {
                                    $domainData = $kinderDomainData->get($domainKey);
                                    if (!$domainData) return '';
                                    $indicatorData = $domainData->get($indicatorKey);
                                    if (!$indicatorData) return '';
                                    $record = $indicatorData->firstWhere('quarter', $quarter);
                                    return $record ? $record->rating : '';
                                };
                            @endphp
                            
                            @if($isKindergartenGrade)
                                <!-- KINDERGARTEN: Developmental Domains -->
                                <table class="sf10-table">
                                    <thead>
                                        <tr style="background-color: #f3f4f6;">
                                            <th rowspan="2" style="width: 50%; text-align: left; padding-left: 8px; vertical-align: middle;">{{ $lang == 'cebuano' ? 'MGA KAHILIAN (DOMAINS)' : 'DOMAINS' }}</th>
                                            <th colspan="4" style="text-align: center; border-bottom: 1px solid #000;">{{ $lang == 'cebuano' ? 'MARKAHAN (QUARTER)' : 'QUARTER' }}</th>
                                        </tr>
                                        <tr style="background-color: #f3f4f6;">
                                            <th style="width: 12.5%; text-align: center;">1</th>
                                            <th style="width: 12.5%; text-align: center;">2</th>
                                            <th style="width: 12.5%; text-align: center;">3</th>
                                            <th style="width: 12.5%; text-align: center;">4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kinderConfig as $domainKey => $domainData)
                                            <tr style="background-color: #e5e7eb;">
                                                <td colspan="5" class="font-bold text-[9px]" style="text-align: left; padding-left: 8px; text-transform: uppercase; background-color: #f3f4f6;">
                                                    {{ $domainData['name'][$lang] ?? $domainData['name']['cebuano'] }}
                                                </td>
                                            </tr>
                                            @if(isset($domainData['subdomains']))
                                                {{-- Domains with subdomains --}}
                                                @foreach($domainData['subdomains'] as $subdomainKey => $subdomainData)
                                                    @foreach($subdomainData['indicators'] as $indicatorKey => $indicatorText)
                                                    <tr style="{{ $loop->parent->even && $loop->even ? 'background-color: #f9fafb;' : '' }}">
                                                        <td class="text-left pl-4 text-[7.5pt]" style="font-size: 7.5pt; text-align: justify; text-justify: inter-word; padding: 4px 8px; line-height: 1.4;">{{ $indicatorText[$lang] ?? $indicatorText['cebuano'] }}</td>
                                                        <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 1) }}</td>
                                                        <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 2) }}</td>
                                                        <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 3) }}</td>
                                                        <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 4) }}</td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                            @elseif(isset($domainData['indicators']))
                                                {{-- Domains without subdomains --}}
                                                @foreach($domainData['indicators'] as $indicatorKey => $indicatorText)
                                                <tr style="{{ $loop->even ? 'background-color: #f9fafb;' : '' }}">
                                                    <td class="text-left pl-4 text-[7.5pt]" style="font-size: 7.5pt; text-align: justify; text-justify: inter-word; padding: 4px 8px; line-height: 1.4;">{{ $indicatorText[$lang] ?? $indicatorText['cebuano'] }}</td>
                                                    <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 1) }}</td>
                                                    <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 2) }}</td>
                                                    <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 3) }}</td>
                                                    <td class="text-center font-bold" style="vertical-align: middle;">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 4) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-2 text-slate-400 text-[8px]">No kindergarten domain data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                                <!-- Rating Scale for SF10 Kindergarten -->
                                <div class="p-2 border-t-2 border-black text-[7px] bg-gray-50">
                                    @if($lang == 'cebuano')
                                        <p class="font-bold mb-1">MARKAHAN: B = Sinugdan (Beginning) | D = Nagpalambo (Developing) | C = Kusgan (Consistent)</p>
                                    @else
                                        <p class="font-bold mb-1">RATING SCALE: B = Beginning (Sinugdan) | D = Developing (Nagpalambo) | C = Consistent (Kusgan)</p>
                                    @endif
                                </div>
                            @else
                                <!-- GRADES 1-6: Regular Subject Grades -->
                                <table class="sf10-table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="width: 32%; text-align: left; padding-left: 6px;">LEARNING AREAS</th>
                                            <th colspan="4">QUARTERLY RATING</th>
                                            <th rowspan="2" style="width: 8%;">FINAL RATING</th>
                                            <th rowspan="2" style="width: 10%;">REMARKS</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 8%;">1</th>
                                            <th style="width: 8%;">2</th>
                                            <th style="width: 8%;">3</th>
                                            <th style="width: 8%;">4</th>
                                        </tr>
                                    </thead>
                                   <tbody>
            @php
                $totalFinal = 0;
                $subjectCount = 0;
            @endphp
            
            @forelse($subjectsForGrade as $subject)
                @php
                    // Get grades for this subject from grouped data
                    $subjectGrades = $gradeRecords[$subject->id] ?? collect();
                    
                    // Extract quarter grades (same pattern as SF9)
                    $q1 = $subjectGrades->get(1)?->final_grade;
                    $q2 = $subjectGrades->get(2)?->final_grade;
                    $q3 = $subjectGrades->get(3)?->final_grade;
                    $q4 = $subjectGrades->get(4)?->final_grade;
                    
                    // Get year-end final grade (quarter = NULL or 0)
                    $yearEndGrade = $subjectGrades->get(null)?->final_grade ?? $subjectGrades->get(0)?->final_grade;
                    
                    // If no year-end grade, calculate average of available quarters
                    $final = $yearEndGrade;
                    if (!$final) {
                        $quarters = array_filter([$q1, $q2, $q3, $q4], fn($q) => $q !== null);
                        if (count($quarters) > 0) {
                            $final = round(array_sum($quarters) / count($quarters));
                        }
                    }
                    
                    if ($final !== null) {
                        $totalFinal += $final;
                        $subjectCount++;
                    }
                    
                    $remark = '';
                    if ($final !== null) {
                        $remark = $final >= 75 ? 'Passed' : 'Failed';
                    }
                @endphp
                <tr>
                    <td class="text-left pl-2 text-[9px]">{{ $subject->name }}</td>
                    <td>{{ $q1 ?? '' }}</td>
                    <td>{{ $q2 ?? '' }}</td>
                    <td>{{ $q3 ?? '' }}</td>
                    <td>{{ $q4 ?? '' }}</td>
                    <td class="font-bold">{{ $final ?? '' }}</td>
                    <td class="text-[8px]">{{ $remark }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-2 text-slate-400 text-[8px]">No subjects found for {{ $gradeLevel }}</td>
                </tr>
            @endforelse
            
            @if($subjectCount > 0)
                @php
                    $generalAverage = round($totalFinal / $subjectCount);
                @endphp
                <tr class="bg-gray-100 font-bold">
                    <td colspan="5" class="text-right pr-3 text-[9px]">GENERAL AVERAGE</td>
                    <td class="text-[10px] border-2 border-black">{{ $generalAverage }}</td>
                    <td class="text-[9px]">{{ $generalAverage >= 75 ? 'Promoted' : 'Retained' }}</td>
                </tr>
            @else
                <tr class="bg-gray-100 font-bold">
                    <td colspan="5" class="text-right pr-3 text-[9px]">GENERAL AVERAGE</td>
                    <td class="text-[10px] border-2 border-black"></td>
                    <td class="text-[9px]"></td>
                </tr>
            @endif
            </tbody>
                                </table>
                            @endif

                            <!-- Remedial Classes -->
                            <div class="p-2 border-t-2 border-black text-[8px] bg-gray-50">
                                <p class="font-bold mb-1">REMEDIAL CLASSES</p>
                                <div class="grid grid-cols-3 gap-4 mb-1">
                                    <div>Conducted from (mm/dd/yyyy): <span class="underline-field w-24"></span></div>
                                    <div>To (mm/dd/yyyy): <span class="underline-field w-24"></span></div>
                                    <div>Final Rating: <span class="underline-field w-16"></span></div>
                                </div>
                                <div class="mb-1">
                                    <span class="font-semibold">Learning Areas for Remedial:</span>
                                    <span class="border-b border-black inline-block w-96"></span>
                                </div>
                                <div>
                                    <span class="font-semibold">Remarks:</span>
                                    <span class="border-b border-black inline-block flex-1"></span>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="p-4 text-center text-slate-500 text-sm border border-dashed border-slate-300 rounded-lg mt-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        No grade level information available.
                    </div>
                @endif
            </div>

            <!-- Certification -->
            <div class="mb-3 border-2 border-black p-3">
                <h3 class="section-header">CERTIFICATION</h3>
                <p class="text-[10px] leading-relaxed mt-3">
                    I CERTIFY that this is a true record of <strong class="uppercase">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</strong> 
                    with LRN <strong>{{ $selectedStudent->lrn ?? '' }}</strong> and that he/she is eligible for admission to Grade 
                    <span class="underline-field w-16"></span>.
                </p>
                <div class="mt-3 grid grid-cols-2 gap-6 text-[9px]">
                    <div class="space-y-1">
                        <p>Name of School: <span class="underline-field">{{ $schoolName }}</span></p>
                        <p>School ID: <span class="underline-field">{{ $schoolId }}</span></p>
                        <p>District: <span class="underline-field">{{ $schoolDistrict }}</span></p>
                        <p>Division: <span class="underline-field">{{ $schoolDivision }}</span></p>
                    </div>
                    <div class="space-y-1">
                        <p>Last School Year Attended: <span class="underline-field">{{ $schoolYear }}</span></p>
                        <p>Date: <span class="underline-field">{{ now()->format('m/d/Y') }}</span></p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-between items-end">
                    <div class="text-center">
                        <div class="border-t-2 border-black w-56 pt-1">
                            <p class="font-bold uppercase text-[11px]">{{ $schoolHead }}</p>
                            <p class="text-[9px]">School Head</p>
                        </div>
                    </div>
                    <div class="w-28 h-28 border-2 border-black flex items-center justify-center text-[9px] text-gray-500 bg-gray-50">
                        School Seal
                    </div>
                </div>
            </div>

            <!-- Cancellation of Eligibility to Transfer -->
            <div class="mb-3 border-2 border-black p-2 bg-gray-50">
                <h3 class="text-[10px] font-bold mb-2">CANCELLATION OF ELIGIBILITY TO TRANSFER</h3>
                <div class="text-[9px] space-y-2">
                    <div class="flex items-center gap-2">
                        <span>Admitted in:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span>Date:</span>
                        <span class="border-b border-black w-32"></span>
                        <span class="ml-4">Signature of Principal/School Head:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-2 pt-2 border-t border-black text-[8px] text-black flex justify-between font-semibold">
                <span>DepEd School Form 10-ES - Revised 2025</span>
                <span>Date Generated: {{ now()->format('F d, Y') }}</span>
            </div>

        </div>
        </div>
        <!-- /LEFT COLUMN -->

        <!-- RIGHT COLUMN: Student Selector & Info Sidebar -->
        <div class="no-print" style="width: 300px; flex-shrink: 0;">
            
            <!-- Student Selector Card -->
            <div class="bg-white rounded-lg shadow-md border border-slate-200 mb-4 overflow-hidden">
                <div class="bg-blue-600 text-white px-4 py-3 flex items-center gap-2">
                    <i class="fas fa-user-graduate"></i>
                    <span class="font-semibold">Select Student</span>
                </div>
                <div class="p-4">
                    <form method="GET" action="{{ route('teacher.sf10') }}">
                        <select name="student_id" onchange="this.form.submit()" 
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-700 text-sm bg-slate-50 mb-3">
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $selectedStudent && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                    {{ $student->user->last_name ?? '' }}, {{ $student->user->first_name ?? '' }} {{ $student->user->middle_name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Load
                        </button>
                    </form>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="bg-white rounded-lg shadow-md border border-slate-200 mb-4 overflow-hidden">
                <div class="bg-slate-100 text-slate-800 px-4 py-2 text-sm font-semibold border-b">Student Information</div>
                <div class="p-4 text-sm">
                    <div class="mb-2"><span class="text-slate-500">Name:</span> <span class="font-semibold">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }}</span></div>
                    <div class="mb-2"><span class="text-slate-500">LRN:</span> <span class="font-semibold">{{ $selectedStudent->lrn ?? 'N/A' }}</span></div>
                    <div class="mb-2"><span class="text-slate-500">Birthdate:</span> <span class="font-semibold">{{ $selectedStudent->birthdate ? \Carbon\Carbon::parse($selectedStudent->birthdate)->format('m/d/Y') : 'N/A' }}</span></div>
                    <div><span class="text-slate-500">Sex:</span> <span class="font-semibold">{{ $selectedStudent->gender ?? 'N/A' }}</span></div>
                </div>
            </div>

            <!-- Academic History Stats -->
            <div class="bg-white rounded-lg shadow-md border border-slate-200 mb-4 overflow-hidden">
                <div class="bg-blue-600 text-white px-4 py-3 flex items-center gap-2">
                    <i class="fas fa-history"></i>
                    <span class="font-semibold">Academic History</span>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold uppercase">Grade Levels</p>
                            <p class="text-lg font-bold text-slate-800">{{ count($scholasticRecords ?? []) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-700">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold uppercase">Status</p>
                            <p class="text-sm font-bold text-green-700">Active</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /RIGHT COLUMN -->

        </div>
        <!-- /TWO COLUMN LAYOUT -->
        @endif

    </div>

    <!-- Floating Print Button -->
    <button onclick="window.print()" class="no-print print-btn bg-blue-600 text-white hover:bg-blue-700 transition shadow-xl shadow-blue-500/40">
        <i class="fas fa-print text-xl"></i>
    </button>

</body>
</html>