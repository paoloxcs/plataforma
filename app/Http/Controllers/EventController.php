<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\TypeEvent;
use Validator;


class EventController extends Controller
{
    //
    public function index()
    {
    	return view('panel.event.index');
    }

    public function getEvents(Request $request)
    {
    	$events=Event::with('rubro','type_event')->orderBy('date_init', 'ASC')->paginate(6);
    	return response()->json($events, 200);
    }

    public function store(Request $request)
    {

    	$validation= Validator::make($request->all(),[
    			'title'=>'required|string',
    			'url_web'=>'required|string',
    			'url_image'=>'required|mimes:jpg,png,jpeg|max:100',
                'date_init' =>'required|string'
    	] );

    	if ($validation->fails()) {
    	     return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
    	}

        $extension=$request->file('url_image')->getClientOriginalExtension();
        $image_name=uniqid().'.'.$extension;

        $request->file('url_image')->move(public_path('/posts/'), $image_name);

        Event::create([
            'title'         =>$request->title,
            'url_web'       =>$request->url_web,
            'url_image'     =>$image_name,
            'type_event_id' =>$request->tipo,
            'rubro_id'      =>$request->rubro,
            'date_init'     =>$request->date_init
        ]);

        return response()->json(['message'=>'Nuevo evento registrado correctamente']);

    }

    public function update(Request $request, $id)
    {
        $validation= Validator::make($request->all(),[
                'title'=>'required|string',
                'url_web'=>'required|string',
                'url_image'=>'mimes:jpg,png,jpeg|max:100',
                'date_init' => 'required|string'

        ] );
        if ($validation->fails()) {
             return response()->json(['errors'=>$validation->errors(),'status'=> 422]);        
        }


        $event=Event::findOrFail($id);
        if($request->file('url_image')){

            if($event->url_image && file_exists(public_path('/posts/'.$event->url_image))){
                unlink(public_path('/posts/'.$event->url_image));
            }

            $extension=$request->file('url_image')->getClientOriginalExtension();
            $image_name=uniqid().'.'.$extension;

            $request->file('url_image')->move(public_path('/posts/'), $image_name);

            $event->url_image=$image_name;

        }

        $event->title=$request->title;
        $event->url_web=$request->url_web;
        $event->type_event_id=$request->tipo;
        $event->rubro_id=$request->rubro;
        $event->date_init = $request->date_init;
        $event->status = $request->status;
        $event->save();

        return response()->json(['message'=>'Registro actualizado correctamente']);

    }

    public function destroy($id)
    {
        $event=Event::findOrFail($id);
        if($event->url_image && file_exists(public_path('/posts/'.$event->url_image))){
            unlink(public_path('/posts/'.$event->url_image));
        }
        $event->delete();
        return response()->json(['message'=>'El registro fue eliminado']);
    }

    public function getTypeEvents()
    {
    	$type_events=TypeEvent::all();
    	return response()->json($type_events,200);
    }
}
