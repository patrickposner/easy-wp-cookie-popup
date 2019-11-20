<?php

if ( ! function_exists( 'cookii_fs' ) ) {
	// Create a helper function for easy SDK access.
	function cookii_fs() {
		global $cookii_fs;

		if ( ! isset( $cookii_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$cookii_fs = fs_dynamic_init( array(
				'id'                 => '2333',
				'slug'               => 'easy-wp-cookie-popup',
				'type'               => 'plugin',
				'public_key'         => 'pk_4c3f34537d04709eff0922c07d81e',
				'is_premium'         => false,
				'has_addons'         => false,
				'has_paid_plans'     => false,
				'menu'               => array(
					'slug'           => 'cookii_settings',
					'contact'        => false,
					'support'        => false,
					'parent'         => array(
						'slug' => 'options-general.php',
					),
				),
			) );
		}

		return $cookii_fs;
	}

	// Init Freemius.
	cookii_fs();
	// Signal that SDK was initiated.
	do_action( 'cookii_fs_loaded' );
}

/**
 * Uninstall function to clear options
 *
 * @return void
 */
function cookii_cleanup() {

	$options = array(
		'cookimize_options',
		'cookimize_style',
		'cookimize_gdpr',
	);

	if ( is_multisite() ) {
		foreach ( $options as $option ) {
			delete_site_option( $option );
		}
	} else {
		foreach ( $options as $option ) {
			delete_option( $option );
		}
	}
}

cookii_fs()->add_action( 'after_uninstall', 'cookii_cleanup' );
