<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Form 10 (SF10) - Learner's Permanent Academic Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
        }
        
        .sf10-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .sf10-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 8px;
        }
        
        .sf10-table th,
        .sf10-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            vertical-align: middle;
        }
        
        .sf10-table th {
            background-color: #e5e7eb;
            font-weight: 600;
            font-size: 7px;
        }
        
        .header-box {
            border: 2px solid #1e3a8a;
            padding: 6px;
            text-align: center;
            background: #f8fafc;
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
        
        /* Print styles */
        @media print {
            @page {
                size: letter portrait;
                margin: 0.4in 0.3in 0.4in 0.3in;
            }
            
            aside,
            nav[class*="w-72"],
            div[class*="w-72"],
            .sidebar,
            #sidebar,
            [class*="sidebar"],
            .no-print {
                display: none !important;
            }
            
            .ml-72,
            [class*="ml-72"] {
                margin-left: 0 !important;
                padding-left: 0 !important;
                width: 100% !important;
            }
            
            body {
                background: white;
                font-size: 8pt;
            }
            
            .sf10-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                max-width: 100% !important;
            }
            
            .sf10-table {
                font-size: 7pt;
            }
            
            .sf10-table th,
            .sf10-table td {
                padding: 1px 2px;
            }
        }
        
        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            font-weight: 600;
        }
        
        .scholastic-record {
            page-break-inside: avoid;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen">

    <!-- Include Sidebar -->
    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <div class="ml-72 p-6">
        
        <!-- Page Header -->
        <div class="mb-4 flex items-center justify-between no-print">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">School Form 10 (SF10)</h1>
                <p class="text-slate-500">Learner's Permanent Academic Record</p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 text-sm font-medium">
                    <i class="fas fa-calendar-alt mr-2"></i>{{ $schoolYear }}
                </div>
            </div>
        </div>

        <!-- Student Selector -->
        <div class="no-print mb-4 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <form method="GET" action="{{ route('teacher.sf10') }}" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Student</label>
                    <select name="student_id" onchange="this.form.submit()" 
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $selectedStudent && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                {{ $student->user->last_name ?? '' }}, {{ $student->user->first_name ?? '' }} {{ $student->user->middle_name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                    Load Permanent Record
                </button>
            </form>
        </div>

        @if(!$selectedStudent)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center no-print mb-4">
                <i class="fas fa-exclamation-triangle text-amber-500 text-3xl mb-2"></i>
                <p class="text-amber-800 font-medium">Please select a student to view their permanent academic record.</p>
            </div>
        @endif

        @if($selectedStudent)
        <!-- SF10 Permanent Record -->
        <div class="sf10-container bg-white p-4 rounded-xl shadow-lg border border-slate-200">
            
            <!-- Header Section -->
            <div class="header-box mb-3">
                <div class="text-center space-y-0.5">
                    <p class="text-[10px] font-semibold">Republic of the Philippines</p>
                    <p class="text-[10px] font-bold">DEPARTMENT OF EDUCATION</p>
                    <p class="text-lg font-bold text-indigo-900 mt-1">SCHOOL FORM 10 (SF10)</p>
                    <p class="text-xs font-bold">LEARNER'S PERMANENT ACADEMIC RECORD</p>
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

            <div class="mb-3 p-2 border border-black bg-gray-50">
                <h3 class="text-[10px] font-bold bg-indigo-600 text-white py-0.5 px-2 mb-2 inline-block">LEARNER'S INFORMATION</h3>
                
                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-[9px]">
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-20">Last Name:</span>
                        <span class="border-b border-black flex-1 px-1 font-bold uppercase">{{ $user->last_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-24">LRN:</span>
                        <span class="border-b border-black flex-1 px-1 font-mono">{{ $selectedStudent->lrn ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-20">First Name:</span>
                        <span class="border-b border-black flex-1 px-1 font-bold uppercase">{{ $user->first_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-24">Birthdate:</span>
                        <span class="border-b border-black flex-1 px-1">{{ $selectedStudent->birthdate ? \Carbon\Carbon::parse($selectedStudent->birthdate)->format('m/d/Y') : '' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-20">Middle Name:</span>
                        <span class="border-b border-black flex-1 px-1 font-bold uppercase">{{ $user->middle_name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold w-24">Sex:</span>
                        <span class="border-b border-black flex-1 px-1 uppercase">{{ $selectedStudent->gender ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Eligibility for Elementary School Admission -->
            <div class="mb-3 p-2 border border-black">
                <h3 class="text-[10px] font-bold bg-indigo-600 text-white py-0.5 px-2 mb-2 inline-block">ELIGIBILITY FOR ELEMENTARY SCHOOL ADMISSION</h3>
                
                <div class="grid grid-cols-2 gap-4 text-[9px]">
                    <div>
                        <p class="font-semibold">Credential Presented for Grade 1:</p>
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center gap-1">
                                <input type="checkbox" class="w-3 h-3"> Kinder Progress Report
                            </label>
                            <label class="flex items-center gap-1">
                                <input type="checkbox" class="w-3 h-3"> ECD Checklist
                            </label>
                            <label class="flex items-center gap-1">
                                <input type="checkbox" class="w-3 h-3"> Kindergarten Certificate
                            </label>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold">Other Credential Presented:</p>
                        <div class="border-b border-black mt-1 h-4"></div>
                    </div>
                </div>
            </div>

<!-- Scholastic Records -->
<div class="mb-3">
    <h3 class="text-[10px] font-bold bg-indigo-600 text-white py-0.5 px-2 mb-2 inline-block">SCHOLASTIC RECORDS</h3>
    
    @if($currentGradeLevel && isset($subjectsByGrade[$currentGradeLevel]))
        @php
            $gradeLevel = $currentGradeLevel;
            $subjectsForGrade = $subjectsByGrade[$gradeLevel] ?? collect();
            $gradeRecords = $historicalGrades[$gradeLevel] ?? collect();
            $schoolInfo = $schoolHistory[$gradeLevel] ?? null;
        @endphp
        
        <div class="scholastic-record mb-3 border border-black">
            <!-- School Info Header -->
            <div class="bg-gray-100 p-1 text-[8px] border-b border-black">
                <div class="flex justify-between items-center">
                    <span class="font-bold">{{ $gradeLevel }}</span>
                    <div class="flex gap-4">
                        <span>School: <span class="underline-field">{{ $schoolInfo->school_name ?? $schoolName }}</span></span>
                        <span>School ID: <span class="underline-field">{{ $schoolInfo->school_id ?? $schoolId }}</span></span>
                        <span>District: <span class="underline-field">{{ $schoolInfo->district ?? $schoolDistrict }}</span></span>
                        <span>Division: <span class="underline-field">{{ $schoolInfo->division ?? $schoolDivision }}</span></span>
                        <span>Region: <span class="underline-field">{{ $schoolInfo->region ?? $schoolRegion }}</span></span>
                    </div>
                </div>
                <div class="flex justify-between mt-1">
                    <span>Classified as Grade: <span class="underline-field">{{ str_replace('Grade ', '', $gradeLevel) }}</span></span>
                    <span>Section: <span class="underline-field">{{ $schoolInfo->section ?? ($selectedStudent->section->name ?? '') }}</span></span>
                    <span>School Year: <span class="underline-field">{{ $schoolInfo->school_year ?? $schoolYear }}</span></span>
                    <span>Name of Adviser/Teacher: <span class="underline-field">{{ $schoolInfo->adviser ?? (optional($selectedStudent->section->teacher->user)->full_name ?? 'N/A') }}</span></span>
                </div>
            </div>

            <!-- Grades Table -->
            <table class="sf10-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 30%;">Learning Areas</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th rowspan="2" style="width: 10%;">Final Rating</th>
                        <th rowspan="2" style="width: 10%;">Remarks</th>
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
                            // Find grade record for this subject
                            $gradeRecord = $gradeRecords->firstWhere('subject_id', $subject->id);
                            
                            // If no grade record found by subject_id, try matching by subject name
                            if (!$gradeRecord) {
                                $gradeRecord = $gradeRecords->first(function($gr) use ($subject) {
                                    return $gr->subject && $gr->subject->name == $subject->name;
                                });
                            }
                            
                            $q1 = $gradeRecord->quarter_1 ?? '';
                            $q2 = $gradeRecord->quarter_2 ?? '';
                            $q3 = $gradeRecord->quarter_3 ?? '';
                            $q4 = $gradeRecord->quarter_4 ?? '';
                            
                            $quarters = array_filter([$q1, $q2, $q3, $q4], function($v) { return $v !== '' && $v !== null; });
                            $final = count($quarters) > 0 ? round(array_sum($quarters) / count($quarters)) : '';
                            
                            if ($final !== '' && $final !== null) {
                                $totalFinal += $final;
                                $subjectCount++;
                            }
                            
                            $remark = '';
                            if ($final !== '' && $final !== null) {
                                $remark = $final >= 75 ? 'Passed' : 'Failed';
                            }
                        @endphp
                        <tr>
                            <td class="text-left pl-1 text-[8px]">{{ $subject->name }}</td>
                            <td>{{ $q1 }}</td>
                            <td>{{ $q2 }}</td>
                            <td>{{ $q3 }}</td>
                            <td>{{ $q4 }}</td>
                            <td class="font-bold">{{ $final }}</td>
                            <td class="text-[7px]">{{ $remark }}</td>
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
                            <td colspan="5" class="text-right pr-2 text-[9px]">General Average</td>
                            <td class="text-[11px] border-2 border-black">{{ $generalAverage }}</td>
                            <td class="text-[9px]">{{ $generalAverage >= 75 ? 'Promoted' : 'Retained' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Remedial Classes -->
            <div class="p-1 border-t border-black text-[8px]">
                <p class="font-semibold">Remedial Classes:</p>
                <div class="grid grid-cols-3 gap-2 mt-1">
                    <div>Conducted from (mm/dd/yyyy): <span class="underline-field"></span></div>
                    <div>To (mm/dd/yyyy): <span class="underline-field"></span></div>
                    <div>Final Rating: <span class="underline-field"></span></div>
                </div>
                <div class="mt-1">
                    Learning Areas for Remedial: <span class="underline-field w-full"></span>
                </div>
                <div class="mt-1">
                    Remarks: <span class="underline-field w-full"></span>
                </div>
            </div>
        </div>
    @else
        <div class="p-4 text-center text-slate-500 text-sm border border-dashed border-slate-300 rounded-lg">
            <i class="fas fa-info-circle mr-2"></i>
            No grade level information available for this student.
        </div>
    @endif
</div>

            <!-- Certification -->
            <div class="mb-3 p-2 border-2 border-black">
                <h3 class="text-[10px] font-bold mb-2">CERTIFICATION</h3>
                <p class="text-[9px] leading-relaxed">
                    I CERTIFY that this is a true record of <strong>{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</strong> 
                    with LRN <strong>{{ $selectedStudent->lrn ?? '' }}</strong> and that he/she is eligible for admission to Grade 
                    <span class="underline-field w-12"></span>.
                </p>
                <div class="mt-2 grid grid-cols-2 gap-4 text-[9px]">
                    <div>
                        <p>Name of School: <span class="underline-field">{{ $schoolName }}</span></p>
                        <p>School ID: <span class="underline-field">{{ $schoolId }}</span></p>
                        <p>Division: <span class="underline-field">{{ $schoolDivision }}</span></p>
                    </div>
                    <div>
                        <p>Last School Year Attended: <span class="underline-field">{{ $schoolYear }}</span></p>
                        <p>Date: <span class="underline-field">{{ now()->format('m/d/Y') }}</span></p>
                    </div>
                </div>
                
                <div class="mt-4 flex justify-between items-end">
                    <div class="text-center">
                        <div class="border-t border-black w-48 pt-1">
                            <p class="font-bold uppercase text-[10px]">{{ $schoolHead }}</p>
                            <p class="text-[8px]">School Head</p>
                        </div>
                    </div>
                    <div class="w-24 h-24 border border-black flex items-center justify-center text-[8px] text-gray-400">
                        School Seal
                    </div>
                </div>
            </div>

            <!-- Cancellation of Eligibility to Transfer -->
            <div class="mb-3 p-2 border border-black bg-gray-50">
                <h3 class="text-[10px] font-bold mb-1">Cancellation of Eligibility to Transfer</h3>
                <div class="text-[9px] space-y-1">
                    <div class="flex items-center gap-2">
                        <span>Admitted in:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Date:</span>
                        <span class="border-b border-black w-32"></span>
                        <span class="ml-4">Signature of Principal:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-2 pt-1 border-t border-slate-300 text-[8px] text-slate-500 flex justify-between">
                <span>DepEd School Form 10 - Revised 2025</span>
                <span>Date Generated: {{ now()->format('F d, Y') }}</span>
            </div>

        </div>
        @endif

    </div>

    <!-- Floating Print Button -->
    <button onclick="window.print()" class="no-print print-btn bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/40">
        <i class="fas fa-print text-xl"></i>
    </button>

</body>
</html>