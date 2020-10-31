<?php

namespace Treiner\Http\Controllers\Api;

use Illuminate\Http\Request;
use Treiner\Http\Controllers\Controller;
use Treiner\Message;
use Auth;
use Treiner\Conversation;
use Treiner\Http\Resources\Message as MessageResource;
use Treiner\User;

class MessageController extends Controller
{
    public function getUnreadMessages(Conversation $conversation)
    {
        $messages = Auth::user()->messages()->where('to_id', Auth::id())->where('conversation_id', $conversation->id)->where('seen', false);
        foreach ($messages as $message) {
            if ($message->to_id == Auth::id()) {
                $message->seen = true;
                $message->save();
            }
        }
        return MessageResource::collection($messages);
    }

    public function getAllMessages(Conversation $conversation)
    {
        $messages = Auth::user()->messages()->where('conversation_id', $conversation->id)->sortBy('created_at');
        foreach ($messages as $message) {
            if ($message->to_id == Auth::id()) {
                $message->seen = true;
                $message->save;
            }
        }
        return MessageResource::collection($messages);
    }

    public function store(Conversation $conversation, Request $request)
    {
        $request->validate([
            'to_id' => 'integer|required',
            'content' => 'string|required|max:10000',
        ]);

        if ($conversation->from != Auth::user() && $conversation->to != Auth::user()) {
            abort(403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'to_id' => $request->input('to_id'),
            'from_id' => Auth::user()->id,
            'content' => $request->input('content'),
            'seen' => false
        ]);
        return MessageResource::collection(collect([$message]));
    }
}
