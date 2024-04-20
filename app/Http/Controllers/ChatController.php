<?php

namespace App\Http\Controllers;

use App\Events\PrivateMessages;
use App\Models\Chats;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $userID = auth()->user()->id;
        $chatMembers = [$userID];
        $recipients = User::select('id', 'name', 'email')
            ->whereIn('id', $request->toArray())
            ->where('id', '!=', $userID)
            ->get();

        // check if they chatted yet
        foreach ($recipients as $recipient) {
            $chatMembers[] = $recipient['id'];
        }

        sort($chatMembers);
        $chatMembers = implode('-', $chatMembers);

        // create chat if we haven't already
        try {
            DB::beginTransaction();

            $chatID = Chats::firstOrCreate(['users' => $chatMembers])->id;

            // set all messages as seen
            Messages::where('chat_id', $chatID)->update(['is_seen' => 1]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return [
            'messages' => $this->getMessages($chatID),
            'recipients' => $recipients,
        ];
    }

    public function getCountNewMessages($friendID)
    {
        $userID = auth()->user()->id;
        $chatMembers = [$userID, $friendID];
        sort($chatMembers);

        $chatID = Chats::where('users', implode('-', $chatMembers))->value('id');

        return Messages::where('chat_id', $chatID)->where('is_seen', 0)->count();
    }

    private function getMessages($chatID): array
    {
        return Messages::select('title', 'chat_id', 'user_id', 'created_at')
            ->where('chat_id', $chatID)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function sendMessage(Request $request)
    {
        $sender = auth()->user();
        $chatID = $this->getChatID($request['recipients']);
        $message = $request['message']['title'];

        if (!$message) {
            return response(['message' => 'You can\'t send an empty text'], 500);
        }

        if (strlen($message) > 1000) {
            return response(['message' => 'Messages have 1000 characters limit. Your message is too long'], 500);
        }

        $newMessage = Messages::create([
            'title' => $request['message']['title'],
            'chat_id' => $chatID,
            'user_id' => $sender->id,
        ]);

        // dispatch message to all recipients
        foreach ($request['recipients'] as $recipient) {
             broadcast(new PrivateMessages(User::find($recipient['id']), $sender, $newMessage))->toOthers();
        }

        return true;
    }

    public function setMessageAsSeen(Request $request)
    {
        return Chats::where('id', $request['id'])->update(['is_seen' => 1]);
//        return true;
    }

    private function getChatID($recipients)
    {
        $userID = auth()->user()->id;
        $recipientIDs = array_column($recipients, 'id');

        $chatMembers = array_merge($recipientIDs, [$userID]);
        sort($chatMembers);
        $chatMembers = implode('-', $chatMembers);

        return Chats::firstOrCreate(['users' => $chatMembers])->id;
    }
}
