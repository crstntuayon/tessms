<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    //

    public function assignSection(Request $request, $id)
{
    $request->validate([
        'section_id' => 'required|exists:sections,id'
    ]);

    $enrollment = \App\Models\Enrollment::findOrFail($id);
    $student = $enrollment->student;

    // Assign section to enrollment
    $enrollment->update([
        'section_id' => $request->section_id,
        'status' => 'enrolled'
    ]);

    // ALSO assign to student table
    $student->update([
        'section_id' => $request->section_id,
        'status' => 'active'
    ]);

    return back()->with('success', 'Student assigned to section successfully!');
}
}
