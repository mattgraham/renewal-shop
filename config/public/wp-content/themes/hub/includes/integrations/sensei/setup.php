<?php
/**
 * Integrates this theme with the Sensei plugin
 * http://www.woothemes.com/products/sensei/
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $woothemes_sensei;

/**
 * Styles
 * Disable stock sensei css and enqueue our own.
 */
add_filter( 'sensei_disable_styles', '__return_true' );
add_action( 'wp_enqueue_scripts', 'woo_sensei_css' );

/**
 * Wrappers
 * Remove default Sensei wrappers and replace with our own
 */
add_action( 'init', 'woo_sensei_remove_wrappers' );

add_action( 'sensei_before_main_content', 'woo_sensei_layout_wrap', 10 );
add_action( 'sensei_after_main_content', 'woo_sensei_layout_wrap_end', 10 );

add_action( 'sensei_before_main_content', 'woo_sensei_content_wrap', 14 );
add_action( 'sensei_after_main_content', 'woo_sensei_content_wrap_end', 8 );

/**
 * Pagination
 * Remove the Sensei pagination and add our own
 */
add_action( 'init', 'woo_sensei_remove_pagination' );
add_action( 'sensei_pagination', 'woo_sensei_pagination', 10 );

/**
 * Sensei
 * Remove the Sensei comments and add our own
 */
add_action( 'init', 'woo_sensei_remove_comments' );
add_action( 'woo_sensei_output_comments', array( $woothemes_sensei->frontend, 'sensei_output_comments' ), 10 );
add_filter( 'course_archive_title', 'woo_sensei_remove_featuredcourses_title' );