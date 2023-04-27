<?php // THE SETTINGS PAGE

	$db_settings_phone = sanitize_text_field ( get_option('db_settings_phone') );
	$db_settings_whatsapp = sanitize_text_field ( get_option('db_settings_whatsapp') );
	$db_settings_email = sanitize_email ( get_option('db_settings_email') );

	if ( isset ( $_POST['submit'] ) )
	{

		if ( function_exists('current_user_can') &&
			 !current_user_can('manage_options') )
				die( _e('Error: You do not have the permission to update the value' , 'db-website-settings') );

		if ( function_exists('check_admin_referrer') )
			check_admin_referrer('db_settings_form');

		// Phone
		if ( $_POST['phone'] >= 0 )
		{
			$db_settings_phone = sanitize_text_field ( $_POST['phone'] );
			update_option ( 'db_settings_phone', $db_settings_phone );
		}

		// Whatsapp
		if ( $_POST['whatsapp'] >= 0 )
		{
			$db_settings_whatsapp = sanitize_text_field ( $_POST['whatsapp'] );
			update_option ( 'db_settings_whatsapp', $db_settings_whatsapp );
		}

		// E-mail
		if ( $_POST['email'] >= 0 )
		{
			$db_settings_email = sanitize_email ( $_POST['email'] );
			update_option ( 'db_settings_email', $db_settings_email );
		}

	}

?>
<div class='wrap db-settings-admin'>

	<h1><?php _e('Website Settings', 'db-website-settings') ?></h1>

	<div class="db-settings-description">
		<p><?php _e("The plugin is used for the basic website settings", 'db-website-settings') ?></p>
	</div>

	<h2><?php _e('Settings', 'db-website-settings') ?></h2>

	<form name="db-settings" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=db-settings&amp;updated=true">

		<?php
			if (function_exists ('wp_nonce_field') )
				wp_nonce_field('db_settings_form');
		?>

		<table class="form-table db-settings-table" width="100%">
			<tr valign="top">
				<th scope="col" width="25%">
					<?php _e('Parameter' , 'db-website-settings') ?>
				</th>
				<th width="25%">
					<?php _e('Value' , 'db-website-settings') ?>
				</th>
				<th width="25%">
					<?php _e('Shortcode' , 'db-website-settings') ?>
				</th>
				<th width="25%">
					<?php _e('Shortcode' , 'db-website-settings') ?> <?php _e('description' , 'db-website-settings') ?>
				</th>
			</tr>
			<tr valign="top">
				<th scope="row" rowspan="2">
					<?php _e('Phone' , 'db-website-settings') ?>
				</th>
				<td rowspan="2">
					<input type="text" name="phone" id="db_settings_phone"
							size="20" value="<?php echo $db_settings_phone; ?>" />
				</td>
				<td>
					[db-phone]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the phone number' , 'db-website-settings') ?> <?php _e('as text' , 'db-website-settings') ?>
				</td>
			</tr>
			<tr valign="top">
				<td>
					[db-phone-link]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the phone number' , 'db-website-settings') ?> <?php _e('as link' , 'db-website-settings') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" rowspan="2">
					<?php _e('Whatsapp' , 'db-website-settings') ?>
				</th>
				<td rowspan="2">
					<input type="text" name="whatsapp" id="db_settings_whatsapp"
							size="20" value="<?php echo $db_settings_whatsapp; ?>" />
				</td>
				<td>
					[db-whatsapp]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the whatsapp number' , 'db-website-settings') ?> <?php _e('as text' , 'db-website-settings') ?>
				</td>
			</tr>
			<tr valign="top">
				<td>
					[db-whatsapp-link]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the whatsapp number' , 'db-website-settings') ?> <?php _e('as link' , 'db-website-settings') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" rowspan="2">
					<?php _e('E-mail' , 'db-website-settings') ?>
				</th>
				<td rowspan="2">
					<input type="text" name="email" id="db_settings_email"
							size="20" value="<?php echo $db_settings_email; ?>" />
				</td>
				<td>
					[db-email]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the e-mail' , 'db-website-settings') ?> <?php _e('as text' , 'db-website-settings') ?>
				</td>
			</tr>
			<tr valign="top">
				<td>
					[db-email-link]
				</td>
				<td>
					<?php _e('insert' , 'db-website-settings') ?> <?php _e('the e-mail' , 'db-website-settings') ?> <?php _e('as link' , 'db-website-settings') ?>
				</td>
			</tr>
		</table>

		<input type="hidden" name="action" value="update" />

		<input type="hidden" name="page_options" value="db_tagcloud_cols" />

		<?php submit_button(); ?>

	</form>

</div>