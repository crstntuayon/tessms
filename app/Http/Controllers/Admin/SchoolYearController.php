<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Section;
use App\Models\SchoolYearQrCode;
use App\Models\PromotionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\QrCodeService;

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

    /**
     * Assign student to an available section for a grade level
     */
    private function assignSection(int $gradeLevelId, int $schoolYearId): ?int
    {
        $sections = Section::where('grade_level_id', $gradeLevelId)
            ->where('is_active', true)
            ->get();

        foreach ($sections as $section) {
            $count = Enrollment::where('section_id', $section->id)
                ->where('school_year_id', $schoolYearId)
                ->where('status', 'enrolled')
                ->count();

            if ($count < $section->capacity) {
                return $section->id;
            }
        }

        return null; // fallback if no section is available
    }

    /**
     * Start a school year
     */
    public function startSchoolYear(Request $request)
    {
        $request->validate(['school_year_id' => 'required|exists:school_years,id']);

        $schoolYear = SchoolYear::findOrFail($request->school_year_id);

        if ($schoolYear->is_active) {
            return redirect()->back()->with('warning', 'This school year is already active.');
        }

        try {
            DB::beginTransaction();

            // Deactivate other active years
            SchoolYear::where('is_active', true)->update(['is_active' => false]);

            // Activate the selected school year
            $schoolYear->update(['is_active' => true]);

            // Generate QR Code
            $qrCode = $this->qrCodeService->generateForSchoolYear($schoolYear);

            DB::commit();

            return redirect()->route('admin.school-years.index')
                ->with('success', "School year '{$schoolYear->name}' started. QR code generated.")
                ->with('qr_code', $qrCode);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Start school year failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to start school year.');
        }
    }

    /**
     * End school year, promote students, graduate Grade 6
     */
    public function endSchoolYear(Request $request)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        if (!$activeSchoolYear) {
            return redirect()->back()->with('error', 'No active school year found.');
        }

        try {
            DB::beginTransaction();

            $nextSchoolYear = SchoolYear::where('start_date', '>', $activeSchoolYear->start_date)
                ->orderBy('start_date')
                ->first();

            if (!$nextSchoolYear) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Please create the next school year first.');
            }

            $GRADE_6_ID = 7; // Adjust according to your DB

            $enrollments = Enrollment::where('school_year_id', $activeSchoolYear->id)
                ->where('status', 'enrolled')
                ->get();

            $graduatedIds = [];
            $promotedCount = 0;

            foreach ($enrollments as $enrollment) {

                // Graduate Grade 6
                if ($enrollment->grade_level_id == $GRADE_6_ID) {
                    $graduatedIds[] = $enrollment->student_id;
                    continue;
                }

                $nextGradeLevelId = $enrollment->grade_level_id + 1;

                // Skip if enrollment already exists for next year
                if (Enrollment::where('student_id', $enrollment->student_id)
                    ->where('school_year_id', $nextSchoolYear->id)
                    ->exists()) {
                    continue;
                }

                $sectionId = $this->assignSection($nextGradeLevelId, $nextSchoolYear->id);

                Enrollment::create([
                    'student_id' => $enrollment->student_id,
                    'school_year_id' => $nextSchoolYear->id,
                    'grade_level_id' => $nextGradeLevelId,
                    'section_id' => $sectionId,
                    'type' => 'continuing',
                    'status' => 'pending',
                    'previous_school' => null, // only for transferees
                    'enrollment_date' => now(),
                ]);

                PromotionHistory::create([
                    'student_id' => $enrollment->student_id,
                    'from_school_year_id' => $activeSchoolYear->id,
                    'to_school_year_id' => $nextSchoolYear->id,
                    'from_grade_level_id' => $enrollment->grade_level_id,
                    'to_grade_level_id' => $nextGradeLevelId,
                ]);

                Student::where('id', $enrollment->student_id)->update([
                    'status' => 'inactive',
                    'grade_level_id' => $nextGradeLevelId,
                ]);

                $promotedCount++;
            }

            if (!empty($graduatedIds)) {
                Student::whereIn('id', $graduatedIds)->update(['status' => 'graduated']);
            }

            // Deactivate QR codes and school year
            SchoolYearQrCode::where('school_year_id', $activeSchoolYear->id)
                ->update(['is_active' => false]);

            $activeSchoolYear->update(['is_active' => false]);

            DB::commit();

            return redirect()->back()->with('success',
                "{$promotedCount} students promoted, " . count($graduatedIds) . " graduated 🎓."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('End school year failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to end school year.');
        }
    }


    public function setActive(Request $request)
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
        SchoolYear::where('is_active', true)->update(['is_active' => false]);
        $schoolYear->update(['is_active' => true]);
        DB::commit();

        return redirect()->back()->with('success', "School year '{$schoolYear->name}' is now active.");
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Set active school year failed', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to set active school year.');
    }
}

    /**
     * Download QR code
     */
    public function downloadQrCode(SchoolYearQrCode $qrCode)
    {
        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        if (!$disk->exists($qrCode->qr_code_image_path)) {
            abort(404, 'QR Code not found.');
        }

        return $disk->download(
            $qrCode->qr_code_image_path,
            "enrollment-qr-{$qrCode->schoolYear->name}.png"
        );
    }

    /**
     * Regenerate QR code
     */
    public function regenerateQrCode(Request $request)
    {
        $request->validate(['school_year_id' => 'required|exists:school_years,id']);

        $schoolYear = SchoolYear::findOrFail($request->school_year_id);

        if (!$schoolYear->is_active) {
            return redirect()->back()->with('error', 'Cannot generate QR code for inactive school year.');
        }

        try {
            $qrCode = $this->qrCodeService->generateForSchoolYear($schoolYear);

            return redirect()->back()->with('success', 'QR Code regenerated successfully.')
                ->with('qr_code', $qrCode);

        } catch (\Exception $e) {
            Log::error('Regenerate QR failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate QR code.');
        }
    }
}