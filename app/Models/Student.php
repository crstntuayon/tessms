<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'enrollment_date' => 'date',

    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

 // Get the latest enrollment's section
public function section()
{
    return $this->hasOneThrough(
        Section::class,
        Enrollment::class,
        'student_id', // Foreign key on enrollments table
        'id',         // Foreign key on sections table
        'id',         // Local key on students table
        'section_id'  // Local key on enrollments table
    )->latestOfMany(); // pick the latest enrollment if multiple
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



    // Avatar accessor
    public function getAvatarAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }


public function getAgeAttribute()
{
    return $this->birthdate 
        ? Carbon::parse($this->birthdate)->age 
        : null;
}

    
}