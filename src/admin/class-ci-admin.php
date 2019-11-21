<?php

namespace cookii;

class CI_Admin {

	/**
	 * return instance from class
	 */
	public static function get_instance() {
		new CI_Admin();
	}

	/**
	 * CI_Admin constructor.
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'wp_ajax_ci_dismiss_notice', array( $this, 'dismiss_admin_notice' ) );

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$settings = new CI_Settings();

		/* Tab: columns */

		$settings->add_section(
			array(
				'id'    => 'cookimize_options',
				'title' => __( 'Texts & Settings', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'   => 'cookimize_cookie_texts_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Texts', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_cookie_message_headline',
				'type'    => 'text',
				'name'    => __( 'Cookie Notification Headline', 'cookii' ),
				'default' => __( 'Cookies & Privacy', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_cookie_message',
				'type'    => 'wysiwyg',
				'name'    => __( 'Cookie Notification Message', 'cookii' ),
				'default' => __( 'This website uses cookies to ensure you get the best experience on our website.', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_select_privacy_link',
				'type'    => 'text',
				'name'    => __( 'Privacy Page Link Text', 'cookii' ),
				'default' => __( 'More Information', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_button_label',
				'type'    => 'text',
				'name'    => __( 'Accept Button Label', 'cookii' ),
				'default' => __( 'Accept', 'cookii' ),
			)
		);


		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_customise_label',
				'type'    => 'text',
				'name'    => __( 'Customise Button Label', 'cookii' ),
				'default' => __( 'Customise', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'   => 'cookimize_cookie_settings_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Settings', 'cookii' ) . '</h3>',
			)
		);


		$settings->add_field(
			'cookimize_options',
			array(
				'id'                => 'cookimize_seconds_before_trigger',
				'type'              => 'number',
				'name'              => __( 'Popup delay (seconds)', 'cookii' ),
				'default'           => 3,
				'sanitize_callback' => 'intval',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'                => 'cookimize_expiration_time',
				'type'              => 'number',
				'name'              => __( 'Cookie Expiration (days)', 'cookii' ),
				'default'           => 30,
				'sanitize_callback' => 'intval',
			)
		);
		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_select_privacy_slug',
				'type'    => 'text',
				'name'    => __( 'Privacy Page slug', 'cookii' ),
				'default' => __( 'privacy', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_select_imprint_slug',
				'type'    => 'text',
				'name'    => __( 'Imprint Page slug', 'cookii' ),
				'default' => __( 'imprint', 'cookii' ),
			)
		);

		/* Tab: styling */

		$settings->add_section(
			array(
				'id'    => 'cookimize_style',
				'title' => __( 'Design', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_cookie_banner_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Cookie Banner', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_message_position',
				'type'    => 'select',
				'name'    => __( 'Banner Position', 'cookii' ),
				'default' => 'bottom_right',
				'options' => array(
					'center'       => __( 'center', 'cookii' ),
					'bottom'       => __( 'bottom', 'cookii' ),
					'bottom_right' => __( 'bottom-right', 'cookii' ),
				),
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_headline_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Headline', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_headline_font_color',
				'type'    => 'color',
				'name'    => __( 'Headline Font Color', 'cookii' ),
				'default' => '#8224e3',
			)
		);

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_headline_font_size',
					'type'    => 'number',
					'name'    => __( 'Headline Font Size (px)', 'cookii' ),
					'default' => 20,
				)
			);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_message_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Message', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_message_background_color',
				'type'    => 'color',
				'name'    => __( 'Message Background Color', 'cookii' ),
				'default' => '#ffffff',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_message_font_color',
				'type'    => 'color',
				'name'    => __( 'Message Font Color', 'cookii' ),
				'default' => '#23282d',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_message_font_size',
				'type'    => 'number',
				'name'    => __( 'Message Font Size (px)', 'cookii' ),
				'default' => 14,
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_link_font_color',
				'type'    => 'color',
				'name'    => __( 'Link Font Color', 'cookii' ),
				'default' => '#000000',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_button_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Buttons', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_accept_background_color',
				'type'    => 'color',
				'name'    => __( 'Accept Button Background Color', 'cookii' ),
				'default' => '#8224e3',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_accept_font_color',
				'type'    => 'color',
				'name'    => __( 'Accept Button Font Color', 'cookii' ),
				'default' => '#ffffff',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_customise_background_color',
				'type'    => 'color',
				'name'    => __( 'Customise Button Background Color', 'cookii' ),
				'default' => '#23282d',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_customise_font_color',
				'type'    => 'color',
				'name'    => __( 'Customise Button Font Color', 'cookii' ),
				'default' => '#ffffff',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_button_font_size',
				'type'    => 'number',
				'name'    => __( 'Button Font Size (px)', 'cookii' ),
				'default' => 14,
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_overlay_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Overlay', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_overlay_status',
				'type'    => 'toggle',
				'default' => 'off',
				'name'    => __( 'Use overlay until cookie accepted', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_overlay_transparency',
				'type'    => 'text',
				'name'    => __( 'Overlay transparency', 'cookii' ),
				'default' => '0.5',
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_overlay_z_index',
				'type'    => 'number',
				'name'    => __( 'Overlay z-index', 'cookii' ),
				'default' => 999,
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_overlay_banner_z_index',
				'type'    => 'number',
				'name'    => __( 'Banner z-index', 'cookii' ),
				'default' => 9999,
			)
		);

		/* Tab: GDPR */

		$settings->add_section(
			array(
				'id'    => 'cookimize_gdpr',
				'title' => __( 'Scripts', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_ga_code_label',
				'type'        => 'text',
				'name'        => __( 'Google Analytics Label', 'cookii' ),
				'placeholder' => __( 'Marketing', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_ga_code',
				'type'        => 'text',
				'name'        => __( 'Google Analytics ID', 'cookii' ),
				'placeholder' => 'UA-XXXXX-Y',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_fb_code_label',
				'type'        => 'text',
				'name'        => __( 'Facebook Label', 'cookii' ),
				'placeholder' => __( 'Social Media', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_fb_code',
				'type'        => 'text',
				'name'        => __( 'Facebook ID', 'cookii' ),
				'placeholder' => 'FB_PIXEL_ID',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_tracking_iframes',
				'type' => 'title',
				'name' => '<h3>' . __( 'iframes', 'cookii' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'      => 'cookimize_toggle_iframes',
				'type'    => 'toggle',
				'default' => 'off',
				'name'    => __( 'Block iframes until cookie accepted', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_iframe_label',
				'type'        => 'text',
				'name'        => __( 'Checkbox-Label', 'cookii' ),
				'placeholder' => 'Youtube, Google Maps, Vimeo',
				'default'     => __( 'Youtube', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'      => 'cookimize_iframe_alternate_content',
				'type'    => 'textarea',
				'name'    => __( 'Alternate Content', 'cookii' ),
				'default' => __( 'To see this content you have to accept our cookies.', 'cookii' ),
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_tracking_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Custom Tracking Codes', 'cookii' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_1_label',
				'type'        => 'text',
				'name'        => __( 'Checkbox-Label', 'cookii' ),
				'placeholder' => __( 'Google Tag Manager', 'cookii' ),

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_1_description',
				'type'        => 'textarea',
				'name'        => __( 'Description', 'cookii' ),
				'placeholder' => '',

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_code_1',
				'type' => 'code',
				'name' => __( 'Tracking-Code', 'cookii' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Tag Manager)', 'cookii' ),

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_2_label',
				'type'        => 'text',
				'name'        => __( 'Checkbox-Label', 'cookii' ),
				'placeholder' => __( 'Google Adsense', 'cookii' ),

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_2_description',
				'type'        => 'textarea',
				'name'        => __( 'Description', 'cookii' ),
				'placeholder' => '',

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_code_2',
				'type' => 'code',
				'name' => __( 'Tracking-Code', 'cookii' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Adsense)', 'cookii' ),

			)
		);

	}


	/**
	 * Enqueue admin styles and scripts for settings page.
	 */
	public function add_admin_scripts() {
		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : 'min.';

		wp_enqueue_style( 'cookii-admin', COOKII_URL . '/assets/admin/cookii-admin.' . $min . 'css', '1.0', 'all' );
		wp_enqueue_script( 'ci-admin-notices', COOKII_URL . '/assets/admin/backend-admin-notices.' . $min . 'js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'ci-admin-notices', 'ci_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Outputs admin notice.
	 *
	 * @return void
	 */
	public function admin_notice() {
		$activate_notice = get_option( 'ci_admin_notice', false );

		$text = sprintf( __( 'Thanks for installing Cookii. Start to <a href="%s">configure it</a>', 'cookii' ), admin_url( 'options-general.php?page=cookii_settings', 'https' ) );

		if ( false === $activate_notice ) {
			echo '<div class="notice notice-success is-dismissible cookii-dismiss"><p>' . $text . '</p></div>';
		}
	}

	/**
	 * Deactivate admin notice.
	 *
	 * @return void
	 */
	public function dismiss_admin_notice() {
		update_option( 'ci_admin_notice', true );
	}
}
