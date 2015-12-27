<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Input;
use Crypt;
use App\User;
use App\MySQLUser;
use App\MySQLDatabase;
use App\Setting;

class StaticController extends Controller{

	public function howToSSH( ){
		return View::make('static.ssh');
	}
}