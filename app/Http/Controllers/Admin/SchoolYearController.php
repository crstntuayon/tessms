<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use App\Models\Student;




class SchoolYearController extends Controller
{
    public function setActive(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        // Deactivate all
        SchoolYear::query()->update(['is_active' => false]);

        // Activate selected
        $year = SchoolYear::findOrFail($request->school_year_id);
        $year->update(['is_active' => true]);

        return back()->with('success', 'Active school year updated.');
    }


    
 /**
     * End the current school year and unenroll all students
     */
    public function endSchoolYear(Request $request)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if (!$activeSchoolYear) {
            return redirect()->back()->with('error', 'No active school year found.');
        }

        try {
            DB::beginTransaction();
            
            // Get all enrolled students for this school year
            $enrolledStudents = Enrollment::where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->pluck('student_id');
            
            $enrolledCount = $enrolledStudents->count();
            
            if ($enrolledCount === 0) {
                DB::rollBack();
                return redirect()->back()->with('warning', 'No enrolled students found for the current school year.');
            }
            
            // 1. Update enrollments table status to 'unenrolled'
            Enrollment::where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->update([
                    'status' => 'unenrolled',
                    'updated_at' => now(),
                ]);
            
            // 2. Update students table status to 'unenrolled' (or 'inactive')
            Student::whereIn('id', $enrolledStudents)
                ->update([
                    'status' => 'unenrolled',
                    'updated_at' => now(),
                ]);
            
            // 3. Deactivate the school year
            $activeSchoolYear->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                "School year '{$activeSchoolYear->name}' has been ended. {$enrolledCount} student(s) have been unenrolled in both enrollment and student records.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to end school year: ' . $e->getMessage());
        }
    }
}