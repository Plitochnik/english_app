<?php

namespace App\Http\Controllers;

use App\Events\FriendshipInviteEvent;
use App\Models\Chats;
use App\Models\Friends;
use App\Models\FriendsInvitation;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FriendsController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        return Friends::where('user_id', $userID)
            ->with(['users' => function ($query) {
                $query->select('id', 'name', 'profile_photo_path');
            }])
            ->get()
            ->map(function ($friend) {
                $friend['id'] = $friend->users->id;
                $friend['name'] = $friend->users->name;
                $friend['profile_photo_path'] = $friend->users->profile_photo_path;
                // we need this for the FE search
                $friend['hide'] = false;
                $friend['new_messages'] = (new ChatController())->getCountNewMessages($friend['id']);

                unset($friend->users);
                return $friend;
            });
    }

    public function showPage()
    {
        return Inertia::render('Friends');
    }

    public function addFriend($id)
    {
        $userID = auth()->user()->id;
        $friend = User::find($id);

        $validation = $this->validateFriends($userID, $friend->id);

        if (isset($validation['error'])) {
            return response(['message' => $validation['error']], 422);
        }

        // show the message to the invited user
        broadcast(new FriendshipInviteEvent($friend))->toOthers();

        FriendsInvitation::updateOrCreate([
            'sender_user_id' => $userID,
            'receiver_user_id' => $friend->id,
        ]);

        return response(['message' => 'Friend added'], 200);
    }

    public function delete($id)
    {
        $userID = auth()->user()->id;

        Friends::where('user_id', $userID)->where('friend_id', $id)->delete();
        Friends::where('friend_id', $userID)->where('user_id', $id)->delete();

        return $this->index();
    }

    public function validateFriends($userID, $theirID)
    {
        // validation
        if (!$userID || !$theirID) {
            return ['error' => 'User not found'];
        }

        // we can't add ourselves
        if ($theirID === $userID) {
            return ['error' => 'You can\'t be friends with yourself, unless you got a dementia'];
        }

        // check if invite has already been sent
        if (FriendsInvitation::where(['sender_user_id' => $userID, 'receiver_user_id' => $theirID])->count()) {
            return ['error' => 'You\'ve already sent an invite to this user'];
        }

        // check if we're already friends
        if (Friends::where(['user_id' => $userID, 'friend_id' => $theirID])->count()) {
            return ['error' => 'You\'re already friends with this user'];
        }
    }

    public function getInvitesForMyself()
    {
        $userID = auth()->user()->id;

        return FriendsInvitation::where('receiver_user_id', $userID)
            ->with('sender')
            ->get()
            ->map(function ($invite) {
                $invite['id'] = $invite->sender->id;
                $invite['sender_name'] = $invite->sender->name;
                $invite['sender_photo'] = $invite->sender->profile_photo_path;
                // we need this for the FE loading
                $invite['loading'] = false;

                unset($invite->sender);
                return $invite;
            });
    }

    public function acceptFriendshipInvite($newFriendID)
    {
        try {
            DB::beginTransaction();

            $userID = auth()->user()->id;

            $validation = $this->validateFriends($userID, $newFriendID);

            if (isset($validation['error'])) {
                return response(['message' => $validation['error']], 422);
            }

            // make a friend for both users
            Friends::insert([
                ['user_id' => $newFriendID, 'friend_id' => auth()->user()->id],
                ['user_id' => auth()->user()->id, 'friend_id' => $newFriendID],
            ]);

            // delete an invite
            FriendsInvitation::where([
                'sender_user_id' => $newFriendID,
                'receiver_user_id' => auth()->user()->id,
            ])->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return $this->getInvitesForMyself();
    }

    public function acceptAllInvitations()
    {
        $userID = auth()->user()->id;

        $invitations = FriendsInvitation::where('receiver_user_id', $userID)->get()->toArray();

        foreach ($invitations as $invitation) {
            $this->acceptFriendshipInvite($invitation['sender_user_id']);
        }

        return $this->getInvitesForMyself();
    }

    public function searchPeople($name)
    {
        $userID = Auth::id();

        if (!$userID) {
            return response(['error' => 'You\'re not authorized to see that information'], 401);
        }

        $users = User::select('id', 'name', 'profile_photo_path')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->where('id', '!=', $userID)
            ->with(['isFriend', 'isInvited', 'theySentInvite'])
            ->whereDoesntHave('isFriend')
            ->take(15)
            ->get()
            ->map(function ($user) {
                $status = '';
                if ($user->isInvited) {
                    $status = 'Invited';
                } else if ($user->theySentInvite) {
                    $status = 'Accept invitation';
                }
                unset($user->isInvited);
                unset($user->theySentInvite);
                unset($user->isFriend);
                $user['status'] = $status;
                $user['loading'] = false;

                return $user;
            });

        return $users;
    }
}
