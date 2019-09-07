<?php

namespace App\Http\Controllers;

use App\Events\NewMessageAdded;
use App\Messages;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Messages::all();

        return view('chat')->withMessages($messages);
    }

    public function addMessage(Request $request)
    {
        $message = Messages::create(['text' => $request->message, 'user_id' => 1]);

        event(new NewMessageAdded($message));

        return response()->json($message);
    }
}
