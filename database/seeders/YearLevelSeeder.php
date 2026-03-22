<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YearLevel;

class YearLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'];

        foreach ($levels as $level) {
            YearLevel::updateOrCreate(['name' => $level]);
        }
    }
}
