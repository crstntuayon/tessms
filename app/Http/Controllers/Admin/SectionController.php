<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
public function index(Request $request)
{
    $query = Section::with(['gradeLevel', 'teacher', 'students', 'schoolYear']);
    
    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('room_number', 'like', "%{$search}%")
              ->orWhereHas('teacher', function($tq) use ($search) {
                  $tq->where('first_name', 'like', "%{$search}%")
                     ->orWhere('last_name', 'like', "%{$search}%");
              })
              ->orWhereHas('gradeLevel', function($gq) use ($search) {
                  $gq->where('name', 'like', "%{$search}%");
              });
        });
    }
    
    $sections = $query->orderBy('grade_level_id')->orderBy('name')->paginate(10);
    
    return view('admin.sections.index', compact('sections'));
}

    public function show($id)
{
    $section = Section::with(['teacher', 'students', 'gradeLevel'])->findOrFail($id);

    return view('admin.sections.show', compact('section'));
}

    public function create()
    {
        $gradeLevels = GradeLevel::orderBy('name')->get();
        
        // Only teachers without sections in active school year
        $activeYear = SchoolYear::getActive();
        $teachers = Teacher::whereDoesntHave('section', function ($q) use ($activeYear) {
                if ($activeYear) {
                    $q->where('school_year_id', $activeYear->id);
                }
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $schoolYears = SchoolYear::orderBy('start_date', 'desc')->get();
        $activeSchoolYear = $activeYear;

        return view('admin.sections.create', compact(
            'gradeLevels', 
            'teachers', 
            'schoolYears',
            'activeSchoolYear'
        ));
    }

    public function store(Request $request)
    {
        $activeYear = SchoolYear::getActive();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'school_year_id' => 'nullable|exists:school_years,id',
            'teacher_id' => 'nullable|exists:teachers,id|unique:sections,teacher_id,NULL,id,school_year_id,' . ($request->school_year_id ?? $activeYear?->id),
            'room_number' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:60',
        ], [
            'teacher_id.unique' => 'This teacher is already assigned to a section in this school year.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Auto-assign active school year if none selected
        $data = $validator->validated();
        if (empty($data['school_year_id']) && $activeYear) {
            $data['school_year_id'] = $activeYear->id;
        }

        Section::create($data);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        $gradeLevels = GradeLevel::orderBy('name')->get();
        $schoolYears = SchoolYear::orderBy('start_date', 'desc')->get();
        
        $activeYear = SchoolYear::getActive();
        $teachers = Teacher::whereDoesntHave('section', function ($q) use ($activeYear, $section) {
                $q->where('school_year_id', $activeYear?->id ?? $section->school_year_id)
                  ->where('id', '!=', $section->teacher_id);
            })
            ->orWhere('id', $section->teacher_id)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.sections.edit', compact('section', 'gradeLevels', 'teachers', 'schoolYears'));
    }

    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'school_year_id' => 'nullable|exists:school_years,id',
            'teacher_id' => 'nullable|exists:teachers,id|unique:sections,teacher_id,' . $section->id . ',id,school_year_id,' . ($request->school_year_id ?? $section->school_year_id),
            'room_number' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:60',
        ], [
            'teacher_id.unique' => 'This teacher is already assigned to another section in this school year.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $section->update($validator->validated());

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully.');
    }
}