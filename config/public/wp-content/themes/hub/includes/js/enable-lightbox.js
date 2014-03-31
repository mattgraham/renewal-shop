jQuery( document ).ready( function ( e ) {
	if ( jQuery( 'body' ).hasClass( 'has-lightbox' ) && ! jQuery( 'body' ).hasClass( 'portfolio-component' ) ) {
		jQuery( 'a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".png"]' ).each( function ( i ) {
			if ( jQuery( this ).parent( '.gallery-icon' ).length ) {
				var galleryID = jQuery( this ).parents( '.gallery' ).attr( 'id' );
				jQuery( this ).attr( 'rel', 'lightbox[' + galleryID + ']' );
			} else {
				jQuery( this ).attr( 'rel', 'lightbox[gallery]' );
			}
			// Use the image caption as the lightbox title.
			var imageTitle = '';
			if ( jQuery( this ).next().hasClass( 'wp-caption-text' ) ) {
				imageTitle = jQuery( this ).next().text();
			}

			if ( '' !== imageTitle ) {
				jQuery( this ).attr( 'title', imageTitle );
			}
		});

		jQuery( 'a[rel^="lightbox"]' ).prettyPhoto({
			social_tools: false,
			theme: 'pp_woothemes',
			horizontal_padding: 20,
			opacity: 0.8,
			deeplinking: false
		});
	}
});