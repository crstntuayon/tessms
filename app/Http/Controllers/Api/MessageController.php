<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Events\MessageSent;
use App\Events\MessageEdited;
use App\Events\MessageDeleted;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * Store a new message
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'body' => 'nullable|string|max:5000',
            'subject' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:messages,id',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $user = Auth::user();

        // Check if this is a reply to an existing conversation
        $parentId = $request->parent_id;
        if (!$parentId) {
            // Check if there's an existing conversation
            $existingMessage = Message::whereNull('parent_id')
                ->where(function ($q) use ($user, $request) {
                    $q->where('sender_id', $user->id)->where('recipient_id', $request->recipient_id);
                })->orWhere(function ($q) use ($user, $request) {
                    $q->where('sender_id', $request->recipient_id)->where('recipient_id', $user->id);
                })
                ->first();
            
            if ($existingMessage) {
                $parentId = $existingMessage->id;
            }
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'recipient_id' => $request->recipient_id,
            'parent_id' => $parentId,
            'subject' => $request->subject ?? 'Message from ' . $user->full_name,
            'body' => $request->body ?? '',
            'is_read' => false,
        ]);

        // Handle attachments
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

        // Load relationships
        $message->load(['sender', 'recipient', 'attachments']);

        // Broadcast the message
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            \Log::info('Broadcast failed: ' . $e->getMessage());
        }

        // Send notification
        try {
            NotificationService::notifyNewMessage(
                $request->recipient_id,
                $user->full_name,
                Str::limit($request->body ?? 'Sent an attachment', 100),
                $message->id
            );
        } catch (\Exception $e) {
            \Log::info('Notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message_id' => $message->id,
            'conversation_id' => $parentId ?? $message->id,
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'sender_id' => $message->sender_id,
                'recipient_id' => $message->recipient_id,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at->toISOString(),
                'attachments' => $message->attachments->map(function ($att) {
                    return [
                        'id' => $att->id,
                        'file_name' => $att->file_name,
                        'file_type' => $att->file_type,
                        'url' => route('api.attachments.view', $att),
                        'download_url' => route('api.attachments.download', $att),
                    ];
                }),
            ],
        ]);
    }

    /**
     * Get a specific message
     */
    public function show(Message $message)
    {
        $user = Auth::user();

        if ($message->recipient_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        $message->load(['sender', 'recipient', 'attachments', 'replies']);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'subject' => $message->subject,
                'sender' => [
                    'id' => $message->sender->id,
                    'name' => $message->sender->full_name,
                ],
                'recipient' => [
                    'id' => $message->recipient->id,
                    'name' => $message->recipient->full_name,
                ],
                'is_read' => $message->is_read,
                'read_at' => $message->read_at,
                'created_at' => $message->created_at->toISOString(),
                'attachments' => $message->attachments,
                'replies' => $message->replies,
            ],
        ]);
    }

    /**
     * Update a message (Edit)
     */
    public function update(Request $request, Message $message)
    {
        $user = Auth::user();

        // Only sender can edit their own message
        if ($message->sender_id !== $user->id) {
            return response()->json(['error' => 'You can only edit your own messages'], 403);
        }

        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message->update([
            'body' => $request->body,
            'is_edited' => true,
        ]);

        // Broadcast edit event
        try {
            broadcast(new MessageEdited($message))->toOthers();
        } catch (\Exception $e) {
            \Log::info('Edit broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'is_edited' => true,
            ]
        ]);
    }

    /**
     * Delete a message
     */
    public function destroy(Message $message)
    {
        $user = Auth::user();

        // Only sender can delete their own message
        if ($message->sender_id !== $user->id) {
            return response()->json(['error' => 'You can only delete your own messages'], 403);
        }

        $messageId = $message->id;
        $senderId = $message->sender_id;
        $recipientId = $message->recipient_id;

        foreach ($message->attachments as $attachment) {
            \Storage::disk('public')->delete($attachment->file_path);
        }

        $message->delete();

        // Broadcast delete event
        try {
            broadcast(new MessageDeleted($messageId, $senderId, $recipientId))->toOthers();
        } catch (\Exception $e) {
            \Log::info('Delete broadcast failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}
