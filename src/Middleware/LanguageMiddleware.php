<?php

namespace Kaiwh\Admin\Middleware;

use App;
use Closure;
use Config;
use Request;

class LanguageMiddleware
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

        if (Request::session()->get('language')) {
            App::setLocale(Request::session()->get('language'));
        } else {
            App::setLocale(Config::get('admin.defaults.language'));
        }

        return $next($request);
    }
}
