<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Grade;
use App\Models\GradeLevel;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request, Section $section)
    {
        if ($section->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        // Students in the section
        $students = $section->students()->with('user')->get();

        // Get the section's grade level only
        $gradeLevel = $section->gradeLevel;
        $gradeLevels = collect([$gradeLevel]); // Wrap in collection for the view

        // Get selected grade level and filtered subjects
        $selectedGradeLevel = null;
        $filteredSubjects = collect();
        $selectedSubject = null;
        $grades = collect();
        $existingGrades = collect(); // Store existing grades data for JS

        // Always use the section's grade level
        $selectedGradeLevel = $gradeLevel;
        $filteredSubjects = $gradeLevel->subjects ?? collect();

        // If subject is selected, load existing grades for that subject
        if ($request->filled('subject')) {
            $selectedSubject = Subject::find($request->subject);
            
            if ($selectedSubject) {
                // Get existing grades with components for this subject and section
                $grades = Grade::where('section_id', $section->id)
                    ->where('subject_id', $selectedSubject->id)
                    ->where('quarter', $request->get('quarter', 1))
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->student_id . '_' . $item->component_type;
                    });
                
                // Prepare data for JavaScript to populate inputs
                foreach ($grades as $key => $grade) {
                    $existingGrades[$key] = [
                        'scores' => json_decode($grade->scores, true) ?? [],
                        'total_score' => $grade->total_score,
                        'percentage_score' => $grade->percentage_score,
                    ];
                }
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
        ]);

        // Validate weights sum to 100
        $totalWeight = $request->ww_weight + $request->pt_weight + $request->qe_weight;
        if (round($totalWeight, 2) != 100) {
            return back()->with('error', 'Component weights must sum to 100%. Current: ' . $totalWeight . '%');
        }

        $subjectId = $request->subject_id;
        $quarter = $request->quarter;

        // Process Written Work grades
        if ($request->has('ww')) {
            foreach ($request->ww as $studentId => $scores) {
                $this->saveGradeComponents($section->id, $studentId, $subjectId, $quarter, 'written_work', $scores);
            }
        }

        // Process Performance Task grades
        if ($request->has('pt')) {
            foreach ($request->pt as $studentId => $scores) {
                $this->saveGradeComponents($section->id, $studentId, $subjectId, $quarter, 'performance_task', $scores);
            }
        }

        // Process Quarterly Exam grades
        if ($request->has('qe')) {
            foreach ($request->qe as $studentId => $score) {
                if ($score !== null && $score !== '') {
                    $this->saveQuarterlyExam($section->id, $studentId, $subjectId, $quarter, $score);
                }
            }
        }

        // Calculate and save final grades for all students
        $students = $section->students()->pluck('id');
        foreach ($students as $studentId) {
            $this->calculateAndSaveFinalGrade(
                $section->id, 
                $studentId, 
                $subjectId, 
                $quarter,
                $request->ww_weight,
                $request->pt_weight,
                $request->qe_weight
            );
        }

        return back()->with('success', 'Grades saved and calculated successfully.');
    }

    /**
     * Save grade components (Written Work or Performance Tasks)
     */
    private function saveGradeComponents($sectionId, $studentId, $subjectId, $quarter, $componentType, $scores)
    {
        // Remove empty scores and calculate statistics
        $validScores = array_filter($scores, function($score) {
            return $score !== null && $score !== '';
        });

        if (empty($validScores)) {
            return;
        }

        $totalScore = array_sum($validScores);
        $count = count($validScores);

        // Calculate percentage score (assuming 100 points per activity by default)
        $totalPossible = $count * 100; // Can be customized based on actual total items
        $percentageScore = ($totalScore / $totalPossible) * 100;

        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => $componentType,
            ],
            [
                'scores' => json_encode(array_values($validScores)),
                'total_score' => $totalScore,
                'percentage_score' => round($percentageScore, 2),
            ]
        );
    }

    /**
     * Save Quarterly Exam grade
     */
    private function saveQuarterlyExam($sectionId, $studentId, $subjectId, $quarter, $score)
    {
        $totalItems = 100;
        $percentageScore = ($score / $totalItems) * 100;

        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => 'quarterly_exam',
            ],
            [
                'total_score' => $score,
                'percentage_score' => round($percentageScore, 2),
            ]
        );
    }

    /**
     * Calculate weighted scores and final grade with transmutation
     */
    private function calculateAndSaveFinalGrade($sectionId, $studentId, $subjectId, $quarter, $wwWeight, $ptWeight, $qeWeight)
    {
        // Get component scores
        $wwGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'written_work',
        ])->first();

        $ptGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'performance_task',
        ])->first();

        $qeGrade = Grade::where([
            'section_id' => $sectionId,
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'quarter' => $quarter,
            'component_type' => 'quarterly_exam',
        ])->first();

        // Calculate weighted scores
        $wwWeighted = $wwGrade ? ($wwGrade->percentage_score * ($wwWeight / 100)) : 0;
        $ptWeighted = $ptGrade ? ($ptGrade->percentage_score * ($ptWeight / 100)) : 0;
        $qeWeighted = $qeGrade ? ($qeGrade->percentage_score * ($qeWeight / 100)) : 0;

        $initialGrade = $wwWeighted + $ptWeighted + $qeWeighted;
        $transmutedGrade = $this->transmuteGrade($initialGrade);

        // Save or update final grade record
        Grade::updateOrCreate(
            [
                'section_id' => $sectionId,
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'quarter' => $quarter,
                'component_type' => 'final_grade',
            ],
            [
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
}
