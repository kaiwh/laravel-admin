<?php

namespace Kaiwh\Admin;

use Illuminate\Support\Facades\Route;

class AdminManager
{
    public function routes()
    {
        /**
         * 首页
         */
        Route::get('/', 'HomeController@index')->name('admin');

        /**
         * 登录界面
         */
        Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'LoginController@login')->name('admin.login');

        /**
         * 注销
         */
        Route::get('logout', 'LoginController@logout')->name('admin.logout');

        /**
         * 管理员
         */
        Route::get('admin', '\Kaiwh\Admin\Controllers\AdminController@index')->name('admin.admin.index');
        Route::get('admin/create', '\Kaiwh\Admin\Controllers\AdminController@create')->name('admin.admin.create');
        Route::post('admin/create', '\Kaiwh\Admin\Controllers\AdminController@store');
        // Route::get('admin/{id}', 'AdminController@show')->name('admin.admin.show')->where('id', '[0-9]+');
        Route::get('admin/{id}/edit', '\Kaiwh\Admin\Controllers\AdminController@edit')->name('admin.admin.edit');
        Route::post('admin/{id}/edit', '\Kaiwh\Admin\Controllers\AdminController@update');
        Route::get('admin/{id}/destroy', '\Kaiwh\Admin\Controllers\AdminController@destroy')->name('admin.admin.destroy');

        /**
         * 语言
         */
        Route::get('language/{code}', '\Kaiwh\Admin\Controllers\LanguageController@index')->name('admin.language.index');

        /**
         * 图片管理器
         */
        Route::get('image', '\Kaiwh\Admin\Controllers\ImageController@index')->name('admin.image.index');
        Route::post('image/upload', '\Kaiwh\Admin\Controllers\ImageController@upload')->name('admin.image.upload');
        Route::post('image/folder', '\Kaiwh\Admin\Controllers\ImageController@folder')->name('admin.image.folder');
        Route::post('image/delete', '\Kaiwh\Admin\Controllers\ImageController@delete')->name('admin.image.delete');
    }
}
