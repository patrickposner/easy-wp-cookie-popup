<?php

namespace cookster;

class CS_Iframe {

	public function __construct() {

		$tracking = get_option( 'cookster_gdpr' );

		if ( is_null( $_COOKIE['cookieControl'] ) && $tracking['cookster_toggle_iframes'] === 'on' ) {

			$cookie_preferences = json_decode( stripslashes( $_COOKIE['cookieControlPrefs'] ) );

			if ( is_array( $cookie_preferences ) && ! in_array( 'iframe', $cookie_preferences ) ) {

				add_filter( 'the_content', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'embed_oembed_html', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'widget_custom_html_content', array( $this, 'search_frames' ), 100, 1 );
				add_filter( 'acf/format_value/type=oembed', array( $this, 'search_frames' ), 100, 3 );
				add_filter( 'acf/format_value/type=textarea', array( $this, 'search_frames' ), 100, 3 );
			}
		}

	}

	public function search_frames( $content ) {

		$content = preg_replace_callback( '/(\<p\>)?(<iframe.*<\/iframe>)+(\<\/p\>)?/', [
			$this,
			'replace_with_alternate_text'
		], $content );

		return $content;
	}

	public function replace_with_alternate_text( $tags ) {

		$tracking = get_option( 'cookster_gdpr' );

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

			return '<div class="cookster-alternate-text" data-type="' . $iframe_type . '"><h5>' . __( 'Please accept our cookies', 'easy-wp-cookie-popup' ) . '</h5><p>' . $tracking['cookster_iframe_alternate_content'] . '</p></div>';

		} else {

			return $tags[0];
		}

	}
}