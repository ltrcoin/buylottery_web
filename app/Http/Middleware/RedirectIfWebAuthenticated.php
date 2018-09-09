<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfWebAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = "web")
    {
        $route = $request->route()->getAction()['as'];
        $allow_route = [
            'frontend.site.vRegister', 
            'frontend.site.pRegister', 
            'frontend.site.validateRegister',
            'frontend.site.vUseanotheraccount'
        ];
        if (Auth::guard($guard)->check()) {
            return redirect()->route('frontend.site.index');
        } elseif (\Session::has('2fa:isLogged') && !in_array($route, $allow_route)) {
            return redirect()->route('frontend.ps.verify2fa');
        }

        return $next($request);
    }
}
