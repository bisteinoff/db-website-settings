<?php
/*
Plugin Name: DB Website Settings
Plugin URI: https://github.com/bisteinoff/db-website-settings
Description: The plugin is used for the basic website settings
Version: 1.0
Author: Denis Bisteinov
Author URI: https://bisteinoff.com
License: GPL2
*/

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : bisteinoff@gmail.com)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	class dbSettings

	{

		function dbSettings()
		{

			add_option( 'db_settings_phone' );
			add_option( 'db_settings_whatsapp' );
			add_option( 'db_settings_email' );

			add_filter('widget_text','do_shortcode'); // enable shortcodes in widgets

			add_filter( 'plugin_action_links_db-settings/index.php', array(&$this, 'db_settings_link') );
			add_action( 'admin_menu', array (&$this, 'admin') );

			add_action( 'admin_footer', function() {
							wp_enqueue_style( 'db-settings-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css' );
						},
						99
			);

			if (function_exists ('add_shortcode') )
			{

				// Phone Plain Text
				add_shortcode('db-phone', function() {
					return sanitize_text_field ( get_option('db_settings_phone') );
				});

				// Phone As Link
				add_shortcode('db-phone-link', function() {
					$phone = sanitize_text_field ( get_option('db_settings_phone') );
					$link = str_replace(
						array( " ", "(", ")" ),
						'',
						$phone
					);
					return "<a href=\"tel:{$link}\">{$phone}</a>"; 
				});

				// Whatsapp Plain Text
				add_shortcode('db-whatsapp', function() {
					return sanitize_text_field ( get_option('db_settings_whatsapp') );
				});

				// Whatsapp As Link
				add_shortcode('db-whatsapp-link', function() {
					$whatsapp = sanitize_text_field ( get_option('db_settings_whatsapp') );
					$link = str_replace(
						array( " ", "(", ")" ),
						'',
						$whatsapp
					);
					return "<a href=\"https://wa.me/:{$link}\">{$whatsapp}</a>"; 
				});

				// E-mail Plain Text
				add_shortcode('db-email', function() {
					return sanitize_email ( get_option('db_settings_email') );
				});

				// E-mail As Link
				add_shortcode('db-email-link', function() {
					$email = sanitize_email ( get_option('db_settings_email') );
					return "<a href=\"mailto:{$email}\">{$email}</a>"; 
				});

			}

		}

		function admin() {

			if ( function_exists('add_menu_page') )
			{

				$icon = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
<g>
	<g>
		<path d="M356,145.993c-5.52,0-10,4.48-10,10c0,5.52,4.48,10,10,10c5.52,0,10-4.48,10-10S361.52,145.993,356,145.993z"/>
	</g>
</g>
<g>
	<g>
		<path d="M156,345.993c-5.52,0-10,4.48-10,10c0,5.52,4.48,10,10,10s10-4.48,10-10C166,350.473,161.52,345.993,156,345.993z"/>
	</g>
</g>
<g>
	<g>
		<path d="M508.532,214.332c-0.811-4.815-4.98-8.34-9.862-8.34h-38.684c-5.079-20.77-13.275-40.497-24.447-58.838l29.082-29.081
			c3.453-3.454,3.907-8.897,1.073-12.875c-16.262-22.821-36.079-42.638-58.9-58.9c-3.977-2.833-9.419-2.381-12.875,1.073
			l-29.081,29.082C346.497,65.282,326.77,57.084,306,52.006V13.323c0-4.882-3.525-9.051-8.34-9.861
			c-27.347-4.604-55.973-4.604-83.319,0C209.525,4.272,206,8.441,206,13.323v38.683c-20.778,5.08-40.508,13.278-58.839,24.446
			l-29.08-29.081c-3.454-3.454-8.897-3.908-12.875-1.073c-22.821,16.262-42.638,36.079-58.9,58.9
			c-2.834,3.978-2.38,9.42,1.073,12.875l29.082,29.081c-11.172,18.341-19.368,38.068-24.447,58.838H13.33
			c-4.882,0-9.051,3.525-9.861,8.34C1.167,228.007,0,242.022,0,255.993c0,13.97,1.167,27.986,3.469,41.66
			c0.811,4.815,4.979,8.34,9.861,8.34h38.683c5.08,20.778,13.278,40.508,24.446,58.839l-29.081,29.08
			c-3.453,3.454-3.907,8.897-1.073,12.875c16.262,22.821,36.079,42.638,58.9,58.9c3.977,2.834,9.42,2.381,12.875-1.073
			l29.081-29.082C165.503,446.704,185.23,454.9,206,459.978v38.684c0,4.882,3.525,9.051,8.34,9.861
			c13.671,2.302,27.688,3.469,41.66,3.469s27.989-1.167,41.66-3.469c4.814-0.811,8.34-4.979,8.34-9.861V459.98
			c20.778-5.08,40.508-13.278,58.839-24.446l29.08,29.081c3.454,3.453,8.896,3.906,12.875,1.073
			c22.821-16.262,42.638-36.079,58.9-58.9c2.834-3.978,2.38-9.42-1.073-12.875L435.54,364.83
			c11.172-18.341,19.368-38.068,24.447-58.838h38.684c4.882,0,9.051-3.525,9.861-8.34c2.302-13.673,3.469-27.69,3.469-41.66
			C512.001,242.022,510.834,228.007,508.532,214.332z M490.054,285.993H451.98c-4.754,0-8.851,3.347-9.799,8.006
			c-4.855,23.854-14.18,46.298-27.715,66.708c-2.629,3.965-2.101,9.234,1.263,12.598l28.658,28.658
			c-12.254,15.943-26.475,30.163-42.417,42.417l-28.658-28.658c-3.364-3.365-8.634-3.893-12.6-1.261
			c-20.395,13.532-42.837,22.856-66.706,27.714c-4.659,0.948-8.006,5.045-8.006,9.799v38.074c-19.816,2.586-40.184,2.586-60,0
			v-38.074c0-4.754-3.347-8.851-8.006-9.799c-23.854-4.855-46.298-14.18-66.708-27.715c-3.966-2.63-9.234-2.102-12.598,1.263
			l-28.658,28.658c-15.943-12.254-30.163-26.475-42.417-42.417l28.658-28.658c3.365-3.364,3.892-8.634,1.261-12.6
			C84,340.311,74.676,317.868,69.818,294c-0.948-4.659-5.045-8.006-9.799-8.006H21.946c-1.293-9.911-1.946-19.967-1.946-30
			c0-10.033,0.653-20.089,1.946-30H60.02c4.754,0,8.851-3.347,9.799-8.006c4.855-23.854,14.18-46.298,27.715-66.708
			c2.629-3.965,2.101-9.234-1.263-12.598l-28.658-28.658c12.255-15.943,26.475-30.163,42.418-42.417l28.658,28.658
			c3.364,3.364,8.634,3.893,12.6,1.261c20.395-13.532,42.837-22.856,66.706-27.714c4.659-0.948,8.006-5.045,8.006-9.799V21.939
			c19.821-2.586,40.179-2.586,60,0v38.074c0,4.754,3.347,8.851,8.006,9.799c23.854,4.855,46.298,14.18,66.708,27.715
			c3.964,2.629,9.233,2.101,12.598-1.263l28.658-28.658c15.943,12.254,30.163,26.475,42.417,42.417l-28.658,28.658
			c-3.364,3.364-3.892,8.633-1.263,12.598c13.535,20.41,22.86,42.853,27.715,66.708c0.948,4.659,5.045,8.006,9.799,8.006h38.074
			c1.293,9.911,1.946,19.967,1.946,30C492.001,266.025,491.347,276.082,490.054,285.993z"/>
	</g>
</g>
<g>
	<g>
		<path d="M327.972,124.405c-21.947-12.047-46.835-18.414-71.972-18.414c-82.71,0-150,67.29-150,150
			c0,25.137,6.367,50.024,18.414,71.972c2.665,4.857,8.751,6.604,13.578,3.955c4.842-2.657,6.612-8.736,3.955-13.578
			C131.514,299.335,126,277.775,126,255.993c0-71.682,58.318-130,130-130c21.782,0,43.342,5.514,62.349,15.946
			c4.84,2.657,10.921,0.888,13.578-3.955C334.585,133.142,332.814,127.064,327.972,124.405z"/>
	</g>
</g>
<g>
	<g>
		<path d="M387.586,184.022c-2.657-4.843-8.736-6.613-13.578-3.955c-4.842,2.657-6.612,8.736-3.955,13.578
			C380.486,212.65,386,234.211,386,255.993c0,71.682-58.318,130-130,130c-21.782,0-43.342-5.514-62.349-15.946
			c-4.839-2.656-10.92-0.887-13.578,3.955c-2.658,4.841-0.887,10.92,3.955,13.578c21.947,12.047,46.835,18.414,71.972,18.414
			c82.71,0,150-67.29,150-150C406,230.856,399.633,205.97,387.586,184.022z"/>
	</g>
</g>
<g>
	<g>
		<path d="M256,145.993c-60.654,0-110,49.346-110,110s49.346,110,110,110s110-49.346,110-110S316.654,145.993,256,145.993z
			 M256,345.993c-49.626,0-90-40.374-90-90c0-49.626,40.374-90,90-90c49.626,0,90,40.374,90,90
			C346,305.618,305.626,345.993,256,345.993z"/>
	</g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>';

				add_menu_page(
					'DB Website Settings',
					'Website Settings',
					'manage_options',
					'db-settings',
					array (&$this, 'admin_page_callback'),
					'data:image/svg+xml;base64,' . base64_encode( $icon ),
					27
					);

			}

		}

		function admin_page_callback()
		{

			require_once('inc/admin.php');

		}

		function db_settings_link( $links )
		{

			$url = esc_url ( add_query_arg (
				'page',
				'db-settings',
				get_admin_url() . 'index.php'
			) );

			$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';

			array_push(
				$links,
				$settings_link
			);

			return $links;

		}

	}

	$db_settings = new dbSettings();