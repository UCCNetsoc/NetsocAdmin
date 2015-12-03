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

Route::get('/', 'UserController@index');
Route::get('home', ['as' => 'register', 'uses' => 'UserController@index']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/register', ['as' => 'register', 'uses' => 'UserController@register']);
Route::post('/user/store', ['as' => 'user/store', 'uses' => 'UserController@store']);

Route::get('/login', ['as' => 'login', 'uses' => 'UserController@login']);
Route::post('/user/login', ['as' => 'handleLogin', 'uses' => 'UserController@handleLogin']);