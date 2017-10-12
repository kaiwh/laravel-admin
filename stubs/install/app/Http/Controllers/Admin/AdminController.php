<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Config;
use Kaiwh\Admin\Admin\Repositories\AdminRepository;
use Kaiwh\Admin\Admin\Requests\AdminStoreRequest;
use Kaiwh\Admin\Admin\Requests\AdminUpdateRequest;
use Redirect;

class AdminController extends Controller
{
    /**
     * @var repository
     */
    private $repository;
    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * 管理员列表
     *
     * @return 视图
     */
    public function index()
    {
        $admins = $this->repository->paginate();

        return view('admin::admin.index')
            ->with('admins', $admins);
    }
    /**
     * 新增管理员
     *
     * @return 视图
     */
    public function create()
    {

        $authorizes = $this->authorizes();

        return view('admin::admin.create')
            ->with('authorizes', $authorizes);
    }
    /**
     * 保存新增管理员
     *
     * @param AdminStore
     * @return 重定向列表页
     */
    public function store(AdminStoreRequest $request)
    {
        $this->repository->store($request->all());

        return Redirect::route('admin.admin.index');
    }
    /**
     * 编辑管理员
     *
     * @return 视图
     */
    public function edit($id)
    {
        $admin = $this->repository->first($id);

        if (is_null($admin)) {
            return Redirect::route('admin.admin.index');
        }

        $authorizes = $this->authorizes();

        return view('admin::admin.edit')
            ->with('admin', $admin)
            ->with('authorizes', $authorizes);
    }
    /**
     * 修改管理员
     *
     * @return 重定向列表页
     */
    public function update(AdminUpdateRequest $request, $id)
    {

        $admin = $this->repository->first($id);

        if (!is_null($admin)) {
            $this->repository->update($admin, $request->all());
        }

        return Redirect::route('admin.admin.index');
    }
    /**
     * 删除管理员
     *
     * @return 视图
     */
    public function destroy($id)
    {
        $admin = $this->repository->first($id);

        if (!is_null($admin)) {
            $this->repository->destroy($admin);
        }

        return Redirect::route('admin.admin.index');
    }

    /**
     * 须授权的
     *
     * @return Arrry
     */
    protected function authorizes()
    {

        $authorizes = Config::get('admin.authorizes');

        $results = [];
        foreach ($authorizes as $key => $value) {
            $results[] = [
                'title' => trans($value),
                'value' => $key,
            ];
        }

        return $results;
    }
}
