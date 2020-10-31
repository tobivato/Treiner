<?php

namespace Treiner\Http\Controllers;

use Treiner\Conversation;
use Illuminate\Http\Request;
use Auth;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Conversation::class, 'conversation');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = Auth::user()->conversations();
        if (count($conversations) > 0) {
            return redirect(route('conversations.show', ($conversations->first()->id)));
        } else {
            return redirect()->back();
        }
        return view('conversations.index');
    }

    public function show(Conversation $conversation)
    {
        return view('conversations.show', ['conversation' => $conversation]);
    }
}
