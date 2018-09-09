<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Session;

class SetLocale
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
        $language = !is_null(Session::get('locale')) ? Session::get('locale') : 'en';
        config(['app.locale' => $language]);
        App::setLocale($language);
        return $next($request);
    }
}
