<?php

namespace App\Http\Controllers;

use App\Log;
use App\Record;
use App\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
	//Metodo para listar el historial del usuario
	// parametro id del usuario
    public function index($id)
    {
    	$user = User::find($id);
    	$records = Record::where('user_id','=',$id)->with('gestor','user')->orderBy('id','desc')->get();
        return response()->json($records);
    }

    public function store(Request $request)
    {
    	$validation = \Validator::make($request->all(),[
    		'body'	=>	'required|string'
    	]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()], 422);
        }
    	Record::create([
    		'user_id'	=>	$request->user_id,
    		'gestor_id'	=>	Auth()->user()->id,
    		'body'		=>	$request->body
    	]);
        return response()->json(['message'=>'Registro exitoso'], 201);

    }
    // parametro id del record
    public function destroy($id)
    {
    	$record = Record::find($id);
    	$record->delete();

    	return response()->json(['message'=>'Registro eliminado'], 200);
    }

    public function getRecords($id)
    {
        $records = Record::where('user_id','=',$id)->orderBy('id','desc')->get();

        $html ='';
        if (count($records) > 0) {
            foreach ($records as $index => $record) {
               $html.='
               <tr>
               <td>'.$record->id.'</td>
               <td>'.$record->gestor->fullName().'</td>
               <td>'.$record->body.'</td>
               <td>'.date('d/m/Y g:ia',strtotime($record->created_at)).'</td>
               </tr>
               ';
            }
        }else{
            $html ='Sin resultados';
        }

        return $html;
    }

    public function getLogs()
    {
        $logs = Log::orderBy('id','desc')->with('user.role')->limit(10)->get();
        return response()->json($logs);
        
    }
}
