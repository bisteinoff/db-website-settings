<?php // THE SETTINGS PAGE

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$baseObj = new dbSettings();
	$d = $baseObj -> thisdir(); // domain for translate.wordpress.org

	// multisite compatibility
	if ( is_multisite() ) {

		$blog_id = get_current_blog_id();

		if ( $blog_id !== 1 ) {

			switch_to_blog( 1 );

			$url = esc_url ( add_query_arg (
				'page',
				$d,
				get_admin_url() . 'index.php'
			) );

			restore_current_blog();

			if ( wp_redirect( $url ) ) {
				exit;
			}
		}
	}

	// if there is not yet a phone/whatsapp/email
	$db_settings_phone[ 0 ] = '';
	$db_settings_whatsapp[ 0 ] = '';
	$db_settings_email[ 0 ] = '';

	// getting the values of the options
	$i = 0;
	while ( $option = esc_html ( sanitize_text_field ( get_option( 'db_settings_phone_' . $i ) ) ) )
	{
		$db_settings_phone[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = esc_html ( sanitize_text_field ( get_option( 'db_settings_whatsapp_' . $i ) ) ) )
	{
		$db_settings_whatsapp[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = esc_html ( sanitize_text_field ( get_option( 'db_settings_email_' . $i ) ) ) )
	{
		$db_settings_email[ $i ] = $option;
		$i++;
	}


	// form submit
	if ( isset ( $_POST['submit'] ) && 
	isset( $_POST[ $d . '_nonce' ] ) &&
	wp_verify_nonce( $_POST[ $d . '_nonce' ], $d ) )
	{

		if ( function_exists('current_user_can') &&
			 !current_user_can('manage_options') )
				die( _e( "Error: You do not have the permission to update the value" , $d ) );

		// Phone
		$i = 0;
		while ( $option = esc_html ( sanitize_text_field ( $_POST[ 'phone_' . $i ] ) ) )
		{
			$db_settings_phone[ $i ] = $option;
			update_option ( 'db_settings_phone_'. $i , $db_settings_phone[ $i ] );
			$i++;
		}

		// Whatsapp
		$i = 0;
		while ( $option = esc_html ( sanitize_text_field ( $_POST[ 'whatsapp_' . $i ] ) ) )
		{
			$db_settings_whatsapp[ $i ] = $option;
			update_option ( 'db_settings_whatsapp_'. $i , $db_settings_whatsapp[ $i ] );
			$i++;
		}

		// E-mail
		$i = 0;
		while ( $option = esc_html ( sanitize_email ( $_POST[ 'email_' . $i ] ) ) )
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

	<form name="db-settings" method="post" action="<?php echo esc_html( sanitize_text_field( $_SERVER['PHP_SELF'] ) ) ?>?page=<?php echo esc_html( sanitize_text_field( $d ) ) ?>&amp;updated=true">

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
				foreach ( $db_settings_phone as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
				?>
				<tr id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php _e( "Phone" , $d ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
					</th>
					<td rowspan="3">
						<input type="text" name="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>" id="db_settings_phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>"
								size="20" value="<?php echo esc_html( sanitize_text_field( $value ) ) ?>" />
					</td>
					<td>
						[db-phone<?php echo esc_html( sanitize_text_field( $ext ) ) ?>]
					</td>
					<td id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-phone" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-phone<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-phone" . $ext . "-link]"); ?>
					</td>
				</tr>
				<tr id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-phone<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-phone" . $ext . "-href]"); ?>
					</td>
				</tr>
			<?php
				}
				unset($value); // .Phones


				// Whatsapp Chats
				$i = -1;
				foreach ( $db_settings_whatsapp as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php _e( "Whatsapp" , $d ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
					</th>
					<td rowspan="3">
						<input type="text" name="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>" id="db_settings_whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>"
								size="20" value="<?php echo esc_html( sanitize_text_field( $value ) ) ?>" />
					</td>
					<td>
						[db-whatsapp<?php echo esc_html( sanitize_text_field( $ext ) ) ?>]
					</td>
					<td id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-whatsapp<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "-link]"); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-whatsapp<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-whatsapp" . $ext . "-href]"); ?>
					</td>
				</tr>
			<?php
				}
				unset($value); // .Whatsapp Chats


				// E-mails
				$i = -1;
				foreach ( $db_settings_email as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="2">
						<?php _e( "E-mail" , $d ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
					</th>
					<td rowspan="2">
						<input type="text" name="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>" id="db_settings_email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>"
								size="20" value="<?php echo esc_html( sanitize_text_field( $value ) ) ?>" />
					</td>
					<td>
						[db-email<?php echo esc_html( sanitize_text_field( $ext ) ) ?>]
					</td>
					<td id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-email" . $ext . "]"); ?>
					</td>
				</tr>
				<tr id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-email<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode("[db-email-link" . $ext . "]"); ?>
					</td>
				</tr>
			<?php
				}
				unset($value); // .E-mails
			?>
		</table>

		<div id="db_settings_add_buttons">
			<a id="db_settings_add_phone"><?php _e( "Add Phone" , $d ) ?></a>
			<a id="db_settings_add_whatsapp"><?php _e( "Add Whatsapp" , $d ) ?></a>
			<a id="db_settings_add_email"><?php _e( "Add E-mail" , $d ) ?></a>
		</div>

		<input type="hidden" name="action" value="update" />

		<?php $nonce = wp_create_nonce( $d ); ?>

		<input type="hidden" name="<?php echo esc_html( sanitize_text_field( $d ) ) ?>_nonce" value="<?php echo esc_html( sanitize_text_field( $nonce ) ) ?>" />

		<?php submit_button(); ?>

	</form>

</div>

<script type="text/javascript">
	let dbSettingsDescriptions = {
		"phone" : [
			"<?php _e( "Phone" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the phone number" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e("the phone number" , $d ) ?> <?php _e( "as link" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e("the href parameter of the phone number" , $d ) ?>"
		],
		"whatsapp" : [
			"<?php _e( "Whatsapp" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the whatsapp number" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the whatsapp number" , $d ) ?> <?php _e( "as link" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the href parameter of the whatsapp number" , $d ) ?>"
		],
		"email" : [
			"<?php _e( "E-mail" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the e-mail" , $d ) ?> <?php _e( "as text" , $d ) ?>",
			"<?php _e( "insert" , $d ) ?> <?php _e( "the e-mail" , $d ) ?> <?php _e( "as link" , $d ) ?>"
		]
	}

</script>