<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'woothemes_add_javascript' ); }

if ( ! function_exists( 'woothemes_add_javascript' ) ) {
	function woothemes_add_javascript() {
		global $woo_options;

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register scripts
		wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/includes/js/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.3' );
		wp_register_script( 'enable-lightbox', get_template_directory_uri() . '/includes/js/enable-lightbox.js', array( 'jquery', 'prettyPhoto' ) );
		wp_register_script( 'google-maps', 'http://maps.google.com/maps/api/js?sensor=false' );
		wp_register_script( 'google-maps-markers', get_template_directory_uri() . '/includes/js/markers.js' );
		wp_register_script( 'flexslider', get_template_directory_uri() . '/includes/js/jquery.flexslider' . $suffix . '.js', array( 'jquery' ), '2.1' );
		wp_register_script( 'jquery-waypoints', get_template_directory_uri() . '/includes/js/waypoints' . $suffix . '.js', array( 'jquery' ), '2.0.3' );
		wp_register_script( 'jquery-stellar', get_template_directory_uri() . '/includes/js/jquery.stellar' . $suffix . '.js', array( 'jquery' ), '2.0.3' );
		wp_register_script( 'recent-posts', get_template_directory_uri() . '/includes/js/recent-posts.js', array( 'jquery' , 'flexslider' ) );
		wp_register_script( 'testimonials', get_template_directory_uri() . '/includes/js/testimonials.js', array( 'jquery' , 'flexslider' ) );

		// Enqueue third party scripts
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/includes/js/fitvids' . $suffix . '.js', array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/includes/js/modernizr' . $suffix . '.js', array( 'jquery' ), '2.6.2' );
		wp_enqueue_script( 'doubleTapToGo', get_template_directory_uri() . '/includes/js/jquery.doubleTapToGo' . $suffix . '.js', array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'jquery-waypoints', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-stellar', array( 'jquery' ) );

		// Enqueue scripts
		wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery' ) );

		if ( apply_filters( 'hub_recent_posts_js', false ) ) {
			wp_enqueue_script( 'recent-posts' );
		}

		if ( apply_filters( 'hub_testimonials_js', false ) ) {
			wp_enqueue_script( 'testimonials' );
		}

		// Load Google Script on Contact Form Page Template
		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script( 'google-maps' );
			wp_enqueue_script( 'google-maps-markers' );
		} // End If Statement

		do_action( 'woothemes_add_javascript' );
	} // End woothemes_add_javascript()
}

if ( ! is_admin() ) { add_action( 'wp_print_styles', 'woothemes_add_css' ); }

if ( ! function_exists( 'woothemes_add_css' ) ) {
	function woothemes_add_css () {
		wp_register_style( 'prettyPhoto', get_template_directory_uri().'/includes/css/prettyPhoto.css' );

		do_action( 'woothemes_add_css' );
	} // End woothemes_add_css()
}

// Add an HTML5 Shim
add_action( 'wp_head', 'html5_shim' );

if ( ! function_exists( 'html5_shim' ) ) {
	function html5_shim() {
		?>
<!--[if lt IE 9]>
<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
		<?php
	} // End html5_shim()
}

?>