<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportTemplate;
use App\Models\SavedReport;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportingController extends Controller
{
    /**
     * Main reporting dashboard
     */
    public function index()
    {
        $categories = ReportTemplate::getCategories();
        $templates = ReportTemplate::active()->orderBy('name')->get();
        $favorites = SavedReport::favorites()
            ->byUser(auth()->id())
            ->with('template')
            ->limit(5)
            ->get();
        $recentReports = SavedReport::byUser(auth()->id())
            ->recent()
            ->with('template')
            ->limit(10)
            ->get();

        // Real-time stats
        $stats = $this->getDashboardStats();

        return view('admin.reports.index', compact(
            'categories',
            'templates',
            'favorites',
            'recentReports',
            'stats'
        ));
    }

    /**
     * Get real-time dashboard statistics
     */
    protected function getDashboardStats(): array
    {
        $currentSchoolYear = SchoolYear::where('is_active', true)->first();
        $schoolYearId = $currentSchoolYear?->id;

        return [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_sections' => Section::count(),
            'active_enrollments' => $schoolYearId ? Enrollment::where('school_year_id', $schoolYearId)->count() : 0,
            'today_attendance' => $this->getTodayAttendanceStats(),
            'grade_averages' => $this->getGradeAverages(),
            'enrollment_trend' => $this->getEnrollmentTrend(),
            'attendance_trend' => $this->getAttendanceTrend(30),
        ];
    }

    /**
     * Get today's attendance statistics
     */
    protected function getTodayAttendanceStats(): array
    {
        $today = now()->toDateString();
        $total = Attendance::whereDate('date', $today)->distinct('student_id')->count('student_id');
        
        if ($total === 0) {
            return [
                'present' => 0,
                'absent' => 0,
                'late' => 0,
                'total' => 0,
                'rate' => 0,
            ];
        }

        $present = Attendance::whereDate('date', $today)->where('status', 'present')->distinct('student_id')->count('student_id');
        $absent = Attendance::whereDate('date', $today)->where('status', 'absent')->distinct('student_id')->count('student_id');
        $late = Attendance::whereDate('date', $today)->where('status', 'late')->distinct('student_id')->count('student_id');

        return [
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'total' => $total,
            'rate' => round(($present / $total) * 100, 1),
        ];
    }

    /**
     * Get grade averages by subject/level
     */
    protected function getGradeAverages(): array
    {
        // Get average of final grades grouped by student's grade level
        $averages = Grade::select(
            DB::raw('AVG(final_grade) as average'),
            'student_id'
        )
        ->whereNotNull('final_grade')
        ->groupBy('student_id')
        ->with(['student.gradeLevel'])
        ->get()
        ->groupBy('student.gradeLevel.name')
        ->map(function ($grades, $levelName) {
            return round($grades->avg('average'), 2);
        });

        return $averages->toArray();
    }

    /**
     * Get enrollment trend (last 6 months)
     */
    protected function getEnrollmentTrend(): array
    {
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Enrollment::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $trend[$month->format('M Y')] = $count;
        }
        return $trend;
    }

    /**
     * Get attendance trend for last N days
     */
    protected function getAttendanceTrend(int $days): array
    {
        $trend = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $total = Attendance::whereDate('date', $date)->distinct('student_id')->count('student_id');
            $present = $total > 0 ? Attendance::whereDate('date', $date)->where('status', 'present')->distinct('student_id')->count('student_id') : 0;
            $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
            $trend[$date] = $rate;
        }
        return $trend;
    }

    /**
     * Show report builder for a template
     */
    public function builder(Request $request, ReportTemplate $template)
    {
        $savedReportId = $request->get('saved_report');
        $savedReport = $savedReportId ? SavedReport::find($savedReportId) : null;

        // Get filter options
        $filterOptions = $this->getFilterOptions($template);

        return view('admin.reports.builder', compact(
            'template',
            'savedReport',
            'filterOptions'
        ));
    }

    /**
     * Get filter options based on template category
     */
    protected function getFilterOptions(ReportTemplate $template): array
    {
        $currentSchoolYear = SchoolYear::where('is_active', true)->first();

        return [
            'school_years' => SchoolYear::orderBy('year_start', 'desc')->get(),
            'grade_levels' => \App\Models\GradeLevel::orderBy('sort_order')->get(),
            'sections' => Section::when($currentSchoolYear, fn($q) => $q->where('school_year_id', $currentSchoolYear->id))
                ->with(['gradeLevel', 'teacher'])
                ->orderBy('name')
                ->get(),
            'subjects' => \App\Models\Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->get()->map(fn($t) => [
                'id' => $t->id,
                'name' => $t->user?->full_name ?? 'Unknown'
            ]),
            'genders' => ['male' => 'Male', 'female' => 'Female'],
            'statuses' => ['active' => 'Active', 'inactive' => 'Inactive', 'transferred' => 'Transferred', 'dropped' => 'Dropped'],
        ];
    }

    /**
     * Generate report data
     */
    public function generate(Request $request, ReportTemplate $template)
    {
        $parameters = $request->get('parameters', []);
        $format = $request->get('format', 'html');

        // Generate report data based on template slug
        $data = match($template->slug) {
            'student-masterlist' => $this->generateStudentMasterlist($parameters),
            'grade-summary' => $this->generateGradeSummary($parameters),
            'attendance-summary' => $this->generateAttendanceSummary($parameters),
            'enrollment-statistics' => $this->generateEnrollmentStats($parameters),
            'teacher-workload' => $this->generateTeacherWorkload($parameters),
            'class-performance' => $this->generateClassPerformance($parameters),
            'attendance-trend' => $this->generateAttendanceTrendReport($parameters),
            'honor-roll' => $this->generateHonorRoll($parameters),
            'dropout-risk' => $this->generateDropoutRiskReport($parameters),
            default => $this->generateGenericReport($template, $parameters),
        };

        // Export based on format
        return match($format) {
            'pdf' => $this->exportPdf($template, $data, $parameters),
            'excel' => $this->exportExcel($template, $data, $parameters),
            'csv' => $this->exportCsv($template, $data, $parameters),
            default => response()->json([
                'success' => true,
                'data' => $data,
                'template' => $template,
                'parameters' => $parameters,
                'generated_at' => now()->toDateTimeString(),
            ]),
        };
    }

    /**
     * Generate Student Masterlist Report
     */
    protected function generateStudentMasterlist(array $parameters): array
    {
        $query = Student::with(['user', 'gradeLevel', 'section', 'enrollments']);

        if (!empty($parameters['grade_level_id'])) {
            $query->where('grade_level_id', $parameters['grade_level_id']);
        }

        if (!empty($parameters['section_id'])) {
            $query->where('section_id', $parameters['section_id']);
        }

        if (!empty($parameters['gender'])) {
            $query->where('gender', $parameters['gender']);
        }

        if (!empty($parameters['status'])) {
            $query->where('status', $parameters['status']);
        }

        $students = $query->orderBy('last_name')->get()->map(function ($student) {
            return [
                'lrn' => $student->lrn,
                'name' => $student->full_name,
                'grade_level' => $student->gradeLevel?->name,
                'section' => $student->section?->name,
                'gender' => ucfirst($student->gender),
                'birthdate' => $student->birthdate?->format('M d, Y'),
                'age' => $student->age,
                'contact' => $student->guardian_contact,
                'status' => ucfirst($student->status),
            ];
        });

        return [
            'title' => 'Student Masterlist',
            'rows' => $students,
            'summary' => [
                'Total Students' => $students->count(),
                'Male' => $students->where('gender', 'Male')->count(),
                'Female' => $students->where('gender', 'Female')->count(),
            ],
        ];
    }

    /**
     * Generate Grade Summary Report
     */
    protected function generateGradeSummary(array $parameters): array
    {
        // Get final grades (component_type = 'final_grade')
        $query = Grade::with(['student.user', 'subject', 'section'])
            ->where('component_type', 'final_grade');

        if (!empty($parameters['section_id'])) {
            $query->where('section_id', $parameters['section_id']);
        }

        if (!empty($parameters['subject_id'])) {
            $query->where('subject_id', $parameters['subject_id']);
        }

        if (!empty($parameters['school_year_id'])) {
            $query->where('school_year_id', $parameters['school_year_id']);
        }

        $grades = $query->get()->map(function ($grade) {
            $final = $grade->final_grade ?? 0;
            return [
                'student_name' => $grade->student?->full_name ?? 'Unknown',
                'subject' => $grade->subject?->name ?? 'Unknown',
                'section' => $grade->section?->name ?? 'Unknown',
                'quarter' => 'Q' . $grade->quarter,
                'final' => round($final, 2),
                'remarks' => $final >= 75 ? 'Passed' : 'Failed',
            ];
        });

        $passed = $grades->where('remarks', 'Passed')->count();
        $total = $grades->count();

        return [
            'title' => 'Grade Summary Report',
            'rows' => $grades,
            'summary' => [
                'Total Records' => $total,
                'Passed' => $passed,
                'Failed' => $total - $passed,
                'Passing Rate' => $total > 0 ? round(($passed / $total) * 100, 2) . '%' : '0%',
                'Class Average' => round($grades->avg('final'), 2),
            ],
        ];
    }

    /**
     * Generate Attendance Summary Report
     */
    protected function generateAttendanceSummary(array $parameters): array
    {
        $startDate = $parameters['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $parameters['end_date'] ?? now()->toDateString();

        $query = Attendance::with(['student.user', 'section'])
            ->whereBetween('date', [$startDate, $endDate]);

        if (!empty($parameters['section_id'])) {
            $query->where('section_id', $parameters['section_id']);
        }

        $attendances = $query->get();

        $summary = $attendances->groupBy('student_id')->map(function ($records, $studentId) {
            $firstRecord = $records->first();
            return [
                'student_name' => $firstRecord->student?->full_name ?? 'Unknown',
                'section' => $firstRecord->section?->name ?? 'Unknown',
                'present' => $records->where('status', 'present')->count(),
                'absent' => $records->where('status', 'absent')->count(),
                'late' => $records->where('status', 'late')->count(),
                'total' => $records->count(),
                'attendance_rate' => $records->count() > 0 
                    ? round(($records->whereIn('status', ['present', 'late'])->count() / $records->count()) * 100, 2) 
                    : 0,
            ];
        })->values();

        return [
            'title' => 'Attendance Summary Report',
            'period' => Carbon::parse($startDate)->format('M d, Y') . ' - ' . Carbon::parse($endDate)->format('M d, Y'),
            'rows' => $summary,
            'summary' => [
                'Total Students' => $summary->count(),
                'Average Attendance Rate' => $summary->count() > 0 ? round($summary->avg('attendance_rate'), 2) . '%' : '0%',
                'Perfect Attendance' => $summary->where('attendance_rate', 100)->count(),
            ],
        ];
    }

    /**
     * Generate Enrollment Statistics
     */
    protected function generateEnrollmentStats(array $parameters): array
    {
        $schoolYearId = $parameters['school_year_id'] ?? SchoolYear::where('is_active', true)->value('id');

        $enrollments = Enrollment::with(['student', 'gradeLevel', 'section'])
            ->where('school_year_id', $schoolYearId)
            ->get();

        $byGradeLevel = $enrollments->groupBy('grade_level_id')->map(function ($items, $gradeLevelId) {
            $first = $items->first();
            return [
                'grade_level' => $first?->gradeLevel?->name ?? 'Unknown',
                'total' => $items->count(),
                'male' => $items->where('student.gender', 'male')->count(),
                'female' => $items->where('student.gender', 'female')->count(),
            ];
        })->values();

        $bySection = $enrollments->groupBy('section_id')->map(function ($items, $sectionId) {
            $first = $items->first();
            return [
                'section' => $first?->section?->name ?? 'Unknown',
                'grade_level' => $first?->gradeLevel?->name ?? 'Unknown',
                'total' => $items->count(),
                'adviser' => $first?->section?->teacher?->user?->full_name ?? 'Not Assigned',
            ];
        })->values();

        return [
            'title' => 'Enrollment Statistics',
            'school_year' => SchoolYear::find($schoolYearId)?->name ?? 'Unknown',
            'by_grade_level' => $byGradeLevel,
            'by_section' => $bySection,
            'summary' => [
                'Total Enrollments' => $enrollments->count(),
                'Male' => $enrollments->where('student.gender', 'male')->count(),
                'Female' => $enrollments->where('student.gender', 'female')->count(),
            ],
        ];
    }

    /**
     * Generate Teacher Workload Report
     */
    protected function generateTeacherWorkload(array $parameters): array
    {
        $teachers = Teacher::with(['user', 'sections', 'subjects'])->get();

        $workload = $teachers->map(function ($teacher) {
            return [
                'teacher_name' => $teacher->user?->full_name ?? 'Unknown',
                'specialization' => $teacher->specialization ?? 'N/A',
                'sections_handled' => $teacher->sections->count(),
                'subjects' => $teacher->subjects->pluck('name')->implode(', '),
                'total_students' => $teacher->sections->sum(function ($section) {
                    return $section->students->count();
                }),
            ];
        });

        return [
            'title' => 'Teacher Workload Report',
            'rows' => $workload,
            'summary' => [
                'Total Teachers' => $workload->count(),
                'Average Sections per Teacher' => round($workload->avg('sections_handled'), 2),
                'Average Students per Teacher' => round($workload->avg('total_students'), 2),
            ],
        ];
    }

    /**
     * Generate Class Performance Report
     */
    protected function generateClassPerformance(array $parameters): array
    {
        $sectionId = $parameters['section_id'] ?? null;
        
        $query = Section::with(['gradeLevel', 'teacher.user', 'students']);
        
        if ($sectionId) {
            $query->where('id', $sectionId);
        }

        $sections = $query->get()->map(function ($section) {
            // Get final grades for this section
            $grades = Grade::where('section_id', $section->id)
                ->where('component_type', 'final_grade')
                ->get();
            
            $avgGrade = $grades->count() > 0 
                ? $grades->avg('final_grade')
                : 0;

            return [
                'section' => $section->name,
                'grade_level' => $section->gradeLevel?->name ?? 'Unknown',
                'adviser' => $section->teacher?->user?->full_name ?? 'Not Assigned',
                'total_students' => $section->students->count(),
                'average_grade' => round($avgGrade, 2),
                'passing_rate' => $this->calculateSectionPassingRate($grades),
            ];
        });

        return [
            'title' => 'Class Performance Report',
            'rows' => $sections,
            'summary' => [
                'Total Sections' => $sections->count(),
                'Highest Average' => round($sections->max('average_grade'), 2),
                'Lowest Average' => round($sections->min('average_grade'), 2),
                'Overall Average' => round($sections->avg('average_grade'), 2),
            ],
        ];
    }

    /**
     * Calculate section passing rate
     */
    protected function calculateSectionPassingRate($grades): float
    {
        if ($grades->count() === 0) return 0;
        
        $passed = $grades->where('final_grade', '>=', 75)->count();

        return round(($passed / $grades->count()) * 100, 2);
    }

    /**
     * Generate Attendance Trend Report
     */
    protected function generateAttendanceTrendReport(array $parameters): array
    {
        $days = $parameters['days'] ?? 30;
        $sectionId = $parameters['section_id'] ?? null;

        $trend = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $query = Attendance::whereDate('date', $date);
            
            if ($sectionId) {
                $query->where('section_id', $sectionId);
            }

            $total = $query->distinct('student_id')->count('student_id');
            $present = $total > 0 ? $query->where('status', 'present')->distinct('student_id')->count('student_id') : 0;
            
            $trend[] = [
                'date' => $date->format('M d'),
                'total' => $total,
                'present' => $present,
                'rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return [
            'title' => 'Attendance Trend (Last ' . $days . ' Days)',
            'chart_data' => $trend,
            'summary' => [
                'Average Daily Attendance' => round(collect($trend)->avg('rate'), 2) . '%',
                'Highest Rate' => collect($trend)->max('rate') . '%',
                'Lowest Rate' => collect($trend)->min('rate') . '%',
            ],
        ];
    }

    /**
     * Generate Honor Roll Report
     */
    protected function generateHonorRoll(array $parameters): array
    {
        $minAverage = $parameters['min_average'] ?? 90;
        $schoolYearId = $parameters['school_year_id'] ?? SchoolYear::where('is_active', true)->value('id');

        $honors = Grade::with(['student.user', 'section'])
            ->where('school_year_id', $schoolYearId)
            ->where('component_type', 'final_grade')
            ->get()
            ->groupBy('student_id')
            ->map(function ($grades, $studentId) use ($minAverage) {
                $first = $grades->first();
                $genAvg = $grades->avg('final_grade');
                
                if ($genAvg < $minAverage) return null;

                return [
                    'student_name' => $first->student?->full_name ?? 'Unknown',
                    'section' => $first->section?->name ?? 'Unknown',
                    'general_average' => round($genAvg, 2),
                    'honor' => $genAvg >= 98 ? 'With Highest Honors' : ($genAvg >= 95 ? 'With High Honors' : 'With Honors'),
                ];
            })
            ->filter()
            ->sortByDesc('general_average')
            ->values();

        return [
            'title' => 'Honor Roll',
            'rows' => $honors,
            'summary' => [
                'Total Honorees' => $honors->count(),
                'With Highest Honors' => $honors->where('honor', 'With Highest Honors')->count(),
                'With High Honors' => $honors->where('honor', 'With High Honors')->count(),
                'With Honors' => $honors->where('honor', 'With Honors')->count(),
            ],
        ];
    }

    /**
     * Generate Dropout Risk Report
     */
    protected function generateDropoutRiskReport(array $parameters): array
    {
        $threshold = $parameters['attendance_threshold'] ?? 75;
        $gradeThreshold = $parameters['grade_threshold'] ?? 75;

        // Students with low attendance
        $atRiskStudents = Student::with(['user', 'section', 'attendances'])
            ->get()
            ->map(function ($student) use ($threshold, $gradeThreshold) {
                $totalAttendance = $student->attendances->count();
                $presentAttendance = $student->attendances->whereIn('status', ['present', 'late'])->count();
                $attendanceRate = $totalAttendance > 0 ? ($presentAttendance / $totalAttendance) * 100 : 100;

                // Get student's average final grade
                $avgGrade = Grade::where('student_id', $student->id)
                    ->where('component_type', 'final_grade')
                    ->avg('final_grade') ?? 100;

                $riskFactors = [];
                if ($attendanceRate < $threshold) $riskFactors[] = 'Low Attendance (' . round($attendanceRate, 1) . '%)';
                if ($avgGrade < $gradeThreshold) $riskFactors[] = 'Low Grades (' . round($avgGrade, 1) . ')';

                if (empty($riskFactors)) return null;

                return [
                    'student_name' => $student->full_name,
                    'section' => $student->section?->name ?? 'N/A',
                    'attendance_rate' => round($attendanceRate, 1) . '%',
                    'average_grade' => round($avgGrade, 2),
                    'risk_factors' => implode(', ', $riskFactors),
                    'risk_level' => count($riskFactors) >= 2 ? 'High' : 'Medium',
                ];
            })
            ->filter()
            ->sortByDesc('risk_level')
            ->values();

        return [
            'title' => 'At-Risk Students Report',
            'rows' => $atRiskStudents,
            'summary' => [
                'Total At-Risk Students' => $atRiskStudents->count(),
                'High Risk' => $atRiskStudents->where('risk_level', 'High')->count(),
                'Medium Risk' => $atRiskStudents->where('risk_level', 'Medium')->count(),
            ],
        ];
    }

    /**
     * Generic report generator fallback
     */
    protected function generateGenericReport(ReportTemplate $template, array $parameters): array
    {
        return [
            'title' => $template->name,
            'message' => 'This report type is not yet implemented.',
            'parameters' => $parameters,
        ];
    }

    /**
     * Save a report configuration
     */
    public function save(Request $request, ReportTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parameters' => 'required|array',
            'format' => 'required|in:html,pdf,excel,csv',
            'is_favorite' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $savedReport = SavedReport::create([
            'name' => $validated['name'],
            'template_id' => $template->id,
            'user_id' => auth()->id(),
            'parameters' => $validated['parameters'],
            'format' => $validated['format'],
            'is_favorite' => $validated['is_favorite'] ?? false,
            'notes' => $validated['notes'],
            'last_run_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report saved successfully',
            'saved_report' => $savedReport,
        ]);
    }

    /**
     * Delete saved report
     */
    public function destroySaved(SavedReport $savedReport)
    {
        $this->authorize('delete', $savedReport);
        
        $savedReport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully',
        ]);
    }

    /**
     * Export to PDF
     */
    protected function exportPdf(ReportTemplate $template, array $data, array $parameters)
    {
        $pdf = Pdf::loadView('admin.reports.exports.pdf', compact('template', 'data', 'parameters'));
        return $pdf->download(str_replace(' ', '_', $data['title']) . '_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export to Excel
     */
    protected function exportExcel(ReportTemplate $template, array $data, array $parameters)
    {
        // This would use Maatwebsite/Excel - simplified for now
        return response()->json([
            'success' => true,
            'message' => 'Excel export would be implemented with Maatwebsite/Excel',
            'data' => $data,
        ]);
    }

    /**
     * Export to CSV
     */
    protected function exportCsv(ReportTemplate $template, array $data, array $parameters)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . str_replace(' ', '_', $data['title']) . '_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // Headers
            if (!empty($data['rows']) && is_array($data['rows']->first())) {
                fputcsv($file, array_keys($data['rows']->first()));
                
                // Data
                foreach ($data['rows'] as $row) {
                    fputcsv($file, $row);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
