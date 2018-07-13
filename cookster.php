<?php
/*
Plugin Name: Cookster
Text Domain: cookster
Domain Path: /languages
Description: A simple plugin for integrating a GDPR conform cookie solution
Author: patrickposner
Version: 1.0.2
*/

define( 'COOKSTER_ABSPATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
define( 'COOKSTER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( "COOKSTER_PATH", untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( "COOKSTER_URL", untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/* load setup */
// require_once( COOKSTER_ABSPATH . 'inc' . DIRECTORY_SEPARATOR . 'setup.php' );

/* localize */
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'easy-wp-cookie-popup', false, $textdomain_dir );


if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/* intialize classes */

cookster\CS_Activation::init();
cookster\CS_Admin::get_instance();
cookster\CS_Public::get_instance();
new cookster\CS_Iframe();
