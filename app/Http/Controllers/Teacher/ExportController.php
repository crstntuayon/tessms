<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    //

    public function sf1(Request $request)
{
    $sectionId = $request->section_id;

    // TODO: Generate SF1 (PDF/Excel later)
    return response()->json([
        'message' => 'SF1 export working',
        'section_id' => $sectionId
    ]);
}

    public function sf9(Request $request)
{
    $sectionId = $request->section_id;

    return response()->json([
        'message' => 'SF9 export not yet implemented',
        'section_id' => $sectionId
    ]);
}
}
