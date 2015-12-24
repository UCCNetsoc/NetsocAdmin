<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use DB;
use App\MySQLDatabase;
use App\MySQLUser;
use Crypt;

class MySQLController extends Controller
{
	
	/**
	 * The homepage for MySQL Management
	 */
	public function index( ){

		if( Auth::user()->mysqluser == null ){
			return $this->createUser();
		}

		$databases = Auth::user()->databases;

		$i = 0;
		foreach ( $databases as $database ) {
			// For every database, get its size based on the tables'
			// sizes within it. Size is output as MB
			$size = DB::select("SELECT table_schema AS 'db_name',"
									." ROUND(Sum(data_length + index_length) / 1024 / 1024, 2) AS 'size'"
									." FROM   information_schema.tables  "
									." WHERE table_schema = 'evan_test'"
									." GROUP  BY table_schema; ");
			if( !empty($size) ){
				$databases[$i]->size = $size[0]->size;
			} else {
				// If there are no tables, the database is empty 
				// and is 0MB in size
				$databases[$i]->size = 0;
			}

			$i++;
		}

		return View::make('admin.mysql.index')->with('databases', $databases );
	}

	/**
	 * Removes a database
	 */
	public function delete( ){
		$data = Request::only( ['delete_db_name_encrypted', 'delete_db_name'] );

		if( Crypt::decrypt($data['delete_db_name_encrypted']) == $data['delete_db_name']){
			$db_name = str_replace('`', '', $data['delete_db_name']);

			// Remove the DB
			DB::statement("DROP DATABASE `{$db_name}`");
			MySQLDatabase::where('db_name', $db_name)->first()->delete();
		}

		return Redirect::back();
	}

	/**
	 * Handle database creation from form
	 */
	public function create( ){
		// Filter allowed data
        $data = Request::only([ 'db_name' ]);

        // Validate user input
        $validator = Validator::make(
            $data,
            [
                'db_name' => 'required|unique:mysql_databases|alpha_num',
            ]
        );

        if($validator->fails()){
        	// If validation fails, send back with errors
            return Redirect::back()->withErrors( $validator )->withInput( );
        }

        $this->createDatabase( $data['db_name'] );

        return Redirect::route('manage/mysql');
	}

	/**
	 * Create a new MySQL Database
	 * @param  string $db_name Name of the database
	 */
	public function createDatabase( $db_name ){
		// Prepend the database name with {username}_
		$db_name = Auth::user()->uid . "_" . $db_name;

		// Unfortunately, can't use placeholders for system statements
        $db_name = str_replace('`', '', $db_name);
        DB::statement("CREATE DATABASE `{$db_name}`;");
        MySQLDatabase::create(['user_id' => Auth::user()->id, 'db_name' => $db_name]);
	}

	/**
	 * Create primary MySQL user (i.e. the MySQL user linked 
	 * to our local LDAP user)
	 */
	public function createUser( ){
		$username = Auth::user()->uid;
		$password = $this->randomPassword();

		// Create user and grant permissions on all DBs
		// beginning with {username}_
        DB::statement("CREATE USER '{$username}'@'%' IDENTIFIED BY '{$password}';");
        DB::statement("GRANT ALL PRIVILEGES ON `{$username}\_%`.* TO '{$username}'@'%';");

        MySQLUser::create(['user_id' => Auth::user()->id, 'username' => Auth::user()->uid, 'password' => $password]);

        return Redirect::back();
	}

	/**
	 * Generate a random alphanumeric password
	 */
	public function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1;
	    for ($i = 0; $i < 15; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
}
