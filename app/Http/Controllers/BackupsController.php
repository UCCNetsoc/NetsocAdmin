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

class BackupsController extends Controller{

	public function index( ){

		if( !file_exists(storage_path() .'/backups/'. Auth::user()->uid .'/weekly') ){
			if(!file_exists(storage_path() .'/backups/'){ mkdir(storage_path() .'/backups/'); }
			if(!file_exists(storage_path() .'/backups/'. Auth::user()->uid){ mkdir(storage_path() .'/backups/'. Auth::user()->uid); }
			if(!file_exists(storage_path() .'/backups/'. Auth::user()->uid .'/weekly'){ mkdir(storage_path() .'/backups/'. Auth::user()->uid .'/weekly'); }
			if(!file_exists(storage_path() .'/backups/'.Auth::user()->uid .'/monthly'){ mkdir(storage_path() .'/backups/'. Auth::user()->uid .'/monthly'); }
		}

		$weekly_files = array_diff(
							scandir( 
								storage_path() .'/backups/'. Auth::user()->uid .'/weekly' 
							), array('.', '..', 'manifest.txt')
						);

		$monthly_files = array_diff(
							scandir( 
								storage_path() .'/backups/'. Auth::user()->uid .'/monthly' 
							), array('.', '..', 'manifest.txt')
						);
		
		return View::make('admin.backups.index')->with( ['weekly_files' => $weekly_files, 'monthly_files' => $monthly_files]);
	}
}