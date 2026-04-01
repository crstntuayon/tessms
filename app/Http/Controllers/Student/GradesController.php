<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\CoreValue;
use App\Models\SchoolYear;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradesController extends Controller
{
    /**
     * Display SF9-style grades report for the authenticated student
     */
    public function index(Request $request)
    {
        // Get authenticated student with relationships
        $user = Auth::user();
        $student = Student::with(['user', 'section.gradeLevel.subjects', 'section.teacher.user'])
            ->where('user_id', $user->id)
            ->first();

        if (!$student) {
            abort(404, 'Student record not found');
        }

        // Get active school year
        $activeSchoolYearId = Setting::where('key', 'active_school_year_id')->value('value') ?? 1;
        $activeSchoolYear = SchoolYear::find($activeSchoolYearId) ?? SchoolYear::where('is_active', true)->first();
        $schoolYear = $activeSchoolYear ? $activeSchoolYear->name : date('Y') . '-' . (date('Y') + 1);

        // Get school settings from database
        $schoolSettings = Setting::whereIn('group', ['school', 'general'])->get()->keyBy('key')->map->value;
        
        $schoolId = $schoolSettings['deped_school_id'] ?? '120231';
        $schoolName = $schoolSettings['school_name'] ?? 'TUGAWE ELEMENTARY SCHOOL';
        $schoolDivision = $schoolSettings['school_division'] ?? '_______';
        $schoolRegion = $schoolSettings['school_region'] ?? '_______';
        $schoolDistrict = $schoolSettings['school_district'] ?? '_______';
        $schoolHead = $schoolSettings['school_head'] ?? '_______';

        // Calculate age from birthdate
        $age = null;
        if ($student->user->date_of_birth) {
            $age = \Carbon\Carbon::parse($student->user->date_of_birth)->age;
        } elseif ($student->age) {
            $age = $student->age;
        }

        // Get adviser name from section teacher
        $adviserName = '___________';
        if ($student->section && $student->section->teacher) {
            $teacherUser = $student->section->teacher->user;
            if ($teacherUser) {
                $adviserName = ($teacherUser->last_name ?? '') . ', ' . 
                              ($teacherUser->first_name ?? '') . ' ' . 
                              ($teacherUser->middle_name ?? '');
                $adviserName = trim($adviserName) ?: ($teacherUser->name ?? '___________');
            } else {
                $adviserName = $student->section->teacher->name ?? '___________';
            }
        }

        // Get attendance records for the school year
        $attendances = Attendance::where('student_id', $student->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->get();

        // Get core values records grouped by core_value and statement_key
        $coreValues = CoreValue::where('student_id', $student->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->get()
            ->groupBy(['core_value', 'statement_key']);

        // Build subject grades from grade level subjects
        $subjectGrades = collect();
        $gradeLevelSubjects = $student->section->gradeLevel->subjects ?? collect();
        
        $totalFinalGrade = 0;
        $gradedSubjectsCount = 0;
        
        foreach ($gradeLevelSubjects as $subject) {
            // Get all final_grade records for this subject (quarters 1-4 and year-end)
            $allGrades = Grade::where([
                'student_id' => $student->id,
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

        // Calculate attendance rate for stats
        $totalSchoolDays = $attendances->sum('school_days') ?? 0;
        $totalPresent = $attendances->sum('days_present') ?? 0;
        $attendanceRate = $totalSchoolDays > 0 ? round(($totalPresent / $totalSchoolDays) * 100, 1) : 0;

        return view('student.grades.index', compact(
            'student',
            'schoolYear',
            'activeSchoolYear',
            'schoolId',
            'schoolName',
            'schoolDivision',
            'schoolRegion',
            'schoolDistrict',
            'schoolHead',
            'age',
            'adviserName',
            'subjectGrades',
            'generalAverage',
            'attendances',
            'coreValues',
            'attendanceRate'
        ));
    }
}
