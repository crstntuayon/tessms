<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Section;
use App\Models\SchoolYearQrCode;
use App\Models\PromotionHistory;
use App\Models\SchoolYearClosure;
use App\Models\SectionFinalization;
use App\Services\QrCodeService;
use App\Services\FinalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SchoolYearController extends Controller
{
    protected $qrCodeService;
    protected $finalizationService;

    public function __construct(QrCodeService $qrCodeService, FinalizationService $finalizationService)
    {
        $this->qrCodeService = $qrCodeService;
        $this->finalizationService = $finalizationService;
    }

    /**
     * Display school year management page
     */
    public function index()
    {
        $schoolYears = SchoolYear::orderBy('start_date', 'desc')->paginate(10);
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        // Get closure status if there's an active school year
        $closure = null;
        if ($activeSchoolYear) {
            $closure = $this->finalizationService->getOrCreateClosure($activeSchoolYear->id);
            $closure->updateProgress();
        }

        return view('admin.school-years.index', compact('schoolYears', 'activeSchoolYear', 'closure'));
    }

    /**
     * Display school year closure dashboard
     */
    public function closureDashboard(Request $request)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        if (!$activeSchoolYear) {
            return redirect()->route('admin.school-years.index')
                ->with('error', 'No active school year found.');
        }

        $closure = $this->finalizationService->getOrCreateClosure($activeSchoolYear->id);
        $closure->updateProgress();

        $sectionsStatus = $this->finalizationService->getAllSectionsStatus($activeSchoolYear->id);
        
        $canEnd = $this->finalizationService->canEndSchoolYear($activeSchoolYear->id);

        return view('admin.school-years.closure', compact(
            'activeSchoolYear',
            'closure',
            'sectionsStatus',
            'canEnd'
        ));
    }

    /**
     * Set finalization deadline
     */
    public function setDeadline(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'deadline' => 'required|date|after:today',
            'auto_finalize' => 'boolean',
        ]);

        $deadline = Carbon::parse($request->deadline);
        $autoFinalize = $request->boolean('auto_finalize', false);

        $result = $this->finalizationService->setDeadline(
            $request->school_year_id,
            $deadline,
            $autoFinalize
        );

        if ($result['success']) {
            return redirect()->back()->with('success', 
                'Finalization deadline set to ' . $deadline->format('F d, Y') . 
                ($autoFinalize ? '. Auto-finalization enabled.' : '')
            );
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Unlock a section for editing
     */
    public function unlockSection(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'school_year_id' => 'required|exists:school_years,id',
            'reason' => 'required|string|max:500',
        ]);

        $result = $this->finalizationService->unlockSection(
            $request->section_id,
            $request->school_year_id,
            auth()->id(),
            $request->reason
        );

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Re-lock a section after admin edits
     */
    public function relockSection(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        $result = $this->finalizationService->relockSection(
            $request->section_id,
            $request->school_year_id
        );

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Force end school year (admin override)
     */
    public function forceEndSchoolYear(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
            'reason' => 'required|string|max:1000',
        ]);

        $activeSchoolYear = SchoolYear::findOrFail($request->school_year_id);

        if (!$activeSchoolYear->is_active) {
            return redirect()->back()->with('error', 'This school year is not active.');
        }

        // Log the force end action
        Log::warning('Force ending school year', [
            'school_year_id' => $activeSchoolYear->id,
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
        ]);

        // Update closure record
        $closure = $this->finalizationService->getOrCreateClosure($activeSchoolYear->id);
        $closure->update([
            'status' => 'closed',
            'closure_completed_at' => now(),
            'closed_by' => auth()->id(),
            'admin_notes' => $request->reason,
        ]);

        // Proceed with normal end school year logic
        return $this->executeEndSchoolYear($activeSchoolYear);
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

        return null;
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

            // Initialize closure record
            $closure = $this->finalizationService->getOrCreateClosure($schoolYear->id);
            $closure->update([
                'total_sections' => Section::where('is_active', true)->count(),
                'status' => 'pending',
            ]);

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
     * End school year with finalization validation
     */
    public function endSchoolYear(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        $activeSchoolYear = SchoolYear::findOrFail($request->school_year_id);

        if (!$activeSchoolYear->is_active) {
            return redirect()->back()->with('error', 'This school year is not active.');
        }

        // Check if all sections are finalized
        $canEnd = $this->finalizationService->canEndSchoolYear($activeSchoolYear->id);

        if (!$canEnd['can_end']) {
            return redirect()->route('admin.school-years.closure')
                ->with('error', 'Cannot end school year. ' . $canEnd['pending_count'] . ' section(s) still pending finalization.');
        }

        if (!$canEnd['all_finalized']) {
            return redirect()->route('admin.school-years.closure')
                ->with('warning', 'Some sections are not finalized but deadline has passed. You may force end the school year with a reason.');
        }

        // Update closure record
        $closure = $canEnd['closure'];
        $closure->update([
            'status' => 'closing',
            'closure_started_at' => now(),
        ]);

        return $this->executeEndSchoolYear($activeSchoolYear);
    }

    /**
     * Execute the actual end school year logic
     */
    private function executeEndSchoolYear(SchoolYear $activeSchoolYear)
    {
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
                    'previous_school' => null,
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

            // Update closure record
            $closure = SchoolYearClosure::where('school_year_id', $activeSchoolYear->id)->first();
            if ($closure) {
                $closure->update([
                    'status' => 'closed',
                    'closure_completed_at' => now(),
                    'closed_by' => auth()->id(),
                    'closure_summary' => "{$promotedCount} students promoted, " . count($graduatedIds) . " graduated.",
                ]);
            }

            DB::commit();

            return redirect()->route('admin.school-years.index')->with('success',
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

    /**
     * Store a newly created school year
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:school_years',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $schoolYear = SchoolYear::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active', false),
            ]);

            return redirect()->back()->with('success', "School year '{$schoolYear->name}' created successfully.");
        } catch (\Exception $e) {
            Log::error('Create school year failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create school year.');
        }
    }
}
