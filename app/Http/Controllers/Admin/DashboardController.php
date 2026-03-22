<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Section;

class DashboardController extends Controller
{
    // Load the dashboard view with initial counts
 public function index()
{
    $totalStudents = \App\Models\Student::count();
    $totalTeachers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count();
    $totalSections = \App\Models\Section::count();

    // Add this for the sidebar
    $sidebarSectionCount = $totalSections;

    return view('admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalSections', 'sidebarSectionCount'));
}
}
