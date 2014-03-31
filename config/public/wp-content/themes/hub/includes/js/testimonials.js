jQuery( window ).load( function() {
	jQuery('.slide-nav .testimonials-list > div:first a').addClass('active');
	jQuery('.slide-nav .testimonials-list > div a').click(function(e) {
		e.preventDefault();
		var slide = jQuery( this ).parents( 'div' ).index();
		jQuery('#testimonials .slides').flexslider( slide );
		jQuery( '.slide-nav .testimonials-list > div a' ).removeClass('active');
		jQuery( this ).addClass('active');
	});
	jQuery( "#testimonials .slides" ).flexslider({
		selector: ".testimonials-list > div",
		animation: "fade",
		manualControls: ".slide-nav .testimonials-list",
		slideshow: false,
		controlNav: false,
		directionNav: false,
		smoothHeight: true
	});
});