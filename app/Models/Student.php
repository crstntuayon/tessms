<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lrn',
        'birthdate',
        'birth_place',
        'gender',
        'nationality',
        'religion',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'guardian_name',
        'guardian_relationship',
        'guardian_contact',
        'street_address',
        'barangay',
        'city',
        'province',
        'zip_code',
        'status',
        'grade_level_id',
        'section_id',
        'photo',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class);
    }

    public function enrolledSections()
    {
        return $this->belongsToMany(Section::class, 'student_section');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // ✅ FIXED: Changed from method to accessor
    public function getFullNameAttribute(): ?string
    {
        return $this->user ? $this->user->full_name : null;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birthdate ? $this->birthdate->diffInYears() : null;
    }

    // ✅ FIXED: Changed from avatar() method to getAvatarAttribute accessor
    public function getAvatarAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}