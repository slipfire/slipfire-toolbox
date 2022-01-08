<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slipfire_admin = new SlipFire_Admin();

class SlipFire_Admin {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_filter( 'admin_body_class', array( 'slipfire_admin', 'admin_body_class' ) );
	}

	/**
	 * Add body classes to admin
	 */
	public static function admin_body_class( $classes ) {
		$current_user = wp_get_current_user();

		$classes .= 'current-user-' . $current_user->user_login;

		return $classes;
	}
}
