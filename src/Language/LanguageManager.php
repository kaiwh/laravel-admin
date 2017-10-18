<?php

namespace Kaiwh\Admin\Language;

use Config;
use Request;

class LanguageManager
{
    protected $languages = [];
    public function __construct()
    {
        $this->languages = [];
        foreach (Config::get('admin.languages') as $key => $value) {
            $this->languages[$key] = new Language($key, $value['title']);
        }
    }
    public function active()
    {
        if (Request::session()->get('language')) {
            return $this->languages[Request::session()->get('language')];
        } else {
            return $this->languages[Config::get('admin.defaults.language')];
        }
    }
    public function all()
    {
        return $this->languages;
    }
    public function find($code)
    {
        return $this->languages[$code];
    }

}
