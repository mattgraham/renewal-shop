<?php
/**
 * Setup
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 						'woo_wc_css', 20 );
}

add_action( 'wp', 											'woo_wc_disable_css' );
add_action( 'after_setup_theme', 							'woocommerce_support' );

// Layout
remove_action( 'woocommerce_before_main_content', 			'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 			'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 				'woo_wc_before_content', 10 );
add_action( 'woocommerce_after_main_content', 				'woo_wc_after_content', 20 );
add_filter( 'body_class',									'woo_wc_layout_body_class', 10 );
add_action(	'woocommerce_before_shop_loop_item',			'woo_wc_before_shop_loop_item', 11 );
add_action(	'woocommerce_after_shop_loop_item',				'woo_wc_after_shop_loop_item', 11 );
remove_action( 'woocommerce_before_shop_loop_item_title', 	'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item', 			'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );


// Upsells
remove_action( 'woocommerce_after_single_product_summary', 	'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 	'woo_wc_upsell_display', 15 );

// Related Products
add_filter( 'woocommerce_output_related_products_args', 	'woo_wc_related_products' );

// Custom place holder
add_filter( 'woocommerce_placeholder_img_src', 				'woo_wc_placeholder_img_src' );

// Product columns
add_filter( 'loop_shop_columns', 							'woo_wc_loop_columns', 98 );

// Breadcrumb
remove_action( 'woocommerce_before_main_content', 			'woocommerce_breadcrumb', 20, 0 );

// Sidebar
remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 							'woo_wc_get_sidebar', 10 );

// Pagination / Search
remove_action( 'woocommerce_after_shop_loop', 				'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 					'woo_wc_pagination', 10 );

// Cart Fragments
add_filter( 'add_to_cart_fragments', 						'woo_wc_header_add_to_cart_fragment' );