<?php

namespace App\Http\Controllers;
use Session;
use App\Colaboradores;
use App\Rubro;
use Illuminate\Http\Request;




class ColaboradoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaboradores = Colaboradores::orderBy('id','desc')->paginate(8);
         $rubros = Rubro::orderBy('nombrerubro','asc')->get();

        if(!\Auth::guest()) {
            if(Auth()->user()->isAdmin() or Auth()->user()->isContentManager()){
              return view('panel.colaborador.index',compact('colaboradores','rubros'));
            }
            else{
                return back()->with('');
            }
        }
       
     
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
            $rubro=Rubro::where('idrubro',$request->rubro_id)->first();

           $validation = \Validator::make($request->all(),[
            'nombre' => 'required|string',
            'url_logo' => 'required|mimes:jpg,png,jpeg|max:100',
            'url_logo_w' => 'required|mimes:jpg,png,jpeg|max:100',
            'rubro_id' => 'required|numeric',
            'estado' => 'required|numeric',
            'prioridad' => 'required|numeric',
            'orden' => 'required|numeric|unique:colaboradores,orden,NULL,id,rubro_id,'.$rubro->idrubro,
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('url_logo')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;


            $extension1 =$request->file('url_logo_w')->getClientOriginalExtension();
            $imgnombre1= uniqid().'.'.$extension1;

             

            if ($request->file('url_logo')->move(public_path().'/imgColaboradores/',$imgnombre)) {

                if ($request->file('url_logo_w')->move(public_path().'/imgColaboradores/',$imgnombre1)) {
                   
                $colaborador = new Colaboradores();
                $colaborador->nombre = $request->nombre;
                $colaborador->url_logo = $imgnombre;
                $colaborador->url_logo_w = $imgnombre;
                $colaborador->rubro_id = $request->rubro_id;
                $colaborador->orden = $request->orden;
                $colaborador->prioridad = $request->prioridad;
                $colaborador->estado = $request->estado;
                $colaborador->descripcion = $request->descripcion;


                $colaborador->save();
                }

             }   
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect()->route('colaboradores');
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
        $colaborador = Colaboradores::find($id);
        $rubros = Rubro::orderBy('nombrerubro','asc')->get();
        return view('panel.colaborador.edit',compact('colaborador','rubros'));
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
       $colaborador = Colaboradores::find($id); 

         $rubro=Rubro::where('idrubro',$colaborador->rubro_id)->first();

        $validation = \Validator::make($request->all(),[
            'nombre' => 'required|string',
            'rubro_id' => 'required|numeric',
            
            'estado' => 'required|numeric',
            'prioridad' => 'required|numeric',
            'orden' => 'required|numeric|unique:colaboradores,orden,'.$colaborador->id.',id,rubro_id,'.$rubro->idrubro,
           
            
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        
       

         if ($request->file('url_logo')) {
            $validation = \Validator::make($request->all(),[
            'url_logo' => 'required|mimes:jpg,png,jpeg|max:100',
           
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($colaborador->url_logo && file_exists(public_path().'/imgColaboradores/'.$colaborador->url_logo)){
               unlink(public_path().'/imgColaboradores/'.$colaborador->url_logo);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('url_logo')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;
            if ($request->file('url_logo')->move(public_path().'/imgColaboradores/',$imgnombre)) {
                $colaborador->url_logo = $imgnombre;
            }
        }

        if ($request->file('url_logo_w')) {
            $validation = \Validator::make($request->all(),[
            'url_logo_w' => 'required|mimes:jpg,png,jpeg|max:100',
           
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($colaborador->url_logo_w && file_exists(public_path().'/imgColaboradores/'.$colaborador->url_logo_w)){
               unlink(public_path().'/imgColaboradores/'.$colaborador->url_logo_w);
            }
            //Recuperando la extension de la imagen
            $extension1 =$request->file('url_logo_w')->getClientOriginalExtension();
            $imgnombre1= uniqid().'.'.$extension1;
            if ($request->file('url_logo_w')->move(public_path().'/imgColaboradores/',$imgnombre1)) {
                $colaborador->url_logo_w = $imgnombre1;
            }
        }


       
        $colaborador->nombre = $request->nombre;
        $colaborador->rubro_id = $request->rubro_id;
        $colaborador->orden = $request->orden;
        $colaborador->prioridad = $request->prioridad;
        $colaborador->estado = $request->estado;
        $colaborador->descripcion = $request->descripcion;
             
      
        $colaborador->save();

        return redirect()->route('colaboradores');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colaborador = Colaboradores::find($id);

        $colaborador->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect()->route('colaboradores');
    }

    public function buscador(Request $request){
        $colaboradores=Colaboradores::where("nombre",'like',"%".$request->texto."%")->orderBy('nombre','Asc')->limit(8)->get();

        return view('panel.colaborador.buscador',compact('colaboradores'));
    }
   
}

