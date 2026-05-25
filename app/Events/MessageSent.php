<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn(): array
    {
        $channels = [];

        // Project-based chat
        if ($this->message->project_id) {
            $channels[] = new Channel('project.' . $this->message->project_id);
        }

        // General conversation chat
        if ($this->message->conversation_id) {
            $channels[] = new Channel('conversation.' . $this->message->conversation_id);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'project_id' => $this->message->project_id,
            'conversation_id' => $this->message->conversation_id,
            'message' => $this->message->message,
            'file_path' => $this->message->file_path,
            'file_name' => $this->message->file_name,
            'file_type' => $this->message->file_type,
            'file_size' => $this->message->file_size,
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
                'role' => $this->message->sender->role,
            ],
            'created_at' => $this->message->created_at->toIso8601String(),
        ];
    }
}
