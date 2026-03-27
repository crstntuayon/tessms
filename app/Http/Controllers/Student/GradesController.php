<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;

class GradesController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Example: get all grades for the student
        $grades = Grade::where('student_id', $student->id)->get();

        // Optional: calculate general average
        $generalAverage = $grades->avg('final_grade');

        return view('student.grades.index', compact('grades', 'generalAverage'));
    }
}