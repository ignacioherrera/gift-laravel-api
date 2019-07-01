<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; 
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Message;
use App\Event;

class ChatController extends Controller
{
    public function fetchMessages($id){

        $messages = Message::where('event_id', $id)->get();
    }

    public function sendMessage($id){
        $input = request()->all();
        $input['event_id'] = $id;
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $message = Message::create($input);
        $user = Auth::user();
        $event = Event::find($id);
        broadcast(new MessageSent($user, $event, $message));
        return response()->json(['success'=>$message], 200);

    }
}
