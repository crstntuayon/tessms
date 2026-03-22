<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;


class SchoolYearController extends Controller
{
    public function setActive(Request $request)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);

        // Deactivate all
        SchoolYear::query()->update(['is_active' => false]);

        // Activate selected
        $year = SchoolYear::findOrFail($request->school_year_id);
        $year->update(['is_active' => true]);

        return back()->with('success', 'Active school year updated.');
    }
}