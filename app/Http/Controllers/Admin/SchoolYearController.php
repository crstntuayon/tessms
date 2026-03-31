<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Services\QrCodeService;
use App\Models\SchoolYearQrCode;
use Illuminate\Support\Facades\Storage;

class SchoolYearController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display school year management page
     */
    public function index()
    {
      $schoolYears = SchoolYear::orderBy('start_date', 'desc')->paginate(10);
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        return view('admin.school-years.index', compact('schoolYears', 'activeSchoolYear'));
    }


     // Show create form
    public function create()
    {
        return view('admin.school-years.create'); // Make this Blade view
    }

    // Save new school year
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        SchoolYear::create($validated);

        return redirect()->route('admin.school-years.index')->with('success', 'School year created successfully.');
    }

    /**
     * Start new school year - Generate QR Code
     */
    public function startSchoolYear(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        $schoolYear = SchoolYear::findOrFail($request->school_year_id);

        if ($schoolYear->is_active) {
            return redirect()->back()->with('warning', 'This school year is already active.');
        }

        try {
            DB::beginTransaction();

            // Deactivate all other school years
            SchoolYear::where('is_active', true)->update(['is_active' => false]);

            // Activate selected school year
            $schoolYear->update(['is_active' => true]);

            // Generate QR Code for enrollment
            $qrCode = $this->qrCodeService->generateForSchoolYear($schoolYear);

            DB::commit();

            return redirect()->route('admin.school-years.index')
                ->with('success', "School year '{$schoolYear->name}' has been started. QR code generated successfully.")
                ->with('qr_code', $qrCode);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to start school year: ' . $e->getMessage());
        }
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
            
            $enrolledStudents = Enrollment::where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->pluck('student_id');
            
            $enrolledCount = $enrolledStudents->count();
            
            if ($enrolledCount === 0) {
                DB::rollBack();
                return redirect()->back()->with('warning', 'No enrolled students found for the current school year.');
            }
            
            Enrollment::where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->update([
                    'status' => 'unenrolled',
                    'updated_at' => now(),
                ]);
            
            Student::whereIn('id', $enrolledStudents)
                ->update([
                    'status' => 'unenrolled',
                    'updated_at' => now(),
                ]);
            
            SchoolYearQrCode::where('school_year_id', $activeSchoolYear->id)
                ->update(['is_active' => false]);
            
            $activeSchoolYear->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                "School year '{$activeSchoolYear->name}' has been ended. {$enrolledCount} student(s) have been unenrolled.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to end school year: ' . $e->getMessage());
        }
    }

    public function setActive(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        SchoolYear::query()->update(['is_active' => false]);
        SchoolYear::where('id', $request->school_year_id)->update(['is_active' => true]);

        return back()->with('success', 'Active school year updated.');
    }

    /**
     * Download QR Code
     */
    public function downloadQrCode(SchoolYearQrCode $qrCode)
    {
        if (!Storage::disk('public')->exists($qrCode->qr_code_image_path)) {
            abort(404, 'QR Code not found.');
        }

        return Storage::disk('public')->download(
            $qrCode->qr_code_image_path,
            "enrollment-qr-{$qrCode->schoolYear->name}.png"
        );
    }

    /**
     * Regenerate QR Code
     */
    public function regenerateQrCode(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        $schoolYear = SchoolYear::findOrFail($request->school_year_id);

        if (!$schoolYear->is_active) {
            return redirect()->back()->with('error', 'Cannot generate QR code for inactive school year.');
        }

        try {
            $qrCode = $this->qrCodeService->generateForSchoolYear($schoolYear);
            
            return redirect()->back()->with('success', 'QR Code regenerated successfully.')
                ->with('qr_code', $qrCode);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate QR code: ' . $e->getMessage());
        }
    }
}