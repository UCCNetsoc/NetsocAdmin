<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Hash;
use App\User;

class UserController extends Controller
{
	
/*
|--------------------------------------------------------------------------
| User Controller
|--------------------------------------------------------------------------
|
| 
|
*/
	/**
	 * Render front page view
	 * @return VIEW welcome
	 */
	public function index( ){
        if (Auth::attempt(['uid' => "username", 'password' => "password"])) {
            // Authentication passed...
            echo "logged in";
            die();
        } else {
            echo "Nada";
        }
		// return View::make( 'welcome' );
	}
	
	/**
	 * Render registration view
	 * @return VIEW register
	 */
    public function register( ){
        return View::make( 'users.register' );
    }

    /**
     * Creates a new user
     * 	Data should be POSTed to this function only
     * @return REDIRECT home
     */
    public function store( ){
    	// Only allow following fields to be submitted
        $data = Request::only( [
                    'username',
                    'password',
                    'password_confirmation',
                    'email'
                ]);

        // Validate all input
        $validator = Validator::make( $data, [
                    'username'  => 'required|unique:users|min:5|alpha_num',
                    'email'     => 'email|required|unique:users',
                    'password'  => 'required|confirmed|min:5'
                ]);

        if( $validator->fails( ) ){
        	// If validation fails, redirect back to 
        	// registration form with errors
            return Redirect::back( )
                    ->withErrors( $validator )
                    ->withInput( );
        }

        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Create the new user
        $newUser = User::create( $data );

        if( $newUser ){
        	// If successful, go to home
        	return Redirect::route( 'home' );
        }
        
        // If unsuccessful, return with errors
        return Redirect::back( )
                    ->withErrors( [
                    	'message' => 'We\'re sorry but registration failed, please email '. env('DEV_EMAIL') 
                    ] )
                    ->withInput( );

    }

    /**
     * Render login view
     * @return VIEW login
     */
    public function login( ){

        if( Auth::check( ) ){
        	// If user is logged in, send 'em home
            return Redirect::route( 'home' );
        }

        return View::make( 'users.login' );
    }

    /**
     * Log a user into the system
     * @return REDIRECT home
     */
    public function handleLogin( ){
    	// Filter allowed data
        $data = Request::only([ 'email', 'password' ]);

        // Validate user input
        $validator = Validator::make(
            $data,
            [
                'email' => 'required|email|min:8',
                'password' => 'required',
            ]
        );

        if($validator->fails()){
        	// If validation fails, send back with errors
            return Redirect::route('login')->withErrors( $validator )->withInput( );
        }

        if( Auth::attempt( [ 'email' => $data['email'], 'password' => $data['password']], true ) ){
        	// If login is successful, send them to home
            return Redirect::route( 'home' );
        } else {
        	// Otherwise, tell them they're wrong
            return Redirect::route( 'login' )
            			   ->withErrors([ 
            			   		'message' => 'I\'m sorry, that username and password aren\'t correct.' 
            			   	]);
        }

        return Redirect::route( 'login' )->withInput( );
    }
}
