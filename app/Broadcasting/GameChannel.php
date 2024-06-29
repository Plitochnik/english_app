<?php

namespace App\Broadcasting;

use App\Http\Controllers\GameController;
use App\Models\ConnectedGameUsers;
use App\Models\Game;
use App\Models\User;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Http\Request;

class GameChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @return array|bool
     * @throws \Exception
     */
    public function join(User $user, $key)
    {
        $game = Game::select('id', 'key', 'is_private', 'players_count')
            ->where(['key' => $key, 'is_online' => true])
            ->first();

        // is there a free slot in the game?
        $connectedUsers = ConnectedGameUsers::where('game_id', $game->id)->count();
        $isFullRoom = $game->players_count === $connectedUsers;

        if (!$game || !isset($user->id)) {
            return null;
        }

        if ($isFullRoom) {
            throw new \Exception('The game room is full.');
        }

        if ($game === true) {
            // TODO logic of checking the user's ID in the 'private_game_users' table. Might create something like: $user->canJoinRoom
        } else {
            (new GameController())->logConnectionToPublicVocabularyGame(new Request(['game_key' => $game->key, 'leave' => false]));

            return ['id' => $user->id, 'name' => $user->name];
        }
    }
}
