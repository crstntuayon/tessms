<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionsController extends Controller
{
    //

    public function index()
{
    return view('teacher.sections.index');
}

  // Custom method for grades
  /**
     * Show students of a section
     */
    public function students(Section $section)
    {
        $teacherId = auth()->user()->teacher->id ?? null;

        if ($section->teacher_id != $teacherId) {
            abort(403, 'Unauthorized');
        }

        $students = $section->students; // assumes Section has students() relationship
        return view('teacher.sections.students', compact('section', 'students'));
    }

    /**
     * Show grades of a section
     */
    public function grades(Section $section)
    {
        $teacherId = auth()->user()->teacher->id ?? null;

        if ($section->teacher_id != $teacherId) {
            abort(403, 'Unauthorized');
        }

        $students = $section->students()->with('grades')->get();
        return view('teacher.sections.grades', compact('section', 'students'));
    }

    public function attendance(Section $section)
{
    $teacherId = auth()->user()->teacher->id ?? null;

    if ($section->teacher_id != $teacherId) {
        abort(403, 'Unauthorized');
    }

    $students = $section->students; // assumes Section model has students() relationship

    // optionally, load attendance records if you have Attendance model
    // $attendanceRecords = Attendance::where('section_id', $section->id)->get();

    return view('teacher.sections.attendance', compact('section', 'students'));
}


}
