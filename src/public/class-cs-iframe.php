<?php

namespace cookimize;

class CS_Iframe {

	/**
	 * CS_Iframe constructor.
	 */
	public function __construct() {

		$tracking = get_option( 'cookimize_gdpr' );

		if ( is_null( $_COOKIE['cookieControl'] ) && $tracking['cookimize_toggle_iframes'] === 'on' ) {

			$cookie_preferences = json_decode( stripslashes( $_COOKIE['cookieControlPrefs'] ) );

			if ( ! is_array( $cookie_preferences ) || ! in_array( 'iframe', $cookie_preferences ) ) {

				add_filter( 'the_content', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'embed_oembed_html', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'widget_custom_html_content', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'acf/format_value/type=oembed', array( $this, 'search_frames' ), 100, 3 );
				add_filter( 'acf/format_value/type=textarea', array( $this, 'search_frames' ), 100, 3 );
			}
		}

	}

	/**
	 * return instance from class
	 */
	public static function get_instance() {
		new CS_Public();
	}


	/**
	 * @param $content
	 *
	 * @return null|string|string[]
	 */
	public function search_frames( $content ) {

		$content = preg_replace_callback( '/(\<p\>)?(<iframe.*<\/iframe>)+(\<\/p\>)?/', [
			$this,
			'replace_with_alternate_text'
		], $content );

		return $content;
	}

	/**
	 * @param $tags
	 *
	 * @return string
	 */
	public function replace_with_alternate_text( $tags ) {

		$tracking = get_option( 'cookimize_gdpr' );

		$src = [];

		preg_match( '/src=("|\')([^"\']{1,})(\1)/', $tags[2], $src );

		if ( ! empty( $src[2] ) || $src[2] !== 'about:blank' ) {

			$url = parse_url( $src[2] );

			if ( strpos( $url['host'], 'youtube.' ) !== false || strpos( $url['host'], 'youtu.be' ) !== false || strpos( $url['host'], 'youtube-nocookie.com' ) !== false ) {

				$iframe_type = 'YouTube';

			} elseif ( strpos( $url['host'], 'vimeo.com' ) !== false ) {

				$iframe_type = 'Vimeo';

			} elseif ( strpos( $url['host'], 'google' ) !== false && strpos( $url['path'], 'maps' ) !== false ) {

				$iframe_type = 'Google Maps';

			} else {
				$iframe_type = $url['host'];
			}

			return '<div class="cookimize-alternate-text" data-type="' . $iframe_type . '"><h5>' . __( 'Please accept our cookies', 'easy-wp-cookie-popup' ) . '</h5><p>' . $tracking['cookimize_iframe_alternate_content'] . '</p></div>';

		} else {

			return $tags[0];
		}

	}
}