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

class FileController extends Controller{

	/**
	 * Recursively delete a directory and its contents
	 */
	public static function rrmdir($path) {
	    return is_file($path) ? @unlink($path): array_map( array(new FileController(), 'rrmdir'), glob($path.'/*'))==@rmdir($path);
	}

	/**
	 * Recursively copy all the files from source folder to destination
	 */
	public static function recursive_copy($src, $dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                FileController::recursive_copy($src . '/' . $file,$dst . '/' . $file);
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file);
	            } 
	            chgrp($dst . '/' . $file, Setting::where('name', 'REGISTRATION_GROUP')->first()->setting);
	            chmod($dst . '/' . $file, 0775);
	        } 
	    } 
	    closedir($dir); 
	}
}