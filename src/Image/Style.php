<?php

namespace Kaiwh\Admin\Image;

class Style
{
    public function __construct($width = 0, $height = 0, $watermark = [])
    {
        $this->width     = $width;
        $this->height    = $height;
        $this->watermark = $watermark;
    }
    /**
     * @val 宽度
     */
    protected $width;
    /**
     * @val 高度
     */
    protected $height;

    /**
     *  @val 水印
     *  [
     *      'source'   => 'watermark.png',
     *      'position' => 'bottom-right',
     *      'x'        => 10,
     *      'y'        => 10,
     *  ]
     */
    protected $watermark = [
    ];

    public function __get($key)
    {
        return $this->$key;
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
    }
}
