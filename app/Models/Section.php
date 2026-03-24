<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_level_id',
         'school_year_id', 
            'room_number',
        'teacher_id',
        'capacity',
        'is_active',
    ];

    /**
     * SECTION → GRADE LEVEL
     */
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * SECTION → TEACHER (Adviser)
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * SECTION → STUDENTS
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Check if section is full
     */
    public function isFull()
    {
        if (!$this->capacity) return false;

        return $this->students()->count() >= $this->capacity;
    }

    /**
     * Remaining slots
     */
    public function remainingSlots()
    {
        if (!$this->capacity) return null;

        return $this->capacity - $this->students()->count();
    
    }

    // Scope for active school year sections
    public function scopeActiveYear($query)
    {
        return $query->whereHas('schoolYear', function ($q) {
            $q->where('is_active', true);
        });
    }

        public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_section', 'section_id', 'teacher_id');
    }

    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
}