<?php

namespace Kaiwh\Admin\Language\Facades;

use Illuminate\Support\Facades\Facade;

class LanguageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kaiwh_laravel_admin_language';
    }
}
