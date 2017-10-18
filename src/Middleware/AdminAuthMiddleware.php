<?php

namespace Kaiwh\Admin\Middleware;

use Auth;
use Closure;
use Route;

class AdminAuthMiddleware
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
        if (Auth::guard('admin')->guest()) {
            if (Route::currentRouteName() == 'admin.login') {
                return $next($request);
            } elseif ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        } elseif (Route::currentRouteName() == 'admin.login') {
            return redirect()->guest('admin');
        }
        return $next($request);
    }
}
