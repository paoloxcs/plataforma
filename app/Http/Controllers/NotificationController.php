<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index()
	{
		return view('panel.notification.index');
	}
	public function getNotifications(Request $request)
	{
		$notifications = Notification::orderBy('id','desc')->with('type','user.role')->paginate(6);
		return response()->json($notifications);
	}
	public function updateReaded($id)
	{
		$notification = Notification::find($id);
		if ($notification->is_readed == 0) {
			$notification->is_readed = 1;
			$notification->save();
			
		}
		return response()->json([
			'message'=>'Actualización exitosa'
		]);
	}
  
  	public function store(Request $request)
    {
    	Notification::create([
    		'type_id'	=>	$request->type_id,
    		'user_id'	=>	Auth()->user()->id,
    		'body'		=>	$request->body,   		
    	]);
    	
    	return back()->with('msg','¡Solicitud enviada con éxito!');
    }  
}
