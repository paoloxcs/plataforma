<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Mail\NewSuscripDeposito;
use App\Mail\NewSuscripDepositoC;
use App\Mail\updateCaducidad;
use App\MetodoPago;
use App\Pago;
use App\Plan;
use App\Rubro;
use App\SuscriptorCursos;
use App\SuscriptorDeposito;
use App\SuscriptorYape;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;

class SusbYapeController extends Controller
{
   public function index()
    {
    // $planes = Plan::where('status', 1)->get();
    $planes = Plan::where('status', 1)->orderBy('status', 'desc')->get();
    // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
    $planes_off = Plan::where('id_culqi', '!=', null)->where('status', 0)->orderBy('status', 'desc')->get();

    $subsYape_query =  SuscriptorYape::join('users as u', 'u.id', '=', 'suscriptores_yape.user_id')->when(request('order') ?? 'new', function ($query, $order) {
      $sort = $order === 'new' ? 'desc' : 'asc';
      $query->orderBy('id',  $sort);
    })->when(request('search') ?? null, function ($query, $buscar) {
      $query->where(function ($query) use ($buscar) {
        $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
          ->orWhere('u.email', 'like', '%' . $buscar . '%')
          ->orWhere('telefono', 'like', '%' . $buscar . '%')
          ->orWhere('dni', 'like', '%' . $buscar . '%');
      });
    })->when(request('plan') ?? null, function ($query, $plan) {
      $query->where('plan_id', $plan);
    })->when(request('asesor') ?? null, function ($query, $asesor) {
      $query->where([['gestor_id', $asesor]]);
    })->select('suscriptores_yape.*');

    $subsYape = $subsYape_query->with('user', 'curso', 'user.role', 'gestor', 'plan')->paginate(10);
    $subsYape_count = $subsYape_query->count();

    if (request('count_yape')) {
      $subsYape_count = request('count_free');
    }

    return view('panel.subscriber.yape.index', compact('subsYape', 'subsYape_count', 'planes', 'planes_off'));
  }

   public function getPagoYapeData(Request $request)
   {
    // $subscribers = SuscriptorEfectivo::with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('id', 'desc')->where('gestor_id', Auth()->user()->id)->orWhere('gestor_id', '18207')->paginate(6);
    $subscribers = SuscriptorYape::join('users as u', 'u.id', '=', 'suscriptores_yape.user_id')
                    ->select('suscriptores_yape.*')
                    ->with('user', 'pagos', 'plan', 'gestor', 'curso')
                    ->latest('suscriptores_yape.id')
                    ->paginate(6);
    // if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
    //   $subscribers = SuscriptorEfectivo::with('user', 'pagos', 'plan', 'gestor', 'curso')->orderBy('id', 'desc')->paginate(6);
    // } 
    foreach ($subscribers as $subs) {
      // if (User::where('id', $subs->user_id)->get()) {
      if ($subs->suscription_end < date('Y-m-d')) {
        $subs['status'] = 'Expirado';
      } else {
        $subs['status'] = 'Vigente';
      }
      // }

      // formatea la fecha 
      /*$subs->suscription_end = date('d/m/Y', strtotime($subs->suscription_end));*/
    }

    return response()->json($subscribers);
  }

  public function searchPagoYapeCurso(Request $request)
  {
    $texto = $request->text;

    $subscribers = SuscriptorYape::join('users as u', 'u.id', '=', 'suscriptores_yape.user_id')->with('user', 'curso', 'user.role', 'gestor', 'plan')
      ->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $texto . '%')
      ->orWhere('u.email', 'like', '%' . $texto . '%')
      ->orWhere('suscriptores_yape.codigo_verification', 'like', '%' . $texto . '%')
      ->select('suscriptores_yape.*')
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

  public function getPlanGestorJSON()
  {
    $planes = Plan::where('status','=',1)->get();
    foreach ($planes as $plan) {
      // Definiendo proxima fecha de caducidad
      $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( date('Y-m-d')));
      $plan['caduca'] = date('Y-m-d',$nuevafecha);
    } 

    // 8=>Suscription Support ; 6=>Suscription Manager
    $users = User::where('role_id',8)->orWhere('role_id',6)->get();

    return response()->json(['planes'=>$planes,'gestores'=>$users]);    
   // return response()->json($planes);
  }

  public function getCursosData()
  {
    $cursos = Curso::Where('estado', 1)->get();

    $users = User::where('role_id', 8)->orWhere('role_id', 6)->get();

    // return response()->json($cursos);
    // 8=>Suscription Support ; 6=>Suscription Manager
    return response()->json(['cursos' => $cursos, 'gestores' => $users]);
  }

  public function storePagoYapePremium(Request $request, $id)
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

        $metodo_pago = MetodoPago::where('name', 'Yape')->first();
        if(!$metodo_pago){  
            $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Yape']);
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
 
        $suscriptor_yape = SuscriptorYape::find($request->suscriptor_yape_id);
        $suscriptor_yape->delete();

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

            $metodo_pago = MetodoPago::where('name', 'Yape')->first();
            if(!$metodo_pago){  
                $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Yape']);
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
 
        $suscriptor_yape = SuscriptorYape::find($request->suscriptor_yape_id);
        $suscriptor_yape->delete();

        create_user_log('Actualizó los datos de '.strtoupper($user->fullName()));

        return response()->json(['message'=>'Actualizacion exitosa','status'=>200]);
      }
       
    }
  }


  public function destroyPagoYape($id)
  {
    $suscrip = SuscriptorYape::find($id);
    $suscrip->delete();

    // create_user_log('Anuló la suscripción del curso ' . strtoupper($suscrip->curso->titulo) . ' a ' . strtoupper($suscrip->user->fullName()));

    return response()->json(['message' => 'Suscripcion o Curso anulada', 'status' => 200]);
  }
 
  public function applyFiltersPagoYapeCurso(Request $request)
  {

    $plan_id = $request->plan;
    $status_pago = $request->statuspago;
    $responsable = $request->gestor;

    $subscribers = SuscriptorYape::join('users as u', 'u.id', '=', 'suscriptores_yape.user_id')->select('suscriptores_yape.*')
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
      ->orderBy('suscriptores_yape.id', 'DESC')->paginate(15);

    return response()->json($subscribers);
  }
  
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

        $metodo_pago = MetodoPago::where('name', 'Yape')->first();
        if(!$metodo_pago){  
            $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Yape']);
        }

        $suscrip = new SuscriptorDeposito();
        $suscrip->user_id = $usr->id;
        $suscrip->plan_id = $plan->id;
        $suscrip->suscription_init = date('Y-m-d');
        $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
        $suscrip->medio = 'RC';
        $suscrip->tipo = 'D';
        $suscrip->metodopago_id = $metodo_pago->id;
        $suscrip->gestor_id = $request->gestor_a;
        $suscrip->save();


        //Guardando pago
        Pago::create([
          'suscriptor_id' =>  $suscrip->id,
          'monto'         =>  0.00,
          'moneda'         =>  $plan->moneda,
          'nro_comprobante' => 'COMPRA_CURSO',
          'metodopago_id' =>  $metodo_pago->id,
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
        'id_culqi' => "NO HAY",
        'suscription_end' => date('Y-m-d', $nuevafecha),
        'nro_comprobante' =>  $request->nro_comprobante,
        'responsable' => $request->gestor_a,
        'moneda' => $request->moneda,
      ]);
    } else { 
      $suscriptor = SuscriptorCursos::create([
        'user_id' => $user->id,
        'curso_id' =>  $curso->id,
        'id_culqi' => "NO HAY",
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

    // $suscriptorefectivo =  SuscriptorEfectivo::where('id',  $request->pago_id)
    // ->update([
    //   'gestor_id' =>  $gestor->id,
    //   'status_efectivo' => "1"
    // ]);
    
    $suscriptor_yape = SuscriptorYape::where('id',$request->suscriptor_yape_id)->first();
    $suscriptor_yape->delete();

    return response()->json(['message' => 'Asignación exitosa'], 200);
 
  }
  
  // METODO DE WEB
public function pay_curso_yape(Request $request)
{
    $validation = \Validator::make($request->all(),[
        'dni'=>'required|numeric',
        'phoneNumber'=>'required|numeric',
    ]);
    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors(), 'status' => 422]);
    } else {
        
        $codigo = Str::random(10);

        $curso = Curso::find($request->CursoId);
        // $curso = Curso::where('slug', $request->slug)->with('autor', 'rubro')->first();
        $user = Auth()->user();
        // $rubro = Rubro::where('idrubro', $curso->rubro_id)->first(); 
        $plan = Plan::where('id', '2')->first();
        
            $metodo_pago = MetodoPago::where('name','Yape')->first();
            if(!$metodo_pago){  
                $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Yape']);
            }
         
            $suscrip = new SuscriptorYape();
            $suscrip->user_id = $user->id;
            $suscrip->plan_id = $plan->id;
            $suscrip->curso_id =  $curso->id; 
            $suscrip->suscription_init = date('Y-m-d');
            $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
            $suscrip->medio = 'RC';
            $suscrip->dni =  $request->dni;             
            $suscrip->telefono =  $request->phoneNumber; 
            $suscrip->codigo_verification =  $codigo; 
            $suscrip->tipo = 'D';
            $suscrip->tipo_susc = 'C'; // C --> curso | R --> recurrente
            $suscrip->metodopago_id = $metodo_pago->id; //Pago Yape
            $suscrip->gestor_id = '18207';
            $suscrip->save();

        return response()->json(['message'=>'Solicitud enviada','codigo'=>$codigo,'status'=>200]);
            
    }
}

public function pay_susc_yape(Request $request)
{   
    $validation = \Validator::make($request->all(),[
        'dni'=>'required|numeric',
        'phoneNumber'=>'required|numeric',
    ]);
    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors(), 'status' => 422]);
    } else {
        
        $codigo = Str::random(10);

        $plan = Plan::where('slug', $request->slug)->first(); 
        // $curso = Curso::find($request->CursoId);
        // $curso = Curso::where('slug', $request->slug)->with('autor', 'rubro')->first();
        $curso = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->first();
        $user = Auth()->user();
        // $rubro = Rubro::where('idrubro', $curso->rubro_id)->first(); 
        // $plan = Plan::where('id', '2')->first(); 

            $metodo_pago = MetodoPago::where('name','Yape')->first();
            if(!$metodo_pago){  
                $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Yape']);
            }
         
            $suscrip = new SuscriptorYape();
            $suscrip->user_id = $user->id;
            $suscrip->plan_id = $plan->id;
            $suscrip->curso_id =  $curso->id; 
            $suscrip->suscription_init = date('Y-m-d');
            $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
            $suscrip->medio = 'RC';
            $suscrip->dni =  $request->dni;             
            $suscrip->telefono =  $request->phoneNumber; 
            $suscrip->codigo_verification =  $codigo; 
            $suscrip->tipo = 'D';
            $suscrip->tipo_susc = 'P'; // C --> curso | R --> recurrente | P --> primiun
            $suscrip->metodopago_id = $metodo_pago->id; //Pago Yape
            $suscrip->gestor_id = '18207';
            $suscrip->save();

        return response()->json(['message'=>'Solicitud enviada','codigo'=>$codigo,'status'=>200]);
            
    }
  }

    
}
