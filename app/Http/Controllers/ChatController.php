<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $userID = auth()->user()->id;
        $recipients = $request->toArray();
        $chatMembers = [$userID];

        // check if they chatted yet
        foreach ($recipients as $recipient) {
            $chatMembers[] = $recipient;
        }

        sort($chatMembers);
        $chatMembers = implode('-', $chatMembers);

        try {
            DB::beginTransaction();
            $isNewChat = Chats::firstOrCreate(['users' => $chatMembers]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return $chatMembers;
    }
}
