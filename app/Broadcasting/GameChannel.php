<?php

namespace App\Broadcasting;

use App\Models\User;
use Illuminate\Broadcasting\PresenceChannel;

class GameChannel
{
    private $gameID;

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct($gameID)
    {
        $this->gameID = $gameID;
    }

    /**
     * Get the channels the event should broadcast on
     */
    public function broadcastOn()
    {
        return new PresenceChannel('game.'.$this->gameID);
    }

    public function broadcastAs()
    {
        return 'join.game';
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        //
    }
}
