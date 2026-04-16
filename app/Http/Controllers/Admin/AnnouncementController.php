<?php

namespace App\Http\Controllers\Admin;

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
     * List all announcements (admin sees everything).
     */
    public function index()
    {
        $sections = Section::with('gradeLevel')->get();
        $gradeLevels = GradeLevel::orderBy('order')->get();

        $announcements = Announcement::with(['author', 'schoolYear', 'section.gradeLevel', 'gradeLevel', 'attachments'])
            ->withCount('reads')
            ->ordered()
            ->paginate(10);

        return view('admin.announcements.index', compact(
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
        $sections = Section::with('gradeLevel')->get();
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $activeSchoolYear = SchoolYear::getActive();

        return view('admin.announcements.create', compact(
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

        // Send database notifications to targeted users
        try {
            $userIds = [];

            if (in_array($announcement->scope, ['all', 'school'])) {
                $userIds = \App\Models\User::whereHas('role', function($q) {
                    $q->whereRaw('LOWER(name) IN (?, ?)', ['student', 'teacher']);
                })->pluck('id')->toArray();
            } elseif ($announcement->scope === 'grade' && $announcement->grade_level_id) {
                $userIds = \App\Models\User::whereHas('student', function($q) use ($announcement) {
                    $q->where('grade_level_id', $announcement->grade_level_id);
                })->pluck('id')->toArray();
            } elseif ($announcement->scope === 'section' && $announcement->target_id) {
                $userIds = \App\Models\User::whereHas('student', function($q) use ($announcement) {
                    $q->where('section_id', $announcement->target_id);
                })->pluck('id')->toArray();
            }

            // Exclude the creator from receiving their own notification
            $userIds = array_diff($userIds, [Auth::id()]);

            if (!empty($userIds)) {
                \App\Services\NotificationService::notifyMany(
                    $userIds,
                    'announcement',
                    "New Announcement: {$announcement->title}",
                    strip_tags($announcement->message),
                    [
                        'url' => route('student.announcements.show', $announcement),
                        'announcement_id' => $announcement->id,
                    ]
                );
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send announcement notifications: ' . $e->getMessage());
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * Show the form to edit an announcement.
     */
    public function edit(Announcement $announcement)
    {
        $sections = Section::with('gradeLevel')->get();
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $activeSchoolYear = SchoolYear::getActive();

        $announcement->load('attachments');

        return view('admin.announcements.edit', compact(
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

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Show a single announcement with read stats.
     */
    public function show(Announcement $announcement)
    {
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

        return view('admin.announcements.show', compact('announcement', 'readStats'));
    }

    /**
     * Toggle pin status.
     */
    public function togglePin(Announcement $announcement)
    {
        $announcement->update(['pinned' => !$announcement->pinned]);

        return back()->with('success', $announcement->pinned ? 'Announcement pinned.' : 'Announcement unpinned.');
    }

    /**
     * Delete an announcement.
     */
    public function destroy(Announcement $announcement)
    {
        // Delete attachments from storage
        foreach ($announcement->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted.');
    }
}
