<?php

namespace App\Http\Controllers;
use Session;

use App\Encuestas_Curso;
use App\Preguntas_Encuestas_Curso;
use Illuminate\Http\Request;




class Preguntas_Encuestas_CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pregunta= Preguntas_Encuestas_Curso::orderBy('id','desc')->paginate(8);
        return view('panel.pregunta_encuesta_curso.index',compact('pregunta'));
        
    }

     public function pregunta_encuesta_curso($id)
    {
        $preguntas= Preguntas_Encuestas_Curso::where('encuesta_id','=',$id)->orderBy('id','desc')->paginate(8);
        $encuesta = Encuestas_Curso::where('id','=',$id)->first();
        return view('panel.pregunta_encuesta_curso.index',compact('preguntas','encuesta'));
        
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
            'pregunta' => 'required|string',
            'encuesta_id' => 'required|string',
            'tipo_respuesta' => 'required|numeric',
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            
                      
                $pregunta= new Preguntas_Encuestas_Curso();
                $pregunta->pregunta = $request->pregunta;
                $pregunta->encuesta_id = $request->encuesta_id;
                $pregunta->descripcion = $request->descripcion;
                $pregunta->tipo_respuesta = $request->tipo_respuesta;
               
                $pregunta->save();
             
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/Encuesta/pregunta_encuesta_curso/'.$request->encuesta_id);
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
        $pregunta= Preguntas_Encuestas_Curso::find($id);
       
        return view('panel.pregunta_encuesta_curso.edit',compact('pregunta'));
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
            'pregunta' => 'required|string',
            'tipo_respuesta' => 'required|numeric',
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $pregunta= Preguntas_Encuestas_Curso::find($id);

        $pregunta->pregunta = $request->pregunta;
        $pregunta->descripcion = $request->descripcion;
        $pregunta->tipo_respuesta = $request->tipo_respuesta;
        $pregunta->save();

        return redirect('panel/Encuesta/pregunta_encuesta_curso/'.$pregunta->encuesta_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pregunta= Preguntas_Encuestas_Curso::find($id);

        $pregunta->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cursos=Encuestas_Curso::where("pregunta",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('pregunta','Asc')->limit(8)->get();

        return view('panel.encuesta.bucador',compact('cursos'));
    }
   
}
