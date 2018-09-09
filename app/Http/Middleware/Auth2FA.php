<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Auth2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('web')->check()) {
            return redirect()->route('frontend.site.index');
        } elseif (!\Session::has('2fa:isLogged')) {
            return redirect()->route('frontend.site.vLogin');
        }

        return $next($request);
    }
}
