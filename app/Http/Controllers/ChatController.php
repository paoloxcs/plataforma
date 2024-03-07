<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
    	return view('web.profile.chats');
    }
    public function getMessages()
    {
    	$messages = Chat::with('user.role')->get();
    	return response()->json($messages);
    }

    public function store(Request $request)
    {
    	$chat = Chat::create([
    		'user_id' => Auth()->user()->id,
    		'message' => $request->message
    	]);

    	$params = [
    		'user_id' => $chat->user->id,
    		'user' => $chat->user->fullName(),
    		'role' => $chat->user->role->name,
    		'message' => $chat->message
    	];

    	/*event(new MessageEvent($params,'new-message'));*/

    	return response()->json(['message' => 'Message saved success']);



    }
}
