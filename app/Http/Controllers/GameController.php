<?php

namespace App\Http\Controllers;

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

        $request['test_from'] = $request['test_from']['name'];
        $request['test_to'] = $request['test_to']['name'];

        return Game::create($request->all());
    }
}
