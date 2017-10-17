<?php

namespace Kaiwh\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AdminInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin install!';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesystem = new Filesystem;
        $filesystem->copyDirectory(
            __DIR__ . '/stubs/install',
            base_path()
        );
        $this->call('storage:link');

        $this->call('migrate', ['--path' => str_replace(base_path(), '', __DIR__) . '/../../migrations']);
        $this->call('db:seed', ['--class' => \Kaiwh\Admin\Seeds\InitAdminSeeder::class]);
    }

}
