<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permiso)
    {

        foreach ($request->user()->role->permisos as $perm) {
            if ($perm->slug == $permiso) {
                
                return $next($request);
            }
        }
        
        Session::flash('msg-denny','¡Acceso denegado!');
        return redirect('/panel');
        /*abort(401);*/
            
    }
}
