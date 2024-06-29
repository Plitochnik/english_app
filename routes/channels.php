<?php

use App\Broadcasting\GameChannel;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messages-for-user.{userID}', function ($user, $userID) {
    return $user->id === (int) $userID;
});

// game session
 Broadcast::channel('game.{key}', GameChannel::class);
