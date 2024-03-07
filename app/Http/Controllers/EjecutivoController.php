<?php

namespace App\Http\Controllers;

use App\Ejecutivo;
use App\User;
use Illuminate\Http\Request;
use Session;

class EjecutivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ejecutivos = Ejecutivo::paginate(10);
        return view('panel.ejecutivo.index',compact('ejecutivos'));
    }

    public function getEjecutivosAll()
    {  
        $ejecutivos = Ejecutivo::orderBy('idejecutivo','desc')->get();
        return response()->json($ejecutivos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.ejecutivo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'nombres'=>'required','apellidos'=>'required'
        // ]);
        //  $ejecutivo = new Ejecutivo();
        //  $ejecutivo->nombres = $request->nombres;
        //  $ejecutivo->apellidos =$request->apellidos;
        //  $ejecutivo->save();
        //  Session::flash('msg','El registro fue guardado con éxito');
        //  return redirect()->route('ejecutivos.index');
        // JHED EJECUTIVO
        if($request->correo != null){
                $this->validate($request,[
                'correo'=>'required',
            ]);

            $user = User::where('email','=',$request->correo)->first();
            if($user){
                $ejecutivo = new Ejecutivo();
                $ejecutivo->idejecutivo = $user->id;
                $ejecutivo->nombres = $user->name;
                $ejecutivo->apellidos =$user->last_name;
                $ejecutivo->save();
       
                Session::flash('msg','El registro fue guardado con éxito');
                return redirect()->route('ejecutivos.index');
            }else{
                Session::flash('msg_warning','El correo no existe, el registro no se guardo con éxito');
                return  redirect()->back();
            } 
        }else{
            $this->validate($request,[
                'nombres'=>'required',
                'apellidos'=>'required'
            ]);

            $ejecutivo = new Ejecutivo();
            $ejecutivo->nombres = $request->nombres;
            $ejecutivo->apellidos =$request->apellidos;
            $ejecutivo->save();

            Session::flash('msg','El registro fue guardado con éxito');
            return redirect()->route('ejecutivos.index');
        }
        // JHED EJECUTIVO

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
        $ejecutivo = Ejecutivo::find($id);

        return view('panel.ejecutivo.edit',compact('ejecutivo'));
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
         // $this->validate($request,[
        //     'nombres'=>'required','apellidos'=>'required'
        // ]);
        // $ejecutivo = Ejecutivo::find($id);
        // $ejecutivo->nombres = $request->nombres;
        // $ejecutivo->apellidos = $request->apellidos;
        // $ejecutivo->save();
        // Session::flash('msg','El registro fue actualizado con éxito');
        // return redirect()->route('ejecutivos.index');
        // JHED EJECUTIVO
        if($request->correo != null){
                $this->validate($request,[
                'correo'=>'required',
            ]);

            $user = User::where('email','=',$request->correo)->first();
            if($user){
                $ejecutivo = Ejecutivo::find($user->id);
                $ejecutivo->idejecutivo = $user->id;
                $ejecutivo->nombres = $user->name;
                $ejecutivo->apellidos =$user->last_name;
                $ejecutivo->save();
    
                Session::flash('msg','El registro fue guardado con éxito');
                return redirect()->route('ejecutivos.index');
            }else{
                Session::flash('msg_warning','El correo no existe, el registro no se guardo con éxito');
                return  redirect()->back();
            } 
        }else{
            $this->validate($request,[
                'nombres'=>'required',
                'apellidos'=>'required'
            ]);
            $user = User::where('name','=',$request->nombres)->where('last_name','=',$request->apellidos)->first();
            if($user){
                $ejecutivo = Ejecutivo::find($id);
                $ejecutivo->idejecutivo = $user->id;
                $ejecutivo->nombres = $user->name;
                $ejecutivo->apellidos =$user->last_name;
                $ejecutivo->save();
            }else{
                $ejecutivo = Ejecutivo::find($id);
                $ejecutivo->nombres = $request->nombres;
                $ejecutivo->apellidos =$request->apellidos;
                $ejecutivo->save();
            }
            Session::flash('msg','El registro fue actualizado con éxito');
            return redirect()->route('ejecutivos.index');
        }
        // JHED EJECUTIVO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ejecutivo = Ejecutivo::find($id);
        $ejecutivo->delete();

        Session::flash('msg','El registro fue eliminado con éxito');

        return redirect()->route('ejecutivos.index');

    }
}
