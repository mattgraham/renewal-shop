<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options, $woocommerce;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'woothemes' ), max( $paged, $page ) );

	?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php
wp_head();
woo_head();
?>
</head>
<body <?php body_class(); ?>>
<?php woo_top(); ?>

<div id="wrapper">
	<div id="inner-wrapper">

    <?php woo_header_before(); ?>

    <div id="header-wrapper">

		<div class="wrapper">

			<header id="header">

					<?php woo_header_inside(); ?>

					<span class="nav-toggle"><a href="#navigation"><span><?php _e( 'Navigation', 'woothemes' ); ?></span></a></span>

				    <div class="site-header">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>

			        <?php woo_nav_before(); ?>

					<nav id="navigation" role="navigation">

						<section class="menus">

						<a href="<?php echo home_url(); ?>" class="nav-home"><span><?php _e( 'Home', 'woothemes' ); ?></span></a>

						<?php if ( is_woocommerce_activated() && isset( $woo_options['woocommerce_header_cart_link'] ) && 'true' == $woo_options['woocommerce_header_cart_link'] ) { ?>
				        	<h3><?php _e( 'Shopping Cart', 'woothemes' ); ?></h3>
				        	<ul class="nav cart">
				        		<li <?php if ( is_cart() ) { echo 'class="current-menu-item"'; } ?>>
				        			<?php woo_wc_cart_link(); ?>
				        		</li>
				       		</ul>
				        <?php }
						if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
							echo '<h3>' . woo_get_menu_name('primary-menu') . '</h3>';
							wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) );
						} else {
						?>
				        <ul id="main-nav" class="nav">
							<?php if ( is_page() ) $highlight = 'page_item'; else $highlight = 'page_item current_page_item'; ?>
							<li class="<?php echo $highlight; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
							<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
						</ul><!-- /#nav -->
				        <?php } ?>

				    	</section><!--/.menus-->

				        <a href="#top" class="nav-close"><span><?php _e('Return to Content', 'woothemes' ); ?></span></a>

					</nav><!-- /#navigation -->

					<?php woo_nav_after(); ?>

			</header><!-- /#header -->

		</div><!-- /.wrapper -->

	</div><!-- /#header-out -->

	<?php woo_content_before(); ?>