
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Form 9 (SF9) - Learner's Progress Report Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
        }
        
        .sf9-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .sf9-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 9px;
        }
        
        .sf9-table th,
        .sf9-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .sf9-table th {
            background-color: #e5e7eb;
            font-weight: 600;
            font-size: 8px;
        }
        
        .header-box {
            border: 2px solid #1e3a8a;
            padding: 8px;
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
                margin: 0.5in 0.4in 0.5in 0.4in;
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
                font-size: 9pt;
            }
            
            .sf9-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                max-width: 100% !important;
            }
            
            .sf9-table {
                font-size: 8pt;
            }
            
            .sf9-table th,
            .sf9-table td {
                padding: 2px 3px;
            }
        }
        
        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            font-weight: 600;
        }
        
        .core-values-table td {
            font-size: 8px;
            text-align: left;
            padding: 2px 4px;
        }
        
        .attendance-table td {
            font-size: 8px;
            padding: 2px 4px;
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
                <h1 class="text-2xl font-bold text-slate-800">School Form 9 (SF9)</h1>
                <p class="text-slate-500">Learner's Progress Report Card</p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 text-sm font-medium">
                    <i class="fas fa-calendar-alt mr-2"></i>{{ $schoolYear }}
                </div>
            </div>
        </div>

        <!-- Student Selector -->
        <div class="no-print mb-4 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
            <form method="GET" action="{{ route('teacher.sf9') }}" class="flex items-end gap-4">
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
                    Load Report Card
                </button>
            </form>
        </div>

        @if(!$selectedStudent)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center no-print mb-4">
                <i class="fas fa-exclamation-triangle text-amber-500 text-3xl mb-2"></i>
                <p class="text-amber-800 font-medium">Please select a student to view their report card.</p>
            </div>
        @endif

        @if($selectedStudent)
        <!-- SF9 Report Card -->
        <div class="sf9-container bg-white p-6 rounded-xl shadow-lg border border-slate-200">
            
            <!-- Header Section -->
            <div class="header-box mb-4">
                <div class="text-center space-y-1">
                    <p class="text-xs font-semibold">Republic of the Philippines</p>
                    <p class="text-xs font-bold">DEPARTMENT OF EDUCATION</p>
                    <p class="text-[10px]">Region <span class="underline-field">{{ $schoolRegion }}</span></p>
                    <p class="text-[10px]">SCHOOLS DIVISION OF <span class="underline-field">{{ $schoolDivision }}</span></p>
                    <p class="text-[10px]"><span class="underline-field">{{ $schoolDistrict }}</span> District</p>
                    <p class="text-sm font-bold mt-2">{{ $schoolName }}</p>
                    <p class="text-lg font-bold text-indigo-900 mt-1">PROGRESS REPORT CARD</p>
                    <p class="text-xs">School Year <span class="underline-field">{{ $schoolYear }}</span></p>
                </div>
            </div>

            <!-- Student Information -->
            @php
                $user = $selectedStudent->user;
                $section = $selectedStudent->section;
                $gradeLevel = $section->gradeLevel ?? null;
                
                // Calculate age
                $age = '';
                if ($selectedStudent->birthdate) {
                    $birth = \Carbon\Carbon::parse($selectedStudent->birthdate);
                    $now = \Carbon\Carbon::now();
                    $age = $birth->diffInYears($now);
                }
            @endphp

            <div class="mb-4 space-y-1 text-sm">
                <div class="flex items-center gap-2">
                    <span class="font-semibold w-20 text-xs">NAME:</span>
                    <span class="border-b border-black flex-1 px-2 font-bold uppercase">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold w-20 text-xs">Age:</span>
                        <span class="border-b border-black w-16 text-center">{{ $age }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold w-16 text-xs">Sex:</span>
                        <span class="border-b border-black w-20 text-center uppercase">{{ $selectedStudent->gender ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold w-20 text-xs">Grade:</span>
                        <span class="border-b border-black w-16 text-center">{{ $gradeLevel->name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold w-20 text-xs">Section:</span>
                        <span class="border-b border-black w-24 text-center">{{ $section->name ?? '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-1">
                        <span class="font-semibold w-12 text-xs">LRN:</span>
                        <span class="border-b border-black flex-1 font-mono text-xs">{{ $selectedStudent->lrn ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Report on Learning Progress and Achievement -->
            <div class="mb-4">
                <h3 class="text-xs font-bold bg-indigo-600 text-white py-1 px-2 mb-2">REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</h3>
                
                <table class="sf9-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 30%;">Learning Areas</th>
                            <th colspan="4">Quarter</th>
                            <th rowspan="2" style="width: 12%;">Final Rating</th>
                            <th rowspan="2" style="width: 15%;">Remarks</th>
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
                            $subjects = [
                                'Mother Tongue' => 'mother_tongue',
                                'Filipino' => 'filipino',
                                'English' => 'english',
                                'Mathematics' => 'mathematics',
                                'Science' => 'science',
                                'Araling Panlipunan' => 'ap',
                                'Edukasyon sa Pagpapakatao' => 'esp',
                                'Music' => 'music',
                                'Arts' => 'arts',
                                'Physical Education' => 'pe',
                                'Health' => 'health',
                                'Edukasyong Pantahanan at Pangkabuhayan' => 'epp',
                                'Technology and Livelihood Education' => 'tle'
                            ];
                            
                            $finalRatings = [];
                            $totalGrade = 0;
                            $subjectCount = 0;
                        @endphp

                        @foreach($subjects as $subjectName => $subjectKey)
                            @php
                                $grade = $grades->firstWhere('subject', $subjectKey);
                                $q1 = $grade->quarter_1 ?? '';
                                $q2 = $grade->quarter_2 ?? '';
                                $q3 = $grade->quarter_3 ?? '';
                                $q4 = $grade->quarter_4 ?? '';
                                
                                // Calculate final rating
                                $quarters = array_filter([$q1, $q2, $q3, $q4], function($v) { return $v !== ''; });
                                $final = count($quarters) > 0 ? round(array_sum($quarters) / count($quarters)) : '';
                                
                                if ($final !== '') {
                                    $finalRatings[$subjectName] = $final;
                                    $totalGrade += $final;
                                    $subjectCount++;
                                }
                                
                                $remark = '';
                                if ($final !== '') {
                                    $remark = $final >= 75 ? 'Passed' : 'Failed';
                                }
                            @endphp
                            @if($grade || $final !== '')
                            <tr>
                                <td class="text-left pl-2 text-[9px]">{{ $subjectName }}</td>
                                <td class="font-semibold">{{ $q1 }}</td>
                                <td class="font-semibold">{{ $q2 }}</td>
                                <td class="font-semibold">{{ $q3 }}</td>
                                <td class="font-semibold">{{ $q4 }}</td>
                                <td class="font-bold text-[10px]">{{ $final }}</td>
                                <td class="text-[8px]">{{ $remark }}</td>
                            </tr>
                            @endif
                        @endforeach

                        @php
                            $generalAverage = $subjectCount > 0 ? round($totalGrade / $subjectCount) : '';
                        @endphp

                        <tr class="bg-gray-100 font-bold">
                            <td colspan="5" class="text-right pr-2 text-[10px]">General Average</td>
                            <td class="text-[11px] border-2 border-black">{{ $generalAverage }}</td>
                            <td class="text-[9px]">{{ $generalAverage >= 75 ? 'Passed' : ($generalAverage ? 'Failed' : '') }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Descriptors and Grading Scale -->
                <div class="mt-2 grid grid-cols-2 gap-4 text-[8px]">
                    <div>
                        <table class="w-full border border-black">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-black p-1">Descriptors</th>
                                    <th class="border border-black p-1">Grading Scale</th>
                                    <th class="border border-black p-1">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="border border-black p-1">Outstanding</td><td class="border border-black p-1 text-center">90-100</td><td class="border border-black p-1 text-center">Passed</td></tr>
                                <tr><td class="border border-black p-1">Very Satisfactory</td><td class="border border-black p-1 text-center">85-89</td><td class="border border-black p-1 text-center">Passed</td></tr>
                                <tr><td class="border border-black p-1">Satisfactory</td><td class="border border-black p-1 text-center">80-84</td><td class="border border-black p-1 text-center">Passed</td></tr>
                                <tr><td class="border border-black p-1">Fairly Satisfactory</td><td class="border border-black p-1 text-center">75-79</td><td class="border border-black p-1 text-center">Passed</td></tr>
                                <tr><td class="border border-black p-1">Did Not Meet Expectations</td><td class="border border-black p-1 text-center">Below 75</td><td class="border border-black p-1 text-center">Failed</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center">
                        <p class="text-[9px] leading-relaxed">
                            <strong>Dear Parent,</strong><br>
                            This report card shows the ability and the progress your child has made in the different learning areas as well as his/her progress in core values.<br>
                            The school welcomes you should you desire to know more about your child's progress.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Report on Learner's Observed Values -->
            <div class="mb-4">
                <h3 class="text-xs font-bold bg-indigo-600 text-white py-1 px-2 mb-2">REPORT ON LEARNER'S OBSERVED VALUES</h3>
                
                <table class="sf9-table core-values-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 15%;">Core Values</th>
                            <th rowspan="2" style="width: 50%;">Behavior Statements</th>
                            <th colspan="4">Quarter</th>
                        </tr>
                        <tr>
                            <th style="width: 8%;">1</th>
                            <th style="width: 8%;">2</th>
                            <th style="width: 8%;">3</th>
                            <th style="width: 8%;">4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2" class="font-semibold align-top">1. Maka-Diyos</td>
                            <td>Expresses one's spiritual beliefs while respecting the spiritual beliefs of others</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Shows adherence to ethical principles by upholding truth</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="font-semibold align-top">2. Makatao</td>
                            <td>Is sensitive to individual, social, and cultural differences</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Demonstrates contributions toward solidarity</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="font-semibold">3. Maka-Kalikasan</td>
                            <td>Cares for the environment and utilizes resources wisely, judiciously, and economically</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="font-semibold align-top">4. Maka-bansa</td>
                            <td>Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Demonstrates appropriate behavior in carrying out activities in the school, community, and country</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-1 text-[8px] space-y-1">
                    <p><strong>Marking:</strong> AO - Always Observed | SO - Sometimes Observed | RO - Rarely Observed | NO - Not Observed</p>
                </div>
            </div>

            <!-- Attendance Record -->
            <div class="mb-4">
                <h3 class="text-xs font-bold bg-indigo-600 text-white py-1 px-2 mb-2">ATTENDANCE RECORD</h3>
                
                @php
                    $months = ['Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Total'];
                    $attendanceData = [];
                    
                    // Calculate attendance per month (mock data structure - replace with actual)
                    foreach ($months as $month) {
                        if ($month != 'Total') {
                            $monthAtt = $attendances->filter(function($a) use ($month) {
                                return date('M', strtotime($a->date)) == $month && $a->status == 'present';
                            });
                            $attendanceData[$month] = [
                                'days' => 20, // School days in month
                                'present' => $monthAtt->count(),
                                'absent' => 0
                            ];
                        }
                    }
                @endphp

                <table class="sf9-table attendance-table">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($months as $month)
                                <th>{{ $month }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left font-semibold pl-2">No. of School Days</td>
                            @foreach($months as $month)
                                <td>{{ $month == 'Total' ? array_sum(array_column($attendanceData, 'days')) : ($attendanceData[$month]['days'] ?? '') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="text-left font-semibold pl-2">No. of Days Present</td>
                            @foreach($months as $month)
                                <td>{{ $month == 'Total' ? array_sum(array_column($attendanceData, 'present')) : ($attendanceData[$month]['present'] ?? '') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="text-left font-semibold pl-2">No. of Days Absent</td>
                            @foreach($months as $month)
                                <td>{{ $month == 'Total' ? array_sum(array_column($attendanceData, 'absent')) : ($attendanceData[$month]['absent'] ?? '') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Parent/Guardian Signature -->
            <div class="mb-4">
                <h3 class="text-xs font-bold bg-indigo-600 text-white py-1 px-2 mb-2">PARENT/GUARDIAN'S SIGNATURE</h3>
                <div class="space-y-2 text-[9px]">
                    <div class="flex items-center gap-2">
                        <span class="w-24">1st Quarter:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-24">2nd Quarter:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-24">3rd Quarter:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-24">4th Quarter:</span>
                        <span class="border-b border-black flex-1"></span>
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="mt-6 grid grid-cols-2 gap-8 text-xs">
                <div class="text-center">
                    <div class="mt-8 border-t border-black pt-1">
                        <p class="font-bold uppercase">{{ $adviserName }}</p>
                        <p class="text-[9px] mt-0.5">Adviser</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="mt-8 border-t border-black pt-1">
                        <p class="font-bold uppercase">{{ $schoolHead }}</p>
                        <p class="text-[9px] mt-0.5">School Head</p>
                    </div>
                </div>
            </div>

            <!-- Certificate of Transfer (Bottom Section) -->
            <div class="mt-6 border-t-2 border-indigo-900 pt-4">
                <h3 class="text-xs font-bold text-indigo-900 mb-2">CERTIFICATE OF TRANSFER</h3>
                <div class="text-[9px] space-y-1">
                    <div class="flex items-center gap-2">
                        <span>Admitted to Grade:</span>
                        <span class="border-b border-black w-20"></span>
                        <span>Section:</span>
                        <span class="border-b border-black w-32"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Eligible for Admission to Grade:</span>
                        <span class="border-b border-black w-32"></span>
                    </div>
                    <div class="flex items-center gap-4 mt-2">
                        <span>Approved:</span>
                        <div class="flex-1 text-center">
                            <div class="border-t border-black pt-1 mt-4">
                                <p class="font-bold uppercase">{{ $schoolHead }}</p>
                                <p class="text-[8px]">School Head</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-4 pt-2 border-t border-slate-300 text-[8px] text-slate-500 flex justify-between">
                <span>DepEd School Form 9</span>
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