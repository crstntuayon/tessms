<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;

class DashboardController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Make sure the user has a student record
        $student = $user->student;
        if (!$student) {
            abort(403, 'Student record not found.');
        }

        // Load related section, teacher, and classmates
        $section = $student->section; // returns null if no section assigned
        $teacher = $section?->teacher; // null safe operator
        $classmates = $section
            ? $section->students()->where('id', '!=', $student->id)->get()
            : collect(); // empty collection if no section

        return view('student.dashboard', compact(
            'student',
            'section',
            'teacher',
            'classmates'
        ));
    }

    /**
     * Show the student's grades.
     */
    public function grades()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Student record not found.');
        }

        // Load grades grouped by quarter, eager load subjects
        $grades = Grade::where('student_id', $student->id)
            ->with('subject')
            ->get()
            ->groupBy('quarter');

        return view('student.grades', compact('grades'));
    }
}
