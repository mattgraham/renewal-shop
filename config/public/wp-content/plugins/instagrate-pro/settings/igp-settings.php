<?php

global $wpsf_settings;
$plugin_l10n = 'instagrate-pro';

// General Settings section
$wpsf_settings[] = array(
    'section_id' => 'general',
    'section_title' => 'Global Settings',
    'section_order' => 1,
    'fields' => array(
        array(
            'id' => 'default-title',
            'title' => __( 'Default Title', $plugin_l10n ),
            'desc' => __( 'Enter a title for posts where the Instagram image has no title.', $plugin_l10n ),
            'type' => 'text',
            'std' => 'Instagram Image'
        ),
		array(
            'id' => 'bypass-home',
            'title' => __( 'Bypass is_home()', $plugin_l10n ),
            'desc' => __( 'Bypass is_home() check on posting. This should only be used if really necessary as it will make the plugin run on every page load.', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 0
        ),
		array(
            'id' => 'allow-duplicates',
            'title' => __( 'Allow Duplicate Images', $plugin_l10n ),
            'desc' => __( 'Allow posting of same image by different accounts', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 0
        ),
        array(
            'id' => 'location-distance',
            'title' => __( 'Instagram Location Distance', $plugin_l10n ),
            'desc' => __( 'Set the distance in metres of the location searching of Instagram locations.', $plugin_l10n ),
            'type' => 'select',
            'choices' => array('1000' => '1000', '2000' => '2000', '3000' => '3000', '4000' => '4000', '5000' => '5000'),
            'std' => 0
        ),
        array(
            'id' => 'admin-images',
            'title' => __( 'Images in Account Admin', $plugin_l10n ),
            'desc' => __( 'Set amount of images to show when the account is edited. This helps performance for accounts with a large number of images.', $plugin_l10n ),
            'type' => 'select',
            'choices' => array('' => 'All', '20' => '20', '40' => '40', '60' => '60', '80' => '80', '100' => '100'),
            'std' => ''
        ),
        array(
            'id' => 'credit-link',
            'title' => __( 'Link Love', $plugin_l10n ),
            'desc' => __( 'Check this to enable a credit link to the plugin page after images posted.', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 0
        ),
        array(
            'id' => 'cron-job',
            'title' => '<strong>'. __( 'Cron Job', $plugin_l10n ) .'</strong>',
            'desc' => '',
            'type' => 'custom',
            'std' => '<p>'. __( 'You can set up a UNIX Cron job on your server to post images from accounts with the Posting Frequency of Cron Job  using the this url:', $plugin_l10n ) .'</p><code>'.  get_admin_url() . 'admin-ajax.php?action=instagrate</code>'
        ),
    )
);

// Comments Settings section
$wpsf_settings[] = array(
    'section_id' => 'comments',
    'section_title' => 'Comments &amp; Likes',
    'section_order' => 1,
    'fields' => array(
		array(
            'id' => 'enable-comments',
            'title' => __( 'Enable Comments', $plugin_l10n ),
            'desc' => __( 'Enables Instagram comments imported as WordPress comments. <br><em>Only works if posts are created for each image, ie. the Multiple Images setting is set to "Post Per Image"</em>', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 0
        ),
		array(
            'id' => 'auto-approve',
            'title' => __( 'Automatically Approve Comments', $plugin_l10n ),
            'desc' => __( 'Enables the comments to be automatically approved in WordPress when imported from Instagram.', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 0
        ),
        array(
            'id' => 'avatar',
            'title' => __( 'Instagram Avatar', $plugin_l10n ),
            'desc' => __( 'Enables the use of the Instagram user\'s profile image as the comment author avatar image.', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 1
        ),
        array(
            'id' => 'mentions',
            'title' => __( 'Username Mentions', $plugin_l10n ),
            'desc' => __( 'Makes all mentions of an Instagram username in a comment into a link to their profile page on Instagram.', $plugin_l10n ),
            'type' => 'checkbox',
            'std' => 1
        ),
        array(
            'id' => 'likes',
            'title' =>  __( 'Likes', $plugin_l10n ),
            'desc' => '',
            'type' => 'custom',
            'std' => __( 'You can use the template tag %%likes%%, the shortcode [igp-likes], or the custom post meta \'ig_likes\' to display the Like count from Instagram.', $plugin_l10n )
        ),
        array(
            'id' => 'cron-sync',
            'title' => '<strong>'. __( 'Syncing', $plugin_l10n ) .'</strong>',
            'desc' => '',
            'type' => 'custom',
            'std' => __( 'You can synchronise the comments and likes from Instagram for a specific account by clicking on the buttons on the ', $plugin_l10n ) . '<a href="'.  get_admin_url() . 'edit.php?post_type=instagrate_pro">Instagrate Accounts page.</a>' .'
					<p>'. __( 'You can also set up a UNIX Cron job on your server to synchronise all comments and likes at a certain time interval, using the this url:', $plugin_l10n ) .'</p><code>'.  get_admin_url() . 'admin-ajax.php?action=instagram_sync</code>'
        ),
	)
);


// Support Settings section
$wpsf_settings[] = array(
    'section_id' => 'support',
    'section_title' => 'Support',
    'section_order' => 2,
    'fields' => array(
        array(
            'id' => 'debug-mode',
            'title' => __( 'Debug Mode', $plugin_l10n ),
            'desc' => __( 'Check this to enable debug mode for troubleshooting the plugin. The file debug.txt will be created in the plugin folder', $plugin_l10n ) .' - <a href="'. str_replace('settings/', '', plugin_dir_url( __FILE__ )) . 'debug.txt">debug.txt</a>',
            'type' => 'checkbox',
            'std' => 0
        ),
		array(
            'id' => 'send-debug',
            'title' => __( 'Send Debug File', $plugin_l10n ),
            'desc' => '',
            'type' => 'custom',
            'std' => '<p><input value="'. __( 'Send Debug', $plugin_l10n ) .'" class="button" type="button" id="igp-send-debug"></p>'. __( 'You can manually send the', $plugin_l10n ) .' <a href="'. str_replace('settings/', '', plugin_dir_url( __FILE__ )) . 'debug.txt">file</a> to <a href="mailto:support@polevaultweb.com">Support</a>'
        ),
		array(
            'id' => 'send-data',
            'title' => __( 'Send Install Data', $plugin_l10n ),
            'desc' => '',
            'type' => 'custom',
            'std' => __( 'If you have raised an issue with us please send the install data', $plugin_l10n ) .' -
					<p><input value="'. __( 'Send Data', $plugin_l10n ) .'" class="button" type="button" id="igp-send-data"></p>'
        ),
		array(
            'id' => 'useful-links',
            'title' => __( 'Useful Links', $plugin_l10n ),
            'desc' => '',
            'type' => 'custom',
            'std' => 'Website: <a href="http://www.instagrate.co.uk">Instagrate Pro</a><br />
            Support: <a href="http://www.polevaultweb.com/support/forum/instagrate-pro-plugin/">Support Forum</a><br />
            Changelog: <a href="http://www.instagrate.co.uk/category/release/">Changelog</a><br/><br/>
			<a target="_blank" title="Plugin by polevaultweb.com" href="http://www.polevaultweb.com/">
				<img width="190" alt="polevaultweb logo" src="'. str_replace('settings/', 'assets/img/', plugin_dir_url( __FILE__ )) . 'pvw_logo.png">
			</a><br/><br/>			
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.instagrate.co.uk" data-text="I\'m using the Instagrate Pro WordPress plugin" data-via="instagrate">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>'
        )
    )
);

?>