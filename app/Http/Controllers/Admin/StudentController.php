<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class StudentController extends Controller
{
public function index()
{
    $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();
    
    // Get students who have enrollments in the active school year
    $students = Student::with(['user', 'section'])
        ->whereHas('enrollments', function ($query) use ($activeSchoolYear) {
            $query->where('school_year_id', $activeSchoolYear?->id);
        })
        ->with(['enrollments' => function ($query) use ($activeSchoolYear) {
            // Load only the active year enrollment
            $query->where('school_year_id', $activeSchoolYear?->id);
        }])
        ->latest()
        ->paginate(10);
    
    return view('admin.students.index', compact('students', 'activeSchoolYear'));
}
    public function create()
    {
        $gradeLevels = \App\Models\GradeLevel::orderBy('name')->get();
        $sections = \App\Models\Section::orderBy('name')->get();
        return view('admin.students.create', compact('gradeLevels', 'sections'));
    }

      public function store(Request $request)
    {
        try {
            // VALIDATION
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                 'middle_name' => 'nullable|string|max:255',
                'last_name'  => 'required|string|max:255',
                'username'   => 'required|string|max:255|alpha_dash|unique:users,username',
                'email'      => 'required|email|max:255|unique:users,email',
                'password'   => 'required|min:8|confirmed',

                'lrn_full' => 'nullable|string|size:12|unique:students,lrn',
                'birthdate' => 'nullable|date|before_or_equal:today',
                'birth_place' => 'nullable|string|max:255',
                'gender' => 'nullable|in:Male,Female,Other',
                'nationality' => 'nullable|string|max:100',
                'religion' => 'nullable|string|max:100',

                'father_name' => 'nullable|string|max:255',
                'father_occupation' => 'nullable|string|max:255',
                'mother_name' => 'nullable|string|max:255',
                'mother_occupation' => 'nullable|string|max:255',

                'guardian_name' => 'nullable|string|max:255',
                'guardian_relationship' => 'nullable|string|max:100',
                'guardian_contact' => 'nullable|string|max:11',

                'street_address' => 'nullable|string|max:255',
                'barangay' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:10',

                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'grade_level_id' => 'nullable|exists:grade_levels,id',
                'section_id' => 'nullable|exists:sections,id',

                // STUDENT TYPE
                'type' => 'required|in:new,continuing,transferee',
                'previous_school' => 'nullable|required_if:type,transferee|string|max:255',

                'ethnicity' => 'nullable|string|max:100',           // ADD THIS
                'mother_tongue' => 'nullable|string|max:100',       // ADD THIS   
                'remarks' => 'nullable|string|max:10|in:TI,TO,DO,LE,CCT,BA,LWD',  // ADD THIS
            ]);

            DB::beginTransaction();

            // Get student role
            $studentRole = Role::where('name', 'student')->first();
            if (!$studentRole) {
                throw new \Exception('Student role not found!');
            }

            // Get active school year
            $schoolYear = SchoolYear::where('is_active', 1)->first();
            if (!$schoolYear) {
                throw new \Exception('No active school year found!');
            }

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            // CREATE USER
            $user = User::create([
                'role_id' => $studentRole->id,
                'first_name' => $validated['first_name'],
                  'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'photo' => $photoPath,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]);

            // CREATE STUDENT
            $student = Student::create([
                'user_id' => $user->id,
                'grade_level_id' => $validated['grade_level_id'] ?? null,
                'section_id' => $validated['section_id'] ?? null,
                'lrn' => $validated['lrn_full'] ?? null,
                'birthdate' => $validated['birthdate'] ?? null,
                'birth_place' => $validated['birth_place'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'nationality' => $validated['nationality'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'father_name' => $validated['father_name'] ?? null,
                'father_occupation' => $validated['father_occupation'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
                'mother_occupation' => $validated['mother_occupation'] ?? null,
                'guardian_name' => $validated['guardian_name'] ?? null,
                'guardian_relationship' => $validated['guardian_relationship'] ?? null,
                'guardian_contact' => $validated['guardian_contact'] ?? null,
                'street_address' => $validated['street_address'] ?? null,
                'barangay' => $validated['barangay'] ?? null,
                'city' => $validated['city'] ?? null,
                'province' => $validated['province'] ?? null,
                'zip_code' => $validated['zip_code'] ?? null,
                'ethnicity' => $validated['ethnicity'] ?? null,         // ADD THIS
                 'mother_tongue' => $validated['mother_tongue'] ?? null, // ADD THIS
                 'remarks' => $validated['remarks'] ?? null,  // ADD THIS
            ]);

            // ✅ CREATE ENROLLMENT
            $existingEnrollment = Enrollment::where('student_id', $student->id)
                ->where('school_year_id', $schoolYear->id)
                ->first();

            if (!$existingEnrollment) {
                Enrollment::create([
                    'school_year_id' => $schoolYear->id,
                    'grade_level_id' => $validated['grade_level_id'] ?? null,
                    'student_id' => $student->id,
                    'section_id' => $validated['section_id'] ?? null,
                    'type' => $validated['type'], // must match ENUM
                    'status' => 'pending',
                    'previous_school' => $validated['type'] === 'transferee' ? $validated['previous_school'] : null,
                    'enrollment_date' => now(),

                     // Store current school info at time of enrollment
    'school_name' => Setting::get('school_name'),
    'school_id' => Setting::get('deped_school_id'),
    'school_district' => Setting::get('school_district'),
    'school_division' => Setting::get('school_division'),
    'school_region' => Setting::get('school_region'),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created & enrolled successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }
// In your Controller show() method
public function show($id)
{
    $student = Student::with(['user', 'gradeLevel', 'section', 'enrollments.schoolYear'])
        ->findOrFail($id);
        
    return view('admin.students.show', compact('student'));
}

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $gradeLevels = \App\Models\GradeLevel::orderBy('name')->get();
        $sections = \App\Models\Section::orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'gradeLevels', 'sections'));
    }

   public function update(Request $request, $id)
{
    $student = Student::with('user')->findOrFail($id);
    $user = $student->user;

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',

        // STUDENT INFO
        'lrn' => 'nullable|string|size:12|unique:students,lrn,' . $student->id,
        'birthdate' => 'nullable|date',
        'birth_place' => 'nullable|string|max:255',
        'gender' => 'nullable|in:Male,Female,Other',
        'mother_tongue' => 'nullable|string|max:100',
        'ethnicity' => 'nullable|string|max:100',
        'nationality' => 'nullable|string|max:100',
        'religion' => 'nullable|string|max:100',

        // FAMILY
        'father_name' => 'nullable|string|max:255',
        'father_occupation' => 'nullable|string|max:255',
        'mother_name' => 'nullable|string|max:255',
        'mother_occupation' => 'nullable|string|max:255',

        // GUARDIAN
        'guardian_name' => 'nullable|string|max:255',
        'guardian_relationship' => 'nullable|string|max:100',
        'guardian_contact' => 'nullable|string|max:20',

        // ADDRESS
        'street_address' => 'nullable|string|max:255',
        'barangay' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'province' => 'nullable|string|max:255',
        'zip_code' => 'nullable|string|max:10',

        // SCHOOL
        'grade_level_id' => 'nullable|exists:grade_levels,id',
        'section_id' => 'nullable|exists:sections,id',

        // EXTRA
        'remarks' => 'nullable|string|max:10|in:TI,TO,DO,LE,CCT,BA,LWD',

        // PHOTO
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // HANDLE PHOTO
    $photoPath = $user->photo;

    if ($request->has('remove_photo') && $request->remove_photo == '1') {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $photoPath = null;
    } elseif ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // UPDATE USER
    $user->update([
        'first_name' => $validated['first_name'],
        'middle_name' => $validated['middle_name'] ?? null,
        'last_name' => $validated['last_name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'photo' => $photoPath,
    ]);

    if (!empty($validated['password'])) {
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
    }

    // UPDATE STUDENT (FULL)
    $student->update([
        'lrn' => $validated['lrn'] ?? null,
        'birthdate' => $validated['birthdate'] ?? null,
        'birth_place' => $validated['birth_place'] ?? null,
        'gender' => $validated['gender'] ?? null,
        'mother_tongue' => $validated['mother_tongue'] ?? null,
        'ethnicity' => $validated['ethnicity'] ?? null,
        'nationality' => $validated['nationality'] ?? null,
        'religion' => $validated['religion'] ?? null,

        'father_name' => $validated['father_name'] ?? null,
        'father_occupation' => $validated['father_occupation'] ?? null,
        'mother_name' => $validated['mother_name'] ?? null,
        'mother_occupation' => $validated['mother_occupation'] ?? null,

        'guardian_name' => $validated['guardian_name'] ?? null,
        'guardian_relationship' => $validated['guardian_relationship'] ?? null,
        'guardian_contact' => $validated['guardian_contact'] ?? null,

        'street_address' => $validated['street_address'] ?? null,
        'barangay' => $validated['barangay'] ?? null,
        'city' => $validated['city'] ?? null,
        'province' => $validated['province'] ?? null,
        'zip_code' => $validated['zip_code'] ?? null,

        'grade_level_id' => $validated['grade_level_id'] ?? null,
        'section_id' => $validated['section_id'] ?? null,

        'remarks' => $validated['remarks'] ?? null,
    ]);

    return redirect()->route('admin.students.index')
        ->with('success', 'Student updated successfully.');
}

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}