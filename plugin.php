<?php
/* 	Plugin name:	Woocommerce Service Booking System
**	Description:	Enable visitors to book service through Woocommerce
**	Author:			Banglanfeng Pan
**	Version:		1.0
**	License:		GPLv2
**/

define( 'WSBS_PLUGIN_VERSION_NUMBER', '1.0' );

// Check if the WooCommerce plugin is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	load_plugin_textdomain( 'wsbs', false, dirname( plugin_basename( __FILE__ ) ) . '/language/' );

	function wsbs_woocommerce_calculator_form() {

		global $post, $woocommerce, $product;

		// Check if the calculator does exists
		$active = get_post_meta( $post->ID, "_calculatorscript_active", true );

		// if the calculator exists, enable the form
		if ( $active != 'no' && $active != null ) {
			wp_enqueue_script( 'jquery-ui-datepicker', plugins_url( '/script/jquery-ui.min.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'calculator-script', plugins_url( '/script/script.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ) );

			wp_enqueue_style( 'jquery-ui', "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css", '', '', false );
			wp_enqueue_style( 'qty-calculator', plugins_url( '/css/qty-calculator.css', __FILE__ ), '', '', false );
			wp_enqueue_style( 'qty-calculator', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', '', '', false );
			$calculatorValue = get_post_meta( $post->ID, "_calculatorscript_value", true );
			require_once 'template.php';
		}

		return false;
	}

	// Add the code above in front of the "add to cart" button
	add_action( 'woocommerce_before_add_to_cart_button', 'wsbs_woocommerce_calculator_form' );

	/*	New product tab
	**	Add a new custom tab to the admin screen, where the user can enable the calculator
	**
	**	@since 1.0
	*/
	function wqc_add_calculator_tab() {

		echo "<li class=\"calculator_tab\"><a href=\"#calculator_tab_data\">" . __( 'Calculator', 'wsbs' ) . "</a></li>";
	}

	// Add the new tab to WooCommerce
	add_action( 'woocommerce_product_write_panel_tabs', 'wsbs_add_calculator_tab' );

	/*	New product tab options
	**	Add options to the earlier registrered product tab
	**
	**	@since 1.0
	*/
	function wsbs_calculator_tab_options() {

		global $post, $woocommerce, $product;

		// Start a container
		echo "<div id=\"calculator_tab_data\" class=\"panel woocommerce_options_panel\">";

		// Boolean calculator
		woocommerce_wp_checkbox( array(
			                         'id'    => '_calculatorscript_active',
			                         'label' => __( 'Enable Calculator', 'wsbs' ),
			                         'value' => esc_attr( $post->_calculatorscript_active )
		                         )
		);

		// Calculator value
		woocommerce_wp_text_input( array(
			                           'id'          => '_calculatorscript_value',
			                           'label'       => __( 'Calculator value', 'wsbs' ),
			                           'description' => __( 'This package contains ... m<sup>2</sup> (e.g. 1.5)', 'woocommerce' ),
			                           'value'       => $post->_calculatorscript_value,
		                           )
		);

		// Close the container
		echo "</div>";
	}

	// Add the new options to the admin screen
	add_action( 'woocommerce_product_write_panels', 'wsbs_calculator_tab_options' );

	/*	Save data in post meta
	**	Store all data in the post_meta table
	**
	**	@since 1.0
	*/
	function wsbs_calculator_tab_save_data( $post_id ) {

		update_post_meta( $post_id, '_calculatorscript_active', ( isset( $_POST['_calculatorscript_active'] ) && $_POST['_calculatorscript_active'] ) ? 'yes' : 'no' );
		update_post_meta( $post_id, '_calculatorscript_value', $_POST['_calculatorscript_value'] );
	}

	// Save all data
	add_action( 'woocommerce_process_product_meta', 'wsbs_calculator_tab_save_data' );
}