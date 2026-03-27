<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class AssignmentsController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $pendingAssignments = Assignment::where('section_id', $student->section_id)
                                        ->where('status', 'pending')
                                        ->count();

        return view('student.assignments.index', compact('pendingAssignments'));
    }
}