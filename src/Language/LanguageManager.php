<?php

namespace Kaiwh\Admin\Language;

use Config;

class LanguageManager
{
    protected $languages = [];
    public function __construct()
    {
        $this->languages = [];
        foreach (Config::get('language.languages') as $key => $value) {
            $this->languages[$key] = new Language($key, $value['title']);
        }
    }
    public function active()
    {
        return $this->languages[Config::get('language.default')];
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
