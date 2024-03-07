<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Session;
use Culqi\Culqi;
use Culqi\CulqiException;
use Requests;

class PlanController extends Controller
{

     protected $SECRET_API_KEY = ""; // Variable llave privada API CULQI
     protected $culqi = null; // Variable culqi

    public function __construct() /* Deteminación del método constructor */
    {
        Requests::register_autoloader(); /* Invocación de dependencia requests para Culqi */
       $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c"; /* Asignación de llave privada */
       /* $this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN"; /* Asignación de llave privada */
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY)); /*Instancia a la clase de culqi API*/

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // $planes = Plan::orderBy('id', 'desc')->get();
        $planes = Plan::when(request('status') ?? 'active', function ($query, $status) {
            if (request('status')) {
                $sort = $status === 'active' ? 1 : 0;
                $query->where('status',  $sort);
            }
        })->when(request('order') ?? 'new', function ($query, $order) {
            $sort = $order === 'new' ? 'desc' : 'asc';
            $query->orderBy('updated_at',  $sort);
        })->orderBy('id',  'desc')->get();
        return view('panel.plan.index',compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.plan.create');
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
            'name'  =>  'required|string',
            'descripcion' => 'required',
            'descripcion_c'=>'required',
            'descripcion_a'=>'required',
            'descripcion_m'=>'required',
            'precio'    => 'required|numeric',
            'moneda'  =>  'required|string',
            'int_meses'    => 'required|numeric'

        ]);

        if($request->promocion>0){
            $amount = $request->promocion;
        }else{
            $amount = $request->precio;
        }

         $plan=$this->culqi->Plans->create(array(
            //"amount" => $request->amount,
            "amount" => $amount * 100,
            "currency_code" => $request->moneda,
            "interval" => "meses",
            "interval_count" => $request->int_meses,
            //"limit" => 99, ciclo infinito
            "name" => $request->name
          )
        );



        Plan::create([
            'name'  =>  $request->name,
            'slug'  =>  create_slug($request->name).'-'.uniqid(),
            'descripcion' => $request->descripcion,
            'descripcion_c'=> $request->descripcion_c,
            'descripcion_a'=> $request->descripcion_a,
            'descripcion_m'=> $request->descripcion_m,
            'precio'    =>  $request->precio,
            'promocion'    =>  $request->promocion,
            'moneda'    =>  $request->moneda,
            'status'    =>  $request->status,
            'meses' => $request->int_meses,
            'id_culqi'=>$plan->id,
        ]);

       

        Session::flash('msg','Registro exitoso!');

        return redirect()->route('planes.index');

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
        $plan = Plan::find($id);
        return view('panel.plan.edit',compact('plan'));
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
            'name'  =>  'required|string',
            'descripcion' => 'required',
            'descripcion_m'=>'required',
            'descripcion_a'=>'required',
            'descripcion_c'=>'required',
            //'precio'    => 'required|numeric',
            //'int_meses'    => 'required|numeric'
        ]);

       /*$suscriptores=SuscriptorRecurrente::get();
        foreach ($suscriptores as $suscriptor) {
            $editar = SuscriptorRecurrente::find($suscriptor->id);
            if($editar->plan_id==2) {
                if($editar->suscription_init==date('Y-m-d')) {
                      $editar->monto=50;
                }else{
                      $editar->monto=100;
                }
              
            }else if($editar->plan_id==3){
                  if($editar->suscription_init==date('Y-m-d')) {
                      $editar->monto=30;
                }else{
                      $editar->monto=60;
                }
              }else if($editar->plan_id==1){
                
                      $editar->monto=0;
                
              }
              else if($editar->plan_id==5){
                
                      $editar->monto=0;
                
              }
              else if($editar->plan_id==6){
                
                      $editar->monto=28;
                
              }
              else if($editar->plan_id==7){
                
                      $editar->monto=18;
                
              }
            $editar->save();
        }
*/
        $plan = Plan::find($id);

        /* $planc=$this->culqi->Plans->update($plan->id_culqi,array(
            "metadata" => array(
                "amount" => $request->precio*100,
            )
          )
        );*/



        if ($request->name != $plan->name) {
            $plan->name = $request->name;
            $plan->slug = create_slug($request->name).'-'.uniqid();
        }

        $plan->descripcion = $request->descripcion;
        $plan->descripcion_a = $request->descripcion_a;
        $plan->descripcion_c = $request->descripcion_c;
        $plan->descripcion_m = $request->descripcion_m;
       // $plan->precio = $request->precio;
        $plan->status = $request->status;
        //$plan->meses=$request->int_meses;
        $plan->save();

        Session::flash('msg','Actualización exitosa!');
        return redirect()->route('planes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::find($id);

        $plan->delete();

        $this->culqi->Plans->delete($plan->id_culqi);

        Session::flash('msg','El registro fue eliminado!');

        return redirect()->route('planes.index');
    }
}
