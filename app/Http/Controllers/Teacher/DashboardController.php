<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller; // must import the base controller
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Subject;
use Carbon\Carbon;

class DashboardController extends Controller
{


    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        
        $teacher = Teacher::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => explode(' ', $user->name)[0] ?? 'Teacher',
                'last_name'  => explode(' ', $user->name)[1] ?? '',
            ]
        );

        // -----------------------------
        // Active Section
        // -----------------------------
        $activeSection = $request->section_id
            ? Section::with(['students.attendances', 'students.grades'])->find($request->section_id)
            : $teacher->sections()->with(['students.attendances', 'students.grades'])->first();

        $students = $activeSection ? $activeSection->students : collect();

        // -----------------------------
        // School Year & Quarter
        // -----------------------------
        $schoolYear = now()->year . '-' . (now()->year + 1);
        $currentQuarter = '1st';
        $currentQuarterNumber = 1;

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

        $totalToday = max($students->count(), 1);
        $todayAttendanceRate = round(($todayStats['present'] / $totalToday) * 100);

        // -----------------------------
        // Students Count
        // -----------------------------
        $totalStudents = $students->count();
        $maleStudents = $students->where('gender', 'male')->count();
        $femaleStudents = $students->where('gender', 'female')->count();

        // -----------------------------
        // Grades
        // -----------------------------
        $grades = Grade::whereIn('student_id', $students->pluck('id'))->get();
        $pendingGradesCount = $students->count() - $grades->groupBy('student_id')->count();
        $overdueGrading = 0;

        // -----------------------------
        // Subjects & Stats
        // -----------------------------
        $subjects = Subject::all();
        $subjectStats = [];

        foreach ($subjects as $subject) {
            $subjectGrades = $grades->where('subject_id', $subject->id);

            $avg = $subjectGrades->avg(function ($g) {
                return $this->calculateFinalGrade($g);
            });

            $subjectStats[] = [
                'subject_id'      => $subject->id,
                'name'            => $subject->name,
                'code'            => $subject->code ?? '',
                'class_average'   => $avg ?? 0,
                'encoded_count'   => $subjectGrades->count(),
                'at_risk_count'   => $subjectGrades->filter(fn($g) => $this->calculateFinalGrade($g) < 75)->count(),
                'ww_weight'       => 30,
                'pt_weight'       => 50,
                'color'           => 'blue',
                'icon'            => 'fa-book'
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
        $failingGradesCount = $grades->filter(fn($g) => $this->calculateFinalGrade($g) < 75)->count();
        $chronicAbsentees = 0;

        // -----------------------------
        // Recent Grades
        // -----------------------------
        $recentGrades = Grade::with(['student', 'subject'])
            ->whereIn('student_id', $students->pluck('id'))
            ->latest()
            ->take(5)
            ->get();

        // -----------------------------
        // Notifications
        // -----------------------------
        $notifications = $user->notifications()->take(5)->get();
        $unreadNotifications = $user->unreadNotifications()->count();

        // -----------------------------
        // Deadlines
        // -----------------------------
        $upcomingDeadlines = collect([]);

        // -----------------------------
        // School Days
        // -----------------------------
        $schoolDaysTotal = 200;
        $daysCompleted = now()->dayOfYear;

        // -----------------------------
        // Return view
        // -----------------------------
        return view('teacher.dashboard', compact(
            'teacher',
            'students',
            'activeSection',
            'schoolYear',
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
            'notifications',
            'unreadNotifications',
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

        return round(($ww * 0.3) + ($pt * 0.5) + ($qa * 0.2));
    }
}