<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        // Fetch unread announcements for this student
        $unreadAnnouncements = Announcement::where('target', 'students')
                                           ->where('is_read', false)
                                           ->count();

        // Fetch all announcements for display
        $announcements = Announcement::latest()->get();

        return view('student.announcements.index', compact('announcements', 'unreadAnnouncements'));
    }
}