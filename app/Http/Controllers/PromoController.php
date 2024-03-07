<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Promocion;
use Illuminate\Http\Request;
use Session;
class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promocion::orderBy('id','desc')->get();
        return view('panel.promo.index',compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $planes = Plan::where('status','=',1)->get();
        return view('panel.promo.create',compact('planes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'  =>  'required|string','descripcion'=>'required|string',
            'portada' => 'required|mimes:jpg,png,jpeg|max:100','precio'    => 'required',
            'fecha_ini' => 'required','fecha_fin'   => 'required'
        ]);

        $imgnombre= uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
        $request->file('portada')->move(public_path().'/posts/',$imgnombre);



        Promocion::create([
            'name'          =>  $request->name,
            'slug'          =>  create_slug($request->name).'-'.uniqid(),
            'descripcion'   =>  $request->descripcion,
            'url_portada'   =>  $imgnombre,
            'precio'        =>  $request->precio,
            'fecha_ini'     =>  $request->fecha_ini,
            'fecha_fin'     =>  $request->fecha_fin,
            'plan_id'       =>  $request->plan
        ]);

        Session::flash('msg','Registro exitoso');

        return redirect()->route('promos.index');
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
        $promo = Promocion::find($id);
        $planes = Plan::where('status','=',1)->get();

        return view('panel.promo.edit',compact('promo','planes'));
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
        $this->validate($request,[
            'name'  =>  'required|string','descripcion'=>'required|string',
            'precio'    => 'required',
            'fecha_ini' => 'required','fecha_fin'   => 'required'
        ]);

        $promo = Promocion::find($id);

        if ($request->file('portada')) {
            $this->validate($request,[
                'portada' => 'mimes:jpg,png,jpeg|max:100'
            ]);
            if (file_exists(public_path().'/posts/'.$promo->url_portada)) {
                unlink(public_path().'/posts/'.$promo->url_portada);
            }
            $imgnombre= uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
            $request->file('portada')->move(public_path().'/posts/',$imgnombre);

            $promo->url_portada = $imgnombre;
        }

        if ($request->name != $promo->name) {
            $promo->name = $request->name;
            $promo->slug = create_slug($request->name).'-'.uniqid();
        }

        $promo->descripcion = $request->descripcion;
        $promo->precio = $request->precio;
        $promo->fecha_ini = $request->fecha_ini;
        $promo->fecha_fin = $request->fecha_fin;
        $promo->plan_id = $request->plan;
        //Resetear promocion activa
        if ($request->estado == 1) {
            Promocion::query()->update(['estado' => 0]);
        }
        $promo->estado = $request->estado;
        $promo->save();

        Session::flash('msg','Actualización exitosa');
        return redirect()->route('promos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Promocion::find($id);
        if (file_exists(public_path().'/posts/'.$promo->url_portada)) {
            unlink(public_path().'/posts/'.$promo->url_portada);
        }

        $promo->delete();

        Session::flash('msg','Registro eliminado');
        return redirect()->route('promos.index');
    }
}
