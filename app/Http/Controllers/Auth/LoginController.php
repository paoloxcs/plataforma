<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Medio;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Requests;

use App\Post;
use App\Curso;
use App\Publicacion;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     protected  $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

 public function showLoginForm(Request $request)
{

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


    if ($request->has('redirect_to')) {
        session()->put('redirect_to', $request->input('redirect_to'));
    }
    
    return view('auth.login',compact('rubroSlug','cursosA','cursosC','cursosM','seriesA','videosA','videosC','videosM','revistasA','revistasC','revistasM','articulosA','articulosC','articulosM'));
}

public function redirectTo()
{
    if (session()->has('redirect_to')){
        return session()->pull('redirect_to');
    }


    return $this->redirectTo;
}
protected function sendLoginResponse(Request $request)
{
    $request->session()->regenerate();
    $previous_session = Auth::User()->session_id;
    if ($previous_session) {
        \Session::getHandler()->destroy($previous_session);
    }

    Auth::user()->session_id = \Session::getId();
    Auth::user()->save();
    $this->clearLoginAttempts($request);

    return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
}  
}
