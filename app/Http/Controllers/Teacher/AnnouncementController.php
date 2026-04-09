<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementAttachment;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Events\AnnouncementPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * List all announcements created by this teacher.
     */
    public function index()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        $sections = $teacher ? $teacher->sections()->with('gradeLevel')->get() : collect();
        $gradeLevels = GradeLevel::orderBy('order')->get();

        $announcements = Announcement::where('author_id', Auth::id())
            ->with(['schoolYear', 'section', 'gradeLevel', 'reads'])
            ->withCount('reads')
            ->ordered()
            ->paginate(10);

        return view('teacher.announcements.index', compact(
            'announcements',
            'sections',
            'gradeLevels'
        ));
    }

    /**
     * Show the form to create a new announcement.
     */
    public function create()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        $sections = $teacher ? $teacher->sections()->with('gradeLevel')->get() : collect();
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $activeSchoolYear = SchoolYear::getActive();

        return view('teacher.announcements.create', compact(
            'sections',
            'gradeLevels',
            'activeSchoolYear'
        ));
    }

    /**
     * Store a new announcement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
            'scope' => 'required|in:section,grade,school,all',
            'target_id' => 'nullable|required_if:scope,section,grade|integer',
            'priority' => 'required|in:normal,important,urgent',
            'pinned' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $activeSchoolYear = SchoolYear::getActive();

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'author_id' => Auth::id(),
            'scope' => $validated['scope'],
            'target_id' => in_array($validated['scope'], ['section', 'grade']) ? $validated['target_id'] : null,
            'grade_level_id' => $validated['scope'] === 'grade' ? $validated['target_id'] : null,
            'priority' => $validated['priority'],
            'pinned' => $request->boolean('pinned'),
            'expires_at' => $validated['expires_at'] ?? null,
            'school_year_id' => $activeSchoolYear?->id,
            'target' => 'students',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('announcement-attachments', 'public');
                AnnouncementAttachment::create([
                    'announcement_id' => $announcement->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Broadcast to all users
        broadcast(new AnnouncementPosted($announcement))->toOthers();

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * Show the form to edit an announcement.
     */
    public function edit(Announcement $announcement)
    {
        if ($announcement->author_id !== Auth::id()) {
            abort(403);
        }

        $teacher = Teacher::where('user_id', Auth::id())->first();
        $sections = $teacher ? $teacher->sections()->with('gradeLevel')->get() : collect();
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $activeSchoolYear = SchoolYear::getActive();

        $announcement->load('attachments');

        return view('teacher.announcements.edit', compact(
            'announcement',
            'sections',
            'gradeLevels',
            'activeSchoolYear'
        ));
    }

    /**
     * Update an announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->author_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
            'scope' => 'required|in:section,grade,school,all',
            'target_id' => 'nullable|required_if:scope,section,grade|integer',
            'priority' => 'required|in:normal,important,urgent',
            'pinned' => 'boolean',
            'expires_at' => 'nullable|date',
            'attachments.*' => 'nullable|file|max:10240',
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'integer|exists:announcement_attachments,id',
        ]);

        $announcement->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'scope' => $validated['scope'],
            'target_id' => in_array($validated['scope'], ['section', 'grade']) ? $validated['target_id'] : null,
            'grade_level_id' => $validated['scope'] === 'grade' ? $validated['target_id'] : null,
            'priority' => $validated['priority'],
            'pinned' => $request->boolean('pinned'),
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        // Remove selected attachments
        if ($request->has('remove_attachments')) {
            foreach ($request->input('remove_attachments') as $attId) {
                $att = AnnouncementAttachment::where('id', $attId)->where('announcement_id', $announcement->id)->first();
                if ($att) {
                    Storage::disk('public')->delete($att->file_path);
                    $att->delete();
                }
            }
        }

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('announcement-attachments', 'public');
                AnnouncementAttachment::create([
                    'announcement_id' => $announcement->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Show a single announcement with read stats.
     */
    public function show(Announcement $announcement)
    {
        // Authorization: teacher can only view their own announcements
        if ($announcement->author_id !== Auth::id()) {
            abort(403);
        }

        $announcement->load(['author', 'schoolYear', 'section.gradeLevel', 'gradeLevel', 'attachments']);

        $activeSchoolYear = SchoolYear::getActive();

        // Get read stats - only count students enrolled in active school year
        $readStats = [];
        if ($announcement->scope === 'section' && $announcement->section) {
            $totalStudents = Student::whereHas('enrollments', function ($q) use ($activeSchoolYear, $announcement) {
                $q->where('school_year_id', $activeSchoolYear?->id)
                  ->where('section_id', $announcement->target_id)
                  ->where('status', 'enrolled');
            })->count();
            $readCount = $announcement->readCount();
            $readStats = [
                'total' => $totalStudents,
                'read' => $readCount,
                'unread' => max(0, $totalStudents - $readCount),
            ];
        } elseif ($announcement->scope === 'grade' && $announcement->gradeLevel) {
            $totalStudents = Student::whereHas('enrollments', function ($q) use ($activeSchoolYear, $announcement) {
                $q->where('school_year_id', $activeSchoolYear?->id)
                  ->where('grade_level_id', $announcement->target_id)
                  ->where('status', 'enrolled');
            })->count();
            $readCount = $announcement->readCount();
            $readStats = [
                'total' => $totalStudents,
                'read' => $readCount,
                'unread' => max(0, $totalStudents - $readCount),
            ];
        }

        return view('teacher.announcements.show', compact('announcement', 'readStats'));
    }

    /**
     * Toggle pin status.
     */
    public function togglePin(Announcement $announcement)
    {
        if ($announcement->author_id !== Auth::id()) {
            abort(403);
        }

        $announcement->update(['pinned' => !$announcement->pinned]);

        return back()->with('success', $announcement->pinned ? 'Announcement pinned.' : 'Announcement unpinned.');
    }

    /**
     * Delete an announcement.
     */
    public function destroy(Announcement $announcement)
    {
        if ($announcement->author_id !== Auth::id()) {
            abort(403);
        }

        // Delete attachments from storage
        foreach ($announcement->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }

        $announcement->delete();

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted.');
    }
}
