<?php
namespace Kaiwh\Admin\Seeds;

use Kaiwh\Admin\Repositories\AdminRepository;
use Illuminate\Database\Seeder;

class InitAdminSeeder extends Seeder
{
    protected $repository;
    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }

    protected $data;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->repository->truncate();

        $this->repository->store([
            'name'          => 'root',
            'email'         => 'root@admin.com',
            'password'      => '1q2w3e4r',
            'administrator' => 1,
        ]);
    }
}
