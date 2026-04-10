<?php

namespace App\Services;

use App\Models\Section;
use App\Models\SchoolYear;
use App\Models\SectionFinalization;
use App\Models\SchoolYearClosure;
use App\Models\Grade;
use App\Models\CoreValue;
use App\Models\Attendance;
use App\Models\AttendanceSchoolDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FinalizationService
{
    /**
     * Get or create section finalization record
     */
    public function getOrCreateFinalization(int $sectionId, int $schoolYearId): SectionFinalization
    {
        $section = Section::findOrFail($sectionId);
        
        $finalization = SectionFinalization::firstOrCreate(
            [
                'section_id' => $sectionId,
                'school_year_id' => $schoolYearId,
            ],
            [
                'teacher_id' => $section->teacher_id,
            ]
        );

        return $finalization;
    }

    /**
     * Get or create school year closure record
     */
    public function getOrCreateClosure(int $schoolYearId): SchoolYearClosure
    {
        $closure = SchoolYearClosure::firstOrCreate(
            ['school_year_id' => $schoolYearId],
            [
                'total_sections' => Section::where('is_active', true)->count(),
                'status' => 'pending',
            ]
        );

        return $closure;
    }

    /**
     * Validate if grades can be finalized for a section
     */
    public function validateGradesFinalization(int $sectionId, int $schoolYearId): array
    {
        $section = Section::with('students', 'gradeLevel.subjects')->findOrFail($sectionId);
        $students = $section->students()->whereNotIn('status', ['completed', 'inactive'])->get();
        $subjects = $section->gradeLevel->subjects ?? collect();
        
        $errors = [];
        $warnings = [];

        if ($students->isEmpty()) {
            $errors[] = 'No active students found in this section.';
            return ['valid' => false, 'errors' => $errors, 'warnings' => $warnings];
        }

        // Check for missing grades
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                for ($quarter = 1; $quarter <= 4; $quarter++) {
                    $grade = Grade::where([
                        'section_id' => $sectionId,
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'school_year_id' => $schoolYearId,
                        'quarter' => $quarter,
                        'component_type' => 'final_grade',
                    ])->first();

                    if (!$grade || $grade->final_grade === null) {
                        $errors[] = "Missing grade for {$student->user->full_name} - {$subject->name} (Q{$quarter})";
                    }
                }
            }
        }

        // Limit errors to prevent overwhelming output
        if (count($errors) > 10) {
            $remaining = count($errors) - 10;
            $errors = array_slice($errors, 0, 10);
            $errors[] = "... and {$remaining} more missing grades.";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings,
        ];
    }

    /**
     * Validate if attendance can be finalized for a section
     */
    public function validateAttendanceFinalization(int $sectionId, int $schoolYearId): array
    {
        $section = Section::with('students')->findOrFail($sectionId);
        $students = $section->students()->whereNotIn('status', ['completed', 'inactive'])->get();
        
        $errors = [];
        $warnings = [];

        // Check if school days are configured for each month
        $schoolYear = SchoolYear::findOrFail($schoolYearId);
        $startDate = Carbon::parse($schoolYear->start_date);
        $endDate = Carbon::parse($schoolYear->end_date ?? now());
        
        $current = $startDate->copy();
        while ($current->lessThanOrEqualTo($endDate)) {
            $schoolDays = AttendanceSchoolDay::where([
                'section_id' => $sectionId,
                'school_year_id' => $schoolYearId,
                'month' => $current->month,
                'year' => $current->year,
            ])->first();

            if (!$schoolDays) {
                $warnings[] = "School days not configured for {$current->format('F Y')}";
            }

            $current->addMonth();
        }

        // Check for students with no attendance records
        foreach ($students as $student) {
            $attendanceCount = Attendance::where([
                'student_id' => $student->id,
                'school_year_id' => $schoolYearId,
            ])->count();

            if ($attendanceCount === 0) {
                $warnings[] = "No attendance records for {$student->user->full_name}";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings,
        ];
    }

    /**
     * Validate if core values can be finalized for a section
     */
    public function validateCoreValuesFinalization(int $sectionId, int $schoolYearId): array
    {
        $section = Section::with('students')->findOrFail($sectionId);
        $students = $section->students()->whereNotIn('status', ['completed', 'inactive'])->get();
        
        $errors = [];
        $warnings = [];
        $coreValues = ['Maka-Diyos', 'Makatao', 'Maka-Kalikasan', 'Maka-bansa'];

        foreach ($students as $student) {
            foreach ($coreValues as $coreValue) {
                for ($quarter = 1; $quarter <= 4; $quarter++) {
                    $rating = CoreValue::where([
                        'student_id' => $student->id,
                        'school_year_id' => $schoolYearId,
                        'quarter' => $quarter,
                        'core_value' => $coreValue,
                    ])->first();

                    if (!$rating) {
                        $errors[] = "Missing core value rating for {$student->user->full_name} - {$coreValue} (Q{$quarter})";
                    }
                }
            }
        }

        // Limit errors
        if (count($errors) > 10) {
            $remaining = count($errors) - 10;
            $errors = array_slice($errors, 0, 10);
            $errors[] = "... and {$remaining} more missing ratings.";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings,
        ];
    }

    /**
     * Finalize grades for a section
     */
    public function finalizeGrades(int $sectionId, int $schoolYearId, int $userId): array
    {
        $validation = $this->validateGradesFinalization($sectionId, $schoolYearId);
        
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => 'Cannot finalize grades. Please fix the errors.',
                'errors' => $validation['errors'],
            ];
        }

        try {
            DB::beginTransaction();

            $finalization = $this->getOrCreateFinalization($sectionId, $schoolYearId);
            $finalization->update([
                'grades_finalized' => true,
                'grades_finalized_at' => now(),
            ]);

            $this->checkAndUpdateFullFinalization($finalization, $userId);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Grades finalized successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to finalize grades', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to finalize grades: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Finalize attendance for a section
     */
    public function finalizeAttendance(int $sectionId, int $schoolYearId, int $userId): array
    {
        $validation = $this->validateAttendanceFinalization($sectionId, $schoolYearId);
        
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => 'Cannot finalize attendance.',
                'errors' => $validation['errors'],
            ];
        }

        try {
            DB::beginTransaction();

            $finalization = $this->getOrCreateFinalization($sectionId, $schoolYearId);
            $finalization->update([
                'attendance_finalized' => true,
                'attendance_finalized_at' => now(),
            ]);

            $this->checkAndUpdateFullFinalization($finalization, $userId);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Attendance finalized successfully.',
                'warnings' => $validation['warnings'],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to finalize attendance', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to finalize attendance: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Finalize core values for a section
     */
    public function finalizeCoreValues(int $sectionId, int $schoolYearId, int $userId): array
    {
        $validation = $this->validateCoreValuesFinalization($sectionId, $schoolYearId);
        
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => 'Cannot finalize core values. Please fix the errors.',
                'errors' => $validation['errors'],
            ];
        }

        try {
            DB::beginTransaction();

            $finalization = $this->getOrCreateFinalization($sectionId, $schoolYearId);
            $finalization->update([
                'core_values_finalized' => true,
                'core_values_finalized_at' => now(),
            ]);

            $this->checkAndUpdateFullFinalization($finalization, $userId);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Core values finalized successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to finalize core values', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to finalize core values: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check if all components are finalized and update full finalization status
     */
    private function checkAndUpdateFullFinalization(SectionFinalization $finalization, int $userId): void
    {
        if ($finalization->grades_finalized && 
            $finalization->attendance_finalized && 
            $finalization->core_values_finalized) {
            
            $finalization->update([
                'is_fully_finalized' => true,
                'finalized_at' => now(),
                'finalized_by' => $userId,
                'is_locked' => true,
                'locked_at' => now(),
            ]);

            // Update closure progress
            $closure = $this->getOrCreateClosure($finalization->school_year_id);
            $closure->updateProgress();
        }
    }

    /**
     * Unlock a section for editing (admin only)
     */
    public function unlockSection(int $sectionId, int $schoolYearId, int $adminId, ?string $reason = null): array
    {
        try {
            DB::beginTransaction();

            $finalization = SectionFinalization::where([
                'section_id' => $sectionId,
                'school_year_id' => $schoolYearId,
            ])->first();

            if (!$finalization) {
                return [
                    'success' => false,
                    'message' => 'No finalization record found.',
                ];
            }

            $finalization->update([
                'is_locked' => false,
                'unlocked_at' => now(),
                'unlocked_by' => $adminId,
                'unlock_reason' => $reason,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Section unlocked successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to unlock section', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to unlock section: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Re-lock a section after admin edits
     */
    public function relockSection(int $sectionId, int $schoolYearId): array
    {
        try {
            DB::beginTransaction();

            $finalization = SectionFinalization::where([
                'section_id' => $sectionId,
                'school_year_id' => $schoolYearId,
            ])->first();

            if (!$finalization) {
                return [
                    'success' => false,
                    'message' => 'No finalization record found.',
                ];
            }

            $finalization->update([
                'is_locked' => true,
                'locked_at' => now(),
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Section re-locked successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to relock section', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to relock section: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check if school year can be ended
     */
    public function canEndSchoolYear(int $schoolYearId): array
    {
        $closure = $this->getOrCreateClosure($schoolYearId);
        $closure->updateProgress();

        $pendingSections = SectionFinalization::where('school_year_id', $schoolYearId)
            ->where('is_fully_finalized', false)
            ->with('section', 'section.teacher.user')
            ->get();

        $allFinalized = $pendingSections->isEmpty();

        return [
            'can_end' => $allFinalized || $closure->isReadyToClose(),
            'all_finalized' => $allFinalized,
            'pending_count' => $pendingSections->count(),
            'pending_sections' => $pendingSections,
            'closure' => $closure,
        ];
    }

    /**
     * Set finalization deadline
     */
    public function setDeadline(int $schoolYearId, Carbon $deadline, bool $autoFinalize = false): array
    {
        try {
            $closure = $this->getOrCreateClosure($schoolYearId);
            
            // Update all pending finalizations with deadline
            SectionFinalization::where('school_year_id', $schoolYearId)
                ->where('is_fully_finalized', false)
                ->update(['deadline_at' => $deadline]);

            $closure->update([
                'finalization_deadline' => $deadline,
                'auto_close_enabled' => $autoFinalize,
                'auto_close_at' => $autoFinalize ? $deadline : null,
            ]);

            return [
                'success' => true,
                'message' => 'Deadline set successfully.',
            ];
        } catch (\Exception $e) {
            Log::error('Failed to set deadline', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to set deadline: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Process auto-finalization for overdue sections
     */
    public function processAutoFinalization(): void
    {
        $overdueFinalizations = SectionFinalization::where('is_fully_finalized', false)
            ->whereNotNull('deadline_at')
            ->where('deadline_at', '<', now())
            ->where('auto_finalized', false)
            ->get();

        foreach ($overdueFinalizations as $finalization) {
            try {
                DB::beginTransaction();

                // Auto-finalize all components
                $finalization->update([
                    'grades_finalized' => true,
                    'grades_finalized_at' => now(),
                    'attendance_finalized' => true,
                    'attendance_finalized_at' => now(),
                    'core_values_finalized' => true,
                    'core_values_finalized_at' => now(),
                    'is_fully_finalized' => true,
                    'finalized_at' => now(),
                    'is_locked' => true,
                    'locked_at' => now(),
                    'auto_finalized' => true,
                ]);

                // Update closure progress
                $closure = $this->getOrCreateClosure($finalization->school_year_id);
                $closure->updateProgress();

                DB::commit();

                Log::info('Auto-finalized section', [
                    'section_id' => $finalization->section_id,
                    'school_year_id' => $finalization->school_year_id,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to auto-finalize section', [
                    'section_id' => $finalization->section_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Check if a section is editable
     */
    public function isSectionEditable(int $sectionId, int $schoolYearId): bool
    {
        $finalization = SectionFinalization::where([
            'section_id' => $sectionId,
            'school_year_id' => $schoolYearId,
        ])->first();

        if (!$finalization) {
            return true;
        }

        return !$finalization->is_locked;
    }

    /**
     * Get finalization status for all sections
     */
    public function getAllSectionsStatus(int $schoolYearId): array
    {
        $sections = Section::with(['teacher.user'])
            ->where('is_active', true)
            ->get();

        $finalizations = SectionFinalization::where('school_year_id', $schoolYearId)
            ->get()
            ->keyBy('section_id');

        $result = [];
        foreach ($sections as $section) {
            $finalization = $finalizations->get($section->id);
            
            $result[] = [
                'section' => $section,
                'finalization' => $finalization,
                'status' => $finalization ? $finalization->getStatusBadge() : ['text' => 'Pending', 'class' => 'bg-slate-100 text-slate-600'],
                'completion' => $finalization ? $finalization->getCompletionPercentage() : 0,
            ];
        }

        return $result;
    }
}
