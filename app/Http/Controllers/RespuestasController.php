<?php

namespace App\Http\Controllers;
use Session;
use App\Cuestionario;
use App\Respuestas;
use Illuminate\Http\Request;

function create_slug($string, $replace = array(), $delimiter = '-'){
    // Validacion de acotejamiento utf-8
    if (!extension_loaded('iconv')) {
      throw new Exception('iconv module not loaded');
    }
    // Obtener cotejamiento por defecto y pasar a UTF-8
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    if (!empty($replace)) {
      $clean = str_replace((array) $replace, ' ', $clean);
    }
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    // Revert back to the old locale
    setlocale(LC_ALL, $oldLocale);
    //Concatenando con el time
    return $clean;
}



class RespuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respuestas = Respuestas::orderBy('id','Asc')->paginate(8);
        return view('panel.respuestas.index',compact('respuestas'));
        
    }

     public function respuestas($id)
    {
        $respuestas = Respuestas::where('cuestionario_id','=',$id)->orderBy('id','Asc')->paginate(8);
        $cuestionario = Cuestionario::where('id','=',$id)->first();
        return view('panel.respuestas.index',compact('respuestas','cuestionario'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
           $validation = \Validator::make($request->all(),[
            'respuesta' => 'required|string',
            'cuestionario_id' => 'required|string',
            'correcto' => 'required|string'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            
                      
                $respuestas= new Respuestas();
                $respuestas->respuesta = $request->respuesta;

                $respuestas->cuestionario_id = $request->cuestionario_id;
                $respuestas->correcto = $request->correcto;
               
                $respuestas->save();
             
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/cuestionario/respuestas/'.$request->cuestionario_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $respuestas= Respuestas::find($id);
       
        return view('panel.respuestas.edit',compact('respuestas'));
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
            'respuesta' => 'required|string',
            'correcto' => 'required|string'
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $respuestas= Respuestas::find($id);
        
        $respuestas->respuesta = $request->respuesta;
        $respuestas->correcto = $request->correcto;
        $respuestas->save();

        return redirect('panel/cuestionario/respuestas/'.$respuestas->cuestionario_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $respuestas= Respuestas::find($id);

        $respuestas->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cuestionarios=Cuestionario::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.cuestionario.buscador',compact('cuestionarios'));
    }
   
}
