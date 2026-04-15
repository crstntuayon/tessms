<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\GradeLevel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Services\SettingsEnforcer;

class RegisteredUserController extends Controller
{
    /**
     * Show registration form
     */
    public function create(): View
    {
        if (!SettingsEnforcer::isRegistrationEnabled()) {
            abort(403, 'User registration is currently disabled.');
        }

        $gradeLevels = GradeLevel::orderBy('order')->get();
        return view('auth.register', compact('gradeLevels'));
    }

    /**
     * Handle registration
     */
    public function store(Request $request)
    {
        if (!SettingsEnforcer::isRegistrationEnabled()) {
            return back()->withErrors(['error' => 'User registration is currently disabled.'])->withInput();
        }
        // Generate full LRN if provided
        $fullLrn = $request->filled('lrn_suffix') ? '120231' . $request->lrn_suffix : null;

        $request->validate([
            'lrn_suffix' => [
                'nullable',
                'digits:6',
                function ($attribute, $value, $fail) use ($fullLrn) {
                    if ($fullLrn && Student::where('lrn', $fullLrn)->exists()) {
                        $fail('The LRN is already taken.');
                    }
                },
            ],

            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',

            'birthday' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'nationality' => 'required|string|max:255',
            'religion' => 'required|string|max:255',

            'father_name' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',

            'guardian_name' => 'required|string|max:255',
            'guardian_relationship' => 'required|string|max:255',
            'guardian_contact' => 'nullable|string|max:50',

            'street_address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',

            'grade_level_id' => 'required|exists:grade_levels,id',

            'type' => 'required|in:new,transferee,continuing',
            'previous_school' => 'nullable|string|max:255|required_if:type,transferee',

            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',

            'password' => ['required', 'confirmed', SettingsEnforcer::getPasswordRules()],

            'photo' => 'nullable|image|max:2048',

            'ethnicity' => 'required|string|max:100',
            'mother_tongue' => 'required|string|max:100',
            'remarks' => 'nullable|string|max:255',
            
            // Document uploads - all optional
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'report_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'good_moral' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'transfer_credential' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Get role
            $studentRole = Role::where('name', 'student')->firstOrFail();

            // Handle photo
            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('photos', 'public')
                : null;

            // Create user
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'suffix' => $request->suffix,
                'birthday' => $request->birthday,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_updated_at' => now(),
                'role_id' => $studentRole->id,
                'photo' => $photoPath,
                'is_active' => 0, // cannot login yet
            ]);

            // Create student (pending)
            $student = $user->student()->create([
                'lrn' => $fullLrn,
                'birthdate' => $request->birthday,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'nationality' => $request->nationality,
                'religion' => $request->religion,

                'father_name' => $request->father_name,
                'father_occupation' => $request->father_occupation,
                'mother_name' => $request->mother_name,
                'mother_occupation' => $request->mother_occupation,

                'guardian_name' => $request->guardian_name,
                'guardian_relationship' => $request->guardian_relationship,
                'guardian_contact' => $request->guardian_contact,

                'street_address' => $request->street_address,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'zip_code' => $request->zip_code,

                'status' => 'inactive',
                'grade_level_id' => $request->grade_level_id,
                'section_id' => null,

                'ethnicity' => $request->ethnicity,
                'mother_tongue' => $request->mother_tongue,
                'remarks' => $request->remarks,
                
                // Document paths will be updated after upload
                'birth_certificate_path' => null,
                'report_card_path' => null,
                'good_moral_path' => null,
                'transfer_credential_path' => null,
                'registration_status' => 'pending',
            ]);
            
            // Handle document uploads
            $documentPaths = [];
            
            if ($request->hasFile('birth_certificate')) {
                $documentPaths['birth_certificate_path'] = $request->file('birth_certificate')->store('student-documents/' . $student->id, 'public');
            }
            
            if ($request->hasFile('report_card')) {
                $documentPaths['report_card_path'] = $request->file('report_card')->store('student-documents/' . $student->id, 'public');
            }
            
            if ($request->hasFile('good_moral')) {
                $documentPaths['good_moral_path'] = $request->file('good_moral')->store('student-documents/' . $student->id, 'public');
            }
            
            if ($request->hasFile('transfer_credential')) {
                $documentPaths['transfer_credential_path'] = $request->file('transfer_credential')->store('student-documents/' . $student->id, 'public');
            }
            
            // Update student with document paths
            if (!empty($documentPaths)) {
                $student->update($documentPaths);
            }

            // ✅ Get ACTIVE school year
            $currentYear = SchoolYear::where('is_active', 1)->first();

            if (!$currentYear) {
                throw new \Exception('No active school year found.');
            }

            // ✅ Prevent duplicate enrollment
            $existingEnrollment = Enrollment::where('student_id', $student->id)
                ->where('school_year_id', $currentYear->id)
                ->first();

            if (!$existingEnrollment) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'school_year_id' => $currentYear->id,
                    'grade_level_id' => $request->grade_level_id,
                    'section_id' => null,

                    'type' => $request->type,
                    'status' => 'pending',

                    'previous_school' => $request->type === 'transferee'
                        ? $request->previous_school
                        : null,

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

            event(new Registered($user));

            return redirect()->route('login')
                ->with('success', 'Registration successful! Waiting for admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }
    }
}