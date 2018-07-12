<?php

namespace cookster;

class CS_Public {


	/**
	 * CS_Public constructor.
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'wp_head', array( $this, 'dynamic_styles' ) );
		add_action( 'init', array( $this, 'get_default_settings' ) );
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

		wp_enqueue_script( 'ihavecookies-js', COOKSTER_URL . '/assets/public/jquery.ihavecookies.min.js', array( 'jquery' ), false );
		wp_enqueue_script( 'cookster-cookie-js', COOKSTER_URL . '/assets/public/cookster-cookie.js', array( 'jquery' ), false );

		$settings = get_option( 'cookster_options' );

		/* todo: add and localize gdpr settings */

		wp_localize_script( 'cookster-cookie-js', 'cookster', array(
			'headline'          => $settings['cookster_cookie_message_headline'],
			'message'           => $settings['cookster_cookie_message'],
			'trigger_time'      => $settings['cookster_seconds_before_trigger'],
			'expiration_time'   => $settings['cookster_expiration_time'],
			'privacy_page'      => get_bloginfo( 'url' ) . DIRECTORY_SEPARATOR . $settings['cookster_select_privacy_slug'],
			'privacy_page_text' => $settings['cookster_select_privacy_link'],
			'accept'            => $settings['cookster_button_label'],
			'customize'         => $settings['cookster_customize_label'],
			'cookie_type_title' => __( 'Select cookies to accept', 'easy-wp-cookie-popup' )
		) );


	}

	/**
	 * adding dynamic styles for cookster
	 */
	public function dynamic_styles() {

		$styles = get_option( 'cookster_style' );
		$this->get_default_styles();
		?>

        <style>

            <?php

			/* message box position */

			switch ( $styles['cookster_message_position'] ) {
				case 'center': ?>
            #gdpr-cookie-message {
                position: fixed;
                width: 375px;
                height: 200px;
                background-color: <?php echo $styles['cookster_message_background_color'];?>;
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                background-color: <?php echo $styles['cookster_message_background_color'];?>;
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                background-color: <?php echo $styles['cookster_message_background_color'];?>;
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                background-color: <?php echo $styles['cookster_message_background_color'];?>;
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                background-color: <?php echo $styles['cookster_message_background_color'];?>;
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                color: <?php echo $styles['cookster_headline_font_color'];?>;
                font-size: <?php echo $styles['cookster_headline_font_size'];?>px;
                font-weight: 500;
                margin-bottom: 10px;
            }

            #gdpr-cookie-message h5 {
                color: <?php echo $styles['cookster_headline_font_color'];?>;
                font-size: calc(<?php echo $styles['cookster_headline_font_size'];?>px - 4px);
                font-weight: 500;
                margin-bottom: 10px;
            }

            #gdpr-cookie-message p, #gdpr-cookie-message ul {
                color: <?php echo $styles['cookster_message_font_color'];?>;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
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
                color: <?php echo $styles['cookster_link_font_color'];?>;
                text-decoration: none;
                font-size: <?php echo $styles['cookster_message_font_size'];?>px;
                padding-bottom: 2px;
                border-bottom: 1px dotted rgba(255, 255, 255, 0.75);
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message a:hover {
                color: white;
                border-bottom-color: <?php echo $styles['cookster_link_font_color'];?>;
                transition: all 0.3s ease-in;
            }

            #gdpr-cookie-message button {
                border: none;
                background: <?php echo $styles['cookster_accept_background_color'];?>;
                color: <?php echo $styles['cookster_accept_font_color'];?>;
                font-size: <?php echo $styles['cookster_button_font_size'];?>px;
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
                background: <?php echo $styles['cookster_customize_background_color'];?>;
                color: <?php echo $styles['cookster_customize_font_color'];?>;
                font-size: <?php echo $styles['cookster_button_font_size'];?>px;
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
        </style>

		<?php

	}


	/**
	 * update default styles if no styles set
	 */
	public function get_default_styles() {

		$styles = get_option( 'cookster_style' );

		if ( ! is_array( $styles ) ) {

			$default_styles = array(
				'cookster_headline_font_color'        => '#ffffff',
				'cookster_headline_font_size'         => '20',
				'cookster_message_position'           => 'bottom-right',
				'cookster_message_background_color'   => '#a5b1c2',
				'cookster_message_font_color'         => '#ffffff',
				'cookster_message_font_size'          => '14',
				'cookster_link_font_color'            => '#ffffff',
				'cookster_accept_background_color'    => '#4b6584',
				'cookster_accept_font_color'          => '#ffffff',
				'cookster_customize_background_color' => '#ffffff',
				'cookster_customize_font_color'       => '#4b6584',
				'cookster_button_font_size'           => '12',

			);

			update_option( 'cookster_style', $default_styles );

		}
	}

	/**
	 * update default settings if no options set
	 */
	public function get_default_settings() {

		$options = get_option( 'cookster_options' );

		if ( ! is_array( $options ) ) {

			$default_options = array(
				'cookster_cookie_message_headline' => 'Cookies & Privacy',
				'cookster_cookie_message'          => 'This website uses cookies to ensure you get the best experience on our website.',
				'cookster_seconds_before_trigger'  => 2,
				'cookster_expiration_time'         => 1,
				'cookster_select_privacy_page'     => 'yes',
				'cookster_button_label'            => 'Accept Cookies',
				'cookster_customize_label'         => 'Customize Cookies',
				'cookster_select_privacy_slug'     => 'privacy',
				'cookster_select_privacy_link'     => 'More information',
			);

			update_option( 'cookster_options', $default_options );
		}

	}

}