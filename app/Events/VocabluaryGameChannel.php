<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VocabluaryGameChannel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $gameKey;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($gameKey)
    {
        $this->gameKey = $gameKey;
    }

    public function broadcastAs()
    {
        return 'join.game';
    }

    /**
     * Get the channels the event should broadcast on
     */
    public function broadcastOn()
    {
        return new PresenceChannel('game.'.$this->gameKey);
    }
}
