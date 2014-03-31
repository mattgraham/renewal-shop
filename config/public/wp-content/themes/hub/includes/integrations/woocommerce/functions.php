<?php
/**
 * Functions
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Compatibility
 * Declare WooCommerce support
 */
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/*-----------------------------------------------------------------------------------*/
/* Styles
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_css' ) ) {
	/**
	 * WooCommerce Styles
	 * Enqueue WooCommerce styles
	 */
	function woo_wc_css () {
		wp_register_style( 'woocommerce', esc_url( get_template_directory_uri() . '/includes/integrations/woocommerce/css/woocommerce.css' ) );
		wp_enqueue_style( 'woocommerce' );
	} // End woo_wc_css()
}

if ( ! function_exists( 'woo_wc_disable_css' ) ) {
	function woo_wc_disable_css() {
		/**
		 * Disable WooCommerce styles
		 */
		if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
			// WooCommerce 2.1 or above is active
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
		} else {
			// WooCommerce is less than 2.1
			define( 'WOOCOMMERCE_USE_CSS', false );
		}
	}
}


/*-----------------------------------------------------------------------------------*/
/* Cart Fragment
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_header_add_to_cart_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @param  array $fragments Fragments to refresh via AJAX
	 * @return array            Fragments to refresh via AJAX
	 */
	function woo_wc_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		woo_wc_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	} // End woo_wc_header_add_to_cart_fragment()
}