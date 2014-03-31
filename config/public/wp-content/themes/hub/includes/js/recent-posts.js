jQuery( window ).load( function() {

	jQuery( "#featured-slider" ).flexslider({
		animation: "fade",
		slideshow: false,
		controlNav: false,
		directionNav: true,
		smoothHeight: true
	});

});

jQuery(document).ready(function($){

	// Show first 3 pagination items
	jQuery('#featured-slider-pagination ul#carousel-items li').slice(0,3).show();

	// FEATURED SLIDER PAGINATION
	jQuery('ul#carousel-items li a').click(function(e) {
		e.preventDefault();
		var slide = jQuery( this ).parents( 'li' ).index();
		jQuery('#featured-slider').flexslider( slide );
		jQuery( 'ul#carousel-items li a' ).removeClass('active');
		jQuery( this ).addClass('active');
	});

	jQuery("#featured-slider-pagination button").click(function(e) {

		// Prevent default behaviour
		e.preventDefault();

		// Assign relavant selectors to vars
		var items = jQuery("ul#carousel-items");
		var prev = jQuery("#featured-slider-pagination #prev");
		var next = jQuery("#featured-slider-pagination #next");
		var visible = items.find('li:visible');
		var first = visible.first().index();
		var last = visible.last().index() + 1;

		// Go forward
		if ( jQuery( this ).attr("id") == "prev" ) {
			if ( first <= items.children().size() && first > 0 ) {
				visible.hide(); // Hide visible items
				items.children().slice( first - 3, first ).show();
			}
		}

		// Go backwards
		if ( jQuery( this ).attr("id") == "next" ) {
			if ( last < items.children().size() ) {
				visible.hide(); // Hide visible items
				items.children().slice(last, last + 3).show(); // Display next 3	
			}
		}
		
		items.children().removeClass("last");
		items.find("li:visible").last().addClass("last");		

		// Remove disabled class from both selectors
		prev.removeClass("disabled");
		next.removeClass("disabled");	

		// No more items, add disabled class to both
		if ( items.children().size() ==  items.find("li:visible").size() ) {
			prev.addClass("disabled");
			next.addClass("disabled");	
		}

		// Add disabled class if showing the first item on the list
		if ( items.find("li:visible").first().index() == 0 ) {
			prev.addClass("disabled");
		}

		// Add disabled class if showing the last item on the list
		if ( items.find("li:visible").last().index()+1 == items.children().size() ) {
			next.addClass("disabled");
		}

	});

});