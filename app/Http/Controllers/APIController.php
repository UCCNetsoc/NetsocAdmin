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

class APIController extends Controller
{
	/**
	 * Reveal MySQL password to the user
	 */
	public function revealPassword( ){

		$data = Input::only([
					'username',
					'password'
				]);

		$username = Crypt::decrypt( $data['username'] );
		if( Auth::attempt( [ 'uid' => $username, 'password' => $data['password']], true ) ){
			$user = User::where('uid', $username)->first();
			return Response::json( ["password" => $user->mysqluser->password , "status" => "success"] );
		} else {
			return Response::json( ["password" => "Wrong Password", "status" => "fail"] );
		}
	}
}
