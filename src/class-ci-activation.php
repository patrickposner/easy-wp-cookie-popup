<?php

namespace cookii;


class CI_Activation {

	/**
	 * initialize activation
	 */
	public static function init() {
		register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );

		if ( is_admin() ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'plugin_action_links' ) );
		}
	}

	/**
	 * add plugin actions links for settings page
	 *
	 * @param $links
	 *
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=cookii' ) . '" aria-label="' . esc_attr__( 'View cookii settings', 'cookii' ) . '">' . esc_html__( 'Settings', 'cookii' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * check conditions before activate
	 */
	public function activate() {

		set_transient( 'fx-admin-notice-example', true, 5 );

		global $wp_version;

		$php = '5.6';
		$wp  = '4.1';

		if ( version_compare( PHP_VERSION, $php, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a PHP version greater than %1$s. Your PHP version can be updated by your hosting company.', 'cookii' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cookii' ) . '</a>'
			);
		}

		if ( version_compare( $wp_version, $wp, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard &#9656; Updates to gran the latest version of WordPress .', 'cookii' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cookii' ) . '</a>'
			);
		}
	}

}
