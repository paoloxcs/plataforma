<?php

namespace App\Http\Controllers;
use Session;
use App\Curso;
use DB;
use App\Encuestas_Curso;
use App\Preguntas_Encuestas_Curso;
use App\Respuestas_Preguntas_Curso;
use Illuminate\Http\Request;



class Encuesta_cursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function encuestas()
    {
        $encuestas = Encuestas_Curso::get();
        $preguntas=Preguntas_Encuestas_Curso::get();
        $respuestas=Respuestas_Preguntas_Curso::get();

        // $encuestasu=DB::table('cursos as c')
        // ->join('encuestas_curso as e','c.id','=','e.curso_id')
        // ->join('preguntas_encuestas_curso as pe','e.id','=','pe.encuesta_id')
        // ->join('respuestas_preguntas_curso as rp','pe.id','=','rp.pregunta_id')
        // ->join('users as u','rp.user_id','=','u.id')->distinct('rp.user_id','e.id')
        // // ->select('e.titulo','c.titulo as tituloc','u.name','u.last_name','u.phone_number','u.email','u.id as user_id','e.id as encuesta_id')
        //     ->select('rp.id', 'e.titulo', 'c.titulo as tituloc', 'u.name', 'u.last_name', 'u.phone_number', 'u.email', 'u.id as user_id', 'e.id as encuesta_id')
        // ->orderBy('rp.id','desc')->paginate(6);

      $encuestasu = DB::table('cursos as c')
        ->join('encuestas_curso as e', 'c.id', '=', 'e.curso_id')
        ->join('preguntas_encuestas_curso as pe', 'e.id', '=', 'pe.encuesta_id')
        ->join('respuestas_preguntas_curso as rp', 'pe.id', '=', 'rp.pregunta_id')
        ->join('users as u', 'rp.user_id', '=', 'u.id')
        ->distinct('rp.user_id', 'e.id') 
        ->select('e.titulo', 'c.titulo as tituloc', 'u.name', 'u.last_name', 'u.phone_number', 'u.email', 'u.id as user_id', 'e.id as encuesta_id','rp.created_at as time_start')
        ->orderBy('rp.created_at', 'desc')
        ->paginate(6);

        return view('panel.encuestasusers.index',compact('encuestas','preguntas','respuestas','encuestasu'));
        
    }
    public function encuestasbuscador(Request $request)
    {
        $encuestas = Encuestas_Curso::get();
        $preguntas=Preguntas_Encuestas_Curso::get();
        $respuestas=Respuestas_Preguntas_Curso::get();

          $encuestasu=DB::table('cursos as c')
        ->join('encuestas_curso as e','c.id','=','e.curso_id')
        ->join('preguntas_encuestas_curso as pe','e.id','=','pe.encuesta_id')
        ->join('respuestas_preguntas_curso as rp','pe.id','=','rp.pregunta_id')
        ->join('users as u','rp.user_id','=','u.id')->distinct('rp.user_id','e.id')
        ->where("e.titulo",'like',"%".$request->texto."%")
        ->orWhere("c.titulo",'like',"%".$request->texto."%")
        ->orWhere("u.name",'like',"%".$request->texto."%")
        ->orWhere("u.last_name",'like',"%".$request->texto."%")
        ->orWhere("u.phone_number",'like',"%".$request->texto."%")
        ->orWhere("u.email",'like',"%".$request->texto."%")
        ->select('e.titulo','c.titulo as tituloc','u.name','u.last_name','u.phone_number','u.email','u.id as user_id','e.id as encuesta_id')->limit(6)->get();

        return view('panel.encuestasusers.buscador',compact('encuestasu','encuestas','preguntas','respuestas'));

    }


     public function encuesta_curso($id)
    {
        $encuesta = Encuestas_Curso::where('curso_id','=',$id)->orderBy('id','desc')->paginate(8);
        $curso = Curso::where('id','=',$id)->first();
        return view('panel.encuestacurso.index',compact('encuesta','curso'));
        
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
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            
                      
                $encuesta= new Encuestas_Curso();
                $encuesta->titulo = $request->titulo;
                $encuesta->curso_id = $request->curso_id;
                $encuesta->descripcion = $request->descripcion;
               
                $encuesta->save();
             
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/curso/encuesta_curso/'.$request->curso_id);
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
        $encuesta= Encuestas_Curso::find($id);
       
        return view('panel.encuestacurso.edit',compact('encuesta'));
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
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $encuesta= Encuestas_Curso::find($id);

        $encuesta->titulo = $request->titulo;
        $encuesta->descripcion = $request->descripcion;
        $encuesta->save();

        return redirect('panel/curso/encuesta_curso/'.$encuesta->curso_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $encuesta= Encuestas_Curso::find($id);

        $encuesta->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cursos=Curso::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.curso.bucador',compact('cursos'));
    }
   
}
