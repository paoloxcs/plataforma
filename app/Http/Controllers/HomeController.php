<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\Cliente;
use App\Ejecutivo;
use App\Mail\ReportBug;
use App\Mail\Sorteo;
use App\Mail\sendContacto;
use App\MetodoPago;
use App\Plan;
use App\Post;
use App\Role;
use App\Curso;
use App\SuscriptorDeposito;
use App\User;
use Culqi\Culqi;
use Culqi\CulqiException;
use App\Mail\NewSuscripDepositoC;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Requests;
use Session;
use App\Mail\SusCursoM;
use App\SuscriptorCursos;

class HomeController extends Controller
{

  /* Declaración de Variables para Culqi */
     protected $SECRET_API_KEY = "";
     protected $culqi = null;

    /* Deteminación del método constructor */
    public function __construct()
    {
        /* Invocación de dependencia requests para Culqi */
        Requests::register_autoloader();
       
        /* Autenticación al API de Culqi */
       $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c";/*/
      /* $this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN";*/
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY));

    }
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (show_btnPanel()) {

          $ejecutivos = Ejecutivo::with('clientes')->get();
            $posts = Post::all();
            $roles = Role::all();
            $users = User::all();

            return view('panel.index',compact('posts','users','roles','ejecutivos'));
        }else{
            return redirect('/');
        }
    }
    
    public function getcategs($id){ // Retorna lista de categorias del rubro elegido
        $categs = DB::table('categoria')
        ->where('idrubro','=',$id)
        ->select()->orderBy('nombrecategoria','ASC')->get();
        return response()->json($categs);
    }
    public function getsubcates($id){ // Retorna lista de subcategorias de la categoria elegida
        $subcates = DB::table('subcategoria')
        ->where('idcategoria','=',$id)
        ->select()->get();

        return response()->json($subcates);
    }
    public function sendReportbug(Request $request)
    {
        $this->validate($request,[
            'asunto'=> 'required|string|max:255',
            'mensaje'=> 'required|string'
        ]);

        $data =[
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'username'  => Auth()->user()->fullName()
        ];

            Mail::to('postmaster2@constructivo.com')
            ->send(new ReportBug($data));

        return back()->with('msg','Su mensaje fue enviado con éxito!');
    }

    // CONTACTO
    public function sendContacto(Request $request)
    {
        $this->validate($request,[
            'nombre'=> 'required|string|max:255',
            'correo'=> 'required|email',
            'telf'=> 'required|string|max:20',
            'mensaje'=>'required|string'
        ]);

        $data =[
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telf' => $request->telf,
            'mensaje' => $request->mensaje,
        ];

            Mail::to('postmaster2@constructivo.com')
            ->send(new sendContacto($data));

        return back()->with('msg','Su mensaje fue enviado con éxito!');
    }
    public function asignateTo(Request $request)
    {
        $asign = Asignacion::create([
            'suscriptor_id' =>  $request->user_id,
            'gestor_id'     =>  $request->gestor
        ]);

        create_user_log('Asignó a '.strtoupper($asign->gestor->name).' al suscriptor '.strtoupper($asign->suscriptor->fullName()));


        return response()->json(['message'=>'Asignación exitosa'], 200);

    }

      public function asignatecurso(Request $request)
    {

        /*$asign = Asignacion::create([
            'suscriptor_id' =>  $request->user_id,
            'gestor_id'     =>  $request->gestor
        ]);*/

        $curso=Curso::where('id',$request->gestor)->first();
        $user=User::where('id',$request->user_id)->first();
        $gestor=User::where('id',$request->gestor_a)->first();
              

        if (Auth()->user()->role_id==6 OR Auth()->user()->role_id==8 OR Auth()->user()->role_id==1){

          $suscrito= SuscriptorCursos::where('user_id',$request->user_id)->where('curso_id',$request->gestor)->count();
          if($suscrito>0){

            return response()->json(['message'=>'El Usuario ya se suscribió anteriormente'], 200);
          }
          else{

                    if ($request->cortesia==1){

                        if($curso->expira>date('Y-m-d')){

                              if($curso->fecha_culminacion<date('Y-m-d')){

                                      if($curso->precio_c==Null or $curso->precio_c=="" ){

                                        return response()->json(['message'=>'El curso no tiene precio culminado'], 200);
                                      }

                                        $nuevafecha = strtotime ( '+ 1 month' , strtotime ( date('Y-m-d')));

                                        $suscriptor = SuscriptorCursos::create([
                                          /*'user_id' =>  Auth()->user()->id,*/
                                          'user_id' =>  $request->user_id,
                                          'curso_id' =>  $request->gestor,
                                          'nro_comprobante' =>  $request->nro_comprobante,
                //Nuevos Campos requeridos
                'num_operacion' =>  $request->num_operacion,
                'pago_monto' =>  $request->pago_monto,
                                          'id_culqi' => "Null",
                                          'suscription_end' => date('Y-m-d',$nuevafecha),
                                          'moneda' => $request->moneda,
                                          'responsable' => $request->gestor_a
                                          ]);



                                         if($user->role_id==2){

                                            $precio=$curso->promocion_c;
                                         }
                                         else{
                                              $precio=$curso->precio_c;                                     
                                         }

                                        $data =[
                                          'name'  => $user->name,
                                          'email' => $user->email,
                                          'curso'  => $curso->titulo,
                                          'amount'=> $precio,
                                          'moneda' => "PEN",
                                          'rubro' =>$curso->rubro->nombrerubro,
                                          'slug'=>$curso->slug,
                                          'user_message' => 'participación con éxito'
                                        ];

                                         Mail::to($user->email)
                                        ->cc(['info@constructivo.com','postmaster3@constructivo.com'])
                                        ->send(new SusCursoM($data));
                                
                                        //Enviar correo
                                        $dataC =[
                                        'name' => $user->fullName(),
                                        'suscription_init'=> date('Y-m-d'),
                                        'doc_number' => $user->doc_number,
                                        'phone' => $user->phone_number,
                                        'email'=> $user->email,
                                        'nro_comprobante' => $request->nro_comprobante,
                //Nuevos Campos requeridos
                'num_operacion' =>  $request->num_operacion,
                'pago_monto' =>  $request->pago_monto,
                                        'gestor' => $gestor->fullName(),
                                        'plan' => $curso->titulo,
                                        'precio' => $precio,
                                        'moneda' => $request->moneda,
                                        'message' => 'Nueva suscripción en Curso de Plataforma',
                                        'data'=>1,
                                        ];

                                        Mail::to('cobranzas@constructivo.com')
                                        ->cc('postmaster3@constructivo.com')
                                        ->send(new NewSuscripDepositoC($dataC)); 



                                        return response()->json(['message'=>'Asignación exitosa'], 200);
                                     
                               
                              }
                              else
                              {
                                //cuando no está culminado

                                    $suscriptor = SuscriptorCursos::create([
                                      /*'user_id' =>  Auth()->user()->id,*/
                                      'user_id' =>  $request->user_id,
                                      'curso_id' =>  $request->gestor,
                                      'nro_comprobante' =>  $request->nro_comprobante,
                //Nuevos Campos requeridos
                'num_operacion' =>  $request->num_operacion,
                'pago_monto' =>  $request->pago_monto,
                                      'id_culqi' => "Null",
                                      'moneda' => $request->moneda,
                                      'responsable' => $request->gestor_a
                                    ]);

                                      if($user->role_id==2){
                                        if($request->moneda=="PEN"){
                                            $precio=$curso->promocion;
                                        }
                                        else{
                                          $precio=$curso->promocion_d;
                                        }
                                    
                                     }
                                     else{
                                       if($request->moneda=="PEN"){
                                            $precio=$curso->precio;
                                        }
                                        else{
                                          $precio=$curso->precio_d;
                                        }
                                     }


                                    $data =[
                                      'name'  => $user->name,
                                      'email' => $user->email,
                                      'curso'  => $curso->titulo,
                                      'amount'=> $precio,
                                      'moneda' => $request->moneda,
                                      'rubro' =>$curso->rubro->nombrerubro,
                                      'slug'=>$curso->slug,
                                      'user_message' => 'participación con éxito'
                                    ];

                                     Mail::to($user->email)
                                    ->cc(['info@constructivo.com','postmaster3@constructivo.com'])
                                    ->send(new SusCursoM($data));
                            
                                    //Enviar correo
                                    $dataC =[
                                    'name' => $user->fullName(),
                                    'suscription_init'=> date('Y-m-d'),
                                    'doc_number' => $user->doc_number,
                                    'phone' => $user->phone_number,
                                    'email'=> $user->email,
                                    'nro_comprobante' => $request->nro_comprobante,
                                    'gestor' => $gestor->fullName(),
                                    'plan' => $curso->titulo,
                                    'precio' => $precio,
                                    'moneda' => $request->moneda,
                                    'message' => 'Nueva suscripción en Curso de Plataforma',
                                    'data'=>1,
                                    ];
                                      Mail::to('cobranzas@constructivo.com')
                                      ->cc('postmaster3@constructivo.com')
                                      ->send(new NewSuscripDepositoC($dataC));  



                                    return response()->json(['message'=>'Asignación exitosa'], 200);



                                
                              }
                            
                        }else{
                            return response()->json(['message'=>'El curso está expirado'], 200);
                        }

                    }
                    else{
                      //GRATIS curso

                      /*$scursoscomprados=  SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','1')->where('created_at','>','2020-10-23')->count();

                      $scursosgratis=  SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','0')->where('created_at','>','2020-10-23')->count();
                       //$suscritogratis= SuscriptorCursos::where('user_id',$request->user_id)->where('compra','=','0')->count();
                       if ($scursosgratis>=$scursoscomprados) {
                          
                        return response()->json(['message'=>'El Usuario ya exedió el número de cursos gratis'], 200);
                       }else{*/

                          $nuevafecha = strtotime ( '+ 1 month' , strtotime ( date('Y-m-d')));

                           $suscriptor = SuscriptorCursos::create([
                          /*'user_id' =>  Auth()->user()->id,*/
                          'user_id' =>  $request->user_id,
                          'curso_id' =>  $request->gestor,
                          'nro_comprobante' =>  $request->nro_comprobante,
                          'id_culqi' => "Null",
                          'compra' => "0",
                          'suscription_end' => date('Y-m-d',$nuevafecha),
                          'responsable' => $request->gestor_a
                          ]);
                      
                          


                         /*if($user->role_id==2){

                            $data =[
                              'name'  => $user->name,
                              'email' => $user->email,
                              'curso'  => $curso->titulo,
                              'amount'=> '00',
                              'moneda' => $request->moneda,
                              'rubro' =>$curso->rubro->nombrerubro,
                              'slug'=>$curso->slug,
                              'user_message' => 'participación con éxito'
                            ];

                             Mail::to($user->email)
                            ->cc(['info@constructivo.com','postmaster3@constructivo.com'])
                            ->send(new SusCursoM($data));
                    
                            //Enviar correo
                          $dataC =[
                            'name' => $user->fullName(),
                            'suscription_init'=> date('Y-m-d'),
                            'doc_number' => $user->doc_number,
                            'phone' => $user->phone_number,
                            'email'=> $user->email,
                            'nro_comprobante' => $request->nro_comprobante,
                            'gestor' => Auth()->user()->fullName(),
                            'plan' => $curso->titulo,
                            'precio' => '00',
                            'moneda' => $request->moneda,
                            'message' => 'Nueva suscripción en Curso de Plataforma',
                            'data'=>1,
                          ];
                          Mail::to('cobranzas@constructivo.com')
                          ->cc('postmaster3@constructivo.com')
                          ->send(new NewSuscripDepositoC($dataC));  


                          }
                          else{*/

                             $data =[
                              'name'  => $user->name,
                              'email' => $user->email,
                              'curso'  => $curso->titulo,
                              'amount'=> '00',
                              'moneda' => $request->moneda,
                              'rubro' =>$curso->rubro->nombrerubro,
                              'slug'=>$curso->slug,
                              'user_message' => 'participación con éxito'
                            ];

                            Mail::to($user->email)
                            ->cc('info@constructivo.com')
                            ->send(new SusCursoM($data));


                            $dataC =[
                            'name' => $user->fullName(),
                            'suscription_init'=> date('Y-m-d'),
                            'doc_number' => $user->doc_number,
                            'phone' => $user->phone_number,
                            'email'=> $user->email,
                            'nro_comprobante' => $request->nro_comprobante,
                            'gestor' => $gestor->fullName(),
                            'plan' => $curso->titulo,
                            'precio' => '00',
                            'moneda' => $request->moneda,
                            'message' => 'Nueva suscripción en Curso de Plataforma',
                            'data'=>1,
                          ];
                          Mail::to('cobranzas@constructivo.com')
                          ->cc('postmaster3@constructivo.com')
                          ->send(new NewSuscripDepositoC($dataC)); 

                         // }

                        return response()->json(['message'=>'Asignación exitosa'], 200);



                      // }
                    }
              }
        }
        else
        {

          return response()->json(['message'=>'No tienes acceso para realizar este proceso'], 200);
        }


       


    }
    public function destryoAsignation($id)
    {
        $asignacion = Asignacion::where('suscriptor_id','=',$id)->first();

        create_user_log('Quitó al suscriptor '.strtoupper($asignacion->suscriptor->fullName()).' de la bandeja de '.strtoupper($asignacion->gestor->name));

        $asignacion->delete();

        return response()->json(['message'=>'Desasignación exitosa'], 200);
    }


    public function getPlanesJSON()
    {
        $planes = Plan::where('status','=',1)->get();
        foreach ($planes as $plan) {
          // Definiendo proxima fecha de caducidad
          $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( date('Y-m-d')));
          $plan['caduca'] = date('Y-m-d',$nuevafecha);
        }
        
        return response()->json($planes);
    }
    public function getPlanesGestorJSON(){

       $planes = Plan::where('status','=',1)->get();
        foreach ($planes as $plan) {
          // Definiendo proxima fecha de caducidad
          $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( date('Y-m-d')));
          $plan['caduca'] = date('Y-m-d',$nuevafecha);
        }


        $users = User::where('role_id',8)->orWhere('role_id',6)->get();

           return response()->json(['planes'=>$planes,'gestores'=>$users]);
        
       // return response()->json($planes);

    }


    public function getFiltterToSubscribers()
    {
      $planes = Plan::orderBy('id','DESC')->get();
      $modpago = MetodoPago::where('name','<>','Recurrente')->get();

      return response()->json(['planes'=>$planes, 'modpago'=>$modpago]);
    }

     public function getFiltterToSubscribersCursos()
    {
      $cursos = Curso::orderBy('titulo','asc')->get();

      $gestor=User::where('role_id',6)->orWhere('role_id',8)->orderBy('name','asc')->get();
     

      return response()->json(['cursos'=>$cursos,'gestor'=>$gestor]);
    }

    public function culqiCharges()
    {
      return view('panel.subscriber.culqi.index');
    }

    public function culqiChargesData(Request $request)
    {

      try {

        /*$resp = $this->culqi->Charges->all(["limit" => 5]);
        $perPage = 5;
        $total = count($resp->data) + $resp->paging->remaining_items;
        $lastPage = ceil($total/$perPage);
        $page = 1;

        if($request->before){
          $cargos = $this->culqi->Charges->all(["limit" => $perPage,
                                                "before"=> $request->before]);
         $cargos->paging->page = (int)$request->page;
         $cargos->paging->total = $total;
         $cargos->paging->lastPage = $lastPage;


        }elseif($request->after){

          $cargos = $this->culqi->Charges->all(["limit" => $perPage,
                                                "after"=> $request->after]);
          $cargos->paging->page = (int)$request->page;
          $cargos->paging->total = $total;
          $cargos->paging->lastPage = $lastPage;

        }else{
          $cargos = $this->culqi->Charges->all(["limit" => $perPage]);
          $cargos->paging->page = $page;
          $cargos->paging->total = $total;
          $cargos->paging->lastPage = $lastPage;
          
        }*/

        $cargos = $this->culqi->Charges->all(["limit" => 10]);
        
        return response()->json($cargos);

      } catch (\Exception $e) {

        return response()->json($e->getMessage(), 500);
      }

      
    }

    public function culqiChargesSearch($email)
    {
      
      $cargos = $this->culqi->Charges->all(["email" => $email,"limit" => 1]);

      return response()->json($cargos);
    }

   
  public function gerCursoPrecio(Request $request)
  {

    $curso = Curso::where('id', $request->curso_id)->first();
    $user = User::where('id', $request->user_id)->first();

    if ($user->role_id == 2) {
      if ($request->moneda == "PEN") {
        $precio = $curso->promocion;
      } else {
        $precio = $curso->promocion_d;
      }
    } else {
      if ($request->moneda == "PEN") {
        $precio = $curso->precio;
      } else {
        $precio = $curso->precio_d;
      }
    }

    return response()->json(['pago_monto' => $precio]);
  }
}
