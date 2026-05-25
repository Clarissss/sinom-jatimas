<?php

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation->load(['user', 'admin', 'latestMessage.sender']);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('admin.conversations'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'conversation.updated';
    }

    public function broadcastWith(): array
    {
        $latestMessage = $this->conversation->latestMessage;

        return [
            'conversation' => [
                'id' => $this->conversation->id,
                'user_id' => $this->conversation->user_id,
                'admin_id' => $this->conversation->admin_id,
                'status' => $this->conversation->status,
                'subject' => $this->conversation->subject,
                'last_message_at' => $this->conversation->last_message_at?->toIso8601String(),
                'created_at' => $this->conversation->created_at->toIso8601String(),
                'user' => [
                    'id' => $this->conversation->user->id,
                    'name' => $this->conversation->user->name,
                    'photo_url' => $this->conversation->user->photo_url,
                ],
                'latest_message' => $latestMessage ? [
                    'id' => $latestMessage->id,
                    'message' => $latestMessage->message,
                    'sender_id' => $latestMessage->sender_id,
                    'sender_name' => $latestMessage->sender->name,
                    'created_at' => $latestMessage->created_at->toIso8601String(),
                ] : null,
            ],
        ];
    }
}
