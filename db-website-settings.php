<?php
/*
Plugin Name: DB Website Settings
Plugin URI: https://github.com/bisteinoff/db-website-settings
Description: The plugin is used for the basic website settings
Version: 2.8.1
Author: Denis Bisteinov
Author URI: https://bisteinoff.com
Text Domain: db-website-settings
License: GPL2
*/

/*  Copyright 2024  Denis BISTEINOV  (email : bisteinoff@gmail.com)
 
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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'DB_SETTINGS_WebsiteSettings' ) ) :

	define( 'DB_WEBSITE_SETTINGS_PLUGIN_VERSION', '2.8.1' );

	class DB_SETTINGS_WebsiteSettings

	{

		function thisdir()
		{
			return basename( __DIR__ );
		}

		function __construct()
		{

			add_option( 'db_settings_phone_0'    );
			add_option( 'db_settings_whatsapp_0' );
			add_option( 'db_settings_telegram_0' );
			add_option( 'db_settings_email_0'    );

			add_filter( 'widget_text', 'do_shortcode' ); // enable shortcodes in widgets

			add_filter( 'plugin_action_links_' . $this->thisdir() . '/db-website-settings.php', array( &$this, 'db_settings_link' ) );
			add_action( 'admin_menu', array( &$this, 'admin' ) );

			add_action( 'admin_footer', function() {
							wp_enqueue_style( $this->thisdir() . '-admin', plugin_dir_url( __FILE__ ) . 'css/admin.min.css', [], DB_WEBSITE_SETTINGS_PLUGIN_VERSION, 'all' );
							wp_enqueue_script( $this->thisdir() . '-admin', plugin_dir_url( __FILE__ ) . 'js/admin.min.js', null, DB_WEBSITE_SETTINGS_PLUGIN_VERSION, true );
						},
						99
			);

			add_action( 'wp_enqueue_scripts', function() {
					wp_register_style( $this->thisdir(), plugin_dir_url( __FILE__ ) . 'css/style.min.css', [], DB_WEBSITE_SETTINGS_PLUGIN_VERSION, 'all' );
					wp_enqueue_style( $this->thisdir() );
				},
				99
			);

			if ( function_exists( 'add_shortcode' ) )
			{

				if ( is_multisite() ) switch_to_blog( 1 ); // multisite compatibility

				// Phones
				$i = 0;
				$db_remove_chars = array(
					" ",
					"(",
					")",
					"-"
				);
				while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_phone_' . $i ) ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';
					$classes = "db-wcs-contact db-wcs-contact-phone db-wcs-contact-phone-{$i}";

					// Phone Plain Text
					add_shortcode( 'db-phone' . esc_html( sanitize_text_field( $ext ) ), function() use ( $option, $classes ) {
						return wp_kses_post( "<span class=\"{$classes}\">{$option}</span>" );
					});

					// Phone As Link
					add_shortcode( 'db-phone' . esc_html( sanitize_text_field( $ext ) ) . '-link', function() use ( $option, $classes, $db_remove_chars, $i ) {
						$link = str_replace(
							$db_remove_chars,
							'',
							$option
						);
						return wp_kses_post( "<a href=\"tel:{$link}\" class=\"{$classes}\">{$option}</a>" );
					});

					// Phone href
					add_shortcode( 'db-phone' . esc_html( sanitize_text_field( $ext ) ) . '-href', function() use ( $option, $db_remove_chars ) {
						$link = str_replace(
							$db_remove_chars,
							'',
							$option
						);
						return wp_kses_post( $link );
					});

					$i++;
				}


				// Whatsapp Chats
				$i = 0;
				while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_whatsapp_' . $i ) ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';

					// Whatsapp Plain Text
					add_shortcode( 'db-whatsapp' . esc_html( sanitize_text_field( $ext ) ), function() use ( $option, $i ) {
						return wp_kses_post( $this->whatsapp( $option , 'text', $i ) );
					});

					// Whatsapp As Link
					add_shortcode( 'db-whatsapp' . esc_html( sanitize_text_field( $ext ) ) . '-link', function() use ( $option, $i ) {
						return wp_kses_post( $this->whatsapp( $option , 'link', $i ) );
					});

					// Whatsapp href
					add_shortcode( 'db-whatsapp' . esc_html( sanitize_text_field( $ext ) ) . '-href', function() use ( $option, $i ) {
						return wp_kses_post( $this->whatsapp( $option , 'href', $i ) );
					});

					$i++;
				}


				// Telegram Chats
				$i = 0;
				while ( $option = esc_html( sanitize_text_field( get_option( 'db_settings_telegram_' . $i ) ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';

					// Telegram Plain Text
					add_shortcode( 'db-telegram' . esc_html( sanitize_text_field( $ext ) ), function() use ( $option, $i ) {
						return wp_kses_post( $this->telegram( $option , 'text', $i ) );
					});

					// Telegram As Link
					add_shortcode( 'db-telegram' . esc_html( sanitize_text_field( $ext ) ) . '-link', function() use ( $option, $i ) {
						return wp_kses_post( $this->telegram( $option , 'link', $i ) );
					});

					// Telegram href
					add_shortcode( 'db-telegram' . esc_html( sanitize_text_field( $ext ) ) . '-href', function() use ( $option, $i ) {
						return wp_kses_post( $this->telegram( $option , 'href', $i ) );
					});

					$i++;
				}


				// E-mail
				$i = 0;
				while ( $option = esc_html( sanitize_email( get_option( 'db_settings_email_' . $i ) ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';
					$classes = "db-wcs-contact db-wcs-contact-email db-wcs-contact-email-{$i}";

					// E-mail Plain Text
					add_shortcode( 'db-email' . esc_html( sanitize_text_field( $ext ) ), function() use ( $option, $classes ) {
						return wp_kses_post( "<span class=\"{$classes}\">{$option}</span>" );
					});

					// E-mail As Link
					add_shortcode( 'db-email' . esc_html( sanitize_text_field( $ext ) ) . '-link', function() use ( $option, $classes, $i ) {
						return wp_kses_post( "<a href=\"mailto:{$option}\" class=\"{$classes}\">{$option}</a>" );
					});

					// E-mail href
					add_shortcode( 'db-email' . esc_html( sanitize_text_field( $ext ) ) . '-href', function() use ( $option, $i ) {
						return wp_kses_post( $option );
					});

					$i++;
				}

				if ( is_multisite() ) restore_current_blog(); // multisite compatibility

			}

		}

		function whatsapp( $whatsapp, $type, $i ) {

			$classes = "db-wcs-contact db-wcs-contact-whatsapp db-wcs-contact-whatsapp-{$i}";

			switch ( $type ) {

				case "text" :
					$html = "<span class=\"{$classes}\">{$whatsapp}</span>";
					break;

				case "href" :
					$href = str_replace(
						array( " ", "(", ")", "-", "+" ),
						'',
						$whatsapp
					);
					$html = "https://wa.me/{$href}";
					break;

				case "link" :
					$link = $this->whatsapp( $whatsapp, "href", $i );
					$html = "<a href=\"{$link}\" class=\"{$classes}\">{$whatsapp}</a>";
					break;

			}

			return wp_kses_post( $html );

		}

		function telegram( $telegram, $type, $i ) {

			$classes = "db-wcs-contact db-wcs-contact-telegram db-wcs-contact-telegram-{$i}";

			switch ( $type ) {

				case "text" :
					$html = "<span class=\"{$classes}\">@{$telegram}</span>";
					break;

				case "href" :
					$html = "tg://resolve?domain={$telegram}";
					break;

				case "link" :
					$link = $this->telegram( $telegram, "href", $i );
					$html = "<a href=\"{$link}\" class=\"{$classes}\">@{$telegram}</a>";
					break;

			}

			return wp_kses_post( $html );

		}

		function admin() {

			if ( function_exists( 'add_menu_page' ) )
			{

				if ( class_exists( 'DOMDocument' ) ) :

					$svg = new DOMDocument();
					$svg->load( plugin_dir_path( __FILE__ ) . 'img/icon.svg' );
					$icon = $svg->saveHTML( $svg->getElementsByTagName( 'svg' )[ 0 ] );
					$icon = 'data:image/svg+xml;base64,' . base64_encode( $icon );

				else:

					$icon = 'dashicons-welcome-widgets-menus';

				endif;

				add_menu_page(
					esc_html__( 'DB Contact Settings', 'db-website-settings' ),
					esc_html__( 'Contact Settings', 'db-website-settings' ),
					'manage_options',
					$this->thisdir(),
					array( &$this, 'admin_page_callback' ),
					$icon,
					27
					);

			}

		}

		function admin_page_callback()
		{

			require_once( 'inc/admin.php' );

		}

		function db_settings_link( $links )
		{

			$url = esc_url( add_query_arg(
				'page',
				$this->thisdir(),
				get_admin_url() . 'admin.php'
			) );

			$settings_link = "<a href='$url'>" . esc_html__( 'Settings' ) . '</a>';

			array_push(
				$links,
				$settings_link
			);

			return $links;

		}

	}

	$db_settings = new DB_SETTINGS_WebsiteSettings();

endif;