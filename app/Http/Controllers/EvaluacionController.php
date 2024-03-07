<?php

namespace App\Http\Controllers;
use Session;
use App\Curso;
use App\Evaluacion;
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



class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluacion = Evaluacion::orderBy('id','desc')->paginate(8);
        return view('panel.evaluacion.index',compact('evaluacion'));
        
    }

     public function evaluacion($id)
    {
        $evaluacion = Evaluacion::where('curso_id','=',$id)->orderBy('id','desc')->paginate(8);
        $curso = Curso::where('id','=',$id)->first();
        return view('panel.evaluacion.index',compact('evaluacion','curso'));
        
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
            'titulo' => 'required|string',
            'curso_id' => 'required|string',
            'fecha' => 'required|date'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            
                      
                $evaluacion= new Evaluacion();
                $evaluacion->titulo = $request->titulo;

                $evaluacion->curso_id = $request->curso_id;
                $evaluacion->fecha = $request->fecha;
                 $evaluacion->slug= create_slug($request->titulo).'-'.uniqid();
               
                $evaluacion->save();
             
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/curso/evaluaciones/'.$request->curso_id);
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
        $evaluacion= Evaluacion::find($id);
       
        return view('panel.evaluacion.edit',compact('evaluacion'));
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
            'titulo' => 'required|string',
            'fecha' => 'required|date'
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $evaluacion= Evaluacion::find($id);
        //actualizamos el slug
        if ($request->titulo !=$evaluacion->titulo) {
            $evaluacion->titulo = $request->titulo;
            $evaluacion->slug = create_slug($request->titulo).'-'.uniqid();
        }

        $evaluacion->fecha = $request->fecha;
        $evaluacion->save();

        return redirect('panel/curso/evaluaciones/'.$evaluacion->curso_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluacion= Evaluacion::find($id);

        $evaluacion->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cursos=Curso::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.curso.buscador',compact('cursos'));
    }
   
}
