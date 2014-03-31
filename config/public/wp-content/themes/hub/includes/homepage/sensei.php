<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Sensei Component
 *
 * Display Sensei Featured Courses. Requires "Sensei" by WooThemes.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	$settings = array(
			'homepage_sensei_title' => __( 'Featured Courses', 'woothemes' ),
			'homepage_sensei_byline' => __( 'Learn', 'woothemes' )
		);

	$settings = woo_get_dynamic_values( $settings );

?>

<section id="sensei-featuredcourses" class="home-section">

	<div class="wrapper">

		<?php if ( ( '' != $settings['homepage_sensei_title'] ) || ( '' != $settings['homepage_sensei_byline'] ) ): ?>
		<header class="section-title">
			<?php if ( '' != $settings['homepage_sensei_byline'] ): ?><span class="heading"><?php echo stripslashes( esc_html( $settings['homepage_sensei_byline'] ) ); ?></span><?php endif; ?>
			<?php if ( '' != $settings['homepage_sensei_title'] ): ?><h1><?php echo stripslashes( esc_html( $settings['homepage_sensei_title'] ) ); ?></h1><?php endif; ?>
		</header>
		<?php endif; ?>

		<?php echo do_shortcode('[featuredcourses]'); ?>

	</div><!-- /.wrapper -->

</section><!-- /#our-team -->