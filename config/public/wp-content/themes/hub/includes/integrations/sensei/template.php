<?php
/**
 * Sensei template functions
 */

if ( ! function_exists( 'woo_sensei_layout_wrap' ) ) {
	/**
	 * Open Sensei layout wrap
	 * Contains the entire sensei page
	 */
	function woo_sensei_layout_wrap() {
		echo '<div id="content" class="col-full"><div class="wrapper">';
	}
}

if ( ! function_exists( 'woo_sensei_layout_wrap_end' ) ) {
	/**
	 * Close Sensei layout wrap
	 * Contains the entire sensei page
	 */
	function woo_sensei_layout_wrap_end() {
		echo '</div></div>';
		do_action('woo_sensei_output_comments');
	}
}

if ( ! function_exists( 'woo_sensei_content_wrap' ) ) {
	/**
	 * Open Sensei content wrap
	 * Contains the sensei content and appends sidebar
	 */
	function woo_sensei_content_wrap() {
		echo '<section id="main" class="col-left">';
	}
}

if ( ! function_exists( 'woo_sensei_content_wrap_end' ) ) {
	/**
	 * Close Sensei content wrap
	 * Contains the sensei content and appends sidebar
	 */
	function woo_sensei_content_wrap_end() {
		echo '</section>';
		get_sidebar();
	}
}

if ( ! function_exists( 'woo_sensei_pagination' ) ) {
	/**
	 * Woo Sensei Pagination
	 * Replaces the standard Sensei archive pagination with woo_pagination();
	 */
	function woo_sensei_pagination() {
		global $wp_query, $woothemes_sensei;

		$paged 			= $wp_query->get( 'paged' );
		$course_page_id = intval( $woothemes_sensei->settings->settings[ 'course_page' ] );

		if ( ( is_post_type_archive( 'course' ) || ( is_page( $course_page_id ) ) ) && ( isset( $paged ) && 0 == $paged ) ) {
			// Silence
		} elseif( is_singular( 'course' ) ) {
			$woothemes_sensei->frontend->sensei_get_template( 'wrappers/pagination-posts.php' );
		} elseif( is_singular( 'lesson' ) ) {
			$woothemes_sensei->frontend->sensei_get_template( 'wrappers/pagination-lesson.php' );
		} elseif( is_singular( 'quiz' ) ) {
			$woothemes_sensei->frontend->sensei_get_template( 'wrappers/pagination-quiz.php' );
		} else {
			woo_pagination();
		}
	}
}

if ( ! function_exists( 'woo_sensei_remove_featuredcourses_title' ) ) {
	/**
	 * Remove Featured Courses title from shortcode in Homepage
	 */
	function woo_sensei_remove_featuredcourses_title( $html ) {
		global $shortcode_override;
		if ( 'featuredcourses' == $shortcode_override && ( is_home() || is_front_page() ) ) {
			$html = '';
		}
		return $html;
	}
}
