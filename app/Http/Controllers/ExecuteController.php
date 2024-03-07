<?php

namespace App\Http\Controllers;

use App\Autor;
use App\Cliente;
use App\Colaboradores;
use App\Curso;
use App\Ejecutivo;
use App\Plan;
use App\Post;
use App\Publicacion;
use App\Rubro;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExecuteController extends Controller
{
    public function index()
    {
        $rubros = Rubro::where('estado', 1)->get();

        $rubro = Rubro::where('estado', 1)->inrandomOrder()->first();
    
        $colaboradores = Colaboradores::where('estado', 1)->where('prioridad', 1)->orderby('orden', 'asc')->get();
    
        $colaboradores = $colaboradores->unique('nombre');
    
        $autores = Autor::with('posts.subcategoria.categoria.rubro')->where('principal', 1)->get();
    
        $autores = $autores->unique('idautor');
    
        $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();
    
        $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();
    
    
        //MENU 
    
        $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();
    
        $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();
    
        $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();
    
        $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
          ->limit(2)->get();
    
        $videosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
          ->limit(2)->get();
    
        $videosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
          ->limit(2)->get();
    
        $videosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
          ->limit(2)->get();
    
        $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
          ->limit(2)->get();
    
        $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
          ->limit(2)->get();
    
        $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
          ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
          ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
          ->select('*', 'posts.slug as pslug')
          ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
          ->limit(2)->get();
    
    
        $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();
    
        $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();
    
        $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
        $rubroSlug = "";
    
       
        
        // $clientes = Cliente::where('clientes_ejecutivos', function ($query) {
        //     $query->where('ejecutivo_id', Auth()->user()->id);
        // })->with('user','ejecutivo')->orderBy('id','DESC')->get();
 

        // <td>${cliente.user.id}</td>
        //                         <td>${cliente.user.name} ${cliente.user.last_name}</td>
        //                         <td>${cliente.user.email}</td>
        //                         <td>${dateFormat(cliente.fecha_registro)}</td>
        //                         <td>${dateFormat(cliente.fecha_caducidad)}</td>
        //                         <td>${cliente.ejecutivo[0].nombres} ${cliente.ejecutivo[0].apellidos}</td>
        //                         <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
        //                         <td>
        //                             <button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
        //                                                   <i class="fa fa-plus" aria-hidden="true"></i> Curso
        //                                         </button>
        //                             <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
        //                             <button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
        //                         </td>
//  dd($clientes);
        //MENU
       if(Auth()->user()->ejecutivo){
        return view('web.execute.index', compact('rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
       }else{ 
        return redirect()->route('home'); 
       }
        
  
  }

  public function getClientes(Request $request)
  { 
      // Retorna la lista paginada de clientes en formato JSON.
    //   $clientes = Cliente::with('user','ejecutivo')->orderBy('id','DESC')->paginate(6);

    $clientes = DB::table('clientes_ejecutivos')
    ->join('clientes as c', 'c.id', '=', 'clientes_ejecutivos.cliente_id')
    ->join('users as u', 'u.id', '=', 'c.user_id')
    ->join('ejecutivos as e', 'e.idejecutivo', '=', 'clientes_ejecutivos.ejecutivo_id')
    ->select('u.id as user_id', 'u.name as user_name','u.last_name as user_last_name','u.email as user_email','u.phone_number as user_phone_number','u.doc_number as user_doc_number','u.address as user_address',
    'c.fecha_registro as fecha_registro','c.fecha_caducidad as fecha_caducidad','c.status as status','c.empresa as empresa','c.medio as medio',
    'e.nombres as ejecutivo_nombres','e.apellidos as ejecutivo_apellidos','e.idejecutivo as idejecutivo')
    ->where('e.idejecutivo', '=', Auth()->user()->id)
    ->orderBy('c.id','DESC')
    ->paginate(6);
    
      return response()->json($clientes);
  }
  public function search(Request $request)
  {
      $texto = $request->text;
      // Retorna resultados de busqueda limitada en 6, formato JSON.
    //   $clientes = Cliente::join('users as u','clientes.user_id','=','u.id')
    //   ->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
    //   ->orWhere('u.email','like', '%'.$texto.'%')
    //   ->with('user','ejecutivo')->select('clientes.*')->limit(6)->get();

    $clientes = DB::table('clientes_ejecutivos')
    ->join('clientes as c', 'c.id', '=', 'clientes_ejecutivos.cliente_id')
    ->join('users as u', 'u.id', '=', 'c.user_id')
    ->join('ejecutivos as e', 'e.idejecutivo', '=', 'clientes_ejecutivos.ejecutivo_id')
    ->select('u.id as user_id', 'u.name as user_name','u.last_name as user_last_name','u.email as user_email','u.phone_number as user_phone_number','u.doc_number as user_doc_number','u.address as user_address',
    'c.fecha_registro as fecha_registro','c.fecha_caducidad as fecha_caducidad','c.status as status','c.empresa as empresa','c.medio as medio',
    'e.nombres as ejecutivo_nombres','e.apellidos as ejecutivo_apellidos','e.idejecutivo as idejecutivo')
    ->where('e.idejecutivo', '=', Auth()->user()->id)
    ->where(function ($query) use ($texto){
        $query->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
              ->orWhere('u.email','like', '%'.$texto.'%');
    }) 
    ->orderBy('c.id','DESC')
    ->limit(6)->get();

      return response()->json($clientes);

  }

    public function getEjecutivosAll()
    {  
        // $ejecutivos = Ejecutivo::orderBy('idejecutivo','desc')->get();
        $ejecutivos = Ejecutivo::where('idejecutivo','=',Auth()->user()->id)->orderBy('idejecutivo','desc')->first();
        return response()->json($ejecutivos);
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
            // $cliente->ejecutivo()->attach($request->ejecutivo);
            $cliente->ejecutivo()->attach($request->idejecutivo);

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
        //    $cliente->ejecutivo()->attach($request->ejecutivo);
            $cliente->ejecutivo()->attach($request->idejecutivo);

            create_user_log('Actualizó los datos de '.strtoupper($user->fullName()).'('.$user->role->name.')');

            return response()->json(['message'=>'Actualización exitosa','status'=>200]); 
        }
    }


    public function destroyByAjax($id) // Elimina un usuario mediante peticion ajax
    {
        $user = User::find($id);
        if ($user->url_foto != null && file_exists(public_path().'/fotousers/'.$user->url_foto)) {
            unlink(public_path().'/fotousers/'.$user->url_foto);
        }
        create_user_log('Eliminó a '.$user->fullName().' ('.$user->role->name.')');
        
        $user->delete();
        return response()->json(['message'=>'El registro fue eliminado'], 200);
    }

    public function applyFilters(Request $request)
    { 
      $status = $request->status;

      $clientes = DB::table('clientes_ejecutivos')
      ->join('clientes as c', 'c.id', '=', 'clientes_ejecutivos.cliente_id')
      ->join('users as u', 'u.id', '=', 'c.user_id')
      ->join('ejecutivos as e', 'e.idejecutivo', '=', 'clientes_ejecutivos.ejecutivo_id')
      ->select('u.id as user_id', 'u.name as user_name','u.last_name as user_last_name','u.email as user_email','u.phone_number as user_phone_number','u.doc_number as user_doc_number','u.address as user_address',
      'c.fecha_registro as fecha_registro','c.fecha_caducidad as fecha_caducidad','c.status as status','c.empresa as empresa','c.medio as medio',
      'e.nombres as ejecutivo_nombres','e.apellidos as ejecutivo_apellidos','e.idejecutivo as idejecutivo')
      ->where('e.idejecutivo', '=', Auth()->user()->id)
      ->where(function($query) use($status){
        if($status != 2){
          $query->where('c.status', $status);
        }        
      })
      ->orderBy('c.id','DESC')
      ->paginate(6);

      // $clientes = Cliente::where(function($query) use($status){
      //   if($status != 2){
      //     $query->where('status', $status);
      //   }        
      // })
      // ->with('user','ejecutivo')->orderBy('id','DESC')->paginate(6);

      return response()->json($clientes);

    }

    public function downloadDataFilter(Request $request)
    {
      $status = $request->status;
  
      // $clientes = Cliente::where(function($query) use($status){               
      //     if($status != 2){
      //       $query->where('status', $status);
      //     }                
      // })->with('user','ejecutivo')->orderBy('id','DESC')->get();
                
      $clientes = DB::table('clientes_ejecutivos')
      ->join('clientes as c', 'c.id', '=', 'clientes_ejecutivos.cliente_id')
      ->join('users as u', 'u.id', '=', 'c.user_id')
      ->join('ejecutivos as e', 'e.idejecutivo', '=', 'clientes_ejecutivos.ejecutivo_id')
      ->select('u.id as user_id', 'u.name as user_name','u.last_name as user_last_name','u.email as user_email','u.phone_number as user_phone_number','u.doc_number as user_doc_number','u.address as user_address',
      'c.fecha_registro as fecha_registro','c.fecha_caducidad as fecha_caducidad','c.status as status','c.empresa as empresa','c.medio as medio',
      'e.nombres as ejecutivo_nombres','e.apellidos as ejecutivo_apellidos','e.idejecutivo as idejecutivo')
      ->where('e.idejecutivo', '=', Auth()->user()->id)  
      ->where(function($query) use($status){          
        if($status != 2){
          $query->where('status', $status);
        }                
      })->orderBy('c.id','DESC')->get();

        Excel::create('excel_data', function($excel) use($clientes){
          $excel->sheet('excel_data', function($sheet) use ($clientes){

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
                $cliente->user_name.' '.$cliente->user_last_name,
                $cliente->user_email,
                $cliente->user_phone_number,
                $cliente->medio, 
                $cliente->status == 1 ? 'Activo' : 'Inactivo', 
                count($cliente->idejecutivo)>0? $cliente->ejecutivo_nombres . ' '. $cliente->ejecutivo_apellidos:'No Registrado',
                $cliente->fecha_registro,
                $cliente->fecha_caducidad,
              ]);
            }

          });

      })->export('xls');


    }

}


