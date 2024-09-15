<?php // THE SETTINGS PAGE

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$baseObj = new DB_SETTINGS_WebsiteSettings();
	$d = $baseObj->thisdir();

	// multisite compatibility
	if ( is_multisite() ) {

		$blog_id = get_current_blog_id();

		if ( $blog_id !== 1 ) {

			switch_to_blog( 1 );

			$url = esc_url( add_query_arg(
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

	// if there is not yet a phone/whatsapp/telegram/email
	$db_settings_phone[ 0 ] = '';
	$db_settings_whatsapp[ 0 ] = '';
	$db_settings_telegram[ 0 ] = '';
	$db_settings_email[ 0 ] = '';

	// getting the values of the options
	$i = 0;
	while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_phone_' . $i ) ) ) )
	{
		$db_settings_phone[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_whatsapp_' . $i ) ) ) )
	{
		$db_settings_whatsapp[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_telegram_' . $i ) ) ) )
	{
		$db_settings_telegram[ $i ] = $option;
		$i++;
	}

	$i = 0;
	while ( $option = esc_html( sanitize_email( get_option( 'db_settings_email_' . $i ) ) ) )
	{
		$db_settings_email[ $i ] = $option;
		$i++;
	}


	// form submit
	if ( isset ( $_POST[ 'submit' ] ) && 
		 isset( $_POST[ $d . '_nonce' ] ) &&
		 wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $d . '_nonce' ] ) ), sanitize_text_field( $d ) ) )
	{

		if ( function_exists( 'current_user_can' ) &&
			 !current_user_can( 'manage_options' ) )
				die( esc_html_e( 'Error: You do not have the permission to update the value', 'db-website-settings' ) );

		// Phone
		$i = 0;
		while ( $option = esc_html( sanitize_text_field( $_POST[ 'phone_' . $i ] ) ) )
		{
			$db_settings_phone[ $i ] = $option;
			update_option ( 'db_settings_phone_'. $i, $db_settings_phone[ $i ] );
			$i++;
		}

		// Whatsapp
		$i = 0;
		while ( $option = esc_html( sanitize_text_field( $_POST[ 'whatsapp_' . $i ] ) ) )
		{
			$db_settings_whatsapp[ $i ] = $option;
			update_option ( 'db_settings_whatsapp_'. $i, $db_settings_whatsapp[ $i ] );
			$i++;
		}

		// Telegram
		$i = 0;
		while ( $option = esc_html( sanitize_text_field( $_POST[ 'telegram_' . $i ] ) ) )
		{
			$db_settings_telegram[ $i ] = $option;
			update_option ( 'db_settings_telegram_'. $i, $db_settings_telegram[ $i ] );
			$i++;
		}

		// E-mail
		$i = 0;
		while ( $option = esc_html( sanitize_email ( $_POST[ 'email_' . $i ] ) ) )
		{
			$db_settings_email[ $i ] = $option;
			update_option ( 'db_settings_email_'. $i, $db_settings_email[ $i ] );
			$i++;
		}

	}

?>
<div class='wrap db-settings-admin'>

	<h1><?php esc_html_e( 'Contact Settings' , 'db-website-settings' ) ?></h1>

	<div class="db-settings-description">
		<p><?php esc_html_e( 'The plugin is used for the basic website settings' , 'db-website-settings' ) ?></p>
	</div>

	<h2><?php esc_html_e( 'Settings' , 'db-website-settings' ) ?></h2>

	<form name="db-settings" method="post" action="<?php echo esc_html( sanitize_text_field( $_SERVER['PHP_SELF'] ) ) ?>?page=<?php echo esc_html( sanitize_text_field( $d ) ) ?>&amp;updated=true">

		<table id="db-settings-table" class="form-table db-settings-table" width="100%">
			<tr valign="top">
				<th scope="col" width="20%">
					<?php esc_html_e( 'Parameter' , 'db-website-settings' ) ?>
				</th>
				<th scope="col" width="20%">
					<?php esc_html_e( 'Value' , 'db-website-settings' ) ?>
				</th>
				<th scope="col" width="20%">
					<?php esc_html_e( 'Shortcode' , 'db-website-settings' ) ?>
				</th>
				<th scope="col" width="20%">
					<?php esc_html_e( 'Shortcode' , 'db-website-settings' ) ?> <?php esc_html_e( 'description' , 'db-website-settings' ) ?>
				</th>
				<th scope="col" width="20%">
					<?php esc_html_e( 'Example' , 'db-website-settings' ) ?>
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
						<?php esc_html_e( 'Phone' , 'db-website-settings' ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
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
						<?php echo do_shortcode( "[db-phone" . esc_html( sanitize_text_field( $ext ) ) . "]" ); ?>
					</td>
				</tr>
				<tr id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-phone<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-phone" . esc_html( sanitize_text_field( $ext ) ) . "-link]" ); ?>
					</td>
				</tr>
				<tr id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-phone<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="phone_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-phone" . esc_html( sanitize_text_field( $ext ) ) . "-href]" ); ?>
					</td>
				</tr>
			<?php
				}
				unset( $value ); // .Phones


				// Whatsapp Chats
				$i = -1;
				foreach ( $db_settings_whatsapp as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php esc_html_e( 'Whatsapp' , 'db-website-settings' ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
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
						<?php echo do_shortcode( "[db-whatsapp" . esc_html( sanitize_text_field( $ext ) ) . "]" ); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-whatsapp<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-whatsapp" . esc_html( sanitize_text_field( $ext ) ) . "-link]" ); ?>
					</td>
				</tr>
				<tr id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-whatsapp<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="whatsapp_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-whatsapp" . esc_html( sanitize_text_field( $ext ) ) . "-href]" ); ?>
					</td>
				</tr>
			<?php
				}
				unset( $value ); // .Whatsapp Chats


				// Telegram Chats
				$i = -1;
				foreach ( $db_settings_telegram as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php esc_html_e( 'Telegram' , 'db-website-settings' ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
					</th>
					<td rowspan="3">
						<input type="text" name="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>" id="db_settings_telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>"
								size="20" value="<?php echo esc_html( sanitize_text_field( $value ) ) ?>" />
					</td>
					<td>
						[db-telegram<?php echo esc_html( sanitize_text_field( $ext ) ) ?>]
					</td>
					<td id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-telegram" . esc_html( sanitize_text_field( $ext ) ) . "]" ); ?>
					</td>
				</tr>
				<tr id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-telegram<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-telegram" . esc_html( sanitize_text_field( $ext ) ) . "-link]" ); ?>
					</td>
				</tr>
				<tr id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-telegram<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="telegram_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-telegram" . esc_html( sanitize_text_field( $ext ) ) . "-href]" ); ?>
					</td>
				</tr>
			<?php
				}
				unset( $value ); // .Telegram Chats


				// E-mails
				$i = -1;
				foreach ( $db_settings_email as $value ) {
					$i++;
					$ext = $i > 0 ? $i + 1 : '';
			?>
				<tr id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1" valign="top">
					<th scope="row" rowspan="3">
						<?php esc_html_e( 'E-mail' , 'db-website-settings' ) ?> <?php echo esc_html( sanitize_text_field( $ext ) ) ?>
					</th>
					<td rowspan="3">
						<input type="text" name="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>" id="db_settings_email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>"
								size="20" value="<?php echo esc_html( sanitize_email( $value ) ) ?>" />
					</td>
					<td>
						[db-email<?php echo esc_html( sanitize_text_field( $ext ) ) ?>]
					</td>
					<td id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_1_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-email" . esc_html( sanitize_text_field( $ext ) ) . "]" ); ?>
					</td>
				</tr>
				<tr id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2" valign="top">
					<td>
						[db-email<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-link]
					</td>
					<td id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_2_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-email" . esc_html( sanitize_text_field( $ext ) ) . "-link]" ); ?>
					</td>
				</tr>
				<tr id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3" valign="top">
					<td>
						[db-email<?php echo esc_html( sanitize_text_field( $ext ) ) ?>-href]
					</td>
					<td id="email_<?php echo esc_html( sanitize_text_field( $i ) ) ?>_3_description">
					</td>
					<td>
						<?php echo do_shortcode( "[db-email" . esc_html( sanitize_text_field( $ext ) ) . "-href]" ); ?>
					</td>
				</tr>
			<?php
				}
				unset( $value ); // .E-mails
			?>
		</table>

		<div id="db_settings_add_buttons">
			<a id="db_settings_add_phone"><?php esc_html_e( 'Add Phone' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_whatsapp"><?php esc_html_e( 'Add Whatsapp' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_telegram"><?php esc_html_e( 'Add Telegram' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_email"><?php esc_html_e( 'Add E-mail' , 'db-website-settings' ) ?></a>
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
			"<?php esc_html_e( 'Phone', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the phone number', 'db-website-settings' ) ?> <?php esc_html_e( 'as text', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the phone number', 'db-website-settings' ) ?> <?php esc_html_e( 'as link', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the href parameter of the phone number', 'db-website-settings' ) ?> (tel:)"
		],
		"whatsapp" : [
			"<?php esc_html_e( 'Whatsapp', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the whatsapp number', 'db-website-settings' ) ?> <?php esc_html_e( 'as text', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the whatsapp number', 'db-website-settings' ) ?> <?php esc_html_e( 'as link', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the href parameter of the whatsapp number', 'db-website-settings' ) ?>"
		],
		"telegram" : [
			"<?php esc_html_e( 'Telegram' , 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert' , 'db-website-settings' ) ?> <?php esc_html_e( 'the telegram number' , 'db-website-settings' ) ?> <?php esc_html_e( 'as text' , 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert' , 'db-website-settings' ) ?> <?php esc_html_e( 'the telegram number' , 'db-website-settings' ) ?> <?php esc_html_e( 'as link' , 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert' , 'db-website-settings' ) ?> <?php esc_html_e( 'the href parameter of the telegram number' , 'db-website-settings' ) ?>"
		],
		"email" : [
			"<?php esc_html_e( 'E-mail', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the e-mail', 'db-website-settings' ) ?> <?php esc_html_e( 'as text', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the e-mail', 'db-website-settings' ) ?> <?php esc_html_e( 'as link', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the e-mail', 'db-website-settings' ) ?> <?php esc_html_e( 'the href parameter of email', 'db-website-settings' ) ?> (mailto:)"
		]
	}

</script>