<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Example: get attendance for the current month
        $attendanceRecords = Attendance::where('student_id', $student->id)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->get();

        return view('student.attendance.index', compact('attendanceRecords'));
    }
}