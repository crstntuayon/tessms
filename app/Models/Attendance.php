<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Attendance extends Model
{
     protected $fillable = ['section_id', 'student_id', 'date', 'teacher_id', 'school_year_id', 'status', 'remarks'];


    public function section()
    {
        return $this->belongsTo(Section::class);
    }

       public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
