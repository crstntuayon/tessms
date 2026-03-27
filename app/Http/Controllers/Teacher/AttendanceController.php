<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show attendance page
     */
    public function index(Section $section)
    {
        // सुरक्षा: teacher only sees own section
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $students = $section->students()->with('user')->get();

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


        // Show form to create attendance
  public function create(Section $section)
    {
        $students = $section->students()->get();

        return view('teacher.attendance.create', compact('section', 'students'));
    }

    /**
     * Store attendance
     */
    public function store(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
             'attendance' => 'required|array',
             'attendance.*.status' => 'required|in:present,absent,late',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                [
                    'section_id' => $section->id,
                    'student_id' => $student_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return back()->with('success', 'Attendance saved successfully.');
    }

public function bulkStore(Request $request)
{
    $attendances = $request->input('attendance', []); // array of [student_id => ['status' => ..., 'remarks' => ...]]
    $sectionId = $request->input('section_id');
    $date = $request->input('date', now()->toDateString());

    foreach ($attendances as $studentId => $data) {
        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'date' => $date
            ],
            [
                'section_id' => $sectionId,
               'status' => $data['status'],
                'remarks' => $data['remarks'] ?? null
            ]
        );
    }

    return response()->json([
        'message' => 'Attendance saved successfully'
    ]);
}
}