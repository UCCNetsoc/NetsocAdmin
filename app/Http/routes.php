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

Route::get('/register', ['as' => 'register', 'uses' => 'UserController@preRegistration']);
Route::get('/register/{token}/{email}', ['as' => 'after-validation', 'uses' => 'UserController@register']);
Route::post('/user/sendconfirmation', ['as' => 'user/sendconfirmation', 'uses' => 'UserController@sendConfirmation']);
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
	});

	Route::group(['prefix' => 'backups'], function(){
		Route::get('/', ['as' => 'manage/backups', 'uses' => 'BackupsController@index']);
		Route::get('/downloads/{timeframe}/{filename}', ['as' => 'manage/backups/download', function( $timeframe, $filename ){
			return response()->download( storage_path() .'/backups/'. Auth::user()->uid .'/'.$timeframe.'/'.$filename );
		}]);
	});
});

Route::group(['middleware' => 'auth', 'prefix' => 'static'], function () {
    Route::get('/ssh', ['as' => 'static/ssh', 'uses' => 'StaticController@howToSSH' ] );
    Route::get('/irc', ['as' => 'static/irc', 'uses' => 'StaticController@howToIRC' ] );
});



Route::group(['prefix' => 'download'], function(){
	Route::get('materialize', ['as' => 'download/materialize', function( ){
		return Redirect::to("http://materializecss.com/bin/materialize-v0.97.5.zip");
	}]);
});

Route::group(['prefix' => 'api'], function( ){
	Route::post('revealPassword', ['uses' => 'APIController@revealPassword']);
});