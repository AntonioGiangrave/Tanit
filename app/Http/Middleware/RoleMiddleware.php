<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
// app/Http/Middleware/RoleMiddleware.php


    public function handle($request, Closure $next, $role, $permission= null)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        if (! $request->user()->hasRole($role)) {
            abort(403);
        }


        \Debugbar::info('loginazienda');
        if ($request->user()->hasRole('azienda')) {
            \Debugbar::info('loginazienda');
            return redirect('/societa/' . $request->user()->societa_id . '/edit')->with('error', 'Devi aggiornare l\'ateco della società ' . $request->user()->societa->ragione_sociale . 'prima di procedere');
        }



//        if (! $request->user()->hasPermissionTo($permission)) {
//            abort(403);
//        }

        return $next($request);
    }
}
