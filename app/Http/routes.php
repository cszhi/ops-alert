<?php

get('login', 'Auth\AuthController@getLogin');
post('login', 'Auth\AuthController@postLogin')->name('login');
get('users/logout', 'Auth\AuthController@getLogout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
	Route::group(['namespace' => 'Alert'], function(){
		get('/', 'UserController@index');
		get('user', 'UserController@index')->name('alert.user');
		get('user/{id}', 'UserController@show')->name('alert.user.show');
		post('user', 'UserController@store')->name('alert.user.store');
		post('user/{id}/edit', 'UserController@update')->name('alert.user.update');
		post('user/{id}/delete', 'UserController@destroy')->name('alert.user.destroy');

		get('group', 'GroupController@index')->name('alert.group');
		post('group', 'GroupController@store')->name('alert.group.store');
		post('group/{id}/edit', 'GroupController@update')->name('alert.group.update');
		post('group/{id}/delete', 'GroupController@destroy')->name('alert.group.destroy');

		get('log', 'LogController@index')->name('alert.log');
		get('log/{token}', 'LogController@show')->name('alert.log.show');
	});
	Route::group(['namespace' => 'Admin'], function(){
		get('config', 'ConfigController@config')->name('admin.config');
		post('config', 'ConfigController@configupdate')->name('admin.config.update');
		post('config2', 'ConfigController@config2update')->name('admin.config2.update');
		get('password', 'PasswordController@password')->name('admin.password');
		post('password', 'PasswordController@passwordupdate')->name('admin.password.update');
	});
});
//alert api
Route::match(['get', 'post'], 'alert', 'AlertController@index');
Route::match(['get', 'post'], 'alert/{token}', 'AlertController@alert');
// get('alert', 'AlertController@index');
// get('alert/{token}', 'AlertController@alert');

get('test', 'AlertController@test');





