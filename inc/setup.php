<?php

function cookster_fs() {

	global $cookster_fs;

	if ( ! isset( $cookster_fs ) ) {

		require_once dirname( __FILE__ ) . '/freemius/start.php';

		$cookster_fs = fs_dynamic_init( array(
			'id'                  => '1901',
			'slug'                => 'easy-wp-cookie-popup',
			'type'                => 'plugin',
			'public_key'          => 'pk_7a9211571eb810bc38864bbc7f2ef',
			'is_premium'          => true,
			'has_premium_version' => true,
			'has_addons'          => false,
			'has_paid_plans'      => true,
			'menu'                => array(
				'slug'    => 'cookster',
				'support' => false,
				'parent'  => array(
					'slug' => 'settings',
				),
			),

			'secret_key' => 'sk_MakTp#yifHURIOIGiWV#:Ah5*O@T7',

		) );
	}

	return $cookster_fs;
}

quickster_fs();
do_action( 'quickster_fs_loaded' );


function cookster_cleanup() {

	$options = array(
		'quickster_shortcode',
		'quickster_table_heads',
		'quickster_additional_settings',
		'quickster_documentation'
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


quickster_fs()->add_action( 'after_uninstall', 'cookster_cleanup' );