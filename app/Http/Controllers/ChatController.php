<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Messages;
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

        // create chat if we haven't already
        try {
            DB::beginTransaction();

            $chatID = Chats::firstOrCreate(['users' => $chatMembers])->id;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return $this->getMessages($chatID);
    }

    private function getMessages($chatID): array
    {
        return Messages::select('title', 'chat_id', 'user_id', 'created_at')
            ->where('chat_id', $chatID)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }
}
