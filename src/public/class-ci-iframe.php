<?php

namespace cookii;

class CI_Iframe {

	/**
	 * B2B_Cookie_Consent_Iframe constructor.
	 */
	public function __construct() {

		if ( ! isset( $_COOKIE['cookieControl'] ) && 'on' === get_option( 'bm_cc_block_iframes', 'off' ) ) {
			add_filter( 'the_content', array( $this, 'search_frames' ), 100, 1 );
			add_filter( 'embed_oembed_html', array( $this, 'search_frames' ), 100, 1 );
			add_filter( 'widget_custom_html_content', array( $this, 'search_frames' ), 100, 1 );
			add_filter( 'acf/format_value/type=oembed', array( $this, 'search_frames' ), 100, 3 );
			add_filter( 'acf/format_value/type=textarea', array( $this, 'search_frames' ), 100, 3 );
		}
	}

	/**
	 * Return instance from class
	 */
	public static function get_instance() {
		new CI_Iframe();
	}


	/**
	 * Search for frame elements
	 *
	 * @param string $content the current content.
	 * @return string
	 */
	public function search_frames( $content ) {
		$content = preg_replace_callback( '/(\<p\>)?(<iframe.*<\/iframe>)+(\<\/p\>)?/', array( $this, 'replace_with_alternate_text' ), $content );
		return $content;
	}

	/**
	 * Replace tags in frames
	 *
	 * @param array $tags array of src attrivbutes.
	 * @return string
	 */
	public function replace_with_alternate_text( $tags ) {

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

			return '<div class="cookimize-alternate-text" data-type="' . $iframe_type . '"><h5>' . __( 'Please accept our cookies', 'b2b-market' ) . '</h5><p>' . get_option( 'bm_cc_iframe_alternative_text' ) . '</p></div>';

		} else {

			return $tags[0];
		}
	}
}
