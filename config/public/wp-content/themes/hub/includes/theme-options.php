<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if (!function_exists( 'woo_options')) {
function woo_options() {

// THEME VARIABLES
$themename = 'Hub';
$themeslug = 'hub';

// STANDARD VARIABLES. DO NOT TOUCH!
$shortname = 'woo';
$manualurl = 'http://www.woothemes.com/support/theme-documentation/'.$themeslug.'/';

//Access the WordPress Categories via an Array
$woo_categories = array();
$woo_categories_obj = get_categories( 'hide_empty=0' );
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, 'Select a category:' );

//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, 'Select a page:' );

//Stylesheets Reader
$alt_stylesheet_path = get_template_directory() . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, '.css') !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }
    }
}

// More Options
$slide_options = array();
$total_possible_slides = 10;
for ( $i = 1; $i <= $total_possible_slides; $i++ ) { $slide_options[] = $i; }

// Setup an array of slide-page terms for a dropdown.
$args = array( 'echo' => 0, 'hierarchical' => 1, 'taxonomy' => 'slide-page' );
$cats_dropdown = wp_dropdown_categories( $args );
$cats = array();

// Quick string hack to make sure we get the pages with the indents.
$cats_dropdown = str_replace( "<select name='cat' id='cat' class='postform' >", '', $cats_dropdown );
$cats_dropdown = str_replace( '</select>', '', $cats_dropdown );
$cats_split = explode( '</option>', $cats_dropdown );

$cats[] = __( 'Select a Slide Group:', 'woothemes' );

foreach ( $cats_split as $k => $v ) {
    $id = '';
    // Get the ID value.
    preg_match( '/value="(.*?)"/i', $v, $matches );

    if ( isset( $matches[1] ) ) {
        $id = $matches[1];
        $cats[$id] = trim( strip_tags( $v ) );
    }
}

$slide_groups = $cats;

// Below are the various theme options fields.
$options = array();
$other_entries = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19' );
$other_entries_multiples = array( '3' => '3', '6' => '6', '9' => '9', '12' => '12', '15' => '15' );

/* General */

$options[] = array( 'name' => __( 'General Settings', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'general' );

$options[] = array( 'name' => __( 'Quick Start', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Theme Stylesheet', 'woothemes' ),
    				'desc' => __( 'Select your themes alternative color scheme.', 'woothemes' ),
    				'id' => $shortname . '_alt_stylesheet',
    				'std' => 'default.css',
    				'type' => 'select',
    				'options' => $alt_stylesheets );

$options[] = array( 'name' => __( 'Custom Logo', 'woothemes' ),
    				'desc' => __( 'Upload a logo for your theme, or specify an image URL directly.', 'woothemes' ),
    				'id' => $shortname . '_logo',
    				'std' => '',
    				'type' => 'upload' );

$options[] = array( 'name' => __( 'Text Title', 'woothemes' ),
    				'desc' => sprintf( __( 'Enable text-based Site Title and Tagline. Setup title & tagline in %1$s.', 'woothemes' ), '<a href="' . esc_url( home_url() ) . '/wp-admin/options-general.php">' . __( 'General Settings', 'woothemes' ) . '</a>' ),
    				'id' => $shortname . '_texttitle',
    				'std' => 'false',
    				'class' => 'collapsed',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Site Title', 'woothemes' ),
    				'desc' => __( 'Change the site title typography.', 'woothemes' ),
    				'id' => $shortname . '_font_site_title',
    				'std' => array( 'size' => '36', 'unit' => 'px', 'face' => 'Droid Serif', 'style' => '', 'color' => '#333333' ),
    				'class' => 'hidden',
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Site Description', 'woothemes' ),
    				'desc' => __( 'Enable the site description/tagline under site title.', 'woothemes' ),
    				'id' => $shortname . '_tagline',
    				'class' => 'hidden',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Site Description', 'woothemes' ),
    				'desc' => __( 'Change the site description typography.', 'woothemes' ),
    				'id' => $shortname . '_font_tagline',
    				'std' => array( 'size' => '12', 'unit' => 'px', 'face' => 'Droid Sans', 'style' => '', 'color' => '#999999' ),
    				'class' => 'hidden last',
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Custom Favicon', 'woothemes' ),
    				'desc' => sprintf( __( 'Upload a 16px x 16px %1$s that will represent your website\'s favicon.', 'woothemes' ), '<a href="http://www.faviconr.com/">'.__( 'ico image', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_custom_favicon',
    				'std' => '',
    				'type' => 'upload' );

$options[] = array( 'name' => __( 'Tracking Code', 'woothemes' ),
    				'desc' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'woothemes' ),
    				'id' => $shortname . '_google_analytics',
    				'std' => '',
    				'type' => 'textarea' );

$options[] = array( 'name' => __( 'Subscription Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'RSS URL', 'woothemes' ),
    				'desc' => __( 'Enter your preferred RSS URL. (Feedburner or other)', 'woothemes' ),
    				'id' => $shortname . '_feed_url',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'E-Mail Subscription URL', 'woothemes' ),
    				'desc' => __( 'Enter your preferred E-mail subscription URL. (Feedburner or other)', 'woothemes' ),
    				'id' => $shortname . '_subscribe_email',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Display Options', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Custom CSS', 'woothemes' ),
    				'desc' => __( 'Quickly add some CSS to your theme by adding it to this block.', 'woothemes' ),
    				'id' => $shortname . '_custom_css',
    				'std' => '',
    				'type' => 'textarea' );

$options[] = array( 'name' => __( 'Post Content', 'woothemes' ),
    				'desc' => __( 'Select if you want to show the full content or the excerpt on posts.', 'woothemes' ),
    				'id' => $shortname . '_post_content',
    				'type' => 'select2',
    				'options' => array( 'excerpt' => __( 'The Excerpt', 'woothemes' ), 'content' => __( 'Full Content', 'woothemes' ) ) );

$options[] = array( 'name' => __( 'Post Author Box', 'woothemes' ),
    				'desc' => sprintf( __( 'This will enable the post author box on the single posts page. Edit description in %1$s.', 'woothemes' ), '<a href="' . esc_url( home_url() ) . '/wp-admin/profile.php">' . __( 'Profile', 'woothemes' ) . '</a>' ),
    				'id' => $shortname . '_post_author',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Display Breadcrumbs', 'woothemes' ),
    				'desc' => __( 'Display dynamic breadcrumbs on each page of your website.', 'woothemes' ),
    				'id' => $shortname . '_breadcrumbs_show',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Display Pagination', 'woothemes' ),
    				'desc' => __( 'Display pagination on the blog.', 'woothemes' ),
    				'id' => $shortname . '_pagenav_show',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Pagination Style', 'woothemes' ),
    				'desc' => __( 'Select the style of pagination you would like to use on the blog.', 'woothemes' ),
    				'id' => $shortname . '_pagination_type',
    				'type' => 'select2',
    				'options' => array( 'paginated_links' => __( 'Numbers', 'woothemes' ), 'simple' => __( 'Next/Previous', 'woothemes' ) ) );

/* Styling */

$options[] = array( 'name' => __( 'Styling', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'styling' );

$options[] = array( 'name' => __( 'Background', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Body Background Color', 'woothemes' ),
    				'desc' => __( 'Pick a custom color for background color of the theme e.g. #697e09', 'woothemes' ),
    				'id' => $shortname . '_body_color',
    				'std' => '',
    				'type' => 'color' );

$options[] = array( 'name' => __( 'Body background image', 'woothemes' ),
    				'desc' => __( 'Upload an image for the theme\'s background', 'woothemes' ),
    				'id' => $shortname . '_body_img',
    				'std' => '',
    				'type' => 'upload' );

$options[] = array( 'name' => __( 'Background image repeat', 'woothemes' ),
    				'desc' => __( 'Select how you would like to repeat the background-image', 'woothemes' ),
    				'id' => $shortname . '_body_repeat',
    				'std' => 'no-repeat',
    				'type' => 'select',
    				'options' => array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) );

$options[] = array( 'name' => __( 'Background image position', 'woothemes' ),
    				'desc' => __( 'Select how you would like to position the background', 'woothemes' ),
    				'id' => $shortname . '_body_pos',
    				'std' => 'top',
    				'type' => 'select',
    				'options' => array( 'top left', 'top center', 'top right', 'center left', 'center center', 'center right', 'bottom left', 'bottom center', 'bottom right' ) );

$options[] = array( 'name' => __( 'Background Attachment', 'woothemes' ),
    				'desc' => __( 'Select whether the background should be fixed or move when the user scrolls', 'woothemes' ),
    				'id' => $shortname.'_body_attachment',
    				'std' => 'scroll',
    				'type' => 'select',
    				'options' => array( 'scroll', 'fixed' ) );

$options[] = array( 'name' => __( 'Links', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Link Color', 'woothemes' ),
    				'desc' => __( 'Pick a custom color for links or add a hex color code e.g. #697e09', 'woothemes' ),
    				'id' => $shortname . '_link_color',
    				'std' => '',
    				'type' => 'color' );

$options[] = array( 'name' => __( 'Link Hover Color', 'woothemes' ),
    				'desc' => __( 'Pick a custom color for links hover or add a hex color code e.g. #697e09', 'woothemes' ),
    				'id' => $shortname . '_link_hover_color',
    				'std' => '',
    				'type' => 'color' );

$options[] = array( 'name' => __( 'Button Color', 'woothemes' ),
    				'desc' => __( 'Pick a custom color for buttons or add a hex color code e.g. #697e09', 'woothemes' ),
    				'id' => $shortname . '_button_color',
    				'std' => '',
    				'type' => 'color' );

/* Typography */

$options[] = array( 'name' => __( 'Typography', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'typography' );

$options[] = array( 'name' => __( 'Enable Custom Typography', 'woothemes' ) ,
    				'desc' => __( 'Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.', 'woothemes' ) ,
    				'id' => $shortname . '_typography',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'General Typography', 'woothemes' ) ,
    				'desc' => __( 'Change the general font.', 'woothemes' ) ,
    				'id' => $shortname . '_font_body',
    				'std' => array( 'size' => '1.4', 'unit' => 'em', 'face' => 'FontSiteSans-Roman', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Navigation', 'woothemes' ) ,
    				'desc' => __( 'Change the navigation font.', 'woothemes' ),
    				'id' => $shortname . '_font_nav',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'FontSiteSans-Cond', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Page Title', 'woothemes' ) ,
    				'desc' => __( 'Change the page title.', 'woothemes' ) ,
    				'id' => $shortname . '_font_page_title',
    				'std' => array( 'size' => '2.2', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Title', 'woothemes' ) ,
    				'desc' => __( 'Change the post title.', 'woothemes' ) ,
    				'id' => $shortname . '_font_post_title',
    				'std' => array( 'size' => '2.2', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Meta', 'woothemes' ),
    				'desc' => __( 'Change the post meta.', 'woothemes' ) ,
    				'id' => $shortname . '_font_post_meta',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Entry', 'woothemes' ) ,
    				'desc' => __( 'Change the post entry.', 'woothemes' ) ,
    				'id' => $shortname . '_font_post_entry',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Widget Titles', 'woothemes' ) ,
    				'desc' => __( 'Change the widget titles.', 'woothemes' ) ,
    				'id' => $shortname . '_font_widget_titles',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'FontSiteSans-Cond', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

/* Layout */

$options[] = array( 'name' => __( 'Layout', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'layout' );

$options[] = array( 'name' => __( 'Global Layout', 'woothemes' ),
                    'type' => 'subheading' );

$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( 'name' => __( 'Main Layout', 'woothemes' ),
    				'desc' => __( 'Select which layout you want for your site.', 'woothemes' ),
    				'id' => $shortname . '_site_layout',
    				'std' => 'layout-left-content',
    				'type' => 'images',
    				'options' => array(
    					'layout-left-content' => $url . '2cl.png',
    					'layout-right-content' => $url . '2cr.png' )
    				);

$options[] = array( 'name' => __( 'Business Template', 'woothemes' ),
					'type' => 'subheading' );
$options[] = array( 'name' => __( 'Display WooSlider', 'woothemes' ),
					'desc' => sprintf( __( 'Display a slider above the page content? Requires %sWooSlider%s plugin.', 'woothemes' ), '<a href="http://www.woothemes.com/products/wooslider/" title="' . __( 'Purchase WooSlider from WooThemes.com', 'woothemes' ) . '" target="_blank">', '</a>' ),
					'id' => $shortname . '_business_display_slider',
					'std' => 'true',
					'type' => 'checkbox' );
$options[] = array( 'name' => __( 'Display Features', 'woothemes' ),
					'desc' => sprintf( __( 'Display Features beneath the page content? Requires %sFeatures%s plugin.', 'woothemes' ), '<a href="http://wordpress.org/extend/plugins/features-by-woothemes/" title="' . __( 'Download \'Features by WooThemes\' from WordPress.org', 'woothemes' ) . '" target="_blank">', '</a>' ),
					'id' => $shortname . '_business_display_features',
					'std' => 'true',
					'type' => 'checkbox' );
$options[] = array( 'name' => __( 'Display Testimonials', 'woothemes' ),
					'desc' => sprintf( __( 'Display testimonials beneath the page content? Requires %sTestimonials%s plugin.', 'woothemes' ), '<a href="http://wordpress.org/extend/plugins/testimonials-by-woothemes/" title="' . __( 'Download \'Testimonials by WooThemes\' from WordPress.org', 'woothemes' ) . '" target="_blank">', '</a>' ),
					'id' => $shortname . '_business_display_testimonials',
					'std' => 'true',
					'type' => 'checkbox' );
$options[] = array( 'name' => __( 'Display latest blog posts and sidebar', 'woothemes' ),
					'desc' => __( 'Display your latest blog posts and primary sidebar beneath the business template content', 'woothemes' ),
					'id' => $shortname . '_business_display_blog',
					'std' => 'true',
					'type' => 'checkbox' );

/* Footer */

$options[] = array( 'name' => __( 'Footer', 'woothemes' ),
                    'type' => 'subheading' );

$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( 'name' => __( 'Footer Widget Areas', 'woothemes' ),
                    'desc' => __( 'Select how many footer widget areas you want to display.', 'woothemes' ),
                    'id' => $shortname . '_footer_sidebars',
                    'std' => '4',
                    'type' => 'images',
                    'options' => array(
                        '0' => $url . 'layout-off.png',
                        '1' => $url . 'footer-widgets-1.png',
                        '2' => $url . 'footer-widgets-2.png',
                        '3' => $url . 'footer-widgets-3.png',
                        '4' => $url . 'footer-widgets-4.png' )
                    );

$options[] = array( 'name' => __( 'Enable Custom Footer (Top)', 'woothemes' ),
                    'desc' => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
                    'id' => $shortname . '_footer_top',
                    'std' => 'false',
                    'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Custom Text (Top)', 'woothemes' ),
                    'desc' => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
                    'id' => $shortname . '_footer_top_text',
                    'std' => '',
                    'type' => 'textarea' );

$options[] = array( 'name' => __( 'Enable Custom Footer (Bottom)', 'woothemes' ),
                    'desc' => __( 'Activate to add the custom text below to the theme footer.', 'woothemes' ),
                    'id' => $shortname . '_footer_bottom',
                    'std' => 'false',
                    'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Custom Text (Bottom)', 'woothemes' ),
                    'desc' => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'woothemes' ),
                    'id' => $shortname . '_footer_bottom_text',
                    'std' => '',
                    'type' => 'textarea' );

/* Homepage */

$options[] = array( 'name' => __( 'Homepage', 'woothemes' ),
                    'icon' => 'homepage',
                    'type' => 'heading' );

$options[] = array( 'name' => __( 'Homepage Setup', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Enable Introductory Message', 'woothemes' ),
                    'desc' => __( 'Display the Introductory Message section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_intro_message',
                    'std' => 'true',
                    'type' => 'checkbox');

$options[] = array( 'name' => __( 'Enable Popular Posts', 'woothemes' ),
                    'desc' => __( 'Display the Popular Posts section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_popular_posts',
                    'std' => 'true',
                    'type' => 'checkbox');

$options[] = array( 'name' => __( 'Enable Testimonials', 'woothemes' ),
                    'desc' => __( 'Display the Testimonials section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_testimonials',
                    'std' => 'true',
                    'type' => 'checkbox');

if ( class_exists( 'Woothemes_Sensei' ) ) {
$options[] = array( 'name' => __( 'Enable Sensei - Featured Courses', 'woothemes' ),
                    'desc' => __( 'Display the Featured Courses section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_sensei',
                    'std' => 'true',
                    'type' => 'checkbox');
}

$options[] = array( 'name' => __( 'Enable Recent Posts', 'woothemes' ),
                    'desc' => __( 'Display the Recent Posts section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_recent_posts',
                    'std' => 'true',
                    'type' => 'checkbox');

$options[] = array( 'name' => __( 'Enable Our Team', 'woothemes' ),
                    'desc' => __( 'Display the Recent Posts section on the homepage.', 'woothemes' ),
                    'id' => $shortname . '_homepage_enable_our_team',
                    'std' => 'true',
                    'type' => 'checkbox');

/* Intro Message */

$options[] = array( 'name' => __( 'Introductory Message', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Introductory Message Heading', 'woothemes' ),
                    'desc' => __( 'Introductory message heading.', 'woothemes' ),
                    'id' => $shortname . '_homepage_intro_message_heading',
                    'std' => __('Welcome to Hub, a new WordPress theme by WooThemes', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Introductory Message Content', 'woothemes' ),
                    'desc' => __( 'Introductory message content', 'woothemes' ),
                    'id' => $shortname . '_homepage_intro_message_content',
                    'std' => __('This is your message content!', 'woothemes'),
                    'type' => 'textarea' );

$options[] = array( 'name' => __( 'Introductory Message Button Label', 'woothemes' ),
                    'desc' => __( 'Introductory Message Button Label', 'woothemes' ),
                    'id' => $shortname . '_homepage_intro_message_button_label',
                    'std' => __('Show me more', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Introductory Message Button URL', 'woothemes' ),
                    'desc' => __( 'Introductory Message Button URL', 'woothemes' ),
                    'id' => $shortname . '_homepage_intro_message_button_url',
                    'std' => '#',
                    'type' => 'text' );

/* Popular Posts */

$options[] = array( 'name' => __( 'Popular Posts', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Section Title', 'woothemes' ),
                    'desc' => __( 'Title for the Popular Posts section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_popular_posts_title',
                    'std' => __('Most Commented Posts', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Byline', 'woothemes' ),
                    'desc' => __( 'Byline for the Popular Posts section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_popular_posts_byline',
                    'std' => __('Popular Posts', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Period of Time', 'woothemes' ),
                    'desc' => __( 'Limit Popular Posts to a spefic period of time.', 'woothemes' ),
                    'id' => $shortname . '_homepage_popular_posts_period',
                    'std' => 'week',
                    'type' => 'select2',
                    'options' => array( 'week' => __( 'Last Week', 'woothemes' ), 'month' => __( 'Last Month', 'woothemes' ), 'year' => __( 'Last Year', 'woothemes' ) ) );

$options[] = array( 'name' => __( 'Number of Popular Posts', 'woothemes' ),
                    'desc' => __( 'Number of Popular Posts to display.', 'woothemes' ),
                    'id' => $shortname . '_homepage_popular_posts_number',
                    'std' => '3',
                    'type' => 'select2',
                    'options' => $other_entries_multiples );

/* Testimonials */

$options[] = array( 'name' => __( 'Testimonials', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Section Title', 'woothemes' ),
                    'desc' => __( 'Title for the Testimonials section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_testimonials_title',
                    'std' => __('What others are saying', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Byline', 'woothemes' ),
                    'desc' => __( 'Byline for the Testimonials section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_testimonials_byline',
                    'std' => __('Testimonials', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Background Image', 'woothemes' ),
                    'desc' => __( 'Upload a background image for this section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_testimonials_bg',
                    'std' => '',
                    'type' => 'upload' );

$options[] = array( 'name' => __( 'Number of Testimonials', 'woothemes' ),
                    'desc' => __( 'Number of Testimonials to display.', 'woothemes' ),
                    'id' => $shortname . '_homepage_testimonials_number',
                    'std' => '5',
                    'type' => 'select2',
                    'options' => $other_entries );

/* Sensei */

if ( class_exists( 'Woothemes_Sensei' ) ) {
$options[] = array( 'name' => __( 'Sensei', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Section Title', 'woothemes' ),
                    'desc' => __( 'Title for the Sensei section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_sensei_title',
                    'std' => __('Featured Courses', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Byline', 'woothemes' ),
                    'desc' => __( 'Byline for the Sensei section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_sensei_byline',
                    'std' => __('Learn', 'woothemes'),
                    'type' => 'text' );
}

/* Recent Posts */

$options[] = array( 'name' => __( 'Recent Posts', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Section Title', 'woothemes' ),
                    'desc' => __( 'Title for the Recent Posts section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_recent_posts_title',
                    'std' => __('From the Hub', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Byline', 'woothemes' ),
                    'desc' => __( 'Byline for the Recent Posts section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_recent_posts_byline',
                    'std' => __('Discover', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Number of Recent Posts', 'woothemes' ),
                    'desc' => __( 'Number of Recent Posts to display.', 'woothemes' ),
                    'id' => $shortname . '_homepage_recent_posts_number',
                    'std' => '9',
                    'type' => 'select2',
                    'options' => array( '6', '9', '12', '15', '18' ) );

/* Our Team */

$options[] = array( 'name' => __( 'Our Team', 'woothemes' ),
                    'type' => 'subheading' );

$options[] = array( 'name' => __( 'Section Title', 'woothemes' ),
                    'desc' => __( 'Title for the Our Team section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_our_team_title',
                    'std' => __('Who\'s Writing', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Section Byline', 'woothemes' ),
                    'desc' => __( 'Byline for the Our Team section.', 'woothemes' ),
                    'id' => $shortname . '_homepage_our_team_byline',
                    'std' => __('Our Team', 'woothemes'),
                    'type' => 'text' );

$options[] = array( 'name' => __( 'Number of Team Members', 'woothemes' ),
                    'desc' => __( 'Number of Team Members to display.', 'woothemes' ),
                    'id' => $shortname . '_homepage_our_team_number',
                    'std' => '5',
                    'type' => 'select2',
                    'options' => array( '5', '10', '15' ) );

/* WooCommerce */

if ( is_woocommerce_activated() ) {
    $options[] = array( 'name' => __( 'WooCommerce', 'woothemes' ),
    					'type' => 'heading',
    					'icon' => 'woocommerce' );

    $options[] = array( 'name' => __( 'Custom Placeholder', 'woothemes' ),
                        'desc' => __( 'Upload a custom placeholder to be displayed when there is no product image.', 'woothemes' ),
                        'id' => $shortname . '_placeholder_url',
                        'std' => '',
                        'type' => 'upload' );

    $options[] = array( 'name' => __( 'Header Cart Link', 'woothemes' ),
                        'desc' => __( 'Display a link to the cart in the main navigation', 'woothemes' ),
                        'id' => $shortname.'commerce_header_cart_link',
                        'std' => 'true',
                        'type' => 'checkbox' );

    $options[] = array( 'name' => __( 'Shop Archives Full Width', 'woothemes' ),
                        'desc' => __( 'Display the product archives in a full-width single column format? (The sidebar is removed).', 'woothemes' ),
                        'id' => $shortname.'commerce_archives_fullwidth',
                        'std' => 'true',
                        'type' => 'checkbox' );

    $options[] = array( 'name' => __( 'Product Details Full Width', 'woothemes' ),
                        'desc' => __( 'Display the product details in a full-width single column format? (The sidebar is removed).' ),
                        'id' => $shortname.'commerce_products_fullwidth',
                        'std' => 'false',
                        'type' => 'checkbox' );

}

/* Dynamic Images */

$options[] = array( 'name' => __( 'Dynamic Images', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'image' );

$options[] = array( 'name' => __( 'Resizer Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Dynamic Image Resizing', 'woothemes' ),
    				'desc' => '',
    				'id' => $shortname . '_wpthumb_notice',
					"std" => __( 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> (default) or <strong>TimThumb</strong>.', 'woothemes' ),
    				'type' => 'info' );

$options[] = array( 'name' => __( 'WP Post Thumbnail', 'woothemes' ),
    				'desc' => __( 'Use WordPress post thumbnail to assign a post thumbnail. Will enable the <strong>Featured Image panel</strong> in your post sidebar where you can assign a post thumbnail.', 'woothemes' ),
    				'id' => $shortname . '_post_image_support',
    				'std' => 'true',
    				'class' => 'collapsed',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'WP Post Thumbnail - Dynamic Image Resizing', 'woothemes' ),
    				'desc' => __( 'The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>', 'woothemes' ),
    				'id' => $shortname . '_pis_resize',
    				'std' => 'true',
    				'class' => 'hidden',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'WP Post Thumbnail - Hard Crop', 'woothemes' ),
    				'desc' => __( 'The post thumbnail will be cropped to match the target aspect ratio (only used if "Dynamic Image Resizing" is enabled).', 'woothemes' ),
    				'id' => $shortname . '_pis_hard_crop',
    				'std' => 'true',
    				'class' => 'hidden last',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'TimThumb', 'woothemes' ),
					"desc" => __( 'This will enable the <a href="http://code.google.com/p/timthumb/">TimThumb</a> (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel</strong>  below the post editor. Make sure your themes <em>cache</em> folder is writable. <a href="http://docs.woothemes.com/document/docs-featured-images/">Need help?</a>', 'woothemes' ),
    				'id' => $shortname . '_resize',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Automatic Image Thumbnail', 'woothemes' ),
    				'desc' => __( 'If no thumbnail is specified then the first uploaded image in the post is used.', 'woothemes' ),
    				'id' => $shortname . '_auto_img',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Thumbnail Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Thumbnail Image Dimensions', 'woothemes' ),
    				'desc' => __( 'Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.', 'woothemes' ),
    				'id' => $shortname . '_image_dimensions',
    				'std' => '',
    				'type' => array(
    					array(  'id' => $shortname . '_thumb_w',
    						'type' => 'text',
    						'std' => 825,
    						'meta' => __( 'Width', 'woothemes' ) ),
    					array(  'id' => $shortname . '_thumb_h',
    						'type' => 'text',
    						'std' => 350,
    						'meta' => __( 'Height', 'woothemes' ) )
    				) );

$options[] = array( 'name' => __( 'Thumbnail Alignment', 'woothemes' ),
    				'desc' => __( 'Select how to align your thumbnails with posts.', 'woothemes' ),
    				'id' => $shortname . '_thumb_align',
    				'std' => 'aligncenter',
    				'type' => 'select2',
    				'options' => array( 'alignleft' => __( 'Left', 'woothemes' ), 'alignright' => __( 'Right', 'woothemes' ), 'aligncenter' => __( 'Center', 'woothemes' ) ) );

$options[] = array( 'name' => __( 'Single Post - Show Thumbnail', 'woothemes' ),
    				'desc' => __( 'Show the thumbnail in the single post page.', 'woothemes' ),
    				'id' => $shortname . '_thumb_single',
    				'class' => 'collapsed',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Single Post - Thumbnail Dimensions', 'woothemes' ),
    				'desc' => __( 'Enter an integer value i.e. 250 for the image size. Max width is 576.', 'woothemes' ),
    				'id' => $shortname . '_image_dimensions',
    				'std' => '',
    				'class' => 'hidden last',
    				'type' => array(
    					array(  'id' => $shortname . '_single_w',
    						'type' => 'text',
    						'std' => 825,
    						'meta' => __( 'Width', 'woothemes' ) ),
    					array(  'id' => $shortname . '_single_h',
    						'type' => 'text',
    						'std' => 350,
    						'meta' => __( 'Height', 'woothemes' ) )
    				) );

$options[] = array( 'name' => __( 'Single Post - Thumbnail Alignment', 'woothemes' ),
    				'desc' => __( 'Select how to align your thumbnail with single posts.', 'woothemes' ),
    				'id' => $shortname . '_thumb_single_align',
    				'std' => 'aligncenter',
    				'type' => 'select2',
    				'class' => 'hidden',
    				'options' => array( 'alignleft' => __( 'Left', 'woothemes' ), 'alignright' => __( 'Right', 'woothemes' ), 'aligncenter' => __( 'Center', 'woothemes' ) ) );

$options[] = array( 'name' => __( 'Add Featured Image to RSS feed', 'woothemes' ),
    				'desc' => __( 'Add the featured image to your RSS feed', 'woothemes' ),
    				'id' => $shortname . '_rss_thumb',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Enable Lightbox', 'woothemes' ),
    				'desc' => __( 'Enable the PrettyPhoto lightbox script on images within your website\'s content.', 'woothemes' ),
    				'id' => $shortname . '_enable_lightbox',
    				'std' => 'false',
    				'type' => 'checkbox' );

/* Subscribe & Connect */

$options[] = array( 'name' => __( 'Subscribe & Connect', 'woothemes' ),
    				'type' => 'heading',
    				'icon' => 'connect' );

$options[] = array( 'name' => __( 'Setup', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Text', 'woothemes' ),
    				'desc' => __( 'Change the default text in this area.', 'woothemes' ),
    				'id' => $shortname . '_connect_content',
    				'std' => '',
    				'type' => 'textarea' );

$options[] = array( 'name' => __( 'Enable Related Posts', 'woothemes' ),
    				'desc' => __( 'Enable related posts in the subscribe area. Uses posts with the same <strong>tags</strong> to find related posts. Note: Will not show in the Subscribe widget.', 'woothemes' ),
    				'id' => $shortname . '_connect_related',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Subscribe Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Subscribe By E-mail ID (Feedburner)', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s for the e-mail subscription form.', 'woothemes' ), '<a href="http://www.woothemes.com/tutorials/how-to-find-your-feedburner-id-for-email-subscription/">'.__( 'Feedburner ID', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_newsletter_id',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Subscribe By E-mail to MailChimp', 'woothemes', 'woothemes' ),
    				'desc' => sprintf( __( 'If you have a MailChimp account you can enter the %1$s to allow your users to subscribe to a MailChimp List.', 'woothemes' ), '<a href="http://woochimp.heroku.com" target="_blank">'.__( 'MailChimp List Subscribe URL', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_mailchimp_list_url',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Connect Settings', 'woothemes' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Enable RSS', 'woothemes' ),
    				'desc' => __( 'Enable the subscribe and RSS icon.', 'woothemes' ),
    				'id' => $shortname . '_connect_rss',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Twitter URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.twitter.com/woothemes', 'woothemes' ), '<a href="http://www.twitter.com/">'.__( 'Twitter', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_twitter',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Facebook URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.facebook.com/woothemes', 'woothemes' ), '<a href="http://www.facebook.com/">'.__( 'Facebook', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_facebook',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'YouTube URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.youtube.com/woothemes', 'woothemes' ), '<a href="http://www.youtube.com/">'.__( 'YouTube', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_youtube',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Flickr URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.flickr.com/woothemes', 'woothemes' ), '<a href="http://www.flickr.com/">'.__( 'Flickr', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_flickr',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'LinkedIn URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.linkedin.com/in/woothemes', 'woothemes' ), '<a href="http://www.www.linkedin.com.com/">'.__( 'LinkedIn', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_linkedin',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Delicious URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.delicious.com/woothemes', 'woothemes' ), '<a href="http://www.delicious.com/">'.__( 'Delicious', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_delicious',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Google+ URL', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. https://plus.google.com/104560124403688998123/', 'woothemes' ), '<a href="http://plus.google.com/">'.__( 'Google+', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_googleplus',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Dribbble', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://dribbble.com/woothemes', 'woothemes' ), '<a href="http://dribbble.com/">'.__( 'Dribbble', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_dribbble',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Instagram', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://instagram.com/woothemes', 'woothemes' ), '<a href="http://instagram.com">'.__( 'Instagram', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_instagram',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Vimeo', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://vimeo.com/woothemes', 'woothemes' ), '<a href="http://vimeo.com/">'.__( 'Vimeo', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_vimeo',
    				'std' => '',
    				'type' => 'text' );

$options[] = array( 'name' => __( 'Pinterest', 'woothemes' ),
    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://pinterest.com/woothemes', 'woothemes' ), '<a href="http://pinterest.com/">'.__( 'Pinterest', 'woothemes' ).'</a>' ),
    				'id' => $shortname . '_connect_pinterest',
    				'std' => '',
    				'type' => 'text' );

/* Contact Template Settings */

$options[] = array( 'name' => __( 'Contact Page', 'woothemes' ),
					'icon' => 'maps',
				    'type' => 'heading');

$options[] = array( 'name' => __( 'Contact Information', 'woothemes' ),
					'type' => 'subheading');

$options[] = array( "name" => __( 'Contact Information Panel', 'woothemes' ),
					"desc" => __( 'Enable the contact information panel on your contact page template.', 'woothemes' ),
					"id" => $shortname."_contact_panel",
					"std" => "false",
					"class" => 'collapsed',
					"type" => "checkbox" );

$options[] = array( 'name' => __( 'Location Name', 'woothemes' ),
					'desc' => __( 'Enter the location name. Example: London Office', 'woothemes' ),
					'id' => $shortname . '_contact_title',
					'std' => '',
					'class' => 'hidden',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Location Address', 'woothemes' ),
					'desc' => __( "Enter your company's address", 'woothemes' ),
					'id' => $shortname . '_contact_address',
					'std' => '',
					'class' => 'hidden',
					'type' => 'textarea' );

$options[] = array( 'name' => __( 'Telephone', 'woothemes' ),
					'desc' => __( 'Enter your telephone number', 'woothemes' ),
					'id' => $shortname . '_contact_number',
					'std' => '',
					'class' => 'hidden',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Fax', 'woothemes' ),
					'desc' => __( 'Enter your fax number', 'woothemes' ),
					'id' => $shortname . '_contact_fax',
					'std' => '',
					'class' => 'hidden last',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Contact Form E-Mail', 'woothemes' ),
					'desc' => __( "Enter your E-mail address to use on the 'Contact Form' page Template.", 'woothemes' ),
					'id' => $shortname.'_contactform_email',
					'std' => '',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Enable Subscribe and Connect', 'woothemes' ),
					'desc' => __( 'Enable the subscribe and connect functionality on the contact page template', 'woothemes' ),
					'id' => $shortname.'_contact_subscribe_and_connect',
					'std' => 'false',
					'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Maps', 'woothemes' ),
					'type' => 'subheading');

$options[] = array( 'name' => __( 'Contact Form Google Maps Coordinates', 'woothemes' ),
					'desc' => sprintf( __( 'Enter your Google Map coordinates to display a map on the Contact Form page template and a link to it on the Contact Us widget. You can get these details from %1$s', 'woothemes' ), '<a href="http://itouchmap.com/latlong.html" target="_blank">Google Maps</a>' ),
					'id' => $shortname . '_contactform_map_coords',
					'std' => '',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Disable Mousescroll', 'woothemes' ),
					'desc' => __( 'Turn off the mouse scroll action for all the Google Maps on the site. This could improve usability on your site.', 'woothemes' ),
					'id' => $shortname . '_maps_scroll',
					'std' => '',
					'type' => 'checkbox');

$options[] = array( 'name' => __( 'Map Height', 'woothemes' ),
					'desc' => __( 'Height in pixels for the maps displayed on Single.php pages.', 'woothemes' ),
					'id' => $shortname . '_maps_single_height',
					'std' => '250',
					'type' => 'text');

$options[] = array( 'name' => __( 'Default Map Zoom Level', 'woothemes' ),
					'desc' => __( 'Set this to adjust the default in the post & page edit backend.', 'woothemes' ),
					'id' => $shortname . '_maps_default_mapzoom',
					'std' => '9',
					'type' => 'select2',
					'options' => $other_entries);

$options[] = array( 'name' => __( 'Default Map Type', 'woothemes' ),
					'desc' => __( 'Set this to the default rendered in the post backend.', 'woothemes' ),
					'id' => $shortname . '_maps_default_maptype',
					'std' => 'G_NORMAL_MAP',
					'type' => 'select2',
					'options' => array( 'G_NORMAL_MAP' => __( 'Normal', 'woothemes' ), 'G_SATELLITE_MAP' => __( 'Satellite', 'woothemes' ),'G_HYBRID_MAP' => __( 'Hybrid', 'woothemes' ), 'G_PHYSICAL_MAP' => __( 'Terrain', 'woothemes' ) ) );

$options[] = array( 'name' => __( 'Map Callout Text', 'woothemes' ),
					'desc' => __( 'Text or HTML that will be output when you click on the map marker for your location.', 'woothemes' ),
					'id' => $shortname . '_maps_callout_text',
					'std' => '',
					'type' => 'textarea');

// Add extra options through function
if ( function_exists( 'woo_options_add') )
	$options = woo_options_add($options);

if ( get_option( 'woo_template') != $options) update_option( 'woo_template',$options);
if ( get_option( 'woo_themename') != $themename) update_option( 'woo_themename',$themename);
if ( get_option( 'woo_shortname') != $shortname) update_option( 'woo_shortname',$shortname);
if ( get_option( 'woo_manual') != $manualurl) update_option( 'woo_manual',$manualurl);

// Woo Metabox Options
// Start name with underscore to hide custom key from the user
global $post;
$woo_metaboxes = array();

// Shown on both posts and pages


// Show only on specific post types or page

if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {

	// TimThumb is enabled in options
	if ( get_option( 'woo_resize') == 'true' ) {

		$woo_metaboxes[] = array (	'name' => 'image',
									'label' => __( 'Image', 'woothemes' ),
									'type' => 'upload',
									'desc' => __( 'Upload an image or enter an URL.', 'woothemes' ) );

		$woo_metaboxes[] = array (	'name' => '_image_alignment',
									'std' => __( 'Center', 'woothemes' ),
									'label' => __( 'Image Crop Alignment', 'woothemes' ),
									'type' => 'select2',
									'desc' => __( 'Select crop alignment for resized image', 'woothemes' ),
									'options' => array(	'c' => 'Center',
														't' => 'Top',
														'b' => 'Bottom',
														'l' => 'Left',
														'r' => 'Right'));
	// TimThumb disabled in the options
	} else {

		$woo_metaboxes[] = array (	'name' => '_timthumb-info',
									'label' => __( 'Image', 'woothemes' ),
									'type' => 'info',
									'desc' => sprintf( __( '%1$s is disabled. Use the %2$s panel in the sidebar instead, or enable TimThumb in the options panel.', 'woothemes' ), '<strong>'.__( 'TimThumb', 'woothemes' ).'</strong>', '<strong>'.__( 'Featured Image', 'woothemes' ).'</strong>' ) ) ;

	}

	$woo_metaboxes[] = array (  'name'  => 'embed',
					            'std'  => '',
					            'label' => __( 'Embed Code', 'woothemes' ),
					            'type' => 'textarea',
					            'desc' => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'woothemes' ) );

} // End post

$woo_metaboxes[] = array (	'name' => '_layout',
							'std' => 'normal',
							'label' => __( 'Layout', 'woothemes' ),
							'type' => 'images',
							'desc' => __( 'Select the layout you want on this specific post/page.', 'woothemes' ),
							'options' => array(
										'layout-default' => $url . 'layout-off.png',
										'layout-full' => get_template_directory_uri() . '/functions/images/' . '1c.png',
										'layout-left-content' => get_template_directory_uri() . '/functions/images/' . '2cl.png',
										'layout-right-content' => get_template_directory_uri() . '/functions/images/' . '2cr.png'));


if ( get_post_type() == 'slide' || ! get_post_type() ) {
        $woo_metaboxes[] = array (
                                    'name' => 'url',
                                    'label' => __( 'Slide URL', 'woothemes' ),
                                    'type' => 'text',
                                    'desc' => sprintf( __( 'Enter an URL to link the slider title to a page e.g. %s (optional)', 'woothemes' ), 'http://yoursite.com/pagename/' )
                                    );

        $woo_metaboxes[] = array (
                                    'name'  => 'embed',
                                    'std'  => '',
                                    'label' => __( 'Embed Code', 'woothemes' ),
                                    'type' => 'textarea',
                                    'desc' => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'woothemes' )
                                    );
} // End Slide

// Add extra metaboxes through function
if ( function_exists( 'woo_metaboxes_add' ) )
	$woo_metaboxes = woo_metaboxes_add( $woo_metaboxes );

if ( get_option( 'woo_custom_template' ) != $woo_metaboxes) update_option( 'woo_custom_template', $woo_metaboxes );

} // END woo_options()
} // END function_exists()

// Add options to admin_head
add_action( 'admin_head', 'woo_options' );

//Enable WooSEO on these Post types
$seo_post_types = array( 'post', 'page' );
define( 'SEOPOSTTYPES', serialize( $seo_post_types ));

//Global options setup
add_action( 'init', 'woo_global_options' );
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options;
	$woo_options = get_option( 'woo_options' );
}

?>
