<?php

namespace Kaiwh\Admin\Controllers;

use Kaiwh\Admin\Controllers\Controller;
use Language;
use Redirect;
use Request;

class LanguageController extends Controller
{
    /**
     * 编辑
     *
     * @return 视图
     */
    public function index($code)
    {
        $language = Language::find($code);

        if (!is_null($language)) {
            Request::session()->put('language', $code);
        }

        return Redirect::back();
    }
}
