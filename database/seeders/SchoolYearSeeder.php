<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolYear;
use Carbon\Carbon;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        $schoolYears = [
            [
                'name' => '2026-2027',
                'start_date' => '2026-06-01',
                'end_date' => '2027-03-31',
                'is_active' => 1,
                'description' => 'School year 2026-2027 (current)',
            ],
            [
                'name' => '2027-2028',
                'start_date' => '2027-06-01',
                'end_date' => '2028-03-31',
                'is_active' => 0,
                'description' => 'School year 2027-2028',
            ],
            [
                'name' => '2028-2029',
                'start_date' => '2028-06-01',
                'end_date' => '2029-03-31',
                'is_active' => 0, 
                'description' => 'School year 2028-2029',
            ],
             [
                'name' => '2029-2030',
                'start_date' => '2029-06-01',
                'end_date' => '2030-03-31',
                'is_active' => 0,
                'description' => 'School year 2029-2030',
            ],
            [
                'name' => '2030-2031',
                'start_date' => '2030-06-01',
                'end_date' => '2031-03-31',
                'is_active' => 0, 
                'description' => 'School year 2030-2031',
            ],
             [
                'name' => '2031-2032',
                'start_date' => '2031-06-01',
                'end_date' => '2032-03-31',
                'is_active' => 0,
                'description' => 'School year 2031-2032',
            ],
            [
                'name' => '2032-2033',
                'start_date' => '2032-06-01',
                'end_date' => '2033-03-31',
                'is_active' => 0, 
                'description' => 'School year 2032-2033',
            ],
             [
                'name' => '2033-2034',
                'start_date' => '2033-06-01',
                'end_date' => '2034-03-31',
                'is_active' => 0,
                'description' => 'School year 2033-2034',
            ],
            [
                'name' => '2034-2035',
                'start_date' => '2034-06-01',
                'end_date' => '2035-03-31',
                'is_active' => 0, 
                'description' => 'School year 2034-2035',
            ],
             [
                'name' => '2035-2036',
                'start_date' => '2035-06-01',
                'end_date' => '2036-03-31',
                'is_active' => 0,
                'description' => 'School year 2035-2036',
            ],
            [
                'name' => '2036-2037',
                'start_date' => '2036-06-01',
                'end_date' => '2037-03-31',
                'is_active' => 0, 
                'description' => 'School year 2036-2037',
            ],
             [
                'name' => '2037-2038',
                'start_date' => '2037-06-01',
                'end_date' => '2038-03-31',
                'is_active' => 0,
                'description' => 'School year 2037-2038',
            ],
            [
                'name' => '2038-2039',
                'start_date' => '2038-06-01',
                'end_date' => '2039-03-31',
                'is_active' => 0, 
                'description' => 'School year 2038-2039',
            ],
             [
                'name' => '2039-2040',
                'start_date' => '2039-06-01',
                'end_date' => '2040-03-31',
                'is_active' => 0,
                'description' => 'School year 2039-2040',
            ],
      
        ];

        foreach ($schoolYears as $year) {
            SchoolYear::updateOrCreate(
                ['name' => $year['name']], // match by name to avoid duplicates
                $year
            );
        }
    }
}