<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Cliente;
use App\Ejecutivo;
use App\Mail\NewCliente;
use App\Mail\NewSuscriptordeta;
use App\Mail\NewSuscriptorinfo;
use App\Mail\updateCaducidad2;
use App\Mail\updateCaducidad;
use App\Mail\updateSuscriptor;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ClienteController extends Controller
{
        public function index()
        {
            // Retorna la vista para lista los clientes.
            return view('panel.cliente.index');

         


        }

        public function getClientes(Request $request)
        {

          /*   $users=User::get();
        foreach ($users as $user) {
             if ($user->isCliente()) {
               $cliente=Cliente::where('user_id',$user->id)->first();
               if($cliente){
               $client = Cliente::find($cliente->id);
               $client->fecha_registro = date('Y-m-d', strtotime($user->created_at));
               $client->fecha_caducidad = date('Y-m-d', strtotime($user->created_at."+ 1 year"));
               $client->save();
               }
              

             }
            }

            foreach ($users as $user) {
             if ($user->isCliente()) {
               $cliente=Cliente::where('user_id',$user->id)->first();
               if($cliente){
               $client = Cliente::find($cliente->id);
                if ($client->Caducidad()>0) {
                   $client->status= 1;
                 }else{
                   $client->status= 0;
                 }
               $client->save();
               }
              

             }
            }*/
           /* $clients= Cliente::get();
            foreach ($clients as $cliente) {
               if($cliente->fecha_registro==""){
                $cli=Cliente::find($cliente->id);
                $cli->delete();
               }
            }*/

            // Retorna la lista paginada de clientes en formato JSON.
            $clientes = Cliente::with('user','ejecutivo')->orderBy('id','DESC')->paginate(6);
            return response()->json($clientes);
        }

        public function search(Request $request)
        {
            $texto = $request->text;
            // Retorna resultados de busqueda limitada en 6, formato JSON.
            $clientes = Cliente::join('users as u','clientes.user_id','=','u.id')
            ->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
            ->orWhere('u.email','like', '%'.$texto.'%')
            ->with('user','ejecutivo')->select('clientes.*')->limit(6)->get();

            return response()->json($clientes);

        }

        public function store(Request $request)
        {

        	$validation = \Validator::make($request->all(),[
        	    'name'=>'required|string',
                'last_name'=>'required|string',
        	    'email'=>'required|email|unique:users',
        	    'password'=>'required|confirmed|min:6'
        	    ],[
        	      'email.unique'=>'El correo ingresado ya existe!'
        	    ]);
            if($validation->fails()){
                return response()->json(['errors'=>$validation->errors(),'status'=>422]);
            }else{

                //Insetar en la tabla users
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role_id = 5;
                $user->phone_number = $request->phone_number;
                $user->doc_number = $request->doc_number;
                $user->save();

                //Insertar en la tabla clientes
                $cliente = new Cliente();
                $cliente->empresa = $request->empresa;
                $cliente->user_id = $user->id;
                $cliente->medio = $request->medio;
                $cliente->fecha_registro=date('Y-m-d');
                $cliente->fecha_caducidad=date('Y-m-d', strtotime(date('Y-m-d')."+ 1 year"));
                $cliente->save();

                //Vincular cliente con ejecutivo
                $cliente->ejecutivo()->attach($request->ejecutivo);

                //Enviando correo al cliente
                $data=[
                    'name'=> $user->fullName(),
                    'email'=> $user->email,
                    'password'=>$request->password
                ];
               /* Mail::to($user->email)
                ->send(new NewCliente($data));
                create_user_log('Agregó a '.strtoupper($user->fullName()).'('.$user->role->name.')');*/

                return response()->json(['message'=>'Registro exitoso','status'=>200]);
            }
            
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            $validation = \Validator::make($request->all(),[
                'name'=>'required|string',
                'last_name'=>'required|string',
                'email' => 'required|email|unique:users,email,'.$id.',id',
                'caducidad'=>'required|string'
                ],[
                  'email.unique'=>'El correo ingresado ya existe!'
                ]);
            if($validation->fails()){
                return response()->json(['errors'=>$validation->errors(),'status'=>422]);
            }else{
               $user = User::find($id);

               $user->name = $request->name;
               $user->last_name = $request->last_name;
               $user->email = $request->email;
               $user->address = $request->address;
               $user->phone_number = $request->phone_number;
               $user->doc_number = $request->doc_number;
               $user->save();

               //actualizar tabla clientes
               $cliente = Cliente::where('user_id',$id)->first();
               
               //desvincular ejecutivo
               $cliente->ejecutivo()->detach();

               $cliente->empresa = $request->empresa;
               $cliente->medio = $request->medio;
               $cliente->status = $request->status;
               $cliente->fecha_caducidad = $request->caducidad;
               $cliente->save();

               //Vincular con el ejecutivo
               $cliente->ejecutivo()->attach($request->ejecutivo);

               create_user_log('Actualizó los datos de '.strtoupper($user->fullName()).'('.$user->role->name.')');

               return response()->json(['message'=>'Actualización exitosa','status'=>200]); 
            }
        }
        public function frmConvert($id)
        {
            
            $user = User::find($id);
            $ejecutivos = Ejecutivo::all();
            return view('panel.cliente.frmconvert',compact('user','ejecutivos'));
        }
        public function convertStore(Request $request, $id)
        {
            $user = User::find($id);

            $asignacion = Asignacion::where('suscriptor_id','=',$id)->first();

            $cliente = Cliente::create([
                'empresa'   =>  $request->empresa,
                'user_id'   =>  $user->id,
                'medio'     => $request->medio
            ]);

            $cliente->ejecutivo()->attach($request->ejecutivo);


            $user->role_id = 5;
            $user->save();

            $asignacion->is_confirmed = 1;
            $asignacion->save();

            Session::flash('msg','Registro exitoso!');
            return redirect()->route('mybandeja',Auth()->user()->id);
            
        }

        public function getFiltterToClients()
          {
          $ejecutivos = Ejecutivo::get();

          return response()->json(['ejecutivos'=>$ejecutivos]);
           }

        public function applyFilters(Request $request)
            { 
              $status = $request->status;

               

              $clientes = Cliente::where(function($query) use($status){
               


                if($status != 2){

                  $query->where('status', $status);
                }
                
              })
              ->with('user','ejecutivo')->orderBy('id','DESC')->paginate(6);

              return response()->json($clientes);

            }

         public function downloadDataFilter(Request $request)
    {
     $status = $request->status;

               

              $clientes = Cliente::where(function($query) use($status){
               


                if($status != 2){

                  $query->where('status', $status);
                }
                
              })
              ->with('user','ejecutivo')
              ->orderBy('id','DESC')->get();
               


      Excel::create('clientes',function($excel) use($clientes){
        $excel->sheet('clientes',function($sheet) use ($clientes){

          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'N° telf.',
            'Medio',
            'Estado',
            'Ejecutivo',
            'Fecha Registro',
            'Fecha Caducidad'


          ]);

          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });


          // Datos en en archivo excel
          foreach ($clientes as $index => $cliente) {

            $sheet->row($index + 2, [
              $cliente->user->fullName(),
              $cliente->user->email,
              $cliente->user->phone_number,
              $cliente->medio,
              
              $cliente->status == 1 ? 'Activo' : 'Inactivo',
              count($cliente->ejecutivo)>0? $cliente->ejecutivo[0]->nombres . ' '. $cliente->ejecutivo[0]->apellidos:'No Registrado',
              $cliente->fecha_registro,
              $cliente->fecha_caducidad,
            ]);
          }

        });

    })->export('xls');


    }
}
