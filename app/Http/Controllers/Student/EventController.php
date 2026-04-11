<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events for students.
     */
    public function index()
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $events = Event::when($activeSchoolYear, function($q) use ($activeSchoolYear) {
                return $q->where('school_year_id', $activeSchoolYear->id);
            })
            ->orderBy('date', 'asc')
            ->get();
            
        return view('student.events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('student.events.show', compact('event'));
    }
}
