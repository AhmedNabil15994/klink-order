<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/login');
        }
        define('USER_ID',Auth::guard($guard)->user()->id);
        define('IS_COMPANY', Auth::guard($guard)->user()->profile->group_id == 4 ? true : false);
        define('IS_DRIVER', Auth::guard($guard)->user()->profile->group_id == 5 ? true : false);
        define('IS_NORMAL_USER', Auth::guard($guard)->user()->profile->group_id == 3 ? true : false);

        define('PERMISSIONS', \App\Models\User::checkUserPermissions(Auth::guard($guard)->user()));
        return $next($request);
    }
}
