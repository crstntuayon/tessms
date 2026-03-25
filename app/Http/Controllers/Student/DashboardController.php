<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        // Safety check (in case middleware missed it)
        if (!$student || $student->status !== 'approved') {
            Auth::logout();
            return redirect()->route('auth.pending')
                ->withErrors([
                    'login' => 'Your registration is pending admin approval.'
                ]);
        }

        // Load section, teacher, classmates
        $section = $student->section;
        $teacher = $section?->teacher;
        $classmates = $section
            ? $section->students()->where('id', '!=', $student->id)->get()
            : collect();

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

        $grades = Grade::where('student_id', $student->id)
            ->with('subject')
            ->get()
            ->groupBy('quarter');

        return view('student.grades', compact('grades'));
    }
}