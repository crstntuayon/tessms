<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Student;

class StudentController extends Controller
{
    //

     /**
     * Display students under a teacher's section
     */
    public function index(Section $section)
    {
        // Ensure teacher only accesses their own section
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        // Load students (adjust relationship if needed)
        $students = $section->students()
            ->with('user') // if student has user relation
            ->paginate(10);

        return view('teacher.students.index', compact('section', 'students'));
    }



    public function show(Student $student)
    {
        return view('teacher.students.show', compact('student'));
    }


     // Show edit form
    public function edit(Student $student)
    {
        return view('teacher.students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return redirect()->route('teacher.students.show', $student)->with('success', 'Student updated successfully.');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('teacher.students.index')->with('success', 'Student deleted successfully.');
    }
}
