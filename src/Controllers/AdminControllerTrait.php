<?php

namespace Kaiwh\Admin\Controllers;

use Kaiwh\Admin\Repositories\AdminPermissionRepository;
use Kaiwh\Admin\Repositories\AdminRepository;
use Kaiwh\Admin\Requests\AdminStoreRequest;
use Kaiwh\Admin\Requests\AdminUpdateRequest;
use Redirect;

trait AdminControllerTrait
{
    /**
     * @var \Kaiwh\Admin\Repositories\AdminRepository $adminReposotory
     */
    private $adminRepository;
    private $adminPermissionRepository;
    public function __construct(
        AdminRepository $adminRepository,
        AdminPermissionRepository $adminPermissionRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->adminPermissionRepository = $adminPermissionRepository;
    }
    /**
     * 管理员列表
     *
     * @return 视图
     */
    public function index()
    {
        $admins = $this->adminRepository->paginate();

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

        $authorizes = $this->adminPermissionRepository->authorizes;

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
        $this->adminRepository->store($request->all());

        return Redirect::route('admin.admin.index');
    }
    /**
     * 编辑管理员
     *
     * @return 视图
     */
    public function edit($id)
    {
        $admin = $this->adminRepository->find($id);

        if (is_null($admin)) {
            return Redirect::route('admin.admin.index');
        }

        $authorizes = $this->adminPermissionRepository->authorizes;

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

        $admin = $this->adminRepository->find($id);

        if (!is_null($admin)) {
            $this->adminRepository->update($admin, $request->all());
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
        $admin = $this->adminRepository->find($id);

        if (!is_null($admin)) {
            $this->adminRepository->destroy($admin);
        }

        return Redirect::route('admin.admin.index');
    }
}
