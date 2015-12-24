<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		Setting::create(['name' => 'registration_group', 'setting' => env('REGISTRATION_GROUP')]);
		Setting::create(['name' => 'registration_group_id', 'setting' => env('REGISTRATION_GROUP_ID')]);
		Setting::create(['name' => 'default_home_directory', 'setting' => env('DEFAULT_HOME_DIRECTORY')]);
		Setting::create(['name' => 'default_shell', 'setting' => env('DEFAULT_SHELL')]);
		Setting::create(['name' => 'db_manager_url', 'setting' => env('DB_MANAGER_URL')]);


		Setting::create(['name' => 'current_uid_number', 'setting' => env('INITIAL_UID_NUMBER')]);		
	}
}
