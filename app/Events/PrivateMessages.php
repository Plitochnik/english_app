<?php

namespace App\Events;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateMessages implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $sender;

    private User $recipient;

    private Messages $message;

    private string $created_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $recipient, User $sender, $message)
    {
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('messages-for-user.' . $this->recipient->id);
    }

    public function broadcastAs()
    {
        return 'private.messages';
    }

    public function broadcastWith()
    {
        return [
            'sender' => ['id' => $this->sender->id, 'name' => $this->sender->name],
            'message' => $this->message,
        ];
    }
}
