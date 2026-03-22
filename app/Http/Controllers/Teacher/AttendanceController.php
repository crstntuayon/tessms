<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;


class AttendanceController extends Controller
{
    //

    public function index()
{
    return view('teacher.attendance.index');
}

    public function bulkStore(Request $request)
{
    // save attendance logic
    return back()->with('success', 'Attendance saved');
}

 public function monthly(Request $request)
    {
        $sectionId = $request->query('section_id');
        $month = $request->query('month');
        $year = $request->query('year');

        // Validate inputs
        if (!$sectionId || !$month || !$year) {
            return response()->json([], 400);
        }

        // Fetch attendances for the month
        $attendances = Attendance::where('section_id', $sectionId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy(function ($item) {
                return $item->date->format('Y-m-d');
            });

        return response()->json($attendances);
    }

}
