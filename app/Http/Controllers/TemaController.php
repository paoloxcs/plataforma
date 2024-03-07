<?php

namespace App\Http\Controllers;
use Session;
use App\Tema;
use App\Curso;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temas = Tema::orderBy('id','desc')->paginate(8);

        return view('tema.index',compact('temas'));
    }

     public function tema($id)
    {
        $temas = Tema::where('curso_id','=',$id)->orderBy('id','Asc')->paginate(8);
        $curso = Curso::where('id','=',$id)->first();
      
        return view('panel.tema.index',compact('temas','curso'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
           $validation = \Validator::make($request->all(),[
            'descripcion' => 'required|string'
            ]);
          
                      //guardando en la tabla posts
                $tema = new Tema();
                $tema->curso_id = $request->curso_id;
                $tema->descripcion = $request->descripcion;
                $tema->save();
             


      Session::flash('msg','¡Registro exitoso!');
     return redirect('panel/curso/temas/'.$request->curso_id);
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
      $tema = Tema::find($id);
        return view('panel.tema.edit',compact('tema'));
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
            $validation = \Validator::make($request->all(), [
            'descripcion' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $tema = Tema::find($id);

        $tema->descripcion=$request->descripcion;
        $tema->save();

     Session::flash('msg','¡Registro exitoso!');
     return redirect('panel/curso/temas/'.$request->curso_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $tema = Tema::find($id);

        $tema->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }
   
}
