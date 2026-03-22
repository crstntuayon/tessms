<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        return view('teacher.grades.index');
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('teacher.grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'quarter' => $request->quarter,
            'written_works_avg' => $request->written_works_avg,
            'performance_tasks_avg' => $request->performance_tasks_avg,
            'quarterly_assessment' => $request->quarterly_assessment,
        ]);

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Grade saved successfully');
    }
}