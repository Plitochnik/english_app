<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FriendsController extends Controller
{
    public function show()
    {
        $userID = auth()->user()->id;
        $userName = auth()->user()->name;

        return Inertia::render('Friends', compact('userID', 'userName'));
    }

    public function searchPeople($name)
    {
        $userID = $userID = auth()->user()->id;

        if (!$userID) {
            return response(['error' => 'You\'re not authorized to see that information'], 401 );
        }

        return User::select('id', 'name')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->where('id', '!=', $userID)
            ->take(15)
            ->get();
    }
}
