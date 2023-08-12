<?php
/*
Plugin Name: DB Website Settings
Plugin URI: https://github.com/bisteinoff/db-website-settings
Description: The plugin is used for the basic website settings
Version: 2.0.3
Author: Denis Bisteinov
Author URI: https://bisteinoff.com
Text Domain: db-website-settings
License: GPL2
*/

/*  Copyright 2023  Denis BISTEINOV  (email : bisteinoff@gmail.com)
 
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

		function thisdir()
		{
			return basename( __DIR__ );
		}

		function dbSettings()
		{

			add_option( 'db_settings_phone_0' );
			add_option( 'db_settings_whatsapp_0' );
			add_option( 'db_settings_email_0' );

			add_filter('widget_text','do_shortcode'); // enable shortcodes in widgets

			add_filter( 'plugin_action_links_' . $this -> thisdir() . '/index.php', array(&$this, 'db_settings_link') );
			add_action( 'admin_menu', array (&$this, 'admin') );

			add_action( 'admin_footer', function() {
							wp_enqueue_style( $this -> thisdir() . '-admin', plugin_dir_url( __FILE__ ) . 'css/admin.min.css' );
							wp_enqueue_script( $this -> thisdir() . '-admin', plugin_dir_url( __FILE__ ) . 'js/admin.min.js', null, false, true );
						},
						99
			);

			if (function_exists ('add_shortcode') )
			{
				// Phones
				$i = 0;
				while ( $option = sanitize_text_field ( get_option( 'db_settings_phone_' . $i ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';

					// Phone Plain Text
					add_shortcode('db-phone' . $ext, function() use ($option) {
						return $option;
					});

					// Phone As Link
					add_shortcode('db-phone' . $ext . '-link', function() use ($option) {
						$link = str_replace(
							array( " ", "(", ")" ),
							'',
							$option
						);
						return "<a href=\"tel:{$link}\">{$option}</a>"; 
					});

					$i++;
				}


				// Whatsapp Chats
				$i = 0;
				while ( $option = sanitize_text_field ( get_option( 'db_settings_whatsapp_' . $i ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';

					// Whatsapp Plain Text
					add_shortcode('db-whatsapp' . $ext, function() use ($option) {
						return $this -> whatsapp( $option , 'text' );
					});

					// Whatsapp As Link
					add_shortcode('db-whatsapp' . $ext . '-link', function() use ($option) {
						return $this -> whatsapp( $option , 'link' );
					});

					// Whatsapp href
					add_shortcode('db-whatsapp' . $ext . '-href', function() use ($option) {
						return $this -> whatsapp( $option , 'href' );
					});

					$i++;
				}


				// Whatsapp Chats
				$i = 0;
				while ( $option = sanitize_text_field ( get_option( 'db_settings_email_' . $i ) ) )
				{
					$ext = $i > 0 ? $i + 1 : '';

					// E-mail Plain Text
					add_shortcode('db-email' . $ext, function() use ($option) {
						return $option;
					});

					// E-mail As Link
					add_shortcode('db-email' . $ext . '-link', function() use ($option) {
						return "<a href=\"mailto:{$option}\">{$option}</a>"; 
					});

					$i++;
				}

			}

		}

		function whatsapp( $whatsapp , $type ) {

			switch ( $type ) {

				case "text" :
					$html = $whatsapp;
					break;

				case "href" :
					$href = str_replace(
						array( " ", "(", ")", "+" ),
						'',
						$whatsapp
					);
					$html = "https://wa.me/{$href}";
					break;

				case "link" :
					$link = $this -> whatsapp( $whatsapp , "href" );
					$html = "<a href=\"{$link}\">{$whatsapp}</a>";
					break;

			}

			return $html;

		}

		function admin() {

			if ( function_exists('add_menu_page') )
			{

				$svg = new DOMDocument();
				$svg -> load( plugin_dir_path( __FILE__ ) . 'img/icon.svg' );
				$icon = $svg -> saveHTML( $svg -> getElementsByTagName('svg')[0] );

				add_menu_page(
					__('DB Website Settings' , $this -> thisdir() ),
					__('Website Settings' , $this -> thisdir() ),
					'manage_options',
					$this -> thisdir(),
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
				$this -> thisdir(),
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