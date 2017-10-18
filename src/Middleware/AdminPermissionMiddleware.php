<?php

namespace Kaiwh\Admin\Middleware;

use Auth;
use Closure;
use Kaiwh\Admin\Repositories\AdminPermissionRepository;

class AdminPermissionMiddleware
{
    private $adminPermissionRepository;
    public function __construct(
        AdminPermissionRepository $adminPermissionRepository
    ) {
        $this->adminPermissionRepository = $adminPermissionRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = 'admin';

        if (Auth::guard($guard)->user()->administrator) {
            return $next($request);
        }

        if ($this->adminPermissionRepository->ignores()) {
            return $next($request);
        }

        if ($this->adminPermissionRepository->permission(Auth::guard($guard)->user()->permission())) {
            return $next($request);
        }

        return response()->view('admin::errors.401', [], 401);
    }
}
