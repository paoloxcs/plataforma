<?php

namespace App\Http\Controllers;
use Session;
use App\Curso;
use App\Clase;
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



class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clases = Clase::orderBy('id','desc')->paginate(8);
        return view('panel.clase.index',compact('clases'));
        
    }

     public function clase($id)
    {
        $clases = Clase::where('curso_id','=',$id)->orderBy('id','asc')->paginate(8);
        $curso = Curso::where('id','=',$id)->first();
        return view('panel.clase.index',compact('clases','curso'));
        
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
            'informacion' => 'required|string',
            'curso_id' => 'required|string',
            

            'estado' => 'required|string',

            'fecha' => 'required|date',
            'time' => 'required',
            'time_exp' => 'required',
            
            'portada' => 'required|mimes:jpg,png,jpeg|max:100'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('portada')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;

            if ($request->file('portada')->move(public_path().'/imgCurso/',$imgnombre)) {
                      
                $clase = new Clase();
                $clase->titulo = $request->titulo;
                $clase->informacion = $request->informacion;
                $clase->url_portada = $imgnombre;

                $clase->curso_id = $request->curso_id;

                $clase->zoom_codigo_url = $request->codigo_zoom;
                $clase->video_codigo = $request->codigo_video;
                $clase->estado = $request->estado;
                $clase->fecha = $request->fecha;
                $clase->time = $request->time;
                $clase->time_exp = $request->time_exp;
                 $clase->slug= create_slug($request->titulo).'-'.uniqid();
               
                $clase->save();
             }   
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/curso/clases/'.$request->curso_id);
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
        $clase = Clase::find($id);
       
        return view('panel.clase.edit',compact('clase'));
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
            'informacion' => 'required|string',
            
            'time' => 'required',
            'time_exp' => 'required',
            'estado' => 'required|string',

            'fecha' => 'required|date'
            
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $clase = Clase::find($id);
        //actualizamos el slug
        if ($request->titulo !=$clase->titulo) {
            $clase->titulo = $request->titulo;
            $clase->slug = create_slug($request->titulo).'-'.uniqid();
        }

         if ($request->file('portada')) {
            $validation = \Validator::make($request->all(),[
                'portada'   =>  'mimes:jpg,png,jpeg|max:100'
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($clase->url_portada && file_exists(public_path().'/imgCurso/'.$clase->url_portada)){
               unlink(public_path().'/imgCurso/'.$clase->url_portada);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('portada')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;
            if ($request->file('portada')->move(public_path().'/imgCurso/',$imgnombre)) {
                $clase->url_portada = $imgnombre;
            }
        }


                $clase->titulo = $request->titulo;
                $clase->informacion = $request->informacion;

                $clase->zoom_codigo_url = $request->codigo_zoom;
                $clase->video_codigo = $request->codigo_video;
                $clase->estado = $request->estado;
                $clase->fecha = $request->fecha;
                $clase->time = $request->time;
                $clase->time_exp = $request->time_exp;
        $clase->save();

        return redirect('panel/curso/clases/'.$clase->curso_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clase = Clase::find($id);

        $clase->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cursos=Curso::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.curso.buscador',compact('cursos'));
    }
   
}
