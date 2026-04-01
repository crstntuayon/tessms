<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\Setting;
use App\Models\CoreValue;

class SchoolFormController extends Controller
{
    /**
     * Get logged-in teacher sections
     */
    private function getTeacherSections()
    {
        $teacher = Auth::user()->teacher;

        return Section::with(['students.user', 'gradeLevel', 'teacher.user'])
            ->where('teacher_id', $teacher->id)
            ->where('is_active', 1)
            ->get();
    }

    /**
     * SF1 - School Register (Student List)
     */
 public function sf1(Request $request)
{
    $sections = $this->getTeacherSections();
    
    // Get active school year from settings
    $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
    $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
    
    $schoolYear = $activeSchoolYear ? $activeSchoolYear->name : '2025-2026';
    $schoolYearStart = $activeSchoolYear ? Carbon::parse($activeSchoolYear->start_date)->year : 2025;
    
    // Get school settings
    $schoolSettings = Setting::where('group', 'school')->get()->keyBy('key')->map->value;
    
    $schoolId = $schoolSettings['deped_school_id'] ?? '_______';
    $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
    $schoolDivision = $schoolSettings['school_division'] ?? '_______';
    $schoolRegion = $schoolSettings['school_region'] ?? '_______';
    $schoolHead = $schoolSettings['school_head'] ?? '_______';
    
    // Get selected section with teacher
    $selectedSection = $request->section_id 
        ? Section::with(['gradeLevel', 'teacher.user'])->find($request->section_id)
        : $sections->first();

    // Get adviser name from section's teacher
    $adviserName = '___________';
    if ($selectedSection && $selectedSection->teacher) {
        $teacherUser = $selectedSection->teacher->user;
        if ($teacherUser) {
            $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                          ($teacherUser->first_name ?? '') . ' ' . 
                          ($teacherUser->middle_name ?? '');
            $adviserName = trim($adviserName) ?: $teacherUser->name ?? '___________';
        } else {
            $adviserName = $selectedSection->teacher->name ?? '___________';
        }
    }

    // Get enrolled students with user data (for names)
    $enrollments = collect();
    $maleCount = 0;
    $femaleCount = 0;

    if ($selectedSection && $activeSchoolYear) {
        $enrollments = Enrollment::with(['student.user'])
            ->where('section_id', $selectedSection->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->where('status', 'enrolled')
            ->get()
            ->sortBy(function ($enrollment) {
                $student = $enrollment->student;
                $gender = strtoupper($student->gender ?? '');
                // Males first (0), then females (1)
                $genderOrder = ($gender == 'MALE' || $gender == 'M') ? 0 : 1;
                
                $user = $student->user;
                $lastName = $user->last_name ?? '';
                $firstName = $user->first_name ?? '';
                
                return [$genderOrder, $lastName, $firstName];
            })
            ->values();

        // Count gender
        $maleCount = $enrollments->filter(function ($e) {
            $gender = strtoupper($e->student->gender ?? '');
            return $gender == 'MALE' || $gender == 'M';
        })->count();

        $femaleCount = $enrollments->filter(function ($e) {
            $gender = strtoupper($e->student->gender ?? '');
            return $gender == 'FEMALE' || $gender == 'F';
        })->count();

        // Process enrollments to calculate age
        foreach ($enrollments as $enrollment) {
            $student = $enrollment->student;
            if ($student) {
                // Calculate age using birthdate
                $age = $this->calculateAge($student->birthdate, $schoolYearStart);
                
                // Store age using setAttribute which properly tracks changes
                $student->setAttribute('calculated_age', $age);
                
                // Make the attribute visible when converting to array
                $student->makeVisible(['calculated_age']);
            }
        }
    }

    return view('teacher.school-forms.sf1', compact(
        'sections',
        'selectedSection',
        'adviserName',
        'enrollments',
        'schoolYear',
        'schoolYearStart',
        'schoolId',
        'schoolName',
        'schoolDivision',
        'schoolRegion',
        'schoolHead',
        'maleCount',
        'femaleCount',
        'activeSchoolYear'
    ));
}

/**
 * Calculate age as of first Friday of June
 */
public function calculateAge($birthDate, $year)
{
    if (!$birthDate) return '';
    
    try {
        $birth = Carbon::parse($birthDate);
        $juneFirst = Carbon::create($year, 6, 1);
        
        // Find first Friday of June
        if ($juneFirst->isFriday()) {
            $firstFriday = $juneFirst;
        } else {
            $firstFriday = $juneFirst->copy()->next(Carbon::FRIDAY);
        }
        
        // Use floor() to get whole number
        return floor($birth->diffInYears($firstFriday));
        
    } catch (\Exception $e) {
        return '';
    }
}

    /**
     * SF2 - Daily Attendance
     */
   
# Create the updated SF2 Controller method

    public function sf2(Request $request)
    {
        $sections = $this->getTeacherSections();
        
        // Get active school year from settings
        $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
        $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
        
        $schoolYear = $activeSchoolYear ? $activeSchoolYear->name : '2025-2026';
        
        // Get school settings
        $schoolSettings = Setting::where('group', 'school')->get()->keyBy('key')->map->value;
        
        $schoolId = $schoolSettings['deped_school_id'] ?? '_______';
        $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
        $schoolHead = $schoolSettings['school_head'] ?? '_______';
        
        // Get selected section
        $selectedSection = $request->section_id 
            ? Section::with(['gradeLevel', 'teacher.user'])->find($request->section_id)
            : $sections->first();
        
        // Get selected month (default to current month or June)
        $selectedMonth = $request->month ?? 'June';
        
        // Get adviser name from section's teacher
        $adviserName = '___________';
        if ($selectedSection && $selectedSection->teacher) {
            $teacherUser = $selectedSection->teacher->user;
            if ($teacherUser) {
                $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                              ($teacherUser->first_name ?? '') . ' ' . 
                              ($teacherUser->middle_name ?? '');
                $adviserName = trim($adviserName) ?: $teacherUser->name ?? '___________';
            } else {
                $adviserName = $selectedSection->teacher->name ?? '___________';
            }
        }

        // Get enrolled students sorted by gender (Male first) then alphabetically
        $enrollments = collect();
        
        if ($selectedSection && $activeSchoolYear) {
            $enrollments = Enrollment::with(['student.user'])
                ->where('section_id', $selectedSection->id)
                ->where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->get()
                ->sortBy(function ($enrollment) {
                    $student = $enrollment->student;
                    $gender = strtoupper($student->gender ?? '');
                    // Males first (0), then females (1)
                    $genderOrder = ($gender == 'MALE' || $gender == 'M') ? 0 : 1;
                    
                    $user = $student->user;
                    $lastName = $user->last_name ?? '';
                    $firstName = $user->first_name ?? '';
                    
                    return [$genderOrder, $lastName, $firstName];
                })
                ->values();
        }

        // Get attendances for the selected month
        $attendances = collect();
        if ($selectedSection && $activeSchoolYear) {
            $year = $activeSchoolYear ? \Carbon\Carbon::parse($activeSchoolYear->start_date)->year : date('Y');
            $monthNum = date('n', strtotime($selectedMonth));
            
            $attendances = Attendance::whereIn(
                'student_id',
                $enrollments->pluck('student.id')
            )
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->get();
        }

        // Calculate summary statistics
        $lateEnrollments = 0;
        $consecutiveAbsences = 0;
        $dropoutMale = 0;
        $dropoutFemale = 0;
        $transferredOutMale = 0;
        $transferredOutFemale = 0;
        $transferredInMale = 0;
        $transferredInFemale = 0;
        $averageDailyAttendance = '';
        $attendancePercentage = '';

        return view('teacher.school-forms.sf2', compact(
            'sections',
            'selectedSection',
            'adviserName',
            'enrollments',
            'attendances',
            'schoolYear',
            'activeSchoolYear',
            'schoolId',
            'schoolName',
            'schoolHead',
            'selectedMonth',
            'lateEnrollments',
            'consecutiveAbsences',
            'dropoutMale',
            'dropoutFemale',
            'transferredOutMale',
            'transferredOutFemale',
            'transferredInMale',
            'transferredInFemale',
            'averageDailyAttendance',
            'attendancePercentage'
        ));
    }
 

    public function sf5(Request $request)
    {
        $sections = $this->getTeacherSections();
        
        // Get active school year from settings
        $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
        $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
        
        $schoolYear = $activeSchoolYear ? $activeSchoolYear->name : '2025-2026';
        
        // Get school settings
        $schoolSettings = Setting::where('group', 'school')->get()->keyBy('key')->map->value;
        
        $schoolId = $schoolSettings['deped_school_id'] ?? '_______';
        $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
        $schoolDivision = $schoolSettings['school_division'] ?? '_______';
        $schoolRegion = $schoolSettings['school_region'] ?? '_______';
        $schoolDistrict = $schoolSettings['school_district'] ?? '_______';
        $schoolHead = $schoolSettings['school_head'] ?? '_______';
        
        // Get selected section
        $selectedSection = $request->section_id 
            ? Section::with(['gradeLevel', 'teacher.user'])->find($request->section_id)
            : $sections->first();
        
        // Get adviser name from section's teacher
        $adviserName = '___________';
        if ($selectedSection && $selectedSection->teacher) {
            $teacherUser = $selectedSection->teacher->user;
            if ($teacherUser) {
                $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                              ($teacherUser->first_name ?? '') . ' ' . 
                              ($teacherUser->middle_name ?? '');
                $adviserName = trim($adviserName) ?: $teacherUser->name ?? '___________';
            } else {
                $adviserName = $selectedSection->teacher->name ?? '___________';
            }
        }

        // Get enrolled students sorted by gender (Male first) then alphabetically
        $enrollments = collect();
        $grades = collect();

        if ($selectedSection && $activeSchoolYear) {
            $enrollments = Enrollment::with(['student.user'])
                ->where('section_id', $selectedSection->id)
                ->where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->get()
                ->sortBy(function ($enrollment) {
                    $student = $enrollment->student;
                    $gender = strtoupper($student->gender ?? '');
                    // Males first (0), then females (1)
                    $genderOrder = ($gender == 'MALE' || $gender == 'M') ? 0 : 1;
                    
                    $user = $student->user;
                    $lastName = $user->last_name ?? '';
                    $firstName = $user->first_name ?? '';
                    
                    return [$genderOrder, $lastName, $firstName];
                })
                ->values();

            // Get grades for enrolled students
            $grades = Grade::whereIn(
                'student_id',
                $enrollments->pluck('student.id')
            )->get();
        }

        return view('teacher.school-forms.sf5', compact(
            'sections',
            'selectedSection',
            'adviserName',
            'enrollments',
            'grades',
            'schoolYear',
            'activeSchoolYear',
            'schoolId',
            'schoolName',
            'schoolDivision',
            'schoolRegion',
            'schoolDistrict',
            'schoolHead'
        ));
    }

    /**
     * Calculate Final Grade
     */
    public function calculateFinal($grade)
    {
        $ww = $grade->written_works_avg ?? 0;
        $pt = $grade->performance_tasks_avg ?? 0;

        return round(($ww * 0.4) + ($pt * 0.6), 2);
    }



    

public function sf9(Request $request)
{
    $sections = $this->getTeacherSections();
    
    // Get active school year from settings
    $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
    $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
    
    $schoolYear = $activeSchoolYear ? $activeSchoolYear->name : '2025-2026';
    
    // Get school settings
    $schoolSettings = Setting::whereIn('group', ['school', 'general'])->get()->keyBy('key')->map->value;
    
    $schoolId = $schoolSettings['deped_school_id'] ?? '_______';
    $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
    $schoolDivision = $schoolSettings['school_division'] ?? '_______';
    $schoolRegion = $schoolSettings['school_region'] ?? '_______';
    $schoolDistrict = $schoolSettings['school_district'] ?? '_______';
    $schoolHead = $schoolSettings['school_head'] ?? '_______';
    
    // Get all students from teacher's sections
    $students = collect();
    foreach ($sections as $section) {
        $sectionStudents = Student::with(['user', 'section.gradeLevel'])
            ->whereHas('enrollments', function($q) use ($activeSchoolYear) {
                $q->where('school_year_id', $activeSchoolYear->id)
                  ->where('status', 'enrolled');
            })
            ->where('section_id', $section->id)
            ->get();
        $students = $students->merge($sectionStudents);
    }
    $students = $students->unique('id')->sortBy('user.last_name');
    
    // Get selected student
    $selectedStudent = $request->student_id
        ? Student::with(['user', 'section.gradeLevel.subjects', 'section.teacher.user'])->find($request->student_id)
        : null;
    
    // Get adviser name
    $adviserName = '___________';
    if ($selectedStudent && $selectedStudent->section && $selectedStudent->section->teacher) {
        $teacherUser = $selectedStudent->section->teacher->user;
        if ($teacherUser) {
            $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                          ($teacherUser->first_name ?? '') . ' ' . 
                          ($teacherUser->middle_name ?? '');
            $adviserName = trim($adviserName) ?: $teacherUser->name ?? '___________';
        } else {
            $adviserName = $selectedStudent->section->teacher->name ?? '___________';
        }
    }

    // Get grades for selected student
    $subjectGrades = collect();
    $attendances = collect();
    $generalAverage = null;
    $coreValues = collect(); // Initialize core values collection
    
    if ($selectedStudent) {
        // Get attendance records
        $attendances = Attendance::where('student_id', $selectedStudent->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->get();
        
       
 // Get core values records - GROUPED by core_value and quarter
$coreValues = CoreValue::where('student_id', $selectedStudent->id)
    ->where('school_year_id', $activeSchoolYear->id)
    ->get()
    ->groupBy(['core_value', 'statement_key']);
        
        // Build subject grades array from grade level subjects
        $gradeLevelSubjects = $selectedStudent->section->gradeLevel->subjects ?? collect();
        
        $totalFinalGrade = 0;
        $gradedSubjectsCount = 0;
        
        foreach ($gradeLevelSubjects as $subject) {
            // Get all final_grade records for this subject (quarters 1-4 and year-end)
            $allGrades = Grade::where([
                'student_id' => $selectedStudent->id,
                'subject_id' => $subject->id,
                'school_year_id' => $activeSchoolYear->id,
                'component_type' => 'final_grade',
            ])->get()->keyBy('quarter');
            
            // Extract quarter grades (quarter 1-4)
            $q1 = $allGrades->get(1)?->final_grade;
            $q2 = $allGrades->get(2)?->final_grade;
            $q3 = $allGrades->get(3)?->final_grade;
            $q4 = $allGrades->get(4)?->final_grade;
            
            // Get year-end final grade (quarter = NULL or 0)
            $yearEndGrade = $allGrades->get(null)?->final_grade ?? $allGrades->get(0)?->final_grade;
            
            // If no year-end grade, calculate average of available quarters
            $finalGrade = $yearEndGrade;
            if (!$finalGrade) {
                $quarters = array_filter([$q1, $q2, $q3, $q4], fn($q) => $q !== null);
                if (count($quarters) > 0) {
                    $finalGrade = round(array_sum($quarters) / count($quarters));
                }
            }
            
            $remarks = '';
            if ($finalGrade !== null) {
                $remarks = $finalGrade >= 75 ? 'Passed' : 'Failed';
                $totalFinalGrade += $finalGrade;
                $gradedSubjectsCount++;
            }
            
            $subjectGrades->push([
                'subject_id' => $subject->id,
                'subject_name' => $subject->name,
                'subject_code' => $subject->code,
                'quarter_1' => $q1,
                'quarter_2' => $q2,
                'quarter_3' => $q3,
                'quarter_4' => $q4,
                'final_grade' => $finalGrade,
                'remarks' => $remarks,
            ]);
        }
        
        // Calculate general average
        $generalAverage = $gradedSubjectsCount > 0 ? round($totalFinalGrade / $gradedSubjectsCount) : null;
    }

    return view('teacher.school-forms.sf9', compact(
        'students',
        'selectedStudent',
        'adviserName',
        'subjectGrades',
        'generalAverage',
        'attendances',
        'coreValues', // Add to compact
        'schoolYear',
        'activeSchoolYear',
        'schoolId',
        'schoolName',
        'schoolDivision',
        'schoolRegion',
        'schoolDistrict',
        'schoolHead'
    ));
}



    /**
     * SF10 - Learner's Permanent Academic Record (Form 137)
     */


public function sf10(Request $request)
{
    // Get teacher's sections
    $sections = $this->getTeacherSections();

    // Active school year
    $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
    $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
    $schoolYear = $activeSchoolYear->name ?? '2025-2026';

    // School settings
    $schoolSettings = Setting::whereIn('group', ['school', 'general'])
        ->get()->keyBy('key')->map->value;
    $schoolId = $schoolSettings['deped_school_id'] ?? '';
    $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
    $schoolDivision = $schoolSettings['school_division'] ?? '';
    $schoolRegion = $schoolSettings['school_region'] ?? '';
    $schoolDistrict = $schoolSettings['school_district'] ?? '';
    $schoolHead = $schoolSettings['school_head'] ?? '';

    // Get all students from teacher's sections (same pattern as SF9)
    $students = collect();
    foreach ($sections as $section) {
        $sectionStudents = Student::with(['user', 'section.gradeLevel'])
            ->whereHas('enrollments', function($q) use ($activeSchoolYear) {
                $q->where('school_year_id', $activeSchoolYear->id)
                  ->where('status', 'enrolled');
            })
            ->where('section_id', $section->id)
            ->get();
        $students = $students->merge($sectionStudents);
    }
    $students = $students->unique('id')->sortBy('user.last_name');

    // Selected student
    $selectedStudent = $request->student_id
        ? Student::with(['user', 'section.gradeLevel.subjects', 'section.teacher.user'])->find($request->student_id)
        : null;

    // Get adviser name (same pattern as SF9)
    $adviserName = '';
    if ($selectedStudent && $selectedStudent->section && $selectedStudent->section->teacher) {
        $teacherUser = $selectedStudent->section->teacher->user;
        if ($teacherUser) {
            $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                          ($teacherUser->first_name ?? '') . ' ' . 
                          ($teacherUser->middle_name ?? '');
            $adviserName = trim($adviserName) ?: ($teacherUser->name ?? '');
        } else {
            $adviserName = $selectedStudent->section->teacher->name ?? '';
        }
    }

    // Define all elementary grade levels (Kinder to Grade 6)
    $allGradeLevels = ['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'];
    
    // Get student's current grade level
    $currentGradeLevel = null;
    if ($selectedStudent && $selectedStudent->section && $selectedStudent->section->gradeLevel) {
        $currentGradeLevel = $selectedStudent->section->gradeLevel->name;
    }

    // Load data for all grade levels
    $subjectsByGrade = [];
    $historicalGrades = [];
    $schoolHistory = [];

    if ($selectedStudent) {
        // Get all grade levels from the database
        $gradeLevels = \App\Models\GradeLevel::whereIn('name', $allGradeLevels)
            ->orderByRaw("FIELD(name, 'Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6')")
            ->get()
            ->keyBy('name');

        foreach ($allGradeLevels as $gradeLevelName) {
            $gradeLevel = $gradeLevels[$gradeLevelName] ?? null;
            
            if ($gradeLevel) {
                // Get subjects for this grade level
                $subjectsByGrade[$gradeLevelName] = Subject::where('grade_level_id', $gradeLevel->id)
                    ->orderBy('name')
                    ->get();
            } else {
                $subjectsByGrade[$gradeLevelName] = collect();
            }

            // Get grades for this student in this grade level (same pattern as SF9)
            $grades = Grade::with(['subject', 'section.gradeLevel'])
                ->where('student_id', $selectedStudent->id)
                ->where('school_year_id', $activeSchoolYear->id)
                ->whereHas('section.gradeLevel', function ($q) use ($gradeLevelName) {
                    $q->where('name', $gradeLevelName);
                })
                ->where('component_type', 'final_grade')
                ->get();

            // Group grades by subject_id and quarter for easy access
            $groupedGrades = $grades->groupBy('subject_id')->map(function($subjectGrades) {
                return $subjectGrades->keyBy('quarter');
            });

            $historicalGrades[$gradeLevelName] = $groupedGrades;

            // Build school history for this grade level
            $gradeRecord = $grades->first();
            if ($gradeRecord && $gradeRecord->section) {
                $sectionTeacher = $gradeRecord->section->teacher;
                $teacherFullName = '';
                if ($sectionTeacher && $sectionTeacher->user) {
                    $tUser = $sectionTeacher->user;
                    $teacherFullName = ($tUser->last_name ?? '') . ', ' . 
                                     ($tUser->first_name ?? '') . ' ' . 
                                     ($tUser->middle_name ?? '');
                    $teacherFullName = trim($teacherFullName) ?: ($tUser->name ?? '');
                }
                
                $schoolHistory[$gradeLevelName] = (object)[
                    'school_name' => $schoolName,
                    'school_id' => $schoolId,
                    'district' => $schoolDistrict,
                    'division' => $schoolDivision,
                    'region' => $schoolRegion,
                    'section' => $gradeRecord->section->name ?? '',
                    'school_year' => $schoolYear,
                    'adviser' => $teacherFullName
                ];
            } else {
                // Use current section info if this is the current grade level
                $isCurrentGrade = ($gradeLevelName === $currentGradeLevel);
                $schoolHistory[$gradeLevelName] = (object)[
                    'school_name' => $schoolName,
                    'school_id' => $schoolId,
                    'district' => $schoolDistrict,
                    'division' => $schoolDivision,
                    'region' => $schoolRegion,
                    'section' => $isCurrentGrade ? ($selectedStudent->section->name ?? '') : '',
                    'school_year' => $isCurrentGrade ? $schoolYear : '',
                    'adviser' => $isCurrentGrade ? $adviserName : ''
                ];
            }
        }
    }

    return view('teacher.school-forms.sf10', compact(
        'students',
        'selectedStudent',
        'adviserName',
        'subjectsByGrade',
        'historicalGrades',
        'schoolHistory',
        'schoolYear',
        'activeSchoolYear',
        'schoolId',
        'schoolName',
        'schoolDivision',
        'schoolRegion',
        'schoolDistrict',
        'schoolHead',
        'currentGradeLevel',
        'allGradeLevels'
    ));
}
}