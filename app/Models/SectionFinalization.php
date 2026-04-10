<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionFinalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'school_year_id',
        'teacher_id',
        'grades_finalized',
        'grades_finalized_at',
        'attendance_finalized',
        'attendance_finalized_at',
        'core_values_finalized',
        'core_values_finalized_at',
        'is_fully_finalized',
        'finalized_at',
        'finalized_by',
        'is_locked',
        'locked_at',
        'unlocked_at',
        'unlocked_by',
        'unlock_reason',
        'deadline_at',
        'auto_finalized',
    ];

    protected $casts = [
        'grades_finalized' => 'boolean',
        'attendance_finalized' => 'boolean',
        'core_values_finalized' => 'boolean',
        'is_fully_finalized' => 'boolean',
        'is_locked' => 'boolean',
        'auto_finalized' => 'boolean',
        'grades_finalized_at' => 'datetime',
        'attendance_finalized_at' => 'datetime',
        'core_values_finalized_at' => 'datetime',
        'finalized_at' => 'datetime',
        'locked_at' => 'datetime',
        'unlocked_at' => 'datetime',
        'deadline_at' => 'datetime',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function finalizedByUser()
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }

    public function unlockedByUser()
    {
        return $this->belongsTo(User::class, 'unlocked_by');
    }

    // Scopes
    public function scopeFinalized($query)
    {
        return $query->where('is_fully_finalized', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_fully_finalized', false);
    }

    public function scopeLocked($query)
    {
        return $query->where('is_locked', true);
    }

    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    // Helpers
    public function isCompletelyFinalized(): bool
    {
        return $this->is_fully_finalized && 
               $this->grades_finalized && 
               $this->attendance_finalized && 
               $this->core_values_finalized;
    }

    public function canBeEdited(): bool
    {
        return !$this->is_locked || $this->unlocked_at !== null;
    }

    public function getCompletionPercentage(): int
    {
        $completed = 0;
        if ($this->grades_finalized) $completed++;
        if ($this->attendance_finalized) $completed++;
        if ($this->core_values_finalized) $completed++;
        return ($completed / 3) * 100;
    }

    public function getStatusBadge(): array
    {
        if ($this->is_fully_finalized && $this->is_locked) {
            return ['text' => 'Finalized & Locked', 'class' => 'bg-emerald-100 text-emerald-700'];
        } elseif ($this->is_fully_finalized) {
            return ['text' => 'Finalized', 'class' => 'bg-blue-100 text-blue-700'];
        } elseif ($this->getCompletionPercentage() > 0) {
            return ['text' => 'In Progress', 'class' => 'bg-amber-100 text-amber-700'];
        } else {
            return ['text' => 'Pending', 'class' => 'bg-slate-100 text-slate-600'];
        }
    }
}
