<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
					'thumb_single' => 'false',
					'single_w' => 200,
					'single_h' => 200,
					'thumb_single_align' => 'alignright'
					);

	$settings = woo_get_dynamic_values( $settings );
?>

    <div id="content">

    	<div class="wrapper">

	    	<?php woo_main_before(); ?>

			<section id="main" class="fullwidth">

	        <?php
	        	if ( have_posts() ) { $count = 0;
	        		while ( have_posts() ) { the_post(); $count++;
	        ?>

	        	<?php woo_post_author(); ?>

				<article <?php post_class(); ?>>

	                <header>

		                <h1><?php the_title(); ?></h1>

	                	<?php woo_post_meta(); ?>

	                </header>

					<?php echo woo_embed( 'width=580' ); ?>
	                <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>

	                <section class="entry fix">
	                	<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
					</section>

					<?php the_tags( '<p class="tags">', '', '</p>' ); ?>

	            </article><!-- .post -->

		        <?php woo_postnav(); ?>

	            <?php

					} // End WHILE Loop
				} else {
			?>
				<article <?php post_class(); ?>>
	            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
				</article><!-- .post -->
	       	<?php } ?>

			</section><!-- #main -->

			<?php woo_main_after(); ?>

        </div><!-- /.wrapper -->

        <?php comments_template(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>