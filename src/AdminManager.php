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
		Route::get('admin', 'AdminController@index')->name('admin.admin.index');
		Route::get('admin/create', 'AdminController@create')->name('admin.admin.create');
		Route::post('admin/create', 'AdminController@store');
		// Route::get('admin/{id}', 'AdminController@show')->name('admin.admin.show')->where('id', '[0-9]+');
		Route::get('admin/{id}/edit', 'AdminController@edit')->name('admin.admin.edit');
		Route::post('admin/{id}/edit', 'AdminController@update');
		Route::get('admin/{id}/destroy', 'AdminController@destroy')->name('admin.admin.destroy');

		/**
		 * 语言
		 */
		Route::get('language/{code}', 'LanguageController@index')->name('admin.language.index');

		/**
		 * 图片管理器
		 */
		Route::get('image', 'ImageController@index')->name('admin.image.index');
		Route::post('image/upload', 'ImageController@upload')->name('admin.image.upload');
		Route::post('image/folder', 'ImageController@folder')->name('admin.image.folder');
		Route::post('image/delete', 'ImageController@delete')->name('admin.image.delete');
    }
}
