<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>WP Quick Install</title>
		<!-- Get out Google! -->
		<meta name="robots" content="noindex, nofollow">
		<!-- CSS files -->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=3.9.1" />
		<link rel="stylesheet" href="{{ URL::to('/') }}/css/style.min.css" />
		<link rel="stylesheet" href="{{ URL::to('/') }}/css/buttons.min.css" />
		<link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.min.css" />
	</head>
	<body class="wp-core-ui">
	<h1 id="logo"><a href="http://wp-quick-install.com">WordPress</a></h1>
		<?php
		$parent_dir = realpath( dirname ( dirname( __FILE__ ) ) );
		if ( is_writable( $parent_dir ) ) { ?>

			<div id="response"></div>
			<div class="progress" style="display:none;">
				<div class="progress-bar progress-bar-striped active" style="width: 0%;"></div>
			</div>
			<div id="success" style="display:none; margin: 10px 0;">
				<h1 style="margin: 0">{{ _('The world is yours')  }}</h1>
				<p>{{ _('WordPress has been installed.')  }}</p>
			</div>
			<form method="post" action="">

				<table class="form-table">
					<tr>
						<th scope="row"><label for="default_content">{{ _('Default content') }}</label></th>
						<td>
							<label><input type="checkbox" name="default_content" id="default_content" value="1" checked="checked" /> {{ _('Delete the content') }}</label>
							<p>{{ _('If you want to delete the default content added par WordPress (post, page, comment and links).') }}</p>
						</td>
						<td></td>
					</tr>
				</table>
				
				<div id="errors" class="alert alert-danger" style="display:none;">
					<strong><?php echo _('Warning');?></strong>
				</div>

				<h1>{{ _('Required Informations') }}</h1>
				<p>{{ _('Thank you to provide the following information. Don\'t worry, you will be able to change it later.') }}</p>

				<table class="form-table">
					<tr>
						<th scope="row"><label for="language">{{ _('Language') }}</label></th>
						<td>
							<select id="language" name="language">
								<option value="en_US">English (United States)</option>
								<?php
								// Get all available languages
								$languages = json_decode( file_get_contents( 'http://api.wordpress.org/translations/core/1.0/?version=4.0' ) )->translations;

								foreach ( $languages as $language ) {
									echo '<option value="' . $language->language . '">' . $language->native_name . '</option>';
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input name="url" type="hidden" value="{{ 'http://' . Auth::user()->uid . '.' . env('USER_DOMAIN') }}" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="directory">{{ _('Installation Folder') }}</label>
							<p>{{ _('Leave blank to install on the root folder.') }}</p>
						</th>
						<td>
							<input name="directory" type="text" id="directory" size="25" value="" />
							<p> {{ _('This is relative to your user public_html directory. (i.e. "wordpress" for user "evan" would install at "'. \App\Setting::where('name', 'DEFAULT_HOME_DIRECTORY')->first()->setting .'evan/public_html/wordpress"). ' ) }} <strong> <u> {{ _('Please ensure the directory has 0775 permissions.') }}</u></strong></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="weblog_title">{{ _('Site Title') }}</label></th>
						<td><input name="weblog_title" type="text" id="weblog_title" size="25" value="" class="required" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="user_login">{{ _('Username') }}</label></th>
						<td>
							<input name="user_login" type="text" id="user_login" size="25" value="" class="required" />
							<p>{{ _('Usernames can have only alphanumeric characters, spaces, underscores, hyphens, periods and the @ symbol.') }}</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="admin_password">{{ _('Password') }}</label>
							<p>{{ _('A password will be automatically generated for you if you leave this blank.') }}</p>
						</th>
						<td>
							<input name="admin_password" type="password" id="admin_password" size="25" value="" />
							<p>{{ _('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).') }}.</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="admin_email">{{ _('Your E-mail') }}</label></th>
						<td><input name="admin_email" type="text" id="admin_email" size="25" value="" class="required" />
						<p>{{ _('Double-check your email address before continuing.') }}</p></td>
					</tr>
					<tr>
						<th scope="row"><label for="blog_public">{{ _('Privacy') }}</label></th>
						<td colspan="2"><label><input type="checkbox" id="blog_public" name="blog_public" value="1" checked="checked" /> {{ _('Allow search engines to index this site.') }}</label></td>
					</tr>
				</table>

				<h1>{{ _('Netsoc Theme Information') }}</h1>
				<p>{{ _('Enter the information below for your Netsoc\'s theme.') }}</p>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="activate_theme">{{ _('Automatic Activation') }}</label>
						</th>
						<td colspan="2">
							<label><input type="checkbox" id="activate_theme" name="activate_theme" value="1" /> {{ _('Activate the theme after installing WordPress.') }}</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="delete_default_themes">{{ _('Default Themes') }}</label>
						</th>
						<td colspan="2"><label><input type="checkbox" id="delete_default_themes" name="delete_default_themes" value="1" /> {{ _('Delete the default themes (Twenty Family).') }}</label></td>
					</tr>
				</table>

				<h1>{{ _('Extensions Informations') }}</h1>
				<p>{{ _('Simply enter below the extensions that should be addend during the installation.') }}</p>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="plugins">{{ _('Free Extensions') }}</label>
							<p>{{ _('The extension slug is available in the url (Ex: http://wordpress.org/extend/plugins/<strong>wordpress-seo</strong>)') }}</p>
						</th>
						<td>
							<input name="plugins" type="text" id="plugins" size="50" value="wp-website-monitoring; rocket-lazy-load" />
							<p>{{ _('Make sure that the extensions slugs are separated by a semicolon (;).') }}</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="plugins">{{ _('Premium Extensions') }}</label>
							<p>{{ _('Zip Archives have to be in the <em>plugins</em> folder at the <em>wp-quick-install</em> root folder.') }}</p>
						</th>
						<td><label><input type="checkbox" id="plugins_premium" name="plugins_premium" value="1" /> {{ _('Install the premium extensions after WordPress installation.') }}</label></td>
					</tr>
					<tr>
						<th scope="row">
							<label for="plugins">{{ _('Automatic activation') }}</label>
						</th>
						<td><label><input type="checkbox" name="activate_plugins" id="activate_plugins" value="1" /> {{ _('Activate the extensions after WordPress installation.') }}</label></td>
					</tr>
				</table>

				<h1>{{ _('Permalinks Informations') }}</h1>

				<p>{{ sprintf( _('By default WordPress uses web URLs which have question marks and lots of numbers in them; however, WordPress offers you the ability to create a custom URL structure for your permalinks and archives. This can improve the aesthetics, usability, and forward-compatibility of your links. A <a href="%s">number of tags are available</a>.'), 'http://codex.wordpress.org/Using_Permalinks') }}</p>

				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="permalink_structure">{{ _('Custom Structure') }}</label>
						</th>
						<td>
							<code>{{ 'http://' . Auth::user()->uid . '.' . env('USER_DOMAIN') }}</code>
							<input name="permalink_structure" type="text" id="permalink_structure" size="50" value="/%postname%/" />
						</td>
					</tr>
				</table>

				<h1>{{ _('Media Informations') }}</h1>

				<p>{{ _('Specified dimensions below determine the maximum dimensions (in pixels) to use when inserting an image into the body of an article.') }}</p>

				<table class="form-table">
					<tr>
						<th scope="row">{{ _('Thumbnail sizes') }}</th>
						<td>
							<label for="thumbnail_size_w">{{ _('Width : ') }}</label>
							<input name="thumbnail_size_w" style="width:100px;" type="number" id="thumbnail_size_w" min="0" step="10" value="0" size="1" />
							<label for="thumbnail_size_h">{{ _('Height : ') }}</label>
							<input name="thumbnail_size_h" style="width:100px;" type="number" id="thumbnail_size_h" min="0" step="10" value="0" size="1" /><br>
							<label for="thumbnail_crop" class="small-text"><input name="thumbnail_crop" type="checkbox" id="thumbnail_crop" value="1" checked="checked" />{{ _('Resize images to get the exact dimensions') }}</label>
						</td>
					</tr>
					<tr>
						<th scope="row">{{ _('Middle Size') }}</th>
						<td>
							<label for="medium_size_w">{{ _('Width :') }}</label>
							<input name="medium_size_w" style="width:100px;" type="number" id="medium_size_w" min="0" step="10" value="0" size="5" />
							<label for="medium_size_h">{{ _('Height : ') }}</label>
							<input name="medium_size_h" style="width:100px;" type="number" id="medium_size_h" min="0" step="10" value="0" size="5" /><br>
						</td>
					</tr>
					<tr>
						<th scope="row">{{ _('Big Size') }}</th>
						<td>
							<label for="large_size_w">{{ _('Width : ') }}</label>
							<input name="large_size_w" style="width:100px;" type="number" id="large_size_w" min="0" step="10" value="0" size="5" />
							<label for="large_size_h">{{ _('Height : ') }}</label>
							<input name="large_size_h" style="width:100px;" type="number" id="large_size_h" min="0" step="10" value="0" size="5" /><br>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="upload_dir">{{ _('Store uploaded files in this folder') }}</label>
							<p>{{ _('By default, medias are stored in the <em> wp-content/uploads</em> folder') }}</p>
						</th>
						<td>
							<input type="text" id="upload_dir" name="upload_dir" size="46" value="" /><br/>
							<label for="uploads_use_yearmonth_folders" class="small-text"><input name="uploads_use_yearmonth_folders" type="checkbox" id="uploads_use_yearmonth_folders" value="1" checked="checked" />{{ _('Organize my files in monthly and annual folders') }}</label>
						</td>
					</tr>
				</table>

				<h1>{{ _('wp-config.php Informations') }}</h1>
				<p>{{ _('Choose below the additional constants you want to add in <strong>wp-config.php</strong>') }}</p>

				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="post_revisions">{{ _('Revisions') }}</label>
							<p>{{ _('By default, number of post revision is unlimited') }}</p>
						</th>
						<td>
							<input name="post_revisions" id="post_revisions" type="number" min="0" value="0" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="plugins">{{ _('Editor') }}</label>
						</th>
						<td><label><input type="checkbox" id="disallow_file_edit" name="disallow_file_edit" value="1" checked='checked' />{{ _('Disable theme and extensions editor') }}</label></td>
					</tr>
					<tr>
						<th scope="row">
							<label for="autosave_interval">{{ _('Autosave') }}</label>
							<p>{{ _('By default, autosave interval is 60 seconds.') }}</p>
						</th>
						<td><input name="autosave_interval" id="autosave_interval" type="number" min="60" step="60" size="25" value="7200" /> {{ _('seconds') }}</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="debug">{{ _('Debug Mode') }}</label>
						</th>
						<td>
							<label><input type="checkbox" name="debug" id="debug" value="1" /> {{ _('Enable WordPress debug mode') }}
							</label><p>By checking this box, WordPress will displaying errors</p>


							<div id="debug_options" style="display:none;">
								<label><input type="checkbox" name="debug_display" id="debug_display" value="1" /> {{ _('Enable WP Debug') }}</label>
								<br/>
								<label><input type="checkbox" name="debug_log" id="debug_log" value="1" /> {{ _('Write errors in a log file <em>(wp-content/debug.log)</em>. ') }}</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="wpcom_api_key">{{ _('WP.com API Key') }}</label>
						</th>
						<td><input name="wpcom_api_key" id="wpcom_api_key" type="text" size="25" value="" /></td>
					</tr>
				</table>
				<p class="step"><span id="submit" class="button button-large">{{ _('Install WordPress') }}</span></p>
				{{ csrf_field() }}
				<input type="hidden" name="random_int" value="{{ \Crypt::encrypt( $random_int = mt_rand(0,9999)) }}"/>
				<input type="hidden" name="dbname" value='{{ \Crypt::encrypt( substr(Auth::user()->uid, 0, 8) . "_db_" . $random_int ) }}' />
				<input type="hidden" name="uname" value='{{ \Crypt::encrypt( substr(Auth::user()->uid, 0, 8) . "_wp_" . $random_int ) }}' />
				<input type="hidden" name="pwd" value='{{ \Crypt::encrypt( App\Http\Controllers\MySQLController::randomPassword( ) ) }}' />
				<input type="hidden" name="dbhost" value='{{ \Crypt::encrypt( env("MYSQL_HOST") ) }}' />
				<input type="hidden" name="prefix" value='{{ \Crypt::encrypt( "netsoc_wp_" ) }}' />
			</form>
			
			<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
			<script>var data = {!! $data !!};</script>
			<script src="{{ URL::to('/') }}/js/wordpress.js"></script>

		<?php
		} else { ?>

			<div class="alert alert-error" style="margin-bottom: 0px;">
				<strong>{{ _('Warning !') }}</strong>
				<p style="margin-bottom:0px;">{{ _('You don\'t have the good permissions rights on ') . basename( $parent_dir ) . _('. Thank you to set the good files permissions.')  }}</p>
			</div>

		<?php
		}
		?>
	</body>
</html>