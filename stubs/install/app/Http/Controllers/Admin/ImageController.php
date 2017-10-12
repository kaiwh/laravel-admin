<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->storage = Storage::disk($this->disk);
        $this->path    = substr($this->storage->getAdapter()->getPathPrefix(), strlen(storage_path()) + 1);
    }
    /**
     * @var $disk
     */
    protected $disk = 'image';
    /**
     * @var use Storage;
     */
    protected $storage;
    /**
     * @var ;
     */
    protected $path;

    /**
     * 列表
     *
     * @return View
     */
    public function index(Request $request)
    {
        $directories = $this->storage->directories();

        $results = $this->storage->files($request->get('directory'));

        $files = [];

        foreach ($results as $key => $value) {
            $files[] = [
                'file'     => $value,
                'filename' => $this->path . $value,
                'thumb'    => Image::resize($this->path . $value, 100,100),
            ];
        }

        return view('admin::image.index')
            ->with('directories', $directories)
            ->with('files', $files);
    }
    /**
     * 上传文件
     *
     * @return Json
     */
    public function upload(Request $request)
    {
        $json = [];
        foreach ($request->file('file') as $file) {
            Storage::disk($this->disk)->putFile($request->get('directory'), $file);
        }

        $json['success'] = trans('admin::image.success.upload');

        return response()
            ->json($json);
    }
    /**
     * 创建目录
     *
     * @return Json
     */
    public function folder(Request $request)
    {
        $json = [];

        $validator = $this->validatorFolder($request->all())->fails();

        if ($validator) {
            $json['error'] = trans('admin::image.error.folder_alpha_num');
        }

        if (!$json) {

            $result = Storage::disk($this->disk)->makeDirectory($request->get('folder'));

            if ($result) {
                $json['success'] = trans('admin::image.success.folder');
            } else {
                $json['error'] = trans('admin::image.error.folder');
            }
        }

        return response()
            ->json($json);
    }
    /**
     * 删除目录或文件
     *
     * @return Json
     */
    public function delete(Request $request)
    {
        $json = [];

        if ($request->get('directory')) {
            $this->storage->deleteDirectory($request->get('directory'));
            Image::deleteDirectory($this->path . $request->get('directory'));
            $json['success'] = trans('admin::image.success.delete');
        } elseif ($request->get('file')) {
            $this->storage->delete($request->get('file'));
            Image::delete($this->path . $request->get('file'));
            $json['success'] = trans('admin::image.success.delete');
        } else {
            $json['error'] = trans('admin::image.error.delete');
        }

        return response()
            ->json($json);
    }
    /**
     * 验证文件夹名称
     *
     * @return Bool
     */
    protected function validatorFolder(array $data)
    {
        return Validator::make($data, [
            'folder' => 'required|k_alpha_dash',
        ]);
    }

}
