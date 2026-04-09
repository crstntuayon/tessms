<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleName = strtolower($user->role?->name ?? '');
        
        $contacts = collect();
        
        if ($roleName === 'teacher') {
            // Auto-create teacher record if missing
            $teacher = Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => explode(' ', $user->name)[0] ?? 'Teacher',
                    'last_name'  => explode(' ', $user->name)[1] ?? '',
                ]
            );
            
            // Get active school year
            $activeSchoolYear = SchoolYear::where('is_active', true)->first();
            
            if ($activeSchoolYear) {
                // Get teacher's sections for the ACTIVE school year only
                $teacherSections = Section::where('teacher_id', $teacher->id)
                    ->where('school_year_id', $activeSchoolYear->id)
                    ->pluck('id');
                
                // Get only students with ACTIVE enrollment in those sections for the active school year
                if ($teacherSections->isNotEmpty()) {
                    $contacts = User::whereHas('student.enrollments', function ($query) use ($teacherSections, $activeSchoolYear) {
                            $query->whereIn('section_id', $teacherSections)
                                  ->where('school_year_id', $activeSchoolYear->id)
                                  ->where('status', 'enrolled');
                        })
                        ->where('id', '!=', $user->id)
                        ->get();
                }
            }
                
        } elseif ($roleName === 'student') {
            // Get active school year
            $activeSchoolYear = SchoolYear::where('is_active', true)->first();
            
            if ($activeSchoolYear) {
                // Get student's current enrollment in the active school year
                $enrollment = Enrollment::whereHas('student', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->where('school_year_id', $activeSchoolYear->id)
                    ->where('status', 'enrolled')
                    ->with('section')
                    ->first();
                
                // Get teacher from the student's current section
                if ($enrollment && $enrollment->section && $enrollment->section->teacher_id) {
                    $contacts = User::whereHas('teacher', function ($query) use ($enrollment) {
                            $query->where('id', $enrollment->section->teacher_id);
                        })->get();
                }
            }
        }
        
        return view('messenger.index', compact('contacts'));
    }
}
