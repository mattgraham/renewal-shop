<?php
/**
 * Plugin Name: WooCommerce Authorize.net AIM Gateway
 * Plugin URI: http://www.woothemes.com/products/authorize-net-payment-gateway/
 * Description: Adds the Authorize.net AIM Payment Gateway to your WooCommerce site
 * Author: SkyVerge
 * Author URI: http://www.skyverge.com
 * Version: 2.0.8
 * Text Domain: wc-authorize-net
 * Domain Path: /languages/
 *
 * Copyright: (c) 2011-2013 SkyVerge, Inc. (info@skyverge.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   WC-Authorize-Net-AIM
 * @author    SkyVerge
 * @Category  Payment-Gateways
 * @copyright Copyright (c) 2011-2013, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '1a345d194a0d01e903f7a1363b6c86d2', '18598' );

add_action('plugins_loaded', 'woocommerce_authorize_net_init', 0);

function woocommerce_authorize_net_init() {

	if (!class_exists('WC_Payment_Gateway')) return;

	if(!defined('AUTHORIZE_DIR')) {
		define('AUTHORIZE_DIR', plugin_dir_path('', __FILE__ ) . '/');
	}
	if(!defined('AUTHORIZE_URL')) {
		define('AUTHORIZE_URL', plugins_url( '' , __FILE__ ) . '/' );
	}

	include_once( 'classes/class-wc-gateway-authorize-net.php' );

	/**
	 * Add the gateway to woocommerce
	 **/
	function add_authorize_gateway( $methods ) {
		$methods[] = 'WC_Authorize_Net';
		return $methods;
	}

	add_filter('woocommerce_payment_gateways', 'add_authorize_gateway' );
}


function load_authorize_net_translation() {

	load_plugin_textdomain( 'wc-authorize-net', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Load translation files
add_action( 'init', 'load_authorize_net_translation' );
