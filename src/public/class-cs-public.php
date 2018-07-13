<?php

namespace cookimize;

class CS_Public {

	/**
	 * CS_Public constructor.
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'wp_head', array( $this, 'dynamic_styles' ) );
		add_action( 'init', array( $this, 'get_default_settings' ) );
		add_action( 'wp_head', array( $this, 'add_tracking_code' ) );
	}

	/**
	 * return instance from class
	 */
	public static function get_instance() {
		new CS_Public();
	}

	/**
	 * enqueue scripts and localize options
	 */
	public function add_scripts() {

		wp_enqueue_script( 'ihavecookies-js', COOKIMIZE_URL . '/assets/public/jquery.ihavecookies.min.js', array( 'jquery' ), false );
		wp_enqueue_script( 'cookimize-cookie-js', COOKIMIZE_URL . '/assets/public/cookimize-cookie.js', array( 'jquery' ), false, true );

		$settings = get_option( 'cookimize_options' );
		$gdpr     = get_option( 'cookimize_gdpr' );

		wp_localize_script( 'cookimize-cookie-js', 'cookimize', array(
			'headline'               => $settings['cookimize_cookie_message_headline'],
			'message'                => $settings['cookimize_cookie_message'],
			'trigger_time'           => $settings['cookimize_seconds_before_trigger'],
			'expiration_time'        => $settings['cookimize_expiration_time'],
			'privacy_page'           => get_bloginfo( 'url' ) . DIRECTORY_SEPARATOR . $settings['cookimize_select_privacy_slug'],
			'privacy_page_text'      => $settings['cookimize_select_privacy_link'],
			'accept'                 => $settings['cookimize_button_label'],
			'customize'              => $settings['cookimize_customise_label'],
			'cookie_type_title'      => __( 'Select cookies to accept', 'easy-wp-cookie-popup' ),
			'checkboxes_checked'     => $gdpr['cookimize_toggle_checkboxes'],
			'deactivate_all_cookies' => $gdpr['cookimize_toggle_deactivate_all_cookies'],
			'iframes'                => $gdpr['cookimize_toggle_iframes'],
			'ga_label'               => $gdpr['cookimize_ga_code_label'],
			'fb_label'               => $gdpr['cookimize_fb_code_label'],
			'fb_code'                => $gdpr['cookimize_fb_code'],
			'custom_code_1_label'    => $gdpr['cookimize_custom_code_1_label'],
			'custom_code_2_label'    => $gdpr['cookimize_custom_code_2_label'],
			'iframe_label'           => $gdpr['cookimize_iframe_label']
		) );


	}

	/**
	 * adding dynamic styles for cookimize
	 */
	public function dynamic_styles() {

		$styles = get_option( 'cookimize_style' );
		$this->get_default_styles();
		?>

        <style>

            <?php

			/* message box position */

			switch ( $styles['cookimize_message_position'] ) {
				case 'center': ?>
            #gdpr-cookie-message {
                position: fixed;
                width: 375px;
                height: 200px;
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
                z-index: 99;
                top: 50%;
                left: 50%;
                margin-top: -100px;
                margin-left: -187.5px;
            }

            <?php
			break;
		case 'top-left': ?>
            #gdpr-cookie-message {
                position: fixed;
                left: 30px;
                top: 30px;
                max-width: 375px;
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
                margin-left: 30px;
                z-index: 99;
            }

            <?php
			break;
		case 'top-right':
			?>
            #gdpr-cookie-message {
                position: fixed;
                right: 30px;
                top: 30px;
                max-width: 375px;
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
                margin-left: 30px;
                z-index: 99;
            }

            <?php
			break;
		case 'bottom-left': ?>
            #gdpr-cookie-message {
                position: fixed;
                left: 30px;
                bottom: 30px;
                max-width: 375px;
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
                margin-left: 30px;
                z-index: 99;
            }

            <?php
			break;
		case 'bottom-right':
			?>
            #gdpr-cookie-message {
                position: fixed;
                right: 30px;
                bottom: 30px;
                max-width: 375px;
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
                margin-left: 30px;
                z-index: 99;
            }

            <?php
			break;
	}
	?>

            #gdpr-cookie-message h4 {
                color: <?php echo $styles['cookimize_headline_font_color'];?>;
                font-size: <?php echo $styles['cookimize_headline_font_size'];?>px;
                font-weight: 500;
                margin-bottom: 10px;
            }

            #gdpr-cookie-message h5 {
                color: <?php echo $styles['cookimize_headline_font_color'];?>;
                font-size: calc(<?php echo $styles['cookimize_headline_font_size'];?>px - 4px);
                font-weight: 500;
                margin-bottom: 10px;
            }

            #gdpr-cookie-message p, #gdpr-cookie-message ul {
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                line-height: 1.5em;
            }

            #gdpr-cookie-message p:last-child {
                margin-bottom: 0;
                text-align: right;
            }

            #gdpr-cookie-message li {
                width: 49%;
                display: inline-block;
            }

            #gdpr-cookie-message a {
                color: <?php echo $styles['cookimize_link_font_color'];?>;
                text-decoration: none;
                font-size: <?php echo $styles['cookimize_message_font_size'];?>px;
                padding-bottom: 2px;
                border-bottom: 1px dotted rgba(255, 255, 255, 0.75);
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message a:hover {
                color: white;
                border-bottom-color: <?php echo $styles['cookimize_link_font_color'];?>;
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message button {
                border: none;
                background: <?php echo $styles['cookimize_accept_background_color'];?>;
                color: <?php echo $styles['cookimize_accept_font_color'];?>;
                font-size: <?php echo $styles['cookimize_button_font_size'];?>px;
                padding: 7px;
                border-radius: 3px;
                margin-left: 15px;
                cursor: pointer;
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message button:hover {
                transition: all 0.3s ease-in;
            }

            button#gdpr-cookie-advanced {
                background: <?php echo $styles['cookimize_customize_background_color'];?>;
                color: <?php echo $styles['cookimize_customize_font_color'];?>;
                font-size: <?php echo $styles['cookimize_button_font_size'];?>px;
            }

            button#gdpr-cookie-advanced:hover {
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message button:disabled {
                opacity: 0.3;
            }

            #gdpr-cookie-message input[type="checkbox"] {
                float: none;
                margin-top: 0;
                margin-right: 5px;
            }
            .cookimize-alternate-text {
                background-color: <?php echo $styles['cookimize_message_background_color'];?>;
                color: <?php echo $styles['cookimize_message_font_color'];?>;
                padding: 10px 15px;
                text-align: center;
                border-radius: 5px;
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.25);
            }
            .cookimize-alternate-text h5,  .cookimize-alternate-text p {
            margin:0px;
            }


        </style>

		<?php

	}


	/**
	 * update default styles if no styles set
	 */
	public function get_default_styles() {

		$styles = get_option( 'cookimize_style' );

		if ( ! is_array( $styles ) ) {

			$default_styles = array(
				'cookimize_headline_font_color'        => '#ffffff',
				'cookimize_headline_font_size'         => '20',
				'cookimize_message_position'           => 'bottom-right',
				'cookimize_message_background_color'   => '#a5b1c2',
				'cookimize_message_font_color'         => '#ffffff',
				'cookimize_message_font_size'          => '14',
				'cookimize_link_font_color'            => '#ffffff',
				'cookimize_accept_background_color'    => '#4b6584',
				'cookimize_accept_font_color'          => '#ffffff',
				'cookimize_customize_background_color' => '#ffffff',
				'cookimize_customize_font_color'       => '#4b6584',
				'cookimize_button_font_size'           => '12',

			);

			update_option( 'cookimize_style', $default_styles );

		}
	}

	/**
	 * update default settings if no options set
	 */
	public function get_default_settings() {

		$options = get_option( 'cookimize_options' );

		if ( ! is_array( $options ) ) {

			$default_options = array(
				'cookimize_cookie_message_headline' => 'Cookies & Privacy',
				'cookimize_cookie_message'          => 'This website uses cookies to ensure you get the best experience on our website.',
				'cookimize_seconds_before_trigger'  => 2,
				'cookimize_expiration_time'         => 1,
				'cookimize_select_privacy_page'     => 'yes',
				'cookimize_button_label'            => 'Accept Cookies',
				'cookimize_customize_label'         => 'Customize Cookies',
				'cookimize_select_privacy_slug'     => 'privacy',
				'cookimize_select_privacy_link'     => 'More information',
			);

			update_option( 'cookimize_options', $default_options );
		}

	}

	public function add_tracking_code() {

		if ( $_COOKIE['cookieControl'] === 'true' ) {

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
