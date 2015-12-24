<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Hash;
use App\User;
use adLDAP\classes\adLDAPUsers;
use adLDAP\adLDAP;

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
        if( Auth::check() ){
            return View::make('admin.index');
        } else {
            return Redirect::route('login');
        }
		// return View::make( 'welcome' );
	}
	
	/**
	 * Render registration view
	 * @return VIEW register
	 */
    public function register( ){
        return View::make( 'auth.register' );
    }

    /**
     * Creates a new user
     * 	Data should be POSTed to this function only
     * @return REDIRECT home
     */
    public function store( ){
    	// Only allow following fields to be submitted
        $data = Request::only( [
                    'uid',
                    'password',
                    'password_confirmation',
                    'student_id'
                ]);

        // Validate all input
        $validator = Validator::make( $data, [
                    'uid'  => 'required|unique:users|min:5|alpha_num',
                    'student_id'     => 'numeric|required|unique:users',
                    'password'  => 'required|confirmed|min:5'
                ]);

        // All usernames need to be lowercase
        $data['uid'] = strtolower($data['uid']);

        $entry['dn'] = 'cn='.$data['uid'].',cn='.env('REGISTRATION_GROUP').','.env('BASE_DN');
        
        $entry['gidNumber'] = '422';
        $entry['objectClass'][] = 'account';
        $entry['objectClass'][] = 'top';
        $entry['objectClass'][] = 'posixAccount';
        $entry['uidNumber'] = '3025';
        $entry['uid'] = $data['uid'];

        // Generate an alphanumeric salt for the password
        $salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',4)),0,4);
        $entry['userPassword'] = $data['password'] = '{crypt}'.crypt($data['password'], $salt );


        $entry['homeDirectory'] = '/home/users/'.$data['uid'];
        $entry['loginShell'] = '/bin/bash';
        $entry['cn'] = $data['uid'];
        

        if( $validator->fails( ) ){
        	// If validation fails, redirect back to 
        	// registration form with errors
            return Redirect::back( )
                    ->withErrors( $validator )
                    ->withInput( );
        }

        // Create new user in LDAP
        $adLDAP = new adLDAP( );
        $ldapUsers = new adLDAPUsers( $adLDAP );
        $ldapUsers->create( $entry );

        // Create new user locally
        $newUser = User::create($data);

        // Get missing defaults from LDAP
        Auth::attempt(['uid' => $data['uid'], 'password' => $data['password']]);

        // login user
        Auth::login($newUser);

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

        return View::make( 'auth.login' );
    }

    /**
     * Log a user into the system
     * @return REDIRECT home
     */
    public function handleLogin( ){
    	// Filter allowed data
        $data = Request::only([ 'uid', 'password' ]);

        // Validate user input
        $validator = Validator::make(
            $data,
            [
                'uid' => 'required',
                'password' => 'required',
            ]
        );

        if($validator->fails()){
        	// If validation fails, send back with errors
            return Redirect::route('login')->withErrors( $validator )->withInput( );
        }

        if( Auth::attempt( [ 'uid' => $data['uid'], 'password' => $data['password']], true ) ){
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
