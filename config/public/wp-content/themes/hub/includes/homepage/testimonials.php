<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Testimonials Component
 *
 * Display Testimonials. Requires "Testimonials" by WooThemes.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	$settings = array(
			'homepage_testimonials_title' => __( 'What others are saying', 'woothemes' ),
			'homepage_testimonials_byline' => __( 'Testimonials', 'woothemes' ),
			'homepage_testimonials_number' => '5',
			'homepage_testimonials_bg' => ''
		);

	$settings = woo_get_dynamic_values( $settings );

	// Enqueue JavaScript
	wp_enqueue_script( 'testimonials' );

?>

<section id="testimonials" class="home-section">

	<div id="testimonials-holder">

		<?php
			$bg_style = '';
			if ( '' != $settings['homepage_testimonials_bg'] ) {
				$bg_img = esc_url( $settings['homepage_testimonials_bg'] );
				$bg_img = ' style="background-image:url(' . $bg_img . ');"';
			}
		?>

		<div id="testimonials-bg" data-stellar-background-ratio="0.5"<?php echo $bg_img; ?>></div><!-- /#testimonials-bg -->

		<div class="wrapper">

			<?php if ( ( '' != $settings['homepage_testimonials_title'] ) || ( '' != $settings['homepage_testimonials_byline'] ) ): ?>
			<header class="section-title">
				<?php if ( '' != $settings['homepage_testimonials_byline'] ): ?><span class="heading"><?php echo stripslashes( esc_html( $settings['homepage_testimonials_byline'] ) ); ?></span><?php endif; ?>
				<?php if ( '' != $settings['homepage_testimonials_title'] ): ?><h1><?php echo stripslashes( esc_html( $settings['homepage_testimonials_title'] ) ); ?></h1><?php endif; ?>
			</header>
			<?php endif; ?>

			<?php
				// (ADD) Custom Template - Slider Navigation 
				add_filter('woothemes_testimonials_item_template', 'woo_homepage_testimonials_slider_nav');

				// Output Slider Navigation
				$args = array(
					'before' => '<div class="slide-nav">',
					'after' => 	'</div>',
					'limit' => 	intval( $settings['homepage_testimonials_number'] ),
					'size' => 	65
				);

				do_action( 'woothemes_testimonials', $args );

				// (REMOVE) Custom Template - Slider Navigation
				remove_filter('woothemes_testimonials_item_template', 'woo_homepage_testimonials_slider_nav');
				// (ADD) Custom Template - Slider Content 
				add_filter('woothemes_testimonials_item_template', 'woo_homepage_testimonials_slider_content');		

				// Output Slider Content
				$args = array(
					'before' => '<div class="slides">',
					'after' => 	'</div>',
					'limit' => 	intval( $settings['homepage_testimonials_number'] )
				);

				do_action( 'woothemes_testimonials', $args );

				// (REMOVE) Custom Template - Slider Content 
				remove_filter('woothemes_testimonials_item_template', 'woo_homepage_testimonials_slider_content');		
			?>

		</div><!-- /.wrapper -->

	</div><!-- /.testimonials-holder -->

</section><!-- /#our-team -->