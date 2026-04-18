<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ConversationController extends Controller
{
    /**
     * Get all conversations for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $roleName = strtolower($user->role?->name ?? '');
        
        // Get all unique users the current user has messaged with
        $sentTo = Message::where('sender_id', $user->id)
            ->distinct()
            ->pluck('recipient_id');
            
        $receivedFrom = Message::where('recipient_id', $user->id)
            ->distinct()
            ->pluck('sender_id');
            
        $userIds = $sentTo->merge($receivedFrom)->unique()->values();
        
        $conversations = [];
        
        // Filter userIds to only include currently enrolled students (for teachers)
        // or the student's teacher (for students)
        $allowedUserIds = $this->getAllowedContactIds($user, $roleName);
        
        foreach ($userIds as $otherUserId) {
            // Skip if this user is not an allowed contact
            if (!in_array($otherUserId, $allowedUserIds)) {
                continue;
            }
            
            $otherUser = User::find($otherUserId);
            if (!$otherUser) continue;
            
            // Get unread count from this user
            $unreadCount = Message::where('sender_id', $otherUserId)
                ->where('recipient_id', $user->id)
                ->where('is_read', false)
                ->count();
            
            // Get last message
            $lastMessage = Message::betweenUsers($user->id, $otherUserId)
                ->latest()
                ->first();
            
            // Check if user is online (last seen within 2 minutes)
            $isOnline = Cache::has('user-online-' . $otherUserId);
            
            $conversations[] = [
                'id' => $otherUserId,
                'user_id' => $otherUserId,
                'name' => $otherUser->full_name,
                'initials' => $this->getInitials($otherUser->full_name),
                'is_online' => $isOnline,
                'lastMessage' => $lastMessage ? substr($lastMessage->body, 0, 50) : 'No messages yet',
                'lastMessageTime' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                'unreadCount' => $unreadCount,
            ];
        }
        
        return response()->json(['conversations' => $conversations]);
    }

    /**
     * Get messages for a specific conversation
     */
    public function show(Request $request, $userId)
    {
        $user = Auth::user();
        $roleName = strtolower($user->role?->name ?? '');
        
        // Verify the user is an allowed contact before showing messages
        $allowedUserIds = $this->getAllowedContactIds($user, $roleName);
        
        \Log::info('API show: user=' . $user->id . ' role=' . $roleName . ' target=' . $userId . ' allowed=' . implode(',', $allowedUserIds));
        
        if (!in_array((int) $userId, $allowedUserIds)) {
            \Log::warning('API show: 403 - user ' . $userId . ' not in allowed list');
            return response()->json([
                'error' => 'You can only message currently enrolled students.',
                'messages' => [],
            ], 403);
        }
        
        try {
            // Get all messages between these two users
            $messages = Message::betweenUsers($user->id, $userId)
                ->with('attachments')
                ->orderBy('created_at', 'asc')
                ->get();

            $formattedMessages = $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'body' => $msg->body,
                    'sender_id' => $msg->sender_id,
                    'recipient_id' => $msg->recipient_id,
                    'is_read' => (bool) $msg->is_read,
                    'is_edited' => (bool) $msg->is_edited,
                    'created_at' => $msg->created_at ? $msg->created_at->toISOString() : null,
                    'attachments' => $msg->attachments->map(function ($att) {
                        return [
                            'id' => $att->id,
                            'file_name' => $att->file_name,
                            'file_type' => $att->file_type,
                            'url' => route('api.attachments.view', $att),
                            'download_url' => route('api.attachments.download', $att),
                        ];
                    }),
                ];
            });

            return response()->json([
                'messages' => $formattedMessages,
                'has_more' => false,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error loading messages: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load messages',
                'messages' => [],
            ], 500);
        }
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead($userId)
    {
        $user = Auth::user();

        Message::where('sender_id', $userId)
            ->where('recipient_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get IDs of users that the current user is allowed to message.
     * For teachers: only students enrolled in their sections for the active school year.
     * For students: only their teacher from their current enrollment.
     */
    private function getAllowedContactIds($user, $roleName)
    {
        $allowedIds = [];
        
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        if ($roleName === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                // Build list of section IDs this teacher is assigned to
                // NOTE: We do NOT filter sections by school_year_id here because
                // sections may be tagged to a different year than their enrollments.
                // We filter enrollments by school year instead.
                $teacherSectionIds = collect();
                
                // 1) Sections where teacher is the adviser (teacher_id)
                $teacherSectionIds = $teacherSectionIds->merge(
                    Section::where('teacher_id', $teacher->id)->pluck('id')
                );
                
                // 2) Sections where teacher is assigned via teacher_sections pivot
                $pivotSectionIds = \DB::table('teacher_sections')
                    ->where('teacher_id', $teacher->id)
                    ->pluck('section_id');
                $teacherSectionIds = $teacherSectionIds->merge($pivotSectionIds)->unique()->values();
                
                \Log::info('API Conversation: Teacher ' . $teacher->id . ' section IDs: ' . $teacherSectionIds->implode(', '));
                
                if ($teacherSectionIds->isNotEmpty()) {
                    // Find enrollments in teacher's sections for active school year
                    $enrollmentQuery = Enrollment::whereIn('section_id', $teacherSectionIds)
                        ->where('status', 'enrolled');
                    
                    if ($activeSchoolYear) {
                        $enrollmentQuery->where('school_year_id', $activeSchoolYear->id);
                    }
                    
                    $studentIds = $enrollmentQuery->pluck('student_id');
                    
                    $userIds = Student::whereIn('id', $studentIds)
                        ->whereNotNull('user_id')
                        ->pluck('user_id');
                    
                    $allowedIds = $userIds->toArray();
                    
                    \Log::info('API Conversation: Found ' . count($allowedIds) . ' allowed contacts');
                }
            }
        } elseif ($roleName === 'student') {
            $enrollmentQuery = Enrollment::whereHas('student', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->where('status', 'enrolled')
                ->with('section');
            
            if ($activeSchoolYear) {
                $enrollmentQuery->where('school_year_id', $activeSchoolYear->id);
            }
            
            $enrollment = $enrollmentQuery->first();
            
            if ($enrollment && $enrollment->section && $enrollment->section->teacher_id) {
                $teacherUser = User::whereHas('teacher', function ($q) use ($enrollment) {
                    $q->where('id', $enrollment->section->teacher_id);
                })->first();
                
                if ($teacherUser) {
                    $allowedIds[] = $teacherUser->id;
                }
            }
        }
        
        // Convert all IDs to integers for consistent comparison
        return array_map('intval', $allowedIds);
    }

    private function getInitials($name)
    {
        $parts = explode(' ', $name);
        $initials = '';
        foreach ($parts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        return $initials;
    }
}
