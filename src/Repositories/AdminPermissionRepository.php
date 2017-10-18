<?php

namespace Kaiwh\Admin\Repositories;

use Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Kaiwh\Admin\Models\Admin;
use Route;

class AdminPermissionRepository
{
    /**
     * @var Array 无需授权的列表
     */
    public $ignores;
    /**
     * @var Array 需授权的列表
     */
    public $authorizes;
    /**
     * @var Array 需授权的列表
     */
    public $currentController;

    public function __construct()
    {
        $this->ignores = Config::get('admin.permission.ignores');
        $this->setAuthorizes();
        $this->setCurrentController();
    }
    /**
     * 是否具备权限的
     *
     * @return Bool
     */
    public function permission($permission)
    {
        if (in_array($this->currentController, $permission)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 不需授权
     *
     * @return Bool
     */
    public function ignores()
    {
        if (in_array($this->currentController, $this->ignores)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 需授权的列表
     *
     * @return Arrry
     */
    protected function setAuthorizes()
    {
        $filesystem = new Filesystem;

        $files = $filesystem->glob(app_path('Admin/Controllers/*.php'));

        $authorizes = [];

        foreach ($files as $key => $value) {
            $str = Str::snake(Str::replaceLast('Controller.php', '', basename($value)));

            if (!in_array($str, Config::get('admin.permission.ignores'))) {
                $authorizes[] = [
                    'title' => trans('admin::' . $str . '.heading.catalog'),
                    'value' => $str,
                ];
            }

        }
        $this->authorizes = $authorizes;
    }

    /**
     * 当前访问的Controller
     *
     * @return String
     */
    protected function setCurrentController()
    {
        $action = substr(basename(Route::currentRouteAction()), 0, strpos(basename(Route::currentRouteAction()), '@'));

        $this->currentController = Str::snake(Str::replaceLast('Controller', '', $action));
    }
}
