<?php

namespace App\Http\Controllers;
use Session;
use App\Evaluacion;
use App\Cuestionario;
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



class CuestionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuestionario = Cuestionario::orderBy('id','Asc')->paginate(8);
        return view('panel.cuestionario.index',compact('cuestionario'));
        
    }

     public function cuestionario($id)
    {
        $cuestionario = Cuestionario::where('evaluacion_id','=',$id)->orderBy('id','Asc')->paginate(8);
        $evaluacion = Evaluacion::where('id','=',$id)->first();
        return view('panel.cuestionario.index',compact('cuestionario','evaluacion'));
        
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
            'pregunta' => 'required|string'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            
                      
                $cuestionario= new Cuestionario();
                $cuestionario->pregunta = $request->pregunta;

                $cuestionario->evaluacion_id = $request->evaluacion_id;
                
               
                $cuestionario->save();
             
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/evaluacion/cuestionarios/'.$request->evaluacion_id);
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
        $cuestionario= Cuestionario::find($id);
       
        return view('panel.cuestionario.edit',compact('cuestionario'));
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
            'pregunta' => 'required|string'
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $cuestionario= Cuestionario::find($id);
        

        $cuestionario->pregunta = $request->pregunta;
        $cuestionario->save();

        return redirect('panel/evaluacion/cuestionarios/'.$cuestionario->evaluacion_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuestionario= Cuestionario::find($id);

        $cuestionario->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $evaluacions=Evaluacion::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.evaluacion.buscador',compact('evaluacions'));
    }
   
}
