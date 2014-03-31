/*-----------------------------------------------------------------------------------*/
/* GENERAL SCRIPTS */
/*-----------------------------------------------------------------------------------*/

jQuery(function(){
			jQuery.stellar({
				horizontalScrolling: false,
				verticalOffset: 40
			});
		});

function centerDropdown() {

        if ( jQuery(window).width() < 767 ) {
                jQuery('#main-nav > li > ul').each(function(){
                    jQuery(this).css('margin-left', 0);
            });
            return;
        }

        jQuery('#main-nav > li > ul').each(function(){
                var li_width = jQuery(this).parent('li').width();
                li_width = ((li_width - 170) / 2) - 10;
                jQuery(this).css('margin-left', li_width);
        });

}

jQuery(document).ready(function($){

	// Table alt row styling
	jQuery( '.entry table tr:odd' ).addClass( 'alt-table-row' );

	// FitVids - Responsive Videos
	jQuery( '.post, .widget, .panel, .page, #featured-slider .slide-media, .comment-entry' ).fitVids();

	// Add class to parent menu items with JS until WP does this natively
	jQuery( 'ul.sub-menu, ul.children' ).parents( 'li' ).addClass( 'parent' );


	/**
	 * Navigation
	 */
	// Add the 'show-nav' class to the body when the nav toggle is clicked
	jQuery( '.nav-toggle' ).click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Add the 'show-nav' class
		jQuery( 'body' ).toggleClass( 'show-nav' );

		// Check if .top-navigation already exists
		if ( jQuery( '#navigation' ).find( '.top-navigation' ).size() ) return;

		// If it doesn't, clone it (so it will still appear when resizing the browser window in desktop orientation) and add it.
		jQuery( '#top .top-navigation' ).clone().appendTo( '#navigation .menus' );
	});

	// Remove the 'show-nav' class from the body when the nav-close anchor is clicked
	jQuery('.nav-close').click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Remove the 'show-nav' class
		jQuery( 'body' ).removeClass( 'show-nav' );
	});

	// Remove 'show-nav' class from the body when user tabs outside of #navigation on handheld devices
	var hasParent = function(el, id) {
        if (el) {
            do {
                if (el.id === id) {
                    return true;
                }
                if (el.nodeType === 9) {
                    break;
                }
            }
            while((el = el.parentNode));
        }
        return false;
    };
	if (jQuery(window).width() < 767) {
		if (jQuery('body')[0].addEventListener){
			document.addEventListener('touchstart', function(e) {
	        if ( jQuery( 'body' ).hasClass( 'show-nav' ) && !hasParent( e.target, 'navigation' ) ) {
		        // Prevent default behaviour
		        e.preventDefault();

		        // Remove the 'show-nav' class
		        jQuery( 'body' ).removeClass( 'show-nav' );
	        }
	    }, false);
		} else if (jQuery('body')[0].attachEvent){
			document.attachEvent('ontouchstart', function(e) {
	        if ( jQuery( 'body' ).hasClass( 'show-nav' ) && !hasParent( e.target, 'navigation' ) ) {
		        // Prevent default behaviour
		        e.preventDefault();

		        // Remove the 'show-nav' class
		        jQuery( 'body' ).removeClass( 'show-nav' );
	        }
	    });
		}
	}

	// Fix dropdowns in Android
	jQuery( '.nav li:has(ul)' ).doubleTapToGo();

	// Center nav menus
	centerDropdown();

	// Products
	jQuery( 'ul.products li.product' ).hover( function() {
	        jQuery( this ).find( '.product-inner' ).removeClass( 'fadeOut' ).addClass( 'animated fadeIn' );
	        jQuery( this ).children( '.button' ).removeClass( 'fadeOut' ).addClass( 'animated fadeIn' );
	}, function() {
	        jQuery( this ).find( '.product-inner' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
	        jQuery( this ).children( '.button' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
	});

	// Home Avatars
	jQuery( '#popular-posts' ).waypoint(function() {
		jQuery( this ).find( '.post' ).addClass('animated fadeInUp');
	}, { offset: '55%' });	

	// Intro Message
	jQuery( '#intro-message' ).find( 'h2' ).addClass( 'animated slideInLeft' );
	jQuery( '#intro-message' ).find( 'p' ).addClass( 'animated slideInRight' );
	jQuery( '#intro-message' ).find( '.button' ).addClass( 'animated fadeInUp' );


	jQuery( this ).find( '.home #content .avatar' ).addClass( 'animated tada' );

	// Init Parallax
	jQuery('#content').stellar({
		horizontalScrolling: false,
		verticalOffset: 40
	});

	// Center avatar tooltip
	jQuery('#popular-posts ul li').each(function(){
		var tooltip_width = jQuery( this ).find( '.author-avatar span' ).width();
		jQuery(this).find( '.author-avatar span' ).css('margin-right', -( tooltip_width/2 - 35 ) );
	});

});

jQuery(window).resize(function() {
	centerDropdown();
});