<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Sentinel::check() && Sentinel::hasAnyAccess(['admin.*','moderator.*']) ) {
            return redirect()->route('admin.dashbord')->with('info','welcome admin');
        }elseif (Sentinel::check() && Sentinel::hasAccess('user.*')){
            return redirect()->route('user.dashbord')->with('info','welcome user');

        }

        return $next($request);
    }
}
