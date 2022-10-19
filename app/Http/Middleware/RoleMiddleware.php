<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if($request->user()->hasRole('user'))
        {
            Auth::logout();
            return redirect('login');
        }
        if(!$request->user()){
            return redirect('login');
        }

        if($role !== 'user' && !$request->user()->hasRole($role)) {
            return redirect('login');
        }

        if($permission !== null && !$request->user()->hasPermissionThroughRole($permission)) {
            return redirect('/');
        }
        return $next($request);
    }
}
