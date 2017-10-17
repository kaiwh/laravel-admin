<?php

namespace Kaiwh\Admin\Repositories;

use Config;
use DB;
use Kaiwh\Admin\Models\Admin;

class AdminRepository
{
    private $admin;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    public function find($id)
    {
        return $this->admin->find($id);
    }
    /**
     * 列表 分页
     *
     * @return \Kaiwh\Admin\Admin\Models\Admin
     */
    public function paginate()
    {
        return $this->admin->paginate(20);
    }
    /**
     * 保存
     *
     * @return \Kaiwh\Admin\Admin\Models\Admin id
     */
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $admin = new Admin;

            $admin->name          = $data['name'];
            $admin->email         = $data['email'];
            $admin->password      = bcrypt($data['password']);
            $admin->administrator = !empty($data['administrator']) ? 1 : 0;

            $permission = [
                'index'   => [],
                'show'    => [],
                'create'  => [],
                'edit'    => [],
                'destroy' => [],
            ];

            if (!empty($data['permission'])) {
                $permission = array_merge($permission, $data['permission']);
            }

            $admin->permission = serialize($permission);

            $admin->save();

            return $admin->id;
        });
    }
    /**
     * 修改
     *
     * @return Void
     */
    public function update(Admin $admin, array $data)
    {
        DB::transaction(function () use ($admin, $data) {

            $admin->name = $data['name'];
            if (!is_null($data['password'])) {
                $admin->password = bcrypt($data['password']);
            }

            $permission = [
                'index'   => [],
                'show'    => [],
                'create'  => [],
                'edit'    => [],
                'destroy' => [],
            ];

            if (!empty($data['permission'])) {
                $permission = array_merge($permission, $data['permission']);
            }

            $admin->permission = serialize($permission);

            $admin->save();
        });
    }
    /**
     * 删除
     *
     * @return Void
     */
    public function destroy(Admin $admin)
    {
        DB::transaction(function () use ($admin) {
            $admin->delete();
        });
    }
    /**
     * 清空表数据
     *
     */
    public function truncate()
    {
        $this->admin->truncate();
    }

    /**
     * 须授权的列表
     *
     * @return Arrry
     */
    public function getAuthorizes()
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
