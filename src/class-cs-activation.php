<?php

namespace cookster;


class CS_Activation {

	/**
	 * initialize activation
	 */
	public static function init() {
		register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );

		if ( is_admin() ) {
			add_filter( 'plugin_action_links_' . COOKSTER_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
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
			'settings' => '<a href="' . admin_url( 'admin.php?page=cookster' ) . '" aria-label="' . esc_attr__( 'View Cookster settings', 'cookster' ) . '">' . esc_html__( 'Settings', 'cookster' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * check conditions before activate
	 */
	public function activate() {
		global $wp_version;

		$php = '5.6';
		$wp  = '4.1';

		if ( version_compare( PHP_VERSION, $php, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a PHP version greater than %1$s. Your PHP version can be updated by your hosting company.', 'cookster' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cookster' ) . '</a>'
			);
		}

		if ( version_compare( $wp_version, $wp, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>' .
				sprintf(
					__( 'This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard &#9656; Updates to gran the latest version of WordPress .', 'cookster' ),
					$php
				)
				. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cookster' ) . '</a>'
			);
		}

		if ( ! is_multisite() ) {

			// Check if woocommerce is active
			if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				deactivate_plugins( basename( __FILE__ ) );
				wp_die(
					'<p>' .
					sprintf(
						__( 'This plugin can not be activated because it requires a active version of the WooCommerce plugin. Please go to Plugins and install WooCommerce.', 'cookster' ),
						$php
					)
					. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cookster' ) . '</a>'
				);
			}
		}
	}
}