<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearLevel extends Model
{
    use HasFactory;

    protected $table = 'year_levels';

    // Mass assignable fields
    protected $fillable = [
        'name',
    ];

    /**
     * Sections that belong to this year level
     */
    public function sections()
    {
        return $this->hasMany(Section::class, 'year_level'); 
        // assumes 'year_level' column in sections table stores year_level id
    }
}
