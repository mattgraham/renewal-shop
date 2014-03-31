<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>

    <div id="content">

        <div class="wrapper">

        	<?php woo_main_before(); ?>

    		<section id="main">

    		<?php if (have_posts()) : $count = 0; ?>

                <header class="archive-header">

                <?php if (is_category()) { ?>
                    <span class="archive-rss"><?php $cat_id = get_cat_ID( single_cat_title( '', false ) ); echo '<a href="' . get_category_feed_link( $cat_id, '' ) . '">' . __( 'RSS feed for this section', 'woothemes' ) . '</a>'; ?></span>                
            		<h1><?php _e( 'Archive', 'woothemes' ); ?> | <?php single_cat_title( '', true ); ?></h1>
                <?php } elseif (is_day()) { ?>
                	<h1><?php _e( 'Archive', 'woothemes' ); ?> | <?php the_time( get_option( 'date_format' ) ); ?></h1>
                <?php } elseif (is_month()) { ?>
                	<h1><?php _e( 'Archive', 'woothemes' ); ?> | <?php the_time( 'F, Y' ); ?></h1>
                <?php } elseif (is_year()) { ?>
                	<h1><?php _e( 'Archive', 'woothemes' ); ?> | <?php the_time( 'Y' ); ?></h1>
                <?php } elseif (is_author()) { ?>
                	<h1><?php _e( 'Archive by Author', 'woothemes' ); ?></h1>
                <?php } elseif (is_tag()) { ?>
                	<h1><?php _e( 'Tag Archives:', 'woothemes' ); ?> <?php single_tag_title( '', true ); ?></h1>
                <?php } ?>

                <?php
                    // Display the description for this archive, if it's available.
                    woo_archive_description();
                ?>

                </header>

    	        <div class="fix"></div>

            	<?php woo_loop_before(); ?>

    			<?php /* Start the Loop */ ?>
    			<?php while ( have_posts() ) : the_post(); $count++; ?>

    				<?php
    					/* Include the Post-Format-specific template for the content.
    					 * If you want to overload this in a child theme then include a file
    					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
    					 */
    					get_template_part( 'content', get_post_format() );
    				?>

    			<?php endwhile; ?>

    	        <?php else: ?>

    	            <article <?php post_class(); ?>>
    	                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
    	            </article><!-- /.post -->

    	        <?php endif; ?>

    	        <?php woo_loop_after(); ?>

    			<?php woo_pagenav(); ?>

    		</section><!-- /#main -->

    		<?php woo_main_after(); ?>

            <?php get_sidebar(); ?>

        </div><!-- /.wrapper -->

    </div><!-- /#content -->

<?php get_footer(); ?>