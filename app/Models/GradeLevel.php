<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

     protected $fillable = ['name', 'order', 'is_final'];
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sections()
{
    return $this->hasMany(Section::class);
}
}