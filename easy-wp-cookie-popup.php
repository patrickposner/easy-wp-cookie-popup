<?php
/*
Plugin Name: Cookimize
Text Domain: easy-wp-cookie-popup
Domain Path: /languages
Description: A simple plugin for integrating a GDPR conform cookie solution
Author: patrickposner
Version: 1.0.2
*/

define( 'COOKIMIZE_ABSPATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
define( 'COOKIMIZE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( "COOKIMIZE_PATH", untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( "COOKIMIZE_URL", untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/* load setup */
require_once( COOKIMIZE_ABSPATH . 'inc' . DIRECTORY_SEPARATOR . 'setup.php' );

/* localize */
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'easy-wp-cookie-popup', false, $textdomain_dir );


if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/* intialize classes */

cookimize\CS_Activation::init();
cookimize\CS_Admin::get_instance();
cookimize\CS_Public::get_instance();

if ( cookimize_fs()->is_plan__premium_only( 'pro' ) ) {
	cookimize\CS_Iframe::get_instance();
}
