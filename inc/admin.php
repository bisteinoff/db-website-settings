<?php // THE SETTINGS PAGE

	$baseObj = new dbSettings();
	$d = $baseObj -> thisdir(); // domain for translate.wordpress.org


	// getting the values of the options
	$i = 0;
	while ( $option = sanitize_text_field ( get_option( 'db_settings_phone_' . $i ) ) )
	{
		$db_settings_phone[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = sanitize_text_field ( get_option( 'db_settings_whatsapp_' . $i ) ) )
	{
		$db_settings_whatsapp[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = sanitize_text_field ( get_option( 'db_settings_email_' . $i ) ) )
	{
		$db_settings_email[ $i ] = $option;
		$i++;
	}


	// form submit
	if ( isset ( $_POST['submit'] ) )
	{

		if ( function_exists('current_user_can') &&
			 !current_user_can('manage_options') )
				die( _e( "Error: You do not have the permission to update the value" , $d ) );

		if ( function_exists('check_admin_referrer') )
			check_admin_referrer('db_settings_form');

		// Phone
		$i = 0;
		while ( $option = sanitize_text_field ( $_POST[ 'phone_' . $i ] ) )
		{
			$db_settings_phone[ $i ] = $option;
			update_option ( 'db_settings_phone_'. $i , $db_settings_phone[ $i ] );
			$i++;
		}

		// Whatsapp
		$i = 0;
		while ( $option = sanitize_text_field ( $_POST[ 'whatsapp_' . $i ] ) )
		{
			$db_settings_whatsapp[ $i ] = $option;
			update_option ( 'db_settings_whatsapp_'. $i , $db_settings_whatsapp[ $i ] );
			$i++;
		}

		// E-mail
		$i = 0;
		while ( $option = sanitize_email ( $_POST[ 'email_' . $i ] ) )
		{
			$db_settings_email[ $i ] = $option;
			update_option ( 'db_settings_email_'. $i , $db_settings_email[ $i ] );
			$i++;
		}

	}

?>
<div class='wrap db-settings-admin'>

	<h1><?php _e( "Website Settings" , $d ) ?></h1>

	<div class="db-settings-description">
		<p><?php _e( "The plugin is used for the basic website settings" , $d ) ?></p>
	</div>

	<h2><?php _e( "Settings" , $d ) ?></h2>

	<form name="db-settings" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=db-settings&amp;updated=true">

		<?php
			if (function_exists ('wp_nonce_field') )
				wp_nonce_field('db_settings_form');
		?>

		<table id="db-settings-table" class="form-table db-settings-table" width="100%">
			<tr valign="top">
				<th scope="col" width="20%">
					<?php _e( "Parameter" , $d ) ?>
				</th>
				<th scope="col" width="20%">
					<?php _e( "Value" , $d ) ?>
				</th>
				<th scope="col" width="20%">
					<?php _e( "Shortcode" , $d ) ?>
				</th>
				<th scope="col" width="20%">
					<?php _e( "Shortcode" , $d ) ?> <?php _e( "description" , $d ) ?>
				</th>
				<th scope="col" width="20%">
					<?php _e( "Example" , $d ) ?>
				</th>
			</tr>
			<?php
				// Phones
				$i = -1;
				while ( $db_settings_phone[ ++$i ] ) :
					$ext = $i > 0 ? $i + 1 : '';
				?>
				<tr id="phone_<?php echo $i ?>_1" valign="top">
					<th scope="row" rowspan="2">
						<?php _e( "Phone" , $d ) ?> <?php echo $ext ?>
					</th>
					<td rowspan="2">
						<input type="text" name="phone_<?php echo $i ?>" id="db_settings_phone_<?php echo $i ?>"
								size="20" value="<?php echo $db_settings_phone[ $i ]; ?>" />
					</td>
					<td>
						[db-phone<?php echo $ext ?>]
					</td>
					<td id="phone_<?php echo $i ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-phone" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="phone_<?php echo $i ?>_2" valign="top">
					<td>
						[db-phone<?php echo $ext ?>-link]
					</td>
					<td id="phone_<?php echo $i ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-phone" . $ext . "-link]"); ?>
					</td>
				</tr>
			<?php
				endwhile; // .Phones


				// Whatsapp Chats
				$i = -1;
				while ( $db_settings_whatsapp[ ++$i ] ) :
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="whatsapp_<?php echo $i ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php _e( "Whatsapp" , $d ) ?> <?php echo $ext ?>
					</th>
					<td rowspan="3">
						<input type="text" name="whatsapp_<?php echo $i ?>" id="db_settings_whatsapp_<?php echo $i ?>"
								size="20" value="<?php echo $db_settings_whatsapp[ $i ]; ?>" />
					</td>
					<td>
						[db-whatsapp<?php echo $ext ?>]
					</td>
					<td id="whatsapp_<?php echo $i ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo $i ?>_2" valign="top">
					<td>
						[db-whatsapp<?php echo $ext ?>-link]
					</td>
					<td id="whatsapp_<?php echo $i ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "-link]"); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo $i ?>_3" valign="top">
					<td>
						[db-whatsapp<?php echo $ext ?>-href]
					</td>
					<td id="whatsapp_<?php echo $i ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "-href]"); ?>
					</td>
				</tr>
			<?php
				endwhile; // .Whatsapp Chats


				// E-mails
				$i = -1;
				while ( $db_settings_email[ ++$i ] ) :
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="email_<?php echo $i ?>_1" valign="top">
					<th scope="row" rowspan="2">
						<?php _e( "E-mail" , $d ) ?> <?php echo $ext ?>
					</th>
					<td rowspan="2">
						<input type="text" name="email_<?php echo $i ?>" id="db_settings_email_<?php echo $i ?>"
								size="20" value="<?php echo $db_settings_email[ $i ]; ?>" />
					</td>
					<td>
						[db-email<?php echo $ext ?>]
					</td>
					<td id="email_<?php echo $i ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-email" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="email_<?php echo $i ?>_2" valign="top">
					<td>
						[db-email<?php echo $ext ?>-link]
					</td>
					<td id="email_<?php echo $i ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-email-link" . $ext . "]"); ?>
					</td>
				</tr>
			<?php
				endwhile; // .E-mails
			?>
		</table>

		<div id="db_settings_add_buttons">
			<a id="db_settings_add_phone"><?php _e( "Add Phone" , $d ) ?></a>
			<a id="db_settings_add_whatsapp"><?php _e( "Add Whatsapp" , $d ) ?></a>
			<a id="db_settings_add_email"><?php _e( "Add E-mail" , $d ) ?></a>
		</div>

		<input type="hidden" name="action" value="update" />

		<input type="hidden" name="page_options" value="db_tagcloud_cols" />

		<?php submit_button(); ?>

	</form>

</div>

<script type="text/javascript">
	let dbSettingsDescriptions = {
		"phone" : [
			"<?php _e( "Phone" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the phone number" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e("the phone number" , $d ) ?> <?php _e( "as link" , $d ) ?>"
		],
		"whatsapp" : [
			"<?php _e( "Whatsapp" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the whatsapp number" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the whatsapp number" , $d ) ?> <?php _e( "as link" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the href parametr of the whatsapp number" , $d ) ?>"
		],
		"email" : [
			"<?php _e( "E-mail" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the e-mail" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the e-mail" , $d ) ?> <?php _e( "as link" , $d ) ?>"
		]
	}

</script>