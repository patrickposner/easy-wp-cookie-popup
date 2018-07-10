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

		$settings = new QS_Settings();

		/* Tab: shortcode */

		$settings->add_section(
			array(
				'id'    => 'cookster_shortcode',
				'title' => __( 'Shortcode', 'quick-orders-for-woocommerce' ),
			)
		);

		/* Tab: columns */

		$settings->add_section(
			array(
				'id'    => 'cookster_table_heads',
				'title' => __( 'Columns', 'quick-orders-for-woocommerce' ),
			)
		);

		/* thumbnail */
		$settings->add_field(
			'cookster_table_heads',
			array(
				'id'   => 'title_thumbnail',
				'type' => 'title',
				'name' => '<h3>' . __( 'Thumbnail', 'quick-orders-for-woocommerce' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookster_table_heads',
			array(
				'id'      => 'toggle_thumbnail',
				'type'    => 'toggle',
				'default' => 'on',
				'name'    => __( 'Activate', 'quick-orders-for-woocommerce' ),
			)
		);
		/* title */
		$settings->add_field(
			'cookster_table_heads',
			array(
				'id'   => 'title_title',
				'type' => 'title',
				'name' => '<h3>' . __( 'Title', 'quick-orders-for-woocommerce' ) . '</h3>',
			)
		);
		$settings->add_field(
			'cookster_table_heads',
			array(
				'id'      => 'toggle_title',
				'type'    => 'toggle',
				'default' => 'on',
				'name'    => __( 'Activate', 'quick-orders-for-woocommerce' ),
			)
		);

		/* Tab: documentation */

		$settings->add_section(
			array(
				'id'    => 'cookster_documentation',
				'title' => __( 'Documentation', 'quick-orders-for-woocommerce' ),
			)
		);
		$settings->add_field(
			'cookster_documentation',
			array(
				'id'   => 'documentation_shortcode',
				'type' => 'documentation',
				'name' => '<b>' . __( 'Shortcode', 'quick-orders-for-woocommerce' ) . '</b>',
				'desc' => __( 'To generate a product table on your page use the shortcode', 'quick-orders-for-woocommerce' ) . '<code>[cookster]</code>.',
			)
		);
		$settings->add_field(
			'cookster_documentation',
			array(
				'id'   => 'documentation_parameter',
				'type' => 'documentation',
				'name' => '<b>' . __( 'Parameter', 'quick-orders-for-woocommerce' ) . '</b>',
				'desc' => __( 'You can add the following parameters to your shortcode: <b>product_cat, product_tag, sku</b>. You can add this parameters to your shortcode like so:', 'quick-orders-for-woocommerce' ) . '<br><code>[cookster product_cat="hoodies"]</code>.',
			)
		);
		$settings->add_field(
			'cookster_documentation',
			array(
				'id'   => 'documentation_multi_parameter',
				'type' => 'documentation',
				'name' => '<b>' . __( 'Multiple parameter values', 'quick-orders-for-woocommerce' ) . '</b>',
				'desc' => __( 'You can add multiple parameter values like so:', 'quick-orders-for-woocommerce' ) . '<br><code>[cookster product_cat="hoodies,shirts,albums"]</code>.',
			)
		);
	}


	public function add_admin_scripts() {
		
		wp_enqueue_style( 'cookster-admin', COOKSTER_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'cookster-admin.css' );
		wp_enqueue_script( 'cookster-admin-js', COOKSTER_URL . '/assets/admin/cookster-admin.js', array( 'jquery' ), false );
	}


}