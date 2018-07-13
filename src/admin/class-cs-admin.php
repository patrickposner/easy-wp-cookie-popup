<?php

namespace cookimize;

class CS_Admin {

	/**
	 * return instance from class
	 */
	public static function get_instance() {
		new CS_Admin();
	}

	/**
	 * CS_Admin constructor.
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$settings = new CS_Settings();

		/* Tab: columns */

		$settings->add_section(
			array(
				'id'    => 'cookimize_options',
				'title' => __( 'Settings', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_cookie_message_headline',
				'type'    => 'text',
				'name'    => __( 'Cookie Notification Headline', 'easy-wp-cookie-popup' ),
				'default' => 'Cookies & Privacy',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_cookie_message',
				'type'    => 'wysiwyg',
				'name'    => __( 'Cookie Notification Message', 'easy-wp-cookie-popup' ),
				'default' => 'This website uses cookies to ensure you get the best experience on our website.'
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'                => 'cookimize_seconds_before_trigger',
				'type'              => 'number',
				'name'              => __( 'Popup delay (seconds)', 'easy-wp-cookie-popup' ),
				'default'           => 3,
				'sanitize_callback' => 'intval',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'                => 'cookimize_expiration_time',
				'type'              => 'number',
				'name'              => __( 'Cookie Expiration (days)', 'easy-wp-cookie-popup' ),
				'default'           => 1,
				'sanitize_callback' => 'intval',
			)
		);
		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_select_privacy_slug',
				'type'    => 'text',
				'name'    => __( 'Privacy Page slug', 'easy-wp-cookie-popup' ),
				'default' => 'privacy',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_select_privacy_link',
				'type'    => 'text',
				'name'    => __( 'Privacy Page Link Text', 'easy-wp-cookie-popup' ),
				'default' => 'More information',
			)
		);

		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_button_label',
				'type'    => 'text',
				'name'    => __( 'Accept Button Label', 'easy-wp-cookie-popup' ),
				'default' => 'Accept Cookies',
			)
		);


		$settings->add_field(
			'cookimize_options',
			array(
				'id'      => 'cookimize_customise_label',
				'type'    => 'text',
				'name'    => __( 'Customise Button Label', 'easy-wp-cookie-popup' ),
				'default' => 'Customise Cookies',
			)
		);


		/* Tab: styling */

		$settings->add_section(
			array(
				'id'    => 'cookimize_style',
				'title' => __( 'Style', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_headline_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Headline', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_headline_font_color',
					'type'        => 'color',
					'name'        => __( 'Headline Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_headline_font_color',
					'type'        => 'color',
					'name'        => __( 'Headline Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_headline_font_size',
					'type'    => 'text',
					'name'    => __( 'Headline Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '20',
					'premium' => 'premium'
				)
			);
		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_headline_font_size',
					'type'    => 'text',
					'name'    => __( 'Headline Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '20',
				)
			);

		}

		$settings->add_field(
			'cookimize_style',
			array(
				'id'   => 'cookimize_message_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Message', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);


		$settings->add_field(
			'cookimize_style',
			array(
				'id'      => 'cookimize_message_position',
				'type'    => 'select',
				'name'    => __( 'Message Position', 'easy-wp-cookie-popup' ),
				'options' => array(
					'center'       => 'center',
					'top-left'     => 'top-left',
					'top-right'    => 'top-right',
					'bottom-left'  => 'bottom-left',
					'bottom-right' => 'bottom-right',
				),
			)
		);

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {
			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_message_background_color',
					'type'        => 'color',
					'name'        => __( 'Message Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#D4D8E0', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_message_background_color',
					'type'        => 'color',
					'name'        => __( 'Message Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#D4D8E0', 'easy-wp-cookie-popup' ),
				) );
		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_message_font_color',
					'type'        => 'color',
					'name'        => __( 'Message Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_message_font_color',
					'type'        => 'color',
					'name'        => __( 'Message Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_message_font_size',
					'type'    => 'text',
					'name'    => __( 'Message Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '14',
					'premium' => 'premium',
				)
			);

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_message_font_size',
					'type'    => 'text',
					'name'    => __( 'Message Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '14',
				)
			);

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_link_font_color',
					'type'        => 'color',
					'name'        => __( 'Link Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_link_font_color',
					'type'        => 'color',
					'name'        => __( 'Link Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_button_styles',
					'type'    => 'title',
					'name'    => '<h3>' . __( 'Buttons', 'easy-wp-cookie-popup' ) . '</h3>',
					'premium' => 'premium',
				)
			);

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'   => 'cookimize_button_styles',
					'type' => 'title',
					'name' => '<h3>' . __( 'Buttons', 'easy-wp-cookie-popup' ) . '</h3>',
				)
			);

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {
			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_accept_background_color',
					'type'        => 'color',
					'name'        => __( 'Accept Button Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_accept_background_color',
					'type'        => 'color',
					'name'        => __( 'Accept Button Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_accept_font_color',
					'type'        => 'color',
					'name'        => __( 'Accept Button Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_accept_font_color',
					'type'        => 'color',
					'name'        => __( 'Accept Button Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_customise_background_color',
					'type'        => 'color',
					'name'        => __( 'Customise Button Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_customise_background_color',
					'type'        => 'color',
					'name'        => __( 'Customise Button Background Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );
		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_customise_font_color',
					'type'        => 'color',
					'name'        => __( 'Customise Button Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
					'premium'     => 'premium'
				) );

		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'          => 'cookimize_customise_font_color',
					'type'        => 'color',
					'name'        => __( 'Customise Button Font Color', 'easy-wp-cookie-popup' ),
					'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				) );

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_button_font_size',
					'type'    => 'text',
					'name'    => __( 'Button Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '14',
					'premium' => 'premium'
				)
			);
		} else {

			$settings->add_field(
				'cookimize_style',
				array(
					'id'      => 'cookimize_button_font_size',
					'type'    => 'text',
					'name'    => __( 'Button Font Size (px)', 'easy-wp-cookie-popup' ),
					'default' => '14',
				)
			);

		}

		/* Tab: GDRP */

		$settings->add_section(
			array(
				'id'    => 'cookimize_gdpr',
				'title' => __( 'GDPR', 'easy-wp-cookie-popup' ),
			)
		);
		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_tracking_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Third Party Cookies', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_ga_code_label',
				'type'        => 'text',
				'name'        => __( 'Google Analytics Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Marketing',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_ga_code',
				'type'        => 'text',
				'name'        => __( 'Google Analytics ID', 'easy-wp-cookie-popup' ),
				'placeholder' => 'UA-XXXXX-Y',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_fb_code_label',
				'type'        => 'text',
				'name'        => __( 'Facebook Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Social Media',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_fb_code',
				'type'        => 'text',
				'name'        => __( 'Facebook ID', 'easy-wp-cookie-popup' ),
				'placeholder' => 'FB_PIXEL_ID',
			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_tracking_iframes',
				'type' => 'title',
				'name' => '<h3>' . __( 'iframes', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'      => 'cookimize_toggle_iframes',
					'type'    => 'toggle',
					'default' => 'off',
					'name'    => __( 'Block iframes until cookie accepted', 'easy-wp-cookie-popup' ),
					'premium' => 'premium'
				)
			);

		} else {

			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'      => 'cookimize_toggle_iframes',
					'type'    => 'toggle',
					'default' => 'off',
					'name'    => __( 'Block iframes until cookie accepted', 'easy-wp-cookie-popup' ),
				)
			);


		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {


			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'          => 'cookimize_iframe_label',
					'type'        => 'text',
					'name'        => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
					'placeholder' => 'Youtube, Google Maps, Vimeo',
					'premium'     => 'premium'
				)
			);
		} else {

			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'          => 'cookimize_iframe_label',
					'type'        => 'text',
					'name'        => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
					'placeholder' => 'Youtube, Google Maps, Vimeo',
				)
			);

		}

		if ( ! cookimize_fs()->is_plan__premium_only( 'pro' ) ) {

			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'      => 'cookimize_iframe_alternate_content',
					'type'    => 'textarea',
					'name'    => __( 'Alternate Content', 'easy-wp-cookie-popup' ),
					'default' => 'To show this content you have to accept our cookies.',
					'premium' => 'premium'
				)
			);

		} else {

			$settings->add_field(
				'cookimize_gdpr',
				array(
					'id'      => 'cookimize_iframe_alternate_content',
					'type'    => 'textarea',
					'name'    => __( 'Alternate Content', 'easy-wp-cookie-popup' ),
					'default' => 'To show this content you have to accept our cookies.',
				)
			);

		}

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_tracking_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Custom Tracking Codes', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_1_label',
				'type'        => 'text',
				'name'        => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Google Tag Manager',

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_code_1',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Tag Manager)', 'easy-wp-cookie-popup' ),

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'          => 'cookimize_custom_code_2_label',
				'type'        => 'text',
				'name'        => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Google Adsense',

			)
		);

		$settings->add_field(
			'cookimize_gdpr',
			array(
				'id'   => 'cookimize_custom_code_2',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Adsense)', 'easy-wp-cookie-popup' ),

			)
		);

	}


	/**
	 * enqueue admin styles and scripts for settings page
	 */
	public function add_admin_scripts() {

		wp_enqueue_style( 'cookimize-admin', COOKIMIZE_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'cookimize-admin.css' );
		wp_enqueue_script( 'cookimize-admin-js', COOKIMIZE_URL . '/assets/admin/cookimize-admin.js', array( 'jquery' ), false );

		wp_localize_script( 'cookimize-admin-js', 'cookimize_admin', array(
			'logo' => COOKIMIZE_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . '/admin/' . DIRECTORY_SEPARATOR . 'cookimize-logo.png'

		) );
	}
}
