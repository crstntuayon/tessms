<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Grade;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\Setting;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->with('user')
            ->get();

        $gradeLevel = $section->gradeLevel;
        $gradeLevels = collect([$gradeLevel]);

        $selectedGradeLevel = null;
        $filteredSubjects = collect();
        $selectedSubject = null;
        $grades = collect();
        $existingGrades = collect();

        $selectedGradeLevel = $gradeLevel;
        $filteredSubjects = $gradeLevel->subjects ?? collect();

        if ($request->filled('subject')) {
            $selectedSubject = Subject::find($request->subject);
            
            if ($selectedSubject) {
                $grades = Grade::where('section_id', $section->id)
                    ->where('subject_id', $selectedSubject->id)
                    ->where('quarter', $request->get('quarter', 1))
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->student_id . '_' . $item->component_type;
                    });
                
                foreach ($grades as $key => $grade) {
                    $existingGrades[$key] = [
                        'scores' => json_decode($grade->scores, true) ?? [],
                        'titles' => json_decode($grade->titles, true) ?? [],
                        'total_items' => json_decode($grade->total_items, true) ?? [],
                        'total_score' => $grade->total_score,
                        'percentage_score' => $grade->percentage_score,
                    ];
                }
                
                $wwGrade = $grades->firstWhere('component_type', 'written_work');
                $ptGrade = $grades->firstWhere('component_type', 'performance_task');
                $qeGrade = $grades->firstWhere('component_type', 'quarterly_exam');
                
                $existingGrades['ww_titles'] = $wwGrade ? (json_decode($wwGrade->titles, true) ?? []) : [];
                $existingGrades['pt_titles'] = $ptGrade ? (json_decode($ptGrade->titles, true) ?? []) : [];
                $existingGrades['ww_total_items'] = $wwGrade ? (json_decode($wwGrade->total_items, true) ?? []) : [];
                $existingGrades['pt_total_items'] = $ptGrade ? (json_decode($ptGrade->total_items, true) ?? []) : [];
                // NEW: Load QE total items from first QE grade record
                $existingGrades['qe_total_items'] = $qeGrade ? ($qeGrade->total_items ?? 100) : 100;
            }
        }

        return view('teacher.grades.index', compact(
            'section', 
            'students', 
            'gradeLevels', 
            'selectedGradeLevel', 
            'filteredSubjects', 
            'selectedSubject',
            'grades',
            'existingGrades'
        ));
    }

    public function create()
    {
        return view('teacher.grades.create');
    }

    public function store(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'quarter' => 'required|in:1,2,3,4',
            'ww_weight' => 'required|numeric|min:0|max:100',
            'pt_weight' => 'required|numeric|min:0|max:100',
            'qe_weight' => 'required|numeric|min:0|max:100',
            'ww' => 'nullable|array',
            'pt' => 'nullable|array',
            'qe' => 'nullable|array',
            'ww_titles' => 'nullable|array',
            'pt_titles' => 'nullable|array',
            'ww_total_items' => 'nullable|array',
            'pt_total_items' => 'nullable|array',
            'qe_total_items' => 'nullable|numeric|min:1', // NEW: Validation for QE total items
        ]);

        $totalWeight = $request->ww_weight + $request->pt_weight + $request->qe_weight;
        if (round($totalWeight, 2) != 100) {
            return back()->with('error', 'Component weights must sum to 100%. Current: ' . $totalWeight . '%');
        }

        $subjectId = $request->subject_id;
        $quarter = $request->quarter;

        // Get active school year from is_active flag
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }
        
        $schoolYearId = $activeSchoolYear->id;

        if ($request->has('ww')) {
            $wwTitles = $request->ww_titles ?? [];
            $wwTotalItems = $request->ww_total_items ?? [];
            foreach ($request->ww as $studentId => $scores) {
                $this->saveGradeComponents($section->id, $studentId, $subjectId, $quarter, 'written_work', $scores, $wwTitles, $wwTotalItems, $schoolYearId);
            }
        }

        if ($request->has('pt')) {
            $ptTitles = $request->pt_titles ?? [];
            $ptTotalItems = $request->pt_total_items ?? [];
            foreach ($request->pt as $studentId => $scores) {
                $this->saveGradeComponents($section->id, $studentId, $subjectId, $quarter, 'performance_task', $scores, $ptTitles, $ptTotalItems, $schoolYearId);
            }
        }

        if ($request->has('qe')) {
            $qeTotalItems = $request->qe_total_items ?? 100; // NEW: Get QE total items from request
            foreach ($request->qe as $studentId => $score) {
                if ($score !== null && $score !== '') {
                    $this->saveQuarterlyExam($section->id, $studentId, $subjectId, $quarter, $score, $qeTotalItems, $schoolYearId);
                }
            }
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->pluck('id');
            
        foreach ($students as $studentId) {
            $this->calculateAndSaveFinalGrade(
                $section->id, 
                $studentId, 
                $subjectId, 
                $quarter,
                $request->ww_weight,
                $request->pt_weight,
                $request->qe_weight,
                $schoolYearId
            );
        }

        return back()->with('success', 'Grades saved and calculated successfully.');
    }

    /**
     * Save grade components (Written Work or Performance Tasks)
     */
    private function saveGradeComponents($sectionId, $studentId, $subjectId, $quarter, $componentType, $scores, $titles = [], $totalItems = [], $schoolYearId = null)
    {
        $validScores = array_filter($scores, function($score) {
            return $score !== null && $score !== '';
        });

        if (empty($validScores)) {
            return;
        }

        $totalScore = array_sum($validScores);
        $count = count($validScores);

        // Calculate percentage score using individual total items
        $totalPossible = 0;
        foreach ($validScores as $index => $score) {
            $itemCount = isset($totalItems[$index]) && $totalItems[$index] > 0 ? $totalItems[$index] : 100;
            $totalPossible += $itemCount;
        }
        
        $percentageScore = $totalPossible > 0 ? ($totalScore / $totalPossible) * 100 : 0;

        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => $componentType,
                'school_year_id' => $schoolYearId,
            ],
            [
                'school_year_id' => $schoolYearId,
                'scores' => json_encode(array_values($validScores)),
                'titles' => json_encode(array_values($titles)),
                'total_items' => json_encode(array_values($totalItems)),
                'total_score' => $totalScore,
                'percentage_score' => round($percentageScore, 2),
            ]
        );
    }

    /**
     * Save Quarterly Exam grade - UPDATED to include total_items
     */
    private function saveQuarterlyExam($sectionId, $studentId, $subjectId, $quarter, $score, $totalItems = 100, $schoolYearId = null)
    {
        $percentageScore = ($score / $totalItems) * 100;

        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => 'quarterly_exam',
                'school_year_id' => $schoolYearId,
            ],
            [
                'school_year_id' => $schoolYearId,
                'total_score' => $score,
                'total_items' => $totalItems, // NEW: Save total items
                'percentage_score' => round($percentageScore, 2),
            ]
        );
    }

    /**
     * Calculate weighted scores and final grade with transmutation
     */
    private function calculateAndSaveFinalGrade($sectionId, $studentId, $subjectId, $quarter, $wwWeight, $ptWeight, $qeWeight, $schoolYearId = null)
    {
        $wwGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'written_work',
            'school_year_id' => $schoolYearId,
        ])->first();

        $ptGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'performance_task',
            'school_year_id' => $schoolYearId,
        ])->first();

        $qeGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'quarterly_exam',
            'school_year_id' => $schoolYearId,
        ])->first();

        $wwWeighted = $wwGrade ? ($wwGrade->percentage_score * ($wwWeight / 100)) : 0;
        $ptWeighted = $ptGrade ? ($ptGrade->percentage_score * ($ptWeight / 100)) : 0;
        $qeWeighted = $qeGrade ? ($qeGrade->percentage_score * ($qeWeight / 100)) : 0;

        $initialGrade = $wwWeighted + $ptWeighted + $qeWeighted;
        $transmutedGrade = $this->transmuteGrade($initialGrade);

        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => 'final_grade',
                'school_year_id' => $schoolYearId,
            ],
            [
                'school_year_id' => $schoolYearId,
                'ww_weighted' => round($wwWeighted, 2),
                'pt_weighted' => round($ptWeighted, 2),
                'qe_weighted' => round($qeWeighted, 2),
                'initial_grade' => round($initialGrade, 2),
                'final_grade' => $transmutedGrade,
                'remarks' => $this->getRemarks($transmutedGrade),
            ]
        );
    }

    /**
     * DepEd Transmutation Table
     */
    private function transmuteGrade($initialGrade)
    {
        $transmutationTable = [
            ['min' => 100.00, 'max' => 100.00, 'grade' => 100],
            ['min' => 98.40, 'max' => 99.99, 'grade' => 99],
            ['min' => 96.80, 'max' => 98.39, 'grade' => 98],
            ['min' => 95.20, 'max' => 96.79, 'grade' => 97],
            ['min' => 93.60, 'max' => 95.19, 'grade' => 96],
            ['min' => 92.00, 'max' => 93.59, 'grade' => 95],
            ['min' => 90.40, 'max' => 91.99, 'grade' => 94],
            ['min' => 88.80, 'max' => 90.39, 'grade' => 93],
            ['min' => 87.20, 'max' => 88.79, 'grade' => 92],
            ['min' => 85.60, 'max' => 87.19, 'grade' => 91],
            ['min' => 84.00, 'max' => 85.59, 'grade' => 90],
            ['min' => 82.40, 'max' => 83.99, 'grade' => 89],
            ['min' => 80.80, 'max' => 82.39, 'grade' => 88],
            ['min' => 79.20, 'max' => 80.79, 'grade' => 87],
            ['min' => 77.60, 'max' => 79.19, 'grade' => 86],
            ['min' => 76.00, 'max' => 77.59, 'grade' => 85],
            ['min' => 74.40, 'max' => 75.99, 'grade' => 84],
            ['min' => 72.80, 'max' => 74.39, 'grade' => 83],
            ['min' => 71.20, 'max' => 72.79, 'grade' => 82],
            ['min' => 69.60, 'max' => 71.19, 'grade' => 81],
            ['min' => 68.00, 'max' => 69.59, 'grade' => 80],
            ['min' => 66.40, 'max' => 67.99, 'grade' => 79],
            ['min' => 64.80, 'max' => 66.39, 'grade' => 78],
            ['min' => 63.20, 'max' => 64.79, 'grade' => 77],
            ['min' => 61.60, 'max' => 63.19, 'grade' => 76],
            ['min' => 60.00, 'max' => 61.59, 'grade' => 75],
            ['min' => 56.00, 'max' => 59.99, 'grade' => 74],
            ['min' => 52.00, 'max' => 55.99, 'grade' => 73],
            ['min' => 48.00, 'max' => 51.99, 'grade' => 72],
            ['min' => 44.00, 'max' => 47.99, 'grade' => 71],
            ['min' => 40.00, 'max' => 43.99, 'grade' => 70],
            ['min' => 36.00, 'max' => 39.99, 'grade' => 69],
            ['min' => 32.00, 'max' => 35.99, 'grade' => 68],
            ['min' => 28.00, 'max' => 31.99, 'grade' => 67],
            ['min' => 24.00, 'max' => 27.99, 'grade' => 66],
            ['min' => 20.00, 'max' => 23.99, 'grade' => 65],
            ['min' => 16.00, 'max' => 19.99, 'grade' => 64],
            ['min' => 12.00, 'max' => 15.99, 'grade' => 63],
            ['min' => 8.00, 'max' => 11.99, 'grade' => 62],
            ['min' => 4.00, 'max' => 7.99, 'grade' => 61],
            ['min' => 0.00, 'max' => 3.99, 'grade' => 60],
        ];

        foreach ($transmutationTable as $range) {
            if ($initialGrade >= $range['min'] && $initialGrade <= $range['max']) {
                return $range['grade'];
            }
        }

        return 60;
    }

    /**
     * Get remarks based on transmuted grade
     */
    private function getRemarks($grade)
    {
        if ($grade >= 75) {
            return 'Passed';
        } elseif ($grade >= 70) {
            return 'Almost Passed';
        } else {
            return 'Failed';
        }
    }

    /**
     * Quick Grade Entry - Spreadsheet view for all subjects
     */
    public function quickEntry(Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->with('user')
            ->orderBy('last_name')
            ->get();

        $subjects = $section->gradeLevel->subjects ?? collect();
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        $currentQuarter = Setting::get('current_quarter', 1);

        // Get all existing grades for quick loading
        $grades = Grade::where('section_id', $section->id)
            ->where('school_year_id', $activeSchoolYear?->id)
            ->where('quarter', $currentQuarter)
            ->where('component_type', 'final_grade')
            ->get()
            ->keyBy(function ($item) {
                return $item->student_id . '_' . $item->subject_id;
            });

        return view('teacher.grades.quick-entry', compact(
            'section',
            'students',
            'subjects',
            'grades',
            'currentQuarter'
        ));
    }

    /**
     * Save quick grades
     */
    public function saveQuickGrades(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'grades' => 'required|array',
            'quarter' => 'required|in:1,2,3,4',
        ]);

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        DB::beginTransaction();
        try {
            foreach ($request->grades as $studentId => $subjects) {
                foreach ($subjects as $subjectId => $grade) {
                    if ($grade !== null && $grade !== '') {
                        Grade::updateOrCreate(
                            [
                                'section_id' => $section->id,
                                'student_id' => $studentId,
                                'subject_id' => $subjectId,
                                'quarter' => $request->quarter,
                                'component_type' => 'final_grade',
                                'school_year_id' => $activeSchoolYear->id,
                            ],
                            [
                                'school_year_id' => $activeSchoolYear->id,
                                'final_grade' => $grade,
                                'remarks' => $this->getRemarks($grade),
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return back()->with('success', 'Grades saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save grades: ' . $e->getMessage());
        }
    }
}