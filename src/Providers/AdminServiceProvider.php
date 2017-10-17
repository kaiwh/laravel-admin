<?php

namespace Kaiwh\Admin\Providers;

class AdminServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $commands = [
        'Kaiwh\Admin\Commands\AdminInstallCommand',
    ];
    public function boot()
    {
        $this->loadViewsFrom(resource_path('views/vendor/admin'), 'admin');
        $this->loadTranslationsFrom(resource_path('lang/vendor/admin'), 'admin');

        $this->loadViewsFrom(resource_path('views/vendor/desktop'), 'desktop');
        $this->loadTranslationsFrom(resource_path('lang/vendor/desktop'), 'desktop');
    }
    public function register()
    {
        $this->commands($this->commands);

        $this->app->singleton('kaiwh_laravel_admin_language', function () {
            return new \Kaiwh\Admin\Language\LanguageManager();
        });
        $this->app->singleton('kaiwh_laravel_admin_image', function () {
            return new \Kaiwh\Admin\Image\ImageManager();
        });
        $this->app->singleton('kaiwh_laravel_admin_admin', function () {
            return new \Kaiwh\Admin\AdminManager();
        });
    }
}
