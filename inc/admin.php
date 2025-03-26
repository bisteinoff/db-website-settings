<?php // THE SETTINGS PAGE

	if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$baseObj = new DB_SETTINGS_WebsiteSettings();
	$d = $baseObj->thisdir();

	// Multisite compatibility
	if ( is_multisite() ) :
		$blog_id = get_current_blog_id();
		if ( $blog_id !== 1 ) :
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
		endif;
	endif;

	// List of contact types
	$contact_types = ['phone', 'whatsapp', 'telegram', 'email', 'address'];
	$prefix = 'db_settings_';

	// Initialize settings arrays
	$db_settings = [];
	foreach ($contact_types as $type) :
		$db_settings[$type][0] = '';
	endforeach;

	// Retrieve stored options
	foreach ($contact_types as $type) :
		$i = 0;
		while (true) :
			$option_key = $prefix . $type . '_' . $i;
			$option_value = get_option($option_key);
	
			if ($option_value === false) break; // Stop when no more options exist
	
			$db_settings[$type][$i] = esc_html(sanitize_text_field($option_value));
			$i++;
		endwhile;
	endforeach;


	// Form submission handling
	if ( isset( $_POST[ 'submit' ] ) && 
		 isset( $_POST[ $d . '_nonce' ] ) &&
		 wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $d . '_nonce' ] ) ), sanitize_text_field( $d ) ) ) :

		if ( function_exists( 'current_user_can' ) &&
			 !current_user_can( 'manage_options' ) )
				die( esc_html_e( 'Error: You do not have the permission to update the value', 'db-website-settings' ) );

		foreach ($contact_types as $type) :
			$i = 0;
			while (isset($_POST["{$type}_$i"])) :
				$sanitized_option = ($type === 'email') 
					? sanitize_email(wp_unslash($_POST["{$type}_$i"])) 
					: sanitize_text_field(wp_unslash($_POST["{$type}_$i"]));
				$db_settings[$type][$i] = esc_html($sanitized_option);
				update_option("db_settings_{$type}_$i", $db_settings[$type][$i]);
				$i++;
			endwhile;
		endforeach;

	endif;

?>
<div class='wrap db-settings-admin'>

	<?php if ( isset( $_POST[ 'submit' ] ) ) : ?>

	<script>
        (function() {
            setTimeout(function() {
                location.reload();
            }, 500); // Delay to ensure the save process completes.
        })();
    </script>

	<?php else: ?>

	<h1><?php esc_html_e( 'Contact Settings' , 'db-website-settings' ) ?></h1>

	<div class="db-settings-description">
		<p><?php esc_html_e( 'The plugin is used for the basic website settings' , 'db-website-settings' ) ?></p>
	</div>

	<h2><?php esc_html_e( 'Settings' , 'db-website-settings' ) ?></h2>

	<form name="db-settings" method="post" action="?page=<?php echo esc_html( sanitize_text_field( $d ) ) ?>&amp;updated=true">

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
				// Function to generate table rows for different settings
				function db_settings_render_fields( $type, $data, $label ) {
					$i = -1;
					foreach ( $data as $value ) :
						$i++;
						$ext = $i > 0 ? $i + 1 : '';
						?>
						<tr id="<?php echo esc_attr( "{$type}_{$i}_1" ); ?>" valign="top">
							<th scope="row" rowspan="3">
								<?php echo esc_html( $label ); ?> <?php echo esc_html( $ext ); ?>
							</th>
							<td rowspan="3">
								<input type="text" name="<?php echo esc_attr( "{$type}_{$i}" ); ?>" id="db_settings_<?php echo esc_attr( "{$type}_{$i}" ); ?>"
									size="20" value="<?php echo esc_html( sanitize_text_field( $value ) ); ?>" />
							</td>
							<td>[db-<?php echo esc_html( "{$type}{$ext}" ); ?>]</td>
							<td id="<?php echo esc_attr( "{$type}_{$i}_1_description" ); ?>"></td>
							<td><?php echo do_shortcode( "[db-{$type}{$ext}]" ); ?></td>
						</tr>
						<tr id="<?php echo esc_attr( "{$type}_{$i}_2" ); ?>" valign="top">
							<td>[db-<?php echo esc_html( "{$type}{$ext}" ); ?>-link]</td>
							<td id="<?php echo esc_attr( "{$type}_{$i}_2_description" ); ?>"></td>
							<td><?php echo do_shortcode( "[db-{$type}{$ext}-link]" ); ?></td>
						</tr>
						<tr id="<?php echo esc_attr( "{$type}_{$i}_3" ); ?>" valign="top">
							<td>[db-<?php echo esc_html( "{$type}{$ext}" ); ?>-href]</td>
							<td id="<?php echo esc_attr( "{$type}_{$i}_3_description" ); ?>"></td>
							<td><?php echo do_shortcode( "[db-{$type}{$ext}-href]" ); ?></td>
						</tr>
						<?php
					endforeach;
				}

				// Render settings for different types
				db_settings_render_fields( 'phone', $db_settings['phone'], esc_html__( 'Phone', 'db-website-settings' ) );
				db_settings_render_fields( 'whatsapp', $db_settings['whatsapp'], esc_html__( 'WhatsApp', 'db-website-settings' ) );
				db_settings_render_fields( 'telegram', $db_settings['telegram'], esc_html__( 'Telegram', 'db-website-settings' ) );
				db_settings_render_fields( 'email', $db_settings['email'], esc_html__( 'E-mail', 'db-website-settings' ) );
				db_settings_render_fields( 'address', $db_settings['address'], esc_html__( 'Address', 'db-website-settings' ) );
			?>
		</table>

		<div id="db_settings_add_buttons">
			<a id="db_settings_add_phone"><?php esc_html_e( 'Add Phone' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_whatsapp"><?php esc_html_e( 'Add Whatsapp' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_telegram"><?php esc_html_e( 'Add Telegram' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_email"><?php esc_html_e( 'Add E-mail' , 'db-website-settings' ) ?></a>
			<a id="db_settings_add_address"><?php esc_html_e( 'Add Address' , 'db-website-settings' ) ?></a>
		</div>

		<input type="hidden" name="action" value="update" />
		<?php $nonce = wp_create_nonce( $d ); ?>
		<input type="hidden" name="<?php echo esc_html( sanitize_text_field( $d ) ) ?>_nonce" value="<?php echo esc_html( sanitize_text_field( $nonce ) ) ?>" />

		<?php submit_button(); ?>

	</form>

	<?php endif; ?>

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
		],
		"address" : [
			"<?php esc_html_e( 'Address', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the address', 'db-website-settings' ) ?> <?php esc_html_e( 'as text', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the address', 'db-website-settings' ) ?> <?php esc_html_e( 'as link to Google Maps search', 'db-website-settings' ) ?>",
			"<?php esc_html_e( 'insert', 'db-website-settings' ) ?> <?php esc_html_e( 'the href parameter of Google Maps search link of the address', 'db-website-settings' ) ?>"
		],
	}

</script>
<?php