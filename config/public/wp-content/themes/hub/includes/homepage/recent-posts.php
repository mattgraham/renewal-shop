<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Recent Posts Component
 *
 * Display X Recent Posts
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	$settings = array(
			'homepage_recent_posts_title' => __( 'From the Hub', 'woothemes' ),
			'homepage_recent_posts_byline' => __( 'Discover', 'woothemes' ),
			'homepage_recent_posts_number' => 9,
		);

	$settings = woo_get_dynamic_values( $settings );

	// Enqueue JavaScript
	wp_enqueue_script( 'recent-posts' );

?>

<section id="recent-posts" class="home-section">

	<div class="wrapper">

		<?php if ( ( '' != $settings['homepage_recent_posts_title'] ) || ( '' != $settings['homepage_recent_posts_byline'] ) ): ?>
		<header class="section-title">
			<?php if ( '' != $settings['homepage_recent_posts_byline'] ): ?><span class="heading"><?php echo stripslashes( esc_html( $settings['homepage_recent_posts_byline'] ) ); ?></span><?php endif; ?>
			<?php if ( '' != $settings['homepage_recent_posts_title'] ): ?><h1><?php echo stripslashes( esc_html( $settings['homepage_recent_posts_title'] ) ); ?></h1><?php endif; ?>
		</header>
		<?php endif; ?>

		<div id="featured-slider" class="flexslider">

		<?php

			$args = array(
						'posts_per_page' => intval( $settings['homepage_recent_posts_number'] ),
						'ignore_sticky_posts' => 1
					);

			$recent_posts = new WP_Query( $args );

		?>

		<?php if ( $recent_posts->have_posts() ) : ?>

			<ul class="slides">

			<?php $count = 0; while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); $count++; ?>

				<li id="slide-<?php echo $count - 1; ?>">
					<article <?php post_class(); ?>>
						<header>
							<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							<?php woo_post_meta(); ?>
						</header>

						<?php woo_image( 'width=760&height=300&class=thumbnail aligncenter' ); ?>

						<?php the_excerpt(); ?>

						<footer class="post-more">
							<a class="button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Read More', 'woothemes' ); ?>"><?php _e( 'Read More', 'woothemes' ); ?></a>
						</footer>						

					</article>
				</li>

			<?php endwhile; ?>

			</ul>

		<?php endif; ?>

		</div><!-- /#featured-slider -->

		<?php if ( $recent_posts->have_posts() ) : ?>
		<div id="featured-slider-pagination">

			<button type="button" id="prev" class="disabled"></button>
			<ul id="carousel-items">
			<?php $count = 0; while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); $count++; ?>

				<li<?php if ( $count == 3 ): ?> class="last"<?php endif; ?>>
					<a href="#slide-<?php echo $count - 1; ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"<?php if ( $count == 1 ): ?> class="active"<?php endif; ?>>
						<?php echo get_avatar( get_the_author_meta('email'), '80' ); ?>
						<div class="details">
							<h3><?php the_title(); ?></h3>
							<p class="meta"><span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span></p>
						</div>
					</a>
				</li>

			<?php endwhile; ?>
			</ul>
			<button type="button" id="next"<?php if ( $count <= 3 ): ?> class="disabled"<?php endif; ?>></button>
		</div><!-- /#featured-slider-pagination -->
		<?php endif; ?>

	</div><!-- /.wrapper -->

</section><!-- /#recent-posts -->