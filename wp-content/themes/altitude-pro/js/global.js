jQuery(function( $ ){

	if( $( document ).scrollTop() > 0 ){
		$( '.site-header' ).addClass( 'dark' );
	}

	if ( $( document ).scrollTop() > 240 ){
		$( '.theTabs' ).addClass( 'stick' );
		$( '#checkavailbox' ).addClass( 'fixed' );			
	}

	// Add opacity class to site header
	$( document ).on('scroll', function(){

		if ( $( document ).scrollTop() > 0 ){
			$( '.site-header' ).addClass( 'dark' );

		} else {
			$( '.site-header' ).removeClass( 'dark' );
		}

		if ( $( document ).scrollTop() > 240 ){
			$( '.theTabs' ).addClass( 'stick' );
			$( '#checkavailbox' ).addClass( 'fixed' );
		} else {
			$( '.theTabs' ).removeClass( 'stick' );	
			$( '#checkavailbox' ).removeClass( 'fixed' );			
		}

		$( '#sharebox' ).hide();

	});

	$(function() {
	  $('.page-id-0 a[href*="#"]:not([href="#"])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html, body').animate({
	          scrollTop: target.offset().top - 140
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});

	$( ".vrp-share-button" ).on('click', function(){
		$( '#sharebox' ).show();
	});



	$( '.nav-primary .genesis-nav-menu, .nav-secondary .genesis-nav-menu' ).addClass( 'responsive-menu' ).before('<div class="responsive-menu-icon"></div>');

	$( '.responsive-menu-icon' ).click(function(){
		$(this).next( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu' ).slideToggle();
	});

	$( window ).resize(function(){
		if ( window.innerWidth > 800 ) {
			$( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu, nav .sub-menu' ).removeAttr( 'style' );
			$( '.responsive-menu > .menu-item' ).removeClass( 'menu-open' );
		}
	});

	$( '.responsive-menu > .menu-item' ).click(function(event){
		if ( event.target !== this )
		return;
			$(this).find( '.sub-menu:first' ).slideToggle(function() {
			$(this).parent().toggleClass( 'menu-open' );
		});
	});

});