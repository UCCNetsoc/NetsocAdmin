<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'UserController@index']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/register', ['as' => 'register', 'uses' => 'UserController@register']);
Route::post('/user/store', ['as' => 'user/store', 'uses' => 'UserController@store']);

Route::get('/login', ['as' => 'login', 'uses' => 'UserController@login']);
Route::post('/user/login', ['as' => 'user/login', 'uses' => 'UserController@handleLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);

Route::group(['middleware' => 'auth', 'prefix' => 'manage'], function () {
	Route::group(['prefix' => 'mysql'], function () {
	    Route::get('/', ['as' => 'manage/mysql', 'uses' => 'MySQLController@index' ] );
	    Route::post('add', ['as' => 'manage/mysql/add', 'uses' => 'MySQLController@create' ] );
	    Route::post('delete', ['as' => 'manage/mysql/delete', 'uses' => 'MySQLController@delete' ] );
	});

	Route::group(['prefix' => 'account'], function(){
		Route::get('/', ['as' => 'manage/account', 'uses' => 'UserController@changeDetails']);
		Route::post('/update', ['as' => 'manage/account/update', 'uses' => 'UserController@update']);
	});

	Route::group(['prefix' => 'wordpress'], function(){
		Route::match(['get', 'post'], '/', ['as' => 'manage/wordpress', 'uses' => 'Software\Wordpress@install']);
		// Route::post('/update', ['as' => 'manage/account/update', 'uses' => 'UserController@update']);
	});
});

Route::group(['prefix' => 'api'], function( ){
	Route::post('revealPassword', ['uses' => 'APIController@revealPassword']);
});