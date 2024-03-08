<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\FriendsInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $userID = Auth::id();

        if (!$userID) {
            return response(['error' => 'You\'re not authorized to see that information'], 401);
        }

        $users = User::select('id', 'name')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->where('id', '!=', $userID)
            ->with(['isFriend', 'isInvited', 'theySentInvite'])
            ->take(15)
            ->get()
            ->map(function ($user) {
                $status = '';
                if ($user->isFriend) {
                    $status = 'Friend';
                } else if ($user->isInvited) {
                    $status = 'Invited';
                } else if ($user->theySentInvite) {
                    $status = 'Accept invite';
                }
                unset($user->isFriend);
                unset($user->isInvited);
                unset($user->theySentInvite);
                $user['status'] = $status;

                return $user;
            });

        return $users;
    }

    public function addFriend($id)
    {
        $userID = auth()->user()->id;
        $friendID = User::find($id)->id;

        // validation
        if (!$friendID) {
            return response(['message' => 'User not found'], 404);
        }

        // check if invite has already been sent
        if (FriendsInvitation::where(['sender_user_id' => $userID, 'receiver_user_id' => $friendID,])->count()) {
            return response(['message' => 'You\'ve already sent an invite to this user'], 422);
        }

        // check if we're already friends
        if (Friends::where(['user_id' => $userID, 'friend_id' => $friendID])->count()) {
            return response(['message' => 'You\'re already friends with this user'], 422);
        }

        FriendsInvitation::create([
            'sender_user_id' => $userID,
            'receiver_user_id' => $friendID,
        ]);

        return response(['message' => 'Friend added'], 200);
    }
}
