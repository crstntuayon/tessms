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
        return $this->belongsTo(Section::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

        public function enrollment()
    {
        return $this->hasOne(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // Full name accessor
    public function getFullNameAttribute(): ?string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    // Age accessor
    public function getAgeAttribute(): ?int
    {
        return $this->birthdate ? $this->birthdate->diffInYears() : null;
    }

    // Avatar accessor
    public function getAvatarAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    
}