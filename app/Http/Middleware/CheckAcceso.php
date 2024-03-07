<?php

namespace App\Http\Middleware;

use App\Post;
use Closure;
use Session;
class CheckAcceso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Valida si existe un usuario autenticado
        if (!\Auth::guest()) {
           // 2 = rol suscriptor premium
           if ($request->user()->role->id == 2 ) {
            //Valida la caducidad del suscriptor
            if ($request->user()->tarjeta_id=='') {
             
              if ($request->user()->suscriptorDeposito != "") {
                        if (date('Y-m-d') < $request->user()->suscriptorDeposito->suscription_end) {
                            //si es vigente, pasa al siguiente proceso
                            return $next($request);
                        } else {
                            //Valida si existe el parametro slug 
                            if ($request->route('slug')) {
                                //Busca el post mediante el slug
                                $post = Post::where('slug', '=', $request->route('slug'))->first();
                                //Valida si el post existe
                                if ($post) {
                                    //Valida si el post es premium
                                    if ($post->acceso == 1) {
                                        // si la suscripcion fue expirada retorna, lo siguiente
                                        //Envian el mensaje a la session
                                        Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                                        //Retorna a la ruta suscription
                                        return redirect()->route('getmicuenta');
                                    }
                                    //retorna si post es gratis
                                    return $next($request);
                                } else {
                                    //si no existe el post, retorna al home
                                    return redirect('/');
                                }

                                // si el parametro en la url es diferente de slug, retorna al siguiente proceso
                                return $next($request);
                            }

                            // si la suscripcion fue expirada retorna, lo siguiente

                            Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                            return redirect()->route('getmicuenta');
                        }
                    }

                    if (!$request->user()->suscriptorDepositoUni  != "") {
                        if (date('Y-m-d') < $request->user()->suscriptorDepositoUni->suscription_end) {
                            //si es vigente, pasa al siguiente proceso
                            return $next($request);
                        } else {
                            //Valida si existe el parametro slug 
                            if ($request->route('slug')) {
                                //Busca el post mediante el slug
                                $post = Post::where('slug', '=', $request->route('slug'))->first();
                                //Valida si el post existe
                                if ($post) {
                                    //Valida si el post es premium
                                    if ($post->acceso == 1) {
                                        // si la suscripcion fue expirada retorna, lo siguiente
                                        //Envian el mensaje a la session
                                        Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                                        //Retorna a la ruta suscription
                                        return redirect()->route('getmicuenta');
                                    }
                                    //retorna si post es gratis
                                    return $next($request);
                                } else {
                                    //si no existe el post, retorna al home
                                    return redirect('/');
                                }

                                // si el parametro en la url es diferente de slug, retorna al siguiente proceso
                                return $next($request);
                            }

                            // si la suscripcion fue expirada retorna, lo siguiente

                            Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                            return redirect()->route('getmicuenta');
                        }
                    }
            }
            else{
              return $next($request);
            }               

           }
           // 5 = rol cliente
           if ($request->user()->role->id == 5) {
               if ($request->user()->cliente->status == 1 AND $request->user()->cliente->Caducidad() > 0) {
                   return $next($request);
               }else{

                if ($request->route('slug')) {
                    $post = Post::where('slug','=',$request->route('slug'))->first();
                    //Valida si el post existe
                    if ($post) {
                        //Valida si el post es premium
                        if ($post->acceso == 1) {
                            Session::flash('alerta','¡Su suscripción esta inactiva, sugerimos solicitar una activación!');
                            return redirect()->route('getmicuenta');
                        }
                        //retorna si el post es gratis
                        return $next($request);

                    }else{
                        return redirect('/');
                    }
                    
                    // retorna, si el parametro es diferente de slug
                     return $next($request);
                }
                   Session::flash('alerta','¡Su suscripción esta inactiva, sugerimos solicitar una activación!');
                   return redirect()->route('getmicuenta');
               }
           }

           // retorna si el rol del usuario es diferente de (suscrip deposito y cliente).
           return $next($request);
        }
        // retona para los visitante a la web, sin autenticacion
        return $next($request);
    }
}
