<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Services\NotificationService;

class CommunicationController extends Controller
{
    /**
     * Show communications dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Auto-create teacher record if missing (same as DashboardController)
        $teacher = Teacher::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => explode(' ', $user->name)[0] ?? 'Teacher',
                'last_name'  => explode(' ', $user->name)[1] ?? '',
            ]
        );
        
        $sections = $teacher->sections()->with('gradeLevel')->get();
        $tab = $request->get('tab', 'inbox');
        $search = $request->get('search');

        // Get ALL conversations where user is either sender or recipient (unified inbox)
        $query = Message::whereNull('parent_id')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
            })
            ->with(['sender', 'recipient', 'attachments', 'replies']);

        if ($search) {
            $query->search($search);
        }

        $messages = $query->orderByDesc('created_at')->paginate(20);
        $unreadCount = Message::receivedBy($user->id)->unread()->count();

        return view('teacher.communications.index', compact(
            'sections',
            'messages',
            'unreadCount',
            'tab',
            'search'
        ));
    }

    /**
     * Send message to individual student
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:individual,section',
            'recipient_id' => 'required_if:recipient_type,individual|exists:users,id',
            'section_id' => 'required_if:recipient_type,section|exists:sections,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        if ($request->recipient_type === 'individual') {
            return $this->sendIndividualMessage($request);
        } else {
            return $this->sendBulkMessage($request);
        }
    }

    private function sendIndividualMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'subject' => $request->subject,
            'body' => $request->body,
            'is_read' => false,
            'is_bulk' => false,
        ]);

        $this->handleAttachments($request, $message);

        // Broadcast the message in real-time (optional - doesn't fail if Reverb is down)
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            // Silently fail if Reverb is not running
            \Log::info('Broadcast failed (Reverb may not be running): ' . $e->getMessage());
        }

        return redirect()->route('teacher.communications.index', ['tab' => 'sent'])
            ->with('success', 'Message sent successfully!');
    }

    private function sendBulkMessage(Request $request)
    {
        $section = Section::findOrFail($request->section_id);
        $students = $section->students()->whereHas('user', function ($q) {
            $q->where('is_active', true);
        })->with('user')->get();

        $sentCount = 0;

        foreach ($students as $student) {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $student->user_id,
                'section_id' => $section->id,
                'subject' => $request->subject,
                'body' => $request->body,
                'is_read' => false,
                'is_bulk' => true,
            ]);

            $this->handleAttachments($request, $message);
            
            // Broadcast to each student (optional)
            try {
                broadcast(new MessageSent($message))->toOthers();
            } catch (\Exception $e) {
                \Log::info('Broadcast failed (Reverb may not be running): ' . $e->getMessage());
            }
            
            $sentCount++;
        }

        return redirect()->route('teacher.communications.index', ['tab' => 'sent'])
            ->with('success', "Message sent to {$sentCount} students in {$section->name}!");
    }

    private function handleAttachments(Request $request, Message $message)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message-attachments/' . $message->id, 'public');
                MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
    }

    /**
     * Show message details
     */
    public function show(Message $message)
    {
        $user = Auth::user();

        if ($message->recipient_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        if ($message->recipient_id === $user->id && !$message->is_read) {
            $message->markAsRead();
            // Broadcast read receipt to sender (optional)
            try {
                broadcast(new MessageRead($message))->toOthers();
            } catch (\Exception $e) {
                \Log::info('Broadcast failed (Reverb may not be running): ' . $e->getMessage());
            }
        }

        $message->load(['sender', 'recipient', 'attachments', 'replies.sender', 'replies.attachments']);

        return view('teacher.communications.show', compact('message'));
    }

    /**
     * Reply to a message
     */
    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'body' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $user = Auth::user();

        // Both sender and recipient can reply - determine who to reply to
        if ($message->sender_id === $user->id) {
            // Current user is the sender, reply goes to recipient
            $recipientId = $message->recipient_id;
        } elseif ($message->recipient_id === $user->id) {
            // Current user is the recipient, reply goes to sender
            $recipientId = $message->sender_id;
        } else {
            abort(403, 'You are not part of this conversation.');
        }

        $reply = Message::create([
            'sender_id' => $user->id,
            'recipient_id' => $recipientId,
            'parent_id' => $message->parent_id ?? $message->id,
            'subject' => 'Re: ' . $message->subject,
            'body' => $request->body,
            'is_read' => false,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message-attachments/' . $reply->id, 'public');
                MessageAttachment::create([
                    'message_id' => $reply->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Broadcast the reply in real-time (optional)
        try {
            broadcast(new MessageSent($reply))->toOthers();
        } catch (\Exception $e) {
            \Log::info('Broadcast failed (Reverb may not be running): ' . $e->getMessage());
        }

        // Send notification to recipient
        try {
            NotificationService::notifyNewMessage(
                $recipientId,
                $user->full_name,
                Str::limit($request->body, 100),
                $reply->id
            );
        } catch (\Exception $e) {
            \Log::info('Notification failed: ' . $e->getMessage());
        }

        return redirect()->route('teacher.communications.show', $message->parent_id ?? $message)
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Delete a message
     */
    public function destroy(Message $message)
    {
        $user = Auth::user();

        if ($message->recipient_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        foreach ($message->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $message->delete();

        return redirect()->route('teacher.communications.index')
            ->with('success', 'Message deleted successfully!');
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(MessageAttachment $attachment)
    {
        $user = Auth::user();
        $message = $attachment->message;

        if ($message->recipient_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }

    /**
     * Get students for section (AJAX)
     */
    public function getSectionStudents(Section $section)
    {
        // Get current school year
        $currentSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();
        
        \Log::info('Loading students for section: ' . $section->id . ', school year: ' . ($currentSchoolYear ? $currentSchoolYear->id : 'none'));
        
        $query = $section->students()
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            });
            
        // Only filter by enrollment if we have a current school year
        if ($currentSchoolYear) {
            $query->whereHas('enrollments', function ($q) use ($currentSchoolYear) {
                $q->where('status', 'enrolled')
                  ->where('school_year_id', $currentSchoolYear->id);
            });
        }
        
        $students = $query->with('user')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->user_id,
                    'name' => $student->user->full_name,
                    'lrn' => $student->lrn,
                ];
            });
        
        \Log::info('Found ' . $students->count() . ' students');

        return response()->json($students);
    }
}
