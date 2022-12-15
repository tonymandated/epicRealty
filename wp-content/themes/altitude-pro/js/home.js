jQuery(function( $ ){

	// Local Scroll Speed
	$.localScroll({
		duration: 750
	});

	// Image Section Height
	var windowHeight = $( window ).height();
	windowHeight = windowHeight - 75;

	$( '.image-section' ) .css({'height': windowHeight +'px'});
		
	$( window ).resize(function(){
	
		var windowHeight = $( window ).height();
		windowHeight = windowHeight - 75;
	
		$( '.image-section' ) .css({'height': windowHeight +'px'});
	
	});

});