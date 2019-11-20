<?php
/*
Plugin Name: Cookii
Text Domain: cookii
Domain Path: /languages
Description: A simple plugin to integrate a GDPR friendly cookie solution
Author: patrickposner
Version: 2.1
*/

define( 'COOKII_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'COOKII_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/* load setup */
require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'setup.php' );

/* localize */
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'cookii', false, $textdomain_dir );


if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

add_action( 'plugins_loaded', 'run_plugin' );

/**
 * Run plugin
 *
 * @return void
 */
function run_plugin() {
	cookii\CI_Activation::init();
	cookii\CI_Admin::get_instance();
	cookii\CI_Public::get_instance();
	cookii\CI_Iframe::get_instance();
}


