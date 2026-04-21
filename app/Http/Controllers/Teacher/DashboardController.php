<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Student; 
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Subject;
use Carbon\Carbon;
use App\Models\SchoolYear;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // -----------------------------
        // Logged-in user
        // -----------------------------
        $user = auth()->user();

        if (!$user) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        // -----------------------------
        // Teacher record (auto create if missing)
        // -----------------------------
        $teacher = Teacher::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $user->first_name ?? 'Teacher',
                'last_name'  => $user->last_name ?? '',
                'email'      => $user->email,
            ]
        );

        // -----------------------------
        // Active School Year
        // -----------------------------
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        // -----------------------------
        // Sections assigned to teacher (filtered by active school year)
        // -----------------------------
        $sections = Section::with(['students.user', 'teacher.user', 'gradeLevel'])
            ->where('teacher_id', $teacher->id)
            ->when($activeSchoolYear, function ($query) use ($activeSchoolYear) {
                $query->where('school_year_id', $activeSchoolYear->id);
            })
            ->where('is_active', true)
            ->get();

        // -----------------------------
        // Active Section (secured)
        // -----------------------------
        $activeSection = null;

        if ($request->section_id) {
            // Only allow teacher's own sections
            $activeSection = $sections->where('id', $request->section_id)->first();
        }

        // Default to first section
        if (!$activeSection) {
            $activeSection = $sections->first();
        }

        // -----------------------------
        // Students - FILTERED to exclude completed/inactive
        // -----------------------------
        $students = $activeSection
            ? $activeSection->students()
                ->whereHas('enrollment', function($query) {
                    // Exclude students with completed or inactive enrollment status
                    $query->whereNotIn('status', ['completed', 'inactive']);
                })
                ->where('students.status', '!=', 'inactive') // Also check students table status
                ->with('user')
                ->get()
            : collect();

        // -----------------------------
        // Student Counts
        // -----------------------------
        $totalStudents  = $students->count();
        $maleStudents   = $students->where('gender', 'male')->count();
        $femaleStudents = $students->where('gender', 'female')->count();

        // -----------------------------
        // Quarter Logic
        // -----------------------------
        $month = Carbon::now()->month;

        if ($month >= 6 && $month <= 8) {
            $currentQuarter = '1st';
            $currentQuarterNumber = 1;
        } elseif ($month >= 9 && $month <= 11) {
            $currentQuarter = '2nd';
            $currentQuarterNumber = 2;
        } elseif ($month == 12 || $month <= 2) {
            $currentQuarter = '3rd';
            $currentQuarterNumber = 3;
        } else {
            $currentQuarter = '4th';
            $currentQuarterNumber = 4;
        }

        // -----------------------------
        // Attendance Today
        // -----------------------------
        $today = Carbon::today();

        $todayAttendances = Attendance::whereDate('date', $today)
            ->whereIn('student_id', $students->pluck('id'))
            ->get();

        $todayStats = [
            'present' => $todayAttendances->where('status', 'present')->count(),
            'absent'  => $todayAttendances->where('status', 'absent')->count(),
            'late'    => $todayAttendances->where('status', 'late')->count(),
        ];

        $todayAttendanceRate = $totalStudents 
            ? round(($todayStats['present'] / $totalStudents) * 100)
            : 0;

        // -----------------------------
        // Grades
        // -----------------------------
        $grades = Grade::whereIn('student_id', $students->pluck('id'))->get();

        $pendingGradesCount = $totalStudents - $grades->groupBy('student_id')->count();
        $overdueGrading = 0;

        // -----------------------------
        // Subjects (optimized)
        // -----------------------------
        $subjects = Subject::whereHas('grades', function ($query) use ($students) {
            $query->whereIn('student_id', $students->pluck('id'));
        })->get();

        $subjectStats = [];

        foreach ($subjects as $subject) {
            $subjectGrades = $grades->where('subject_id', $subject->id);

            $avg = $subjectGrades->avg(fn($g) => $this->calculateFinalGrade($g));

            $subjectStats[] = [
                'subject_id'    => $subject->id,
                'name'          => $subject->name,
                'code'          => $subject->code ?? '',
                'class_average' => $avg ?? 0,
                'encoded_count' => $subjectGrades->count(),
                'at_risk_count' => $subjectGrades
                    ->filter(fn($g) => $this->calculateFinalGrade($g) < 75)
                    ->count(),
                'ww_weight'     => 40,
                'pt_weight'     => 40,
                'color'         => 'blue',
                'icon'          => 'fa-book'
            ];
        }

        // -----------------------------
        // At-Risk Students
        // -----------------------------
        $atRiskStudents = $students->filter(function ($student) use ($grades) {
            return $grades->where('student_id', $student->id)
                ->filter(fn($g) => $this->calculateFinalGrade($g) < 75)
                ->count() > 0;
        });

        $atRiskCount = $atRiskStudents->count();

        $failingGradesCount = $grades
            ->filter(fn($g) => $this->calculateFinalGrade($g) < 75)
            ->count();

        $chronicAbsentees = 0;

        // -----------------------------
        // Recent Grades
        // -----------------------------
        $recentGrades = Grade::with(['student.user', 'subject'])
            ->whereIn('student_id', $students->pluck('id'))
            ->latest()
            ->take(5)
            ->get();

        // -----------------------------
        // Upcoming Events
        // -----------------------------
        $upcomingEvents = \App\Models\Event::where('date', '>=', today())
            ->orderBy('date')
            ->limit(3)
            ->get();

        // -----------------------------
        // Misc
        // -----------------------------
        $upcomingDeadlines = collect();
        $schoolDaysTotal = 200;
        $daysCompleted = now()->dayOfYear;

        // -----------------------------
        // Return View
        // -----------------------------
        return view('teacher.dashboard', compact(
            'teacher',
            'sections',
            'students',
            'activeSection',
            'activeSchoolYear',
            'currentQuarter',
            'currentQuarterNumber',
            'todayStats',
            'todayAttendanceRate',
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'pendingGradesCount',
            'overdueGrading',
            'subjects',
            'subjectStats',
            'atRiskStudents',
            'atRiskCount',
            'failingGradesCount',
            'chronicAbsentees',
            'recentGrades',
            'upcomingEvents',
            'upcomingDeadlines',
            'schoolDaysTotal',
            'daysCompleted'
        ));
    }

    /**
     * Calculate final grade
     */
    private function calculateFinalGrade($grade)
    {
        $ww = $grade->written_works_avg ?? 0;
        $pt = $grade->performance_tasks_avg ?? 0;
        $qa = $grade->quarterly_assessment ?? 0;

        return round(($ww * 0.4) + ($pt * 0.4) + ($qa * 0.2));
    }
}