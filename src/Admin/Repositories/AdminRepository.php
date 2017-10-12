<?php

namespace Kaiwh\Admin\Admin\Repositories;

use DB;
use Kaiwh\Admin\Admin\Models\Admin;
use Kaiwh\Admin\Traits\Repository;

class AdminRepository
{
    use Repository;
    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }
    /**
     * Filter eloquent
     *
     * @return Void
     */
    protected function filter($query, $filter)
    {
        // if(isset($filter['parent_id']) && !is_null($filter['parent_id'])){
        //     $query->where('parent_id',(int)$filter['parent_id']);
        // }
    }
    /**
     * Store
     *
     * @return \{[NAMESPACE]}\Models\{[CLASSNAME]}Admin id
     */
    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
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

        });
        // return $Admin->id;
    }
    /**
     * Update
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
     * Destroy
     *
     * @return Void
     */
    public function destroy(Admin $admin)
    {
        DB::transaction(function () use ($admin) {
            $admin->delete();
        });
    }

    public function truncate()
    {
        Admin::truncate();
    }
}
