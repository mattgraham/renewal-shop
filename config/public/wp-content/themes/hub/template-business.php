<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Business
 *
 * This template creates a business style page optionally including a slider, features and testimonials
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options, $wp_query;
 get_header();

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
                    'thumb_w' => 100,
                    'thumb_h' => 100,
                    'thumb_align' => 'alignleft',
                    'business_display_slider' => 'true',
                    'business_display_features' => 'true',
                    'business_display_testimonials' => 'true',
                    'business_display_blog' => 'true'
                    );

	$settings = woo_get_dynamic_values( $settings );
?>
    <!-- #content Starts -->
    <div id="content">

            <?php woo_main_before(); ?>

            <?php
                // Display WooSlider if activated and specified in theme options
                if ( 'true' == $settings['business_display_slider'] ) {
                ?>
                    <div id="business-slider">
                        <div class="wrapper">
                            <?php do_action( 'wooslider' ); ?>
                        </div><!-- /.wrapper -->
                    </div><!-- /#business-slider -->
                <?php
                }
                ?>
                <?php if (have_posts()) : $count = 0; ?>
                <?php while (have_posts()) : the_post(); $count++; ?>

                    <div <?php post_class( array( 'business-content' ) ); ?>>

                        <div class="wrapper">

                            <h1 class="title"><?php the_title(); ?></h1>

                            <div class="entry">
                                <?php the_content(); ?>
                            </div><!-- /.entry -->

                        </div><!-- /.wrapper -->

                    </div><!-- /.post -->


                <?php endwhile; else: ?>
                <?php endif; ?>
                <?php
                // Display Features if activated and specified in theme options
                if ( 'true' == $settings['business_display_features'] ) {
                ?>
                    <div id="business-features">
                        <div class="wrapper">
                            <?php
                                $args = array(
                                    'limit' => 3
                                );
                                do_action( 'woothemes_features', $args );
                            ?>
                        </div><!-- /.wrapper -->
                    </div><!-- /#business-features -->
                <?php
                }
                // Display Features if activated and specified in theme options
                if ( 'true' == $settings['business_display_testimonials'] ) {
                ?>
                    <div id="business-testimonials">
                        <div class="wrapper">
                    <?php
                        $args = array(
                            'per_row' => 3,
                            'limit' => 3
                        );
                        do_action( 'woothemes_testimonials', $args );
                    ?>
                        </div><!-- /.wrapper -->
                    </div><!-- /#business-testimonials -->
                <?php
                }
            ?>

            <?php if ( 'true' == $settings['business_display_blog'] ) { ?>

            <div class="wrapper">

                <section id="main">

        		<?php woo_loop_before(); ?>

                <?php
                    if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

                    $query_args     = array(
                                        'post_type' => 'post',
                                        'paged' => $paged
                                    );
                    $query_args     = apply_filters( 'woo_blog_template_query_args', $query_args ); // Do not remove. Used to exclude categories from displaying here.

                    $old_query      = $wp_query;
                    $query          = new WP_Query( $query_args );
                    $wp_query       = $query;

                    if ( $query->have_posts() ) {

                        $count = 0;

                        while ( $query->have_posts() ) {

                            $query->the_post();
                            $count++;

                            /* Include the Post-Format-specific template for the content.
                             * If you want to overload this in a child theme then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );

                        } // End WHILE Loop

                    } else {
                ?>

                    <article <?php post_class(); ?>>
                        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
                    </article><!-- /.post -->

                <?php } // End IF Statement ?>

                <?php woo_loop_after(); ?>

                <?php woo_pagenav(); ?>

                <?php wp_reset_postdata(); ?>

                <?php $wp_query = $old_query; ?>

                </section><!-- /#main -->

            </div><!-- /.wrapper -->

            <?php woo_main_after(); ?>

            <?php } ?>

    </div><!-- /#content -->

<?php get_footer(); ?>