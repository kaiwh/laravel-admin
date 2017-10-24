<?php

namespace Kaiwh\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Image;
use Storage;

trait ImageControllerTrait
{
    public function __construct()
    {
        $this->storage = Storage::disk('image');
        $this->path    = substr($this->storage->getAdapter()->getPathPrefix(), strlen(storage_path()) + 1);
    }
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
        $directories = $this->storage->directories($request->get('directory'));

        $lastModified = [];
        foreach ($directories as $value) {
            $lastModified[] = $this->storage->lastModified($value);
        }
        array_multisort($lastModified, SORT_DESC, SORT_STRING, $directories);


        $files = $this->storage->files($request->get('directory'));

        $lastModified = [];
        foreach ($files as $value) {
            $lastModified[] = $this->storage->lastModified($value);
        }

        array_multisort($lastModified, SORT_DESC, SORT_STRING, $files);

        $images = array_merge($directories, $files);

        $files = [];

        foreach ($images as $key => $value) {
            if (is_dir(storage_path($this->path . $value))) {
                $files[] = [
                    'type'      => 'directory',
                    'directory' => $value,
                    'name'      => implode(' ', str_split(basename($value), 14)),
                ];
            } elseif (is_file(storage_path($this->path . $value))) {
                $files[] = [
                    'type'     => 'image',
                    'file'     => $value,
                    'filename' => $this->path . $value,
                    'thumb'    => Image::resize($this->path . $value, 100, 100),
                ];
            }

        }

        $total   = count($files); //记录总条数
        $perPage = 16; //每页的记录数 ( 常量 )

        if ($request->has('page')) {
            $current_page = $request->input('page');
            $current_page = $current_page <= 0 ? 1 : $current_page;
        } else {
            $current_page = 1;
        }
        if ($request->get('directory')) {
            $path = route('admin.image.index', ['directory' => $request->get('directory')]);
        } else {
            $path = Paginator::resolveCurrentPath();
        }

        $item = array_slice($files, ($current_page - 1) * $perPage, $perPage); //注释1

        $paginator = new LengthAwarePaginator($item, $total, $perPage, $current_page, [
            'path'     => $path, //注释2
            'pageName' => 'page',
        ]);

        return view('admin::image.index')
        // ->with('directories', $directories)
        ->with('files', $paginator);
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
            $this->storage->putFile($request->get('directory'), $file);
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
            $dir = '';
            if ($request->get('directory')) {
                $dir = $request->get('directory') . '/';
            }
            $dir .= $request->get('folder');
            $result = $this->storage->makeDirectory($dir);

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
