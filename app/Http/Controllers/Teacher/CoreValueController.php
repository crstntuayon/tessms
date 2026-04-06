<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use App\Models\CoreValue;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CoreValueController extends Controller
{
    /**
     * Display the core values rating page for a section
     */
    public function index(Section $section, Request $request)
    {
        $currentQuarter = $request->get('quarter', $this->getCurrentQuarter());
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $students = $section->students()
            ->whereNotIn('status', ['completed', 'inactive'])
            ->with([
                'user:id,first_name,last_name',
                'coreValues' => function($query) use ($currentQuarter, $activeSchoolYear) {
                    $query->where('quarter', $currentQuarter)
                          ->where('school_year_id', $activeSchoolYear?->id);
                }
            ])
            ->get()
            ->sortBy('user.last_name');

        return view('teacher.core-values.index', compact(
            'section',
            'students',
            'currentQuarter',
            'activeSchoolYear'
        ));
    }

    /**
     * Store core value ratings for a student
     */
    public function store(Section $section, Request $request)
    {
        Log::info('Core Values Store Request', [
            'section_id' => $section->id,
            'teacher_id' => Auth::id(),
            'all_input' => $request->all()
        ]);

        try {
            $activeSchoolYear = SchoolYear::where('is_active', true)->first();
            
            if (!$activeSchoolYear) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active school year found. Please contact administrator.'
                ], 422);
            }

            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'quarter' => 'required|integer|between:1,4',
                'ratings' => 'required|array|min:1',
                'ratings.*.core_value' => 'required|in:Maka-Diyos,Makatao,Maka-Kalikasan,Maka-bansa',
                'ratings.*.behavior_statement' => 'required|string|max:500',
                'ratings.*.statement_key' => 'required|string|max:50',
                'ratings.*.rating' => 'required|in:AO,SO,RO,NO',
                'ratings.*.remarks' => 'nullable|string|max:1000',
            ]);

            DB::beginTransaction();

            $studentId = $validated['student_id'];
            $quarter = $validated['quarter'];
            $teacherId = Auth::id();

            foreach ($validated['ratings'] as $index => $rating) {
                Log::info("Processing rating {$index}", $rating);

                CoreValue::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'core_value' => $rating['core_value'],
                        'statement_key' => $rating['statement_key'],
                        'quarter' => $quarter,
                        'school_year_id' => $activeSchoolYear->id,
                    ],
                    [
                        'behavior_statement' => $rating['behavior_statement'],
                        'rating' => $rating['rating'],
                        'remarks' => $rating['remarks'] ?? null,
                        'recorded_by' => $teacherId,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Core values saved successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving core values', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current quarter based on date
     */
    private function getCurrentQuarter(): int
    {
        $month = now()->month;
        
        return match(true) {
            $month >= 6 && $month <= 8 => 1,
            $month >= 9 && $month <= 11 => 2,
            $month == 12 || $month <= 2 => 3,
            default => 4,
        };
    }
}