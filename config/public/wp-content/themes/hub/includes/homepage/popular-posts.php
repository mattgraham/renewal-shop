<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Popular Posts Component
 *
 * Display X Popular Posts
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	$settings = array(
			'homepage_popular_posts_title' => __( 'Most Commented Articles', 'woothemes' ),
			'homepage_popular_posts_byline' => __( 'Popular Posts', 'woothemes' ),
			'homepage_popular_posts_number' => 3,
			'homepage_popular_posts_period' => 'week',

		);

	$settings = woo_get_dynamic_values( $settings );

?>

<section id="popular-posts" class="home-section">

	<div class="wrapper">

		<?php if ( ( '' != $settings['homepage_popular_posts_title'] ) || ( '' != $settings['homepage_popular_posts_byline'] ) ): ?>
		<header class="section-title">
			<?php if ( '' != $settings['homepage_popular_posts_byline'] ): ?><span class="heading"><?php echo stripslashes( esc_html( $settings['homepage_popular_posts_byline'] ) ); ?></span><?php endif; ?>
			<?php if ( '' != $settings['homepage_popular_posts_title'] ): ?><h1><?php echo stripslashes( esc_html( $settings['homepage_popular_posts_title'] ) ); ?></h1><?php endif; ?>
		</header>
		<?php endif; ?>

		<?php

			$limit = intval( $settings['homepage_popular_posts_number'] );
			$period = $settings['homepage_popular_posts_period'];

			$popular = woo_get_popular_posts( $period );

			$args = array(
						'orderby' => 'comment_count', 
						'post__in' => $popular,
						'posts_per_page' => $limit,
						'ignore_sticky_posts' => 1
					);

			$popular_posts = new WP_Query( $args );

		?>

		<?php if ( $popular_posts->have_posts() ) : ?>

			<ul>

			<?php while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); ?>

				<li <?php post_class(); ?>>
					<?php $image = woo_image( 'width=355&height=200&class=thumbnail&return=true' ); ?>
					<?php if ( '' != $image ): ?><div class="image-wrap"><?php endif; ?>
						<?php if ( '' != $image ) { echo $image; } ?>
						<a class="author-avatar" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><span><?php printf( esc_attr__( 'More by %s', 'woothemes' ), get_the_author() ); ?></span><?php echo get_avatar( get_the_author_meta('email'), '50' ); ?></a>
					<?php if ( '' != $image ): ?></div><?php endif; ?>
					<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<p class="meta"><span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span></p>
				</li>

			<?php endwhile; ?>

			</ul>

		<?php endif; ?>

	</div><!-- /.wrapper -->

</section><!-- /#popular-posts -->