<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\Setting;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show attendance page
     */
    public function index(Section $section)
    {
        // Security: teacher only sees own section
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
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

        return view('teacher.attendance.index', compact(
            'section',
            'students',
            'attendance',
            'date'
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

        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
        ]);

        // Get active school year from is_active flag
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
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

        // Get active school year from is_active flag
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if (!$activeSchoolYear) {
            return response()->json([
                'success' => false,
                'message' => 'No active school year found'
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

        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->get();

        $today = now()->toDateString();

        foreach ($students as $student) {
            Attendance::updateOrCreate(
                [
                    'section_id' => $section->id,
                    'student_id' => $student->id,
                    'date' => $today,
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
}