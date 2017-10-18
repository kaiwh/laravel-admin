<?php

namespace Kaiwh\Admin\Image;

use Config;
use Intervention\Image\Facades\Image as InterImage;
use Kaiwh\Admin\Image\Style;
use Storage;

class ImageManager
{
    public function __construct()
    {
        $this->storage = Storage::disk($this->disk);
        $this->setConfig();
    }
    /**
     * @var $disk
     */
    protected $disk = 'cache';
    /**
     * @var $disk
     */
    protected $storage;
    /**
     * @var $disk Config
     */
    protected $config;

    protected function setConfig()
    {
        $this->config = Config::get('filesystems.disks.' . $this->disk);
    }
    /**
     * 重制
     * @return url
     */
    public function resize($filename, $width = null, $height = null, $watermark = [])
    {
        $style = new Style($width, $height, $watermark);

        $old_filename = storage_path($filename);

        if (!$filename || !is_file($old_filename)) {

            $filename = Config::get('admin.defaults.placeholder');

            $old_filename = storage_path($filename);

        }

        $new_filename = $this->newFileName($filename, $style);

        if ($this->exists($new_filename)) {
            return $this->storage->url($new_filename);
        }

        $this->makeDirectory($filename);

        $image = InterImage::make($old_filename);

        if ($style->width && $style->height) {
            $image->resize($style->width, $style->height);
        }

        if ($style->watermark) {
            $image->insert($style->watermark['source'], $style->watermark['position'], $style->watermark['x'], $style->watermark['y']);
        }

        $image->save($this->config['root'] . $new_filename);

        return $this->storage->url($new_filename);
    }
    /**
     * Placeholder
     * @return url
     */
    public function placeholder($width = null, $height = null, $watermark = [])
    {
        return $this->resize(Config::get('admin.defaults.placeholder'), $width, $height, $watermark);
    }
    /**
     * 删除缓存
     * @return Void
     */
    public function delete($filename)
    {

        $dirname  = pathinfo($filename, PATHINFO_DIRNAME);
        $basename = pathinfo($filename, PATHINFO_BASENAME);

        $file_name = substr($basename, 0, strrpos($basename, '.'));

        $files = $this->storage->files($dirname);

        foreach ($files as $value) {
            $value_basename = pathinfo($value, PATHINFO_BASENAME);
            $name           = substr($value_basename, 0, strrpos($value_basename, '-'));

            if ($name == $file_name) {
                $this->storage->delete($value);
            }
        }

    }
    /**
     * 删除缓存
     * @return Void
     */
    public function deleteDirectory($directory)
    {
        $this->storage->deleteDirectory($directory);
    }
    /**
     * 新文件名
     */
    protected function newFileName($filename, Style $style)
    {

        if (is_null($style->width) || is_null($style->height)) {
            return $filename;
        } else {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            return substr($filename, 0, strrpos($filename, '.')) . '-' . $style->width . 'x' . $style->height . '.' . $extension;
        }
    }
    /**
     * 建立目录
     */
    protected function makeDirectory($filename)
    {
        if (!$this->storage->exists(dirname($filename))) {
            $this->storage->makeDirectory(dirname($filename));
        }
    }

    /**
     * 是否已经存在此文件
     */
    protected function exists($filename)
    {
        if ($this->storage->exists($filename)) {
            return true;
        } else {
            return false;
        }
    }

}
