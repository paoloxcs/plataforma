<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interes;
use App\Medio;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\assignRole;
use Spatie\Permission\Traits\removeRole;
use Culqi\Culqi;
use Culqi\CulqiException;
use Requests;

use App\Cliente;
use App\Ejecutivo;

use App\Post;
use App\Curso;
use App\Publicacion;
use Illuminate\Support\Facades\Session as FacadesSession;


class RegisterController extends Controller
{
     protected $SECRET_API_KEY = ""; // Variable llave privada API CULQI
     protected $culqi = null; // Variable culqi

    public function __construct() /* Deteminación del método constructor */
    {
        Requests::register_autoloader(); /* Invocación de dependencia requests para Culqi */
        $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c"; /* Asignación de llave privada */
        /*$this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN"; /* Asignación de llave privada */
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY)); /*Instancia a la clase de culqi API*/

         $this->middleware('guest');
    }
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  /*  public function __construct()
    {
        $this->middleware('guest');
    }*/

    public function redirectTo()
{
    if (session()->has('redirect_to'))
        return session()->pull('redirect_to');

    return $this->redirectTo;
}
    public function showRegistrationForm()
    {
        $medios = Medio::all();
         //MENU 

      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->orderby('fecha','Desc')->where('rubro_id','=','1')->limit(2)->get();

      $cursosC = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->orderby('fecha','Desc')->where('rubro_id','=','2')->limit(2)->get();

      $cursosM=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->orderby('fecha','Desc')->where('rubro_id','=','3')->limit(2)->get();

      $seriesA = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','serie'],['c.idrubro','=',1]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(2)->get();

      

      $videosA = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=',1]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(2)->get();

      $videosC = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=',2]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(2)->get();

      $videosM = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=',3]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(2)->get();

      $articulosA = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','articulo'],['c.idrubro','=',1]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('paper','clicks','subcategoria.categoria.rubro','autor','downloads','valoraciones')
      ->limit(2)->get();

      $articulosC = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','articulo'],['c.idrubro','=',2]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('paper','clicks','subcategoria.categoria.rubro','autor','downloads','valoraciones')
      ->limit(2)->get();

      $articulosM = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','articulo'],['c.idrubro','=',3]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('paper','clicks','subcategoria.categoria.rubro','autor','downloads','valoraciones')
      ->limit(2)->get();


      $revistasA = Publicacion::where('medio','=','DA')->orderBy('nro','desc')->limit(2)->get();

      $revistasC = Publicacion::where('medio','=','RC')->orderBy('nro','desc')->limit(2)->get();

      $revistasM = Publicacion::where('medio','=','TM')->orderBy('nro','desc')->limit(2)->get();
      $rubroSlug="";
      
      //MENU
      
        return view('auth.register',compact('medios','rubroSlug','cursosA','cursosC','cursosM','seriesA','videosA','videosC','videosM','revistasA','revistasC','revistasM','articulosA','articulosC','articulosM'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
        {
            $validator =  Validator::make($data, [
                'name' => 'required|string|max:45',
                'last_name'=>'required|string|max:45',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'phone_number'  => 'required|numeric',
                    'medio'        =>  'nullable',
            //Form Age_Profession
            // 'age'  => 'nullable|numeric|min:18|max:150',
            'age'  => 'nullable|date_format:Y-m-d',
            'profession'  => 'nullable',
            'pais'  => 'nullable',
            ],[
                'name.required'=>'Ingrese nombres',
                'last_name.required'=>'Ingrese Apellidos',
                'email.required'=>'Ingrese correo electrónico',
                'password.required'=>'Ingrese contraseña',
                'phone_number.required'=>'Ingrese número de telf o movil',
                //Form Age_Profession
            // 'age.min' => 'La edad debe tener :min +',
            // 'age.max' => 'La edad no puede exeder de 150',
            'age.date_format' => 'La fecha de nacimineto es invalido',
            
                'medio.required'      => 'Elige al menos un medio de Interés',
                
                'pais.required'=>'Seleccione País',
            ]);
            
              if ($validator->fails()) {
            // Los datos proporcionados no pasaron la validación.
            FacadesSession::flash('msg-error', 'Hubo un error, intente nuevamente');
        }
        return $validator;
            
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param  array  $data
         * @return \App\User
         */
        protected function create(array $data)
        {
           /*$cliente= $this->culqi->Customers->create(
                      array(
                        "address" => "callao",
                        "address_city" => "lima",
                        "country_code" => "PE",
                        "email" => strtolower($data['email']),
                        "first_name" => $data['name'],
                        "last_name" => $data['last_name'],
                        //"metadata" => array("test"=>"test"),
                        "phone_number" => $data['phone_number'],
                      )
            );*/
            
           

            
            
                 $user = User::create([
                'name' => $data['name'],
                'pais' => $data['pais'],
                'last_name'=>$data['last_name'],
                'email' => strtolower($data['email']),
                'password' => bcrypt($data['password']),
                'phone_number'=> $data['phone_number'],
                 //Form Age_Profession
            'age' => $data['age'],
            'profession' => $data['profession'],
            
                'role_id'=> 7,
            ]);

        
                   Interes::create([
                       'user_id'   =>  $user->id,
                        'medio_id'  => $data['medio'] ?  $data['medio'] : 1,
                   ]);
               
               
        
            
            return $user;
        }
    

}
