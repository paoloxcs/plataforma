<?php

namespace App\Http\Controllers;

use App\Mail\PromoToGestor;
use App\Mail\PromoToUser;
use App\Mail\SolicitudFactura;
use App\Mail\SolicitudComprobante;
use App\Pago;
use App\PostClick;
use App\Promocion;
use App\SuscriptorOnline;
use App\SuscriptorRecurrente;
use App\User;
use App\UserStorage;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Requests;
use Culqi\Culqi;
use App\Curso;
use Culqi\CulqiException;
use App\Plan;
use App\Cliente;
use DateTime;
use App\Post;
use App\Publicacion;
use App\Voucher;
class DashboardController extends Controller
{
   protected $SECRET_API_KEY = ""; // Variable llave privada API CULQI
     protected $culqi = null; // Variable culqi

    public function __construct() /* Deteminación del método constructor */
    {
        Requests::register_autoloader(); /* Invocación de dependencia requests para Culqi */
        $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c"; /* Asignación de llave privada */
    //  $this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN"; /* Asignación de llave privada */
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY)); /*Instancia a la clase de culqi API*/
    }
    public function getProfile()
    {
      $history = PostClick::where('user_id','=',Auth()->user()->id)->select('idpost')->orderBy('id','desc')->distinct('idpost')->limit(6)->get();
      $favoritos = UserStorage::where('user_id','=',Auth()->user()->id)->orderBy('id','desc')->limit(10)->get();
      return view('web.profile.index',compact('history','favoritos'));
    }
    
    public function frmChangePassword()
    {
      return view('web.profile.changepassword');
    }
    public function changePassword(Request $request)
    {
      $this->validate($request,[
          'currentpass'=>'required',
          'newpass'=>'required|string|min:6|confirmed'
      ],[
          'currentpass.required'=>'Ingrese la contraseña actual',
          'newpass.required'=>'Ingrese la nueva contraseña'
      ]);

      $user = Auth()->user();

      //Verifica la contraseña encryptada
      if (Hash::check($request->currentpass, Auth()->user()->password)) {
         
         $user->password = bcrypt($request->newpass);
         $user->save();
         create_user_log('Cambio su contraseña');

         Session::flash('msg','La contraseña fue cambiada con éxito!');
         return redirect()->route('getmicuenta');

         //verifica la contrseña no ecryptada
      }elseif($request->currentpass == Auth()->user()->password){

        $user->password = bcrypt($request->newpass);
        $user->save();
        create_user_log('Cambio su contraseña');

        return back()->with('msg','La contraseña fue cambiada con éxito!');
          
      }else{

        return back()->with('msg-error','La contraseña actual no coincide');
      }

    }
    public function editUser()
    {
      return view('web.profile.edituser');
    }
    public function updateUser(Request $request, $id)
    {
    
    $this->validate($request, [
      'name'      => 'required|string|max:100',
      'last_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
      'address' => 'required|string|max:50',
      'phone_number' => 'required|numeric',
      // Form Age_Profession
      'age'  => 'nullable|date_format:Y-m-d',
      'profession'  => 'nullable',
    ]);
    $user = User::find($id);
    // if ($user->socialProfiles != '[]') {
    //   $this->validate($request, [
    //     'name'      => 'required|string|max:100',
    //     'last_name' => 'string|max:100|nullable',
    //     'address' => 'required|string|max:50',
    //     'phone_number' => 'required|numeric',
    //     // Form Age_Profession
    //     'age'  => 'nullable|date_format:Y-m-d',
    //     'profession'  => 'nullable',
    //   ]);
    // } else {
    //   $this->validate($request, [
    //     'name'      => 'required|string|max:100',
    //     'last_name' => 'required|string|max:100',
    //     'address' => 'required|string|max:50',
    //     'phone_number' => 'required|numeric',
    //     // Form Age_Profession
    //     'age'  => 'nullable|date_format:Y-m-d',
    //     'profession'  => 'nullable',
    //   ]);
    // }


    //   $user = User::find($id); 

      if($request->file('perfil')){
          $this->validate($request,[
            'perfil'  => 'mimes:jpg,jpeg,png|max:100'
          ]);

          if ($user->url_foto != null && file_exists(public_path().'/fotousers/'.$user->url_foto)) {
            unlink(public_path().'/fotousers/'.$user->url_foto);
          }          

          $url_foto = uniqid().'.'.$request->file('perfil')->getClientOriginalExtension();
          $request->file('perfil')->move(public_path().'/fotousers/',$url_foto);

          $user->url_foto = $url_foto;
      }

      $user->name = $request->name;
      $user->last_name = $request->last_name;
      $user->phone_number = $request->phone_number;
      $user->doc_number = $request->doc_number;
      $user->address = $request->address;
        // Form Age_Profession
    $user->age = $request->age;
    $user->profession = $request->profession;
      $user->save();

      create_user_log('Actualizó sus datos personales');

       return redirect()->route('getmicuenta');

    }
    public function editSuscription()
    {
 
    return redirect('profile/mi-cuenta');
 
      $user = Auth()->user();

      if ($user->isCliente()) {
       $cliente= Cliente::where('user_id',$user->id)->first();

       if ($cliente) {


         $client = Cliente::find($cliente->id);
         if ($client->Caducidad()>0) {
           $client->status= 1;
         }else{
           $client->status= 0;
         }
         $client->save();
       }
      }
      if ($user->tarjeta_id=='') {
     
      
      return view('web.profile.suscription',compact('user'));

       // return view('web.profile.suscription', compact('user',  'rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
     
      }
      else{
        $id_user= Auth()->user()->id;
         $ultimo_suscripcion= SuscriptorRecurrente::where('user_id','=',$id_user)->orderBy('id','desc')->first();

     
     $suscripcion=$this->culqi->Subscriptions->get($ultimo_suscripcion->id_culqi);

     $plan= Plan::where('id','=',$ultimo_suscripcion->plan_id)->first();


        return view('web.profile.suscription', compact('user', 'suscripcion', 'plan'));

      //  return view('web.profile.suscription', compact('user', 'suscripcion', 'plan','rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    } 
    


    }
    public function editFavoritos()
    {
      $favoritos = UserStorage::where('user_id','=',Auth()->user()->id)->get();
      return view('web.profile.favoritos',compact('favoritos'));
    }

    public function generateBoleta($pago_id)
    {
      /*$pago = $this->culqi->Charges->get($pago_id);
      $user = Auth()->user();
      $pdf = \PDF::loadView('web.profile.boleta',compact('pago','user'));
      return $pdf->download('constancia-de-pago.pdf');*/
    }
        public function frmVoucher($pago_id)
    {
        $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();

      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();


      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      return view('web.profile.frmvoucher',compact('pago_id','cursosM','cursosC','cursosA'));
    }
    public function solicitudVoucher(Request $request)
    {

      $this->validate($request,[
        'rsocial' => 'required',
        'ruc'   => 'required|numeric'
      ]);
      $pago = Pago::find($request->pago_id);
      $pago->voucher_emit = 1;
      $pago->save();

      $data = [
        'name'  => Auth()->user()->fullName(),
        'email' => Auth()->user()->email,
        'address' => $request->address,
        'phone'   => Auth()->user()->phone_number,
        'comprobante' => $request->tipo_comprobante,
        'rsocial' => $request->rsocial,
        'ruc'     => $request->ruc,
        'plan'    => $pago->suscriptor->plan->name,
        'pago_id' => $pago->id,
        'modpago' =>  $pago->metodoPago->name,
        'creation_date' => $pago->created_at,
        'amount'  => $pago->monto,
        'moneda'  => $pago->moneda,
      ];
      //Enviar correo
      Mail::to('info@constructivo.com')
      ->cc('jcuadrado@constructivo.com')
      ->send(new SolicitudFactura($data));

      create_user_log('Solicitó comprobante '.strtoupper($request->tipo_comprobante));

      Session::flash('msg','La solictud se realizó con éxito, en breve responderemos ¡Gracias!');
      
      return redirect()->route('suscription');
    }
    
    public function getPromo($slug)
    {
      $promo = Promocion::where('slug','=',$slug)->first();
      if($promo){
        return view('web.promo',compact('promo'));
      }

      return redirect('/');
      
    }
    public function sendMailpromo($id)
    {
      $promo = Promocion::find($id);

      $data = [
        'nameuser'  => Auth()->user()->fullName(),
        'namePromo' => $promo->name,
        'phone'     => Auth()->user()->phone_number,
        'email'     => Auth()->user()->email,
        'precio'    => $promo->precio,
      ];

      //Correo para el suscriptor
      Mail::to(Auth()->user()->email)
      ->send(new PromoToUser($data));

      //Corro para el gestor de suscripcion 
      Mail::to('info@constructivo.com')
      ->cc('jcuadrado@constructivo.com')
      ->send(new PromoToGestor($data));

      return back()->with('msg','Se ha registrado su solicitud, en breve nos contactaremos con ud.');
    }
      public function datacargos(Request $request){
      try {
         $id_user= Auth()->user()->id;
         $ul= SuscriptorRecurrente::where('user_id','=',$id_user)->orderBy('id','desc')->first();

         $suscripcion = $this->culqi->Subscriptions->get($ul->id_culqi);
         //$suscripcion=$suscripcion->unique('creation_date)');
          return response()->json($suscripcion);

      } catch (Exception $e) {

        return response()->json($e->getMessage(), 500);

      }
    }
    public function vauchercargorecurrente(Request $request,$date){
     
       $id_user= Auth()->user()->id;
         $ultimo_suscripcion= SuscriptorRecurrente::where('user_id','=',$id_user)->orderBy('id','desc')->first();
      $plan= Plan::where('id','=',$ultimo_suscripcion->plan_id)->first();

        $fecha_creacion= (new DateTime())
        ->setTimestamp($date/ 1000)
        ->format('d-m-Y');

      $data = [
        'name'  => Auth()->user()->fullName(),
        'email' => Auth()->user()->email,
        'address' => Auth()->user()->address,
        'phone'   => Auth()->user()->phone_number,
        'plan'    => $plan->name,
        'modpago' =>  Auth()->user()->suscriptorRecurrente->metodoPago->name,
        'creation_date' => $fecha_creacion,
        'amount'  => $plan->precio,
        'moneda'  => $plan->moneda,
      ];
      //Enviar correo
    Mail::to(Auth()->user()->email)
    //Mail::to('postmaster3@constructivo.com')
      ->cc('info@constructivo.com')
      ->cc('postmaster3@constructivo.com')
      ->send(new SolicitudComprobante($data));


      Session::flash('msg','La solicitud se realizó con éxito, Revise su email para obtener los datos del cargo');
      
      return redirect()->route('suscription');
    }
    
  public function getVideoAAttribute()
  {
    // return  Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
    //   ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
    //   ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
    //   ->select('*', 'posts.slug as pslug')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->limit(2)->get();
    return  Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'video'], ['posts.is_active', true], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();
  }
  public function getVideoCAttribute()
  {
    // return Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
    //   ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
    //   ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
    //   ->select('*', 'posts.slug as pslug')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->limit(2)->get();
    return Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'video'], ['posts.is_active', true], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();
  }
  public function getVideoMAttribute()
  {
    // return Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
    //   ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
    //   ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
    //   ->select('*', 'posts.slug as pslug')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->limit(2)->get();
    return Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'video'], ['posts.is_active', true], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();
  }
}
