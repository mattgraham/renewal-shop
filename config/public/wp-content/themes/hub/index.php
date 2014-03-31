<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?><?php
/**
 * Index Template
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;


	$settings = array(
			'homepage_enable_intro_message' => true,
			'homepage_enable_popular_posts' => true,
			'homepage_enable_testimonials' => true,
			'homepage_enable_sensei' => true,
			'homepage_enable_recent_posts' => true,
			'homepage_enable_our_team' => true
		);

	$settings = woo_get_dynamic_values( $settings );

?>

    <div id="content">

    	<section id="homepage-content">

    		<?php

    			$homepage_sections = apply_filters('woo_homepage_order', array(
    				'intro-message',
    				'popular-posts',
    				'testimonials',
    				'sensei',
    				'recent-posts',
    				'our-team'
    			) );

    			// Include homepage sections
    			foreach ( $homepage_sections as $section ) {
    				if ( 'true' == $settings[ 'homepage_enable_' . str_replace( '-', '_', $section ) ] ) {
    					if ( $section == 'sensei' && !class_exists( 'Woothemes_Sensei' ) ) continue;
    					get_template_part( 'includes/homepage/' . $section );
    				}
    			}

    		?>

    	</section><!-- /#homepage-content -->

    </div><!-- /#content -->

<?php get_footer(); ?>