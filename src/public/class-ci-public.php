<?php

namespace cookii;

class CI_Public {

	/**
	 * Imprint page
	 *
	 * @var int
	 */
	public $imprint_page_id;

	/**
	 * Data privacy page
	 *
	 * @var int
	 */
	public $privacy_page_id;

	/**
	 * Default GDPR settings
	 *
	 * @var array
	 */
	public $gdpr;

	/**
	 * Default text settings
	 *
	 * @var array
	 */
	public $settings;


	/**
	 * Default style settings
	 *
	 * @var array
	 */
	public $style;

	/**
	 * CS_Public constructor.
	 */
	public function __construct() {

		/* set default settings */
		$settings = get_option( 'cookimize_options', array(
			'cookimize_cookie_message_headline' => __( 'Cookies & Privacy', 'cookii' ),
			'cookimize_cookie_message'          => __( 'This website uses cookies to ensure you get the best experience on our website.', 'cookii' ),
			'cookimize_seconds_before_trigger'  => 2,
			'cookimize_expiration_time'         => 30,
			'cookimize_button_label'            => __( 'Accept', 'cookii' ),
			'cookimize_customise_label'         => __( 'Customise', 'cookii' ),
			'cookimize_select_privacy_slug'     => __( 'privacy', 'cookii' ),
			'cookimize_select_imprint_slug'     => __( 'imprint', 'cookii' ),
			'cookimize_select_privacy_link'     => __( 'More Information', 'cookii' ),
			)
		);

		$gdpr = get_option( 'cookimize_gdpr', array(
			'cookimize_ga_code_label'             => __( 'Google Analytics', 'cookii' ),
			'cookimize_ga_code'                   => '',
			'cookimize_fb_code_label'             => __( 'Facebook', 'cookii' ),
			'cookimize_fb_code'                   => '',
			'cookimize_toggle_iframes'            => 'off',
			'cookimize_iframe_label'              => __( 'Youtube', 'cookii' ),
			'cookimize_iframe_alternate_content'  => __( 'To see this content, you have to accept our cookies first.', 'cookii' ),
			'cookimize_custom_code_1_label'       => '',
			'cookimize_custom_code_1_description' => '',
			'cookimize_custom_code_1'             => '',
			'cookimize_custom_code_2_label'       => '',
			'cookimize_custom_code_2_description' => '',
			'cookimize_custom_code_2'             => '',
			)
		);

		$style = get_option( 'cookimize_style', array(
			'cookimize_headline_font_color'        => '#809cc0',
			'cookimize_headline_font_size'         => 20,
			'cookimize_message_position'           => 'bottom-right',
			'cookimize_message_background_color'   => '#ffffff',
			'cookimize_message_font_color'         => '#4b6584',
			'cookimize_message_font_size'          => 14,
			'cookimize_link_font_color'            => '#ffffff',
			'cookimize_accept_background_color'    => '#4b6584',
			'cookimize_accept_font_color'          => '#ffffff',
			'cookimize_customise_background_color' => '#eee',
			'cookimize_customise_font_color'       => '#4b6584',
			'cookimize_button_font_size'           => 12,
			'cookimize_overlay_status'             => 'off',
			'cookimize_overlay_transparency'       => '0.5',
			'cookimize_overlay_z_index'            => '999',
			)
		);

		$imprint_page = get_page_by_path( $settings['cookimize_select_imprint_slug'], __( 'Imprint', 'cookii' ), OBJECT, 'page' );
		$privacy_page = get_page_by_path( $settings['cookimize_select_privacy_slug'], __( 'Privacy', 'cookii' ), OBJECT, 'page' );

		/* assign variables */
		$this->settings        = $settings;
		$this->gdpr            = $gdpr;
		$this->style            = $style;
		$this->imprint_page_id = $imprint_page->ID;
		$this->privacy_page_id = $privacy_page->ID;

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'wp_head', array( $this, 'dynamic_styles' ) );
		add_action( 'wp_head', array( $this, 'add_tracking_code' ) );
		add_action( 'wp_footer', array( $this, 'add_overlay' ) );	
	}

	/**
	 * Return instance from class
	 */
	public static function get_instance() {
		new CI_Public();
	}

	/**
	 * enqueue scripts and localize options
	 */
	public function add_scripts() {

		if ( is_page( $this->imprint_page_id ) || is_page( $this->privacy_page_id ) ) {
			return;
		}

		$min      = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : 'min.';
		$gdpr     = $this->gdpr;
		$settings = $this->settings;

		wp_enqueue_script( 'ihavecookies-js', COOKII_URL . '/assets/public/jquery.ihavecookies.min.js', array( 'jquery' ), '1.0', false );
		wp_enqueue_script( 'cookii-js', COOKII_URL . '/assets/public/cookii.js', array( 'jquery' ), '1.0', true );


		wp_localize_script( 'cookii-js', 'cookii', array(
			'headline'               => $settings['cookimize_cookie_message_headline'],
			'message'                => $settings['cookimize_cookie_message'],
			'trigger_time'           => $settings['cookimize_seconds_before_trigger'],
			'expiration_time'        => $settings['cookimize_expiration_time'],
			'privacy_page'           => get_bloginfo( 'url' ) . DIRECTORY_SEPARATOR . $settings['cookimize_select_privacy_slug'],
			'accept'                 => $settings['cookimize_button_label'],
			'customize'              => $settings['cookimize_customise_label'],
			'cookie_type_title'      => __( 'Select cookies to accept', 'cookii' ),
			'custom_code_1_label'    => $gdpr['cookimize_custom_code_1_label'],
			'custom_code_2_label'    => $gdpr['cookimize_custom_code_2_label'],
			'custom_code_1_desc'     => $gdpr['cookimize_custom_code_1_description'],
			'custom_code_2_desc'     => $gdpr['cookimize_custom_code_2_description'],
			'necessary'              => __( 'Technical necessary Cookies', 'cookii' ),
			'necessary_desc'         => __( 'We require some cookies to be able to process orders and customer accounts. This cookies can not be disabled if you like to use our product. ', 'cookii' ),
			'privacy_page_text'      => __( 'See privacy policy', 'cookii' ),
			'fb_code_description'    => __( 'We use cookies for Facebook to send and promote you special offers and tracking our campains to optimize our services.', 'cookii' ),
			'ga_code_description'    => __( 'We use cookies for Google Analytics to track our users behaviour with our products and continuesly improve it. ', 'cookii' ),
			'required_code_lifetime' => $this->get_cookie_lifetime( 'required' ),
			'fb_code_lifetime'       => $this->get_cookie_lifetime( 'fb' ),
			'ga_code_lifetime'       => $this->get_cookie_lifetime( 'ga' ),
			'custom_code_1_lifetime' => $this->get_cookie_lifetime( 'custom-code-1' ),
			'custom_code_2_lifetime' => $this->get_cookie_lifetime( 'custom-code-2' ),
			'more_information'       => __( 'More information', 'cookii' ),
			'less_information'       => __( 'Less information', 'cookii' ),
		) );
	}

	/**
	 * Get cookie lifetime markup
	 *
	 * @param string $cookie_name name of the cookie.
	 * @return string
	 */
	public function get_cookie_lifetime( $cookie_name ) {

		ob_start();

		if ( 'required' === $cookie_name ) {
			?>
			<div class="cookii-toggle" style="margin-bottom:15px;">
				<a class="bm-more-information" data-cookie="required"><?php _e( 'More information', 'cookii' ); ?></a>
				<table data-cookie="required" style="display:none">
					<tbody style="vertical-align: top;">
						<tr>
							<th style="width: 40%;"><?php _e( 'Name', 'cookii' ); ?></th>
							<td><?php _e( 'B2B Market Cookie Consent', 'cookii' ); ?></td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Provider', 'cookii' ); ?></th>
							<td><?php _e( 'Owner of this website', 'cookii' ); ?></td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Usage', 'cookii' ); ?></th>
							<td><?php _e( 'Save the settings from your cookie selection.', 'cookii' ); ?>
							</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Cookies', 'cookii' ); ?></th>
							<td>cookieControlPrefs, cookieControl</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Lifetime', 'cookii' ); ?></th>
							<td><?php echo esc_attr( get_option( 'bm_cc_cookie_lifetime', 30 ) ); ?> <?php _e( 'Days', 'cookii' ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
		} elseif ( 'ga' === $cookie_name ) {
			?>
			<div class="cookii-toggle" style="margin-bottom:15px;">
				<a class="bm-more-information" data-cookie="ga"><?php _e( 'More information', 'cookii' ); ?></a>
				<table data-cookie="ga" style="display:none">
					<tbody style="vertical-align: top;">
						<tr>
							<th style="width: 40%;"><?php _e( 'Name', 'cookii' ); ?></th>
							<td>Google Analytics</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Provider', 'cookii' ); ?></th>
							<td>Google LLC</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Usage', 'cookii' ); ?></th>
							<td><?php _e( 'Cookie for website analytics. Creates statistic data about the website usage.', 'cookii' ); ?>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Data privacy', 'cookii' ); ?></th>
							<td><a href="https://policies.google.com/privacy" target="_blank"
									rel="nofollow noopener noreferrer">https://policies.google.com/privacy</a></td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Cookies', 'cookii' ); ?></th>
							<td>_ga,_gat,_gid</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Lifetime', 'cookii' ); ?></th>
							<td>2 <?php _e( 'Years', 'cookii' ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
		} elseif ( 'fb' === $cookie_name ) {
			?>
			<div class="cookii-toggle" style="margin-bottom:15px;">
				<a class="bm-more-information" data-cookie="fb"><?php _e( 'More information', 'cookii' ); ?></a>
				<table data-cookie="fb" style="display:none">
					<tbody style="vertical-align: top;">
						<tr>
							<th style="width: 40%;"><?php _e( 'Name', 'cookii' ); ?></th>
							<td>Facebook</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Provider', 'cookii' ); ?></th>
							<td>Facebook</td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Usage', 'cookii' ); ?></th>
							<td><?php _e( 'Cookie to unlock facebook content.', 'cookii' ); ?>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Data privacy', 'cookii' ); ?></th>
							<td><a href="https://www.facebook.com/privacy/explanation" target="_blank"
									rel="nofollow noopener noreferrer">https://www.facebook.com/privacy/explanation</a></td>
						</tr>
						<tr>
							<th style="width: 40%;"><?php _e( 'Hosts', 'cookii' ); ?></th>
							<td>.facebook.com</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
		} elseif ( 'custom-code-1' === $cookie_name ) {
			do_action( 'cookii_custom_code_1_lifetime' );
		} elseif ( 'custom-code-2' === $cookie_name ) {
			do_action( 'cookii_custom_code_2_lifetime' );
		}

		return ob_get_clean();
	}

	/**
	 * Add overlay markup to page.
	 *
	 * @return void
	 */
	public function add_overlay() {
		if ( is_page( $this->imprint_page_id ) || is_page( $this->privacy_page_id ) ) {
			return;
		}

		$style = $this->style;

		if ( 'off' === $style['cookimize_overlay_status'] ) {
			return;
		}

		if ( isset( $_COOKIE['cookieControl'] ) ) {
			return;
		}

		?>
		<div id="cookii-overlay"></div>
		<style>
		#cookii-overlay {
			height: 100%;
			width: 100%;
			position: fixed;
			background: rgba(0,0,0, <?php echo esc_html( $style['cookimize_overlay_transparency'] ); ?>);
			z-index: <?php echo esc_html( $style['cookimize_overlay_z_index'] ); ?>;
			left: 0;
			top: 0;
			overflow-x: hidden;
			transition: 0.5s;
		}
		</style>
		<?php
	}

	/**
	 * Adding dynamic styles for Cookii
	 */
	public function dynamic_styles() {

		if ( is_page( $this->imprint_page_id ) || is_page( $this->privacy_page_id ) ) {
			return;
		}
		$styles = $this->style;
		?>

		<style>

		<?php
		/* message box position */
		switch ( get_option( 'bm_cc_message_position', 'bottom_right' ) ) {
			case 'center':
				?>
				#cookii-message {
					position: fixed;
					max-width: 500px;
					background-color: <?php echo get_option( 'bm_cc_message_background_color', '#FFFFFF' ); ?>;
					color: <?php echo get_option( 'bm_cc_message_font_color', '#000000' ); ?>;
					font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
					padding: 60px;
					box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
					z-index: <?php echo get_option( 'bm_cc_overlay_banner_z_index', 9999 ); ?>;
					top: 50%;
					left: 50%;
					-webkit-transform: translate(-50%, -50%);
					-ms-transform: translate(-50%, -50%);
					transform: translate(-50%, -50%);
				}
			<?php
				break;
			case 'bottom':
				?>
				#cookii-message {
					position: fixed;
					max-width: 100%;
					width: 100%;
					padding: 60px;
					right: 0;
					left: 0;
					bottom: 0;
					background-color: <?php echo get_option( 'bm_cc_message_background_color', '#FFFFFF' ); ?>;
					color: <?php echo get_option( 'bm_cc_message_font_color', '#000000' ); ?>;
					font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
					box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
					z-index: <?php echo get_option( 'bm_cc_overlay_banner_z_index', 9999 ); ?>;
				}
				.cookii-row {
					max-width: 60%;
					margin: 0px auto;
				}
				.cookii-column {
					float: left;
					width: 33.333333333%;
					padding: 0 15px 0 15px;
					box-sizing: border-box;
				}
				.cookii-column-1 {
					width:30%;
				}
				.cookii-column-2 {
					width:40%;
				}
				.cookii-column-3 {
					width:20%;
				}
				#cookii-types {
					display: block !important;
				}
				#cookii-advanced {
					display: none;
				}
				#cookii-accept {
					float: left;
				}
				<?php
				break;
			case 'bottom_right':
				?>
				#cookii-message {
					position: fixed;
					right: 30px;
					bottom: 30px;
					max-width: 375px;
					background-color: <?php echo get_option( 'bm_cc_message_background_color', '#FFFFFF' ); ?>;
					color: <?php echo get_option( 'bm_cc_message_font_color', '#000000' ); ?>;
					font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
					padding: 40px;
					box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
					z-index: <?php echo get_option( 'bm_cc_overlay_banner_z_index', 9999 ); ?>;
					margin-left: 30px;
				}
				<?php
				break;
		}
		?>

		#cookii-message h4 {
			color: <?php echo get_option( 'bm_cc_headline_color', '#2FAC66' ); ?>;
			font-size: <?php echo get_option( 'bm_cc_headline_font_size', '20' ); ?>px;
			font-weight: 500;
			margin-bottom: 10px;
			margin-top: 0px;
		}
		#cookii-message ul {
			margin: 0;
		}
		#cookii-message li {
			width: 100% !important;
			display: block !important;
			margin: 0px;
		}

		#cookii-message h5 {
			color: <?php echo get_option( 'bm_cc_headline_color', '#2FAC66' ); ?>;
			font-size: calc(<?php echo get_option( 'bm_cc_headline_font_size', '16' ); ?>px - 4px);
			font-weight: 500;
			margin-bottom: 10px;
			margin-top: 0px;
		}

		#cookii-message p, #cookii-message ul {
			color: <?php echo get_option( 'bm_cc_message_font_color', '#000000' ); ?>;
			font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
			line-height: 1.5em;
		}

		#cookii-message p:last-child {
			margin-bottom: 0;
			text-align: right;
		}

		#cookii-message li {
			width: 49%;
			display: inline-block;
		}

		#cookii-message a {
			color: <?php echo get_option( 'bm_cc_data_privacy_link_color', '#2FAC66' ); ?>;
			text-decoration: none;
			font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
			padding-bottom: 2px;
			border-bottom: 1px dotted rgba(255, 255, 255, 0.75);
			transition: all 0.3s ease-in;
		}

		#cookii-message a:hover {
			color: <?php echo get_option( 'bm_cc_data_privacy_link_color', '#2FAC66' ); ?>;
			transition: all 0.3s ease-in;
		}
		.cookii-toggle a {
		cursor: pointer;
		}
		#cookii-message button {
			border: none;
			background: <?php echo get_option( 'bm_cc_accept_button_background_color', '#2FAC66' ); ?>;
			color: <?php echo get_option( 'bm_cc_accept_button_font_color', '#000000' ); ?>;
			font-size: <?php echo get_option( 'bm_cc_button_font_size', 14 ); ?>px;
			padding: 7px;
			border-radius: 3px;
			margin-left: 15px;
			cursor: pointer;
			transition: all 0.3s ease-in;
		}

		#cookii-message button:hover {
			transition: all 0.3s ease-in;
		}

		button#cookii-advanced {
			background: <?php echo get_option( 'bm_cc_message_background_color', '#FFFFFF' ); ?>;
			color: <?php echo get_option( 'bm_cc_message_font_color', '#000000' ); ?>;
			font-size: <?php echo get_option( 'bm_cc_message_font_size', '14' ); ?>px;
		}

		button#cookii-advanced:hover {
			transition: all 0.3s ease-in;
		}

		#cookii-message button:disabled {
			opacity: 0.3;
		}

		#cookii-message input[type="checkbox"] {
			float: none;
			margin-top: 0;
			margin-right: 5px;
		}
		.cookii-toggle table td a {
		font-size: 100% !important;
		}
		</style>

		<?php

	}

	public function add_tracking_code() {

		if ( is_page( $this->imprint_page_id ) || is_page( $this->privacy_page_id ) ) {
			return;
		}

		if ( isset( $_COOKIE['cookieControl'] ) && 'true' === $_COOKIE['cookieControl'] ) {

			$gdpr = get_option( 'cookimize_gdpr' );

			/* add tracking codes based on selection */

			$cookie_preferences = json_decode( stripslashes( $_COOKIE['cookieControlPrefs'] ) );

			if ( in_array( 'ga', $cookie_preferences ) ) { ?>
				<!-- Google Analytics -->
				<script>
					(function (i, s, o, g, r, a, m) {
						i['GoogleAnalyticsObject'] = r;
						i[r] = i[r] || function () {
							(i[r].q = i[r].q || []).push(arguments)
						}, i[r].l = 1 * new Date();
						a = s.createElement(o),
							m = s.getElementsByTagName(o)[0];
						a.async = 1;
						a.src = g;
						m.parentNode.insertBefore(a, m)
					})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

					ga('create', '<?php echo $gdpr['cookimize_ga_code'];?>', 'auto');
					ga('send', 'pageview');
					ga('set', 'anonymizeIp', true);
				</script>
				<!-- End Google Analytics -->
				<?php
			}

			if ( in_array( 'fb', $cookie_preferences ) ) { ?>

				<!-- Facebook Pixel Code -->
				<script>
					!function (f, b, e, v, n, t, s) {
						if (f.fbq) return;
						n = f.fbq = function () {
							n.callMethod ?
								n.callMethod.apply(n, arguments) : n.queue.push(arguments)
						};
						if (!f._fbq) f._fbq = n;
						n.push = n;
						n.loaded = !0;
						n.version = '2.0';
						n.queue = [];
						t = b.createElement(e);
						t.async = !0;
						t.src = v;
						s = b.getElementsByTagName(e)[0];
						s.parentNode.insertBefore(t, s)
					}(window,
						document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
					// Insert Your Facebook Pixel ID below.
					fbq('init', '<?php echo $gdpr['cookimize_fb_code'];?>');
					fbq('track', 'PageView');
				</script>
				<!-- Insert Your Facebook Pixel ID below. -->
				<noscript><img height="1" width="1" style="display:none"
								src="https://www.facebook.com/tr?id=<?php echo $gdpr['cookimize_fb_code']; ?>&amp;ev=PageView&amp;noscript=1"
					/></noscript>
				<!-- End Facebook Pixel Code -->
				<?php

			}

			if ( in_array( 'custom_code_1', $cookie_preferences ) ) {

				echo $gdpr['cookimize_custom_code_1'];
			}

			if ( in_array( 'custom_code_2', $cookie_preferences ) ) {

				echo $gdpr['cookimize_custom_code_1'];
			}

		}
	}
}