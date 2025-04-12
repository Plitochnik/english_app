<?php

namespace App\Http\Controllers;

use App\Models\ConnectedGameUsers;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    public function renderPage()
    {
        return Inertia::render('VocabularyGame');
    }

    public function store(Request $request)
    {
        $userID = auth()->user()->id;

        if (!$userID) {
            return response(['message' => 'Unauthorised user'], 401);
        }

        // uncomment it out when you finish debugging
//        $request['test_from'] = $request['test_from']['name'];
//        $request['test_to'] = $request['test_to']['name'];

        return Game::create($request->all());
    }

    public function logConnectionToPublicVocabularyGame(Request $request)
    {
        $userID = auth()->user()->id;
        $gameID = Game::where('key', $request['game_key'])->where('is_online', true)->value('id');

        if (!$gameID) {
            return response(['message' => "Sorry, game doesn't exist"], 403);
        }

        // leave the game?
        if ($request['leave'] === true) {
            return ConnectedGameUsers::where('game_id', $gameID)->where('user_id', $userID)->delete();
        }

        // join game
        return ConnectedGameUsers::updateOrCreate([
            'user_id' => $userID,
            'game_id' => $gameID,
        ]);
    }
}
