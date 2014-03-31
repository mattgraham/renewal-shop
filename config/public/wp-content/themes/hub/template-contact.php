<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Contact Form
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */

global $woo_options;
get_header();

$nameError = '';
$emailError = '';
$commentError = '';
$mathCheck = '';

//If the form is submitted
if( isset( $_POST['submitted'] ) ) {

	//Check to see if the honeypot captcha field was filled in
	if( trim( $_POST['checking'] ) !== '' ) {
		$captchaError = true;
	} else {

		// Check math field
		if( $_POST['mathCheck'] != 9 && strcasecmp( trim( $_POST['mathCheck'] ), 'nine' ) != 0  ) {
			$mathCheck = __( 'You got the maths wrong.', 'woothemes' );
			$hasError = true;
		} else {
			$math = trim( $_POST['mathCheck'] );
		}

		//Check to make sure that the name field is not empty
		if( trim( $_POST['contactName'] ) === '' ) {
			$nameError =  __( 'You forgot to enter your name.', 'woothemes' );
			$hasError = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}

		//Check to make sure sure that a valid email address is submitted
		if( trim( $_POST['email'] ) === '' )  {
			$emailError = __( 'You forgot to enter your email address.', 'woothemes' );
			$hasError = true;
		} else if ( ! eregi( "^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email'] ) ) ) {
			$emailError = __( 'You entered an invalid email address.', 'woothemes' );
			$hasError = true;
		} else {
			$email = trim( $_POST['email'] );
		}

		//Check to make sure comments were entered
		if( trim( $_POST['comments'] ) === '' ) {
			$commentError = __( 'You forgot to enter your comments.', 'woothemes' );
			$hasError = true;
		} else {
			$comments = stripslashes( trim( $_POST['comments'] ) );
		}

		//If there is no error, send the email
		if( ! isset( $hasError ) ) {

			$emailTo = get_option( 'woo_contactform_email' );
			$subject = sprintf( __( 'Contact Form Submission from %s', 'woothemes' ), esc_html( $name ) );
			$sendCopy = trim( $_POST['sendCopy'] );
			$body = __( "Name: $name \n\nEmail: $email \n\nComments: $comments", 'woothemes' );
			$headers = __( 'From: ', 'woothemes') . "$name <$email>" . "\r\n" . __( 'Reply-To: ', 'woothemes' ) . $email;

			wp_mail( $emailTo, $subject, $body, $headers );

			if( $sendCopy == true ) {
				$subject = __( 'You emailed ', 'woothemes' ) . stripslashes( get_bloginfo( 'title' ) );
				$headers = __( 'From: ', 'woothemes' ) . "$name <$emailTo>";
				wp_mail( $email, $subject, $body, $headers );
			}

			$emailSent = true;

		}
	}
}
?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery(document).ready(function() {
	jQuery( 'form#contactForm').submit(function() {
		jQuery( 'form#contactForm .error').remove();
		var hasError = false;
		jQuery( '.requiredField').each(function() {
			if(jQuery(this).hasClass('math')) {
				if( jQuery.trim(jQuery(this).val()) != 9 && jQuery.trim(jQuery(this).val()).toLowerCase() != 'nine' ) {
					jQuery(this).parent().append( '<span class="error"><?php _e( 'You got the maths wrong', 'woothemes' ); ?>.</span>' );
					jQuery(this).addClass( 'inputError' );
					hasError = true;
				}
			} else {
				if(jQuery.trim(jQuery(this).val()) == '') {
					var labelText = jQuery(this).prev( 'label').text();
					jQuery(this).parent().append( '<span class="error"><?php _e( 'You forgot to enter your', 'woothemes' ); ?> '+labelText+'.</span>' );
					jQuery(this).addClass( 'inputError' );
					hasError = true;
				} else if(jQuery(this).hasClass( 'email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
						var labelText = jQuery(this).prev( 'label').text();
						jQuery(this).parent().append( '<span class="error"><?php _e( 'You entered an invalid', 'woothemes' ); ?> '+labelText+'.</span>' );
						jQuery(this).addClass( 'inputError' );
						hasError = true;
					}
				}
			}
		});
		if(!hasError) {
			var formInput = jQuery(this).serialize();
			jQuery.post(jQuery(this).attr( 'action'),formInput, function(data){
				jQuery( 'form#contactForm').slideUp( "fast", function() {
					jQuery(this).before( '<p class="tick"><?php _e( '<strong>Thanks!</strong> Your email was successfully sent.', 'woothemes' ); ?></p>' );
				});
			});
		}

		return false;

	});
});
//-->!]]>
</script>

    <div id="content">

    	<div class="wrapper">

	    	<?php woo_main_before(); ?>

			<section id="main">

	            <article id="contact-page" class="page">

	            <?php if( isset( $emailSent ) && true == $emailSent ) { ?>

	                <p class="info"><?php _e( 'Your email was successfully sent.', 'woothemes' ); ?></p>

	            <?php } else { ?>

	                <?php if ( have_posts() ) { ?>

	                <?php while ( have_posts() ) { the_post(); ?>

	                		<header>
	                			<h1><?php the_title(); ?></h1>
	                		</header>

	                        <section class="entry">
		                        <?php the_content(); ?>

							   <?php if ( isset($woo_options['woo_contactform_map_coords']) && $woo_options['woo_contactform_map_coords'] != '' ) { $geocoords = $woo_options['woo_contactform_map_coords']; }  else { $geocoords = ''; } ?>

							   <?php if( ( isset( $woo_options['woo_contact_panel'] ) && $woo_options['woo_contact_panel'] == 'true' ) || ($geocoords != '') ) { ?>

							    	<section id="location-map">

							    		<h2><?php _e( 'Location', 'woothemes' ); ?></h2>

							    		<!-- LOCATION -->
										<?php if ( isset( $woo_options['woo_contact_panel'] ) && $woo_options['woo_contact_panel'] == 'true' ) { ?>
	                						<section id="location">
										    	<ul>
										    	    <?php if (isset($woo_options['woo_contact_title'])) { ?><li><strong><?php echo esc_html( $woo_options['woo_contact_title'] ); ?></strong></li><?php } ?>
										    	    <?php if (isset($woo_options['woo_contact_title']) && $woo_options['woo_contact_title'] != '' ) { ?><li><?php echo nl2br( esc_html( $woo_options['woo_contact_address'] ) ); ?></li><?php } ?>
										    	    <?php if (isset($woo_options['woo_contact_number']) && $woo_options['woo_contact_number'] != '' ) { ?><li><?php _e('Tel:','woothemes'); ?> <?php echo esc_html( $woo_options['woo_contact_number'] ); ?></li><?php } ?>
										    	    <?php if (isset($woo_options['woo_contact_fax']) && $woo_options['woo_contact_fax'] != '' ) { ?><li><?php _e('Fax:','woothemes'); ?> <?php echo esc_html( $woo_options['woo_contact_fax'] ); ?></li><?php } ?>
										    	    <?php if (isset($woo_options['woo_contactform_email']) && $woo_options['woo_contactform_email'] != '' ) { ?><li><?php _e('Email:','woothemes'); ?> <a href="mailto:<?php echo esc_attr( $woo_options['woo_contactform_email'] ); ?>"><?php echo esc_html( $woo_options['woo_contactform_email'] ); ?></a></li><?php } ?>
										    	</ul>
											</section><!-- /.location -->
										<?php } ?>

										<!-- MAP -->

	                					<?php if ($geocoords != '') { ?>
	                						<section id="map" <?php if ( isset( $woo_options['woo_contact_panel'] ) && $woo_options['woo_contact_panel'] == 'true' ) { ?>class="float"<?php } ?>>
	                					    	<?php woo_maps_contact_output("geocoords=$geocoords"); ?>
	                						</section>
	                					<?php } ?>

							    	</section><!-- /#location-map -->

							    <?php } ?>
							    <?php if ( isset( $woo_options['woo_contact_subscribe_and_connect'] ) && 'true' == $woo_options['woo_contact_subscribe_and_connect'] ) { ?>
							    	<section id="twitter-connect">
										<!-- SOCIAL MEDIA -->
						    		    <section id="contact-social">

						    		    	<h2><?php _e( 'Social Media', 'woothemes' ); ?></h2>

						    		    	<?php woo_display_social_icons(); ?>

						    		    </section>
							    	</section><!-- /#twitter-connect -->
							    <?php } ?>

	                			<!-- FORM -->

		                        <?php if( isset( $hasError ) || isset( $captchaError ) ) { ?>
	                   		 	    <p class="alert"><?php _e( 'There was an error submitting the form.', 'woothemes' ); ?></p>
	                   		 	<?php } ?>
	                   		 	<?php if ( get_option( 'woo_contactform_email' ) == '' ) { ?>
	                   		 	    <?php echo do_shortcode( '[box type="alert"]' . __( 'E-mail has not been setup properly. Please add your contact e-mail!', 'woothemes' ) . '[/box]' );  ?>
	                   		 	<?php } ?>


	                   		 	<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" id="contactForm" method="post">

	                   		 		<h2><?php _e( 'Contact Form', 'woothemes' ); ?></h2>

	                   		 	    <ol class="forms">
	                   		 	        <li><label for="contactName"><?php _e( 'Name', 'woothemes' ); ?></label>
	                   		 	            <input type="text" name="contactName" id="contactName" value="<?php if( isset( $_POST['contactName'] ) ) { echo esc_attr( $_POST['contactName'] ); } ?>" class="txt requiredField" />
	                   		 	            <?php if($nameError != '') { ?>
	                   		 	                <span class="error"><?php echo $nameError;?></span>
	                   		 	            <?php } ?>
	                   		 	        </li>

	                   		 	        <li><label for="email"><?php _e( 'Email', 'woothemes' ); ?></label>
	                   		 	            <input type="text" name="email" id="email" value="<?php if( isset( $_POST['email'] ) ) { echo esc_attr( $_POST['email'] ); } ?>" class="txt requiredField email" />
	                   		 	            <?php if($emailError != '') { ?>
	                   		 	                <span class="error"><?php echo $emailError;?></span>
	                   		 	            <?php } ?>
	                   		 	        </li>

	                   		 	        <li class="textarea"><label for="commentsText"><?php _e( 'Message', 'woothemes' ); ?></label>
	                   		 	            <textarea name="comments" id="commentsText" rows="5" cols="30" class="requiredField"><?php if( isset( $_POST['comments'] ) ) { echo esc_textarea( $_POST['comments'] ); } ?></textarea>
	                   		 	            <?php if( $commentError != '' ) { ?>
	                   		 	                <span class="error"><?php echo $commentError; ?></span>
	                   		 	            <?php } ?>
	                   		 	        </li>

	                   		 	        <li><label for="mathCheck"><?php _e( 'Solve:', 'woothemes' ); ?> 3 + 6 =</label>
			                                <input type="text" name="mathCheck" id="mathCheck" value="<?php if( isset( $_POST['mathCheck'] ) ) { echo esc_attr( $_POST['mathCheck'] ); } ?>" class="txt requiredField math" />
			                                <?php if($mathCheck != '') { ?>
			                                    <span class="error"><?php echo $mathCheck;?></span>
			                                <?php } ?>
			                            </li>

	                   		 	        <li class="inline"><input type="checkbox" name="sendCopy" id="sendCopy" value="true"<?php if( isset( $_POST['sendCopy'] ) && $_POST['sendCopy'] == true ) { echo ' checked="checked"'; } ?> /><label for="sendCopy"><?php _e( 'Send a copy of this email to yourself', 'woothemes' ); ?></label></li>
	                   		 	        <li class="screenReader"><label for="checking" class="screenReader"><?php _e( 'If you want to submit this form, do not enter anything in this field', 'woothemes' ); ?></label><input type="text" name="checking" id="checking" class="screenReader" value="<?php if( isset( $_POST['checking'] ) ) { echo esc_attr( $_POST['checking'] ); } ?>" /></li>
	                   		 	        <li class="buttons"><input type="hidden" name="submitted" id="submitted" value="true" /><input class="submit button" type="submit" value="<?php esc_attr_e( 'Send Message', 'woothemes' ); ?>" /></li>
	                   		 	    </ol>
	                   		 	</form>

	                        </section>

	                    <?php
	                    		} // End WHILE Loop
	                    	}
	                    }
	                    ?>

	            </article><!-- /#contact-page -->
			</section><!-- /#main -->

			<?php woo_main_after(); ?>

            <?php get_sidebar(); ?>

        </div><!-- /.wrapper -->

    </div><!-- /#content -->
<?php get_footer(); ?>