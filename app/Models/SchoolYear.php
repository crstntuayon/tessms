<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'is_active', 'description'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    // Scope for active school year
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get active school year (helper method)
    public static function getActive()
    {
        return self::active()->first();
    }

    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
}