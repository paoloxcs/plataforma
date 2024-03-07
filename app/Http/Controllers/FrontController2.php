<?php
namespace App\Http\Controllers;
use App\Autor;
use App\Categoria;
use App\Comentario;
use App\Download;
use App\Mail\NewSuscripCulqi;
use App\Mail\Renovacion;
use App\Mail\SolicitudDeposito;
use App\Mail\CertCurso;
use App\Mail\SusCursoM;
use App\Mail\InteresCursoM;
use App\Mail\SusEmpresa;
use App\Notification;
use App\Pago;
use App\Paper;
use App\Plan;
use App\Post;
use App\PostClick;
use App\Promocion;
use App\Publicacion;
use App\Respuesta;
use App\RevistaClick;
use App\Rubro;
use App\Subcategoria;
use App\Suplemento;
use App\SuscriptorDeposito;
use App\SuscriptorRecurrente;
use App\SuscriptorOnline;
use App\User;
use App\UserStorage;
use App\Valoracion;
use App\Video;
use App\Event;
use Culqi\Culqi;
use Culqi\CulqiException;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Requests;
use Session;
use DateTime;
use App\Medio;
use App\Suscurso;
use App\Curso;
use App\Clase;
use App\Material;
use App\SuscriptorCursos;
use App\Evaluacion;
use App\Cuestionario;
use App\Respuestas;
use App\EvaluacionUser;

use App\CursoVista;
use App\ValoracionCurso;
use App\InteresCurso;
use App\ComentarioCurso;
use App\RespuestaCurso;
use App\Tema;
use App\CertificadoCurso;
use App\SponsorCurso;
use App\Sponsor;
use App\SponsorContact;
use App\SponsorMaterial;
use App\Colaboradores;

use App\Encuestas_Curso;
use App\Preguntas_Encuestas_Curso;
use App\Respuestas_Preguntas_Curso;
use App\Mail\EncuestaMail;
use App\Mail\NewSuscripDeposito;
use App\Mail\NewSuscripDepositoC;

class FrontController extends Controller
{
     protected $SECRET_API_KEY = ""; // Variable llave privada API CULQI
     protected $culqi = null; // Variable culqi
     


    public function __construct() /* Deteminación del método constructor */
    {
        Requests::register_autoloader(); /* Invocación de dependencia requests para Culqi */
       $this->SECRET_API_KEY = "sk_live_qRd8lrvyAumH4k5c"; /* Asignación de llave privada */
       //$this->SECRET_API_KEY = "sk_test_ngdZPS3mguG7CmrN"; /* Asignación de llave privada */
        $this->culqi = new Culqi(array('api_key' => $this->SECRET_API_KEY)); /*Instancia a la clase de culqi API*/

        
    }

    public function index() /* Método que se ejecuta al iniciar la aplicación */
    {
      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','video')
      ->select('rubro.*')->distinct('rubro.idrubro')->limit(5)->get();

      

      $articulos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')->where([['posts.type','=','articulo'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')->select('*','posts.slug as pslug')->with('subcategoria.categoria.rubro','paper','autor','clicks','downloads','valoraciones')->orderBy('idpost','desc')->limit(4)->get(); /* Obtiene los ultimos 4 artículos */

      

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')->where([['p.type','=','video'],['categoria.idrubro','=','3']])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $videos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(8)->get();

      $eventos=Event::where('status',1)->where('rubro_id','=','3')->orderBy('date_init', 'asc')->limit(4)->get();

      
      $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      $mediorc = Publicacion::orderBy('nro','desc')->limit(3)->get();
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();

      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();


      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

    
            if (!\Auth::guest()) { /* Determina si existe un usuario auntenticado */
    
           
            if (Auth()->user()->isFree()){

             if(Auth()->user()->slugplan=="defined"){ /* Determina si existe un usuario gratuito auntenticado*/
    
              return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              }else{
                /* Recupera el plan mediante plan_slug */
              $plan = Plan::where('slug','=',Auth()->user()->slugplan)->first();


              /* Recupera el usuario autenticado */
              $currentUser = User::find(Auth()->user()->id);
              /* Determina si el usuario es de rol gratuito */
                       $promo_id=0;
                 if($promo_id != 0){
                      $promo = Promocion::find($promo_id);
                      if($promo->estado == 1){
                        return view('web.suscribemepromo',compact('plan','promo'));
                      }else{
                        return redirect('/');
                      }
                    }
                     

              
                  /* Retorna la vista para pago */
                  $user = User::find(Auth()->user()->id);
                    $user->slugplan = 'defined';
                    $user->save();
                  return view('web.suscribeme',compact('plan'));

                  

              }
               return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              }
            


           /* Retorna la vista Home, para usuaris autenticados */
             return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }
      /* Retorna la vista Index para cualquier visitante */
      return view('web.index',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
      // return view('web.index',compact('videos','articulos'));
    }
    public function index1() /* Método que se ejecuta al iniciar la aplicación */
    {
      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','video')
      ->select('rubro.*')->distinct('rubro.idrubro')->limit(5)->get();

      $articulos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')->where([['posts.type','=','articulo'],['c.idrubro','=','1']])->orderBy('posts.idpost','desc')->select('*','posts.slug as pslug')->with('subcategoria.categoria.rubro','paper','autor','clicks','downloads','valoraciones')->orderBy('idpost','desc')->limit(4)->get(); /* Obtiene los ultimos 4 artículos */
      $videos = Post::where('type','=','video')->with('subcategoria.categoria.rubro','video','autor','clicks')->orderBy('idpost','desc')->limit(8)->get(); /* Obtiene los ultimos 8 videos */

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
    
      ->where([['p.type','=','video'],['categoria.idrubro','=','1']])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $videos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=','1']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(8)->get();

      $eventos=Event::where('status',1)->where('rubro_id','=','1')->orderBy('date_init', 'asc')->limit(4)->get();
      
        $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }

      $mediorc = Publicacion::where('medio','DA')->orderBy('nro','desc')->limit(3)->get();

       $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();


       $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();

      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();


      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();


        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        $series = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','serie'],['c.idrubro','=','1']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(3)->get();

      if (!\Auth::guest()) { /* Determina si existe un usuario auntenticado */

        /* Retorna la vista Home, para usuaris autenticados */
         return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      }
      /* Retorna la vista Index para cualquier visitante */
      return view('web.index',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      // return view('web.index',compact('videos','articulos'));
    }

    public function index2() /* Método que se ejecuta al iniciar la aplicación */
    {
      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','video')
      ->select('rubro.*')->distinct('rubro.idrubro')->limit(5)->get();

      $articulos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')->where([['posts.type','=','articulo'],['c.idrubro','=','2']])->orderBy('posts.idpost','desc')->select('*','posts.slug as pslug')->with('subcategoria.categoria.rubro','paper','autor','clicks','downloads','valoraciones')->orderBy('idpost','desc')->limit(4)->get(); /* Obtiene los ultimos 4 artículos */
      $videos = Post::where('type','=','video')->with('subcategoria.categoria.rubro','video','autor','clicks')->orderBy('idpost','desc')->limit(8)->get(); /* Obtiene los ultimos 8 videos */

    $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')->where([['p.type','=','video'],['categoria.idrubro','=','2']])
      ->where([['p.type','=','video'],['categoria.idrubro','=','2']])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $videos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=','2']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(8)->get();

      $eventos=Event::where('status',1)->where('rubro_id','=','2')->orderBy('date_init', 'asc')->limit(4)->get();
      
        $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }

      $mediorc = Publicacion::where('medio','RC')->orderBy('nro','desc')->limit(3)->get();

       $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $cursosA =Curso::where('estado','=','1')->where('rubro_id','=','1')->limit(3)->get();

      $cursosM = Curso::where('estado','=','1')->where('rubro_id','=','3')->limit(3)->get();


      $cursosC=  Curso::where('estado','=','1')->where('rubro_id','=','2')->limit(3)->get();


      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        $series = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','serie'],['c.idrubro','=','2']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(3)->get();

      if (!\Auth::guest()) { /* Determina si existe un usuario auntenticado */

        /* Retorna la vista Home, para usuaris autenticados */
         return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      }
      /* Retorna la vista Index para cualquier visitante */
      return view('web.index',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      // return view('web.index',compact('videos','articulos'));
    }

   public function index3() /* Método que se ejecuta al iniciar la aplicación */
    {
      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','video')
      ->select('rubro.*')->distinct('rubro.idrubro')->limit(5)->get();

      $articulos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')->where([['posts.type','=','articulo'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')->select('*','posts.slug as pslug')->with('subcategoria.categoria.rubro','paper','autor','clicks','downloads','valoraciones')->orderBy('idpost','desc')->limit(4)->get(); /* Obtiene los ultimos 4 artículos */
      $videos = Post::where('type','=','video')->with('subcategoria.categoria.rubro','video','autor','clicks')->orderBy('idpost','desc')->limit(8)->get(); /* Obtiene los ultimos 8 videos */

    $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')->where([['p.type','=','video'],['categoria.idrubro','=','3']])
      ->where([['p.type','=','video'],['categoria.idrubro','=','3']])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $videos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(8)->get();

      $eventos=Event::where('status',1)->where('rubro_id','=','3')->orderBy('date_init', 'asc')->limit(4)->get();
      
        $ip= $_SERVER['REMOTE_ADDR'];
     /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }

      $mediorc = Publicacion::where('medio','TM')->orderBy('nro','desc')->limit(3)->get();

       $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();

      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();

      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();


      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        $series = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','serie'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(3)->get();

      if (!\Auth::guest()) { /* Determina si existe un usuario auntenticado */

        /* Retorna la vista Home, para usuaris autenticados */
         return view('web.home',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      }
      /* Retorna la vista Index para cualquier visitante */
      return view('web.index',compact('planes','videos','articulos','mediorc','mediotm','medioda','rubros', 'eventos','cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','colaboradoresA','colaboradoresC','colaboradoresM','series'));
      // return view('web.index',compact('videos','articulos'));
    }
    /* Método para listar los planes de suscripción */
    public function getPlanes($slug)
    { 
      $a=$slug;
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();



       $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
      $ch = curl_init('http://ipwhois.app/json/'.$ip);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $json = curl_exec($ch);
      curl_close($ch);

      // Decode JSON response
      $ipwhois_result = json_decode($json, true);

      // Country code output, field "country_code"
      // $ipwhois_result['country_code'];

        $moneda=$ipwhois_result['currency_code'];

      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      if(!\Auth::guest()){ // Verifica usuario autenticado
        $user = Auth()->user(); // Recupera el usuario autenticado
        if($user->isFree()){ // Verifica si el usuario tiene suscripcion gratis
          return view('web.planes',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM')); // Retorna vista de planes
        }
        if($user->isPremium() and $user->tarjeta_id==''){ 
        //if($user->isPremium() ){ // Verifica si el usuario tiene suscripcion premium
          if($user->suscriptorDeposito->currentDays() < 15){ // Verifica caducidad de la suscripcion
            return view('web.planes',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM')); // retorna vista de planes
          }
          return redirect()->route('suscription','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'); // retorna la ruta de suscripcion premium
        }
        return redirect('/'); // Retorna a la vista principal

      }else{
        return view('web.planes',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM')); // retorna la vista de planes
      }

    }
   
    
     public function getPlanes1($slug)
    {
    
      $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
      /*$ch = curl_init('http://ipwhois.app/json/'.$ip);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $json = curl_exec($ch);
      curl_close($ch);

      // Decode JSON response
      $ipwhois_result = json_decode($json, true);

      // Country code output, field "country_code"
      // $ipwhois_result['country_code'];


        $moneda=$ipwhois_result['currency_code'];*/

// Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, 'https://ipgeolocation.abstractapi.com/v1/?api_key=1b73fc927d674c09934b4ae66b46861c&ip_address='.$ip.'');

        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute the request.
        $data = curl_exec($ch);
        curl_close($ch);


        $result = json_decode($data, true);

        
        // Print the data out onto the page.
      $moneda= $result['currency']['currency_code'];


      if($moneda=="PEN"){
        $planes = Plan::where('status','=',1)->where('moneda','=','PEN')->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      else{
        $planes = Plan::where('status','=',1)->where('moneda','=',"USD")->where('id','<>',5)->orderBy('precio','asc')->get();// Obtiene la lista de planes activos
      }
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

       $a=$slug;
      if(!\Auth::guest()){ // Verifica usuario autenticado
        $user = Auth()->user(); // Recupera el usuario autenticado
        if($user->isFree()){ // Verifica si el usuario tiene suscripcion gratis
          return view('web.planes',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','moneda')); // Retorna vista de planes
        }
        if($user->isPremium() and $user->tarjeta_id==''){ 
        //if($user->isPremium() ){ // Verifica si el usuario tiene suscripcion premium
          if($user->suscriptorDeposito->currentDays() < 15){ // Verifica caducidad de la suscripcion
            return view('web.planes',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','moneda')); // retorna vista de planes
          }
          return redirect()->route('suscription','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','moneda'); // retorna la ruta de suscripcion premium
        }
        return redirect('/'); // Retorna a la vista principal

      }else{
        return view('web.planes1',compact('planes','a','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','colaboradoresA','colaboradoresC','colaboradoresM','moneda')); // retorna la vista de planes
      }

    }

       public function registrar($slug)
    {
      
         $medios = Medio::all();
         $a='construccion';
         //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();


      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        return view('auth.register1',compact('medios','a','slug','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM')); 
      

    }

        public function landing($medio)
    {
         $medios = Medio::all();
         $a='construccion';

      if($medio=="TM" or $medio=="RC" or $medio=="DA"){
        

        return view('auth.landing',compact('medios','a','medio')); 
      }
      else{
       return view('auth.register',compact('medios','a','medio')); 
      }
      
        

    }
    /* Muestra el formulario de suscripción, de acuerdo al plan elegido */
    public function frmSuscription($slug,$promo_id = 0)
    {

       $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      
      /* Recupera el plan mediante plan_slug */
      $plan = Plan::where('slug','=',$slug)->first();


      /* Recupera el usuario autenticado */
      $currentUser = User::find(Auth()->user()->id);
      /* Determina si el usuario es de rol gratuito */
      $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      $moneda="PEN";

      if($plan->moneda=="PEN" AND $moneda=="PEN"){
          if ($currentUser->isFree()) {

            if($promo_id != 0){
              $promo = Promocion::find($promo_id);
              if($promo->estado == 1){
                return view('web.suscribemepromo',compact('plan','promo','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              }else{
                return redirect('/');
              }
            }
              /* Retorna la vista para pago */
              return view('web.suscribeme',compact('plan','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }

          if($currentUser->isPremium()){

            if($currentUser->suscriptorDeposito->currentDays() < 15){
               return view('web.suscribeme',compact('plan','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              //return view('web.renuevame',compact('plan','cursosC','cursosA','cursosM'));
            }

            return redirect()->route('suscription');
          }

          return redirect('/');
    }
    elseif($plan->moneda!="PEN" AND $moneda!="PEN"){

        if ($currentUser->isFree()) {

            if($promo_id != 0){
              $promo = Promocion::find($promo_id);
              if($promo->estado == 1){
                return view('web.suscribemepromo',compact('plan','promo','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              }else{
                return redirect('/');
              }
            }
              /* Retorna la vista para pago */
              return view('web.suscribeme',compact('plan','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }

          if($currentUser->isPremium()){

            if($currentUser->suscriptorDeposito->currentDays() < 15){
              return view('web.renuevame',compact('plan'));
            }

            return redirect()->route('suscription');
          }

          return redirect('/');
       
    }else{
      return redirect('/');
    }
    }

    public function createCargoPromo(Request $request)
    {
      /*$plan = Plan::find($request->planId);
      $promo = Promocion::find($request->promoId);
      try {
          // Realizando cargo en culqi
          $cargo = $this->culqi->Charges->create([
            "amount" => ($promo->precio * 100),
            "currency_code" => "PEN",
            "description" => "Suscripción ".$plan->name." - ".$promo->name,
            "email" => Auth()->user()->email,
            "source_id" => $request->tokenId
          ]);

        // Definiendo fecha de caducidad
        $fecha = date('Y-m-d');
        $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( $fecha ) );
        $suscription_end = date ( 'Y-m-d' , $nuevafecha );

        // Creando la suscripcion
        $suscriptor = SuscriptorDeposito::create([
          'user_id' =>  Auth()->user()->id,
          'plan_id' =>  $plan->id,
          'suscription_init' => $fecha,
          'suscription_end' => $suscription_end,
          'metodopago_id'   => 1
        ]);

        // Creando el pago
          Pago::create([
            'suscriptor_id' =>  $suscriptor->id,
            'monto'         =>  $promo->precio,
            'metodopago_id'        =>  1,
            'descrip'     =>  $promo->name
          ]);

          // Actualizando rol del usuario
          $currentUser = User::find(Auth()->user()->id);
          $currentUser->role_id = 2;
          $currentUser->save();

          create_user_log('Se ha suscrito en linea - '.$promo->name);

          /* Array de datos para enviar por correo */
        /*  $data =[
            'name'  => $currentUser->name,
            'email' => $currentUser->email,
            'plan'  => $plan->name.' - '.$promo->name,
            'amount'=> $promo->precio,
            'user_message' => $cargo->outcome->user_message,
            'suscription_end'   => $suscriptor->suscription_end,
          ];

          // Envía correo al usuario con los datos del array (data) 
          Mail::to($currentUser->email)
          ->send(new NewSuscripCulqi($data));


        return response()->json($cargo);
        
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }
*/
    }

    // Metodo para crear un cargo en la API de culqi
    public function createCargo(Request $request)
    {
        $plan = Plan::find($request->planId);
        $id=Auth()->user()->id;
          /**============== INICIO: CREAR CARGO SIN PROMOCION ================**/
          try {
              // Realizando cargo en culqi
             /* $cargo = $this->culqi->Charges->create([
                "amount" => ($plan->precio * 100),
                "currency_code" => "PEN",
                "description" => "Suscripción ".$plan->name,
                "email" => Auth()->user()->email,
                "source_id" => $request->tokenId
              ]);*/

              


              if (Auth()->user()->id_culqi=="") {

                if (Auth()->user()->address=="") {
                        $direccion ="define address";
                    }

                    elseif (strlen((Auth()->user()->address)>50)) {
                       $direccion= substr((Auth()->user()->address), 0, 49);
                    }
                    else{
                      $direccion= Auth()->user()->address;
                    }
               $cliente= $this->culqi->Customers->create(
                  array(
                    
                    "address" => $direccion,
                    "address_city" => "Lima",
                    "country_code" => "PE",
                    "email" => Auth()->user()->email,
                    "first_name" => Auth()->user()->name,
                    "last_name" => Auth()->user()->last_name,
                    //"metadata" => array("test"=>"test"),
                    "phone_number" => Auth()->user()->phone_number,
                  )
              );
               $user = User::find($id);
                $user->id_culqi = $cliente->id;
                $user->save();
             

              $tarjeta=$this->culqi->Cards->create(
                  array(
                    "customer_id" => $cliente->id,
                    "token_id" => $request->tokenId
                  )
                );

              $cargo=$this->culqi->Subscriptions->create(
                  array(
                      "card_id" => $tarjeta->id,
                      "plan_id" => $plan->id_culqi
                  )
                );

              

               $user = User::find($id);
                $user->tarjeta_id = $tarjeta->id;
                $user->tarjeta_token = $tarjeta->source->id;
                $user->save();

          // Definiendo fecha de caducidad
            $fecha = date('Y-m-d');
            $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( $fecha ) );
            $suscription_end = date ( 'Y-m-d' , $nuevafecha );

            $suscriptor = SuscriptorRecurrente::create([
              'user_id' =>  Auth()->user()->id,
              'plan_id' =>  $plan->id,
              'suscription_init' => $fecha,
              'suscription_end' =>  $suscription_end,
              'metodopago_id'   => 3,
              'monto'   => $plan->precio,
              'id_culqi' => $cargo->id
            ]);
            // Creando la suscripcion
           /* $suscriptor = SuscriptorDeposito::create([
              'user_id' =>  Auth()->user()->id,
              'plan_id' =>  $plan->id,
              'suscription_init' => $fecha,
              'suscription_end' => $suscription_end,
              'metodopago_id'   => 1,
              'id_culqi' => $cargo->id
            ]);*/

            // Creando el pago

             /* Pago::create([
                'suscriptor_id' =>  $suscriptor->id,
                'monto'         =>  $plan->precio,
                'metodopago_id'        =>  1
              ]);*/

              // Actualizando rol del usuario
              $currentUser = User::find(Auth()->user()->id);
              $currentUser->role_id = 2;
              $currentUser->save();

              create_user_log('Se ha suscrito en linea');

              /* Array de datos para enviar por correo */
              $data =[
                'name'  => $currentUser->name,
                'email' => $currentUser->email,
                'plan'  => $plan->name,
                'amount'=> $plan->precio,
                'user_message' => 'Ingresado con éxito',
                'suscription_end'   => $suscription_end,
                'moneda'   => $plan->moneda,
                //'Siguiente pago'   => $suscription_end
              ];

              // Envía correo al usuario con los datos del array (data) 
              Mail::to($currentUser->email)
              ->cc('postmaster3@constructivo.com')
              ->send(new NewSuscripCulqi($data));

            return response()->json($cargo);
              }
              else{
               
              $tarjeta=$this->culqi->Cards->create(
                  array(
                    "customer_id" => Auth()->user()->id_culqi,
                    "token_id" => $request->tokenId
                  )
                );

              $cargo=$this->culqi->Subscriptions->create(
                  array(
                      "card_id" => $tarjeta->id,
                      "plan_id" => $plan->id_culqi
                  )
                );

              

               $user = User::find($id);
                $user->tarjeta_id = $tarjeta->id;
                $user->tarjeta_token = $tarjeta->source->id;
                $user->save();

          // Definiendo fecha de caducidad
            $fecha = date('Y-m-d');
            $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( $fecha ) );
            $suscription_end = date ( 'Y-m-d' , $nuevafecha );

            $suscriptor = SuscriptorRecurrente::create([
              'user_id' =>  Auth()->user()->id,
              'plan_id' =>  $plan->id,
              'suscription_init' => $fecha,
              'suscription_end' =>  $suscription_end,
              'metodopago_id'   => 3,
              'monto'   => $plan->precio,
              'id_culqi' => $cargo->id
            ]);
            /*
            // Creando la suscripcion
            $suscriptor = SuscriptorDeposito::create([
              'user_id' =>  Auth()->user()->id,
              'plan_id' =>  $plan->id,
              'suscription_init' => $fecha,
              'suscription_end' => $suscription_end,
              'metodopago_id'   => 1,
              'id_culqi' => $cargo->id,
            ]);

            // Creando el pago

              Pago::create([
                'suscriptor_id' =>  $suscriptor->id,
                'monto'         =>  $plan->precio,
                'metodopago_id'        =>  1
              ]);*/

              // Actualizando rol del usuario
              $currentUser = User::find(Auth()->user()->id);
              $currentUser->role_id = 2;
              $currentUser->save();

              create_user_log('Se ha suscrito en linea');

              /* Array de datos para enviar por correo */
              $data =[
                'name'  => $currentUser->name,
                'email' => $currentUser->email,
                'plan'  => $plan->name,
                'amount'=> $plan->precio,
                'user_message' => 'Ingresado con éxito',
                'suscription_end'   => $suscription_end,
                'moneda'   => $plan->moneda,
                //'Siguiente pago'   => $suscription_end
              ];

              // Envía correo al usuario con los datos del array (data) 
              Mail::to($currentUser->email)
              ->cc('postmaster3@constructivo.com')
              ->send(new NewSuscripCulqi($data));

            return response()->json($cargo);

            }
          } catch (\Exception $e) {
            return response()->json($e->getMessage());
          }

          /**============== FIN: CREAR CARGO SIN PROMOCION ================**/
        
    }

    public function cancelsus(Request $request){
      // $this->culqi->Cards->delete(Auth()->user()->tarjeta_id);
       $suscripcion=SuscriptorRecurrente::where('user_id','=',Auth()->user()->id)->first();
      $suscripcion=SuscriptorRecurrente::find($suscripcion->id);

       $this->culqi->Subscriptions->delete($suscripcion->id_culqi);
              $id=Auth()->user()->id;
                $user = User::find($id);
                $user->role_id = '7';
                $user->tarjeta_id='';
                $user->tarjeta_token='';
                $user->save();

      $suscripcion=SuscriptorRecurrente::where('user_id','=',Auth()->user()->id)->first();
      $suscripcion=SuscriptorRecurrente::find($suscripcion->id);
      $suscripcion->delete();

      return redirect('profile/suscription');
    }

    public function createsus(Request $request){
    
           return redirect('profile/suscription');
    }
    public function getcargos(){
     // $cargos=$this->culqi->Charges->get('chr_test_SBvkPc7lUmyBHpV9');
     
     /* $client=$this->culqi->Customers->get('cus_test_AMVZoDPl2m3BY885');*/
    /* $clientes=$this->culqi->Customers->all();*/
      /*$cargos=$this->culqi->Charges->getList(array("country_code" => "US"));*/
      /*$date = Carbon::createFromTimestamp('1581439395000');*/

      //$this->culqi->Subscriptions->delete("sub_test_RtyZCNFjsTOHdjqk");
     /* try {
         $cargos = $this->culqi->Charges->all(["limit" => 5]);

          return response()->json($cargos);

      } catch (Exception $e) {

        return response()->json($e->getMessage(), 500);

      }*/

    
      return view('web.cargos');

    }
 
    

    public function createRenovacion(Request $request)
    {
     /* $plan = Plan::find($request->planId);
      $user = Auth()->user();

      try {
        // Realizando cargo en culqi
       /* $cargo = $this->culqi->Charges->create([
          "amount" => ($plan->precio * 100),
          "currency_code" => "PEN",
          "description" => "Renovación ".$plan->name,
          "email" => $user->email,
          "source_id" => $request->tokenId
        ]);*/

        // Definiendo fecha de caducidad
       /*  $tarjeta=$this->culqi->Cards->create(
                  array(
                    "customer_id" => Auth()->user()->id_culqi,
                    "token_id" => $request->tokenId
                  )
                );

              $cargo=$this->culqi->Subscriptions->create(
                  array(
                      "card_id" => $tarjeta->id,
                      "plan_id" => $plan->id_culqi
                  )
                );

              $id=Auth()->user()->id;

               $user = User::find($id);
                $user->tarjeta_id = $tarjeta->id;
                $user->tarjeta_token = $tarjeta->source->id;
                $user->save();

        $fecha = date('Y-m-d');
        $nuevafecha = strtotime ( '+'.$plan->meses.' month' , strtotime ( $fecha ) );
        $suscription_end = date ( 'Y-m-d' , $nuevafecha );

        $suscripcion = SuscriptorDeposito::where('user_id','=',$user->id)->first();
        $suscripcion->plan_id = $plan->id;
        $suscripcion->suscription_end = $suscription_end;
        $suscripcion->metodopago_id = 1;
        $suscripcion->save();


        // Creando el pago
          Pago::create([
            'suscriptor_id' =>  $suscripcion->id,
            'monto'         =>  $plan->precio,
            'tipo'          =>  'R',
            'metodopago_id'        =>  1
          ]);

          create_user_log('Renovó su suscripción en linea');

         /* Array de datos para enviar por correo */
         /*   $data =[
              'name'  => $user->name,
              'email' => $user->email,
              'plan'  => $plan->name,
              'amount'=> $plan->precio,
              'user_message' => 'suscrito con éxito',
              'suscription_end'   => $suscription_end,
            ];

            Mail::to($user->email)
            ->send(new Renovacion($data));

            return response()->json($cargo);
        
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }*/

    }

    public function solicituDeposito(Request $request)
    {
      $this->validate($request,[
        'direccion'=>'required|string|max:255',
        'dni'=>'required|numeric',
        'telef'=>'required|numeric'
      ]);

      $plan = Plan::find($request->plan_id);

      // Notification::create([
      //   'type_id' => 1,
      //   'user_id' => Auth()->user()->id,
      //   'body'    => 'Hola, este mensaje fue generado automaticamente por el sistema cuando el usuario realizo una solicitud de suscripción modalidad DEPÓSITO/TRANSFERENCIA',
      // ]);

      if($request->promo_id){
        $promo = Promocion::find($request->promo_id);

        $datainfo =[
          'name'      => Auth()->user()->name,
          'last_name' => Auth()->user()->last_name,
          'email'     => Auth()->user()->email,
          'direccion' => $request->direccion,
          'dni'       => $request->dni,
          'telef'     => $request->telef,
          'plan'      => $plan->name." - ".$promo->name,
          'moneda'      => $plan->moneda,
        ];

        Mail::to('info@constructivo.com','Rocio')
        ->cc('postmaster3@constructivo.com')
        ->send(new SolicitudDeposito($datainfo));

        return back()->with('message','Sus datos han sido enviados con éxito, nos contactaremos con ud. a la brevedad. ¡Gracias!');

      }else{
        $datainfo =[
          'name'      => Auth()->user()->name,
          'last_name' => Auth()->user()->last_name,
          'email'     => Auth()->user()->email,
          'direccion' => $request->direccion,
          'dni'       => $request->dni,
          'telef'     => $request->telef,
          'plan'      => $plan->name,
                    'amount' => $plan->precio,
        ];

        Mail::to('info@constructivo.com','Rocio')
        ->cc('postmaster3@constructivo.com')
        ->send(new SolicitudDeposito($datainfo));

        return back()->with('message','Sus datos han sido enviados con éxito, nos contactaremos con ud. a la brevedad. ¡Gracias!');
      }

    }

    public function getmedios()
    {
      $mediorc = Publicacion::where('medio','RC')->orderBy('nro','desc')->first();
      $mediotm = Publicacion::where('medio','TM')->orderBy('nro','desc')->first();
      $medioda = Publicacion::where('medio','DA')->orderBy('nro','desc')->first();

        return view('web.medios',compact('mediorc','mediotm','medioda'));
    }

    public function empresas()
    {

        return view('web.empresas');
    }

       public function empresasuscrip(Request $request)
    {

         $validation = [
            'nombre' => 'required|string',
            'email' => 'required|string',
            'empresa' => 'required|string',
            'telefono' => 'required|numeric',
            'nro_personas' => 'required|numeric',
            'objetivos' => 'required|string',
           
            ];
           
           $this->validate($request, $validation);

            /* Array de datos para enviar por correo */
          $data =[
              'nombre'  => $request->nombre,
              'email' => $request->email,
              'empresa'  => $request->empresa,
              'telefono'=> $request->telefono,
              'nro_personas' =>$request->nro_personas,
              'objetivos'=>$request->objetivos,

            ];

            Mail::to('info@constructivo.com')
            ->cc('postmaster3@constructivo.com')
            ->send(new SusEmpresa($data));

            Session::flash('msg','¡Registro exitoso!');
        return redirect()->route('empresas');    
    }


    public function getarticulos()
    {

      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','articulo')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

      $posts = Post::where('type','=','articulo')->with('subcategoria.categoria.rubro','paper','downloads','clicks','valoraciones','autor')->orderBy('idpost','desc')->paginate(10);

       $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        return view('web.articulos',compact('posts','rubros','cursosC','cursosM','cursosA','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

    public function getArticulo($slug)
    {
       $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      $post = Post::where('slug','=',$slug)->first(); // recuperando el articulo por el parametro slug
      if (!\Auth::guest()) { // Verfica usuario autenticado
        $categoria = $post->subcategoria->categoria;
        $relacionados = Post::where([['idsubcategoria','=',$post->idsubcategoria],['idpost','<>',$post->idpost],['type','=','articulo']])->orderBy('idpost','desc')->limit(5)->get();

        //mostrar o ocultar el boton de me gusta
        $btnDisabled = false;
        foreach ($post->valoraciones as $valoracion) {
            if ($valoracion->user_id == Auth()->user()->id) {
              $btnDisabled = true;
            }
        }

        $btnDisabled2 = false;
        foreach ($post->marcados as $marcado) {
          if ($marcado->user_id == Auth()->user()->id) {
            $btnDisabled2 = true;
          }
        }


        if ($post->acceso == 1) {
          if (!Auth()->user()->isFree()) {

            PostClick::create([
              'idpost' => $post->idpost,
              'user_id'=> Auth()->user()->id,
              'user_ip'=> $_SERVER['REMOTE_ADDR'],
            ]);

            return view('web.articulo',compact('post','categoria','relacionados','btnDisabled','btnDisabled2','cursosA','cursosC','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
            
          }else{                                                                                                                                               
            //Retornando planes de suscripcion.
            return redirect()->route('planes',$serie->subcategoria->categoria->rubro->slug);
          }
        }

        PostClick::create([
          'idpost' => $post->idpost,
          'user_id'=> Auth()->user()->id,
          'user_ip'=> $_SERVER['REMOTE_ADDR'],
        ]);

        return view('web.articulo',compact('post','categoria','relacionados','btnDisabled','btnDisabled2','cursosA','cursosC','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
      }

      //Retornando planes de suscripcion.
      return redirect()->route('login');
      
    }
    public function downloadArticulo($idpost)
    {
      $post = Post::find($idpost);

      Download::create([
        'idpost'  =>  $post->idpost,
        'user_id' => Auth()->user()->id,
        'user_ip' => $_SERVER['REMOTE_ADDR'],
      ]);
      $file = public_path().'/posts/'.$post->ruta;

      create_user_log('Descargó el artículo: '.$post->titulo);

      /*$file = '/home/cons0507/app-virtual/public/posts/'.$post->ruta;*/

       return response()->download($file);
    }
    public function saveLikePost(Request $request)
    {
      Valoracion::create([
        'idpost'  => $request->post_id,
        'user_id' => Auth()->user()->id,
      ]);

      return response()->json([
        'message' =>'Like guardado con éxito'
      ]);

    }
    public function saveMarker(Request $request)
    {
      UserStorage::create([
        'idpost'  => $request->post_id,
        'user_id' => Auth()->user()->id,
      ]);

      return response()->json([
        'message' =>'Like guardado con éxito'
      ]);
    }
    public function saveComent(Request $request)
    {
      Comentario::create([
        'user_id' => Auth()->user()->id,
        'idpost'  => $request->post_id,
        'texto'   => $request->texto
      ]);

      return response()->json([
        'message'=>'Comentario guardado'
      ]);
    }
    public function saveRespuesta(Request $request)
    {
      Respuesta::create([
        'comentario_id' => $request->coment_id,
        'user_id'       => Auth()->user()->id,
        'texto'         => $request->textores
      ]);

      return response()->json([
        'message'=>'Respuesta  guardado'
      ]);
    }
    public function articulosRubro($slug)
    {
      $rubro = Rubro::where('slug','=',$slug)->first();

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')
      ->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where([['p.type','=','articulo'],['categoria.idrubro','=',$rubro->idrubro]])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')
      ->distinct('categoria.idcategoria')
      ->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','articulo'],['c.idrubro','=',$rubro->idrubro]])
      ->select('posts.*')
      ->with('subcategoria.categoria.rubro','paper','autor','downloads','valoraciones')->orderBy('fecha','Des')
      ->paginate(10);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.articulosrubro',compact('rubro','categorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    //cambios 
     public function eventosRubro($slug)
    {
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      if ($slug=='arquitectura-y-diseno') {
        $id='1';
      }elseif ($slug=='construccion') {
        $id='2';
      }elseif($slug=='mineria'){
        $id='3';
      }
      $active_events=Event::where('rubro_id','=',$id)->where('status',1)->with('type_event','rubro')->orderBy('date_init', 'asc')->get();
      $inactive_events=Event::where('status',0)->where('rubro_id','=',$id)->with('type_event','rubro')->orderBy('date_init', 'asc')->get();
      $rubros=Rubro::whereHas('events')->withCount('events')->get();

      return view('web.eventos', compact('active_events','inactive_events','rubros','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

    public function articulosCategoria($slug)
    {
      $categoria = Categoria::where('slug','=',$slug)->first();

      $subcategorias = Subcategoria::join('posts as p','p.idsubcategoria','=','subcategoria.idsubcategoria')
      ->where([['p.type','=','articulo'],['subcategoria.idcategoria','=',$categoria->idcategoria]])
      ->select('subcategoria.idsubcategoria','subcategoria.nombresubcategoria','subcategoria.slug')
      ->distinct('subcategoria.idsubcategoria')
      ->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->where([['posts.type','=','articulo'],['sc.idcategoria','=',$categoria->idcategoria]])
      ->select('posts.*')
      ->with('subcategoria.categoria.rubro','paper','autor','downloads','valoraciones')->orderBy('fecha','Des')
      ->paginate(10);
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();


      return view('web.articuloscategoria',compact('categoria','subcategorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    public function articulosSubCategoria($slug)
    {
      $subcategoria = Subcategoria::where('slug','=',$slug)->first();

      $categoria = Categoria::where('idcategoria','=',$subcategoria->idcategoria)->first();

      $posts = Post::where([['posts.type','=','articulo'],['idsubcategoria','=',$subcategoria->idsubcategoria]])
      ->select('posts.*')
      ->with('subcategoria.categoria.rubro','paper','autor','downloads','valoraciones')->orderBy('fecha','Des')
      ->paginate(10);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();


      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      return view('web.articulossubcategoria',compact('categoria','subcategoria','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    public function articulosAutor($autor)
    {
      $rubros = Rubro::orderBy('nombrerubro','asc')->get();
      $autor = Autor::where('slug','=',$autor)->first();

      $posts = Post::join('autor as a','a.idautor','=','posts.idautor')
      ->where([['posts.type','=','articulo'],['a.idautor','=',$autor->idautor]])
      ->select('*','posts.slug as pslug')
      ->with('subcategoria.categoria.rubro','paper','autor','downloads','valoraciones')
      ->paginate(10);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.articulosautor',compact('rubros','autor','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

    }
    public function getvideos()
    {

      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','video')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

      $posts = Post::where('type','=','video')->with('subcategoria.categoria.rubro','clicks','autor','video')->orderBy('idpost','desc')->paginate(15);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
        return view('web.videos',compact('posts','rubros','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    
    public function videosRubro($slug)
    {
      $rubro = Rubro::where('slug','=',$slug)->first();

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where([['p.type','=','video'],['categoria.idrubro','=',$rubro->idrubro]])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=',$rubro->idrubro]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->paginate(9);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      return view('web.videosrubro',compact('rubro','categorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    public function videosCategoria($slug)
    {
      $categoria = Categoria::where('slug','=',$slug)->first();

      $subcategorias = Subcategoria::join('posts as p','p.idsubcategoria','=','subcategoria.idsubcategoria')->where([['p.type','=','video'],['subcategoria.idcategoria','=',$categoria->idcategoria]])->select('subcategoria.idsubcategoria','subcategoria.nombresubcategoria','subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->where([['posts.type','=','video'],['sc.idcategoria','=',$categoria->idcategoria]])
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->orderBy('posts.idpost','desc')
      ->paginate(9);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();
      
      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.videoscategoria',compact('categoria','subcategorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    
     public function videosSubCategoria($slug)
    {
      $subcategoria = Subcategoria::where('slug','=',$slug)->first();

      $categoria = Categoria::where('idcategoria','=',$subcategoria->idcategoria)->first();

      $posts = Post::where([['posts.type','=','video'],['idsubcategoria','=',$subcategoria->idsubcategoria]])
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->orderBy('posts.idpost','desc')
      ->paginate(9);
      
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.videossubcategoria',compact('categoria','subcategoria','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }


    public function videosAutor($slug,$rubro)
    {
      $autor=Autor::where('slug','=',$slug)->with('posts')->first();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        $a=$rubro;

      if ($autor) {
        return view('web.videosautor',compact('autor','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','a')); 
      }
      return redirect('/');
      // dd($autor);      

    }

    public function getVideo($slug)
    {
      /* Obtiene el post mediate el slug */
      $post = Post::where('slug','=',$slug)->first();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      /* Determina si existe usuario autenticado */
      if (!\Auth::guest()) {
        /* Lista los 3 ultimos videos diferentes al video elegido */
        $recents = Post::where([['idpost','<>',$post->idpost],['type','=','video']])->orderBy('idpost','desc')->limit(3)->get();

        /* Determina: Habilitar o Deshabilitar el boton de Me gusta */
        $btnDisabled = false;
        foreach ($post->valoraciones as $valoracion) {
            if ($valoracion->user_id == Auth()->user()->id) {
              $btnDisabled = true;
            }
        }

        /* Determina: Habilitar o Deshabilitar el boton de Favoritos  */
        $btnDisabled2 = false;
        foreach ($post->marcados as $marcado) {
          if ($marcado->user_id == Auth()->user()->id) {
            $btnDisabled2 = true;
          }
        }

        /* Determina si el video es Premiun */
        if ($post->acceso == 1) {
          /* Determina si el usuario autenticado es diferente de Gratuito */
          if (!Auth()->user()->isFree()) {
            /* Registra una vista del vista del video */
            PostClick::create([
              'idpost' => $post->idpost,
              'user_id'=> Auth()->user()->id,
              'user_ip'=> $_SERVER['REMOTE_ADDR'],
            ]);
            create_user_log('Ha visto el video: '.$post->titulo);
            /* Retorna la vista video */
            return view('web.video',compact('post','recents','btnDisabled','btnDisabled2','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

          }else{
            /* Retorna la vista previa del video */
            $posts = Post::all();
            return view('web.videopreview',compact('post','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }
        }

        /*Si el video es gratuito se ejectuta esta seccion de CODIGO */
        PostClick::create([
          'idpost' => $post->idpost,
          'user_id'=> Auth()->user()->id,
          'user_ip'=> $_SERVER['REMOTE_ADDR'],
        ]);
        create_user_log('Ha visto el video: '.$post->titulo); 

        return view('web.video',compact('post','recents','btnDisabled','btnDisabled2','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

      }

      /* Retorna la vista previa del video, si no existe usuarios autenticados */
      $posts = Post::all();
      return view('web.videopreview',compact('post','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
      
    }

    public function getseries()
    {

      $rubros = Rubro::join('categoria as c','c.idrubro','=','rubro.idrubro')->join('subcategoria as sc','c.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where('p.type','=','serie')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

      $posts = Post::where('type','=','serie')->with('subcategoria.categoria.rubro','clicks','autor','video')->orderBy('idpost','desc')->paginate(15);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
        return view('web.series',compact('posts','rubros','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
     public function seriesRubro($slug)
    {
      $rubro = Rubro::where('slug','=',$slug)->first();

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where([['p.type','=','serie'],['categoria.idrubro','=',$rubro->idrubro]])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','serie'],['c.idrubro','=',$rubro->idrubro]])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('serie','clicks','subcategoria.categoria.rubro','autor')
      ->paginate(9);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      return view('web.seriesrubro',compact('rubro','categorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    public function seriesCategoria($slug)
    {
      $categoria = Categoria::where('slug','=',$slug)->first();

      $subcategorias = Subcategoria::join('posts as p','p.idsubcategoria','=','subcategoria.idsubcategoria')->where([['p.type','=','serie'],['subcategoria.idcategoria','=',$categoria->idcategoria]])->select('subcategoria.idsubcategoria','subcategoria.nombresubcategoria','subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->where([['posts.type','=','serie'],['sc.idcategoria','=',$categoria->idcategoria]])
      ->select('*','posts.slug as pslug')
      ->with('serie','clicks','subcategoria.categoria.rubro','autor')
      ->orderBy('posts.idpost','desc')
      ->paginate(9);

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();
      
      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.seriescategoria',compact('categoria','subcategorias','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    
     public function seriesSubCategoria($slug)
    {
      $subcategoria = Subcategoria::where('slug','=',$slug)->first();

      $categoria = Categoria::where('idcategoria','=',$subcategoria->idcategoria)->first();

      $posts = Post::where([['posts.type','=','serie'],['idsubcategoria','=',$subcategoria->idsubcategoria]])
      ->select('*','posts.slug as pslug')
      ->with('serie','clicks','subcategoria.categoria.rubro','autor')
      ->orderBy('posts.idpost','desc')
      ->paginate(9);
      
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.seriessubcategoria',compact('categoria','subcategoria','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }


    public function getSerie($slug)
    {
      /* Obtiene el post mediate el slug */
      $post = Post::where('slug','=',$slug)->first();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      /* Determina si existe usuario autenticado */
      if (!\Auth::guest()) {
        /* Lista los 3 ultimos videos diferentes al video elegido */
        $recents = Post::where([['idpost','<>',$post->idpost],['type','=','serie']])->orderBy('idpost','desc')->limit(3)->get();

        /* Determina: Habilitar o Deshabilitar el boton de Me gusta */
        $btnDisabled = false;
        foreach ($post->valoraciones as $valoracion) {
            if ($valoracion->user_id == Auth()->user()->id) {
              $btnDisabled = true;
            }
        }

        /* Determina: Habilitar o Deshabilitar el boton de Favoritos  */
        $btnDisabled2 = false;
        foreach ($post->marcados as $marcado) {
          if ($marcado->user_id == Auth()->user()->id) {
            $btnDisabled2 = true;
          }
        }

        /* Determina si el video es Premiun */
        if ($post->acceso == 1) {
          /* Determina si el usuario autenticado es diferente de Gratuito */
          if (!Auth()->user()->isFree()) {
            /* Registra una vista del vista del video */
            PostClick::create([
              'idpost' => $post->idpost,
              'user_id'=> Auth()->user()->id,
              'user_ip'=> $_SERVER['REMOTE_ADDR'],
            ]);
            create_user_log('Ha visto la serie: '.$post->titulo);
            /* Retorna la vista video */
            return view('web.serie',compact('post','recents','btnDisabled','btnDisabled2','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

          }else{
            /* Retorna la vista previa del video */
            $posts = Post::all();
            return view('web.seriepreview',compact('post','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }
        }

        /*Si el video es gratuito se ejectuta esta seccion de CODIGO */
        PostClick::create([
          'idpost' => $post->idpost,
          'user_id'=> Auth()->user()->id,
          'user_ip'=> $_SERVER['REMOTE_ADDR'],
        ]);
        create_user_log('Ha visto la serie: '.$post->titulo); 

        return view('web.serie',compact('post','recents','btnDisabled','btnDisabled2','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

      }

      /* Retorna la vista previa del video, si no existe usuarios autenticados */
      $posts = Post::all();
      return view('web.seriepreview',compact('post','posts','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
      
    }

    public function getrevistas($medio = 'RC')
    {
      
      $revistas = Publicacion::where('medio','=',$medio)->orderBy('nro','desc')->paginate(12);
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

        return view('web.revistas',compact('revistas','medio','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

    //cambios
     public function getmineria($slug)
    {
      /* $rubro = Rubro::where('slug','=',$slug)->first();

      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where([['p.type','=','video'],['categoria.idrubro','=',$rubro->idrubro]])


       $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
    
      ->where([['p.type','=','video'],['categoria.idrubro','=','3']])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')->distinct('categoria.idcategoria')->get();

      $videos = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['posts.type','=','video'],['c.idrubro','=','3']])->orderBy('posts.idpost','desc')
      ->select('*','posts.slug as pslug')
      ->with('video','clicks','subcategoria.categoria.rubro','autor')
      ->limit(8)->get();
      return redirect('/');/**/
    }
    //cambios


    public function getRevista($medio, $edicion)
    {

      if($medio=="DA"){
        $a="arquitectura-y-diseno";
      }elseif($medio=="RC"){
        $a="construccion";
      }else{
        $a="mineria";
      }

      if (!\Auth::guest()) {
        if (!Auth()->user()->isFree()) {

          $publicacion = Publicacion::where([['nro','=',$edicion],['medio','=',$medio]])->first();
          if ($publicacion != null) {

           $ruta = strtolower($medio).''.$edicion;

           //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

           create_user_log('Ha visto la revista '.$medio.$edicion);

           RevistaClick::create([
            'idpublicacion' =>  $publicacion->idpublicacion,
            'user_id'       => Auth()->user()->id,
            'user_ip'       => $_SERVER['REMOTE_ADDR'],
           ]);
           
           return view('web.revista',compact('ruta','publicacion','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }else{
            return "El recurso no se encuentra!";
          }
        }
        //Retornando planes de suscripcion.
        return redirect()->route('planes',$a);
      }

    
      //Retornando planes de suscripcion.
      return redirect()->route('planes',$a);

        
    }
    public function getsuplemento()
    {
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();
        
      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

       $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
        $moneda="PEN";
      
        if($moneda=="PEN"){

      if (!\Auth::guest()) {
                if (Auth()->user()->isFree()) {
                  // Vista para autenticados pero gratis
                  return view('web.suplementoprev',compact('cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                }
        
                // Vista para suscriptores premium y otros roles
                $ediciones = Publicacion::where('suplemento','=',1)->orderBy('nro','desc')->get();
                $edicion = Publicacion::where('suplemento',1)->orderBy('nro','desc')->first();
                $suplemento = Suplemento::where('nroedicion','=',$edicion->nro)->get();
                return view('web.suplemento',compact('edicion','suplemento','ediciones','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
        
        
              }else{
                // Vista para no autenticados
                return view('web.suplementoprev',compact('cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
              }
        
      }
      else{
          return redirect('/');
      }
    }

    public function changeSuplemento(Request $request)
    {
      $ediciones = Publicacion::where('suplemento','=',1)->orderBy('nro','desc')->get();
      $edicion = Publicacion::where('nro','=',$request->edicion)->first();
      $suplemento = Suplemento::where('nroedicion','=',$edicion->nro)->get();
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.suplemento',compact('edicion','suplemento','ediciones','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

    public function downloadSuplemento($edicion,$filename)
    {
      $suplemento = public_path().'/suplemento/'.$edicion.'/'.$filename;

      /*$suplemento = '/home/cons0507/pv/suplemento/'.$edicion.'/'.$filename;*/
      create_user_log('Descargó el suplemento: '.$filename);

       return response()->download($suplemento);
      
    }

    public function searchQuery(Request $request)
    {
      $texto = $request->text;
      $posts = Post::where('titulo','like','%'.$texto.'%')->orderBy('fecha','desc')->get();

      $videos = Post::where('type','=','video')->orderBy('idpost','desc')->limit(4)->get();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.results',compact('posts','texto','videos','cursosC','cursosM','cursosA','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

    //cambios
     public function searchQueryRubro($slug,Request $request){
      $rubro = Rubro::where('slug','=',$slug)->first();
       $texto = $request->text;
      $categorias = Categoria::join('subcategoria as sc','categoria.idcategoria','=','sc.idcategoria')
      ->join('posts as p','p.idsubcategoria','=','sc.idsubcategoria')
      ->where([['p.type','=','articulo'],['categoria.idrubro','=',$rubro->idrubro]])
      ->select('categoria.idcategoria','categoria.nombrecategoria','categoria.slug')
      ->distinct('categoria.idcategoria')
      ->get();

     
      $posts = Post::join('subcategoria as sc','sc.idsubcategoria','=','posts.idsubcategoria')
      ->join('categoria as c','c.idcategoria','=','sc.idcategoria')
      ->where([['titulo','like','%'.$texto.'%'],['c.idrubro','=',$rubro->idrubro]])
      ->select('posts.*')->where('titulo','like','%'.$texto.'%')->orderBy('fecha','desc')->limit(10)->get();

       $videos = Post::where('type','=','video')->orderBy('idpost','desc')->limit(4)->get();

          //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      return view('web.results',compact('posts','texto','videos','cursosC','cursosM','cursosA','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }


    public function getEventos()
    {
      $active_events=Event::where('status',1)->with('type_event','rubro')->orderBy('date_init', 'asc')->get();
      $inactive_events=Event::where('status',0)->with('type_event','rubro')->orderBy('date_init', 'asc')->get();
      $rubros=Rubro::whereHas('events')->withCount('events')->get();
      return view('web.eventos', compact('active_events','inactive_events','rubros'));
    }


     public function getPremiumDataRecurrente($id){
      try {
         $user= User::where('id','=',$id)->first();
         $ul= SuscriptorRecurrente::where('user_id','=',$user->id)->orderBy('id','desc')->first();

         $suscripcion = $this->culqi->Subscriptions->get($ul->id_culqi);
         

          return response()->json($suscripcion);

      } catch (Exception $e) {

        return response()->json($e->getMessage(), 500);

      }
    }
    public function destroyPremiumrecurrente($id){

      $user=User::where('id','=',$id)->first();
      $suscripcion=SuscriptorRecurrente::where('user_id','=',$user->id)->first();
      $suscripcion=SuscriptorRecurrente::find($suscripcion->id);
         // $this->culqi->Cards->delete($user->tarjeta_id);
          $this->culqi->Subscriptions->delete($suscripcion->id_culqi);
             
            $user = User::find($user->id);
            $user->role_id = '7';
            $user->tarjeta_id='';
            $user->tarjeta_token='';
            $user->save();

            $suscripcion->delete();



      create_user_log('Anuló la suscripción de '.strtoupper($user->fullName())); // Crea un log en el sistema

      return response()->json(['message'=>'Suscripcion anulada','status'=>200]);
    }

//Cursos

       public function cursosRubro($slug)
    {
      if ($slug=='arquitectura-y-diseno') {
        $id='1';
      }elseif ($slug=='construccion') {
        $id='2';
      }elseif($slug=='mineria'){
        $id='3';
      }

      $cursos=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->orderby('id','Desc')->get();

       $cursosP=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','<',date('Y-m-d'))->orderby('id','Desc')->get();


      $cursos1=Curso::where('rubro_id',$id)->where('estado','=','1')->where('fecha_culminacion','>=',date('Y-m-d'))->where('expira','>',date('Y-m-d'))->inRandomOrder()->limit(3)->get();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

       return view('web.cursos', compact('cursos','slug','cursos1','cursosC','cursosA','cursosM','cursosP','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }

      public function beneficios()
    {
     

      /*$cursos=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->orderby('id','Desc')->get();

       $cursosP=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','<',date('Y-m-d'))->orderby('id','Desc')->get();


      $cursos1=Curso::where('rubro_id',$id)->where('estado','=','1')->where('fecha_culminacion','>=',date('Y-m-d'))->where('expira','>',date('Y-m-d'))->inRandomOrder()->limit(3)->get();*/

      //cursos
        $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      if(Auth()->user()->susplan100r()>0 or Auth()->user()->susplan100d()>0){

        if(Auth()->user()->countsusgratis()<1){

        return view('web.beneficios', compact('cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
        }
        else{
        return redirect()->route('getmiscursos');
        }

      }else{
        return redirect()->route('suscription');
        }

    }

    public function beneficiocurso($slug){
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      $curso=Curso::where('slug',$slug)->first();
      $clases=Clase::where('curso_id',$curso->id)->where('estado','=','1')->get();
      $clase1=Clase::where('curso_id',$curso->id)->where('estado','=','1')->first();
      $rubro=Rubro::where('idrubro',$curso->rubro_id)->first();

      $sponsors_cursos=SponsorCurso::where('curso_id',$curso->id)->get();
      $sponsors=Sponsor::get();

      $sponsor_contacts=SponsorContact::get();

      $sponsor_materiales=SponsorMaterial::get();

      $evaluacion=Evaluacion::where('curso_id',$curso->id)->orderby('id','desc')->first();

      /*$evaluacion_user=EvaluacionUser::where('evaluacion_id',$evaluacion->id)->get();*/

      $comentarios=ComentarioCurso::where('curso_id',$curso->id)->orderby('id','desc')->get();


      $respuestas=RespuestaCurso::orderby('id','desc')->get();

      $materiales=Material::where('curso_id',$curso->id)->get();

      $temas=Tema::where('curso_id',$curso->id)->get();






        $newcurso=CursoVista::where('curso_id','=',$curso->id)->where('created_at','=',date("Y-m-d"))->count();
        //Si es mayor que 0 aun no tiene vistas
if (Auth()->user()->susplan100r()>0 or Auth()->user()->susplan100d()>0) {

    if(Auth()->user()->countsusgratis()<1){
      
    if($curso->estado==1 and $curso->expira > date('Y-m-d') and Auth()->user()->countsusgratis()<1){
          if ($newcurso >= 1 ) {
              $vistasup = CursoVista::where('curso_id','=',$curso->id)->where('created_at','=',date("Y-m-d"))->first();
              $vistasup->cant_visto ++;
              $vistasup->updated_at=date("Y-m-d");
              $vistasup->save();
            
          }else{
              $vista = new CursoVista();
              $vista->curso_id = $curso->id;
              $vista->cant_visto =1;
              $vista->created_at=date("Y-m-d");
              $vista->save();
      
          }

         

     if (Auth()->user()->SuscriptorCursos($curso->id)) {
            
            return redirect()->route('getcurso',$curso->slug);

          }
      
        return view('web.beneficio', compact('curso','clases','rubro','slug','evaluacion','comentarios','temas','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
    }
    else{
       return back()->with('');
    }
     
      
    }
    else{
      return redirect()->route('getmiscursos');
    }
  }else{
      return redirect()->route('suscription');
  }
    }
    public function beneficiocreate(Request $request){
      $curso=Curso::where('id','=',$request->curso_id)->first();

      $suscriptor = SuscriptorCursos::create([
              'user_id' =>  Auth()->user()->id,
              'curso_id' =>  $request->curso_id,
              'id_culqi' => 'Null',
              'responsable' => "18207",
              'nro_comprobante' => "CURSOGRATIS"
          ]);
      
        
         /* Array de datos para enviar por correo */
       $data =[
              'name'  => Auth()->user()->name,
              'email' => Auth()->user()->email,
              'curso'  => $curso->titulo,
              'amount'=> '00',
              'rubro' =>$curso->rubro->nombrerubro,
              'slug'=>$curso->slug,
              'user_message' => 'participación con éxito'

            ];

            Mail::to(Auth()->user()->email)
            ->cc('info@constructivo.com')
            ->send(new SusCursoM($data));


        return redirect('curso/'.$curso->slug);

    }
    public function getmiscursos(){

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      $cursos=Curso::get();


      return view('web.miscursos', compact('cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

    }

     public function getmisintereses(){

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->get();
      return view('web.misintereses', compact('cursos','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

    }

   public function getcurso($slug)
    {
      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

      $curso=Curso::where('slug',$slug)->first();
      $clases=Clase::where('curso_id',$curso->id)->where('estado','=','1')->get();
      $clase1=Clase::where('curso_id',$curso->id)->where('estado','=','1')->first();
      $rubro=Rubro::where('idrubro',$curso->rubro_id)->first();

      $sponsors_cursos=SponsorCurso::where('curso_id',$curso->id)->get();
      $sponsors=Sponsor::get();

      $sponsor_contacts=SponsorContact::get();

      $sponsor_materiales=SponsorMaterial::get();

      $evaluacion=Evaluacion::where('curso_id',$curso->id)->orderby('id','desc')->first();

      /*$evaluacion_user=EvaluacionUser::where('evaluacion_id',$evaluacion->id)->get();*/

      $comentarios=ComentarioCurso::where('curso_id',$curso->id)->orderby('id','desc')->get();


      $respuestas=RespuestaCurso::orderby('id','desc')->get();

      $materiales=Material::where('curso_id',$curso->id)->get();

      $temas=Tema::where('curso_id',$curso->id)->get();

      $encuestas=Encuestas_Curso::where('curso_id',$curso->id)->orderby('id','desc')->get();

      $preguntas=Preguntas_Encuestas_Curso::orderby('id','asc')->get();


      $ip= $_SERVER['REMOTE_ADDR'];
      /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/

      $moneda="PEN";
      $moneda1="USD";
      
     if($moneda=="PEN"){

      $moneda="PEN";
     }else{
      $moneda="USD";
     }








        $newcurso=CursoVista::where('curso_id','=',$curso->id)->where('created_at','=',date("Y-m-d"))->count();
        //Si es mayor que 0 aun no tiene vistas

        if (!\Auth::guest()) {

          if (Auth()->user()->SuscriptorCursosG($curso->id) or Auth()->user()->SuscriptorCursosC($curso->id)) {
            return view('web.curso1', compact('curso','clases','rubro','slug','evaluacion','comentarios','respuestas','materiales','temas','clase1','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM','sponsors_cursos','sponsors','sponsor_contacts','sponsor_materiales','moneda','moneda1','preguntas','encuestas'));

          }
        }

          if($curso->estado==1 and $curso->expira > date('Y-m-d')){
                if ($newcurso >= 1 ) {
                    $vistasup = CursoVista::where('curso_id','=',$curso->id)->where('created_at','=',date("Y-m-d"))->first();
                    $vistasup->cant_visto ++;
                    $vistasup->updated_at=date("Y-m-d");
                    $vistasup->save();
                  
                }else{
                    $vista = new CursoVista();
                    $vista->curso_id = $curso->id;
                    $vista->cant_visto =1;
                    $vista->created_at=date("Y-m-d");
                    $vista->save();
            
                }

         


         if (!\Auth::guest()) {

           if (Auth()->user()->isAdmin() or Auth()->user()->isContentManager() or Auth()->user()->isSuscriptorManager()  or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado() )
          {

             return view('web.curso1', compact('curso','clases','rubro','slug','evaluacion','comentarios','respuestas','materiales','temas','clase1','cursosC','cursosA','cursosM','sponsors_cursos','sponsors','sponsor_contacts','sponsor_materiales','moneda','moneda1','preguntas','encuestas','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
          }

          if (Auth()->user()->SuscriptorCursos($curso->id)) {
            return view('web.curso1', compact('curso','clases','rubro','slug','evaluacion','comentarios','respuestas','materiales','temas','clase1','cursosC','cursosA','cursosM','sponsors_cursos','sponsors','sponsor_contacts','sponsor_materiales','moneda','moneda1','preguntas','encuestas','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

          }
          
           return view('web.curso', compact('curso','clases','rubro','slug','evaluacion','comentarios','temas','cursosC','cursosA','cursosM','moneda','moneda1','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
        }
        else{
          return view('web.curso', compact('curso','clases','rubro','slug','evaluacion','comentarios','temas','cursosC','cursosA','cursosM','moneda','moneda1','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
        }
       
    }
    else{
       return redirect('/');
    }
     
      
    }

     public function saveLikeCurso(Request $request)
    {
      ValoracionCurso::create([
        'curso_id'  => $request->curso_id,
        'user_id' => Auth()->user()->id,
      ]);

      return response()->json([
        'message' =>'Like guardado con éxito'
      ]);

    }

     public function saveInteresCurso(Request $request)
    {
      InteresCurso::create([
        'curso_id'  => $request->curso_id,
        'user_id' => Auth()->user()->id,
      ]);
      $curso=Curso::where('id',$request->curso_id)->first();

      $data =[
              'email' => Auth()->user()->email,
              'fullname' => Auth()->user()->fullname(),
              'phone_number' =>Auth()->user()->phone_number,
              'curso'  => $curso->titulo,
              'rubro' =>$curso->rubro->nombrerubro,
              'user_message' => 'Usuario interesado',
            ];

            /*Mail::to('info@constructivo.com','Rocio')
            ->cc*/Mail::to('postmaster3@constructivo.com')
            ->cc('info@constructivo.com')
            ->send(new InteresCursoM($data));



      return response()->json([
        'message' =>'Interes guardado con éxito'
      ]);

    }


        public function saveComentcurso(Request $request)
    {
      ComentarioCurso::create([
        'user_id' => Auth()->user()->id,
        'curso_id'  => $request->curso_id,
        'texto'   => $request->texto
      ]);

      return response()->json([
        'message'=>'Comentario guardado'
      ]);
    }
    public function saveRespuestacurso(Request $request)
    {
      RespuestaCurso::create([
        'comentario_id' => $request->coment_id,
        'user_id'       => Auth()->user()->id,
        'texto'         => $request->textores
      ]);

      return response()->json([
        'message'=>'Respuesta  guardado'
      ]);
    }

    public function getevaluacion($slug){

      $curso=Curso::where('slug',$slug)->first();
      $evaluacion=Evaluacion::where('curso_id',$curso->id)->first();
      $cuestionario=Cuestionario::where('evaluacion_id',$evaluacion->id)->get();
      $respuestas=Respuestas::orderby('id','asc')->get();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();


      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

       return view('web.evaluacion', compact('curso','evaluacion','cuestionario','respuestas','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

    }


      public function getresultado($slug){

      $curso=Curso::where('slug',$slug)->first();
      $evaluacion=Evaluacion::where('curso_id',$curso->id)->first();
      $cuestionario=Cuestionario::where('evaluacion_id',$evaluacion->id)->get();
      $respuestas=Respuestas::orderby('id','asc')->get();

      $evaluacion=Evaluacion::where('curso_id',$curso->id)->orderby('id','desc')->first();
      $evaluacion_user=EvaluacionUser::where('evaluacion_id',$evaluacion->id)->where('user_id',Auth()->user()->id)->orderby('id','desc')->first();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();

       if (Auth()->user()->SuscriptorCursos($curso->id)) {

        return view('web.resulEval', compact('curso','evaluacion','cuestionario','respuestas','evaluacion','evaluacion_user','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

       }
      else{
           return redirect('curso/'.$curso->slug);
      }


    }

       public function getclases($slug)
    {
      
      $curso=Curso::where('slug',$slug)->first();
      $clases=Clase::where('curso_id',$curso->id)->get();
      $rubro=Rubro::where('idrubro',$curso->rubro_id)->first();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();

      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      if (!\Auth::guest()) {
         if (Auth()->user()->SuscriptorCursosG($curso->id)) {

                   return view('web.clases', compact('curso','clases','rubro','slug','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                 }
      }

       if($curso->estado==1 and $curso->expira > date('Y-m-d')){
                if (!\Auth::guest()) {

                if (Auth()->user()->SuscriptorCursos($curso->id)) {

                   return view('web.clases', compact('curso','clases','rubro','slug','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                 }
                else{
                     return redirect('curso/'.$curso->slug);
                }
              }
                else{
                  return redirect('login');
                }

        }
        else{
            return back()->with('');
        }        
    }


    public function getclase($slug)
    {
      $clase=Clase::where('slug',$slug)->first();

      $curso=Curso::where('id',$clase->curso_id)->first();

      $rubro=Rubro::where('idrubro',$curso->rubro_id)->first();

      $materiales=Material::where('curso_id',$clase->curso_id)->get();

      //cursos
      $cursosA =Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','1')->limit(3)->get();
      $cursosM = Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','3')->limit(3)->get();
      $cursosC=  Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('rubro_id','=','2')->limit(3)->get();


      $seriesA = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','1'],['p.type','=','serie']])->count();

        $seriesM = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','3'],['p.type','=','serie']])->count();

        $seriesC = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=','2'],['p.type','=','serie']])->count();

        $colaboradoresA = Colaboradores::where('rubro_id','1')->orderby('orden','asc')->get();
        $colaboradoresC = Colaboradores::where('rubro_id','2')->orderby('orden','asc')->get();
        $colaboradoresM = Colaboradores::where('rubro_id','3')->orderby('orden','asc')->get();
      $clases=Clase::where('curso_id',$curso->id)->get();

          if (!\Auth::guest()) {
          if (Auth()->user()->SuscriptorCursosG($curso->id)) {
                   if ($clase->video_codigo!="") {
                
                    return view('web.clase', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                    }
                    return view('web.clase1', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

                }
          }


       if($curso->estado==1 and $curso->expira > date('Y-m-d')){
                 if (!\Auth::guest()) {

                  if (Auth()->user()->isAdmin() or Auth()->user()->isContentManager() or Auth()->user()->isSuscriptorManager()  or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado())
                    {
                      if ($clase->video_codigo!="") {
                
                    return view('web.clase', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                    }
                    return view('web.clase1', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                    }


                if (Auth()->user()->SuscriptorCursos($curso->id)) {
                   if ($clase->video_codigo!="") {
                
                    return view('web.clase', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));
                    }
                    return view('web.clase1', compact('curso','clase','rubro','slug','materiales','clases','cursosC','cursosA','cursosM','seriesA','seriesM','seriesC','colaboradoresA','colaboradoresC','colaboradoresM'));

                }

              
                else{
                  return redirect('curso/'.$curso->slug);
                }
              }
              else{
                return redirect('login');
              }

          }
          else{
            return back()->with('');
          }
  }

    public function envcuestionario(Request $request){

      $c=Cuestionario::where('evaluacion_id',$request->evaluacion_id)->count();
      $evaluacion=Evaluacion::where('id',$request->evaluacion_id)->first();
      $curso=Curso::where('id',$evaluacion->curso_id)->first();

        /*$respuesta["name"] = "required";
          for($x=1; $x<= $c; $x++) {
             $respuesta['respuesta'.$x] = 'required';

            
          }
          $this->validate($request, $respuesta);*/


       /*$this->validate($request, [
            'respuesta1' => 'required|numeric',
            'respuesta2' => 'required|numeric',
            'respuesta3' => 'required|numeric',
            'respuesta4' => 'required|numeric',
            'respuesta5' => 'required|numeric',
            'respuesta6' => 'required|numeric',
            'respuesta7' => 'required|numeric',
            'respuesta8' => 'required|numeric',
            'evaluacion_id' => 'required|string'            
             ],[
            'respuesta1.required' =>'Debes responder con una opción esta pregunta',
            'respuesta2.required' =>'Debes responder con una opción esta pregunta',
            'respuesta3.required' =>'Debes responder con una opción esta pregunta',
            'respuesta4.required' =>'Debes responder con una opción esta pregunta',
            'respuesta5.required' =>'Debes responder con una opción esta pregunta',
            'respuesta6.required' =>'Debes responder con una opción esta pregunta',
            'respuesta7.required' =>'Debes responder con una opción esta pregunta',
            'respuesta8.required' =>'Debes responder con una opción esta pregunta',
            ]);
*/          
            $total_buenas=0;
            
            for($x=1; $x<= $c; $x++) {

             $total_buenas+= $request['respuesta'.$x];

            }
             $total_malas= $c - $total_buenas;

               $evaluacionuser= new EvaluacionUser();
                 $evaluacionuser->evaluacion_id=$request->evaluacion_id;
                 $evaluacionuser->user_id=  Auth()->user()->id;
                 $evaluacionuser->total_buenas=$total_buenas;
                 $evaluacionuser->total_malas=$total_malas;
           

            for($x=1; $x<= $c; $x++) {

             

                 $evaluacionuser['respuesta'.$x]= $request['respuesta'.$x];
                 $evaluacionuser->evaluacion_id=$request->evaluacion_id;
                 $evaluacionuser->user_id=  Auth()->user()->id;  
            }
            $evaluacionuser->save();

      Session::flash('msg','¡Registro exitoso!');
       return redirect('resultado/'.$curso->slug);
    }

   

    public function suscripcioncurso(Request $request){
      $curso = Curso::find($request->CursoId);
      $user = Auth()->user();
      $rubro=Rubro::where('idrubro',$curso->rubro_id)->first();
      $pago=$request->amount*100;
      $moneda=$request->currency;
      $plan=Plan::where('id','2')->first();

      try {
        // Realizando cargo en culqi
       $cargo = $this->culqi->Charges->create([
          "amount" => ($pago),
          "currency_code" => ($moneda),
          "description" => "Participación Curso",
          "email" => Auth()->user()->email,
          "source_id" => $request->tokenId
        ]);



        if (Auth()->user()->isPremium()) {
          }
          else{

             if($curso->rubro->idrubro==2 and $curso->fecha_culminacion>=date('Y-m-d')){
                  $usr = User::find(Auth()->user()->id);
                  $usr->role_id = 2;
                  $usr->save();

                  $suscrip = new SuscriptorDeposito();
                  $suscrip->user_id = $usr->id;
                  $suscrip->plan_id = $plan->id;
                  $suscrip->suscription_init = date('Y-m-d');
                  $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d')."+ 1 year"));
                  $suscrip->medio = 'RC';
                  $suscrip->tipo = 'D';
                  $suscrip->metodopago_id = 2;
                  $suscrip->gestor_id = '18207';
                  $suscrip->save();

                  //Guardando pago
                  Pago::create([
                    'suscriptor_id' =>  $suscrip->id,
                    'monto'         =>  0.00,
                    'moneda'         =>  $plan->moneda,
                    'nro_comprobante' => 'COMPRA_CURSO',
                    'metodopago_id' =>  2,
                    'voucher_emit' =>  2 
                  ]);


                  $data =[
                    'name' => $usr->name,
                    'email'=> $usr->email,
                    'caducidad'=> date('Y-m-d', strtotime(date('Y-m-d')."+ 1 year"))
                  ];
                  Mail::to($usr->email)
                  ->send(new NewSuscripDeposito($data));

                  //Enviar correo
                  $dataC =[
                    'name' => $usr->name.' '.$usr->last_name,
                    'suscription_init'=> date('Y-m-d'),
                    'doc_number' => $usr->doc_number,
                    'phone' => $usr->phone_number,
                    'email'=> $usr->email,
                    'nro_comprobante' => 'COMPRA_CURSO',
                    'gestor' => 'PLATAFORMA CONSTRUCTIVO',
                    'plan' => $plan->name,
                    'precio' => '0.00',
                    'message'=>'Nueva suscripción en Plataforma',
                    'data' => 0,
                    'moneda' => $plan->moneda,
                  ];
                  Mail::to('cobranzas@constructivo.com')
                  ->cc('postmaster3@constructivo.com')
                  ->send(new NewSuscripDepositoC($dataC));
             }
          }
        //GRATIS PLATAFORMA

       
        
        if($curso->fecha_culminacion<date('Y-m-d')){

          $nuevafecha = strtotime ( '+ 1 month' , strtotime ( date('Y-m-d')));

               $suscriptor = SuscriptorCursos::create([
              /*'user_id' =>  Auth()->user()->id,*/
              'user_id' =>  Auth()->user()->id,
              'curso_id' =>  $curso->id,
              'id_culqi' => $cargo->id,
              'suscription_end' => date('Y-m-d',$nuevafecha),
              'responsable' => "18207",
              'moneda' => $moneda,
            ]);

        }else{

            $suscriptor = SuscriptorCursos::create([
              'user_id' =>  Auth()->user()->id,
              'curso_id' =>  $curso->id,
              'id_culqi' => $cargo->id,
              'responsable' => "18207",
              'moneda' => $moneda,
          ]);

        }
      
        

        
         /* Array de datos para enviar por correo */
          $data =[
              'name'  => Auth()->user()->name,
              'email' => Auth()->user()->email,
              'curso'  => $curso->titulo,
              'amount'=> $request->amount,
              'moneda' => $moneda,
              'rubro' =>$rubro->nombrerubro,
              'slug'=>$curso->slug,
              'user_message' => 'participación con éxito'

            ];

            Mail::to(Auth()->user()->email)
            ->cc('info@constructivo.com')
            ->send(new SusCursoM($data));

            return response()->json($cargo);
        
      } catch (\Exception $e) {
        return response()->json($e->getMessage());
      }
    }

    public function SaveCertificado(Request $request){

       $validation = \Validator::make($request->all(),[
            'email'=>'required|email',
            'nombres'=>'required|string',
            'celular'=>'required|numeric'

        ],[
            'email.required' => 'Ingrese su email',
            'nombres.required' => 'Ingrese nombres completos',
            'celular.required'=>'Ingrese número telefónico'
        ]);

       if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
        }

        $certificado = new CertificadoCurso();
        $certificado->curso_id =  $request->curso_id;
        $certificado->user_id =   Auth()->user()->id;
        $certificado->email =  $request->email;
        $certificado->fullname =  $request->nombres;
        $certificado->phone_number =  $request->celular;
        $certificado->estado = "0";
        $certificado->save();

        $curso=Curso::where('id',$request->curso_id)->first();


          $data =[
              'email' => $certificado->email,
              'fullname' => $certificado->fullname,
              'phone_number' => $certificado->phone_number,
              'curso'  => $curso->titulo,
              'rubro' =>$curso->rubro->nombrerubro,
              'user_message' => 'Solicitud de certificado',
            ];

            /*Mail::to('info@constructivo.com','Rocio')
            ->cc*/Mail::to('postmaster3@constructivo.com')
            ->cc('info@constructivo.com')
            ->send(new CertCurso($data));




       return back()->with('message','Sus datos han sido enviados con éxito, nos contactaremos con ud. ¡Gracias!');

    }

    public function getCursos()
    {
        $cursos = Curso::Where('estado',1)->get();
        return response()->json($cursos);
    }

    public function encuesta_user(Request $request){

       $encuesta=Encuestas_Curso::where('id',$request->encuesta_id)->first();
       $preguntas=Preguntas_Encuestas_Curso::where('encuesta_id',$encuesta->id)->get();

       $curso=Curso::where('id',$encuesta->curso_id)->first();
       
       foreach ($preguntas as $pregunta) {
        
          if($pregunta->tipo_respuesta==0){

             $respuestauser = Respuestas_Preguntas_Curso::create([
                      'valor'=>$request['pregunta'.$pregunta->id.'x'],
                      'pregunta_id'=>$pregunta->id,
                      'user_id'=>Auth()->user()->id,
            ]);

          }else{

             $respuestausert = Respuestas_Preguntas_Curso::create([
                      'texto'=>$request['respuesta'.$pregunta->id.'x'],
                      'pregunta_id'=>$pregunta->id,
                      'user_id'=>Auth()->user()->id,
                    ]);
          }

       }

          $respuestas=Respuestas_Preguntas_Curso::where('user_id',Auth()->user()->id)->get();


                $data =[
                'name' =>Auth()->user()->name,
                'last_name' =>Auth()->user()->last_name,
                'email' =>Auth()->user()->email,
                'phone_number' =>Auth()->user()->phone_number,
                'role' =>Auth()->user()->role->name,
                'curso' =>$curso->titulo,
                'rubro' =>$curso->rubro->nombrerubro,
                'encuesta' =>$encuesta->titulo,
                'preguntas' =>$preguntas,
                'respuestas' => $respuestas,
                'fecha'  => date('Y-m-d'),
                
                ];

                Mail::to("info@constructivo.com")->cc("postmaster3@constructivo.com")->send(new EncuestaMail($data));

             // Mail::to("postmaster3@constructivo.com")->send(new EncuestaMail($data));

       Session::flash('msg','¡Registro exitoso!');
       return redirect('curso/'.$curso->slug);

       
    }
}

