<?php

namespace Kaiwh\Admin\Admin\Middleware;

use Auth;
use Closure;
use Config;
use Route;

class AdminPermissionMiddleware
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
        $guard = 'admin';

        if ($this->ignores()) {
            return $next($request);
        }

        if ($this->administrator($guard)) {
            return $next($request);
        }

        if ($this->permission($guard)) {
            return $next($request);
        }

        return response()->view('admin::errors.401', [], 401);
    }
    /**
     * 不须授权
     *
     * @return Bool
     */
    protected function ignores()
    {
        $ignores = Config::get('admin.ignores');
        if (in_array(Route::currentRouteName(), $ignores)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 是不是超级管理员
     *
     * @param  $guard
     * @return Bool
     */
    protected function administrator($guard)
    {
        return Auth::guard($guard)->user()->administrator;
    }
    /**
     * 是否具备权限的
     *
     * @param  \Closure  $next
     * @return Bool
     */
    protected function permission($guard)
    {
        // dd(Route::currentRouteName());
        $adminPermissions = unserialize(Auth::guard($guard)->user()->permission);

        $permissions = [];

        foreach ($adminPermissions as $key => $group) {
            if ($key == 'index') {
                foreach ($group as $value) {
                    $permissions[] = $value . '.index';
                }
            } elseif ($key == 'show') {
                foreach ($group as $value) {
                    $permissions[] = $value . '.show';
                }
            } elseif ($key == 'create') {
                foreach ($group as $value) {
                    $permissions[] = $value . '.create';
                }
            } elseif ($key == 'edit') {
                foreach ($group as $value) {
                    $permissions[] = $value . '.edit';
                }
            } elseif ($key == 'destroy') {
                foreach ($group as $value) {
                    $permissions[] = $value . '.destroy';
                }
            }
        }
        if (in_array(Route::currentRouteName(), $permissions)) {
            return true;
        } else {
            return false;
        }

    }
}
