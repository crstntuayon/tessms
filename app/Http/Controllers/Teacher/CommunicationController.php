<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    /**
     * Show communications page for a specific section
     */
   public function index(\App\Models\Section $section)
{
    $students = $section->students;

    return view('teacher.communications.index', compact('section', 'students'));
}

    /**
     * Store a message (optional, if you want a form to send updates)
     */
    public function store(Request $request, $sectionId)
    {
        // Example validation
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Store or send the message to parents here
        // Example: loop through students
        // $section = Section::with('students')->findOrFail($sectionId);
        // foreach ($section->students as $student) {
        //     // send message to $student->user->email or phone
        // }

        return redirect()->route('teacher.communications.index', $sectionId)
                         ->with('success', 'Message sent to parents!');
    }
}