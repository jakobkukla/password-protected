<?php

/**
 * @package     Password Protected
 * @subpackage  Admin Caching
 */

class Password_Protected_Admin_Caching {

	/**
	 * Constructor
	 *
	 * @internal  Private. This class should only be instantiated once by the plugin.
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'cache_settings_info' ) );

	}

	/**
	 * Cache Settings Info
	 *
	 * Displays information on the settings page for helping
	 * to configure Password Protected to work with caching setups.
	 */
	public function cache_settings_info() {

		// Caching Section
		add_settings_section(
			'password_protected_compat_caching',
			__( 'Caching', 'password-protected' ),
			array( $this, 'section_caching' ),
			'password-protected-compat'
		);

		// Cookies
		add_settings_field(
			'password_protected_compat_caching_cookie',
			__( 'Cookies', 'password-protected' ),
			array( $this, 'field_cookies' ),
			'password-protected-compat',
			'password_protected_compat_caching'
		);

		// WP Engine Hosting
		if ( ( function_exists( 'is_wpe' ) && is_wpe() ) || ( function_exists( 'is_wpe_snapshot' ) && is_wpe_snapshot() ) ) {

			add_settings_field(
				'password_protected_compat_caching_wp_engine',
				__( 'WP Engine Hosting', 'password-protected' ),
				array( $this, 'field_wp_engine' ),
				'password-protected-compat',
				'password_protected_compat_caching'
			);

		}

		// W3 Total Cache
		if ( defined( 'W3TC' ) && W3TC ) {

			add_settings_field(
				'password_protected_compat_caching_w3_total_cache',
				__( 'W3 Total Cache', 'password-protected' ),
				array( $this, 'field_w3_total_cache' ),
				'password-protected-compat',
				'password_protected_compat_caching'
			);

		}

	}

	/**
	 * Caching Section
	 */
	public function section_caching() {

		global $Password_Protected;

		echo '<p>' . __( 'Password Protected does not always work well with sites that use caching.', 'password-protected' ) . '<br />
			' . __( 'If your site uses a caching plugin or yur web hosting uses server-side caching, you may need to configure your setup to disable caching for the Password Protected cookie:', 'password-protected' ) . '</p>';

	}

	/**
	 * Password Protection Status Field
	 */
	public function field_cookies() {

		global $Password_Protected;

		echo '<p><input type="text" value="' . esc_attr( $Password_Protected->cookie_name() ) . '" class="regular-text code" /></p>';

	}

	/**
	 * WP Engine Hosting
	 */
	public function field_wp_engine() {

		global $Password_Protected;

		echo '<p>' . __( 'We have detected your site may be running on WP Engine hosting.', 'password-protected' ) . '<br />
			' . __( 'In order for Password Protected to work with WP Engine\'s caching configuration you must ask them to disable caching for the Password Protected cookie.', 'password-protected' ) . '</p>';

	}

	/**
	 * W3 Total Cache Compatibility
	 */
	public function field_w3_total_cache() {

		global $Password_Protected;

		echo '<p>' . __( 'It looks like you may be using the W3 Total Cache plugin?', 'password-protected' ) . '<br />
			' . __( 'In order for Password Protected to work with W3 Total Cache you must disable caching when the Password Protected cookie is set.', 'password-protected' ) . ' 
			' . sprintf( __( 'You can adjust the cookie settings for W3 Total Cache under <a href="%s">Performance > Page Cache > Advanced > Rejected Cookies</a>.', 'password-protected' ), admin_url( '/admin.php?page=w3tc_pgcache#advanced' ) ) . '</p>';

	}

}
