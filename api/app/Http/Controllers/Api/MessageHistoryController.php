<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageHistory;
use App\Events\MessageHistoryCreated;
use App\Http\Requests\Api\MessageHistory\StoreMessageHistoryRequest;

class MessageHistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user_id;
        $stylistId = $request->stylist_id;

        $messageHistories = MessageHistory::where('user_id', $userId)
            ->where('stylist_id', $stylistId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $messageHistories = $messageHistories->reverse();
        return response()->json($messageHistories);
    }

    public function store(StoreMessageHistoryRequest $request)
    {
        $messageHistory = MessageHistory::create([
            'user_id' => $request->user_id,
            'stylist_id' => $request->stylist_id,
            'body' => $request->body,
            'from_user' => $request->from_user,
        ]);

        event(new MessageHistoryCreated($messageHistory));

        return response()->json($messageHistory);
    }
}
