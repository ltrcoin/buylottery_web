<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'guest.dev'],
	function() {
		Route::get('/', [
			'as' => 'dev.site.vLogin',
			'uses'  => 'SiteController@login'
			]);
		Route::get('/login', [
			'as' => 'dev.site.vLogin',
			'uses'  => 'SiteController@login'
			]);

		Route::post('/login', [
			'as' => 'dev.site.pLogin',
			'uses'  => 'SiteController@login'
			]);
	}
);


Route::group(['middleware'=>'auth.dev'],
	function() {
		/*SiteController*/
		Route::get('/home', [
			'as' => 'dev.site.index',
			'uses'  => 'SiteController@index'
			]);
		Route::get('/logout', [
			'as' => 'dev.site.logout',
			'uses'  => 'SiteController@logout'
			]);

		/*RoleController*/
		Route::get('role/indexGroup', [
			'as' => 'dev.role.indexGroup',
			'uses'  => 'RoleController@indexGroup'
			]);
		Route::get('role/addGroup', [
			'as' => 'dev.role.vAddGroup',
			'uses'  => 'RoleController@addGroup'
			]);
		Route::post('role/addGroup', [
			'as' => 'dev.role.pAddGroup',
			'uses'  => 'RoleController@addGroup'
			]);
		Route::get('role/editGroup/{id}', [
			'as' => 'dev.role.vEditGroup',
			'uses'  => 'RoleController@editGroup'
			]);
		Route::post('role/editGroup/{id}', [
			'as' => 'dev.role.pEditGroup',
			'uses'  => 'RoleController@editGroup'
			]);
		Route::get('role/deleteGroup/{id}', [
			'as' => 'dev.role.deleteGroup',
			'uses'  => 'RoleController@deleteGroup'
			]);

		/*PermissionController*/
		Route::get('permission/index', [
			'as' => 'dev.permission.index',
			'uses'  => 'PermissionController@index'
			]);
		Route::get('permission/add', [
			'as' => 'dev.permission.vAdd',
			'uses'  => 'PermissionController@add'
			]);
		Route::post('permission/add', [
			'as' => 'dev.permission.pAdd',
			'uses'  => 'PermissionController@add'
			]);
		Route::get('permission/edit/{id}', [
			'as' => 'dev.permission.vEdit',
			'uses'  => 'PermissionController@edit'
			]);
		Route::post('permission/edit/{id}', [
			'as' => 'dev.permission.pEdit',
			'uses'  => 'PermissionController@edit'
			]);
		Route::get('permission/delete/{id}', [
			'as' => 'dev.permission.delete',
			'uses'  => 'PermissionController@delete'
			]);
		/*SettingController*/
		Route::get('setting/index', [
			'as' => 'dev.setting.index',
			'uses'  => 'SettingController@index'
			]);
		Route::get('setting/add', [
			'as' => 'dev.setting.vAdd',
			'uses'  => 'SettingController@add'
			]);
		Route::post('setting/add', [
			'as' => 'dev.setting.pAdd',
			'uses'  => 'SettingController@add'
			]);
		Route::get('setting/edit/{id}', [
			'as' => 'dev.setting.vEdit',
			'uses'  => 'SettingController@edit'
			]);
		Route::post('setting/edit/{id}', [
			'as' => 'dev.setting.pEdit',
			'uses'  => 'SettingController@edit'
			]);
		Route::get('setting/delete/{id}', [
			'as' => 'dev.setting.delete',
			'uses'  => 'SettingController@delete'
			]);
	}
);

