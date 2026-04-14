@if($selectedStudent)
@php $user = $selectedStudent->user; @endphp
<div class="sf10-container bg-white p-4 rounded-xl shadow-lg border border-slate-200" style="max-width: 900px; margin: 0 auto;">
    <style>
        .sf10-table { border-collapse: collapse; width: 100%; font-size: 9px; }
        .sf10-table th, .sf10-table td { border: 1px solid #000; padding: 3px 4px; text-align: center; vertical-align: middle; }
        .sf10-table th { background-color: #f3f4f6; font-weight: 600; font-size: 8px; }
        .header-box { border: 2px solid #000; padding: 8px; text-align: center; background: #fff; }
        .section-header { background: #1e3a8a; color: white; font-size: 10px; font-weight: bold; padding: 4px 8px; display: inline-block; }
        .underline-field { border-bottom: 1px solid #000; display: inline-block; min-width: 60px; font-weight: 600; }
        .scholastic-record { margin-bottom: 10px; border: 1px solid #000; }
    </style>

    <!-- Header -->
    <div class="header-box mb-3">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-normal">Republic of the Philippines</p>
            <p class="text-[11px] font-bold uppercase">Department of Education</p>
            <p class="text-xl font-bold text-black mt-2">SF10-ES</p>
            <p class="text-sm font-bold uppercase">Learner's Permanent Academic Record</p>
            <p class="text-[11px] font-bold uppercase">{{ $schoolName }}</p>
            <p class="text-[9px] italic">(Formerly Form 137)</p>
        </div>
    </div>

    <!-- Learner Information -->
    @php
        $age = '';
        if ($selectedStudent->birthdate) {
            $age = \Carbon\Carbon::parse($selectedStudent->birthdate)->diffInYears(\Carbon\Carbon::now());
        }
    @endphp
    <div class="mb-3 border-2 border-black p-2">
        <h3 class="section-header">LEARNER'S INFORMATION</h3>
        <div class="grid grid-cols-2 gap-x-6 gap-y-2 mt-3 text-[10px]">
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

    <!-- Eligibility -->
    <div class="mb-3 border-2 border-black p-2">
        <h3 class="section-header">ELIGIBILITY FOR ELEMENTARY SCHOOL ADMISSION</h3>
        <div class="mt-3 text-[9px] space-y-2">
            <p class="font-semibold">Credential Presented for Grade 1:</p>
            <div class="flex gap-6 mt-1 ml-4">
                <span>Kinder Progress Report</span>
                <span>ECD Checklist</span>
                <span>Kindergarten Certificate of Completion</span>
            </div>
            <div class="flex items-center gap-2 mt-2"><span class="font-semibold">Other Credential Presented:</span><span class="flex-1"></span></div>
            <div class="flex items-center gap-2 mt-1"><span class="font-semibold">Name and Address of Testing Center:</span><span class="flex-1"></span></div>
            <div class="flex items-center gap-2 mt-1"><span class="font-semibold">Date of Examination/Assessment:</span><span class="w-32"></span></div>
            <div class="flex items-center gap-2 mt-1"><span class="font-semibold">Remark:</span><span class="flex-1"></span></div>
        </div>
    </div>

    <!-- Scholastic Records -->
    <div class="mb-3">
        <h3 class="section-header">SCHOLASTIC RECORDS</h3>
        @if($isKindergarten)
            @php
                $getKinderRatingSF10 = function($domainKey, $indicatorKey, $quarter) use ($kindergartenDomains) {
                    $domainData = $kindergartenDomains->get($domainKey);
                    if (!$domainData) return '';
                    $indicatorData = $domainData->get($indicatorKey);
                    if (!$indicatorData) return '';
                    $record = $indicatorData->firstWhere('quarter', $quarter);
                    return $record ? $record->rating : '';
                };
            @endphp
            <div class="scholastic-record mt-3 border-2 border-black">
                <div class="bg-gray-100 p-2 text-[9px] border-b-2 border-black">
                    <div class="flex justify-between">
                        <span class="font-bold text-[10px]">Kindergarten</span>
                        <span>School: <span class="underline-field">{{ $schoolName }}</span></span>
                        <span>School ID: <span class="underline-field">{{ $schoolId }}</span></span>
                        <span>School Year: <span class="underline-field">{{ $activeSchoolYear?->name ?? '' }}</span></span>
                        <span>Section: <span class="underline-field">{{ $currentSection?->name ?? '' }}</span></span>
                    </div>
                </div>
                <table class="sf10-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 50%; text-align: left; padding-left: 6px;">DOMAINS</th>
                            <th colspan="4" style="text-align: center;">QUARTER</th>
                        </tr>
                        <tr>
                            <th style="width: 12.5%;">1</th>
                            <th style="width: 12.5%;">2</th>
                            <th style="width: 12.5%;">3</th>
                            <th style="width: 12.5%;">4</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kinderConfig as $domainKey => $domainData)
                            <tr style="background-color: #e5e7eb;">
                                <td colspan="5" class="font-bold text-[9px]" style="text-align: left; padding-left: 8px; text-transform: uppercase; background-color: #f3f4f6;">
                                    {{ $domainData['name']['english'] ?? ($domainData['name']['cebuano'] ?? $domainKey) }}
                                </td>
                            </tr>
                            @if(isset($domainData['indicators']))
                                @foreach($domainData['indicators'] as $indicatorKey => $indicatorText)
                                    <tr>
                                        <td class="text-left pl-4 text-[8px]">{{ $indicatorText['english'] ?? ($indicatorText['cebuano'] ?? $indicatorKey) }}</td>
                                        <td class="text-center font-bold">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 1) }}</td>
                                        <td class="text-center font-bold">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 2) }}</td>
                                        <td class="text-center font-bold">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 3) }}</td>
                                        <td class="text-center font-bold">{{ $getKinderRatingSF10($domainKey, $indicatorKey, 4) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr><td colspan="5" class="text-center py-2 text-slate-400 text-[8px]">No kindergarten domain data available</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-2 border-t-2 border-black text-[7px] bg-gray-50">
                    <p class="font-bold">RATING SCALE: B = Beginning | D = Developing | C = Consistent</p>
                </div>
            </div>
        @elseif($academicRecords->isNotEmpty())
            @foreach($academicRecords as $schoolYearId => $yearGrades)
                @php
                    $schoolYearName = $yearGrades->first()?->schoolYear?->name ?? '';
                    $sectionName = $yearGrades->first()?->section?->name ?? '';
                    $gradeLevelName = $yearGrades->first()?->section?->gradeLevel?->name ?? '';
                @endphp
                <div class="scholastic-record mt-3 border-2 border-black">
                    <div class="bg-gray-100 p-2 text-[9px] border-b-2 border-black">
                        <div class="flex justify-between">
                            <span class="font-bold text-[10px]">{{ $gradeLevelName }}</span>
                            <span>School: <span class="underline-field">{{ $schoolName }}</span></span>
                            <span>School ID: <span class="underline-field">{{ $schoolId }}</span></span>
                            <span>School Year: <span class="underline-field">{{ $schoolYearName }}</span></span>
                            <span>Section: <span class="underline-field">{{ $sectionName }}</span></span>
                        </div>
                    </div>
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
                                $subjectGroups = $yearGrades->groupBy(fn($g) => $g->subject?->name ?? 'Unknown');
                                $totalFinal = 0; $subjectCount = 0;
                            @endphp
                            @forelse($subjectGroups as $subjectName => $subjectGrades)
                                @php
                                    $q1 = $subjectGrades->firstWhere('quarter', 1)?->final_grade;
                                    $q2 = $subjectGrades->firstWhere('quarter', 2)?->final_grade;
                                    $q3 = $subjectGrades->firstWhere('quarter', 3)?->final_grade;
                                    $q4 = $subjectGrades->firstWhere('quarter', 4)?->final_grade;
                                    $final = $subjectGrades->firstWhere('quarter', null)?->final_grade ?? $subjectGrades->firstWhere('quarter', 0)?->final_grade;
                                    if (!$final) {
                                        $qs = array_filter([$q1, $q2, $q3, $q4], fn($v) => $v !== null);
                                        $final = count($qs) > 0 ? round(array_sum($qs) / count($qs)) : null;
                                    }
                                    if ($final !== null) { $totalFinal += $final; $subjectCount++; }
                                    $remark = $final !== null ? ($final >= 75 ? 'Passed' : 'Failed') : '';
                                @endphp
                                <tr>
                                    <td class="text-left pl-2 text-[9px]">{{ $subjectName }}</td>
                                    <td>{{ $q1 ?? '' }}</td>
                                    <td>{{ $q2 ?? '' }}</td>
                                    <td>{{ $q3 ?? '' }}</td>
                                    <td>{{ $q4 ?? '' }}</td>
                                    <td class="font-bold">{{ $final ?? '' }}</td>
                                    <td class="text-[8px]">{{ $remark }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center py-2 text-slate-400 text-[8px]">No subjects found</td></tr>
                            @endforelse
                            @if($subjectCount > 0)
                                @php $generalAverage = round($totalFinal / $subjectCount); @endphp
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
                    <div class="p-2 border-t-2 border-black text-[8px] bg-gray-50">
                        <p class="font-bold mb-1">REMEDIAL CLASSES</p>
                        <div class="grid grid-cols-3 gap-4 mb-1">
                            <div>Conducted from: <span class="underline-field w-24"></span></div>
                            <div>To: <span class="underline-field w-24"></span></div>
                            <div>Final Rating: <span class="underline-field w-16"></span></div>
                        </div>
                        <div class="mb-1"><span class="font-semibold">Learning Areas for Remedial:</span><span class="border-b border-black inline-block w-96"></span></div>
                        <div><span class="font-semibold">Remarks:</span><span class="border-b border-black inline-block flex-1"></span></div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-4 text-center text-slate-500 text-sm border border-dashed border-slate-300 rounded-lg mt-3">
                No academic records found for this student.
            </div>
        @endif
    </div>

    <!-- Certification -->
    <div class="mb-3 border-2 border-black p-3">
        <h3 class="section-header">CERTIFICATION</h3>
        <p class="text-[10px] leading-relaxed mt-3">
            I CERTIFY that this is a true record of <strong class="uppercase">{{ $user->last_name ?? '' }}, {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }}</strong>
            with LRN <strong>{{ $selectedStudent->lrn ?? '' }}</strong> and that he/she is eligible for admission to Grade <span class="underline-field w-16"></span>.
        </p>
        <div class="mt-3 grid grid-cols-2 gap-6 text-[9px]">
            <div class="space-y-1">
                <p>Name of School: <span class="underline-field">{{ $schoolName }}</span></p>
                <p>School ID: <span class="underline-field">{{ $schoolId }}</span></p>
                <p>District: <span class="underline-field">{{ $schoolDistrict }}</span></p>
                <p>Division: <span class="underline-field">{{ $schoolDivision }}</span></p>
            </div>
            <div class="space-y-1">
                <p>Last School Year Attended: <span class="underline-field">{{ $activeSchoolYear?->name ?? '' }}</span></p>
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

    <!-- Footer -->
    <div class="mt-2 pt-2 border-t border-black text-[8px] text-black flex justify-between font-semibold">
        <span>DepEd School Form 10-ES - Revised 2025</span>
        <span>Date Generated: {{ now()->format('F d, Y') }}</span>
    </div>
</div>
@else
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center">
        <p class="text-amber-800 font-medium">Please select a student to view the permanent record.</p>
    </div>
@endif
