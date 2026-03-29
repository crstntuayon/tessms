<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'grade_level',
        'isbn',
        'publisher',
        'year_published',
        'price',
        'total_copies',
        'available_copies',
        'type',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year_published' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
        'is_active' => 'boolean'
    ];

    public function issuances(): HasMany
    {
        return $this->hasMany(BookIssuance::class);
    }

    public function activeIssuances(): HasMany
    {
        return $this->hasMany(BookIssuance::class)->where('status', 'issued');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }
}