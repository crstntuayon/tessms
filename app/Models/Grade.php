<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
protected $fillable = [
    'section_id',
    'student_id',
    'school_year_id',
    'subject_id',
    'quarter',
    'component_type',
    'scores',
    'total_score',
    'percentage_score',
    'ww_weighted',
    'pt_weighted',
    'qe_weighted',
    'initial_grade',
    'final_grade',
    'remarks',
    'titles',
    'total_items',
];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function calculateFinalGrade()
{
    $ww = $this->written_works_avg ?? 0;
    $pt = $this->performance_tasks_avg ?? 0;

    // Example formula (adjust if needed)
    return round(($ww * 0.4) + ($pt * 0.6), 2);
}

public function section()
{
    return $this->belongsTo(Section::class);
}

public function schoolYear()
{
    return $this->belongsTo(SchoolYear::class);
}

}
