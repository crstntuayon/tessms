<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
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
            // ✅ VALIDATION - lrn_full is the complete 12-digit LRN
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'username'   => 'required|string|max:255|alpha_dash|unique:users,username',
                'email'      => 'required|email|max:255|unique:users,email',
                'password'   => 'required|min:8|confirmed',

                // lrn_full = 120231 + 6 digits from user = 12 digits total
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
            ]);

            DB::beginTransaction();

            // Get student role
            $studentRole = Role::where('name', 'student')->first();
            
            if (!$studentRole) {
                throw new \Exception('Student role not found in database!');
            }

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            // ✅ CREATE USER
            $user = User::create([
                'role_id' => $studentRole->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'photo' => $photoPath,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]);

            // ✅ CREATE STUDENT with full 12-digit LRN
            $student = Student::create([
                'user_id' => $user->id,
                'grade_level_id' => $validated['grade_level_id'] ?? null,
                'section_id' => $validated['section_id'] ?? null,
                'lrn' => $validated['lrn_full'] ?? null, // 12 digits: 120231 + 6 user digits
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
                'status' => 'Enrolled',
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created successfully! Username: ' . $validated['username']);

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

    public function show($id)
    {
        $student = Student::with('user')->findOrFail($id);
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
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            
            'lrn' => 'nullable|string|size:12|unique:students,lrn,' . $student->id,
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
            'remove_photo' => 'nullable|boolean',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        // Handle photo upload
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

        // Update user data
        $userData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'photo' => $photoPath,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update student data
        $student->update([
            'lrn' => $validated['lrn'] ?? null,
            'grade_level_id' => $validated['grade_level_id'] ?? null,
            'section_id' => $validated['section_id'] ?? null,
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