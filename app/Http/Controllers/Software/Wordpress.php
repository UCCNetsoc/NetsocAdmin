<?php namespace App\Http\Controllers\Software;

use App\Http\Controllers\Controller;

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

use App\Http\Controllers\MySQLController;
use App\Http\Controllers\FileController;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;


/**
 * Adaption of Jonathan Buttigieg's script WP Quick Install
 * Script URI: http://wp-quick-install.com
 * Version: 1.4.1
 * Licence: GPLv3
 *
 * Heavily reworked to be object oriented and fit our system
 */


class Wordpress extends Controller
{

	private $WP_API_CORE				= "";
	private $WPQI_CACHE_PATH			= "";
	private $WPQI_CACHE_CORE_PATH		= "";
	private $WPQI_CACHE_PLUGINS_PATH	= "";
	private $data 						= [];
	private $defaults					= [];


	public function _construct( ){
		$this->WP_API_CORE				= 'http://api.wordpress.org/core/version-check/1.7/?locale=';
		$this->WPQI_CACHE_PATH			= 'cache/';
		$this->WPQI_CACHE_CORE_PATH		= $this->WPQI_CACHE_PATH . 'core/';
		$this->WPQI_CACHE_PLUGINS_PATH	= $this->WPQI_CACHE_PATH . 'plugins/';

		// Create cache directories
		if ( ! is_dir( $this->WPQI_CACHE_PATH ) ) {
			mkdir( $this->WPQI_CACHE_PATH );
		}
		if ( ! is_dir( $this->WPQI_CACHE_CORE_PATH ) ) {
			mkdir( $this->WPQI_CACHE_CORE_PATH );
		}
		if ( ! is_dir( $this->WPQI_CACHE_PLUGINS_PATH ) ) {
			mkdir( $this->WPQI_CACHE_PLUGINS_PATH );
		}

		// We verify if there is a preconfig file
		$this->data = array();
		$this->defaults = array();
		if ( file_exists( app_path() . '/Http/Controllers/Software/wordpress/data.ini' ) ) {
			$this->data = json_encode( parse_ini_file( app_path() . '/Http/Controllers/Software/wordpress/data.ini' ) );
			$this->defaults = parse_ini_file( app_path() . '/Http/Controllers/Software/wordpress/data.ini' );
		}


	}

	public function install( ){
		$this->_construct( );

		$data = Request::all();
		if( isset( $data['action'] ) ){
			/* DATABASE DEFAULTS */

			if( isset( $data['random_int'] ) ){
				// We encrypt and decrypt random int so that it can
				// persist throughout but can't be tampered with
				$random_int = Crypt::decrypt( $data['random_int'] );
				
				// Decode encrypted data
				$data['dbname'] 	= Crypt::decrypt( $data['dbname'] );
				$data['uname'] 		= Crypt::decrypt( $data['uname'] );
				$data['pwd'] 		= Crypt::decrypt( $data['pwd'] );
				$data['dbhost'] 	= Crypt::decrypt( $data['dbhost'] );
				$data['prefix'] 	= Crypt::decrypt( $data['prefix'] );
				$data['url'] 		= $data['url'] . $data['directory'];
			}

			$this->handleInstall( $data );
			die();
		}

		return View::make('admin.software.wordpress.index')->with('data', $this->data);
	}
	

	public function handleInstall( $postInfo ){
		$this->_construct( );

		// We add  ../ to directory
		$directory = ! empty( $postInfo['directory'] ) ? $postInfo['directory'] . '/' : '';

		// Every directory should be an extension of a user's 
		// public_html directory
		$directory = Setting::where('name', 'DEFAULT_HOME_DIRECTORY')->first()->setting 
						. Auth::user()->uid . "/public_html/" . $directory;

		
		// try {
		//    $db = new \PDO('mysql:host=127.0.0.1;dbname=tester_db_3496', 'tester_wp_3496', '9NQJ66gGN3XVDLm');
		// }
		// catch (Exception $e) {
		// 	$this->data['db'] = "error etablishing connection";
		// }
		// dd();


		switch( $postInfo['action'] ) {

			case "check_before_upload" :

				$this->data = array();

				/*--------------------------*/
				/*	We verify if we can connect to DB or WP is not installed yet
				/*--------------------------*/

				// WordPress test
				if ( file_exists( $directory . 'wp-config.php' ) ) {
					$this->data['wp'] = "error directory";
				}

				if( substr(sprintf('%o', fileperms($directory)), -4) != '0775' ){
					$this->data['wp'] = "error directory-permissions";
				}

				try {
					MySQLDatabase::where('db_name', $postInfo['dbname'] )->firstOrfail();
				} catch (ModelNotFoundException $e) {
					// Create a database and a user
					MySQLController::createDatabase( $postInfo['dbname'] );
					MySQLController::createSoleUser( $postInfo['uname'], $postInfo['pwd'], $postInfo['dbname'] );
				}
				
				
				// DB Test
				try {
				   $db = new \PDO('mysql:host='. $postInfo['dbhost'] .';dbname=' . $postInfo['dbname'] , $postInfo['uname'], $postInfo['pwd'] );
				}
				catch (Exception $e) {
					$this->data['db'] = "error etablishing connection";
				}

				// We send the response
				echo json_encode( $this->data );

				break;

			case "download_wp" :

				// Get WordPress language
				$language = substr( $postInfo['language'], 0, 6 );

				// Get WordPress data
				$wp = json_decode( file_get_contents( $this->WP_API_CORE . $language ) )->offers[0];

				/*--------------------------*/
				/*	We download the latest version of WordPress
				/*--------------------------*/

				if ( ! file_exists( $this->WPQI_CACHE_CORE_PATH . 'wordpress-' . $wp->version . '-' . $language  . '.zip' ) ) {
					file_put_contents( $this->WPQI_CACHE_CORE_PATH . 'wordpress-' . $wp->version . '-' . $language  . '.zip', file_get_contents( $wp->download ) );
				}

				break;

			case "unzip_wp" :

				// Get WordPress language
				$language = substr( $postInfo['language'], 0, 6 );

				// Get WordPress data
				$wp = json_decode( file_get_contents( $this->WP_API_CORE . $language ) )->offers[0];

				/*--------------------------*/
				/*	We create the website folder with the files and the WordPress folder
				/*--------------------------*/


				$zip = new \ZipArchive;

				// We verify if we can use the archive
				if ( $zip->open( $this->WPQI_CACHE_CORE_PATH . 'wordpress-' . $wp->version . '-' . $language  . '.zip' ) === true ) {

					// Let's unzip
					$zip->extractTo( '.' );
					$zip->close();

					// We scan the folder
					$files = scandir( 'wordpress' );

					// We remove the "." and ".." from the current folder and its parent
					$files = array_diff( $files, array( '.', '..' ) );

					$this->recursive_copy('wordpress', $directory);

					$this->rrmdir( 'wordpress' ); // We remove WordPress folder
					unlink( $directory . '/license.txt' ); // We remove licence.txt
					unlink( $directory . '/readme.html' ); // We remove readme.html
					unlink( $directory . '/wp-content/plugins/hello.php' ); // We remove Hello Dolly plugin
				}

				break;

				case "wp_config" :

					/*--------------------------*/
					/*	Let's create the wp-config file
					/*--------------------------*/

					// We retrieve each line as an array
					$config_file = file( $directory . 'wp-config-sample.php' );

					// Managing the security keys
					$secret_keys = explode( "\n", file_get_contents( 'https://api.wordpress.org/secret-key/1.1/salt/' ) );

					foreach ( $secret_keys as $k => $v ) {
						$secret_keys[$k] = substr( $v, 28, 64 );
					}

					// We change the data
					$key = 0;
					foreach ( $config_file as &$line ) {

						if ( '$table_prefix  =' == substr( $line, 0, 16 ) ) {
							$line = '$table_prefix  = \'' . $this->sanit( $postInfo[ 'prefix' ] ) . "';\r\n";
							continue;
						}

						if ( ! preg_match( '/^define\(\'([A-Z_]+)\',([ ]+)/', $line, $match ) ) {
							continue;
						}

						$constant = $match[1];

						switch ( $constant ) {
							case 'WP_DEBUG'	   :

								// Debug mod
								if ( isset( $postInfo['debug'] ) && (int) $postInfo['debug'] == 1 ) {
									$line = "define('WP_DEBUG', 'true');\r\n";

									// Display error
									if ( isset( $postInfo['debug_display'] ) && (int) $postInfo['debug_display'] == 1 ) {
										$line .= "\r\n\n " . "/** Affichage des erreurs à l'écran */" . "\r\n";
										$line .= "define('WP_DEBUG_DISPLAY', 'true');\r\n";
									}

									// To write error in a log files
									if ( isset( $postInfo['debug_log'] ) && (int) $postInfo['debug_log'] == 1 ) {
										$line .= "\r\n\n " . "/** Ecriture des erreurs dans un fichier log */" . "\r\n";
										$line .= "define('WP_DEBUG_LOG', 'true');\r\n";
									}
								}

								// We add the extras constant
								if ( isset( $postInfo['uploads'] ) && ! empty( $postInfo['uploads'] ) ) {
									$line .= "\r\n\n " . "/** Dossier de destination des fichiers uploadés */" . "\r\n";
									$line .= "define('UPLOADS', '" . $this->sanit( $postInfo['uploads'] ) . "');";
								}

								if ( isset($postInfo['post_revisions']) && (int) $postInfo['post_revisions'] >= 0 ) {
									$line .= "\r\n\n " . "/** Désactivation des révisions d'articles */" . "\r\n";
									$line .= "define('WP_POST_REVISIONS', " . (int) $postInfo['post_revisions'] . ");";
								}

								if ( isset($postInfo['disallow_file_edit']) && (int) $postInfo['disallow_file_edit'] == 1 ) {
									$line .= "\r\n\n " . "/** Désactivation de l'éditeur de thème et d'extension */" . "\r\n";
									$line .= "define('DISALLOW_FILE_EDIT', true);";
								}

								if ( isset($postInfo['autosave_interval']) && (int) $postInfo['autosave_interval'] >= 60 ) {
									$line .= "\r\n\n " . "/** Intervalle des sauvegardes automatique */" . "\r\n";
									$line .= "define('AUTOSAVE_INTERVAL', " . (int) $postInfo['autosave_interval'] . ");";
								}
								
								if ( isset( $postInfo['wpcom_api_key'] ) && ! empty( $postInfo['wpcom_api_key'] ) ) {
									$line .= "\r\n\n " . "/** WordPress.com API Key */" . "\r\n";
									$line .= "define('WPCOM_API_KEY', '" . $postInfo['wpcom_api_key'] . "');";
								}

								$line .= "\r\n\n " . "/** On augmente la mémoire limite */" . "\r\n";
								$line .= "define('WP_MEMORY_LIMIT', '96M');" . "\r\n";

								break;
							case 'DB_NAME'     :
								$line = "define('DB_NAME', '" . $this->sanit( $postInfo[ 'dbname' ] ) . "');\r\n";
								break;
							case 'DB_USER'     :
								$line = "define('DB_USER', '" . $this->sanit( $postInfo['uname'] ) . "');\r\n";
								break;
							case 'DB_PASSWORD' :
								$line = "define('DB_PASSWORD', '" . $this->sanit( $postInfo['pwd'] ) . "');\r\n";
								break;
							case 'DB_HOST'     :
								$line = "define('DB_HOST', '" . $this->sanit( $postInfo['dbhost'] ) . "');\r\n";
								break;
							case 'AUTH_KEY'         :
							case 'SECURE_AUTH_KEY'  :
							case 'LOGGED_IN_KEY'    :
							case 'NONCE_KEY'        :
							case 'AUTH_SALT'        :
							case 'SECURE_AUTH_SALT' :
							case 'LOGGED_IN_SALT'   :
							case 'NONCE_SALT'       :
								$line = "define('" . $constant . "', '" . $secret_keys[$key++] . "');\r\n";
								break;

							case 'WPLANG' :
								$line = "define('WPLANG', '" . $this->sanit( $postInfo['language'] ) . "');\r\n";
								break;
						}
					}
					unset( $line );

					$handle = fopen( $directory . 'wp-config.php', 'w' );
					foreach ( $config_file as $line ) {
						fwrite( $handle, $line );
					}
					fclose( $handle );

					chmod( $directory . 'wp-config.php', 0775 );
					chgrp( $directory . 'wp-config.php', Setting::where('name', 'REGISTRATION_GROUP')->first()->setting );

					break;

				case "install_wp" :
					/*--------------------------*/
					/*	Let's install WordPress database
					/*--------------------------*/

					define( 'WP_INSTALLING', true );
					
					/** Load WordPress Bootstrap */
					require_once( $directory . 'wp-load.php' );

					/** Load WordPress Administration Upgrade API */
					require_once( $directory . 'wp-admin/includes/upgrade.php' );

					/** Load wpdb */
					require_once( $directory . 'wp-includes/wp-db.php' );

					// WordPress installation
					wp_install( $postInfo[ 'weblog_title' ], $postInfo['user_login'], $postInfo['admin_email'], (int) $postInfo[ 'blog_public' ], '', $postInfo['admin_password'] );
	                

					update_option( 'siteurl', $postInfo['url'] );
					update_option( 'home', $postInfo['url'] );

					/*--------------------------*/
					/*	We remove the default content
					/*--------------------------*/

					if ( isset( $postInfo['default_content'] ) && $postInfo['default_content'] == '1' ) {
						wp_delete_post( 1, true ); // We remove the article "Hello World"
						wp_delete_post( 2, true ); // We remove the "Exemple page"
					}

					/*--------------------------*/
					/*	We update permalinks
					/*--------------------------*/
					if ( isset($postInfo['permalink_structure']) && ! empty( $postInfo['permalink_structure'] ) ) {
						update_option( 'permalink_structure', $postInfo['permalink_structure'] );
					}

					/*--------------------------*/
					/*	We update the media settings
					/*--------------------------*/

					if ( isset($postInfo['thumbnail_size_w']) && ! empty( $postInfo['thumbnail_size_w'] ) || !empty($postInfo['thumbnail_size_h'] ) ) {
						update_option( 'thumbnail_size_w', (int) $postInfo['thumbnail_size_w'] );
						update_option( 'thumbnail_size_h', (int) $postInfo['thumbnail_size_h'] );
						update_option( 'thumbnail_crop', (int) $postInfo['thumbnail_crop'] );
					}

					if ( isset($postInfo['medium_size_w']) && ! empty( $postInfo['medium_size_w'] ) || !empty( $postInfo['medium_size_h'] ) ) {
						update_option( 'medium_size_w', (int) $postInfo['medium_size_w'] );
						update_option( 'medium_size_h', (int) $postInfo['medium_size_h'] );
					}

					if ( isset($postInfo['large_size_w']) && ! empty( $postInfo['large_size_w'] ) || !empty( $postInfo['large_size_h'] ) ) {
						update_option( 'large_size_w', (int) $postInfo['large_size_w'] );
						update_option( 'large_size_h', (int) $postInfo['large_size_h'] );
					}

					 update_option( 'uploads_use_yearmonth_folders', (int) $postInfo['uploads_use_yearmonth_folders'] );

					/*--------------------------*/
					/*	We add the pages we found in the wordpress/data.ini file
					/*--------------------------*/

					// We check if wordpress/data.ini exists
					if ( file_exists( app_path() . '/Http/Controllers/Software/wordpress/data.ini' ) ) {

						// We parse the file and get the array
						$file = parse_ini_file( app_path() . '/Http/Controllers/Software/wordpress/data.ini' );

						// We verify if we have at least one page
						if ( count( $file['posts'] ) >= 1 ) {

							foreach ( $file['posts'] as $post ) {

								// We get the line of the page configuration
								$pre_config_post = explode( "-", $post );
								$post = array();

								foreach ( $pre_config_post as $config_post ) {

									// We retrieve the page title
									if ( preg_match( '#title::#', $config_post ) == 1 ) {
										$post['title'] = str_replace( 'title::', '', $config_post );
									}

									// We retrieve the status (publish, draft, etc...)
									if ( preg_match( '#status::#', $config_post ) == 1 ) {
										$post['status'] = str_replace( 'status::', '', $config_post );
									}

									// On retrieve the post type (post, page or custom post types ...)
									if ( preg_match( '#type::#', $config_post ) == 1 ) {
										$post['type'] = str_replace( 'type::', '', $config_post );
									}

									// We retrieve the content
									if ( preg_match( '#content::#', $config_post ) == 1 ) {
										$post['content'] = str_replace( 'content::', '', $config_post );
									}

									// We retrieve the slug
									if ( preg_match( '#slug::#', $config_post ) == 1 ) {
										$post['slug'] = str_replace( 'slug::', '', $config_post );
									}

									// We retrieve the title of the parent
									if ( preg_match( '#parent::#', $config_post ) == 1 ) {
										$post['parent'] = str_replace( 'parent::', '', $config_post );
									}

								} // foreach

								if ( isset( $post['title'] ) && !empty( $post['title'] ) ) {

									$parent = get_page_by_title( trim( $post['parent'] ) );
	 								$parent = $parent ? $parent->ID : 0;

									// Let's create the page
									$args = array(
										'post_title' 		=> trim( $post['title'] ),
										'post_name'			=> $post['slug'],
										'post_content'		=> trim( $post['content'] ),
										'post_status' 		=> $post['status'],
										'post_type' 		=> $post['type'],
										'post_parent'		=> $parent,
										'post_author'		=> 1,
										'post_date' 		=> date('Y-m-d H:i:s'),
										'post_date_gmt' 	=> gmdate('Y-m-d H:i:s'),
										'comment_status' 	=> 'closed',
										'ping_status'		=> 'closed'
									);
									wp_insert_post( $args );

								}

							}
						}
					}

					break;

				case "install_theme" :

					/** Load WordPress Bootstrap */
					require_once( $directory . 'wp-load.php' );

					/** Load WordPress Administration Upgrade API */
					require_once( $directory . 'wp-admin/includes/upgrade.php' );

					/*--------------------------*/
					/*	We install the new theme
					/*--------------------------*/

					// We verify if theme.zip exists
					if ( file_exists( app_path() . '/Http/Controllers/Software/wordpress/theme.zip' ) ) {

						$zip = new \ZipArchive;

						// We verify we can use it
						if ( $zip->open( app_path() . '/Http/Controllers/Software/wordpress/theme.zip' ) === true ) {

							// We retrieve the name of the folder
							$stat = $zip->statIndex( 0 );
							$theme_name = str_replace('/', '' , $stat['name']);

							// We unzip the archive in the themes folder
							$zip->extractTo( $directory . 'wp-content/themes/' );
							$zip->close();

							// Let's activate the theme
							// Note : The theme is automatically activated if the user asked to remove the default theme
							if ( isset( $postInfo['activate_theme'] ) && $postInfo['activate_theme'] == 1 || $postInfo['delete_default_themes'] == 1 ) {
								switch_theme( $theme_name, $theme_name );
							}

							// Let's remove the Tweenty family
							if ( isset( $postInfo['delete_default_themes'] ) && $postInfo['delete_default_themes'] == 1 ) {
								delete_theme( 'twentyfourteen' );
								delete_theme( 'twentythirteen' );
								delete_theme( 'twentytwelve' );
								delete_theme( 'twentyeleven' );
								delete_theme( 'twentyten' );
							}

							// We delete the _MACOSX folder (bug with a Mac)
							delete_theme( '__MACOSX' );

						}
					}

				break;

				case "install_plugins" :

					/*--------------------------*/
					/*	Let's retrieve the plugin folder
					/*--------------------------*/

					if ( isset( $postInfo['plugins'] ) && ! empty( $postInfo['plugins'] ) ) {

						$plugins     = explode( ";", $postInfo['plugins'] );
						$plugins     = array_map( 'trim' , $plugins );
						$plugins_dir = $directory . 'wp-content/plugins/';

						foreach ( $plugins as $plugin ) {

							// We retrieve the plugin XML file to get the link to downlad it
						    $plugin_repo = file_get_contents( "http://api.wordpress.org/plugins/info/1.0/$plugin.json" );

						    if ( $plugin_repo && $plugin = json_decode( $plugin_repo ) ) {

								$plugin_path = $this->WPQI_CACHE_PLUGINS_PATH . $plugin->slug . '-' . $plugin->version . '.zip';

								if ( ! file_exists( $plugin_path ) ) {
									// We download the lastest version
									if ( $download_link = file_get_contents( $plugin->download_link ) ) {
	 									file_put_contents( $plugin_path, $download_link );
	 								}							}

						    	// We unzip it
						    	$zip = new \ZipArchive;
								if ( $zip->open( $plugin_path ) === true ) {
									$zip->extractTo( $plugins_dir );
									$zip->close();
									$this->chmod_r( $plugins_dir . $plugin->slug  );
								}
						    }
						}
					}

					if ( $postInfo['plugins_premium'] == 1 ) {

						// We scan the folder
						$plugins = scandir( $directory . 'wp-content/plugins' );

						// We remove the "." and ".." corresponding to the current and parent folder
						$plugins = array_diff( $plugins, array( '.', '..' ) );

						// We move the archives and we unzip
						foreach ( $plugins as $plugin ) {

							// We verify if we have to retrive somes plugins via the WP Quick Install "plugins" folder
							if ( preg_match( '#(.*).zip$#', $plugin ) == 1 ) {

								$zip = new \ZipArchive;

								// We verify we can use the archive
								if ( $zip->open(  $directory . 'wp-content/plugins/' . $plugin ) === true ) {

									// We unzip the archive in the plugin folder
									$zip->extractTo( $plugins_dir );
									$zip->close();
								}
							}
						}
					}

					/*--------------------------*/
					/*	We activate extensions
					/*--------------------------*/

					if ( $postInfo['activate_plugins'] == 1 ) {

						/** Load WordPress Bootstrap */
						require_once( $directory . 'wp-load.php' );

						/** Load WordPress Plugin API */
						require_once( $directory . 'wp-admin/includes/plugin.php');

						// Activation
						activate_plugins( array_keys( get_plugins() ) );
					}

				break;

				case "success" :

					/*--------------------------*/
					/*	If we have a success we add the link to the admin and the website
					/*--------------------------*/

					/** Load WordPress Bootstrap */
					require_once( $directory . 'wp-load.php' );

					/** Load WordPress Administration Upgrade API */
					require_once( $directory . 'wp-admin/includes/upgrade.php' );

					/*--------------------------*/
					/*	We update permalinks
					/*--------------------------*/
					if ( ! empty( $postInfo['permalink_structure'] ) ) {
						file_put_contents( $directory . '.htaccess' , null );
						chgrp($directory . '.htaccess', 'member');
						chmod($directory . '.htaccess', 0755);
						flush_rewrite_rules();
					}

					// Link to the admin
					echo '<a href="' . admin_url() . '" class="button" style="margin-right:5px;" target="_blank">'. _('Log In') . '</a>';
					echo '<a href="' . home_url() . '" class="button" target="_blank">' . _('Go to website') . '</a>';
					echo '<a href="' . \URL::route('home') . '" class="button" target="_blank">' . _('Go Back To Netsoc') . '</a>';

					break;
		}
	}


	/**
	 * Sanitise string
	 */
	private function sanit( $str ) {
		return addcslashes( str_replace( array( ';', "\n" ), '', $str ), '\\' );
	}

	/**
	 * Recursively delete a directory and its contents
	 */
	private function rrmdir($path) {
	    return FileController::rrmdir( $path );
	}

	/**
	 * Recursively copy all the files from source folder to destination
	 */
	private function recursive_copy($src, $dst) { 
	    FileController::recursive_copy( $src, $dst );
	}

	/**
	 * Recursively chmod and chgrp a folder
	 */
	private function chmod_r($path) {
	    $dir = new \DirectoryIterator($path);
	    foreach ($dir as $item) {
	        chmod($item->getPathname(), 0775);
	        chgrp($item->getPathname(), Setting::where('name', 'REGISTRATION_GROUP')->first()->setting);
	        if ($item->isDir() && !$item->isDot()) {
	            $this->chmod_r($item->getPathname());
	        }
	    }
	}
}
