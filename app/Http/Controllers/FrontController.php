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
use App\Cliente;
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
use App\Slider_Rubro;

use App\Encuestas_Curso;
use App\Preguntas_Encuestas_Curso;
use App\Respuestas_Preguntas_Curso;
use App\Mail\EncuestaMail;
use App\Mail\MailFormCurso;
use App\Mail\NewSuscripDeposito;
use App\Mail\NewSuscripDepositoC;
use Socialite;
use App\SuscriptorEfectivo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

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

  //*LOGUARSE CON FACEBOOK*
  /*public function LoginFacebook(){
      return Socialite::driver('facebook')->redirect();
    }

    public function FacebookCallback(){
      $user=Socialite::driver('facebook')->user();
      dd($user);
    }*/

  public function getcontacto()
  {
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();



    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.contacto', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }

  public function getnosotros()
  {
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.nosotros', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }
  public function getterminos()
  {
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.terminos', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }

  public function getprivacidad()
  {
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.privacidad', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }

  public function getcursocard(Request $request)
  {

    $curso = Curso::where('slug', $request->slug)->with('autor', 'rubro')->first();

    //RECUPERAR MONEDA DESDE URL
    $moneda = $request->moneda;



    //SI EL CURSO CULMINÓ 
    if ($curso->fecha_culminacion <= date('Y-m-d')) {
      if ($moneda == "pen") {
        //EN SOLES
        $simbolo = "S/ ";
        if (!\Auth::guest()) {

          if (Auth()->user()->isPremium()) {
            //PARA USUARIO PREMIUM
            $precio = $curso->promocion_c;
            $moneda = "PEN";
          } else {
            return redirect()->route('getcurso', $curso->slug);
          }
        }
      } elseif ($moneda == "usd") {
        //EN DOLARES
        $simbolo = "$ ";
        if (!\Auth::guest()) {
          if (Auth()->user()->isPremium()) {
            //PARA USUARIO PREMIUM
            $precio = $curso->promocion_cd;
            $moneda = "USD";
          } else {
            return redirect()->route('getcurso', $curso->slug);
          }
        }
      } else {


        $simbolo = "S/ ";
        if (!\Auth::guest()) {
          if (Auth()->user()->isPremium()) {
            $precio = $curso->promocion_c;
            $moneda = "PEN";
          } else {
            return redirect()->route('getcurso', $curso->slug);
          }
        }
      }
    }
    //SI EL CURSO ES EN VIVO  
    else {
      if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d')) {
        //SI TIENE DESCUENTO EVALUANDO DOS CAMPOS


        //OBTENER DIA, MES Y AÑO DE LA FECHA CUANDO CULMINA LA PROMOCIÓN DEL DESCUENTO EN PORCENTAJE
        $dia_n = date("d", strtotime($curso->fecha_d_v));
        $año_n = date("Y", strtotime($curso->fecha_d_v));
        $mes_n = date("m", strtotime($curso->fecha_d_v));

        setlocale(LC_TIME, "spanish");

        $fecha = DateTime::createFromFormat('!m', $mes_n);
        $mes = strftime("%B", $fecha->getTimestamp()); // marzo


        if ($moneda == "pen") {
          //PRECIO EN SOLES
          $simbolo = "S/ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              //PRECIO PARA PREMIUM SIN DESCUENTO
              $precio_r = $curso->promocion;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->promocion) / 100, 2);
              $precio = number_format($curso->promocion - (($curso->porcentaje_d_v * $curso->promocion) / 100), 2);
              $moneda = "PEN";
            } else {
              //precio real sin descuento
              $precio_r = $curso->precio;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->precio) / 100, 2);
              $precio = number_format($curso->precio - (($curso->porcentaje_d_v * $curso->precio) / 100), 2);
              $moneda = "PEN";
            }
          }
        } elseif ($moneda == "usd") {
          $simbolo = "$ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              //precio real sin descuento
              $precio_r = $curso->promocion_d;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->promocion_d) / 100, 2);
              $precio = number_format($curso->promocion_d - (($curso->porcentaje_d_v * $curso->promocion_d) / 100), 2);
              $moneda = "USD";
            } else {
              //precio real sin descuento
              $precio_r = $curso->precio_d;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->precio_d) / 100, 2);
              $precio = number_format($curso->precio_d - (($curso->porcentaje_d_v * $curso->precio_d) / 100), 2);
              $moneda = "USD";
            }
          }
        } else {

          $simbolo = "S/ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              //precio real sin descuento
              $precio_r = $curso->promocion;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->promocion) / 100, 2);
              $precio = number_format($curso->promocion - (($curso->porcentaje_d_v * $curso->promocion) / 100), 2);
              $moneda = "PEN";
            } else {
              //precio real sin descuento
              $precio_r = $curso->precio;
              $descuento = number_format(($curso->porcentaje_d_v * $curso->precio) / 100, 2);
              $precio = number_format($curso->precio - (($curso->porcentaje_d_v * $curso->precio) / 100), 2);
              $moneda = "PEN";
            }
          }
        }
      } else {

        if ($moneda == "pen") {
          $simbolo = "S/ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              $precio = $curso->promocion;
              $moneda = "PEN";
            } else {
              $precio = $curso->precio;
              $moneda = "PEN";
            }
          }
        } elseif ($moneda == "usd") {
          $simbolo = "$ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              $precio = $curso->promocion_d;
              $moneda = "USD";
            } else {
              $precio = $curso->precio_d;
              $moneda = "USD";
            }
          }
        } else {

          $simbolo = "S/ ";
          if (!\Auth::guest()) {
            if (Auth()->user()->isPremium()) {
              $precio = $curso->promocion;
              $moneda = "PEN";
            } else {
              $precio = $curso->precio;
              $moneda = "PEN";
            }
          }
        }
      }
    }

    //PASO 1 PAGO EFECTIVO  
    $user = Auth()->user();
    //MENU JHED PREMIUN
    //PASO 1 PAGO EFECTIVO  
    $user = Auth()->user();
    // Social Profiles 
     if (!$user->phone_number || !$user->last_name) {
      return redirect()->route('getmicuenta');
    }
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();
    $plan = Plan::where('id', '2')->first();
    //Cuando se da click VER CURSO SE GENERA UN CARGO
    $orden = $this->culqi->Orders->create([
      "amount" => $precio * 100,
      "currency_code" => $moneda,
      "description" => "Curso: " . Str::limit($curso->titulo, 20),
      "order_number" => "#id-" . $curso->id . rand(1, 9999),
      "client_details" => array(
        "first_name" => Auth()->user()->name,
        "last_name" => Auth()->user()->last_name,
        "email" => Auth()->user()->email,
        "phone_number" => Auth()->user()->phone_number,
      ),
      "expiration_date" => time() + 24 * 60 * 60,
      "confirm" => false
    ]);

    if ($curso->rubro->idrubro != 1 and $curso->fecha_culminacion >= date('Y-m-d')) {

      $suscrip = new SuscriptorEfectivo();
      $suscrip->user_id = $user->id;
      $suscrip->plan_id = $plan->id;
      $suscrip->curso_id =  $curso->id;
      $suscrip->id_culqi = $orden->id;
      $suscrip->suscription_init = date('Y-m-d');
      $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
      $suscrip->medio = 'RC';
      $suscrip->tipo = 'D';
      $suscrip->metodopago_id = 4; //Pago Efectivo
      $suscrip->gestor_id = '18207';
      $suscrip->save();
    }
    
    
    //NEW CAMPO
    if ($moneda == "PEN" || $moneda == "pen" ) {
      App::setLocale('pen');
    } else {
      App::setLocale('usd');
    }

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.curso-card', compact('orden', 'dia_n', 'mes_n', 'año_n', 'mes', 'descuento', 'precio_r', 'rubroSlug', 'curso', 'simbolo', 'precio', 'moneda', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }

  public function getplan(Request $request)
  {
    $plan = Plan::where('slug', $request->slug)->first();

    // JHED PREMIUN
    //PASO 1 PAGO EFECTIVO  
    $user = Auth()->user();
    // Social Profiles 
     if (!$user->phone_number || !$user->last_name) {
     return redirect()->route('getmicuenta');
    }
    $curso = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->first();
    // dd($plan);
    // $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();
    $rubro = Rubro::where('idrubro', '2')->first();
    // $plan = Plan::where('id', '2')->first();
    //Cuando se da click VER CURSO SE GENERA UN CARGO

    if ($plan->promocion > 0) {
      $precio = $plan->promocion;
    } else {
      $precio = $plan->precio;
    }
    $moneda = $plan->moneda;

    $orden = $this->culqi->Orders->create([
      "amount" => $precio * 100,
      "currency_code" => $moneda,
      "description" => "Susc: " . Str::limit($plan->name, 20),
      "order_number" => "#id-" . $plan->id . rand(1, 9999),
      "client_details" => array(
        "first_name" => Auth()->user()->name,
        "last_name" => Auth()->user()->last_name,
        "email" => Auth()->user()->email,
        "phone_number" => Auth()->user()->phone_number,
      ),
      "expiration_date" => time() + 24 * 60 * 60,
      "confirm" => false
    ]);

    // if ($curso->rubro->idrubro != 1 and $curso->fecha_culminacion >= date('Y-m-d')) {
    $suscrip = new SuscriptorEfectivo();
    $suscrip->user_id = $user->id;
    $suscrip->plan_id = $plan->id;
    $suscrip->curso_id =  $curso->id;
    $suscrip->id_culqi = $orden->id;
    $suscrip->suscription_init = date('Y-m-d');
    $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
    $suscrip->medio = 'RC';
    $suscrip->tipo = 'D';
    $suscrip->tipo_susc = 'P'; // C --> curso | R --> recurrente | P --> primiun
    $suscrip->metodopago_id = 4; //Pago Efectivo
    $suscrip->gestor_id = '18207';
    $suscrip->save();
    // }


    //NEW CAMPO
    if ($plan->moneda == "PEN" || $plan->moneda == "pen" ) {
      App::setLocale('pen');
    } else {
      App::setLocale('usd');
    }
    
    //MENU

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    return view('web.plan', compact('orden', 'plan', 'rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }


  public function getmicuenta()
  {
    $user = Auth()->user();


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";


    if ($user->isCliente()) {
      $cliente = Cliente::where('user_id', $user->id)->first();

      if ($cliente) {


        $client = Cliente::find($cliente->id);
        if ($client->Caducidad() > 0) {
          $client->status = 1;
        } else {
          $client->status = 0;
        }
        $client->save();
      }
    }
    if ($user->tarjeta_id == '') {
      return view('web.profile.mi-cuenta', compact('rubroSlug', 'user', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    } else {
      $id_user = Auth()->user()->id;
      $ultimo_suscripcion = SuscriptorRecurrente::where('user_id', '=', $id_user)->orderBy('id', 'desc')->first();


      $suscripcion = $this->culqi->Subscriptions->get($ultimo_suscripcion->id_culqi);

      $plan = Plan::where('id', '=', $ultimo_suscripcion->plan_id)->first();



      return view('web.profile.mi-cuenta', compact('rubroSlug', 'user', 'suscripcion', 'plan', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    }

    //MENU



  }

  public function getmiscursosp()
  {


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'curso')->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'curso')->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'curso')->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $cursos = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.profile.mis-cursos', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'sliders', 'cursos'));
  }


  public function getsuplementos()
  {


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU
    $a = "construccion";
    return view('web.suplemento', compact('rubroSlug', 'a', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function gettercondiciones()
  {

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    $a = "construccion";
    return view('web.tercondiciones', compact('rubroSlug', 'a', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getprefrecuentes()
  {


    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();
    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.prefrecuentes', compact('rubroSlug', 'planes', 'planesD', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getcursosuccess(Request $request)
  {
    $curso = Curso::where('slug', $request->slug)->with('autor', 'rubro')->first();
    //MENU 
    $rubroSlug = $curso->rubro->slug;

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.curso-success', compact('rubroSlug', 'curso', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }
  public function cursosuccess($slug)
  {

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    $a = "construccion";
    $curso = Curso::where('slug', $slug)->first();
    return view('web.curso-success-c', compact('rubroSlug', 'a', 'curso', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getAutor($slug)
  {

    $autor = Autor::where('slug', $slug)->first();

    // $videos = Post::where('posts.type', '=', 'video')->where('idautor', $autor->idautor)->orderBy('posts.titulo', 'Asc')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->get();
    // Is_active_capacitacion
    $videos = Post::where('posts.type', '=', 'video')->where('idautor', $autor->idautor)
      ->where('is_active', true)->orderBy('posts.titulo', 'Asc')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->get();
    $videos = $videos->unique('titulo');

    $series = Post::where('posts.type', '=', 'serie')->where('idautor', $autor->idautor)->orderBy('posts.titulo', 'Asc')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->get();
    $series = $series->unique('titulo');




    $cursos = Curso::where('autor_id', $autor->idautor)->orderBy('titulo', 'asc')->get();
    $cursos = $cursos->unique('titulo');


    $articulos = Post::where('posts.type', '=', 'articulo')->where('idautor', $autor->idautor)->orderBy('posts.titulo', 'Asc')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->get();
    $articulos = $articulos->unique('titulo');


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    return view('web.autor', compact('rubroSlug', 'autor', 'videos', 'series', 'cursos', 'articulos', 'curso', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function index() /* Método que se ejecuta al iniciar la aplicación */
  {
    $rubros = Rubro::where('estado', 1)->get();

    $rubro = Rubro::where('estado', 1)->inrandomOrder()->first();

    $colaboradores = Colaboradores::where('estado', 1)->where('prioridad', 1)->orderby('orden', 'asc')->get();

    $colaboradores = $colaboradores->unique('nombre');

    $autores = Autor::with('posts.subcategoria.categoria.rubro')->where('principal', 1)->get();

    $autores = $autores->unique('idautor');

    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    if (!\Auth::guest()) {
      return view('web.home', compact('rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
    } else {


      return view('web.index', compact('rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
    }
  }

  public function getRubro($slug) /* Método que se ejecuta al iniciar la aplicación */
  {

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {
        $class = "";
      } else {

        $class = "d_none";
      }
    } else {

      $class = "";
    }


    $rubro = Rubro::where('estado', 1)->where('slug', $slug)->first();

    $rubroSlug = $rubro->slug;

    $cursos = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', $rubro->idrubro)->limit(12)->get();

    $series = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', $rubro->idrubro]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(12)
      ->get();

    $videos = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', $rubro->idrubro], ['is_active', true]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(12)
      ->get();

    $articulos = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', $rubro->idrubro]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(12)->get();

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {
        $sliders = Slider_Rubro::where('type', 'principal')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'principal')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'principal')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }



    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    $colaboradores = Colaboradores::where('estado', 1)->where('rubro_id', $rubro->idrubro)->orderby('orden', 'asc')->get();

    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    if ($rubro->slug == 'construccion') {
      $medio = "RC";
    } elseif ($rubro->slug == 'mineria') {
      $medio = "TM";
    } else {
      $medio = "DA";
    }


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.rubro', compact('class', 'rubroSlug', 'series', 'cursos', 'videos', 'articulos', 'rubro', 'sliders', 'medio', 'planes', 'planesD', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }



  public function getPlanes($slug)
  {
    $rubro = Rubro::where('slug', '=', $slug)->first();

    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();
    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();


    $ip = $_SERVER['REMOTE_ADDR'];
    /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
    $moneda = "PEN";
    if ($moneda == "PEN") {
      $planes = Plan::where('status', '=', 1)->where('moneda', '=', 'PEN')->where('id', '<>', 5)->orderBy('precio', 'asc')->get(); // Obtiene la lista de planes activos
    } else {
      $planes = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get(); // Obtiene la lista de planes activos
    }


    $a = $slug;

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU





    if (!\Auth::guest()) { // Verifica usuario autenticado
      $user = Auth()->user(); // Recupera el usuario autenticado
      if ($user->isFree()) { // Verifica si el usuario tiene suscripcion gratis
        return view('web.planes', compact('rubroSlug', 'planes', 'rubro', 'planesD', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM')); // Retorna vista de planes
      }
      if ($user->isPremium() and $user->tarjeta_id == '') {
        //if($user->isPremium() ){ // Verifica si el usuario tiene suscripcion premium
        if ($user->suscriptorDeposito->currentDays() < 15) { // Verifica caducidad de la suscripcion
          return view('web.planes', compact('rubroSlug', 'planes', 'rubro', 'planesD', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM')); // retorna vista de planes
        }
        return redirect()->route('getmicuenta'); // retorna la ruta de suscripcion premium
      }
      return redirect('/'); // Retorna a la vista principal

    } else {
      return view('web.planes', compact('rubroSlug', 'planes', 'rubro', 'planesD', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM')); // retorna la vista de planes
    }
  }

  public function registrar($slug)
  {

    $medios = Medio::all();
    $a = 'construccion';
    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();


    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    return view('auth.register1', compact('rubroSlug', 'medios', 'a', 'slug', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }

  public function landing($medio)
  {
    $medios = Medio::all();
    $a = 'construccion';

    if ($medio == "TM" or $medio == "RC" or $medio == "DA") {


      return view('auth.landing', compact('rubroSlug', 'medios', 'a', 'medio'));
    } else {
      return view('auth.register', compact('rubroSlug', 'medios', 'a', 'medio'));
    }
  }
  /* Muestra el formulario de suscripción, de acuerdo al plan elegido */
  public function frmSuscription($slug, $promo_id = 0)
  {

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    /* Recupera el plan mediante plan_slug */
    $plan = Plan::where('slug', '=', $slug)->first();


    /* Recupera el usuario autenticado */
    $currentUser = User::find(Auth()->user()->id);
    /* Determina si el usuario es de rol gratuito */
    $ip = $_SERVER['REMOTE_ADDR'];
    /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
    $moneda = "PEN";
    $moneda = "PEN";

    if ($plan->moneda == "PEN" and $moneda == "PEN") {
      if ($currentUser->isFree()) {

        if ($promo_id != 0) {
          $promo = Promocion::find($promo_id);
          if ($promo->estado == 1) {
            return view('web.suscribemepromo', compact('rubroSlug', 'plan', 'promo', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
          } else {
            return redirect('/');
          }
        }
        /* Retorna la vista para pago */
        return view('web.suscribeme', compact('rubroSlug', 'plan', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
      }

      if ($currentUser->isPremium()) {

        if ($currentUser->suscriptorDeposito->currentDays() < 15) {
          return view('web.suscribeme', compact('rubroSlug', 'plan', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
          //return view('web.renuevame',compact('rubroSlug','plan','cursosC','cursosA','cursosM'));
        }

        return redirect()->route('suscription');
      }

      return redirect('/');
    } elseif ($plan->moneda != "PEN" and $moneda != "PEN") {

      if ($currentUser->isFree()) {

        if ($promo_id != 0) {
          $promo = Promocion::find($promo_id);
          if ($promo->estado == 1) {
            return view('web.suscribemepromo', compact('rubroSlug', 'plan', 'promo', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
          } else {
            return redirect('/');
          }
        }
        /* Retorna la vista para pago */
        return view('web.suscribeme', compact('rubroSlug', 'plan', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
      }

      if ($currentUser->isPremium()) {

        if ($currentUser->suscriptorDeposito->currentDays() < 15) {
          return view('web.renuevame', compact('rubroSlug', 'plan'));
        }

        return redirect()->route('suscription');
      }

      return redirect('/');
    } else {
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
    $id = Auth()->user()->id;
    if ($plan->promocion > 0) {
      $amount = $plan->promocion;
    } else {
      $amount = $plan->precio;
    }
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




      if (Auth()->user()->id_culqi == "") {

        if (Auth()->user()->address == "") {
          $direccion = "define address";
        } elseif (strlen((Auth()->user()->address) > 50)) {
          $direccion = substr((Auth()->user()->address), 0, 49);
        } else {
          $direccion = Auth()->user()->address;
        }
        $cliente = $this->culqi->Customers->create(
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


        $tarjeta = $this->culqi->Cards->create(
          array(
            "customer_id" => $cliente->id,
            "token_id" => $request->tokenId
          )
        );

        $cargo = $this->culqi->Subscriptions->create(
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
        $nuevafecha = strtotime('+' . $plan->meses . ' month', strtotime($fecha));
        $suscription_end = date('Y-m-d', $nuevafecha);

        $suscriptor = SuscriptorRecurrente::create([
          'user_id' =>  Auth()->user()->id,
          'plan_id' =>  $plan->id,
          'suscription_init' => $fecha,
          'suscription_end' =>  $suscription_end,
          'metodopago_id'   => 3,
          'monto'   => $amount,
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
        $data = [
          'name'  => $currentUser->name,
          'email' => $currentUser->email,
          'plan'  => $plan->name,
          'amount' => $amount,
          'user_message' => 'Ingresado con éxito',
          'suscription_end'   => $suscription_end,
          'moneda'   => $plan->moneda,
          //'Siguiente pago'   => $suscription_end
        ];

        // Envía correo al usuario con los datos del array (data) 

        /* Mail::to($currentUser->email)
              ->cc('postmaster3@constructivo.com')
              ->send(new NewSuscripCulqi($data));*/

        return response()->json($cargo);
      } else {

        $tarjeta = $this->culqi->Cards->create(
          array(
            "customer_id" => Auth()->user()->id_culqi,
            "token_id" => $request->tokenId
          )
        );

        $cargo = $this->culqi->Subscriptions->create(
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
        $nuevafecha = strtotime('+' . $plan->meses . ' month', strtotime($fecha));
        $suscription_end = date('Y-m-d', $nuevafecha);

        $suscriptor = SuscriptorRecurrente::create([
          'user_id' =>  Auth()->user()->id,
          'plan_id' =>  $plan->id,
          'suscription_init' => $fecha,
          'suscription_end' =>  $suscription_end,
          'metodopago_id'   => 3,
          'monto'   => $amount,
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
        $data = [
          'name'  => $currentUser->name,
          'email' => $currentUser->email,
          'plan'  => $plan->name,
          'amount' => $amount,
          'user_message' => 'Ingresado con éxito',
          'suscription_end'   => $suscription_end,
          'moneda'   => $plan->moneda,
          //'Siguiente pago'   => $suscription_end
        ];

        // Envía correo al usuario con los datos del array (data) 
        /*  Mail::to($currentUser->email)
              ->cc('postmaster3@constructivo.com')
              ->send(new NewSuscripCulqi($data));*/

        return response()->json($cargo);
      }
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }

    /**============== FIN: CREAR CARGO SIN PROMOCION ================**/
  }

  public function cancelsus(Request $request)
  {
    // $this->culqi->Cards->delete(Auth()->user()->tarjeta_id);
    $suscripcion = SuscriptorRecurrente::where('user_id', '=', Auth()->user()->id)->first();
    $suscripcion = SuscriptorRecurrente::find($suscripcion->id);

    $this->culqi->Subscriptions->delete($suscripcion->id_culqi);
    $id = Auth()->user()->id;
    $user = User::find($id);
    $user->role_id = '7';
    $user->tarjeta_id = '';
    $user->tarjeta_token = '';
    $user->save();

    $suscripcion = SuscriptorRecurrente::where('user_id', '=', Auth()->user()->id)->first();
    $suscripcion = SuscriptorRecurrente::find($suscripcion->id);
    $suscripcion->delete();

    // return redirect('profile/suscription');
    return redirect('profile/mi-cuenta');
  }

  public function createsus(Request $request)
  {

    return redirect('profile/suscription');
  }
  public function getcargos()
  {
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
    $this->validate($request, [
      'direccion' => 'required|string|max:255',
      'dni' => 'required|numeric',
      'telef' => 'required|numeric'
    ]);

    $plan = Plan::find($request->plan_id);

    // Notification::create([
    //   'type_id' => 1,
    //   'user_id' => Auth()->user()->id,
    //   'body'    => 'Hola, este mensaje fue generado automaticamente por el sistema cuando el usuario realizo una solicitud de suscripción modalidad DEPÓSITO/TRANSFERENCIA',
    // ]);

    if ($request->promo_id) {
      $promo = Promocion::find($request->promo_id);

      $datainfo = [
        'name'      => Auth()->user()->name,
        'last_name' => Auth()->user()->last_name,
        'email'     => Auth()->user()->email,
        'direccion' => $request->direccion,
        'dni'       => $request->dni,
        'telef'     => $request->telef,
        'plan'      => $plan->name . " - " . $promo->name,
        'moneda'      => $plan->moneda,
        'precio' => $plan->precio,
      ];

      Mail::to('info@constructivo.com', 'Rocio')
        ->cc('postmaster3@constructivo.com')
        ->send(new SolicitudDeposito($datainfo));

      //return back()->with('message','Sus datos han sido enviados con éxito, nos contactaremos con ud. a la brevedad. ¡Gracias!');

      return redirect()->route('agradecimientode');
    } else {
      $datainfo = [
        'name'      => Auth()->user()->name,
        'last_name' => Auth()->user()->last_name,
        'email'     => Auth()->user()->email,
        'direccion' => $request->direccion,
        'dni'       => $request->dni,
        'telef'     => $request->telef,
        'plan'      => $plan->name,
        'amount' => $plan->precio,
        'precio' => $plan->precio,
        'moneda'      => $plan->moneda,
      ];

      Mail::to('info@constructivo.com', 'Rocio')
        ->cc('postmaster3@constructivo.com')
        ->send(new SolicitudDeposito($datainfo));

      //return back()->with('message','Sus datos han sido enviados con éxito, nos contactaremos con ud. a la brevedad. ¡Gracias!');

      return redirect()->route('agradecimientode');
    }
  }

  public function getmedios()
  {
    $mediorc = Publicacion::where('medio', 'RC')->orderBy('nro', 'desc')->first();
    $mediotm = Publicacion::where('medio', 'TM')->orderBy('nro', 'desc')->first();
    $medioda = Publicacion::where('medio', 'DA')->orderBy('nro', 'desc')->first();

    return view('web.medios', compact('rubroSlug', 'mediorc', 'mediotm', 'medioda'));
  }

  public function empresas()
  {

    $colaboradores = Colaboradores::where('estado', 1)->where('prioridad', 1)->orderby('orden', 'asc')->get();

    $colaboradores = $colaboradores->unique('nombre');

    //MENU 

    $rubros = Rubro::where('estado', 1)->get();

    $rubro = Rubro::where('estado', 1)->inrandomOrder()->first();
    
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU

    return view('web.new_empresas', compact('rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
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
    $data = [
      'nombre'  => $request->nombre,
      'email' => $request->email,
      'empresa'  => $request->empresa,
      'telefono' => $request->telefono,
      'nro_personas' => $request->nro_personas,
      'objetivos' => $request->objetivos,

    ];

    Mail::to('info@constructivo.com')
      ->cc('postmaster3@constructivo.com')
      ->send(new SusEmpresa($data));

    Session::flash('msg', '¡Registro exitoso!');
    return redirect()->route('empresas');
  }


  public function getarticulos()
  {

    $rubros = Rubro::join('categoria as c', 'c.idrubro', '=', 'rubro.idrubro')->join('subcategoria as sc', 'c.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where('p.type', '=', 'articulo')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

    $posts = Post::where('type', '=', 'articulo')->with('subcategoria.categoria.rubro', 'paper', 'downloads', 'clicks', 'valoraciones', 'autor')->orderBy('idpost', 'desc')->paginate(10);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    return view('web.articulos', compact('rubroSlug', 'posts', 'rubros', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getArticulo($slug)
  {
    /* Obtiene el post mediate el slug */
    $post = Post::where('slug', '=', $slug)->first();

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU
    if (!\Auth::guest()) {


      /* Determina si el video es Premiun */
      if ($post->acceso == 1) {
        /* Determina si el usuario autenticado es diferente de Gratuito */
        if (!Auth()->user()->isFree()) {
          /* Registra una vista del vista del video */
          PostClick::create([
            'idpost' => $post->idpost,
            'user_id' => Auth()->user()->id,
            'user_ip' => $_SERVER['REMOTE_ADDR'],
          ]);
          create_user_log('Ha visto el video: ' . $post->titulo);
          /* Retorna la vista video */
          return view('web.articulo', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        } else {
          /* Retorna la vista previa del video */
          return view('web.articulopreview', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        }
      }

      /*Si el video es gratuito se ejectuta esta seccion de CODIGO */
      PostClick::create([
        'idpost' => $post->idpost,
        'user_id' => Auth()->user()->id,
        'user_ip' => $_SERVER['REMOTE_ADDR'],
      ]);
      create_user_log('Ha visto el video: ' . $post->titulo);


      return view('web.articulo', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    }




    return view('web.articulopreview', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }
  public function downloadArticulo($idpost)
  {
    $post = Post::find($idpost);

    Download::create([
      'idpost'  =>  $post->idpost,
      'user_id' => Auth()->user()->id,
      'user_ip' => $_SERVER['REMOTE_ADDR'],
    ]);
    $file = public_path() . '/posts/' . $post->ruta;

    create_user_log('Descargó el artículo: ' . $post->titulo);

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
      'message' => 'Like guardado con éxito'
    ]);
  }
  public function saveMarker(Request $request)
  {
    UserStorage::create([
      'idpost'  => $request->post_id,
      'user_id' => Auth()->user()->id,
    ]);

    return response()->json([
      'message' => 'Like guardado con éxito'
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
      'message' => 'Comentario guardado'
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
      'message' => 'Respuesta  guardado'
    ]);
  }
  public function articulosRubro($slug)
  {
    $rubro = Rubro::where('slug', '=', $slug)->first();
    $rubroSlug = $rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {
        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }



    $categorias = Categoria::join('subcategoria as sc', 'categoria.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where([['p.type', '=', 'articulo'], ['categoria.idrubro', '=', $rubro->idrubro]])
      ->select('categoria.idcategoria', 'categoria.nombrecategoria', 'categoria.slug')->distinct('categoria.idcategoria')->orderby('categoria.nombrecategoria', 'asc')->get();

    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', $rubro->idrubro]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.articulosrubro', compact('rubroSlug', 'rubro', 'sliders', 'categorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }
  //cambios 
  public function eventosRubro($slug)
  {
    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    if ($slug == 'arquitectura-y-diseno') {
      $id = '1';
    } elseif ($slug == 'construccion') {
      $id = '2';
    } elseif ($slug == 'mineria') {
      $id = '3';
    }
    $active_events = Event::where('rubro_id', '=', $id)->where('status', 1)->with('type_event', 'rubro')->orderBy('date_init', 'asc')->get();
    $inactive_events = Event::where('status', 0)->where('rubro_id', '=', $id)->with('type_event', 'rubro')->orderBy('date_init', 'asc')->get();
    $rubros = Rubro::whereHas('events')->withCount('events')->get();

    return view('web.eventos', compact('active_events', 'inactive_events', 'rubros', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }

  public function articulosCategoria($slug)
  {
    $categoria = Categoria::where('slug', '=', $slug)->with('rubro')->first();
    $rubroSlug = $categoria->rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {
        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'articulo'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->where([['posts.type', '=', 'articulo'], ['sc.idcategoria', '=', $categoria->idcategoria]])
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();

    //MENU

    return view('web.articuloscategoria', compact('rubroSlug', 'sliders', 'categoria', 'subcategorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }
  public function articulosSubCategoria($slug)
  {
    $subcategoria = Subcategoria::where('slug', '=', $slug)->first();

    $categoria = Categoria::where('idcategoria', '=', $subcategoria->idcategoria)->with('rubro')->first();
    $rubroSlug = $categoria->rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'articulo')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'articulo'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();


    $posts = Post::where([['posts.type', '=', 'articulo'], ['idsubcategoria', '=', $subcategoria->idsubcategoria]])
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU



    return view('web.articulossubcategoria', compact('rubroSlug', 'sliders', 'categoria', 'subcategoria', 'subcategorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }
  public function articulosAutor($autor)
  {
    $rubros = Rubro::orderBy('nombrerubro', 'asc')->get();
    $autor = Autor::where('slug', '=', $autor)->first();

    $posts = Post::join('autor as a', 'a.idautor', '=', 'posts.idautor')
      ->where([['posts.type', '=', 'articulo'], ['a.idautor', '=', $autor->idautor]])
      ->select('*', 'posts.slug as pslug')
      ->with('subcategoria.categoria.rubro', 'paper', 'autor', 'downloads', 'valoraciones')
      ->paginate(10);

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    return view('web.articulosautor', compact('rubroSlug', 'rubros', 'autor', 'posts', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }
  public function getvideos()
  {

    $rubros = Rubro::join('categoria as c', 'c.idrubro', '=', 'rubro.idrubro')->join('subcategoria as sc', 'c.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where('p.type', '=', 'video')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

    $posts = Post::where('type', '=', 'video')->with('subcategoria.categoria.rubro', 'clicks', 'autor', 'video')->orderBy('idpost', 'desc')->paginate(15);

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();
    return view('web.videos', compact('rubroSlug', 'posts', 'rubros', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }

  public function videosRubro($slug)
  {
    $rubro = Rubro::where('slug', '=', $slug)->first();
    $rubroSlug = $rubro->slug;



    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $categorias = Categoria::join('subcategoria as sc', 'categoria.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where([['p.type', '=', 'video'], ['categoria.idrubro', '=', $rubro->idrubro]])
      ->select('categoria.idcategoria', 'categoria.nombrecategoria', 'categoria.slug')->distinct('categoria.idcategoria')->orderby('categoria.nombrecategoria', 'asc')->get();


    // Is_active_capacitacion
    // $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
    //   ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
    //   ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', $rubro->idrubro]])->orderBy('posts.idpost', 'desc')
    //   ->select('*', 'posts.slug as pslug')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->paginate(9);

    //Filtro de video de capacitacion
    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'video'], ['c.idrubro', '=', $rubro->idrubro], ['is_active', true]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.videosrubro', compact('rubroSlug', 'rubro', 'sliders', 'categorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }
  public function videosCategoria($slug)
  {

    $categoria = Categoria::where('slug', '=', $slug)->with('rubro')->first();

    $rubroSlug = $categoria->rubro->slug;

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }


    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'video'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

    // $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
    //   ->where([['posts.type', '=', 'video'], ['sc.idcategoria', '=', $categoria->idcategoria]])
    //   ->select('*', 'posts.slug as pslug')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    //   ->orderBy('posts.idpost', 'desc')
    //   ->paginate(9);

    // Is_active_capacitacion
    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->where([['posts.type', '=', 'video'], ['sc.idcategoria', '=', $categoria->idcategoria], ['posts.is_active', true]])
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.videoscategoria', compact('rubroSlug', 'sliders', 'categoria', 'subcategorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }

  public function videosSubCategoria($slug)
  {
    $subcategoria = Subcategoria::where('slug', '=', $slug)->first();

    $categoria = Categoria::where('idcategoria', '=', $subcategoria->idcategoria)->with('rubro')->first();

    $rubroSlug = $categoria->rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'capacitacion')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }


    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'video'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

    // Is_active_capacitacion
    // $posts = Post::where([['posts.type', '=', 'video'], ['idsubcategoria', '=', $subcategoria->idsubcategoria]])
    // ->select('*', 'posts.slug as pslug')
    // ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
    // ->orderBy('posts.idpost', 'desc')
    // ->paginate(9);

    $posts = Post::where([['posts.type', '=', 'video'], ['idsubcategoria', '=', $subcategoria->idsubcategoria], ['posts.is_active', true]])
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU



    return view('web.videossubcategoria', compact('rubroSlug', 'sliders', 'categoria', 'subcategoria', 'subcategorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
  }


  public function videosAutor($slug, $rubro)
  {
    $autor = Autor::where('slug', '=', $slug)->with('posts')->first();

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    $a = $rubro;

    if ($autor) {
      return view('web.videosautor', compact('rubroSlug', 'autor', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM', 'a'));
    }
    return redirect('/');
    // dd($autor);      

  }

  public function getVideo($slug)
  {
    /* Obtiene el post mediate el slug */
    $post = Post::where('slug', '=', $slug)->with('video')->first();

    // Is_active_capacitacion
    // return $post->is_active;
    if (!\Auth::guest()) {
      if (!Auth()->user()->isAdmin()) {
       if ($post->is_active == '0') {
          return abort(404);
        }
      }
    } else {
      if ($post->is_active == '0') {
        return abort(404);
      }
    }

    $rubroSlug = $post->subcategoria->categoria->rubro->slug;


    $recents = Post::join('subcategoria as sc', 'posts.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')->where([['idpost', '<>', $post->idpost], ['type', '=', 'video']])->with('autor', 'subcategoria')->where('c.idcategoria', $post->subcategoria->idcategoria)->select('*', 'posts.slug as pslug')->withCount('vistas')->orderBy('vistas_count', 'desc')->limit(4)->get();


    $recents = Post::join('subcategoria as sc', 'posts.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')->where([['idpost', '<>', $post->idpost], ['type', '=', 'video']])->with('autor', 'subcategoria')->where('r.idrubro', $post->subcategoria->categoria->rubro->idrubro)->select('*', 'posts.slug as pslug')->withCount('vistas')->orderBy('vistas_count', 'desc')->limit(4)->get();
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU
    /* Determina si existe usuario autenticado */
    if (!\Auth::guest()) {


      /* Determina si el video es Premiun */
      if ($post->acceso == 1) {
        /* Determina si el usuario autenticado es diferente de Gratuito */
        if (!Auth()->user()->isFree()) {
          /* Registra una vista del vista del video */
          PostClick::create([
            'idpost' => $post->idpost,
            'user_id' => Auth()->user()->id,
            'user_ip' => $_SERVER['REMOTE_ADDR'],
          ]);
          create_user_log('Ha visto el video: ' . $post->titulo);
          /* Retorna la vista video */
          return view('web.video', compact('recents', 'rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        } else {
          /* Retorna la vista previa del video */
          return view('web.videopreview', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        }
      }

      /*Si el video es gratuito se ejectuta esta seccion de CODIGO */
      PostClick::create([
        'idpost' => $post->idpost,
        'user_id' => Auth()->user()->id,
        'user_ip' => $_SERVER['REMOTE_ADDR'],
      ]);
      create_user_log('Ha visto el video: ' . $post->titulo);


      return view('web.video', compact('recents', 'rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    }




    return view('web.videopreview', compact('rubroSlug', 'post', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getseries()
  {

    $rubros = Rubro::join('categoria as c', 'c.idrubro', '=', 'rubro.idrubro')->join('subcategoria as sc', 'c.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where('p.type', '=', 'serie')
      ->select('rubro.*')->distinct('rubro.idrubro')->get();

    $posts = Post::where('type', '=', 'serie')->with('subcategoria.categoria.rubro', 'clicks', 'autor', 'video')->orderBy('idpost', 'desc')->paginate(15);

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();
    return view('web.series', compact('rubroSlug', 'posts', 'rubros', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }
  public function seriesRubro($slug)
  {



    $rubro = Rubro::where('slug', '=', $slug)->first();
    $rubroSlug = $rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }


    $categorias = Categoria::join('subcategoria as sc', 'categoria.idcategoria', '=', 'sc.idcategoria')->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where([['p.type', '=', 'serie'], ['categoria.idrubro', '=', $rubro->idrubro]])
      ->select('categoria.idcategoria', 'categoria.nombrecategoria', 'categoria.slug')->distinct('categoria.idcategoria')->get();

    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', $rubro->idrubro]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->paginate(9);

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.seriesrubro', compact('rubroSlug', 'sliders', 'rubro', 'categorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }
  public function seriesCategoria($slug)
  {
    $categoria = Categoria::where('slug', '=', $slug)->first();
    $rubroSlug = $categoria->rubro->slug;
    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'serie'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->where([['posts.type', '=', 'serie'], ['sc.idcategoria', '=', $categoria->idcategoria]])
      ->select('*', 'posts.slug as pslug')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    return view('web.seriescategoria', compact('rubroSlug', 'sliders', 'categoria', 'subcategorias', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function seriesSubCategoria($slug)
  {
    $subcategoria = Subcategoria::where('slug', '=', $slug)->first();

    $categoria = Categoria::where('idcategoria', '=', $subcategoria->idcategoria)->first();
    $rubroSlug = $categoria->rubro->slug;
    $subcategorias = Subcategoria::join('posts as p', 'p.idsubcategoria', '=', 'subcategoria.idsubcategoria')->where([['p.type', '=', 'serie'], ['subcategoria.idcategoria', '=', $categoria->idcategoria]])->select('subcategoria.idsubcategoria', 'subcategoria.nombresubcategoria', 'subcategoria.slug')->distinct('subcategoria.idsubcategoria')->get();

    $posts = Post::where([['posts.type', '=', 'serie'], ['idsubcategoria', '=', $subcategoria->idsubcategoria]])
      ->select('*', 'posts.slug as pslug')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->orderBy('posts.idpost', 'desc')
      ->paginate(9);

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'serie')->where('rubro_id', $categoria->rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU
    return view('web.seriessubcategoria', compact('rubroSlug', 'subcategorias', 'sliders', 'categoria', 'subcategoria', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }


  public function getSerie($slug)
  {
    /* Obtiene el post mediate el slug */
    $post = Post::where('slug', '=', $slug)->first();



    $recents = Post::join('subcategoria as sc', 'posts.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')->where([['idpost', '<>', $post->idpost], ['type', '=', 'serie']])->with('autor', 'subcategoria')->where('c.idcategoria', $post->subcategoria->idcategoria)->select('*', 'posts.slug as pslug')->withCount('vistas')->orderBy('vistas_count', 'desc')->limit(4)->get();

    $recents = Post::join('subcategoria as sc', 'posts.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')->where([['idpost', '<>', $post->idpost], ['type', '=', 'serie']])->with('autor', 'subcategoria')->where('r.idrubro', $post->subcategoria->categoria->rubro->idrubro)->select('*', 'posts.slug as pslug')->withCount('vistas')->orderBy('vistas_count', 'desc')->limit(4)->get();


    $rubroSlug = $post->subcategoria->categoria->rubro->slug;
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU

    /* Determina si existe usuario autenticado */
    if (!\Auth::guest()) {
      /* Lista los 3 ultimos videos diferentes al video elegido */


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
            'user_id' => Auth()->user()->id,
            'user_ip' => $_SERVER['REMOTE_ADDR'],
          ]);
          create_user_log('Ha visto la serie: ' . $post->titulo);
          /* Retorna la vista video */
          return view('web.serie', compact('recents', 'rubroSlug', 'post', 'recents', 'btnDisabled', 'btnDisabled2', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        } else {
          /* Retorna la vista previa del video */
          $posts = Post::all();
          return view('web.seriepreview', compact('rubroSlug', 'post', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        }
      }

      /*Si el video es gratuito se ejectuta esta seccion de CODIGO */
      PostClick::create([
        'idpost' => $post->idpost,
        'user_id' => Auth()->user()->id,
        'user_ip' => $_SERVER['REMOTE_ADDR'],
      ]);
      create_user_log('Ha visto la serie: ' . $post->titulo);

      return view('web.serie', compact('recents', 'rubroSlug', 'post', 'recents', 'btnDisabled', 'btnDisabled2', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
    }

    /* Retorna la vista previa del video, si no existe usuarios autenticados */
    $posts = Post::all();
    return view('web.seriepreview', compact('rubroSlug', 'post', 'posts', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function getrevistas($medio = 'RC')
  {

    if ($medio == "DA") {
      $a = "arquitectura-y-diseno";
    } elseif ($medio == "RC") {
      $a = "construccion";
    } else {
      $a = "mineria";
    }

    $rubro = Rubro::where('slug', $a)->first();



    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'revista')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'revista')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'revista')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $revistas = Publicacion::where('medio', '=', $medio)->orderBy('nro', 'desc')->paginate(9);
    //cursos

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    return view('web.revistas', compact('rubroSlug', 'sliders', 'revistas', 'rubro', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
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

    if ($medio == "DA") {
      $a = "arquitectura-y-diseno";
    } elseif ($medio == "RC") {
      $a = "construccion";
    } else {
      $a = "mineria";
    }

    if (!\Auth::guest()) {
      if (!Auth()->user()->isFree()) {

        $publicacion = Publicacion::where([['nro', '=', $edicion], ['medio', '=', $medio]])->first();
        if ($publicacion != null) {

          $ruta = strtolower($medio) . '' . $edicion;

          //MENU 

          $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

          $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

          $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

          $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
            ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
            ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
            ->select('*', 'posts.slug as pslug')
            ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
            ->limit(2)->get();

          $videosA = $this->getVideoAAttribute();

          $videosC = $this->getVideoCAttribute();

          $videosM = $this->getVideoMAttribute();


          $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
            ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
            ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
            ->select('*', 'posts.slug as pslug')
            ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
            ->limit(2)->get();

          $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
            ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
            ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
            ->select('*', 'posts.slug as pslug')
            ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
            ->limit(2)->get();

          $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
            ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
            ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
            ->select('*', 'posts.slug as pslug')
            ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
            ->limit(2)->get();


          $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

          $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

          $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
          $rubroSlug = "";

          //MENU



          create_user_log('Ha visto la revista ' . $medio . $edicion);

          RevistaClick::create([
            'idpublicacion' =>  $publicacion->idpublicacion,
            'user_id'       => Auth()->user()->id,
            'user_ip'       => $_SERVER['REMOTE_ADDR'],
          ]);

          return view('web.revista', compact('rubroSlug', 'ruta', 'publicacion', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
        } else {
          return "El recurso no se encuentra!";
        }
      }
      //Retornando planes de suscripcion.
      return redirect()->route('planes', $a);
    }


    //Retornando planes de suscripcion.
    return redirect()->route('planes', $a);
  }
  public function getsuplemento()
  {



    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU



    $ip = $_SERVER['REMOTE_ADDR'];
    /* $datos=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip.''));
      $moneda=$datos["geoplugin_currencyCode"];*/
    $moneda = "PEN";

    if ($moneda == "PEN") {

      if (!\Auth::guest()) {
        if (Auth()->user()->isFree()) {
          // Vista para autenticados pero gratis
          return view('web.suplementoprev', compact('rubroSlug', 'sliders', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        }

        // Vista para suscriptores premium y otros roles
        $ediciones = Publicacion::where('suplemento', '=', 1)->orderBy('nro', 'desc')->get();
        $edicion = Publicacion::where('suplemento', 1)->orderBy('nro', 'desc')->first();
        $suplemento = Suplemento::where('nroedicion', '=', $edicion->nro)->get();
        return view('web.suplemento', compact('edicion', 'suplemento', 'ediciones', 'rubroSlug', 'sliders', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
      } else {
        // Vista para no autenticados
        return view('web.suplementoprev', compact('rubroSlug', 'sliders', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
      }
    } else {
      return redirect('/');
    }
  }

  public function changeSuplemento(Request $request)
  {
    $ediciones = Publicacion::where('suplemento', '=', 1)->orderBy('nro', 'desc')->get();
    $edicion = Publicacion::where('nro', '=', $request->edicion)->first();
    $suplemento = Suplemento::where('nroedicion', '=', $edicion->nro)->get();
    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'suplemento')->where('rubro_id', 2)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "construccion";

    //MENU

    return view('web.suplemento', compact('sliders', 'rubroSlug', 'edicion', 'suplemento', 'ediciones', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function downloadSuplemento($edicion, $filename)
  {
    $suplemento = public_path() . '/suplemento/' . $edicion . '/' . $filename;

    /*$suplemento = '/home/cons0507/pv/suplemento/'.$edicion.'/'.$filename;*/
    create_user_log('Descargó el suplemento: ' . $filename);

    return response()->download($suplemento);
  }

  public function searchQuery(Request $request)
  {
    $texto = $request->text;
    $posts = Post::where('titulo', 'like', '%' . $texto . '%')->orderBy('fecha', 'desc')->get();

    // $videos = Post::where('type', '=', 'video')->orderBy('idpost', 'desc')->limit(4)->get();
    // Is_active_capacitacion
    $videos = Post::where('type', '=', 'video')->where('is_active', true)->orderBy('idpost', 'desc')->limit(4)->get();

    $cursos = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('titulo', 'like', '%' . $texto . '%')->orderby('fecha', 'Desc')->limit(4)->get();

    $series = Post::where('type', '=', 'serie')->where('titulo', 'like', '%' . $texto . '%')->orderBy('posts.idpost', 'desc')
      ->with('serie', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(4)
      ->get();

    // $videos = Post::where('type', '=', 'video')->where('titulo', 'like', '%' . $texto . '%')->orderBy('posts.idpost', 'desc')
    //   ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(4)
    //   ->get();
    // Is_active_capacitacion
    $videos = Post::where('type', '=', 'video')
      ->where('is_active', true)->where('titulo', 'like', '%' . $texto . '%')->orderBy('posts.idpost', 'desc')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(4)
      ->get();



    $articulos = Post::where('type', '=', 'articulo')->where('titulo', 'like', '%' . $texto . '%')->orderBy('posts.idpost', 'desc')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor')->limit(4)
      ->get();



    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "construccion";

    //MENU     

    return view('web.results', compact('rubroSlug', 'posts', 'texto', 'videos', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'cursos', 'series', 'videos', 'articulos'));
  }

  //cambios
  public function searchQueryRubro($slug, Request $request)
  {



    $rubro = Rubro::where('slug', '=', $slug)->first();
    $texto = $request->text;
    $categorias = Categoria::join('subcategoria as sc', 'categoria.idcategoria', '=', 'sc.idcategoria')
      ->join('posts as p', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->where([['p.type', '=', 'articulo'], ['categoria.idrubro', '=', $rubro->idrubro]])
      ->select('categoria.idcategoria', 'categoria.nombrecategoria', 'categoria.slug')
      ->distinct('categoria.idcategoria')
      ->get();


    $posts = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['titulo', 'like', '%' . $texto . '%'], ['c.idrubro', '=', $rubro->idrubro]])
      ->select('posts.*')->where('titulo', 'like', '%' . $texto . '%')->orderBy('fecha', 'desc')->limit(10)->get();

    // $videos = Post::where('type', '=', 'video')->orderBy('idpost', 'desc')->limit(4)->get();
    // Is_active_capacitacion
    $videos = Post::where('type', '=', 'video')->where('is_active', true)->orderBy('idpost', 'desc')->limit(4)->get();

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    return view('web.results', compact('rubroSlug', 'posts', 'texto', 'videos', 'cursosC', 'cursosM', 'cursosA', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }


  public function getEventos()
  {
    $active_events = Event::where('status', 1)->with('type_event', 'rubro')->orderBy('date_init', 'asc')->get();
    $inactive_events = Event::where('status', 0)->with('type_event', 'rubro')->orderBy('date_init', 'asc')->get();
    $rubros = Rubro::whereHas('events')->withCount('events')->get();
    return view('web.eventos', compact('active_events', 'inactive_events', 'rubros'));
  }


  public function getPremiumDataRecurrente($id)
  {
    try {
      $user = User::where('id', '=', $id)->first();
      $ul = SuscriptorRecurrente::where('user_id', '=', $user->id)->orderBy('id', 'desc')->first();

      $suscripcion = $this->culqi->Subscriptions->get($ul->id_culqi);


      return response()->json($suscripcion);
    } catch (Exception $e) {

      return response()->json($e->getMessage(), 500);
    }
  }
  //Buscar Cargo Pago Efectivo
  public function getCargoPagoEfectivoData($id, $id_culqi)
  {
    try {
      $user = User::where('id', '=', $id)->first();
      $ul = SuscriptorEfectivo::where('user_id', '=', $user->id)->where('id_culqi', '=', $id_culqi)->orderBy('id', 'desc')->first();

      $suscripcion = $this->culqi->Orders->get($ul->id_culqi);
      return response()->json($suscripcion);
    } catch (Exception $e) {

      return response()->json($e->getMessage(), 500);
    }
  }
  public function destroyPremiumrecurrente($id)
  {

    $user = User::where('id', '=', $id)->first();
    $suscripcion = SuscriptorRecurrente::where('user_id', '=', $user->id)->first();
    $suscripcion = SuscriptorRecurrente::find($suscripcion->id);
    // $this->culqi->Cards->delete($user->tarjeta_id);
    try {
      $this->culqi->Subscriptions->delete($suscripcion->id_culqi);
    } catch (\Throwable $th) {
      create_user_log('Forzando la anulación de la suscripción de ' . strtoupper($user->fullName())); // Crea un log en el sistema
    }

    $user = User::find($user->id);
    $user->role_id = '7';
    $user->tarjeta_id = '';
    $user->tarjeta_token = '';
    $user->save();

    $suscripcion->delete();
 
    create_user_log('Anuló la suscripción de ' . strtoupper($user->fullName())); // Crea un log en el sistema

    return response()->json(['message' => 'Suscripcion anulada', 'status' => 200]);
  }

  //Cursos

  public function cursosRubro($slug)
  {
    $rubro = Rubro::where('slug', $slug)->first();

    $rubroSlug = $rubro->slug;




    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $cursosP = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>=', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursosD = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '<', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursos = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU



    return view('web.cursos', compact('rubroSlug', 'cursos', 'rubro', 'sliders', 'cursosD', 'cursosP', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function cursosVivo($slug)
  {
    $rubro = Rubro::where('slug', $slug)->first();

    $rubroSlug = $rubro->slug;

    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $cursosP = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>=', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursosD = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '<', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursos = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU



    return view('web.cursos-vivo', compact('rubroSlug', 'cursos', 'rubro', 'sliders', 'cursosD', 'cursosP', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }
  public function cursosReal($slug)
  {
    $rubro = Rubro::where('slug', $slug)->first();

    $rubroSlug = $rubro->slug;


    if (!\Auth::guest()) {
      if (Auth()->user()->isFree()) {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
      } else {

        $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->where('acceso', 1)->orderby('orden', 'Asc')->get();
      }
    } else {

      $sliders = Slider_Rubro::where('type', 'curso')->where('rubro_id', $rubro->idrubro)->where('estado', 1)->orderby('orden', 'Asc')->get();
    }

    $cursosP = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>=', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursosD = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '<', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);

    $cursos = Curso::where('rubro_id', $rubro->idrubro)->where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->paginate(9);


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();


    //MENU



    return view('web.cursos-real', compact('rubroSlug', 'cursos', 'rubro', 'sliders', 'cursosD', 'cursosP', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function beneficios()
  {


    /*$cursos=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','>=',date('Y-m-d'))->orderby('id','Desc')->get();

       $cursosP=Curso::where('rubro_id',$id)->where('estado','=','1')->where('expira','>',date('Y-m-d'))->where('fecha_culminacion','<',date('Y-m-d'))->orderby('id','Desc')->get();


      $cursos1=Curso::where('rubro_id',$id)->where('estado','=','1')->where('fecha_culminacion','>=',date('Y-m-d'))->where('expira','>',date('Y-m-d'))->inRandomOrder()->limit(3)->get();*/

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('fecha_culminacion', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    if (Auth()->user()->susplan100r() > 0 or Auth()->user()->susplan100d() > 0) {

      if (Auth()->user()->countsusgratis() < 1) {

        return view('web.beneficios', compact('cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
      } else {
        return redirect()->route('getmiscursos');
      }
    } else {
      return redirect()->route('suscription');
    }
  }

  public function beneficiocurso($slug)
  {
    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    $curso = Curso::where('slug', $slug)->first();
    $clases = Clase::where('curso_id', $curso->id)->where('estado', '=', '1')->get();
    $clase1 = Clase::where('curso_id', $curso->id)->where('estado', '=', '1')->first();
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();

    $sponsors_cursos = SponsorCurso::where('curso_id', $curso->id)->get();
    $sponsors = Sponsor::get();

    $sponsor_contacts = SponsorContact::get();

    $sponsor_materiales = SponsorMaterial::get();

    $evaluacion = Evaluacion::where('curso_id', $curso->id)->orderby('id', 'desc')->first();

    /*$evaluacion_user=EvaluacionUser::where('evaluacion_id',$evaluacion->id)->get();*/

    $comentarios = ComentarioCurso::where('curso_id', $curso->id)->orderby('id', 'desc')->get();


    $respuestas = RespuestaCurso::orderby('id', 'asc')->get();

    $materiales = Material::where('curso_id', $curso->id)->get();

    $temas = Tema::where('curso_id', $curso->id)->get();






    $newcurso = CursoVista::where('curso_id', '=', $curso->id)->where('created_at', '=', date("Y-m-d"))->count();
    //Si es mayor que 0 aun no tiene vistas
    if (Auth()->user()->susplan100r() > 0 or Auth()->user()->susplan100d() > 0) {

      if (Auth()->user()->countsusgratis() < 1) {

        if ($curso->estado == 1 and $curso->expira > date('Y-m-d') and Auth()->user()->countsusgratis() < 1) {
          if ($newcurso >= 1) {
            $vistasup = CursoVista::where('curso_id', '=', $curso->id)->where('created_at', '=', date("Y-m-d"))->first();
            $vistasup->cant_visto++;
            $vistasup->updated_at = date("Y-m-d");
            $vistasup->save();
          } else {
            $vista = new CursoVista();
            $vista->curso_id = $curso->id;
            $vista->cant_visto = 1;
            $vista->created_at = date("Y-m-d");
            $vista->save();
          }



          if (Auth()->user()->SuscriptorCursos($curso->id)) {

            return redirect()->route('getcurso', $curso->slug);
          }
          //desabilitado curso gratis al suscribirse al plan anual
          return back()->with('');

          return view('web.beneficio', compact('curso', 'clases', 'rubro', 'slug', 'evaluacion', 'comentarios', 'temas', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
        } else {
          return back()->with('');
        }
      } else {
        return redirect()->route('getmiscursos');
      }
    } else {
      return redirect()->route('suscription');
    }
  }
  public function beneficiocreate(Request $request)
  {
    $curso = Curso::where('id', '=', $request->curso_id)->first();

    $suscriptor = SuscriptorCursos::create([
      'user_id' =>  Auth()->user()->id,
      'curso_id' =>  $request->curso_id,
      'id_culqi' => 'Null',
      'responsable' => "18207",
      'nro_comprobante' => "CURSOGRATIS"
    ]);


    /* Array de datos para enviar por correo */
    $data = [
      'name'  => Auth()->user()->name,
      'email' => Auth()->user()->email,
      'curso'  => $curso->titulo,
      'amount' => '00',
      'rubro' => $curso->rubro->nombrerubro,
      'slug' => $curso->slug,
      'user_message' => 'participación con éxito'

    ];

    Mail::to(Auth()->user()->email)
      ->cc('info@constructivo.com')
      ->send(new SusCursoM($data));


    return redirect('curso/' . $curso->slug);
  }
  public function getmiscursos()
  {

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    $cursos = Curso::get();


    return view('web.miscursos', compact('cursos', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }

  public function getmisintereses()
  {

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    $cursos = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->get();
    return view('web.misintereses', compact('cursos', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }

  public function getcurso($slug)
  {




    $curso = Curso::where('slug', $slug)->with('autor', 'rubro')->first();
    $clases = Clase::where('curso_id', $curso->id)->where('estado', '=', '1')->orderby('fecha', 'asc')->get();
    $clase1 = Clase::where('curso_id', $curso->id)->where('estado', '=', '1')->first();
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();


    $comentarios = ComentarioCurso::where('curso_id', $curso->id)->orderby('id', 'desc')->get();
    $respuestas = RespuestaCurso::orderby('id', 'asc')->get();

    if ($curso->precio_c > 0) {
      $descuento = round((100 * ($curso->precio_c - $curso->promocion_c)) / $curso->precio_c, 2);
    } else {
      $descuento = 0;
    }

    if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d')) {
      $dia_n = date("d", strtotime($curso->fecha_d_v));
      $año_n = date("Y", strtotime($curso->fecha_d_v));
      $mes_n = date("m", strtotime($curso->fecha_d_v));

      setlocale(LC_TIME, "spanish");

      $fecha = DateTime::createFromFormat('!m', $mes_n);
      $mes = strftime("%B", $fecha->getTimestamp()); // marzo
      //precio descuento free soles
      $precio_d_f_s = number_format($curso->precio - (($curso->porcentaje_d_v * $curso->precio) / 100), 2);

      //precio descuento premium soles
      $promocion_d_p_s = number_format($curso->promocion - (($curso->porcentaje_d_v * $curso->promocion) / 100), 2);

      //precio descuento free dolar
      $precio_d_f_d = number_format($curso->precio_d - (($curso->porcentaje_d_v * $curso->precio_d) / 100), 2);

      //precio descuento premium dolar
      $promocion_d_p_d = number_format($curso->promocion_d - (($curso->porcentaje_d_v * $curso->promocion_d) / 100), 2);
    }
    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU







    $newcurso = CursoVista::where('curso_id', '=', $curso->id)->where('created_at', '=', date("Y-m-d"))->count();
    //Si es mayor que 0 aun no tiene vistas
    if (!\Auth::guest()) {

      if (Auth()->user()->SuscriptorCursosG($curso->id) or Auth()->user()->SuscriptorCursosC($curso->id)) {
        //return view('web.curso1', compact('rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
      return view('web.curso_new_suscripto', compact('rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
      }
    }



    if ($curso->estado == 1 and $curso->expira > date('Y-m-d')) {
      if ($newcurso >= 1) {
        $vistasup = CursoVista::where('curso_id', '=', $curso->id)->where('created_at', '=', date("Y-m-d"))->first();
        $vistasup->cant_visto++;
        $vistasup->updated_at = date("Y-m-d");
        $vistasup->save();
      } else {
        $vista = new CursoVista();
        $vista->curso_id = $curso->id;
        $vista->cant_visto = 1;
        $vista->created_at = date("Y-m-d");
        $vista->save();
      }

      if (!\Auth::guest()) {

        if (Auth()->user()->isAdmin() or Auth()->user()->isContentManager() or Auth()->user()->isSuscriptorManager()  or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado() or Auth()->user()->SuscriptorCursos($curso->id)) {

         // return view('web.curso1', compact('rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
          return view('web.curso_new_suscripto', compact('rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        } else {
          // return view('web.curso', compact('promocion_d_p_d', 'promocion_d_p_s', 'precio_d_f_d', 'precio_d_f_s', 'mes_n', 'dia_n', 'año_n', 'mes', 'descuento', 'rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
          return view('web.curso_new', compact('promocion_d_p_d', 'promocion_d_p_s', 'precio_d_f_d', 'precio_d_f_s', 'mes_n', 'dia_n', 'año_n', 'mes', 'descuento', 'rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        }
      } else {
        // return view('web.curso', compact('promocion_d_p_d', 'promocion_d_p_s', 'precio_d_f_d', 'precio_d_f_s', 'mes_n', 'dia_n', 'año_n', 'mes', 'descuento', 'rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
        return view('web.curso_new', compact('promocion_d_p_d', 'promocion_d_p_s', 'precio_d_f_d', 'precio_d_f_s', 'mes_n', 'dia_n', 'año_n', 'mes', 'descuento', 'rubroSlug', 'comentarios', 'respuestas', 'curso', 'rubro', 'clases', 'clase1', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
      }
    } else {
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
      'message' => 'Like guardado con éxito'
    ]);
  }

  public function saveInteresCurso(Request $request)
  {
    InteresCurso::create([
      'curso_id'  => $request->curso_id,
      'user_id' => Auth()->user()->id,
    ]);
    $curso = Curso::where('id', $request->curso_id)->first();

    $data = [
      'email' => Auth()->user()->email,
      'fullname' => Auth()->user()->fullname(),
      'phone_number' => Auth()->user()->phone_number,
      'curso'  => $curso->titulo,
      'rubro' => $curso->rubro->nombrerubro,
      'user_message' => 'Usuario interesado',
    ];

    /*Mail::to('info@constructivo.com','Rocio')
            ->cc*/
    Mail::to('postmaster3@constructivo.com')
      ->cc('info@constructivo.com')
      ->send(new InteresCursoM($data));



    return response()->json([
      'message' => 'Interes guardado con éxito'
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
      'message' => 'Comentario guardado'
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
      'message' => 'Respuesta  guardado'
    ]);
  }

  public function getevaluacion($slug)
  {

    $curso = Curso::where('slug', $slug)->first();
    $evaluacion = Evaluacion::where('curso_id', $curso->id)->first();
    $cuestionario = Cuestionario::where('evaluacion_id', $evaluacion->id)->get();
    $respuestas = Respuestas::orderby('id', 'asc')->get();

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();


    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    return view('web.evaluacion', compact('curso', 'evaluacion', 'cuestionario', 'respuestas', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }


  public function getresultado($slug)
  {

    $curso = Curso::where('slug', $slug)->first();
    $evaluacion = Evaluacion::where('curso_id', $curso->id)->first();
    $cuestionario = Cuestionario::where('evaluacion_id', $evaluacion->id)->get();
    $respuestas = Respuestas::orderby('id', 'asc')->get();

    $evaluacion = Evaluacion::where('curso_id', $curso->id)->orderby('id', 'desc')->first();
    $evaluacion_user = EvaluacionUser::where('evaluacion_id', $evaluacion->id)->where('user_id', Auth()->user()->id)->orderby('id', 'desc')->first();

    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();

    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    if (Auth()->user()->SuscriptorCursos($curso->id)) {

      return view('web.resulEval', compact('curso', 'evaluacion', 'cuestionario', 'respuestas', 'evaluacion', 'evaluacion_user', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
    } else {
      return redirect('curso/' . $curso->slug);
    }
  }

  public function getclases($slug)
  {

    $curso = Curso::where('slug', $slug)->first();
    $clases = Clase::where('curso_id', $curso->id)->get();
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();

    $comentarios = ComentarioCurso::where('curso_id', $curso->id)->orderby('id', 'desc')->get();
    $respuestas = RespuestaCurso::orderby('id', 'asc')->get();


    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU
    if (!\Auth::guest()) {
      if (Auth()->user()->SuscriptorCursosG($curso->id)) {

        return view('web.clases', compact('curso', 'clases', 'rubro', 'slug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
      }
    }

    if ($curso->estado == 1 and $curso->expira > date('Y-m-d')) {
      if (!\Auth::guest()) {

        if (Auth()->user()->SuscriptorCursos($curso->id)) {

          return view('web.clases', compact('curso', 'clases', 'rubro', 'slug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
        } else {
          return redirect('curso/' . $curso->slug);
        }
      } else {
        return redirect('login');
      }
    } else {
      return back()->with('');
    }
  }


  public function getclase($slug)
  {
    $clase = Clase::where('slug', $slug)->first();

    $clases = Clase::where('curso_id', $clase->curso->id)->where("estado", 1)->orderBy('id', 'asc')->get();

    $curso = Curso::where('id', $clase->curso->id)->first();

    $materiales = Material::where('curso_id', $clase->curso_id)->get();

    $comentarios = ComentarioCurso::where('curso_id', $curso->id)->orderby('id', 'desc')->get();
    $respuestas = RespuestaCurso::orderby('id', 'asc')->get();

    $encuestas = Encuestas_Curso::where('curso_id', $curso->id)->orderby('id', 'desc')->get();

    $preguntas = Preguntas_Encuestas_Curso::orderby('id', 'asc')->get();

    $cursosrel = Curso::where('rubro_id', $curso->rubro_id)->limit(4)->get();

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU



    if (!\Auth::guest()) {

      if (Auth()->user()->SuscriptorCursosG($curso->id) or Auth()->user()->SuscriptorCursosC($curso->id)) {

        return view('web.clase', compact('curso', 'cursosrel', 'encuestas', 'preguntas', 'comentarios', 'respuestas', 'rubroSlug', 'materiales', 'clase', 'clases', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
      }
    }



    if ($curso->estado == 1 and $clase->estado == 1 and $curso->expira > date('Y-m-d')) {


      if (!\Auth::guest()) {

        if (Auth()->user()->isAdmin() or Auth()->user()->isContentManager() or Auth()->user()->isSuscriptorManager()  or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado() or Auth()->user()->SuscriptorCursos($curso->id)) {

          return view('web.clase', compact('curso', 'cursosrel', 'encuestas', 'preguntas', 'comentarios', 'respuestas', 'rubroSlug', 'materiales', 'clase', 'clases', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM'));
        } else {

          return redirect()->route('getcurso', $curso->slug);
        }
      } else {

        return redirect()->route('getcurso', $curso->slug);
      }
    } else {
      return redirect('/');
    }
  }
  public function envcuestionario(Request $request)
  {

    $c = Cuestionario::where('evaluacion_id', $request->evaluacion_id)->count();
    $evaluacion = Evaluacion::where('id', $request->evaluacion_id)->first();
    $curso = Curso::where('id', $evaluacion->curso_id)->first();

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
    $total_buenas = 0;

    for ($x = 1; $x <= $c; $x++) {

      $total_buenas += $request['respuesta' . $x];
    }
    $total_malas = $c - $total_buenas;

    $evaluacionuser = new EvaluacionUser();
    $evaluacionuser->evaluacion_id = $request->evaluacion_id;
    $evaluacionuser->user_id =  Auth()->user()->id;
    $evaluacionuser->total_buenas = $total_buenas;
    $evaluacionuser->total_malas = $total_malas;


    for ($x = 1; $x <= $c; $x++) {



      $evaluacionuser['respuesta' . $x] = $request['respuesta' . $x];
      $evaluacionuser->evaluacion_id = $request->evaluacion_id;
      $evaluacionuser->user_id =  Auth()->user()->id;
    }
    $evaluacionuser->save();

    Session::flash('msg', '¡Registro exitoso!');
    return redirect('resultado/' . $curso->slug);
  }



  public function suscripcioncurso(Request $request)
  {
    $curso = Curso::find($request->CursoId);
    $user = Auth()->user();
    $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();
    $pago = $request->amount * 100;
    $moneda = $request->currency;
    $plan = Plan::where('id', '2')->first();

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
      } else {

        if ($curso->rubro->idrubro != 1 and $curso->fecha_culminacion >= date('Y-m-d')) {
          $usr = User::find(Auth()->user()->id);
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

          //Guardando pago
          Pago::create([
            'suscriptor_id' =>  $suscrip->id,
            'monto'         =>  0.00,
            'moneda'         =>  $plan->moneda,
            'nro_comprobante' => 'COMPRA_CURSO',
            'metodopago_id' =>  2,
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
          'user_id' =>  Auth()->user()->id,
          'curso_id' =>  $curso->id,
          'id_culqi' => $cargo->id,
          'suscription_end' => date('Y-m-d', $nuevafecha),
          'responsable' => "18207",
          'moneda' => $moneda,
        ]);
      } else {

        $suscriptor = SuscriptorCursos::create([
          'user_id' =>  Auth()->user()->id,
          'curso_id' =>  $curso->id,
          'id_culqi' => $cargo->id,
          'responsable' => "18207",
          'moneda' => $moneda,
        ]);
      }




      /* Array de datos para enviar por correo */
      $data = [
        'name'  => Auth()->user()->name,
        'email' => Auth()->user()->email,
        'curso'  => $curso->titulo,
        'amount' => $request->amount,
        'moneda' => $moneda,
        'rubro' => $rubro->nombrerubro,
        'slug' => $curso->slug,
        'user_message' => 'participación con éxito'

      ];

      /*Mail::to(Auth()->user()->email)
            ->cc('info@constructivo.com')
            ->send(new SusCursoM($data));*/

      return response()->json($cargo);
    } catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
  }

  public function SaveCertificado(Request $request)
  {

    $validation = \Validator::make($request->all(), [
      'email' => 'required|email',
      'nombres' => 'required|string',
      'celular' => 'required|numeric'

    ], [
      'email.required' => 'Ingrese su email',
      'nombres.required' => 'Ingrese nombres completos',
      'celular.required' => 'Ingrese número telefónico'
    ]);

    if ($validation->fails()) {
      return response()->json(['errors' => $validation->errors(), 'status' => 422]);
    }

    $certificado = new CertificadoCurso();
    $certificado->curso_id =  $request->curso_id;
    $certificado->user_id =   Auth()->user()->id;
    $certificado->email =  $request->email;
    $certificado->fullname =  $request->nombres;
    $certificado->phone_number =  $request->celular;
    $certificado->estado = "0";
    $certificado->save();

    $curso = Curso::where('id', $request->curso_id)->first();


    $data = [
      'email' => $certificado->email,
      'fullname' => $certificado->fullname,
      'phone_number' => $certificado->phone_number,
      'curso'  => $curso->titulo,
      'rubro' => $curso->rubro->nombrerubro,
      'user_message' => 'Solicitud de certificado',
    ];

    /*Mail::to('info@constructivo.com','Rocio')
            ->cc*/
    Mail::to('postmaster3@constructivo.com')
      ->cc('info2@constructivo.com')
      ->send(new CertCurso($data));




    return back()->with('message', 'Sus datos han sido enviados con éxito, nos contactaremos con ud. ¡Gracias!');
  }

  public function getCursos()
  {
    $cursos = Curso::Where('estado', 1)->get();

    $users = User::where('role_id', 8)->orWhere('role_id', 6)->get();

    // return response()->json($cursos);

    return response()->json(['cursos' => $cursos, 'gestores' => $users]);
  }

  public function encuesta_user(Request $request)
  {

    $encuesta = Encuestas_Curso::where('id', $request->encuesta_id)->first();
    $preguntas = Preguntas_Encuestas_Curso::where('encuesta_id', $encuesta->id)->get();

    $curso = Curso::where('id', $encuesta->curso_id)->first();

    foreach ($preguntas as $pregunta) {

      if ($pregunta->tipo_respuesta == 0) {

        $respuestauser = Respuestas_Preguntas_Curso::create([
          'valor' => $request['pregunta' . $pregunta->id . 'x'],
          'pregunta_id' => $pregunta->id,
          'user_id' => Auth()->user()->id,
        ]);
      } else {

        $respuestausert = Respuestas_Preguntas_Curso::create([
          'texto' => $request['respuesta' . $pregunta->id . 'x'],
          'pregunta_id' => $pregunta->id,
          'user_id' => Auth()->user()->id,
        ]);
      }
    }

    $respuestas = Respuestas_Preguntas_Curso::where('user_id', Auth()->user()->id)->get();


    $data = [
      'name' => Auth()->user()->name,
      'last_name' => Auth()->user()->last_name,
      'email' => Auth()->user()->email,
      'phone_number' => Auth()->user()->phone_number,
      'role' => Auth()->user()->role->name,
      'curso' => $curso->titulo,
      'rubro' => $curso->rubro->nombrerubro,
      'encuesta' => $encuesta->titulo,
      'preguntas' => $preguntas,
      'respuestas' => $respuestas,
      'fecha'  => date('Y-m-d'),

    ];

    Mail::to("info@constructivo.com")->cc("postmaster3@constructivo.com")->send(new EncuestaMail($data));

    // Mail::to("postmaster3@constructivo.com")->send(new EncuestaMail($data));

    Session::flash('msg', '¡Registro exitoso!');
    return redirect('curso/' . $curso->slug);
  }
  public function agradecimiento()
  {

    //MENU 

    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";

    //MENU


    return view('web.agradecimiento', compact('rubroSlug', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM'));
  }

  public function agradecimientode()
  {

    $a = "construccion";
    //cursos
    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '1')->limit(3)->get();
    $cursosM = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '3')->limit(3)->get();
    $cursosC =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->where('rubro_id', '=', '2')->limit(3)->get();


    $seriesA = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '1'], ['p.type', '=', 'serie']])->count();

    $seriesM = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '3'], ['p.type', '=', 'serie']])->count();

    $seriesC = DB::table('posts as p')
      ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
      ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
      ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
      ->where([['r.idrubro', '=', '2'], ['p.type', '=', 'serie']])->count();

    $colaboradoresA = Colaboradores::where('rubro_id', '1')->orderby('orden', 'asc')->get();
    $colaboradoresC = Colaboradores::where('rubro_id', '2')->orderby('orden', 'asc')->get();
    $colaboradoresM = Colaboradores::where('rubro_id', '3')->orderby('orden', 'asc')->get();

    return view('web.agradecimientode', compact('a', 'cursosC', 'cursosA', 'cursosM', 'seriesA', 'seriesM', 'seriesC', 'colaboradoresA', 'colaboradoresC', 'colaboradoresM'));
  }



  public function mailCursoInteres(Request $request)
  {
    $validation = \Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'required|string',
      'phone' => 'required|numeric',
    ]);
    if ($validation->fails()) {
      // return response()->json(['errors' => $validation->errors(), 'status' => 422]);
      return redirect()->back()->with('msg-error', 'Por favor completar los campos necesarios');
      // return redirect()->route('getcurso',$request->slug)->with('msg-error','Por favor completar los campos necesarios');
    } else {

      $curso = Curso::where('slug', $request->slug)->with('autor', 'rubro')->first();

      $data = [
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'curso'  => $curso->titulo,
        'rubro' => $curso->rubro->nombrerubro,
        'slug' => $curso->slug,
      ];

      Mail::to('info2@constructivo.com')
        ->send(new MailFormCurso($data));

      // return $request->all();

      return redirect()->route('getcurso', $request->slug)->with('msg', 'Se envio el correo exitosamente');
    }
  }



  public function checkout(Request $request)
  {

    $plan = [];
    $curso = [];
    $suscriptor_recurrente = [];
    $suscriptor_curso = [];
    $moneda = $request->moneda;

    //MENU  
    $rubros = Rubro::where('estado', 1)->get();

    $rubro = Rubro::where('estado', 1)->inrandomOrder()->first();

    $colaboradores = Colaboradores::where('estado', 1)->where('prioridad', 1)->orderby('orden', 'asc')->get();

    $colaboradores = $colaboradores->unique('nombre');

    $autores = Autor::with('posts.subcategoria.categoria.rubro')->where('principal', 1)->get();

    $autores = $autores->unique('idautor');

    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();


    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();
    $rubroSlug = "";
    //MENU  
    // return $request->all(); 
    if ($request->plan != null) {
      $suscriptor_recurrente = SuscriptorRecurrente::where('id_culqi', $request->rec)->where('user_id', auth()->user()->id)->first();
      $plan = Plan::where('slug',  $request->plan)->first();

      if ($suscriptor_recurrente) {
        if ($plan) {
          $suscripcion = $this->culqi->Subscriptions->get($request->rec);
          $id_culqi = $suscriptor_recurrente->id_culqi;
          //Verificar si se suscribio
          if (!\Auth::guest()) {
            // 2 = rol suscriptor premium
            if (auth()->user()->role->id == 2) {
              //Valida la caducidad del suscriptor
              if (auth()->user()->tarjeta_id == '') {
                if (date('Y-m-d') < auth()->user()->suscriptorDeposito->suscription_end) {
                  //si es vigente, pasa al siguiente proceso
                  return view('web.checkout', compact('plan', 'curso', 'suscriptor_recurrente', 'id_culqi', 'moneda', 'rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
                } else {
                  // si la suscripcion fue expirada retorna, lo siguiente 
                  Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                  return view('web.checkout', compact('plan', 'curso', 'suscriptor_recurrente', 'id_culqi', 'moneda', 'rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
                }
              } else {
                return redirect()->route('getmicuenta');
                // return view('web.checkout', compact('plan', 'curso','suscriptor_recurrente','id_culqi', 'moneda', 'rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
              }
            } else {
              return redirect()->route('home');
            }
          }
          // return $plan;
          // return response()->json($suscripcion);
        } else {
          return redirect()->route('home');
        }
      } else {
        return redirect()->route('home');
      }
    } elseif ($request->c_slug != null) {
      $suscriptor_curso = SuscriptorCursos::where('id_culqi', $request->rec)->where('user_id', auth()->user()->id)->first();
      $curso = Curso::where('slug', $request->c_slug)->with('autor', 'rubro')->first();

      if ($suscriptor_curso) {
        if ($curso) {
          $suscripcion = $this->culqi->Charges->get($request->rec);
          $id_culqi = $suscriptor_curso->id_culqi;
          //Verificar si se compro el curso el usuario
          // return $suscriptor_curso->id_culqi;
          if (!\Auth::guest()) {
            if (Auth()->user()->isAdmin() or Auth()->user()->isContentManager() or Auth()->user()->isSuscriptorManager()  or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado() or Auth()->user()->SuscriptorCursos($curso->id)) {
              return view('web.checkout', compact('plan', 'curso', 'suscriptor_recurrente', 'id_culqi', 'moneda', 'rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
            }
          }
          // return $curso;
          // return response()->json($suscripcion);
        } else {
          return redirect()->route('home');
        }
        // return $curso;
        // return response()->json($suscripcion);
      } else {
        return redirect()->route('home');
      }
    }
  }


  public function new_checkout(Request $request)
  {

    $plan = [];
    $curso = [];
    $suscriptor_recurrente = [];
    $suscriptor_curso = [];
    // $moneda = $request->moneda; 

    //MENU  
    $rubros = Rubro::where('estado', 1)->get();

    $rubro = Rubro::where('estado', 1)->inrandomOrder()->first();

    $colaboradores = Colaboradores::where('estado', 1)->where('prioridad', 1)->orderby('orden', 'asc')->get();

    $colaboradores = $colaboradores->unique('nombre');

    $autores = Autor::with('posts.subcategoria.categoria.rubro')->where('principal', 1)->get();

    $autores = $autores->unique('idautor');

    $planes = Plan::where('status', '=', 1)->where('moneda', '=', "PEN")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();

    $planesD = Plan::where('status', '=', 1)->where('moneda', '=', "USD")->where('id', '<>', 5)->orderBy('precio', 'asc')->get();


    $cursosA = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '1')->limit(2)->get();

    $cursosC = Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '2')->limit(2)->get();

    $cursosM =  Curso::where('estado', '=', '1')->where('expira', '>', date('Y-m-d'))->orderby('fecha', 'Desc')->where('rubro_id', '=', '3')->limit(2)->get();

    $seriesA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'serie'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('video', 'clicks', 'subcategoria.categoria.rubro', 'autor')
      ->limit(2)->get();

    $videosA = $this->getVideoAAttribute();

    $videosC = $this->getVideoCAttribute();

    $videosM = $this->getVideoMAttribute();

    $articulosA = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 1]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosC = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 2]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();

    $articulosM = Post::join('subcategoria as sc', 'sc.idsubcategoria', '=', 'posts.idsubcategoria')
      ->join('categoria as c', 'c.idcategoria', '=', 'sc.idcategoria')
      ->where([['posts.type', '=', 'articulo'], ['c.idrubro', '=', 3]])->orderBy('posts.idpost', 'desc')
      ->select('*', 'posts.slug as pslug')
      ->with('paper', 'clicks', 'subcategoria.categoria.rubro', 'autor', 'downloads', 'valoraciones')
      ->limit(2)->get();


    $revistasA = Publicacion::where('medio', '=', 'DA')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasC = Publicacion::where('medio', '=', 'RC')->orderBy('nro', 'desc')->limit(2)->get();

    $revistasM = Publicacion::where('medio', '=', 'TM')->orderBy('nro', 'desc')->limit(2)->get();

    $rubroSlug = "";
    //MENU  
    return view('web.new_checkout', compact('rubroSlug', 'rubro', 'rubros', 'colaboradores', 'cursosA', 'cursosC', 'cursosM', 'seriesA', 'videosA', 'videosC', 'videosM', 'revistasA', 'revistasC', 'revistasM', 'articulosA', 'articulosC', 'articulosM', 'videosA', 'videosC', 'videosM', 'autores', 'planes', 'planesD'));
  
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
