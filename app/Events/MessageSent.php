<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'recipient', 'attachments']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // Private channel for the recipient
            new PrivateChannel('user.' . $this->message->recipient_id),
            // Private channel for the sender (to sync across devices)
            new PrivateChannel('user.' . $this->message->sender_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'subject' => $this->message->subject,
            'body' => $this->message->body,
            'preview' => $this->message->preview,
            'is_read' => $this->message->is_read,
            'is_bulk' => $this->message->is_bulk,
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->full_name,
                'first_name' => $this->message->sender->first_name,
                'last_name' => $this->message->sender->last_name,
            ],
            'recipient' => [
                'id' => $this->message->recipient->id,
                'name' => $this->message->recipient->full_name,
            ],
            'attachments_count' => $this->message->attachments->count(),
            'created_at' => $this->message->created_at->toISOString(),
            'created_at_human' => $this->message->created_at->diffForHumans(),
        ];
    }
}
