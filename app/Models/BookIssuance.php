<?php
// app/Models/BookIssuance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookIssuance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'book_id',
        'school_year_id',
        'section_id',
        'date_issued',
        'condition_issued',
        'issued_by',
        'date_returned',
        'condition_returned',
        'returned_to',
        'fine_amount',
        'remarks',
        'status'
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_returned' => 'date',
        'fine_amount' => 'decimal:2'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    public function scopeForSchoolYear($query, $schoolYearId)
    {
        return $query->where('school_year_id', $schoolYearId);
    }

    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    public function isOverdue(): bool
    {
        if ($this->status !== 'issued' || !$this->date_returned_expected) {
            return false;
        }
        return now()->greaterThan($this->date_returned_expected);
    }
}