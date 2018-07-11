<?php

namespace cookster;

class CS_Admin {

	/**
	 * return instance from class
	 */
	public static function get_instance() {
		new CS_Admin();
	}

	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$settings = new CS_Settings();

		/* Tab: columns */

		$settings->add_section(
			array(
				'id'    => 'cookster_options',
				'title' => __( 'Settings', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'      => 'cookster_cookie_message_headline',
				'type'    => 'text',
				'name'    => __( 'Cookie Notification Headline', 'easy-wp-cookie-popup' ),
				'default' => 'Headline',
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'   => 'cookster_cookie_message',
				'type' => 'wysiwyg',
				'name' => __( 'Cookie Notification Message', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'                => 'cookster_seconds_before_trigger',
				'type'              => 'number',
				'name'              => __( 'Popup deplay (seconds)', 'easy-wp-cookie-popup' ),
				'default'           => 1,
				'sanitize_callback' => 'intval',
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'                => 'cookster_expiration_time',
				'type'              => 'number',
				'name'              => __( 'Cookie Expiration (days)', 'easy-wp-cookie-popup' ),
				'default'           => 1,
				'sanitize_callback' => 'intval',
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'      => 'cookster_select_privacy_page',
				'type'    => 'select',
				'name'    => __( 'Privacy Policy Page', 'easy-wp-cookie-popup' ),
				'options' => array(
					'yes' => 'Yes',
					'no'  => 'No',
				),
			)
		);

		$settings->add_field(
			'cookster_options',
			array(
				'id'      => 'cookster_button_label',
				'type'    => 'text',
				'name'    => __( 'Accept Button Label', 'easy-wp-cookie-popup' ),
				'default' => 'Accept',
			)
		);


		$settings->add_field(
			'cookster_options',
			array(
				'id'      => 'cookster_customize_label',
				'type'    => 'text',
				'name'    => __( 'Customize Button Label', 'easy-wp-cookie-popup' ),
				'default' => 'Customize Cookies',
			)
		);


		/* Tab: styling */

		$settings->add_section(
			array(
				'id'    => 'cookster_style',
				'title' => __( 'Style', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'   => 'cookster_headline_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Headline', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_headline_font_color',
				'type'        => 'color',
				'name'        => __( 'Headline Font Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' ),
				'premium' => 'premium'
			) );


		$settings->add_field(
			'cookster_style',
			array(
				'id'      => 'cookster_headline_font_size',
				'type'    => 'text',
				'name'    => __( 'Headline Font Size (px)', 'easy-wp-cookie-popup' ),
				'default' => '20',
			)
		);


		$settings->add_field(
			'cookster_style',
			array(
				'id'   => 'cookster_message_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Message', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'      => 'cookster_message_position',
				'type'    => 'select',
				'name'    => __( 'Message Position', 'easy-wp-cookie-popup' ),
				'options' => array(
					'center'  => 'center',
					'top-left' => 'top-left',
					'top-right' => 'top-right',
					'bottom-left'  => 'bottom-left',
					'bottom-right'  => 'bottom-right',
				),
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_message_background_color',
				'type'        => 'color',
				'name'        => __( 'Message Background Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#FFFFFF', 'easy-wp-cookie-popup' ),
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_message_font_color',
				'type'        => 'color',
				'name'        => __( 'Message Font Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'      => 'cookster_message_font_size',
				'type'    => 'text',
				'name'    => __( 'Message Font Size (px)', 'easy-wp-cookie-popup' ),
				'default' => '14',
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_link_font_color',
				'type'        => 'color',
				'name'        => __( 'Link Font Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'   => 'cookster_button_styles',
				'type' => 'title',
				'name' => '<h3>' . __( 'Buttons', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_accept_background_color',
				'type'        => 'color',
				'name'        => __( 'Accept Button Background Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_accept_font_color',
				'type'        => 'color',
				'name'        => __( 'Accept Button Font Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_customize_background_color',
				'type'        => 'color',
				'name'        => __( 'Customize Button Background Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'          => 'cookster_customize_font_color',
				'type'        => 'color',
				'name'        => __( 'Customize Button Font Color', 'easy-wp-cookie-popup' ),
				'placeholder' => __( '#000000', 'easy-wp-cookie-popup' )
			) );

		$settings->add_field(
			'cookster_style',
			array(
				'id'      => 'cookster_button_font_size',
				'type'    => 'text',
				'name'    => __( 'Button Font Size (px)', 'easy-wp-cookie-popup' ),
				'default' => '14',
			)
		);

		/* Tab: GDRP */

		$settings->add_section(
			array(
				'id'    => 'cookster_gdpr',
				'title' => __( 'GDPR', 'easy-wp-cookie-popup' ),
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'      => 'toggle_checkboxes',
				'type'    => 'toggle',
				'default' => 'off',
				'name'    => __( 'Checkboxes checked by default?', 'easy-wp-cookie-popup' ),
			)
		);
		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_1_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Cookie Types', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'      => 'cookster_type_1',
				'type'    => 'text',
				'name'    => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Google Analytics',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_1_code',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Analytics)', 'easy-wp-cookie-popup' ),
				'default' => '<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');

ga(\'create\', \'UA-XXXXX-Y\', \'auto\');
ga(\'send\', \'pageview\');
</script>
<!-- End Google Analytics -->'
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_2_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Cookie Type', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'      => 'cookster_type_2',
				'type'    => 'text',
				'name'    => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Google Tag Manager',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_2_code',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Tag Manager)', 'easy-wp-cookie-popup' ),
				'default' => '<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-XXXX\');</script>
<!-- End Google Tag Manager -->'
			)
		);
		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_3_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Cookie Type', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'      => 'cookster_type_3',
				'type'    => 'text',
				'name'    => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Facebook Tracking',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_3_code',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Facebook Tracking Pixel)', 'easy-wp-cookie-popup' ),
				'default' => '<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version=\'2.0\';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,\'script\',\'https://connect.facebook.net/en_US/fbevents.js\');
// Insert Your Facebook Pixel ID below. 
fbq(\'init\', \'FB_PIXEL_ID\');
fbq(\'track\', \'PageView\');
</script>
<!-- Insert Your Facebook Pixel ID below. --> 
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=FB_PIXEL_ID&amp;ev=PageView&amp;noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->'
			)
		);
		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_4_headline',
				'type' => 'title',
				'name' => '<h3>' . __( 'Cookie Type', 'easy-wp-cookie-popup' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'      => 'cookster_type_4',
				'type'    => 'text',
				'name'    => __( 'Checkbox-Label', 'easy-wp-cookie-popup' ),
				'placeholder' => 'Google Adsense',
			)
		);

		$settings->add_field(
			'cookster_gdpr',
			array(
				'id'   => 'cookster_type_4_code',
				'type' => 'textarea',
				'name' => __( 'Tracking-Code', 'easy-wp-cookie-popup' ),
				'desc' => __( 'Enter your Tracking Code (Example: Google Adsense)', 'easy-wp-cookie-popup' ),
				'default' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-0000000000000000"
     data-ad-slot="0000000000"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>'
			)
		);

	}


	public function add_admin_scripts() {

		wp_enqueue_style( 'cookster-admin', COOKSTER_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'cookster-admin.css' );
		wp_enqueue_script( 'cookster-admin-js', COOKSTER_URL . '/assets/admin/cookster-admin.js', array( 'jquery' ), false );
	}


}