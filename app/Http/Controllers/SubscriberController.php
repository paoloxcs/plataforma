<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Ejecutivo;
use App\Mail\NewSuscripDeposito;
use App\Mail\NewSuscripDepositoC;
use App\Mail\updateCaducidad;
use App\MetodoPago;
use App\Pago;
use App\Plan;
use App\Record;
use App\Role;
use App\SuscriptorDeposito;
use App\SuscriptorRecurrente;

use App\SuscriptorCursos;
use App\CertificadoCurso;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Culqi\Culqi;
use Culqi\CulqiException;
use App\Interes;
use App\SuscriptorEfectivo;
use App\Mail\MailPagoEfectivoCurso;
use App\Mail\MailPagoEfectivoPremium;
use App\Rubro;
use App\Curso;
use Requests;
use DateTime;

class SubscriberController extends Controller
{
   

   protected $SECRET_API_KEY = ""; // Variable llave privada API CULQI
     protected $culqi = null; // Variable culqi

    public function __construct() /* Deteminación del método constructor */
    {
        Requests::register_autoloader(); /* Invocación de dependencia requests para Culqi */
        $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c"; /* Asignación de llave privada */
      // $this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN"; /* Asignación de llave privada */
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY)); /*Instancia a la clase de culqi API*/
    }

    public function userUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|string',
            'last_name'=>'required|string',
            'email' => 'required|email|unique:users,id,'.$id
            ],[
              'email.unique'=>'El correo ingresado ya existe!'
            ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->doc_number = $request->doc_number;
        $user->save();
    
        return back()->with('msg','El registro fue actualizado con éxito');
    }
    /*<===========================Métodos suscriptores free==================>*/
    public function getFree()
    {
        return view('panel.subscriber.free.index_v1');
    }
    
  public function getFreeList()
  {
    // $subscribers = User::where('role_id', '=', 7)->with('records.gestor', 'intereses.medio', 'asignacion.gestor')->orderBy('id', 'desc')->paginate(6);
    $asesores = User::where('role_id', 8)->orWhere('role_id', 6)->get();
    //Version 1
    $suscriptores_free_query =  User::where('role_id', '=', 7)
      ->when(request('search') ?? null, function ($query, $buscar) {
        $query->where(function ($query) use ($buscar) {
          $query->where([[DB::raw('concat(name," ",last_name)'), 'like', '%' . $buscar . '%'], ['role_id', '=', 7]])
            ->orWhere([['email', 'like', '%' . $buscar . '%'], ['role_id', '=', 7]])
            ->orWhere([['phone_number', 'like', '%' . $buscar . '%'], ['role_id', '=', 7]]);
        });
      })->when(request('asesor') ?? null, function ($query, $asesor) {
        $query->join('asignaciones as a', 'a.suscriptor_id', '=', 'users.id')
          ->where([['a.gestor_id', $asesor], ['a.is_confirmed', false]]);
      })->select('users.*');

    $suscriptores_free = $suscriptores_free_query->with('records.gestor', 'intereses.medio', 'asignacion.gestor')->orderBy('id',  'desc')->paginate(10);
    $suscriptores_free_count = $suscriptores_free_query->count();

    if (request('count_free')) {
      $suscriptores_free_count = request('count_free');
    }

    // return $suscriptores_free;

    return view('panel.subscriber.free.index', compact('suscriptores_free', 'suscriptores_free_count', 'asesores'));
  }
  
    public function getFreeData(Request $request)
    {
      $subscribers = User::where('role_id','=',7)->with('records.gestor','intereses.medio','asignacion.gestor')->orderBy('id','desc')->paginate(6);

      return response($subscribers);

    }


    public function searchFree(Request $request)
    {

      $texto = $request->text;
      $subscribers = User::where([[DB::raw('concat(name," ",last_name)'),'like','%'.$texto.'%'],['role_id','=',7]])
      ->orWhere([['email', 'like', '%'.$texto.'%'],['role_id', '=',7]])->with('records.gestor','intereses.medio','asignacion.gestor')->orderBy('id','desc')
      ->limit(6)->get();

      return response($subscribers);

    }

    public function getSubcribersByAsesor(Request $request)
    {
      $subscribers = User::join('asignaciones as a', 'a.suscriptor_id','=','users.id')
      ->where([['a.gestor_id',$request->asesorid],['a.is_confirmed',false]])
      ->select('users.*')
      ->with('records.gestor','intereses.medio','asignacion.gestor')
      ->orderBy('a.id','desc')
      ->paginate(6);

      return response()->json($subscribers);
    }

    /*<========================Métodos suscriptores premium ===================>*/

    public function getPremium()
    {
        return view('panel.subscriber.deposito.index_v1');
    }
    public function getRecurrente()
    {
        return view('panel.subscriber.recurrente.index_v1');
    }
    //PAGO EFECTIVO
      public function getPagoEfectivo()
      {
        return view('panel.subscriber.pago_efectivo.index_v1');
      }
      
  public function getPagoEfectivoList()
  {
    // $planes = Plan::where('status', 1)->get();
    
    $planes = Plan::where('status', 1)->orderBy('status', 'desc')->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $planes_off = Plan::where('id_culqi', '!=', null)->where('status', 0)->orderBy('status', 'desc')->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $metodo_pagos = MetodoPago::where('name', '<>', 'Recurrente')->get();

    //Version 1
    $suscriptores_efectivo_query =  SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')
      ->when(request('order') ?? 'new', function ($query, $order) {
        $sort = $order === 'new' ? 'desc' : 'asc';
        $query->orderBy('suscription_init',  $sort);
      })->when(request('search') ?? null, function ($query, $buscar) {
        $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
          ->orWhere('u.email', 'like', '%' . $buscar . '%');
      })->when(request('plan') ?? null, function ($query, $plan) {
        $query->where('plan_id', $plan);
      })->when(request('modpago') ?? null, function ($query, $modpago_id) {
        $query->where('metodopago_id', $modpago_id);
      })->select('suscriptores_efectivo.*');

    // $subscribers = SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')
    // ->select('suscriptores_efectivo.*')->with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('suscriptores_efectivo.id', 'desc')->paginate(6);

    // $subscribers = SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')->with('user', 'curso', 'user.role', 'gestor', 'plan')
    // ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $texto . '%')
    // ->orWhere('u.email', 'like', '%' . $texto . '%')
    // ->select('suscriptores_efectivo.*')
    // ->limit(15)->get();


    $suscriptores_efectivo = $suscriptores_efectivo_query->with('user', 'pagos', 'plan', 'gestor', 'curso', 'user.role')->orderBy('suscriptores_efectivo.id',  'desc')->paginate(8);
    $suscriptores_efectivo_count = $suscriptores_efectivo_query->count();

    if (request('count_efectivo')) {
      $suscriptores_efectivo_count = request('count_efectivo');
    }

    return view('panel.subscriber.pago_efectivo.index', compact('suscriptores_efectivo', 'suscriptores_efectivo_count', 'planes', 'planes_off', 'metodo_pagos'));
  }

  public function getRecurrenteList()
  {

    $planes = Plan::where('status', 1)->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $planes_off = Plan::where('id_culqi', '!=', null)->where('status', 0)->orderBy('status', 'desc')->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $metodo_pagos = MetodoPago::where('name', '<>', 'Recurrente')->get();

    // $suscriptores_recurrente = SuscriptorRecurrente::with('user', 'plan')->orderBy('id', 'desc')->paginate(6);
    //Version 1
    $suscriptores_recurrente_query =  SuscriptorRecurrente::when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('suscription_init',  $sort);
    })->when(request('search') ?? null, function ($query, $buscar) {
      // $query->join('users as u', 'u.id', '=', 'suscriptores_recurrente.user_id')
      //   ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
      //   ->orWhere('u.email', 'like', '%' . $buscar . '%');
      $query->join('users as u', 'u.id', '=', 'suscriptores_recurrente.user_id')
        ->where(function ($query) use ($buscar) {
          $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
            ->orWhere('u.email', 'like', '%' . $buscar . '%')
            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
        });
    })->when(request('plan') ?? null, function ($query, $plan) {
      $query->where('plan_id', $plan);
    })->when(request('modpago') ?? null, function ($query, $modpago_id) {
      $query->where('metodopago_id', $modpago_id);
    })->when(request('status') ?? null, function ($query, $status) {
      if ($status == 1) {
        $query->where('suscription_end', '>', date('Y-m-d'));
      } else {
        $query->where('suscription_end', '<', date('Y-m-d'));
      }
    })->select('suscriptores_recurrente.*');

    $suscriptores_recurrente = $suscriptores_recurrente_query->with('plan')->orderBy('id',  'desc')->paginate(8);
    $suscriptores_recurrente_count = $suscriptores_recurrente_query->count();

    if (request('count_recurrente')) {
      $suscriptores_recurrente_count = request('count_recurrente');
    }

    return view('panel.subscriber.recurrente.index', compact('suscriptores_recurrente', 'suscriptores_recurrente_count', 'planes', 'planes_off', 'metodo_pagos'));
  }
  

  //NEW LIST DEPOSITO 
  public function getPremiumList()
  {
    $asesores = User::where('role_id', 8)->orWhere('role_id', 6)->get();

    $planes = Plan::where('status', 1)->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $planes_off = Plan::where('id_culqi', '!=', null)->where('status', 0)->orderBy('status', 'desc')->get();
    $metodo_pagos = MetodoPago::where('name', '<>', 'Recurrente')->get();

    $suscriptores_premium_query =  SuscriptorDeposito::join('users', function ($join) {
      $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
        ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
    })->when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('suscription_init',  $sort);
    })->when(request('search') ?? null, function ($query, $buscar) {
      $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
        ->where(function ($query) use ($buscar) {
          $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
            ->orWhere('u.email', 'like', '%' . $buscar . '%')
            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
        });
    })->when(request('plan') ?? null, function ($query, $plan) {
      $query->where('plan_id', $plan);
    })->when(request('modpago') ?? null, function ($query, $modpago_id) {
      $query->where('metodopago_id', $modpago_id);
    })->when(request('asesor') ?? null, function ($query, $asesor) {
      $query->where([['gestor_id', $asesor]]); 
    // })->when(request('fecha_start') ?? null , function ($query, $data_fecha_start) {
    //     $query->where('suscription_init', $data_fecha_start);
       })->when(request('status') ?? null, function ($query, $status) {
         if ($status == 1) {
           $query->where('suscription_end', '>', date('Y-m-d'));
         } else {
           $query->where('suscription_end', '<', date('Y-m-d'));
         }
    })->select('suscriptores_deposito.*');

    if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
      $suscriptores_premium_query =  SuscriptorDeposito::when(request('order') ?? 'new', function ($query, $order) {
        $sort = $order === 'new' ? 'desc' : 'asc';
        $query->orderBy('suscription_init',  $sort);
      })->when(request('search') ?? null, function ($query, $buscar) {
        $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
          ->where(function ($query) use ($buscar) {
            $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
              ->orWhere('u.email', 'like', '%' . $buscar . '%')
              ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
          });
      })->when(request('plan') ?? null, function ($query, $plan) {
        $query->where('plan_id', $plan);
      })->when(request('modpago') ?? null, function ($query, $modpago_id) {
        $query->where('metodopago_id', $modpago_id);
      })->when(request('asesor') ?? null, function ($query, $asesor) {
        $query->where([['gestor_id', $asesor]]); 
    //   })->when(request('fecha_start') ?? null , function ($query, $data_fecha_start) {
    //     $query->where('suscription_init', $data_fecha_start);
       })->when(request('status') ?? null, function ($query, $status) {
         if ($status == 1) {
           $query->where('suscription_end', '>', date('Y-m-d'));
         } else {
           $query->where('suscription_end', '<', date('Y-m-d'));
         }
      })->select('suscriptores_deposito.*');
    }

    $suscriptores_premium = $suscriptores_premium_query->with('user', 'pagos', 'plan', 'gestor')->orderBy('id',  'desc')->paginate(8);
    $suscriptores_premium_count = $suscriptores_premium_query->count();
    if (request('count_premium')) {
      $suscriptores_premium_count = request('count_premium');
    }
    return view('panel.subscriber.deposito.index', compact('suscriptores_premium', 'suscriptores_premium_count', 'planes', 'planes_off', 'metodo_pagos', 'asesores'));
  }


     public function getPremiumDataRecurrente(){
      $subscribers = SuscriptorRecurrente::with('user','plan')->orderBy('id','desc')->paginate(6);

      /*foreach ($subscribers as $subs) {

          $suscrip = $this->culqi->Subscriptions->get($subs->id_culqi);
          
         
             $subs['status'] = $suscrip;
          
        }*/

     
/*
       foreach ($subscribers as $subs) {

          $suscrip = $this->culqi->Subscriptions->get($subs->id_culqi);
          
         // $suscript =  $suscrip['charges'];
          foreach ( $suscrip->charges as $charge ) {
             $subs['status'] = $charge->outcome->type;
          }

         
        
       }*/
      

      return response()->json($subscribers);
     }

    public function getcursos(){
      return view('panel.subscriber.curso.index_v1');
    }
    
  //NEW LIST
  public function getCursosList()
  {  
    $cursos = Curso::orderBy('titulo', 'asc')->get();
    $gestores = User::where('role_id', 6)->orWhere('role_id', 8)->orderBy('name', 'asc')->get();

    $suscriptores_cursos_query =  SuscriptorCursos::when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('created_at',  $sort);
    })
    // ->join('pagos as p', 'p.nro_comprobante', '=', 'suscriptores_cursos.nro_comprobante')
    ->when(request('search') ?? null, function ($query, $buscar) {
      $query->join('users as u', 'u.id', '=', 'suscriptores_cursos.user_id')
        ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
        ->orWhere('u.email', 'like', '%' . $buscar . '%');
    })->when(request('curso') ?? null, function ($query, $curso_id) {
      $query->where('curso_id', $curso_id);
    })->when(request('gestor') ?? null, function ($query, $responsable) {
      $query->where('responsable', $responsable);
    })->select('suscriptores_cursos.*');

    $suscriptores_cursos = $suscriptores_cursos_query->with('user', 'curso', 'user.role', 'gestor')->paginate(15);
     
       foreach ($suscriptores_cursos as $subs) {

      // $pagos = Pago::where('nro_comprobante', '=', $subs->nro_comprobante)->orWhere('suscriptor_id', '=', $subs->id)->orderBy('id', 'desc')->first();
      // $pagos = Pago::where('nro_comprobante', '=', $subs->nro_comprobante)->orderBy('id', 'desc')->first();
 
      if ($subs->pago_monto) { 
        $subs['monto'] = $subs->pago_monto;
      }else{ 
        $curso = Curso::where('id', $subs->curso_id)->first();
        if ($subs->user->role_id == 2) {
          if ($subs->moneda == "PEN") {
            $precio = $curso->promocion;
          } else {
            $precio = $curso->promocion_d;
          }
        } else {
          if ($subs->moneda == "PEN") {
            $precio = $curso->precio;
          } else {
            $precio = $curso->precio_d;
          }
        }
        $subs['monto'] = $precio;
      }

    }


    $suscriptores_cursos_count = $suscriptores_cursos_query->count();

    if (request('count_cursos')) {
      $suscriptores_cursos_count = request('count_cursos');
    }

    // return $suscriptores_cursos;

    return view('panel.subscriber.curso.index', compact('cursos', 'gestores', 'suscriptores_cursos', 'suscriptores_cursos_count'));
  }


 // PAGO EFECTIVO
  public function getCursosData()
  {
    $cursos = Curso::Where('estado', 1)->get();

    $users = User::where('role_id', 8)->orWhere('role_id', 6)->get();

    // return response()->json($cursos);

    return response()->json(['cursos' => $cursos, 'gestores' => $users]);
  }
     public function getcertificado(){
      return view('panel.subscriber.curso.certificado');
    }

    public function certificadoestado(Request $request)
    {
      

      $certificado = CertificadoCurso::find($request->id);
        $certificado->estado = "1";
        $certificado->save();



      return response()->json([
        'message' =>'Estado modificado'
      ]);

    }

  ///Status Efectivo
  public function statusPagoEfectivo(Request $request)
  {


    $certificado = SuscriptorEfectivo::find($request->id);
    $certificado->status_efectivo = "1";
    $certificado->save();

    return response()->json(['message' => 'Estado modificado', 'status' => 200]);

    // return response()->json([
    //   'message' => 'Estado modificado'
    // ]);
  }
  // MENSAJE ENVIADO
  public function  notificationPagoEfectivo($id)
  {
    try {
      $ul = SuscriptorEfectivo::where('id', '=', $id)->first();

      $suscripcion = $this->culqi->Orders->get($ul->id_culqi);

      $user = User::find($ul->user_id);
      $curso = Curso::find($ul->curso_id);
      //Enviar correo 
      $data = [
        'name'  => $user->name,
        'email' => $user->email,
        'curso'  => $curso->titulo,
        'rubro' => $curso->rubro->nombrerubro,
        'slug' => $curso->slug,
        'user_message' => 'participación con éxito',
        'cip' => $suscripcion->payment_code,
        'suscription_end' => $suscripcion->expiration_date
      ];

      Mail::to($user->email)
        ->send(new MailPagoEfectivoCurso($data));

      // return response()->json($data);
      return response()->json(['message' => 'Mensaje Enviado', 'status' => 200]);
    } catch (Exception $e) {

      return response()->json($e->getMessage(), 500);
    }
  }

  public function  notificationPagoEfectivoPremium($id)
  {
    try {
      $ul = SuscriptorEfectivo::where('id', '=', $id)->first();

      $suscripcion = $this->culqi->Orders->get($ul->id_culqi);

      $user = User::find($ul->user_id);
      $plan = Plan::find($ul->plan_id);

      $precio =""; 
      if(number_format($plan->promocion, 2)>0){ 
        $precio = $plan->promocion;
      }else{ 
        $precio = $plan->precio;
      }
      $moneda =""; 
      if($plan->moneda == "PEN"){ 
        $moneda = "S/ ";
      }else{ 
        $moneda = "$ ";
      }
      //Enviar correo 
      $data = [
        'name'  => $user->name,
        'email' => $user->email,
        'plan'  => $plan->name.' ('.$plan->moneda.')',
        'moneda'  => $moneda,
        'precio'  => $precio,
        'user_message' => 'participación con éxito',
        'cip' => $suscripcion->payment_code,
        'suscription_end' => $suscripcion->expiration_date
      ];

      Mail::to($user->email)
        ->send(new MailPagoEfectivoPremium($data));

      // return response()->json($data);
      return response()->json(['message' => 'Mensaje Enviado', 'status' => 200]);
    } catch (Exception $e) {

      return response()->json($e->getMessage(), 500);
    }
  }
  
//PAGO EFECTIVO
//   public function asignatecurso(Request $request)
//   {

//     /*$asign = Asignacion::create([
//             'suscriptor_id' =>  $request->user_id,
//             'gestor_id'     =>  $request->gestor
//         ]);*/

//     $curso = Curso::where('id', $request->gestor)->first();
//     $user = User::where('id', $request->user_id)->first();
//     $gestor = User::where('id', $request->gestor_a)->first();

//     if (Auth()->user()->role_id == 6 or Auth()->user()->role_id == 8 or Auth()->user()->role_id == 1) {

//       $suscrito = SuscriptorCursos::where('user_id', $request->user_id)->where('curso_id', $request->gestor)->count();
//       if ($suscrito > 0) {

//         //   return response()->json(['message' => 'El Usuario ya se suscribió anteriormente'], 200);
//       } else {

//         if ($request->cortesia == 1) {

//           if ($curso->expira > date('Y-m-d')) {

//             if ($curso->fecha_culminacion < date('Y-m-d')) {

//               if ($curso->precio_c == Null or $curso->precio_c == "") {

//                 return response()->json(['message' => 'El curso no tiene precio culminado'], 200);
//               }

//               $nuevafecha = strtotime('+ 1 month', strtotime(date('Y-m-d')));

//               $suscriptor = SuscriptorCursos::create([
//                 /*'user_id' =>  Auth()->user()->id,*/
//                 'user_id' =>  $request->user_id,
//                 'curso_id' =>  $request->gestor,
//                 'nro_comprobante' =>  $request->nro_comprobante,
//                 'id_culqi' => "Null",
//                 'suscription_end' => date('Y-m-d', $nuevafecha),
//                 'moneda' => $request->moneda,
//                 'responsable' =>  $request->gestor_a
//               ]);



//               if ($user->role_id == 2) {

//                 $precio = $curso->promocion_c;
//               } else {
//                 $precio = $curso->precio_c;
//               }

//               $data = [
//                 'name'  => $user->name,
//                 'email' => $user->email,
//                 'curso'  => $curso->titulo,
//                 'amount' => $precio,
//                 'moneda' => "PEN",
//                 'rubro' => $curso->rubro->nombrerubro,
//                 'slug' => $curso->slug,
//                 'user_message' => 'participación con éxito'
//               ];

//               // Mail::to($user->email)
//               //   ->cc(['info@constructivo.com', 'postmaster3@constructivo.com'])
//               //   ->send(new SusCursoM($data));

//               //Enviar correo
//               $dataC = [
//                 'name' => $user->fullName(),
//                 'suscription_init' => date('Y-m-d'),
//                 'doc_number' => $user->doc_number,
//                 'phone' => $user->phone_number,
//                 'email' => $user->email,
//                 'nro_comprobante' => $request->nro_comprobante,
//                 'gestor' => $gestor->fullName(),
//                 'plan' => $curso->titulo,
//                 'precio' => $precio,
//                 'moneda' => $request->moneda,
//                 'message' => 'Nueva suscripción en Curso de Plataforma',
//                 'data' => 1,
//               ];

//               $suscriptorefectivo =  SuscriptorEfectivo::where('id',  $request->pago_id)
//                  ->update([
//                       'gestor_id' =>  $gestor->id,
//                       'status_efectivo' => "1"
//                     ]);

//               // Mail::to('cobranzas@constructivo.com')
//               //   ->cc('postmaster3@constructivo.com')
//               //   ->send(new NewSuscripDepositoC($dataC));



//               return response()->json(['message' => 'Asignación exitosa'], 200);
//             } else {
//               //cuando no está culminado

//               $suscriptor = SuscriptorCursos::create([
//                 /*'user_id' =>  Auth()->user()->id,*/
//                 'user_id' =>  $request->user_id,
//                 'curso_id' =>  $request->gestor,
//                 'nro_comprobante' =>  $request->nro_comprobante,
//                 'id_culqi' => "Null",
//                 'moneda' => $request->moneda,
//             'responsable' =>  $request->gestor_a
//               ]);

//               if ($user->role_id == 2) {
//                 if ($request->moneda == "PEN") {
//                   $precio = $curso->promocion;
//                 } else {
//                   $precio = $curso->promocion_d;
//                 }
//               } else {
//                 if ($request->moneda == "PEN") {
//                   $precio = $curso->precio;
//                 } else {
//                   $precio = $curso->precio_d;
//                 }
//               }


//               $data = [
//                 'name'  => $user->name,
//                 'email' => $user->email,
//                 'curso'  => $curso->titulo,
//                 'amount' => $precio,
//                 'moneda' => $request->moneda,
//                 'rubro' => $curso->rubro->nombrerubro,
//                 'slug' => $curso->slug,
//                 'user_message' => 'participación con éxito'
//               ];

//               // Mail::to($user->email)
//               //   ->cc(['info@constructivo.com', 'postmaster3@constructivo.com'])
//               //   ->send(new SusCursoM($data));

//               //Enviar correo
//               $dataC = [
//                 'name' => $user->fullName(),
//                 'suscription_init' => date('Y-m-d'),
//                 'doc_number' => $user->doc_number,
//                 'phone' => $user->phone_number,
//                 'email' => $user->email,
//                 'nro_comprobante' => $request->nro_comprobante,
//                 'gestor' => $gestor->fullName(),
//                 'plan' => $curso->titulo,
//                 'precio' => $precio,
//                 'moneda' => $request->moneda,
//                 'message' => 'Nueva suscripción en Curso de Plataforma',
//                 'data' => 1,
//               ];


//               $suscriptorefectivo =  SuscriptorEfectivo::where('id',  $request->pago_id)
//                  ->update([
//                       'gestor_id' =>  $gestor->id,
//                       'status_efectivo' => "1"
//                     ]);

//               // Mail::to('cobranzas@constructivo.com')
//               //   ->cc('postmaster3@constructivo.com')
//               //   ->send(new NewSuscripDepositoC($dataC));



//               return response()->json(['message' => 'Asignación exitosa'], 200);
//             }
//           } else {
//             return response()->json(['message' => 'El curso está expirado'], 200);
//           }
//         } else {
//           //GRATIS curso

//           /*$scursoscomprados=  SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','1')->where('created_at','>','2020-10-23')->count();

//                       $scursosgratis=  SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','0')->where('created_at','>','2020-10-23')->count();
//                       //$suscritogratis= SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','0')->count();
//                       if ($scursosgratis>=$scursoscomprados) {
                          
//                         return response()->json(['message'=>'El Usuario ya exedió el número de cursos gratis'], 200);
//                       }else{*/

//           $nuevafecha = strtotime('+ 1 month', strtotime(date('Y-m-d')));

//           $suscriptor = SuscriptorCursos::create([
//             /*'user_id' =>  Auth()->user()->id,*/
//             'user_id' =>  $request->user_id,
//             'curso_id' =>  $request->gestor,
//             'nro_comprobante' =>  $request->nro_comprobante,
//             'id_culqi' => "Null",
//             'compra' => "0",
//             'suscription_end' => date('Y-m-d', $nuevafecha),
//             'responsable' =>  $request->gestor_a
//           ]);




//           /*if($user->role_id==2){

//                             $data =[
//                               'name'  => $user->name,
//                               'email' => $user->email,
//                               'curso'  => $curso->titulo,
//                               'amount'=> '00',
//                               'moneda' => $request->moneda,
//                               'rubro' =>$curso->rubro->nombrerubro,
//                               'slug'=>$curso->slug,
//                               'user_message' => 'participación con éxito'
//                             ];

//                              Mail::to($user->email)
//                             ->cc(['info@constructivo.com','postmaster3@constructivo.com'])
//                             ->send(new SusCursoM($data));
                    
//                             //Enviar correo
//                           $dataC =[
//                             'name' => $user->fullName(),
//                             'suscription_init'=> date('Y-m-d'),
//                             'doc_number' => $user->doc_number,
//                             'phone' => $user->phone_number,
//                             'email'=> $user->email,
//                             'nro_comprobante' => $request->nro_comprobante,
//                             'gestor' => Auth()->user()->fullName(),
//                             'plan' => $curso->titulo,
//                             'precio' => '00',
//                             'moneda' => $request->moneda,
//                             'message' => 'Nueva suscripción en Curso de Plataforma',
//                             'data'=>1,
//                           ];
//                           Mail::to('cobranzas@constructivo.com')
//                           ->cc('postmaster3@constructivo.com')
//                           ->send(new NewSuscripDepositoC($dataC));  


//                           }
//                           else{*/

//           $data = [
//             'name'  => $user->name,
//             'email' => $user->email,
//             'curso'  => $curso->titulo,
//             'amount' => '00',
//             'moneda' => $request->moneda,
//             'rubro' => $curso->rubro->nombrerubro,
//             'slug' => $curso->slug,
//             'user_message' => 'participación con éxito'
//           ];

//           // Mail::to($user->email)
//           //   ->cc('info@constructivo.com')
//           //   ->send(new SusCursoM($data));


//           $dataC = [
//             'name' => $user->fullName(),
//             'suscription_init' => date('Y-m-d'),
//             'doc_number' => $user->doc_number,
//             'phone' => $user->phone_number,
//             'email' => $user->email,
//             'nro_comprobante' => $request->nro_comprobante,
//             'gestor' => $gestor->fullName(),
//             'plan' => $curso->titulo,
//             'precio' => '00',
//             'moneda' => $request->moneda,
//             'message' => 'Nueva suscripción en Curso de Plataforma',
//             'data' => 1,
//           ];


//           $suscriptorefectivo =  SuscriptorEfectivo::where('id',  $request->pago_id)
//                 ->update([
//                   'gestor_id' =>  $gestor->id,
//                   'status_efectivo' => "1"
//                 ]);

//           // Mail::to('cobranzas@constructivo.com')
//           //   ->cc('postmaster3@constructivo.com')
//           //   ->send(new NewSuscripDepositoC($dataC));

//           // }

//           return response()->json(['message' => 'Asignación exitosa'], 200);



//           // }
//         }
//       }
//     } else {

//       return response()->json(['message' => 'No tienes acceso para realizar este proceso'], 200);
//     }
//   }
 
  public function asignatecurso(Request $request)
  {

    /*$asign = Asignacion::create([
            'suscriptor_id' =>  $request->user_id,
            'gestor_id'     =>  $request->gestor
        ]);*/

    $curso = Curso::where('id', $request->gestor)->first();
    $user = User::where('id', $request->user_id)->first();
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();
    $gestor = User::where('id', $request->gestor_a)->first();
    $plan = Plan::where('id', '2')->first();

    if ($user->isPremium()) {
    } else {

      if ($curso->rubro->idrubro != 1 and $curso->fecha_culminacion >= date('Y-m-d')) {
        $usr = User::find($request->user_id);
        $usr->role_id = 2;
        $usr->save();

        $suscrip = new SuscriptorDeposito();
        $suscrip->user_id = $usr->id;
        $suscrip->plan_id = $plan->id;
        $suscrip->suscription_init = date('Y-m-d');
        $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
        $suscrip->medio = 'RC';
        $suscrip->tipo = 'D';
        $suscrip->metodopago_id = 2;
        $suscrip->gestor_id = '18207';
        $suscrip->save();

        //Guardando new pago
        $metodo_pago = MetodoPago::where('name', 'Pago Efectivo')->first();
        if (!$metodo_pago) {
          $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Pago Efectivo']);
        }

        //Guardando pago
        Pago::create([
          'suscriptor_id' =>  $suscrip->id,
          'monto'         =>  0.00,
          'moneda'         =>  $plan->moneda,
          'nro_comprobante' => 'COMPRA_CURSO',
          'metodopago_id' =>   $metodo_pago->id,
          'voucher_emit' =>  2
        ]);


        $data = [
          'name' => $usr->name,
          'email' => $usr->email,
          'caducidad' => date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"))
        ];
        /*Mail::to($usr->email)
                ->send(new NewSuscripDeposito($data));*/

        //Enviar correo
        $dataC = [
          'name' => $usr->name . ' ' . $usr->last_name,
          'suscription_init' => date('Y-m-d'),
          'doc_number' => $usr->doc_number,
          'phone' => $usr->phone_number,
          'email' => $usr->email,
          'nro_comprobante' => 'COMPRA_CURSO',
          'gestor' => 'PLATAFORMA CONSTRUCTIVO',
          'plan' => $plan->name,
          'precio' => '0.00',
          'message' => 'Nueva suscripción en Plataforma',
          'data' => 0,
          'moneda' => $plan->moneda,
        ];
        /*Mail::to('cobranzas@constructivo.com')
                ->cc('postmaster3@constructivo.com')
                ->send(new NewSuscripDepositoC($dataC));*/
      }
    }
    //GRATIS PLATAFORMA 
    if ($curso->fecha_culminacion < date('Y-m-d')) {

      $nuevafecha = strtotime('+ 1 month', strtotime(date('Y-m-d')));

      $suscriptor = SuscriptorCursos::create([
        /*'user_id' =>  Auth()->user()->id,*/
        'user_id' =>  $user->id,
        'curso_id' =>  $curso->id,
        'id_culqi' => $request->culqi_id,
        'suscription_end' => date('Y-m-d', $nuevafecha),
        'nro_comprobante' =>  $request->nro_comprobante,
        'responsable' => $request->gestor_a,
        'moneda' => $request->moneda,
      ]);
    } else { 
      $suscriptor = SuscriptorCursos::create([
        'user_id' => $user->id,
        'curso_id' =>  $curso->id,
        'id_culqi' => $request->culqi_id,
        'nro_comprobante' =>  $request->nro_comprobante,
        'responsable' => $request->gestor_a,
        'moneda' => $request->moneda,
      ]);
    } 
    /* Array de datos para enviar por correo */
    $data = [
      'name'  => $user->name,
      'email' => $user->email,
      'curso'  => $curso->titulo,
      'amount' => $request->amount,
      'moneda' => $request->moneda,
      'rubro' => $rubro->nombrerubro,
      'slug' => $curso->slug,
      'user_message' => 'participación con éxito'

    ];

    /*Mail::to(Auth()->user()->email)
          ->cc('info@constructivo.com')
          ->send(new SusCursoM($data));*/

      $suscriptorefectivo =  SuscriptorEfectivo::where('id',  $request->pago_id)
       ->update([
         'gestor_id' =>  $gestor->id,
         'status_efectivo' => "1"
       ]);
    // Delete Pago Efectivo
    create_user_log('Actualizó los datos de la compra de curso en Pago Efectivo ' . strtoupper($user->fullName()));
    
 //$suscriptor_pagoefectivo = SuscriptorEfectivo::where('id', '=', $request->pago_id)->first();
   // $suscriptor_pagoefectivo->delete();

    return response()->json(['message' => 'Asignación exitosa'], 200);
 
  }
  
    public function getDataCurso(){

      $subscribers = SuscriptorCursos::with('user','curso','user.role','gestor')->orderBy('id','desc')->paginate(15);

      return response()->json($subscribers);
     }


    public function getDataCertificado(){
      $subscribers = CertificadoCurso::with('user','curso','user.role')->orderBy('id','desc')->paginate(6);
      return response()->json($subscribers);
     }


    public function getPremiumData(Request $request)
    {
       $subscribers = SuscriptorDeposito::with('user','pagos','plan','gestor')->orderBy('id','desc')->where('gestor_id',Auth()->user()->id)->orWhere('gestor_id','18207')->paginate(6);

      if(Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()){
      $subscribers = SuscriptorDeposito::with('user','pagos','plan','gestor')->orderBy('id','desc')->paginate(6);

      }

      foreach ($subscribers as $subs) {
        if($subs->suscription_end < date('Y-m-d')){
          $subs['status'] = 'Expirado';
        }else{
          $subs['status'] = 'Vigente';
        }
        
        // JHED SP-P
        $pagos = Pago::where('suscriptor_id','=',$subs->id)->orderBy('id','desc')->first();
      if ($pagos){ 
        $subs['pago_time'] = $pagos;
      }else{
        $subs['pago_time'] = [];
      }
        // formatea la fecha 
        /*$subs->suscription_end = date('d/m/Y', strtotime($subs->suscription_end));*/
      }

      return response()->json($subscribers);
    }
    //PAGO EFECTIVO
    public function getPagoEfectivoData(Request $request)
      {
        // $subscribers = SuscriptorEfectivo::with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('id', 'desc')->where('gestor_id', Auth()->user()->id)->orWhere('gestor_id', '18207')->paginate(6);
   $subscribers = SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')->select('suscriptores_efectivo.*')->with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('suscriptores_efectivo.id', 'desc')->paginate(6);
    // if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
    //   $subscribers = SuscriptorEfectivo::with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('id', 'desc')->paginate(6);
    // }

    
        foreach ($subscribers as $subs) {
          if ($subs->suscription_end < date('Y-m-d')) {
            $subs['status'] = 'Expirado';
          } else {
            $subs['status'] = 'Vigente';
          }
          // formatea la fecha 
          /*$subs->suscription_end = date('d/m/Y', strtotime($subs->suscription_end));*/
        }
    
        return response()->json($subscribers);
      }
    public function storePremium(Request $request)
    {

      $validation = \Validator::make($request->all(),[
          'name'=>'required|string|max:100',
          'last_name'=>'required|string|max:100',
          'nro_comprobante'=>'required|string',
          'monto'=>'required|numeric',
          //Nuevos Campos requeridos
          'phone_number' => 'required',
          'address' => 'required',
          'doc_number' => 'required',
          'profession' => 'required',
          'cargo_user' => 'required',
          'num_operacion' => 'required',
          //Nuevos Campos requeridos
          'email'=>'required|email|unique:users',
          'password'=>'required|confirmed|min:6',
          'suscription_end'=>'required|after:today'
          ],[
            'email.unique'=>'El correo ingresado ya existe!',
            'suscription_end.after'=>'La fecha de caducidad debe ser mayor que hoy.'
          ]);
      if ($validation->fails()) {
        return response()->json(['errors'=>$validation->errors(),'status'=>422]);
      }else{

        $gestor=User::where('id',$request->gestor_a)->first();

        //Insertar en la tabla users
        $user = new User();

        
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
         //Nuevos Campos requeridos
          $user->phone_number = $request->phone_number;
          $user->doc_number = $request->doc_number;
          $user->profession = $request->profession;
          $user->cargo_user = $request->cargo_user;
          $user->address = $request->address;
          //Nuevos Campos requeridos
        $user->save();

        //recuperar plan seleccionado
        $plan = Plan::find($request->plan);



        //Insertar en la tabla suscriptores_deposito
        $suscrip = new SuscriptorDeposito();
        $suscrip->user_id = $user->id;
        $suscrip->plan_id = $plan->id;
        $suscrip->suscription_init = date('Y-m-d');
        $suscrip->suscription_end = $request->suscription_end;
        $suscrip->medio = $request->medio;
        $suscrip->tipo = $request->modalidad;
        $suscrip->metodopago_id = 2;
        $suscrip->gestor_id = $request->gestor_a;
        $suscrip->save();

        //Guardando pago
        Pago::create([
          'suscriptor_id' =>  $suscrip->id,
          'monto'         =>  $request->monto,
          'moneda'         =>  $plan->moneda,
          'nro_comprobante' => $request->nro_comprobante, 
          //Nuevos Campos requeridos     
          'num_operacion' => $request->num_operacion,      
          'metodopago_id' =>  2,
          'voucher_emit' =>  2 
        ]);

      
        //Enviar correo
        $data =[
          'name' => $request->name,
          'email'=> $request->email,
          'password' => $request->password,
          'caducidad'=> $request->suscription_end
        ];
        Mail::to($request->email)
        ->send(new NewSuscripDeposito($data));

        //Enviar correo
        $dataC =[
          'name' => $request->name.' '.$request->last_name,
          'suscription_init'=> date('Y-m-d'),
          'doc_number' => $request->doc_number,
          'phone' => $request->phone_number,
          'email'=> $request->email,
          'nro_comprobante' => $request->nro_comprobante,
          'gestor' => $gestor->fullName(),
          'plan' => $plan->name,
          'precio' => $request->monto,
          'message'=>'Nueva suscripción en Plataforma',
          'data' => 0,
          'moneda' => $plan->moneda,
        ];
        Mail::to('cobranzas@constructivo.com')
        ->cc('postmaster3@constructivo.com')
        ->send(new NewSuscripDepositoC($dataC));


        create_user_log('Generó la suscripción para '.strtoupper($user->fullName())); // Crea un log en el sistema

        return response()->json(['message'=>'Registro exitoso','status'=>200]);

      }

    }

    // JHED PREMIUM
      public function storePagoEfectivoPremium(Request $request, $id)
      { 
    $validation = \Validator::make($request->all(), [
      'name' => 'required|string|max:100',
      'last_name' => 'required|string|max:100',
      'nro_comprobante' => 'required|string',
      'monto' => 'required|numeric',
      'email' => 'required|email|unique:users,email,'.$id.',id',
      'suscription_end' => 'required|after:today'
    ], [
      'email.unique' => 'El correo ingresado ya existe!',
      'suscription_end.after' => 'La fecha de caducidad debe ser mayor que hoy.'
    ]);
    if ($validation->fails()) {
      return response()->json(['errors' => $validation->errors(), 'status' => 422]);
    } else {
      //VERIFICANDO USER SI ESTA SUSCRIPTO
     
      $gestor=User::where('id',$request->gestor_a)->first();
      $suscripDep = SuscriptorDeposito::where('user_id', $id)->first();
 
      if(!$suscripDep){
        // //Insertar en la tabla users
        $user = User::find($id);     
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = strtolower($request->email);
        // $user->password = bcrypt($request->password);
        $user->role_id = 2;
        $user->phone_number = $request->phone_number;
        $user->doc_number = $request->doc_number;
        $user->save();
        
        //recuperar plan seleccionado
        $plan = Plan::find($request->plan);

         //Insertar en la tabla suscriptores_deposito
         $suscrip = new SuscriptorDeposito();
         $suscrip->user_id = $user->id;
         $suscrip->plan_id = $plan->id;
         $suscrip->suscription_init = date('Y-m-d');
         $suscrip->suscription_end = $request->suscription_end;
         $suscrip->medio = $request->medio;
         $suscrip->tipo = $request->modalidad;
         $suscrip->metodopago_id = 2;
         $suscrip->gestor_id = $request->gestor_a;
         $suscrip->save();
         
        //Guardando new pago
        $metodo_pago = MetodoPago::where('name', 'Pago Efectivo')->first();
        if (!$metodo_pago) {
          $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Pago Efectivo']);
        }

         //Guardando pago
        Pago::create([
          'suscriptor_id' =>  $suscrip->id,
          'monto'         =>  $request->monto,
          'moneda'         =>  $plan->moneda,
          'nro_comprobante' => $request->nro_comprobante,
          'metodopago_id' =>  $metodo_pago->id,
          'voucher_emit' =>  2 
        ]);
        
         //Enviar correo
         $data =[
          'name' => $user->fullName(),
          'email'=> $user->email,
          'password' => $request->password,
          'caducidad'=> $request->suscription_end
        ];
        Mail::to($request->email)
        ->send(new NewSuscripDeposito($data));

        //Enviar correo
        $dataC =[
          'name' => $user->fullName(),
          'suscription_init'=> date('Y-m-d'),
          'doc_number' => $request->doc_number,
          'phone' => $request->phone_number,
          'email'=> $user->email,
          'nro_comprobante' => $request->nro_comprobante,
          'gestor' => $gestor->fullName(),
          'plan' => $plan->name,
          'precio' => $request->monto,
          'message'=>'Nueva suscripción en Plataforma',
          'data' => 0,
          'moneda' => $plan->moneda,
        ];
        Mail::to('cobranzas@constructivo.com')
        ->cc('postmaster3@constructivo.com')
        ->send(new NewSuscripDepositoC($dataC));
 
        create_user_log('Generó la suscripción para '.strtoupper($user->fullName())); // Crea un log en el sistema

             SuscriptorEfectivo::where('id',  $request->suscriptor_efectivo_id)
           ->update([
             'gestor_id' =>  $request->gestor_a,
             'status_efectivo' => "1"
           ]);

        // Delete Pago Efectivo
        create_user_log('Actualizó los datos de la compra en Pago Efectivo ' . strtoupper($user->fullName()));

      
   // $suscriptor_pagoefectivo = SuscriptorEfectivo::where('id', '=', $request->suscriptor_efectivo_id)->first();
   // $suscriptor_pagoefectivo->delete();


        return response()->json(['message'=>'Registro exitoso','status'=>200]);

      }else{  
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->doc_number = $request->doc_number;
        $user->save();
        
        $suscripDep = SuscriptorDeposito::where('user_id',$id)->first();
        $plan = Plan::find($request->plan);

        if($suscripDep->suscription_end != $request->suscription_end){
          $validation = \Validator::make($request->all(),[
            'nro_comprobante'=>'required|string',
            'monto'=>'required|numeric',
            ]);

            if ($validation->fails()) {
              return response()->json(['errors' => $validation->errors(),'status'=>422]);
            }

            $suscripDep->suscription_end = $request->suscription_end;
            $suscripDep->plan_id = $plan->id;
            $suscripDep->gestor_id = $request->gestor_a;
            $suscripDep->save(); 

          //Guardando new pago
          $metodo_pago = MetodoPago::where('name', 'Pago Efectivo')->first();
          if (!$metodo_pago) {
            $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Pago Efectivo']);
          }
          
            Pago::create([
              'suscriptor_id' =>  $suscripDep->id,
              'monto'         =>  $request->monto,
              'nro_comprobante' => $request->nro_comprobante,
              'tipo'          =>  'R',
            'metodopago_id' =>  $metodo_pago->id,
              'voucher_emit'  =>  2,
              'moneda' => $plan->moneda,
            ]);
  
            // Enviando correo al usuario
            $data =[
              'username'  =>  $suscripDep->user->fullName(),
              'caducidad' =>  $suscripDep->suscription_end
            ];
            Mail::to($suscripDep->user->email)
            ->send(new updateCaducidad($data)); 
            //Enviar correo
            $dataC =[
              'name' => $suscripDep->user->fullName(),
              'suscription_init'=> date('Y-m-d'),
              'doc_number' => $request->doc_number,
              'phone' => $request->phone_number,
              'email'=> $request->email,
              'nro_comprobante' => $request->nro_comprobante,
              'gestor' => $gestor->fullName(),
              'plan' => $plan->name,
              'precio' => $request->monto,
              'message'=>'Renovación de suscripción en Plataforma',
              'data' => 0,
              'moneda' => $plan->moneda,
            ];
            Mail::to('cobranzas@constructivo.com')
            ->cc('postmaster3@constructivo.com')
            ->send(new NewSuscripDepositoC($dataC)); 

            create_user_log('Renovó la suscripción de '.strtoupper($user->fullName())); // Crea un log en el sistema
          
        }

        $suscripDep->medio = $request->medio;
        $suscripDep->tipo = $request->modalidad;
        $suscripDep->gestor_id = $request->gestor_a;
        $suscripDep->save(); 

         SuscriptorEfectivo::where('id',  $request->suscriptor_efectivo_id)
           ->update([
             'gestor_id' =>  $request->gestor_a,
             'status_efectivo' => "1"
           ]);

        // Delete Pago Efectivo
        create_user_log('Actualizó los datos de la compra en Pago Efectivo ' . strtoupper($user->fullName()));
 
      
    // $suscriptor_pagoefectivo = SuscriptorEfectivo::where('id', '=', $request->suscriptor_efectivo_id)->first();
   // $suscriptor_pagoefectivo->delete();

        return response()->json(['message'=>'Actualizacion exitosa','status'=>200]);
      }
       
    }
  }
  
    public function storeFree(Request $request){

      $validation = \Validator::make($request->all(),[
          'name'=>'required|string|max:100',
          'last_name'=>'required|string|max:100',
          'email'=>'required|email|unique:users',
          'password'=>'required|confirmed|min:6',
            //Nuevos Campos requeridos
           'phone_number' => 'required',
           'address' => 'required',
           'doc_number' => 'required',
           'profession' => 'required',
           'cargo_user' => 'required', 
           //Nuevos Campos requeridos
          ],[
            'email.unique'=>'El correo ingresado ya existe!',
          ]);
      if ($validation->fails()) {
        return response()->json(['errors'=>$validation->errors(),'status'=>422]);
      }else{
         //Insertar en la tabla users
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->role_id = 7;
         //Nuevos Campos requeridos
     $user->phone_number = $request->phone_number;
     $user->doc_number = $request->doc_number;
     $user->profession = $request->profession;
     $user->cargo_user = $request->cargo_user;
     $user->address = $request->address;
     //Nuevos Campos requeridos
        $user->save();

        Interes::create([
                       'user_id'   =>  $user->id,
                       'medio_id'  => $request->medio,
                   ]);

        create_user_log('Agregó al usuario '.strtoupper($user->fullName()));

         return response()->json(['message'=>'Registro exitoso','status'=>200]);
      }


    }
    
    public function updatePremium(Request $request, $id)
    {
      $validation = \Validator::make($request->all(),[
          'name'=>'required|string',
          'last_name'=>'required|string',
          'email' => 'required|email|unique:users,email,'.$id.',id',
           //Nuevos Campos requeridos
          'phone_number' => 'required',
          'address' => 'required',
          'doc_number' => 'required',
          'profession' => 'required',
          'cargo_user' => 'required',
          'num_operacion' => 'required',
          //Nuevos Campos requeridos
          ],[
            'email.unique'=>'El correo ingresado ya existe!'
          ]);
      if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors(),'status'=>422]);
      }else{
          $gestor=User::where('id',$request->gestor_a)->first();


        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        //Nuevos Campos requeridos
        $user->phone_number = $request->phone_number;
        $user->doc_number = $request->doc_number;
        $user->profession = $request->profession;
        $user->cargo_user = $request->cargo_user;
        $user->address = $request->address;
        //Nuevos Campos requeridos
        $user->save();

        $suscripDep = SuscriptorDeposito::where('user_id',$id)->first();
        $plan = Plan::find($request->plan);

        if($suscripDep->suscription_end != $request->suscription_end){
        $validation = \Validator::make($request->all(),[
          'nro_comprobante'=>'required|string',
          'monto'=>'required|numeric',
          ]);
        if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors(),'status'=>422]);
         }
          $suscripDep->suscription_end = $request->suscription_end;
          $suscripDep->plan_id = $plan->id;
          $suscripDep->gestor_id = $request->gestor_a;
          $suscripDep->save();

         


          Pago::create([
            'suscriptor_id' =>  $suscripDep->id,
            'monto'         =>  $request->monto,
            'nro_comprobante' => $request->nro_comprobante,
      //Nuevos Campos requeridos
          'num_operacion' => $request->num_operacion,
            'tipo'          =>  'R',
            'metodopago_id' =>  2,
            'voucher_emit'  =>  2,
            'moneda' => $plan->moneda,
          ]);


          // Enviando correo al usuario
          $data =[
            'username'  =>  $suscripDep->user->fullName(),
            'caducidad' =>  $suscripDep->suscription_end
          ];
          Mail::to($suscripDep->user->email)
          ->send(new updateCaducidad($data));

           //Enviar correo
          $dataC =[
            'name' => $suscripDep->user->fullName(),
            'suscription_init'=> date('Y-m-d'),
            'doc_number' => $request->doc_number,
            'phone' => $request->phone_number,
            'email'=> $request->email,
            'nro_comprobante' => $request->nro_comprobante,
            'gestor' => $gestor->fullName(),
            'plan' => $plan->name,
            'precio' => $request->monto,
            'message'=>'Renovación de suscripción en Plataforma',
            'data' => 0,
            'moneda' => $plan->moneda,
          ];
          Mail::to('cobranzas@constructivo.com')
          ->cc('postmaster3@constructivo.com')
          ->send(new NewSuscripDepositoC($dataC));

        
          create_user_log('Renovó la suscripción de '.strtoupper($user->fullName())); // Crea un log en el sistema
          
        }

        $suscripDep->medio = $request->medio;
        $suscripDep->tipo = $request->modalidad;
          $suscripDep->gestor_id = $request->gestor_a;
        $suscripDep->save();

       create_user_log('Actualizó los datos de '.strtoupper($user->fullName()));

        return response()->json(['message'=>'Actualizacion exitosa','status'=>200]);
      }

    }
    public function destroyPremium($id)
    {
      $user = User::find($id);

      $suscrip = SuscriptorDeposito::where('user_id','=',$user->id)->first();
      $suscrip->delete();


      $user->role_id = 7;
      $user->save();

      $asignation = Asignacion::where('suscriptor_id',$id)->first();
      if($asignation){
        $asignation->is_confirmed = 0;
        $asignation->save();
      }
      

      create_user_log('Anuló la suscripción de '.strtoupper($user->fullName())); // Crea un log en el sistema

      return response()->json(['message'=>'Suscripcion anulada','status'=>200]);

    }

     public function destroyCurso($id)
    {
    

      $suscrip = SuscriptorCursos::where('id','=',$id)->first();
      $suscrip->delete();


     create_user_log('Anuló la suscripción del curso '.strtoupper($suscrip->curso->titulo).' a ' . strtoupper($suscrip->user->fullName()) );

      return response()->json(['message'=>'Suscripcion anulada','status'=>200]);

    }
    //PAGO EFECTIVO
      public function destroyPagoEfectivo($id)
      {
        $suscrip = SuscriptorEfectivo::where('id', '=', $id)->first();
        $suscrip->delete();
    
        create_user_log('Anuló la suscripción del curso ' . strtoupper($suscrip->curso->titulo) . ' a ' . strtoupper($suscrip->user->fullName()));
    
        return response()->json(['message' => 'Suscripcion anulada', 'status' => 200]);
      }

    //metodo para buscar por nombre
    public function searchPremium(Request $request)
    {

      $texto = $request->text;

      $subscribers = SuscriptorDeposito::join('users as u','u.id','=','suscriptores_deposito.user_id')->join('users', function ($join) {
            $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
                 ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
        })->with('user','pagos','plan','gestor')->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
      ->orWhere('u.email', 'like','%'.$texto.'%')
      ->select('suscriptores_deposito.*')
      ->limit(6)->get();

    if(Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()){

      $subscribers = SuscriptorDeposito::join('users as u','u.id','=','suscriptores_deposito.user_id')->with('user','pagos','plan','gestor')->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
      ->orWhere('u.email', 'like','%'.$texto.'%')
      ->select('suscriptores_deposito.*')
      ->limit(6)->get();

    }

        /* $subscribers = SuscriptorDeposito::with('user','pagos','plan')->orderBy('id','desc')->where('gestor_id',Auth()->user()->id)->paginate(6);*/
      /*->join('contacts', function ($join) {
            $join->on('users.id', '=', 'contacts.user_id')
                 ->where('contacts.user_id', '>', 5);
        })*/
      foreach ($subscribers as $subs) {

        if($subs->suscription_end < date('Y-m-d')){
          $subs['status'] = 'Expirado';
        }else{
          $subs['status'] = 'Vigente';
        }
        
        // JHED SP-P
        $pagos = Pago::where('suscriptor_id','=',$subs->id)->orderBy('id','desc')->first();
      if ($pagos){ 
        $subs['pago_time'] = $pagos;
      }else{
        $subs['pago_time'] = [];
      }
        
      }


      return response()->json($subscribers);


    }
    
       //metodo para buscar por nombre Recurrente
    public function searchPremiumR(Request $request)
    {

      $texto = $request->text;

      $subscribers = SuscriptorRecurrente::join('users as u','u.id','=','suscriptores_recurrente.user_id')->with('user','plan')->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
      ->orWhere('u.email', 'like','%'.$texto.'%')
      ->select('suscriptores_recurrente.*')
      ->limit(6)->get();



      return response()->json($subscribers);

    }


     public function searchCurso(Request $request)
        {

          $texto = $request->text;

          $subscribers = SuscriptorCursos::join('users as u','u.id','=','suscriptores_cursos.user_id')->with('user','curso','user.role','gestor')->where(DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$texto.'%')
          ->orWhere('u.email', 'like','%'.$texto.'%')
          ->select('suscriptores_cursos.*')
          ->limit(15)->get();

          

          return response()->json($subscribers);


    }
     //SEARCH PAGO EFECTIVO
      public function searchPagoEfectivoCurso(Request $request)
      {
    
         $texto = $request->text;

        $subscribers = SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')->with('user', 'curso', 'user.role', 'gestor', 'plan')
          ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $texto . '%')
          ->orWhere('u.email', 'like', '%' . $texto . '%')
          ->select('suscriptores_efectivo.*')
          ->limit(15)->get();
        foreach ($subscribers as $subs) {
          if ($subs->suscription_end < date('Y-m-d')) {
            $subs['status'] = 'Expirado';
          } else {
            $subs['status'] = 'Vigente';
          }
        }
        return response()->json($subscribers);
      }
     public function searchCertificado(Request $request)
        {

          $texto = $request->text;

          $subscribers = CertificadoCurso::with('user','curso','user.role')
          ->orWhere('email', 'like','%'.$texto.'%')
          ->orWhere('fullname', 'like','%'.$texto.'%')
          ->orWhere('phone_number', 'like','%'.$texto.'%')
          ->select('cursos_certificado.*')
          ->limit(6)->get();

          

          return response()->json($subscribers);


    }


    
    public function destroy($id)
    {


    }

    public function convertStore(Request $request,$id)
    {
      $validation = \Validator::make($request->all(),[
        'suscription_end'=>'required|after:today',
        'nro_comprobante'=>'required|string' ,
        'monto'=>'required|numeric' 
      ],[
        'suscription_end.after'=>'La fecha de caducidad debe ser mayor que hoy.'
      ]);
      if($validation->fails()){
        return response()->json(['errors'=>$validation->errors()], 422);
      }

      $user = User::find($id);
      $user->name = $request->name;
      $user->last_name = $request->last_name;
      $user->email = $request->email;
      $user->phone_number = $request->phone_number;
      $user->doc_number = $request->doc_number;
     

      $plan = Plan::find($request->plan);

      $suscrip = SuscriptorDeposito::create([
        'user_id' =>  $user->id,
        'plan_id' => $plan->id,
        'suscription_init'  =>  date('Y-m-d'),
        'suscription_end'   =>  $request->suscription_end,
        'medio'             =>  $request->medio,
        'tipo'         => $request->modalidad,
        'gestor_id' => Auth()->user()->id,
        'metodopago_id' => 2
      ]);

      //Guardando pago
      Pago::create([
        'suscriptor_id' =>  $suscrip->id,
        'monto'         =>  $request->monto,
        'moneda'         =>  $plan->moneda,
        'nro_comprobante' => $request->nro_comprobante,
        'metodopago_id' =>  2,
        'voucher_emit'  =>  2
      ]);

      $user->role_id = 2;
      $user->save();

      $asignacion = Asignacion::where('suscriptor_id','=',$id)->first();
      $asignacion->is_confirmed = 1;
      $asignacion->save();

      create_user_log('Convirtió a '.strtoupper($user->fullName()).' de Free a Premium'); // Crea un log en el sistema

      //Enviar correo
      $data =[
        'name' => $user->name,
        'email'=> $user->email,
        'caducidad'=> $request->suscription_end
      ];
      Mail::to($user->email)
      ->send(new NewSuscripDeposito($data));

       $dataC =[
            'name' => $user->fullName(),
            'suscription_init'=> date('Y-m-d'),
            'doc_number' => $user->doc_number,
            'phone' => $user->phone_number,
            'email'=> $user->email,
            'nro_comprobante' => $request->nro_comprobante,
            'gestor' => Auth()->user()->fullName(),
            'plan' => $plan->name,
            'precio' => $request->monto,
            'message'=>'Nueva Suscripción en Plataforma',
            'data' => 0,
            'moneda' => $plan->moneda,
          ];
          Mail::to('cobranzas@constructivo.com')
          ->cc('postmaster3@constructivo.com')
          ->send(new NewSuscripDepositoC($dataC));

      
      return response()->json(['message'=>'Registro exitoso'], 201);
    }


    // Metodo para actualizar el estado de comprobante de pago
    public function updateStatusComprobante($pago_id)
    { 
        $pago = Pago::find($pago_id);
        $pago->voucher_emit = 2;
        $pago->save();

        create_user_log('Emitió el comprobante del pagoId: '.$pago->id);

        return response()->json(['message' => '¡La actualización se realizó con éxito!', 'status' => 200]);
    }

    public function applyFilters(Request $request)
    { 
      $plan_id = $request->plan;
      $modpago_id = $request->modpago;
      $status = $request->status;

       

      $subscribers = SuscriptorDeposito::join('users', function ($join) {
            $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
                 ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
        })->where(function($query) use($plan_id, $modpago_id, $status){
       

        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }
        
      })
      ->with('user','pagos','plan','gestor')
      ->select('suscriptores_deposito.*')
      ->orderBy('id','DESC')->paginate(6);

       
       if(Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()){
         $subscribers = SuscriptorDeposito::where(function($query) use($plan_id, $modpago_id, $status){
        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }

      })
      ->with('user','pagos','plan','gestor')
      ->orderBy('id','DESC')->paginate(6);
         
       }



      foreach ($subscribers as $subs) {
        if($subs->suscription_end > date('Y-m-d')){
          $subs['status'] = 'Vigente';
        }else{
          $subs['status'] = 'Expirado';
        }
        
    // JHED SP-P
       $pagos = Pago::where('suscriptor_id','=',$subs->id)->orderBy('id','desc')->first();
      if ($pagos){ 
        $subs['pago_time'] = $pagos;
      }else{
        $subs['pago_time'] = [];
      }
        
      }

      return response()->json($subscribers);

    }


  //Filtro recurrente
  public function applyFiltersRecurrente(Request $request)
  {
    $plan_id = $request->plan;
    $modpago_id = $request->modpago;
    $status = $request->status;

    $subscribers = SuscriptorRecurrente::join('users as u', 'u.id', '=', 'suscriptores_recurrente.user_id')->select('suscriptores_recurrente.*')
      ->where(function ($query) use ($plan_id, $modpago_id, $status) {
        if ($plan_id != 0) {
          $query->where('plan_id', $plan_id);
        }

        if ($modpago_id != 0) {
          $query->where('metodopago_id', $modpago_id);
        }

        if ($status != 0) {
          $operator = '>'; // asumiendo que estado el 1
          if ($status == 2) $operator = '<';
          $query->where('suscription_end', $operator, date('Y-m-d'));
        }
      })
      ->with('user',  'plan')
      ->orderBy('suscriptores_recurrente.id', 'DESC')->paginate(15);

    return response()->json($subscribers);
  }


        public function applyFiltersCurso(Request $request)
    { 

      $curso_id=$request->curso;
      $responsable=$request->gestor;

      $subscribers = SuscriptorCursos::where(function($query) use($curso_id,$responsable){
        if($curso_id != 0){
          $query->where('curso_id',$curso_id);
        }

      
         if($responsable != ""){
          $query->where('responsable',$responsable);
        }
        
        

      })
      ->with('user','curso','user.role','gestor')
      ->orderBy('id','DESC')->paginate(15);

      return response()->json($subscribers);

    }

      //PAGO EFECTIVO
      public function applyFiltersPagoEfectivoCurso(Request $request)
      {
    
        $plan_id = $request->plan;
        $status_pago = $request->statuspago;
        $responsable = $request->gestor;
    
        $subscribers = SuscriptorEfectivo::join('users as u', 'u.id', '=', 'suscriptores_efectivo.user_id')->select('suscriptores_efectivo.*')
          ->where(function ($query) use ($plan_id, $status_pago, $responsable) {
            if ($plan_id != 0) {
              $query->where('plan_id', $plan_id);
            }
    
            if ($status_pago != 2) {
              $query->where('status_efectivo', $status_pago);
            }
    
            if ($responsable != "") {
              $query->where('responsable', $responsable);
            }
          })
          ->with('user', 'curso', 'user.role', 'gestor', 'plan')
          ->orderBy('suscriptores_efectivo.id', 'DESC')->paginate(15);
    
        return response()->json($subscribers);
      }
  
    public function applyFiltersCertificado(Request $request)
    { 

      $curso_id=$request->curso;

      $subscribers = CertificadoCurso::where(function($query) use($curso_id){
        if($curso_id != 0){
          $query->where('curso_id',$curso_id);
        }

      })
      ->with('user','curso','user.role')
      ->orderBy('id','DESC')->paginate(6);

      return response()->json($subscribers);

    }

    public function downloadDataFilterF(Request $request)
    {
      
      $asesor = $request->asesor;

      $subscribers = User::join('asignaciones as a', 'a.suscriptor_id','=','users.id')
    
      ->where(function($query) use($asesor){
         if($asesor != 0){
          $query->where('a.gestor_id',$asesor);
      }

      })
      ->where('a.is_confirmed',false)
      ->select('users.*')
      ->with('records.gestor','intereses.medio','asignacion.gestor')
      ->orderBy('a.id','desc')
      ->get();

      


      Excel::create('suscriptores-free',function($excel) use($subscribers){
        $excel->sheet('Suscriptores free',function($sheet) use ($subscribers){

          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'País',
            'N° telf.',
            'F. Registro',
            'Intereses',
            'Gestor'
          ]);

          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });


          // Datos en en archivo excel
          foreach ($subscribers as $index => $subs) {

            $sheet->row($index + 2, [
              $subs->fullName(),
              $subs->email,
              $subs->pais,
              $subs->phone_number,
              date('d/m/Y', strtotime($subs->created_at)),
              count($subs->intereses)==1  ?  $subs->intereses[0]->medio->name :  
              (count($subs->intereses)==2  ? $subs->intereses[0]->medio->name. '  y  ' .$subs->intereses[1]->medio->name : (count($subs->intereses)==3  ? $subs->intereses[0]->medio->name. ', ' .$subs->intereses[1]->medio->name. '  y  ' .$subs->intereses[2]->medio->name : ' ')),

              $subs->asignacion->gestor ? $subs->asignacion->gestor->fullName() : ' - ',
             ]);
          }

        });

    })->export('xls');



      // foreach ($subscribers as $subs) {
      //   if($subs->suscription_end > date('Y-m-d')){
      //     $subs['status'] = 'Vigente';
      //   }else{
      //     $subs['status'] = 'Expirado';
      //   }
        
      // }

      
      // return response()->json($subscribers);

    }
    
  public function downloadDataFreeFilter()
  {
    $suscriptores_free_query =  User::where('role_id', '=', 7)
      ->when(request('search') ?? null, function ($query, $buscar) {
        $query->where(function ($query) use ($buscar) {
          $query->where([[DB::raw('concat(name," ",last_name)'), 'like', '%' . $buscar . '%'], ['role_id', '=', 7]])
            ->orWhere([['email', 'like', '%' . $buscar . '%'], ['role_id', '=', 7]])
            ->orWhere([['phone_number', 'like', '%' . $buscar . '%'], ['role_id', '=', 7]]);
        });
      })->when(request('asesor') ?? null, function ($query, $asesor) {
        $query->join('asignaciones as a', 'a.suscriptor_id', '=', 'users.id')
          ->where([['a.gestor_id', $asesor], ['a.is_confirmed', false]]);
      })->select('users.*');

    $subscribers = $suscriptores_free_query->with('records.gestor', 'intereses.medio', 'asignacion.gestor')->orderBy('id',  'desc')->get();

    Excel::create('suscriptores-free', function ($excel) use ($subscribers) {
      $excel->sheet('Suscriptores free', function ($sheet) use ($subscribers) {

        // Cabecra del archivo excel
        $sheet->row(1, [
          'Nombres y apellidos',
          'Correo',
            //NEW
          'Acceso',
          'Profesión',
          'Edad',
          'País',
          'N° telf.',
          'F. Registro',
          'Intereses',
          'Gestor'
        ]);

        $sheet->row(1, function ($row) {
          // call cell manipulation methods
          $row->setBackground('#000000');
          $row->setFontColor('#FFFFFF');
        });


        // Datos en en archivo excel
        foreach ($subscribers as $index => $subs) {

            $acceso = "";
          if ($subs->socialProfiles == '[]') {
            $acceso = "email";
          } else {
            if ($subs->socialProfiles()->count() == 1) {
              if ($subs->email) {
                $acceso = "email, " . $subs->socialProfiles()->first()->social_name;
              } else {
                $acceso =  $subs->socialProfiles()->first()->social_name;
              }
            } else {
              if ($subs->email) {
                $acceso = "email, google y facebook";
              } else {
                $acceso = "google y facebook";
              }
            }
          }
          
             $nacimiento = new DateTime($subs->age);
          $ahora = new DateTime(date('Y-m-d'));
          $diferencia = $ahora->diff($nacimiento);
          $age = $diferencia->format('%y') . ' años';
          
          
          $sheet->row($index + 2, [
            $subs->fullName(),
            $subs->email,
            // $subs->socialProfiles == '[]' ? 'email' : $subs->socialProfiles()->first()->social_name,
            $acceso,
            $subs->profession ?  $subs->profession : ' - ',
            $subs->age ? $age : ' - ',
            $subs->pais,
            $subs->phone_number,
            date('d/m/Y', strtotime($subs->created_at)),
            count($subs->intereses) == 1  ?  $subs->intereses[0]->medio->name : (count($subs->intereses) == 2  ? $subs->intereses[0]->medio->name . '  y  ' . $subs->intereses[1]->medio->name : (count($subs->intereses) == 3  ? $subs->intereses[0]->medio->name . ', ' . $subs->intereses[1]->medio->name . '  y  ' . $subs->intereses[2]->medio->name : ' ')),

            // $subs->asignacion->gestor ? $subs->asignacion->gestor->fullName() : ' - ',
            $subs->asignacion ? $subs->asignacion->gestor->fullName() : ' - ',            
            // $subs->asignacion == null ? ' - ' : $subs->asignacion->gestor->fullName(),
          ]);
        }
      });
    })->export('xls');
  }

      public function downloadDataFilter(Request $request)
    {
      $plan_id = $request->plan;
      $modpago_id = $request->modpago;
      $status = $request->status;

      $subscribers = SuscriptorDeposito::join('users', function ($join) {
            $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
                 ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
        })->where(function($query) use($plan_id, $modpago_id, $status){
        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }

      })
      ->with('user','gestor')
      ->select('suscriptores_deposito.*')
      ->orderBy('id','Desc')->get();

       if(Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()){

        $subscribers = SuscriptorDeposito::where(function($query) use($plan_id, $modpago_id, $status){
        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }

      })
      ->with('user','gestor')
      ->orderBy('id','Desc')->get();

      }


      Excel::create('suscriptores-premium',function($excel) use($subscribers){
        $excel->sheet('Suscriptores premium',function($sheet) use ($subscribers){

          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'N° telf.',
            'Caducidad',
            'Medio',
            'Intereses',
            'Plan',
            'Nro. Comp.',
            'Monto',
            'Ult. Pago',
            'Estado',
            'Gestor'
          ]);

          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });


          // Datos en en archivo excel
          foreach ($subscribers as $index => $subs) {

            //JHED SP-P
          $pagos = Pago::where('suscriptor_id','=',$subs->id)->orderBy('id','desc')->first();
          if ($pagos){ 
            $subs['pago_nro_comprobante'] = $pagos->nro_comprobante;
            $subs['pago_time'] = $pagos->created_at;         
            $subs['pago_moneda'] =  $pagos->moneda;
            $subs['pago_monto'] = $pagos->monto;
          }
          
            $sheet->row($index + 2, [
              $subs->user->fullName(),
              $subs->user->email,
              $subs->user->phone_number,
              date('d/m/Y', strtotime($subs->suscription_end)),
              $subs->medio,
              count($subs->user->intereses)==1  ?  $subs->user->intereses[0]->medio->name :  
              (count($subs->user->intereses)==2  ? $subs->user->intereses[0]->medio->name. '  y  ' .$subs->user->intereses[1]->medio->name : (count($subs->user->intereses)==3  ? $subs->user->intereses[0]->medio->name. ', ' .$subs->user->intereses[1]->medio->name. '  y  ' .$subs->user->intereses[2]->medio->name : ' ')),
              'S/. '.$subs->plan->precio,
              $subs->pago_nro_comprobante,
            ($subs->pago_moneda == "PEN" ? 'S/. ' : '$ ') . $subs->pago_monto,
               date('d/m/Y', strtotime($subs->pago_time)),
              $subs->suscription_end > date('Y-m-d') ? 'Vigente' : 'Expirado',
              $subs->gestor->name,
            ]);
          }

        });

    })->export('xls');


      // foreach ($subscribers as $subs) {
      //   if($subs->suscription_end > date('Y-m-d')){
      //     $subs['status'] = 'Vigente';
      //   }else{
      //     $subs['status'] = 'Expirado';
      //   }
        
      // }

      
      // return response()->json($subscribers);

    }
    
    
  //New Export de Excel Deposito
  public function dowloadDataPremiumFilter()
  {  
    $suscriptores_premium_query =  SuscriptorDeposito::join('users', function ($join) {
      $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
        ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
      })->when(request('order') ?? 'new', function ($query, $order) {
        $sort = $order === 'new' ? 'desc' : 'asc';
        $query->orderBy('suscription_init',  $sort);
      })->when(request('search') ?? null, function ($query, $buscar) {
        $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
          ->where(function ($query) use ($buscar) {
            $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
              ->orWhere('u.email', 'like', '%' . $buscar . '%')
            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
          });
      })->when(request('plan') ?? null, function ($query, $plan) {
        $query->where('plan_id', $plan);
      })->when(request('modpago') ?? null, function ($query, $modpago_id) {
        $query->where('metodopago_id', $modpago_id);
      })->when(request('asesor') ?? null, function ($query, $asesor) {
        $query->where([['gestor_id', $asesor]]);
      })->when(request('status') ?? null, function ($query, $status) {
        if ($status == 1) {
          $query->where('suscription_end', '>', date('Y-m-d'));
        } else {
          $query->where('suscription_end', '<', date('Y-m-d'));
        }
      })->select('suscriptores_deposito.*');

    if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
      $suscriptores_premium_query =  SuscriptorDeposito::when(request('order') ?? 'new', function ($query, $order) {
        $sort = $order === 'new' ? 'desc' : 'asc';
        $query->orderBy('suscription_init',  $sort);
      })->when(request('search') ?? null, function ($query, $buscar) {
        $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
          ->where(function ($query) use ($buscar) {
            $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
              ->orWhere('u.email', 'like', '%' . $buscar . '%')
            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
          });
      })->when(request('plan') ?? null, function ($query, $plan) {
        $query->where('plan_id', $plan);
      })->when(request('modpago') ?? null, function ($query, $modpago_id) {
        $query->where('metodopago_id', $modpago_id);
      })->when(request('asesor') ?? null, function ($query, $asesor) {
        $query->where([['gestor_id', $asesor]]);
      })->when(request('status') ?? null, function ($query, $status) {
        if ($status == 1) {
          $query->where('suscription_end', '>', date('Y-m-d'));
        } else {
          $query->where('suscription_end', '<', date('Y-m-d'));
        }
      })->select('suscriptores_deposito.*');
    }

    // subscribers prmeium
    $subscribers = $suscriptores_premium_query->with('user', 'pagos', 'plan', 'gestor')->orderBy('id',  'desc')->get();

    Excel::create('suscriptores-premium', function ($excel) use ($subscribers) {
      $excel->sheet('Suscriptores premium', function ($sheet) use ($subscribers) {

        // Cabecra del archivo excel
        $sheet->row(1, [
          'Nombres y apellidos',
          'Correo',
          //NEW CABECERA
          // 'Acceso',
          'Dirección',
          'Cargo',
          'Profesión',
          'N° telf.',
          'Caducidad',
          'Medio',
          'Intereses',
          'Plan',
          'Nro. Comp.',
          'Nro. Oper.',
          'Monto',
          'Ult. Pago',
          'Estado',
          'Gestor'
        ]);

        $sheet->row(1, function ($row) {
          // call cell manipulation methods
          $row->setBackground('#000000');
          $row->setFontColor('#FFFFFF');
        });


        // Datos en en archivo excel
        foreach ($subscribers as $index => $subs) {

          //JHED SP-P
          $pagos = Pago::where('suscriptor_id', '=', $subs->id)->orderBy('id', 'desc')->first();
          if ($pagos) {
            $subs['pago_nro_comprobante'] = $pagos->nro_comprobante;
            $subs['pago_nro_operacion'] = $pagos->num_operacion;
            $subs['pago_time'] = $pagos->created_at;
            $subs['pago_moneda'] =  $pagos->moneda;
            $subs['pago_monto'] = $pagos->monto;
          }

          $sheet->row($index + 2, [
            $subs->user->fullName(),
            $subs->user->email, 
            // $acceso,
            $subs->user->address ?  $subs->user->address : ' - ',
            $subs->user->cargo_user ?  $subs->user->cargo_user : ' - ',
            $subs->user->profession ?  $subs->user->profession : ' - ',
            $subs->user->phone_number,
            date('d/m/Y', strtotime($subs->suscription_end)),
            $subs->medio,
            count($subs->user->intereses) == 1  ?  $subs->user->intereses[0]->medio->name : (count($subs->user->intereses) == 2  ? $subs->user->intereses[0]->medio->name . '  y  ' . $subs->user->intereses[1]->medio->name : (count($subs->user->intereses) == 3  ? $subs->user->intereses[0]->medio->name . ', ' . $subs->user->intereses[1]->medio->name . '  y  ' . $subs->user->intereses[2]->medio->name : ' ')),
            'S/. ' . $subs->plan->precio,
            $subs->pago_nro_comprobante,
            $subs->pago_nro_operacion,
            ($subs->pago_moneda == "PEN" ? 'S/. ' : '$ ') . $subs->pago_monto,
            date('d/m/Y', strtotime($subs->pago_time)),
            $subs->suscription_end > date('Y-m-d') ? 'Vigente' : 'Expirado',
            $subs->gestor->name,
          ]);
        }
      });
    })->export('xls');
  }

     public function downloadDataFilterCursos(Request $request)
    {
       $curso_id=$request->curso;
        $responsable=$request->gestor;


      $subscribers = SuscriptorCursos::where(function($query) use($curso_id,$responsable){
        if($curso_id != 0){
          $query->where('curso_id',$curso_id);
        }
        if($responsable != ""){
          $query->where('responsable',$responsable);
        }
        

      })
      ->with('user','curso','user.role','gestor')
      ->orderBy('id','DESC')->get();


      Excel::create('suscriptores-cursos',function($excel) use($subscribers){
        $excel->sheet('Suscriptores cursos',function($sheet) use ($subscribers){

          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'N° telf.',
            'F. Suscripción',
            'Curso',
            'Nro comprobante',
            'Tipo de usurio',
            'Gestor'
          ]);

          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });


          // Datos en en archivo excel
          foreach ($subscribers as $index => $subs) {

            $sheet->row($index + 2, [
              $subs->user->fullName(),
              $subs->user->email,
              $subs->user->phone_number,
              date('d/m/Y', strtotime($subs->created_at)),
              $subs->curso->titulo,
              $subs->nro_comprobante,
              $subs->user->role->name,
              
              $subs->gestor != "" ? $subs->gestor->name: 'Gestor no encontrado',
            ]);
          }

        });

    })->export('xls');


      // foreach ($subscribers as $subs) {
      //   if($subs->suscription_end > date('Y-m-d')){
      //     $subs['status'] = 'Vigente';
      //   }else{
      //     $subs['status'] = 'Expirado';
      //   }
        
      // }

      
      // return response()->json($subscribers);

    }
    
    
  //New Export de EXcel
  public function dowloadDataCursoFilter()
  {
    $suscriptores_cursos_query =  SuscriptorCursos::when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('created_at',  $sort);
    })->when(request('search') ?? null, function ($query, $buscar) {
      $query->join('users as u', 'u.id', '=', 'suscriptores_cursos.user_id')
        ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
        ->orWhere('u.email', 'like', '%' . $buscar . '%');
    })->when(request('curso') ?? null, function ($query, $curso_id) {
      $query->where('curso_id', $curso_id);
    })->when(request('gestor') ?? null, function ($query, $responsable) {
      $query->where('responsable', $responsable);
    })->select('suscriptores_cursos.*');
  
    $subscribers = $suscriptores_cursos_query->with('user', 'curso', 'user.role', 'gestor')->get(); 

    Excel::create('suscriptores-cursos', function ($excel) use ($subscribers) {
      $excel->sheet('Suscriptores cursos', function ($sheet) use ($subscribers) {

        // Cabecra del archivo excel
        $sheet->row(1, [
          'Nombres y apellidos',
          'Correo',
           // 'Acceso',
          'Dirección',
          'Cargo',
          'Profesión',
          'N° telf.',
          'F. Suscripción',
          'Curso',
          'Monto',
          'Nro comprobante',
          'Nro operación',
          'Tipo de usurio',
          'Gestor'
        ]);

        $sheet->row(1, function ($row) {
          // call cell manipulation methods
          $row->setBackground('#000000');
          $row->setFontColor('#FFFFFF');
        });


        // Datos en en archivo excel
        foreach ($subscribers as $index => $subs) {

          $sheet->row($index + 2, [
            $subs->user->fullName(),
            $subs->user->email,
            // $acceso,
            $subs->user->address ?  $subs->user->address : ' - ',
            $subs->user->cargo_user ?  $subs->user->cargo_user : ' - ',
            $subs->user->profession ?  $subs->user->profession : ' - ',
            $subs->user->phone_number,
            date('d/m/Y', strtotime($subs->created_at)),
            $subs->curso->titulo,
            $subs->pago_monto,
            $subs->nro_comprobante,
            $subs->num_operacion,
            $subs->user->role->name,

            $subs->gestor != "" ? $subs->gestor->name : 'Gestor no encontrado',
          ]);
        }
      });
    })->export('xls');
  }
 

    public function downloadDataFilterR(Request $request)
    {
      $plan_id = $request->plan;
      $modpago_id = $request->modpago;
      $status = $request->status;

      $subscribers = SuscriptorRecurrente::where(function($query) use($plan_id, $modpago_id, $status){
        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }

      })
      ->with('user')
      ->orderBy('id','Desc')->get();


      Excel::create('suscriptores-premium-recurrente',function($excel) use($subscribers){
        $excel->sheet('Suscriptores premium recurrente',function($sheet) use ($subscribers){
          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'N° telf.',
            'Medio',
            'Intereses',
            'Plan',
            'Monto',
            'Fecha de inicio',
          ]);
          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });
          // Datos en en archivo excel
          foreach ($subscribers as $index => $subs) {

            $sheet->row($index + 2, [
              $subs->user->fullName(),
              $subs->user->email,
              $subs->user->phone_number,
              $subs->medio,
              count($subs->user->intereses)==1  ?  $subs->user->intereses[0]->medio->name :  
              (count($subs->user->intereses)==2  ? $subs->user->intereses[0]->medio->name. '  y  ' .$subs->user->intereses[1]->medio->name : (count($subs->user->intereses)==3  ? $subs->user->intereses[0]->medio->name. ', ' .$subs->user->intereses[1]->medio->name. '  y  ' .$subs->user->intereses[2]->medio->name : ' ')),
              $subs->plan->name,
              $subs->monto .'  ('.$subs->plan->moneda.')',
              date('d/m/Y', strtotime($subs->suscription_init)),
              
            ]);
          }

        });

    })->export('xls');
    }
    
  //New Export de EXcel
  public function dowloadDataRecurrenteFilter()
  {
   //Version 1
    $suscriptores_recurrente_query =  SuscriptorRecurrente::when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('suscription_init',  $sort);
    })->when(request('search') ?? null, function ($query, $buscar) {
      // $query->join('users as u', 'u.id', '=', 'suscriptores_recurrente.user_id')
      //   ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
      //   ->orWhere('u.email', 'like', '%' . $buscar . '%');
      $query->join('users as u', 'u.id', '=', 'suscriptores_recurrente.user_id')
        ->where(function ($query) use ($buscar) {
          $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
            ->orWhere('u.email', 'like', '%' . $buscar . '%')
            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
        });
    })->when(request('plan') ?? null, function ($query, $plan) {
      $query->where('plan_id', $plan);
    })->when(request('modpago') ?? null, function ($query, $modpago_id) {
      $query->where('metodopago_id', $modpago_id);
    })->when(request('status') ?? null, function ($query, $status) {
      if ($status == 1) {
        $query->where('suscription_end', '>', date('Y-m-d'));
      } else {
        $query->where('suscription_end', '<', date('Y-m-d'));
      }
    })->select('suscriptores_recurrente.*');

    $subscribers = $suscriptores_recurrente_query->with('plan')->orderBy('id',  'desc')->get();


    Excel::create('suscriptores-premium-recurrente', function ($excel) use ($subscribers) {
      $excel->sheet('Suscriptores premium recurrente', function ($sheet) use ($subscribers) {
        // Cabecra del archivo excel
        $sheet->row(1, [
          'Nombres y apellidos',
          'Correo',
          'N° telf.',
          'Medio',
          'Intereses',
          'Plan',
          'Monto',
          'Fecha de inicio',
        ]);
        $sheet->row(1, function ($row) {
          // call cell manipulation methods
          $row->setBackground('#000000');
          $row->setFontColor('#FFFFFF');
        });
        // Datos en en archivo excel
        foreach ($subscribers as $index => $subs) {

          $sheet->row($index + 2, [
            $subs->user->fullName(),
            $subs->user->email,
            $subs->user->phone_number,
            $subs->medio,
            count($subs->user->intereses) == 1  ?  $subs->user->intereses[0]->medio->name : (count($subs->user->intereses) == 2  ? $subs->user->intereses[0]->medio->name . '  y  ' . $subs->user->intereses[1]->medio->name : (count($subs->user->intereses) == 3  ? $subs->user->intereses[0]->medio->name . ', ' . $subs->user->intereses[1]->medio->name . '  y  ' . $subs->user->intereses[2]->medio->name : ' ')),
            $subs->plan->name,
            $subs->monto . '  (' . $subs->plan->moneda . ')',
            date('d/m/Y', strtotime($subs->suscription_init)),

          ]);
        }
      });
    })->export('xls');
  }

    public function downloadDataFilterS(Request $request)
    {
      $plan_id = $request->plan;
      $modpago_id = $request->modpago;
      $status = $request->status;
     

      $subscribers = Asignacion::where(function($query) use($plan_id, $modpago_id, $status){
        if($plan_id != 0){
          $query->where('plan_id',$plan_id);
        }

        if($modpago_id != 0 ){
          $query->where('metodopago_id',$modpago_id);
        }

        if($status != 0){
          $operator = '>'; // asumiendo que estado el 1
          if($status == 2) $operator = '<';
          $query->where('suscription_end',$operator, date('Y-m-d'));
        }

      })
      ->where([['gestor_id',Auth()->user()->id],['is_confirmed',false]])
      ->with('suscriptor.intereses.medio')
      ->orderBy('id','Desc')->get();


      Excel::create('suscriptores-asignados',function($excel) use($subscribers){
        $excel->sheet('Suscriptores asignados',function($sheet) use ($subscribers){

          // Cabecra del archivo excel
          $sheet->row(1,[
            'Nombres y apellidos',
            'Correo',
            'N° telf.',
            'F. Registro',
            'Intereses',
            
          ]);

          $sheet->row(1, function($row) {
              // call cell manipulation methods
              $row->setBackground('#000000');
              $row->setFontColor('#FFFFFF');
          });

          
          // Datos en en archivo excel
          foreach ($subscribers as $index => $subs) {

            $sheet->row($index + 2, [
              $subs->suscriptor->fullName(),
              $subs->suscriptor->email,
              $subs->suscriptor->phone_number,
              date('d/m/Y', strtotime($subs->created_at)),
              count($subs->suscriptor->intereses)==1  ?  $subs->suscriptor->intereses[0]->medio->name :  
              (count($subs->suscriptor->intereses)==2  ? $subs->suscriptor->intereses[0]->medio->name. '  y  ' .$subs->suscriptor->intereses[1]->medio->name : (count($subs->suscriptor->intereses)==3  ? $subs->suscriptor->intereses[0]->medio->name. ', ' .$subs->suscriptor->intereses[1]->medio->name. '  y  ' .$subs->suscriptor->intereses[2]->medio->name : ' ')),
              
              
            ]);
          }

        });


    })->export('xls');

    }
    
}
