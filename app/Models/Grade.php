<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
protected $fillable = [
    'section_id',
    'student_id',
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
];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
