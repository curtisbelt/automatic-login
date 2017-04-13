<?php

/**
 * Plugin Name: Automatic Login
 * Description: Stay logged in forever!
 * Version: 1.0.1
 * Author: Curtis Belt
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Automatic_Login' ) ) {

	class Automatic_Login {

		public static function automatically_login() {

			if ( ! is_admin() || is_user_logged_in() ) {
				return;	
			}

			$user = wp_signon( array(
				'user_login' => 'admin',
				'user_password' => 'admin',
				'remember' => true,
			) );

			if ( is_wp_error( $user ) ) {
				echo $user->get_error_message();
				die();
			}

			wp_redirect( esc_url( get_admin_url() ) );
			exit;
		}

		public static function set_cookie_expiration( $expire ) {
			return YEAR_IN_SECONDS;
		}

		public function run() {
			add_action( 'init', array( 'Automatic_Login', 'automatically_login' ) );
			add_filter( 'auth_cookie_expiration', array( 'Automatic_Login', 'set_cookie_expiration' ) );
		}

	}
	
	function Automatic_Login() {
		$plugin = new Automatic_Login();
		$plugin->run();
	}

	Automatic_Login();

}
