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
		add_action( 'init', array( 'slipfire_admin', 'init' ) );
		add_action( 'wp_dashboard_setup', array( 'slipfire_admin', 'remove_dashboard_widgets' ) );
		add_filter( 'admin_body_class', array( 'slipfire_admin', 'admin_body_class' ) );
		add_filter( 'admin_footer_text', array( 'slipfire_admin', 'footer_text' ) );
	}

	/**
	 * Run on init
	 *
	 * @var String
	 * @since 1.0.0
	 */
	public static function init() {
		self::jetpack();
	}

	/**
	 * Remove some core dashboard widgets
	 *
	 * @var String
	 * @since 4.9.19
	 */
	public static function remove_dashboard_widgets() {
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Activity
	}

	/**
	 * Add body classes to admin
	 */
	public static function admin_body_class( $classes ) {
		$current_user = wp_get_current_user();

		$classes .= 'current-user-' . $current_user->user_login;

		return $classes;
	}

	/**
	 * Update footer text in admin
	 *
	 * @var String
	 * @since 4.9.19
	 */
	public static function footer_text() {
		echo 'Built for you by <a href="https://slipfire.com">SlipFire</a>';
	}

	/**
	 * Jetpack customizations
	 *
	 * @var String
	 * @since 4.9.19
	 */
	public static function jetpack() {
		add_filter( 'jetpack_just_in_time_msgs', '__return_false' );
	}





}
