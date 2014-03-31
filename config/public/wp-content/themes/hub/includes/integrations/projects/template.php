<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Before Content
 * Wraps all projects content in wrappers which match the theme markup
 * @since   1.0.0
 * @return  void
 * @uses  	woo_content_before(), woo_main_before()
 */
if ( ! function_exists( 'woo_projects_before_content' ) ) {
	function woo_projects_before_content() {
		?>
	    <div id="content" class="col-full">

	    	<div class="wrapper">

		        <!-- #main Starts -->
		        <?php woo_main_before(); ?>
		        <div id="main" class="col-left">

	    <?php
	} // End woo_projects_before_content()
}

/**
 * After Content
 * Closes the wrapping divs
 * @since   1.0.0
 * @return  void
 * @uses    woo_main_after(), do_action(), woo_content_after()
 */
if ( ! function_exists( 'woo_projects_after_content' ) ) {
	function woo_projects_after_content() {
		?>

				</div><!-- /#main -->
		        <?php woo_main_after(); ?>

		        <?php do_action( 'projects_sidebar' ); ?>

	        </div><!-- /.wrapper -->

	    </div><!-- /#content -->
	    <?php
	} // End woo_projects_after_content()
}

/**
 * Projects Pagination
 * Replaces Projects pagination with the function in the WooFramework
 * @uses  woo_projects_add_search_fragment()
 * @uses  woo_projects_pagination_defaults()
 * @uses  woo_pagination()
 */
if ( ! function_exists( 'woo_projects_pagination' ) ) {
	function woo_projects_pagination() {
		if ( is_search() && is_post_type_archive() ) {
			add_filter( 'woo_pagination_args', 			'woo_projects_add_search_fragment', 10 );
			add_filter( 'woo_pagination_args_defaults', 'woo_projects_pagination_defaults', 10 );
		}
		woo_pagination();
	} // End woo_projects_pagination()
}

/**
 * Search Fragment
 * @param  array $settings Fragments
 * @return array           Fragments
 */
if ( ! function_exists( 'woo_projects_add_search_fragment' ) ) {
	function woo_projects_add_search_fragment ( $settings ) {
		$settings['add_fragment'] = '&post_type=product';
		return $settings;
	} // End woo_projects_add_search_fragment()
}

/**
 * Pagination Defaults
 * @param  array $settings Settings
 * @return array           Settings
*/
if ( ! function_exists( 'woo_projects_pagination_defaults' ) ) {
	function woo_projects_pagination_defaults ( $settings ) {
		$settings['use_search_permastruct'] = false;
		return $settings;
	} // End woo_projects_pagination_defaults()
}