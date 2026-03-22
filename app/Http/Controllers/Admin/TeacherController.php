<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
public function index()
{
    $teachers = Teacher::with('user')->latest()->paginate(10);
    $pendingUsers = User::where('role_id', 2)
        ->whereDoesntHave('teacher')
        ->orWhereHas('teacher', function($q) {
            $q->where('status', 'pending');
        })
        ->get();
        
    return view('admin.teachers.index', compact('teachers', 'pendingUsers'));
}


public function update(Request $request, $id)
{
    $teacher = Teacher::findOrFail($id);

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'mobile_number' => 'nullable|string|max:15',
        'username' => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Update teacher table
        $teacher->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'email' => $validated['email'] ?? null,
            'mobile_number' => $validated['mobile_number'] ?? null,
        ]);

        // ✅ Update linked user
        if ($teacher->user) {
            $teacher->user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'] ?? $teacher->user->email,
                'username' => $request->username ?? $teacher->user->username,
            ]);
        }

        DB::commit();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully!');

    } catch (\Exception $e) {
        DB::rollback();

        return back()->with('error', 'Update failed: ' . $e->getMessage())
                     ->withInput();
    }
}

public function edit($id)
{
    $teacher = Teacher::with('user')->findOrFail($id);
    return view('admin.teachers.edit', compact('teacher'));
}

    public function create()
    {
        return view('admin.teachers.create');
    }

 public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8|confirmed',
            'mobile_number' => 'required|string|max:15',
        ]);

        DB::beginTransaction();
        
        // ✅ FIND TEACHER ROLE DYNAMICALLY
        $teacherRole = \App\Models\Role::where('name', 'teacher')->first();
        
        if (!$teacherRole) {
            throw new \Exception('Teacher role not found in database. Please create it first.');
        }
        
        // Create user account
        $user = User::create([
            'role_id' => $teacherRole->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Create teacher record
        Teacher::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'teacher_id' => 'TEMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'current_status' => 'Active',
            'status' => 'pending',
            'employment_status' => 'Probationary',
            'date_hired' => now(),
            'position' => 'Teacher I',
            'highest_education' => 'Pending',
            'degree_program' => 'Pending',
            'school_graduated' => 'Pending',
            'year_graduated' => date('Y'),
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'Pending',
            'gender' => 'Male',
            'civil_status' => 'Single',
            'street_address' => 'Pending',
            'barangay' => 'Pending',
            'city_municipality' => 'Pending',
            'province' => 'Pending',
            'zip_code' => '0000',
            'emergency_contact_name' => 'Pending',
            'emergency_contact_relationship' => 'Pending',
            'emergency_contact_number' => '0000000000',
        ]);

        DB::commit();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher account created successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
            
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()
            ->with('error', 'ERROR: ' . $e->getMessage())
            ->withInput();
    }
}


    public function completeProfile()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher || $teacher->status !== 'pending') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.teachers.complete-profile', compact('teacher'));
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'teacher_id' => 'required|unique:teachers,teacher_id,' . $teacher->id,
            'deped_id' => 'nullable|unique:teachers,deped_id,' . $teacher->id,
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Separated,Annulled',
            'nationality' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'mobile_number' => 'required|string|max:15',
            'telephone_number' => 'nullable|string|max:15',
            'street_address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city_municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'region' => 'nullable|string|max:50',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_relationship' => 'required|string|max:50',
            'emergency_contact_number' => 'required|string|max:15',
            'employment_status' => 'required|in:Permanent,Probationary,Contractual,Substitute,Part-time',
            'date_hired' => 'required|date',
            'date_regularized' => 'nullable|date',
            'position' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'is_class_adviser' => 'boolean',
            'advisory_class' => 'nullable|string|max:255',
            'highest_education' => 'required|string|max:255',
            'degree_program' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'minor' => 'nullable|string|max:255',
            'school_graduated' => 'required|string|max:255',
            'year_graduated' => 'required|integer|min:1950|max:' . date('Y'),
            'prc_license_number' => 'nullable|string|max:50',
            'prc_license_validity' => 'nullable|date',
            'years_of_experience' => 'nullable|integer|min:0',
            'gsis_id' => 'nullable|string|max:20|unique:teachers,gsis_id,' . $teacher->id,
            'pagibig_id' => 'nullable|string|max:20|unique:teachers,pagibig_id,' . $teacher->id,
            'philhealth_id' => 'nullable|string|max:20|unique:teachers,philhealth_id,' . $teacher->id,
            'sss_id' => 'nullable|string|max:20|unique:teachers,sss_id,' . $teacher->id,
            'tin_id' => 'nullable|string|max:20|unique:teachers,tin_id,' . $teacher->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $filePaths = [];
            if ($request->hasFile('photo')) {
                $filePaths['photo_path'] = $request->file('photo')->store('teachers/photos', 'public');
            }

            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'photo' => $filePaths['photo_path'] ?? $user->photo,
            ]);

            // Prepare teacher data
            $teacherData = array_merge($validated, $filePaths);
            $teacherData['status'] = 'active';
            $teacherData['current_status'] = 'Active'; // Valid ENUM value
            $teacherData['teaching_level'] = 'Elementary';
            $teacherData['is_class_adviser'] = $request->boolean('is_class_adviser');
            
            unset($teacherData['photo']);

            $teacher->update($teacherData);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Profile completed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save profile: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.show', compact('teacher'));
    }

    public function destroy(Teacher $teacher)
    {
        DB::beginTransaction();
        
        try {
            if ($teacher->user) {
                $teacher->user->delete();
            }
            $teacher->delete();
            
            DB::commit();
            
            return redirect()->route('admin.teachers.index')
                ->with('success', 'Teacher deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to delete teacher');
        }
    }
}