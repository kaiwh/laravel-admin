<?php

namespace Kaiwh\Admin\Language;

use Storage;

class Language
{
    public $code;
    public $title;
    public $image;

    public function __construct($code, $title)
    {
        $this->code  = $code;
        $this->title = $title;
        $this->image = Storage::disk('public')->url('language/' . $code . '.png');
    }

    
}
