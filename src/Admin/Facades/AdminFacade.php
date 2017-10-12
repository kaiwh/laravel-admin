<?php

namespace Kaiwh\Admin\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kaiwh_laravel_admin_admin';
    }
}
