<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // The table name (optional if it follows Laravel convention 'events')
    protected $table = 'events';

    // Mass assignable fields
    protected $fillable = [
        'title',
        'description',
        'date',
    ];

    // Cast 'date' to a Carbon instance
    protected $casts = [
        'date' => 'date',
    ];
}