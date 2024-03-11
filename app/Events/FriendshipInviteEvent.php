<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipInviteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    /*
     * @var int
     * User ID of the person who gets the invitation
     */

    public $friend;

    public function __construct($friend)
    {
        $this->friend = $friend;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('invite-from.' . $this->friend->id);
    }

    public function broadcastAs()
    {
        return 'invitation';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'You just got a new invitation from '. $this->friend->name .'!'
        ];
    }
}
