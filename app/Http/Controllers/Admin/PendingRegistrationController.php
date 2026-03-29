<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Section;

class PendingRegistrationController extends Controller
{
public function index()
{
    $students = Student::with(['user', 'gradeLevel', 'enrollments'])
        ->where('status', 'pending')
        ->latest()
        ->paginate(10);

    // Load sections with enrolled student count
$sections = Section::with('gradeLevel') // get the grade level of the section
                   ->withCount('students') // get total students in section
                   ->get();

    $sidebarStudentCount = \App\Models\Student::count();
    $sidebarTeacherCount = \App\Models\Teacher::count();
    $sidebarSectionCount = \App\Models\Section::count();

    $enrolledTodayCount = \App\Models\Student::where('status', 'enrolled')
        ->whereDate('updated_at', today())
        ->count();

    return view('admin.pending-registrations.index', compact(
        'students',
        'sections',
        'sidebarStudentCount',
        'sidebarTeacherCount',
        'sidebarSectionCount',
        'enrolledTodayCount'
    ));
}
    /**
     * AJAX: Get student details
     */
    public function details(Student $student)
    {
        try {
            if ($student->status !== 'pending') {
                return response()->json([
                    'error' => 'Student is not in pending status',
                    'status' => $student->status
                ], 400);
            }

            // Load relationships
            $student->loadMissing(['user', 'gradeLevel', 'enrollments']);

            if (!$student->user) {
                return response()->json([
                    'error' => 'Student user account not found'
                ], 404);
            }

            $user = $student->user;

            // ✅ Get latest enrollment safely
            $enrollment = $student->enrollments->sortByDesc('created_at')->first();

            $data = [
                'student' => [
                    'id' => $student->id,
                    'lrn' => $student->lrn,
                    'gender' => $student->gender,

                    // ✅ SAFE DATE HANDLING
                    'birthdate' => $student->birthdate
                        ? Carbon::parse($student->birthdate)->format('Y-m-d')
                        : null,

                    'birth_place' => $student->birth_place,
                    'nationality' => $student->nationality,

                            // ✅ ADD THESE NEW FIELDS
        'ethnicity' => $student->ethnicity,
        'mother_tongue' => $student->mother_tongue,
        'remarks' => $student->remarks,

                    'religion' => $student->religion,
                    'street_address' => $student->street_address,
                    'barangay' => $student->barangay,
                    'city' => $student->city,
                    'province' => $student->province,
                    'zip_code' => $student->zip_code,

                    'guardian_name' => $student->guardian_name,
                    'guardian_relationship' => $student->guardian_relationship,
                    'guardian_contact' => $student->guardian_contact,

                    'father_name' => $student->father_name,
                    'father_occupation' => $student->father_occupation,
                    'mother_name' => $student->mother_name,
                    'mother_occupation' => $student->mother_occupation,

                    // ✅ From enrollment
                    'type' => $enrollment?->type ?? 'N/A',
                    'enrollment_date' => $enrollment && $enrollment->enrollment_date
                        ? Carbon::parse($enrollment->enrollment_date)->format('Y-m-d')
                        : null,

                    'created_at' => $student->created_at
                        ? $student->created_at->format('Y-m-d H:i:s')
                        : null,

                    'user' => [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'middle_name' => $user->middle_name,
                        'email' => $user->email,
                        'username' => $user->username,
                    ],

                    'grade_level' => $student->gradeLevel ? [
                        'id' => $student->gradeLevel->id,
                        'name' => $student->gradeLevel->name,
                    ] : null,
                ],

                'full_name' => trim(
                    "{$user->last_name}, {$user->first_name} " .
                    ($user->middle_name ? substr($user->middle_name, 0, 1) . '.' : '')
                ),

                // ✅ SAFE AGE CALCULATION
                'age' => $student->birthdate
                    ? Carbon::parse($student->birthdate)->age
                    : null,

                'photo_url' => $user->photo
                    ? asset('storage/' . $user->photo)
                    : null,
            ];

            Log::info('Student details loaded', ['student_id' => $student->id]);

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error('Error loading student details', [
                'student_id' => $student->id ?? 'unknown',
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve
     */
   /**
 * Approve
 */
/**
 * Approve (Enroll)
 */
/**
 * Approve (Enroll)
 */
public function approve(Student $student, Request $request)
{
    try {
        // Validate section and remarks
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'remarks' => 'nullable|in:' . implode(',', array_keys(Student::$remarksLegend)), // ✅ Validate remarks
        ]);
        
        $section = Section::find($validated['section_id']);
        
        // Check section capacity
        $currentCount = \App\Models\Student::where('section_id', $section->id)
            ->where('status', 'enrolled')
            ->count();
            
        if ($currentCount >= $section->capacity) {
            return redirect()->back()->with('error', 'Selected section is already full.');
        }

        // Update student with enrolled status, section, and remarks
        $student->update([
            'status' => 'enrolled',
            'section_id' => $validated['section_id'],
            'remarks' => $validated['remarks'] ?? null, // ✅ Save remarks
        ]);

        // Update latest enrollment
        $enrollment = $student->enrollments()->latest()->first();

        if ($enrollment) {
            $enrollment->update([
                'status' => 'enrolled',
                'section_id' => $validated['section_id'],
                'remarks' => $validated['remarks'] ?? null, // ✅ Also save to enrollment if you have this column
            ]);
        }

        // Build success message with remarks if provided
        $successMsg = "Student {$student->user->last_name} enrolled and assigned to {$section->name}.";
        if (!empty($validated['remarks'])) {
            $remarkLabel = Student::$remarksLegend[$validated['remarks']] ?? $validated['remarks'];
            $successMsg .= " Remark: {$remarkLabel}.";
        }

        return redirect()->back()->with('success', $successMsg);

    } catch (\Exception $e) {
        Log::error('Enrollment failed', [
            'student_id' => $student->id,
            'error' => $e->getMessage()
        ]);

        return redirect()->back()->with('error', 'Failed to enroll student.');
    }
}
    /**
     * Reject
     */
   /**
 * Reject
 */
public function reject(Student $student)
{
    try {
        $student->update(['status' => 'rejected']);

        // Update latest enrollment
        $enrollment = $student->enrollments()->latest()->first();

        if ($enrollment) {
            $enrollment->update(['status' => 'rejected']);
        }

        return redirect()->back()
            ->with('success', "Student {$student->user->last_name} rejected.");

    } catch (\Exception $e) {
        Log::error('Rejection failed', [
            'student_id' => $student->id,
            'error' => $e->getMessage()
        ]);

        return redirect()->back()->with('error', 'Failed to reject student.');
    }
}
}