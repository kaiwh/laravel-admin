<?php

namespace Kaiwh\Admin\Image\Facades;

use Illuminate\Support\Facades\Facade;

class ImageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kaiwh_laravel_admin_image';
    }
}
