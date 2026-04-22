<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentApplication;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Show enrollment form for logged-in continuing students.
     * Data is pre-filled from their existing student record.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->withErrors(['error' => 'Student record not found. Please contact the school administration.']);
        }

        // Check if enrollment is enabled
        $enrollmentEnabledValue = \App\Models\Setting::get('enrollment_enabled', false);
        $enrollmentEnabled = $enrollmentEnabledValue === true || $enrollmentEnabledValue === '1' || $enrollmentEnabledValue === 1;

        $currentSchoolYear = SchoolYear::where('is_active', true)->first();
        $gradeLevels = GradeLevel::orderBy('order')->get();

        // Check if student already has a pending enrollment application for active school year
        $existingApplication = null;
        if ($currentSchoolYear) {
            $existingApplication = EnrollmentApplication::where('student_lrn', $student->lrn)
                ->where('school_year_id', $currentSchoolYear->id)
                ->whereIn('status', ['pending', 'under_review'])
                ->first();
        }

        // Check if student is already enrolled for the active school year
        $isAlreadyEnrolled = false;
        if ($currentSchoolYear) {
            $isAlreadyEnrolled = $student->enrollments()
                ->where('school_year_id', $currentSchoolYear->id)
                ->where('status', 'enrolled')
                ->exists();
        }

        return view('student.enrollment.index', compact(
            'student',
            'user',
            'currentSchoolYear',
            'gradeLevels',
            'enrollmentEnabled',
            'existingApplication',
            'isAlreadyEnrolled'
        ));
    }

    /**
     * Submit continuing student enrollment from the student portal.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return back()->withErrors(['error' => 'Student record not found.']);
        }

        // Check if enrollment is enabled
        $enrollmentEnabledValue = \App\Models\Setting::get('enrollment_enabled', false);
        $enrollmentEnabled = $enrollmentEnabledValue === true || $enrollmentEnabledValue === '1' || $enrollmentEnabledValue === 1;
        if (!$enrollmentEnabled) {
            return back()->withErrors(['error' => 'Enrollment is currently closed. Please contact the school administration.']);
        }

        // Get active school year
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return back()->withErrors(['error' => 'No active school year found. Please contact the school administration.']);
        }

        $validated = $request->validate([
            'application_type' => 'required|in:continuing',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'parent_email' => 'required|email',
        ]);

        // Check if already has pending application
        $existingApplication = EnrollmentApplication::where('student_lrn', $student->lrn)
            ->where('school_year_id', $activeSchoolYear->id)
            ->whereIn('status', ['pending', 'under_review'])
            ->first();

        if ($existingApplication) {
            return back()->withErrors(['error' => 'You already have a pending enrollment application for this school year. Application #: ' . $existingApplication->application_number]);
        }

        // Check if already enrolled
        $alreadyEnrolled = $student->enrollments()
            ->where('school_year_id', $activeSchoolYear->id)
            ->where('status', 'enrolled')
            ->exists();

        if ($alreadyEnrolled) {
            return back()->withErrors(['error' => 'You are already enrolled for the ' . $activeSchoolYear->name . ' school year.']);
        }

        // Create enrollment application
        $application = EnrollmentApplication::create([
            'application_type' => 'continuing',
            'application_number' => EnrollmentApplication::generateApplicationNumber(),
            'school_year_id' => $activeSchoolYear->id,
            'grade_level_id' => $validated['grade_level_id'],
            'student_first_name' => $user->first_name ?? 'Unknown',
            'student_middle_name' => $user->middle_name,
            'student_last_name' => $user->last_name ?? 'Unknown',
            'student_suffix' => $user->suffix,
            'student_birthdate' => $student->birthdate,
            'student_gender' => strtolower($student->gender) ?? 'male',
            'student_nationality' => $student->nationality ?? 'Filipino',
            'student_lrn' => $student->lrn,
            'student_id' => $student->id,
            'parent_email' => $validated['parent_email'],
            'parent_password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
            'address' => $student->street_address ?? 'On file',
            'barangay' => $student->barangay ?? 'On file',
            'city' => $student->city ?? 'On file',
            'province' => $student->province ?? 'Negros Oriental',
            'guardian_name' => $student->guardian_name ?? 'On file',
            'guardian_relationship' => $student->guardian_relationship ?? 'Parent',
            'guardian_contact' => $student->guardian_contact ?? 'On file',
            'emergency_contact_name' => $student->guardian_name ?? 'On file',
            'emergency_contact_relationship' => $student->guardian_relationship ?? 'Parent',
            'emergency_contact_number' => $student->guardian_contact ?? 'On file',
            'status' => 'pending',
            'account_created' => true,
        ]);

        // Send confirmation email
        try {
            \Mail::to($application->parent_email)->send(new \App\Mail\EnrollmentSubmitted($application));
        } catch (\Exception $e) {
            \Log::error('Failed to send enrollment confirmation: ' . $e->getMessage());
        }

        return redirect()->route('student.enrollment.index')
            ->with('success', 'Your enrollment application has been submitted successfully! Application number: ' . $application->application_number);
    }
}
