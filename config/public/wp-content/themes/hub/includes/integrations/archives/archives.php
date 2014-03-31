<?php
/**
 * Integrates this theme with the Archives plugin
 * http://wordpress.org/plugins/archives-by-woothemes/
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Styles
 */
function woo_archives_scripts() {
	wp_register_style( 'woo-archives-css', get_template_directory_uri() . '/includes/integrations/archives/css/archives.css' );
	wp_enqueue_style( 'woo-archives-css' );
}
add_action( 'wp_enqueue_scripts', 'woo_archives_scripts' );