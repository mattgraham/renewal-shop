<?php
/**
 * Integrates this theme with the Our Team plugin
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Styles
 */
function woo_our_team_scripts() {
	wp_register_style( 'woo-our-team-css', get_template_directory_uri() . '/includes/integrations/our-team/css/our-team.css' );
	wp_enqueue_style( 'woo-our-team-css' );
}
add_action( 'wp_enqueue_scripts', 'woo_our_team_scripts' );

function woo_our_team_template( $tpl ) {
	return $tpl = '<div itemscope itemtype="http://schema.org/Person" class="%%CLASS%%">%%AVATAR%% <div class="team-member-content">%%TITLE%% <div id="team-member-%%ID%%"  class="team-member-text" itemprop="description">%%TEXT%% %%AUTHOR%%</div></div></div>';
}
add_action( 'woothemes_our_team_item_template', 'woo_our_team_template' );

function woo_our_team_filter_content( $content ) {
	if ( !is_home() || !is_front_page() ) { return; }
	$content = woo_text_trim( $content, 12 );
	return $content;
}
add_action( 'woothemes_our_team_content', 'woo_our_team_filter_content' );