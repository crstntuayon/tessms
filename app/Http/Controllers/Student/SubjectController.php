<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Section;

class SubjectController extends Controller
{
    public function index()
    {
        // Example: get subjects for the logged-in student
        $student = auth()->user()->student;
        $section = $student->section;

        $subjects = $section ? $section->subjects : collect();

        return view('student.subjects.index', compact('subjects'));
    }
}