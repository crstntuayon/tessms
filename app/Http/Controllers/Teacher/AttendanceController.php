<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\AttendanceSchoolDay;
use App\Services\FinalizationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $finalizationService;

    public function __construct(FinalizationService $finalizationService)
    {
        $this->finalizationService = $finalizationService;
    }

    /**
     * Show attendance page
     */
    public function index(Section $section)
    {
        // Security: teacher only sees own section
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        // Check finalization status
        $finalization = null;
        $isEditable = true;
        if ($activeSchoolYear) {
            $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
            $isEditable = !$finalization->is_locked;
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->with('user')
            ->get();

        $date = request('date', now()->toDateString());

        $attendance = Attendance::where('section_id', $section->id)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        // Get school days configuration for the month
        $schoolDaysConfig = null;
        if ($activeSchoolYear) {
            $dateCarbon = Carbon::parse($date);
            $schoolDaysConfig = AttendanceSchoolDay::where([
                'section_id' => $section->id,
                'school_year_id' => $activeSchoolYear->id,
                'month' => $dateCarbon->month,
                'year' => $dateCarbon->year,
            ])->first();
        }

        return view('teacher.attendance.index', compact(
            'section',
            'students',
            'attendance',
            'date',
            'finalization',
            'isEditable',
            'schoolDaysConfig',
            'activeSchoolYear'
        ));
    }

    /**
     * Show form to create attendance
     */
    public function create(Section $section)
    {
        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->get();

        return view('teacher.attendance.create', compact('section', 'students'));
    }

    /**
     * Store attendance - FIXED VERSION
     */
    public function store(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        // Check if section is finalized/locked
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if ($activeSchoolYear) {
            $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
            
            if ($finalization->is_locked) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'This section has been finalized and is locked.']);
                }
                return back()->with('error', 'This section has been finalized and is locked. Contact the administrator if you need to make changes.');
            }
        }

        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
        ]);

        if (!$activeSchoolYear) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No active school year found.']);
            }
            return back()->with('error', 'No active school year found.');
        }

        // Validate that the date falls within the active school year
        $attendanceDate = Carbon::parse($request->date);
        $startDate = Carbon::parse($activeSchoolYear->start_date);
        $endDate = $activeSchoolYear->end_date 
            ? Carbon::parse($activeSchoolYear->end_date) 
            : $startDate->copy()->addYear()->subDay();

        if ($attendanceDate->lt($startDate) || $attendanceDate->gt($endDate)) {
            $errorMsg = 'Attendance date must be within the active school year (' . $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y') . '). The date ' . $attendanceDate->format('M d, Y') . ' is outside this range.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg]);
            }
            return back()->with('error', $errorMsg);
        }

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                [
                    'section_id' => $section->id,
                    'student_id' => $student_id,
                    'date' => $request->date,
                ],
                [
                    'school_year_id' => $activeSchoolYear->id,
                    'status' => $status,
                    'teacher_id' => auth()->user()->teacher->id,
                ]
            );
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Attendance saved successfully.']);
        }
        return back()->with('success', 'Attendance saved successfully.');
    }

    /**
     * Bulk store attendance (AJAX) - For dashboard page
     */
    public function bulkStore(Request $request)
    {
        $attendances = $request->input('attendance', []);
        $sectionId = $request->input('section_id');
        $date = $request->input('date', now()->toDateString());

        $section = Section::findOrFail($sectionId);

        // Check if section is finalized/locked
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if ($activeSchoolYear) {
            $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
            
            if ($finalization->is_locked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This section has been finalized and is locked.'
                ], 403);
            }
        }

        if (!$activeSchoolYear) {
            return response()->json([
                'success' => false,
                'message' => 'No active school year found'
            ], 400);
        }

        // Validate that the date falls within the active school year
        $attendanceDate = Carbon::parse($date);
        $startDate = Carbon::parse($activeSchoolYear->start_date);
        $endDate = $activeSchoolYear->end_date 
            ? Carbon::parse($activeSchoolYear->end_date) 
            : $startDate->copy()->addYear()->subDay();

        if ($attendanceDate->lt($startDate) || $attendanceDate->gt($endDate)) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance date must be within the active school year (' . $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y') . ').'
            ], 400);
        }

        foreach ($attendances as $studentId => $data) {
            $status = is_array($data) ? ($data['status'] ?? null) : $data;
            $remarks = is_array($data) ? ($data['remarks'] ?? null) : null;
            
            if (!$status) continue;

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date,
                ],
                [
                    'section_id' => $sectionId,
                    'school_year_id' => $activeSchoolYear->id,
                    'status' => $status,
                    'remarks' => $remarks,
                    'teacher_id' => auth()->user()->teacher->id,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance saved successfully'
        ]);
    }

    /**
     * Mark all students with same status
     */
    public function markAll(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        // Check if section is finalized/locked
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if ($activeSchoolYear) {
            $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
            
            if ($finalization->is_locked) {
                return back()->with('error', 'This section has been finalized and is locked.');
            }
        }

        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        // Validate that today's date falls within the active school year
        $today = now();
        $startDate = Carbon::parse($activeSchoolYear->start_date);
        $endDate = $activeSchoolYear->end_date 
            ? Carbon::parse($activeSchoolYear->end_date) 
            : $startDate->copy()->addYear()->subDay();

        if ($today->lt($startDate) || $today->gt($endDate)) {
            return back()->with('error', 'Cannot mark attendance. Today is outside the active school year (' . $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y') . ').');
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->get();

        $todayString = $today->toDateString();

        foreach ($students as $student) {
            Attendance::updateOrCreate(
                [
                    'section_id' => $section->id,
                    'student_id' => $student->id,
                    'date' => $todayString,
                ],
                [
                    'school_year_id' => $activeSchoolYear->id,
                    'status' => $request->status,
                    'teacher_id' => auth()->user()->teacher->id,
                ]
            );
        }

        return back()->with('success', "All students marked as {$request->status}.");
    }

    /**
     * Show school days configuration page
     */
    public function schoolDaysConfig(Section $section, Request $request)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return redirect()->back()->with('error', 'No active school year found.');
        }

        // Check finalization status
        $finalization = null;
        $isEditable = true;
        $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
        $isEditable = !$finalization->is_locked;

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $schoolDays = AttendanceSchoolDay::getOrCreateForSection(
            $section->id,
            $activeSchoolYear->id,
            $month,
            $year
        );

        // Generate calendar data
        $calendar = $this->generateCalendarData($month, $year, $schoolDays);

        return view('teacher.attendance.school-days', compact(
            'section',
            'schoolDays',
            'calendar',
            'month',
            'year',
            'finalization',
            'isEditable'
        ));
    }

    /**
     * Update school days configuration
     */
    public function updateSchoolDays(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        // Check if section is finalized/locked
        $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
        if ($finalization->is_locked) {
            return back()->with('error', 'This section has been finalized and is locked.');
        }

        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
            'non_school_days' => 'nullable|array',
            'non_school_days.*.date' => 'required|date',
            'non_school_days.*.reason' => 'required|string|max:255',
            'teacher_notes' => 'nullable|string|max:1000',
        ]);

        $schoolDays = AttendanceSchoolDay::getOrCreateForSection(
            $section->id,
            $activeSchoolYear->id,
            $request->month,
            $request->year
        );

        // Update non-school days
        if ($request->has('non_school_days')) {
            $schoolDays->non_school_days = $request->non_school_days;
        }

        // Update teacher notes
        if ($request->has('teacher_notes')) {
            $schoolDays->teacher_notes = $request->teacher_notes;
        }

        // Recalculate school days
        $schoolDays->recalculateSchoolDays();
        
        $schoolDays->configured_by = auth()->id();
        $schoolDays->configured_at = now();
        $schoolDays->save();

        return back()->with('success', 'School days configuration saved successfully.');
    }

    /**
     * Add a non-school day
     */
    public function addNonSchoolDay(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return response()->json(['error' => 'No active school year found.'], 400);
        }

        // Check if section is finalized/locked
        $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
        if ($finalization->is_locked) {
            return response()->json(['error' => 'This section has been finalized and is locked.'], 403);
        }

        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        $date = Carbon::parse($request->date);
        
        $schoolDays = AttendanceSchoolDay::getOrCreateForSection(
            $section->id,
            $activeSchoolYear->id,
            $date->month,
            $date->year
        );

        $schoolDays->addNonSchoolDay($request->date, $request->reason);
        $schoolDays->save();

        return response()->json([
            'success' => true,
            'message' => 'Non-school day added successfully.',
            'total_school_days' => $schoolDays->total_school_days,
        ]);
    }

    /**
     * Remove a non-school day
     */
    public function removeNonSchoolDay(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return response()->json(['error' => 'No active school year found.'], 400);
        }

        // Check if section is finalized/locked
        $finalization = $this->finalizationService->getOrCreateFinalization($section->id, $activeSchoolYear->id);
        if ($finalization->is_locked) {
            return response()->json(['error' => 'This section has been finalized and is locked.'], 403);
        }

        $request->validate([
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($request->date);
        
        $schoolDays = AttendanceSchoolDay::where([
            'section_id' => $section->id,
            'school_year_id' => $activeSchoolYear->id,
            'month' => $date->month,
            'year' => $date->year,
        ])->first();

        if ($schoolDays) {
            $schoolDays->removeNonSchoolDay($request->date);
            $schoolDays->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Non-school day removed successfully.',
            'total_school_days' => $schoolDays ? $schoolDays->total_school_days : 0,
        ]);
    }

    /**
     * Finalize attendance for this section
     */
    public function finalizeAttendance(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        $result = $this->finalizationService->finalizeAttendance(
            $section->id,
            $activeSchoolYear->id,
            auth()->id()
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message'])->with('validation_errors', $result['errors'] ?? []);
    }

    /**
     * Generate calendar data for school days view
     */
    private function generateCalendarData(int $month, int $year, AttendanceSchoolDay $schoolDays): array
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $nonSchoolDays = collect($schoolDays->non_school_days ?? [])->pluck('date')->toArray();
        
        $calendar = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $carbonDate = Carbon::create($year, $month, $day);
            $isWeekend = $carbonDate->isWeekend();
            $isNonSchoolDay = in_array($date, $nonSchoolDays);
            
            $reason = null;
            if ($isNonSchoolDay) {
                $reason = collect($schoolDays->non_school_days)->firstWhere('date', $date)['reason'] ?? null;
            }

            $calendar[] = [
                'day' => $day,
                'date' => $date,
                'is_weekend' => $isWeekend,
                'is_school_day' => !$isWeekend && !$isNonSchoolDay,
                'is_non_school_day' => $isNonSchoolDay,
                'reason' => $reason,
                'day_of_week' => $carbonDate->format('D'),
            ];
        }

        return $calendar;
    }
}
