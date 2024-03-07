<?php

namespace App\Http\Middleware;

use Closure;

class CheckPay
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
        // if($user->isPremium() && $user->tarjeta_id==''){
        //     return false;
        // }else{
        //     return false;
        // }
        //Valida si existe un usuario autenticado
        if (!\Auth::guest()) {
            // 2 = rol suscriptor premium
            if ($request->user()->role->id == 2 ) {
             //Valida la caducidad del suscriptor
             if ($request->user()->tarjeta_id=='') {
               if (date('Y-m-d') < $request->user()->suscriptorDeposito->suscription_end) {
                        //si es vigente, pasa al siguiente proceso
                        return redirect()->route('getmicuenta');
                    } else {
                        // si la suscripcion fue expirada retorna, lo siguiente 
                        return $next($request);
                        // Session::flash('alerta', '¡Su suscripción ha expirado, sugerimos solicitar una renovación!');
                        // return redirect()->route('getmicuenta');
                    }
             } else{
               return $next($request);
             } 
            }else{
                return $next($request);
            }
        }
        return $next($request);
    }
}
