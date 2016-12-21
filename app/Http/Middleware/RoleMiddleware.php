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

//        if (! $request->user()->hasPermissionTo($permission)) {
//            abort(403);
//        }

        return $next($request);
    }
}
